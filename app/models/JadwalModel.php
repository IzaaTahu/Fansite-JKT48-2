<?php
// app/models/JadwalModel.php

class JadwalModel {
    private PDO    $db;
    private string $table = "jadwal";

    public function __construct(PDO $db) { $this->db = $db; }

    // ══════════════════════════════════════════════
    // QUERY LAMA (tidak diubah)
    // ══════════════════════════════════════════════

    public function getAll(): array {
        return $this->db->query(
            "SELECT * FROM {$this->table} ORDER BY tanggal_jadwal ASC"
        )->fetchAll();
    }

    public function getById(int $id): array|false {
        $stmt = $this->db->prepare(
            "SELECT * FROM {$this->table} WHERE id_jadwal = :id"
        );
        $stmt->execute([':id' => $id]);
        return $stmt->fetch();
    }

    public function getUpcoming(int $limit = 5): array {
        $stmt = $this->db->prepare(
            "SELECT * FROM {$this->table}
             WHERE tanggal_jadwal >= NOW()
             ORDER BY tanggal_jadwal ASC
             LIMIT :lim"
        );
        $stmt->bindValue(':lim', $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getAllGroupedByMonth(): array {
        $rows = $this->db->query(
            "SELECT * FROM {$this->table} ORDER BY tanggal_jadwal ASC"
        )->fetchAll();
        $grouped = [];
        foreach ($rows as $row) {
            $key = date('Y-m', strtotime($row['tanggal_jadwal']));
            $grouped[$key][] = $row;
        }
        return $grouped;
    }

    public function create(array $d): bool {
        $stmt = $this->db->prepare(
            "INSERT INTO {$this->table}
             (tanggal_jadwal, waktu_jadwal, nama_acara, tipe, lokasi, deskripsi, foto)
             VALUES (:tgl, :wkt, :nama, :tipe, :lok, :desk, :foto)"
        );
        return $stmt->execute([
            ':tgl'  => $d['tanggal_jadwal'],
            ':wkt'  => $d['waktu_jadwal'] ?: null,
            ':nama' => $d['nama_acara'],
            ':tipe' => $d['tipe'] ?? 'Theater Show',
            ':lok'  => $d['lokasi'],
            ':desk' => $d['deskripsi'] ?: null,
            ':foto' => $d['foto'] ?: null,
        ]);
    }

    public function update(int $id, array $d): bool {
        $stmt = $this->db->prepare(
            "UPDATE {$this->table}
             SET tanggal_jadwal=:tgl, waktu_jadwal=:wkt, nama_acara=:nama,
                 tipe=:tipe, lokasi=:lok, deskripsi=:desk, foto=:foto
             WHERE id_jadwal=:id"
        );
        return $stmt->execute([
            ':tgl'  => $d['tanggal_jadwal'],
            ':wkt'  => $d['waktu_jadwal'] ?: null,
            ':nama' => $d['nama_acara'],
            ':tipe' => $d['tipe'] ?? 'Theater Show',
            ':lok'  => $d['lokasi'],
            ':desk' => $d['deskripsi'] ?: null,
            ':foto' => $d['foto'] ?: null,
            ':id'   => $id,
        ]);
    }

    public function delete(int $id): bool {
        $stmt = $this->db->prepare(
            "DELETE FROM {$this->table} WHERE id_jadwal = :id"
        );
        return $stmt->execute([':id' => $id]);
    }

    public function count(): int {
        return (int)$this->db->query(
            "SELECT COUNT(*) FROM {$this->table}"
        )->fetchColumn();
    }

    // ══════════════════════════════════════════════
    // SCRAPER + SYNC DARI JKT48.COM
    // ══════════════════════════════════════════════

    public function scrapeFromJKT48(int $year = 0, int $month = 0): array
    {
        if ($year  === 0) $year  = (int) date('Y');
        if ($month === 0) $month = (int) date('n');

        $url = "https://jkt48.com/api/v1/schedules?lang=id&month={$month}&year={$year}";

        $ch = curl_init($url);
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT        => 15,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_ENCODING       => 'gzip, deflate',
            CURLOPT_HTTPHEADER     => [
                'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36',
                'Accept: application/json',
                'Referer: https://jkt48.com/',
            ],
        ]);

        $result = curl_exec($ch);
        $code   = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error  = curl_error($ch);
        curl_close($ch);

        if ($error || $code !== 200) {
            return ['items' => [], 'error' => 'Gagal terhubung ke API jkt48.com'];
        }

        $json = json_decode($result, true);
        if (empty($json['status']) || empty($json['data'])) {
            return ['items' => [], 'error' => null];
        }

        $items = [];
        foreach ($json['data'] as $d) {
            // Ambil detail per jadwal untuk dapat data member
            $detail  = $this->fetchDetail($d['link']);
            $members = $detail['jkt48_member'] ?? [];

            // Konversi tanggal UTC → WIB
            $dt = new DateTime($d['date'], new DateTimeZone('UTC'));
            $dt->setTimezone(new DateTimeZone('Asia/Jakarta'));
            $tglStr = $dt->format('Y-m-d') . ' ' . $d['start_time'];

            $tipe    = $this->detectTipeFromAPI($d['type'], $d['title']);
            $foto    = $this->getSetlistFoto($d['title'], $d['type']);
            $desk    = $this->generateDeskripsi($d['title'], $d['type'], $members);

            $items[] = [
                'tanggal_jadwal' => $tglStr,
                'waktu_jadwal'   => $d['end_time'] ?? null,
                'nama_acara'     => $d['title'],
                'tipe'           => $tipe,
                'lokasi'         => $tipe === 'Theater Show'
                                    ? 'JKT48 Theater, fX Sudirman, Jakarta'
                                    : 'Jakarta',
                'deskripsi'      => $desk,
                'foto'           => $foto,
            ];
        }

        return ['items' => $items, 'error' => null];
    }

