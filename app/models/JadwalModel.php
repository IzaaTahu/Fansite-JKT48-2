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

    /**
     * Ambil jadwal dari jkt48.com untuk bulan tertentu.
     * Return: ['items' => [...], 'error' => null|string]
     */
    public function scrapeFromJKT48(int $year = 0, int $month = 0): array
    {
        if ($year  === 0) $year  = (int) date('Y');
        if ($month === 0) $month = (int) date('n');

        $url  = "https://jkt48.com/calendar/list/y/{$year}/m/{$month}/d/1?lang=id";
        $html = $this->fetchHtml($url);

        if ($html === false) {
            return ['items' => [], 'error' => 'Gagal terhubung ke jkt48.com. Coba lagi nanti.'];
        }

        $items = $this->parseJKT48Html($html, $year, $month);
        return ['items' => $items, 'error' => null];
    }

    /**
     * Sync: ambil dari jkt48.com lalu insert ke DB (skip duplikat).
     * Return: ['inserted' => int, 'skipped' => int, 'error' => null|string]
     */
    public function syncFromJKT48(int $year = 0, int $month = 0): array
    {
        $scraped = $this->scrapeFromJKT48($year, $month);

        if ($scraped['error']) {
            return ['inserted' => 0, 'skipped' => 0, 'error' => $scraped['error']];
        }

        $inserted = 0;
        $skipped  = 0;

        foreach ($scraped['items'] as $item) {
            // Cek duplikat: tanggal + nama acara yang sama
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
    // PRIVATE: HTTP fetch (cURL utama, file_get_contents fallback)
    // ---------------------------------------------------------------

    private function fetchHtml(string $url): string|false
    {
        // Coba cURL dulu (lebih stabil di shared hosting)
        if (function_exists('curl_init')) {
            $ch = curl_init($url);
            curl_setopt_array($ch, [
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_TIMEOUT        => 20,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_MAXREDIRS      => 3,
                CURLOPT_USERAGENT      => 'Mozilla/5.0 (compatible; FansiteBot/1.0)',
                CURLOPT_HTTPHEADER     => [
                    'Accept-Language: id-ID,id;q=0.9',
                    'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8',
                ],
                CURLOPT_SSL_VERIFYPEER => true,
                CURLOPT_SSL_VERIFYHOST => 2,
            ]);
            $result = curl_exec($ch);
            $errno  = curl_errno($ch);
            curl_close($ch);

            if (!$errno && $result !== false) return $result;
        }

        // Fallback: file_get_contents
        if (ini_get('allow_url_fopen')) {
            $ctx = stream_context_create([
                'http' => [
                    'timeout'    => 15,
                    'user_agent' => 'Mozilla/5.0 (compatible; FansiteBot/1.0)',
                    'header'     => "Accept-Language: id-ID,id;q=0.9\r\n",
                ],
            ]);
            $result = @file_get_contents($url, false, $ctx);
            if ($result !== false) return $result;
        }

        return false;
    }

    // ---------------------------------------------------------------
    // PRIVATE: Parser HTML jkt48.com
    // ---------------------------------------------------------------

    private function parseJKT48Html(string $html, int $year, int $month): array
    {
        $items = [];

        $dom = new DOMDocument();
        libxml_use_internal_errors(true);
        $dom->loadHTML('<?xml encoding="UTF-8">' . $html);
        libxml_clear_errors();

        $xpath = new DOMXPath($dom);

        /*
         * Struktur jkt48.com/calendar:
         * Tiap hari ada container dengan tanggal,
         * di dalamnya list item berisi waktu + nama acara.
         * Kita cari pola ini secara fleksibel.
         */

        // Cari semua node yang mengandung info jadwal harian
        $dayNodes = $xpath->query(
            '//*[contains(@class,"sch-") or contains(@class,"schedule-") or contains(@class,"cal-")]'
        );

        // Jika DOM parser tidak nemu, pakai regex fallback
        if ($dayNodes->length === 0) {
            return $this->regexParse($html, $year, $month);
        }

        $currentDay = null;

        foreach ($dayNodes as $node) {
            $text = trim($node->textContent);
            if (empty($text)) continue;

            // Deteksi node tanggal
            $cls = $node->getAttribute('class');
            if (str_contains($cls, 'date') || str_contains($cls, 'day')) {
                $d = (int) preg_replace('/\D/', '', $text);
                if ($d >= 1 && $d <= 31) { $currentDay = $d; continue; }
            }

            // Deteksi node jadwal (ada pola HH:MM)
            if (preg_match('/(\d{1,2}:\d{2})/', $text, $m)) {
                $item = $this->buildItem($text, $m[1], $currentDay, $year, $month);
                if ($item) $items[] = $item;
            }
        }

        // Kalau masih kosong, coba regex
        if (empty($items)) {
            $items = $this->regexParse($html, $year, $month);
        }

        return $items;
    }

    /**
     * Fallback: cari pola jam + nama langsung dari teks halaman.
     */
    private function regexParse(string $html, int $year, int $month): array
    {
        $items = [];
        $text  = strip_tags(html_entity_decode($html, ENT_QUOTES | ENT_HTML5, 'UTF-8'));
        $lines = preg_split('/[\r\n]+/', $text);

        $currentDay = null;

        foreach ($lines as $line) {
            $line = trim($line);
            if (empty($line)) continue;

            // Baris hari (hanya angka 1-31)
            if (preg_match('/^\d{1,2}$/', $line)) {
                $d = (int) $line;
                if ($d >= 1 && $d <= 31) $currentDay = $d;
                continue;
            }

            // Baris jadwal: dimulai jam
            if (preg_match('/^(\d{1,2}:\d{2})\s+(.+)$/', $line, $m)) {
                $item = $this->buildItem($m[2], $m[1], $currentDay, $year, $month);
                if ($item) $items[] = $item;
            }
        }

        return $items;
    }

    /**
     * Buat array item jadwal siap INSERT dari teks mentah.
     */
    private function buildItem(string $raw, string $time, ?int $day, int $year, int $month): ?array
    {
        $title = preg_replace('/^\d{1,2}:\d{2}\s*/', '', $raw);
        $title = preg_replace('/\s+/', ' ', trim($title));
        $title = mb_substr($title, 0, 150);

        if (strlen($title) < 3) return null;

        $day = $day ?? 1;
        $dateStr = sprintf('%04d-%02d-%02d %s:00', $year, $month, $day, $time);

        // Deteksi tipe berdasarkan kata kunci di nama acara
        $lower = mb_strtolower($title);
        $tipe  = $this->detectTipe($lower);

        return [
            'tanggal_jadwal' => $dateStr,
            'waktu_jadwal'   => null,      // jkt48.com hanya ada 1 waktu
            'nama_acara'     => $title,
            'tipe'           => $tipe,
            'lokasi'         => $this->detectLokasi($tipe),
            'deskripsi'      => 'Diimpor otomatis dari jkt48.com',
            'foto'           => null,
        ];
    }

    /**
     * Tebak tipe acara dari nama.
     */
    private function detectTipe(string $lower): string
    {
        if (str_contains($lower, 'theater') || str_contains($lower, 'theatre')
            || str_contains($lower, 'setlist') || str_contains($lower, 'show')
            || str_contains($lower, 'host sweet') || str_contains($lower, 'ramune')
            || str_contains($lower, 'vocal queens') || str_contains($lower, 'battle')) {
            return 'Theater Show';
        }
        if (str_contains($lower, 'meet') || str_contains($lower, 'greet')
            || str_contains($lower, 'handshake') || str_contains($lower, '握手')) {
            return 'Meet & Greet';
        }
        if (str_contains($lower, 'off air') || str_contains($lower, 'konser')
            || str_contains($lower, 'festival') || str_contains($lower, 'fair')) {
            return 'Off Air';
        }
        if (str_contains($lower, 'on air') || str_contains($lower, 'rcti')
            || str_contains($lower, 'sctv') || str_contains($lower, 'trans')
            || str_contains($lower, 'antv') || str_contains($lower, 'indosiar')) {
            return 'On Air';
        }
        return 'Event';
    }

    /**
     * Tebak lokasi default berdasarkan tipe.
     */
    private function detectLokasi(string $tipe): string
    {
        return match ($tipe) {
            'Theater Show' => 'JKT48 Theater, fX Sudirman, Jakarta',
            'On Air'       => 'Studio TV',
            default        => 'Jakarta',
        };
    }

    /**
     * Cek apakah jadwal sudah ada di DB (cegah duplikat).
     * Bandingkan tanggal (tanpa jam) + nama acara (case-insensitive).
     */
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