    public function syncFromJKT48(int $year = 0, int $month = 0): array
    {
        $scraped = $this->scrapeFromJKT48($year, $month);

        if ($scraped['error']) {
            return ['inserted' => 0, 'skipped' => 0, 'error' => $scraped['error']];
        }

        $inserted = 0;
        $skipped  = 0;

        foreach ($scraped['items'] as $item) {
            if ($this->isDuplicate($item['tanggal_jadwal'], $item['nama_acara'])) {
                $skipped++;
                continue;
            }
            if ($this->create($item)) {
                $inserted++;
            }
        }

        return ['inserted' => $inserted, 'skipped' => $skipped, 'error' => null];
    }

    // ---------------------------------------------------------------
    // PRIVATE: Fetch detail per jadwal (untuk ambil member)
    // ---------------------------------------------------------------

    private function fetchDetail(string $link): array
    {
        $url = "https://jkt48.com/api/v1/schedules/{$link}?lang=id";

        $ch = curl_init($url);
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT        => 10,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_ENCODING       => 'gzip, deflate',
            CURLOPT_HTTPHEADER     => [
                'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36',
                'Accept: application/json',
                'Referer: https://jkt48.com/',
            ],
        ]);

        $result = curl_exec($ch);
        $code   = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($code !== 200) return [];

        $json = json_decode($result, true);
        return $json['data'] ?? [];
    }

    // ---------------------------------------------------------------
    // PRIVATE: Mapping foto setlist
    // ---------------------------------------------------------------

    private function getSetlistFoto(string $title, string $type): string
    {
        // Hanya Theater Show yang punya foto mapping
        if ($type !== 'SHOW') return '';

        $map = [
            'Pertaruhan Cinta'               => 'public/images/jadwal/percin.jpg',
            'Sambil Menggandeng Erat Tanganku' => 'public/images/jadwal/twt.jpg',
            'PASSION 200%'                   => 'public/images/jadwal/passion.jpg',
            'Cara Meminum Ramune'            => 'public/images/jadwal/rnn.jpg',
            'DREAM BAKUDAN'                  => 'public/images/jadwal/dream.jpg',
            'ITADAKI♥LOVE'                   => 'public/images/jadwal/love.jpg',
            'Pajama Drive'                   => 'public/images/jadwal/pajama.jpg',
            'SWARA SEMESTA'                  => 'public/images/jadwal/swara_semesta.jpg',
        ];

        return $map[$title] ?? '';
    }

    // ---------------------------------------------------------------
    // PRIVATE: Generate deskripsi otomatis
    // ---------------------------------------------------------------

    private function generateDeskripsi(string $title, string $type, array $members): string
    {
        // Non-SHOW: kosongkan, admin edit sendiri
        if ($type !== 'SHOW') return '';

        // Format nama member
        $namaMembers = '';
        if (!empty($members)) {
            $names = array_map(fn($m) => $this->shortName($m['name']), $members);
            $namaMembers = implode(', ', $names);
        }

        $catatan = "Catatan Khusus:\n"
            . "- Daftar member yang tampil dapat berubah sewaktu-waktu tanpa pemberitahuan terlebih dahulu.\n"
            . "- Tiket hanya tersedia melalui pembelian resmi di website JKT48.\n"
            . "- Mohon mematuhi seluruh protokol dan tata tertib yang berlaku di dalam JKT48 Theater.";

        $memberLine = $namaMembers
            ? "Member yang Tampil: {$namaMembers}."
            : "Member yang Tampil: Daftar member akan diumumkan lebih lanjut.";

        // Template per setlist
        $templates = [
            'Pertaruhan Cinta' =>
                "Saksikan puncak sejarah baru JKT48 dalam Original Setlist: Pertaruhan Cinta! "
                . "Setelah penantian panjang sejak tahun 2021, mahakarya yang menjadi kebanggaan kita semua ini akhirnya hadir di atas panggung Theater. "
                . "Menampilkan deretan lagu pure karya orisinal JKT48 hasil kolaborasi dengan musisi ternama Indonesia. ✨ "
                . "Inilah bukti nyata identitas dan kreativitas tanpa batas JKT48. "
                . "Jangan lewatkan kesempatan untuk menjadi bagian dari perayaan pride terbesar ini! ❤️\n\n"
                . "{memberLine}\n\n{catatan}\n\n"
                . "Ayo kita dukung karya asli anak bangsa dan buat malam ini penuh dengan kebanggaan bersama JKT48!",

            'Sambil Menggandeng Erat Tanganku' =>
                "Nikmati kehangatan dan persahabatan dalam setlist \"Sambil Menggandeng Erat Tanganku\"! "
                . "Pertunjukan ini menghadirkan harmoni yang indah antara energi panggung yang ceria dan momen-momen emosional yang menyentuh hati. "
                . "Mari kembali ke JKT48 Theater untuk menyaksikan penampilan memukau dari para member inti yang siap memberikan pengalaman teater tak terlupakan. ✨\n\n"
                . "{memberLine}\n\n{catatan}\n\n"
                . "Sampai jumpa di Theater dan mari buat malam ini penuh cinta! ❤️",

            'PASSION 200%' =>
                "Bakar semangatmu lebih membara dari sebelumnya! "
                . "Menjadi bagian dari era JKT48 Fight, Team Passion siap menggebrak panggung dengan setlist \"PASSION 200%\". "
                . "Pertunjukan ini menyuguhkan energi murni yang meluap, koreografi yang bertenaga, dan tekad tanpa batas yang akan membakar seluruh isi Theater. "
                . "Rasakan intensitas maksimal dari para member yang siap memberikan segalanya melebihi batas 100%! ⚡️\n\n"
                . "{memberLine}\n\n{catatan}\n\n"
                . "Jangan biarkan api semangatmu padam! Mari bergabung dalam kemeriahan Team Passion! ❤️",

            'Cara Meminum Ramune' =>
                "Kembalilah menikmati kesegaran dan makna mendalam di JKT48 Theater melalui setlist \"Cara Meminum Ramune\"! "
                . "Pertunjukan ini bukan sekadar tentang keceriaan, tapi juga membawa pesan berharga tentang indahnya menikmati hidup selangkah demi selangkah, "
                . "sama seperti seni meminum ramune yang tidak boleh terburu-buru. "
                . "Yuk, luangkan waktu sejenak dari hiruk-pikuk dan bersenang-senang bersama kami! 🍶\n\n"
                . "{memberLine}\n\n{catatan}\n\n"
                . "Jangan sampai kelewatan momen \"segar\" ini, sampai jumpa di Theater! ❤️",

            'DREAM BAKUDAN' =>
                "Bersiaplah untuk ledakan semangat di panggung JKT48! "
                . "Team Dream hadir membawakan setlist \"Dream Bakudan\" (Bom Impian) yang penuh dengan energi dan ambisi. "
                . "Jangan lewatkan perpaduan performa yang powerful dan mimpi-mimpi besar yang akan diledakkan oleh para member di atas panggung Theater! ✨\n\n"
                . "{memberLine}\n\n{catatan}\n\n"
                . "Mari kita dukung perjalanan Team Dream dalam meraih mimpi-mimpi mereka yang setinggi langit! ❤️",

            'ITADAKI♥LOVE' =>
                "Sambut Energi Cinta dari Team Love! ✨ "
                . "Persiapkan dirimu untuk masuk ke dalam dunia yang penuh warna dan keceriaan dalam pertunjukan ITADAKI♥LOVE. "
                . "Show ini menjanjikan atmosfer yang hangat, interaktif, dan penuh kejutan manis di setiap lagunya. "
                . "Kami merayakan setiap detik kebersamaan, mulai dari tawa di atas panggung hingga momen-momen kecil yang membuat Team Love begitu spesial. 💕\n\n"
                . "{memberLine}\n\n{catatan}\n\n"
                . "Mari kita balas setiap energi positif mereka dengan dukungan yang penuh kasih. Sampai jumpa di Theater! ❤️",

            'Pajama Drive' =>
                "Saksikan awal mula perjalanan para bintang masa depan JKT48! "
                . "Pajama Drive adalah panggung penuh semangat yang dibawakan khusus oleh para Trainee JKT48. "
                . "Di sini, kamu bisa melihat dedikasi dan kerja keras mereka dalam menggapai impian menjadi member inti. "
                . "Jangan lewatkan energi murni dan keceriaan khas yang hanya bisa kamu rasakan di setlist legendaris ini! ✨\n\n"
                . "{memberLine}\n\n{catatan}\n\n"
                . "Mari kita berikan dukungan terbaik untuk langkah pertama mereka di atas panggung! ❤️",

            'SWARA SEMESTA' =>
                "Rasakan harmoni alam semesta dalam pertunjukan spesial SWARA SEMESTA! "
                . "Sebuah pengalaman teater yang memadukan keindahan musik dan penampilan memukau dari para member JKT48. "
                . "Bersiaplah untuk terbawa dalam alunan melodi yang menyentuh jiwa dan penampilan yang tak terlupakan. 🌌✨\n\n"
                . "{memberLine}\n\n{catatan}\n\n"
                . "Sampai jumpa dan biarkan semesta membawamu dalam harmoni bersama JKT48! ❤️",
        ];

        // Ambil template, fallback ke generic kalau tidak ada
        $template = $templates[$title]
            ?? "Jangan lewatkan penampilan spesial JKT48 dalam \"{$title}\"! "
             . "Saksikan para member memberikan yang terbaik di atas panggung JKT48 Theater. ✨\n\n"
             . "{memberLine}\n\n{catatan}\n\n"
             . "Sampai jumpa di Theater! ❤️";

        // Inject member dan catatan ke template
        return str_replace(
            ['{memberLine}', '{catatan}'],
            [$memberLine, $catatan],
            $template
        );
    }

    // ---------------------------------------------------------------
    // PRIVATE: Helpers
    // ---------------------------------------------------------------

    /**
     * Ambil nama depan saja untuk display member yang lebih ringkas.
     * Contoh: "Abigail Rachel" → "Abigail"
     */
    private function shortName(string $fullName): string
    {
        return explode(' ', trim($fullName))[0];
    }

    private function detectTipeFromAPI(string $type, string $title): string
    {
        if ($type === 'SHOW') return 'Theater Show';

        $lower = mb_strtolower($title);
        if (str_contains($lower, 'meet') || str_contains($lower, 'greet')
            || str_contains($lower, 'handshake') || str_contains($lower, 'video call')) {
            return 'Meet & Greet';
        }
        if (str_contains($lower, 'off air') || str_contains($lower, 'konser')
            || str_contains($lower, 'festival') || str_contains($lower, 'semesta')
            || str_contains($lower, 'spectaphoria') || str_contains($lower, 'anniversary')) {
            return 'Off Air';
        }
        if (str_contains($lower, 'on air') || str_contains($lower, 'rcti')
            || str_contains($lower, 'sctv') || str_contains($lower, 'tv')) {
            return 'On Air';
        }

        return 'Event';
    }

    private function isDuplicate(string $tanggal, string $namaAcara): bool
    {
        $stmt = $this->db->prepare(
            "SELECT COUNT(*) FROM {$this->table}
             WHERE DATE(tanggal_jadwal) = DATE(:tgl)
               AND LOWER(nama_acara)   = LOWER(:nama)"
        );
        $stmt->execute([':tgl' => $tanggal, ':nama' => $namaAcara]);
        return $stmt->fetchColumn() > 0;
    }
}