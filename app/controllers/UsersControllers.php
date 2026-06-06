<?php
// app/controllers/UsersControllers.php
// UPDATED: tambah mypage, oshimen update, home

include_once 'config/db_config.php';
include_once 'app/models/UsersModel.php';
include_once 'app/models/MemberModel.php';
include_once 'app/models/JadwalModel.php';
include_once 'app/models/PostModel.php';
include_once 'app/models/SaranModel.php';
include_once 'app/models/GaleriModel.php';

class UsersControllers {
    private $usersModel;
    private $memberModel;
    private $jadwalModel;
    private $postModel;
    private $saranModel;
    private $galeriModel;
    private PDO $db;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->usersModel = new UsersModel($this->db);
        $this->memberModel = new MemberModel($this->db);
        $this->jadwalModel = new JadwalModel($this->db);
        $this->postModel   = new PostModel($this->db);
        $this->saranModel  = new SaranModel($this->db);
        $this->galeriModel = new GaleriModel($this->db);
    }

    // ==========================================
    // HOME — PUBLIC (sama untuk login/guest)
    // ==========================================
    public function index() {
        $upcoming = $this->jadwalModel->getUpcoming(3);
        $posts    = $this->postModel->getAll();
        // Ambil data user + oshimen jika sudah login
        $userDetail = null;
        if (isset($_SESSION['user_id'])) {
            $userDetail = $this->usersModel->getById((int)$_SESSION['user_id']);
            // Update session oshimen jika ada perubahan
            $_SESSION['oshimen_nama'] = $userDetail['oshimen_nama'] ?? null;
            $_SESSION['oshimen_foto'] = $userDetail['oshimen_foto'] ?? null;
        }
        include 'app/view/user/home.php';
    }

    public function memberPage() {
        $members = $this->memberModel->getAll(); // sudah urut A-Z
        include 'app/view/user/member.php';
    }

    public function beritaPage() {
    $posts = $this->postModel->getAll();
    include 'app/view/user/berita.php';
    }

    public function jadwalPage() {
        $grouped = $this->jadwalModel->getAllGroupedByMonth();
        include 'app/view/user/jadwal.php';
    }

    public function saranPage() {
        $sarans = $this->saranModel->getAll();
        include 'app/view/user/saran.php';
    }

    public function kontakPage() {
        $flash = $_SESSION['flash'] ?? null;
        unset($_SESSION['flash']);
        include 'app/view/user/kontak.php';
    }

    public function user() {
        if (!isset($_SESSION['user_id'])) {
            header("Location: index.php?act=login");
            exit;
        }
        $this->index();
    }

    // ==========================================
    // MY PAGE
    // ==========================================
    public function mypage() {
        if (!isset($_SESSION['user_id'])) {
            header("Location: index.php?act=login");
            exit;
        }
        $userId     = (int)$_SESSION['user_id'];
        $userDetail = $this->usersModel->getById($userId);
        $members    = $this->memberModel->getAll();
        $flash      = $_SESSION['flash'] ?? null;
        unset($_SESSION['flash']);
        include 'app/view/user/mypage.php';
    }

    public function updateOshimen() {
        if (!isset($_SESSION['user_id'])) {
            header("Location: index.php?act=login");
            exit;
        }
        $userId   = (int)$_SESSION['user_id'];
        $memberId = !empty($_POST['id_member']) ? (int)$_POST['id_member'] : null;

        if ($this->usersModel->updateOshimen($userId, $memberId)) {
            // Refresh session oshimen
            $updated = $this->usersModel->getById($userId);
            $_SESSION['oshimen_nama'] = $updated['oshimen_nama'] ?? null;
            $_SESSION['oshimen_foto'] = $updated['oshimen_foto'] ?? null;
            $_SESSION['flash'] = ['type' => 'success', 'msg' => 'Oshimen berhasil diperbarui! 🌸'];
        } else {
            $_SESSION['flash'] = ['type' => 'error', 'msg' => 'Gagal memperbarui oshimen.'];
        }
        header("Location: index.php?act=mypage");
        exit;
    }

    public function updateProfile() {
        if (!isset($_SESSION['user_id'])) {
            header("Location: index.php?act=login");
            exit;
        }
        $userId = (int)$_SESSION['user_id'];
        $nama   = trim($_POST['nama'] ?? '');
        if (!$nama) {
            $_SESSION['flash'] = ['type' => 'error', 'msg' => 'Nama tidak boleh kosong.'];
            header("Location: index.php?act=mypage");
            exit;
        }
        if ($this->usersModel->updateProfile($userId, $nama)) {
            $_SESSION['nama'] = htmlspecialchars(strip_tags($nama));
            $_SESSION['flash'] = ['type' => 'success', 'msg' => 'Profil berhasil diperbarui!'];
        } else {
            $_SESSION['flash'] = ['type' => 'error', 'msg' => 'Gagal memperbarui profil.'];
        }
        header("Location: index.php?act=mypage");
        exit;
    }

    // ==========================================
    // AUTH
    // ==========================================
    public function viewRegister() {
        include 'app/view/auth/register.php';
    }

    public function register() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $nama     = $_POST['nama'];
            $email    = $_POST['email'];
            $password = $_POST['password_pengguna'];

            if (strlen($password) < 6) {
                $error = "Password minimal 6 karakter!";
                include 'app/view/auth/register.php';
                return;
            }
            if ($this->usersModel->register($nama, $email, $password)) {
                $_SESSION['success'] = "Registrasi berhasil, silakan login.";
                header("Location: index.php?act=login");
                exit;
            } else {
                $error = "Gagal mendaftar. Email mungkin sudah terdaftar.";
                include 'app/view/auth/register.php';
            }
        }
    }

    public function viewLogin() {
        if (isset($_SESSION['user_id'])) {
            header("Location: index.php?act=" . ($_SESSION['role'] === 'admin' ? 'admin' : 'home'));
            exit;
        }
        $success = $_SESSION['success'] ?? null;
        unset($_SESSION['success']);
        include 'app/view/auth/login.php';
    }

    public function login() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $email    = $_POST['email'];
            $password = $_POST['password_pengguna'];
            $user     = $this->usersModel->login($email, $password);

            if ($user) {
                $_SESSION['user_id']      = $user['id_user'];
                $_SESSION['nama']         = $user['nama'];
                $_SESSION['role']         = $user['role'];
                $_SESSION['email']        = $user['email'];
                $_SESSION['oshimen_nama'] = $user['oshimen_nama'] ?? null;
                $_SESSION['oshimen_foto'] = $user['oshimen_foto'] ?? null;
                header("Location: index.php?act=" . ($user['role'] === 'admin' ? 'admin' : 'home'));
                exit;
            } else {
                $error = "Email atau password salah!";
                include 'app/view/auth/login.php';
            }
        }
    }

    public function logout() {
        if (isset($_POST['confirm_logout'])) {
            session_unset();
            session_destroy();
            header("Location: index.php");
            exit;
        }
        include 'app/view/auth/logout.php';
    }

    // ==========================================
    // ADMIN DASHBOARD
    // ==========================================
    public function admin() {
        $this->requireAdmin();
        $totalMember = $this->memberModel->count();
        $totalJadwal = $this->jadwalModel->count();
        $totalPost   = $this->postModel->count();
        $totalSaran  = $this->saranModel->count();
        $totalGaleriEvent = $this->galeriModel->countEvent();
        $totalGaleriFoto  = $this->galeriModel->countFoto();
        $upcoming    = $this->jadwalModel->getUpcoming(5);
        include 'app/view/admin/index.php';
    }

    public function adminSaran() {
        $this->requireAdmin();
        $sarans     = $this->saranModel->getAll();
        $totalSaran = $this->saranModel->count();
        include 'app/view/admin/saran/index.php';
    }

    public function adminSaranDelete() {
        $this->requireAdmin();
        $id = (int)($_GET['id'] ?? 0);
        $_SESSION['flash'] = $this->saranModel->delete($id)
            ? ['type'=>'success','msg'=>'Saran berhasil dihapus.']
            : ['type'=>'error',  'msg'=>'Gagal menghapus saran.'];
        header("Location: index.php?act=admin-saran"); exit;
    }

    // ==========================================
    // ADMIN — MEMBER CRUD
    // ==========================================
    public function adminMember() {
        $this->requireAdmin();
        $members = $this->memberModel->getAll();
        include 'app/view/admin/member/index.php';
    }

    public function adminMemberCreate() {
        $this->requireAdmin();
        include 'app/view/admin/member/form.php';
    }

    public function adminMemberStore() {
        $this->requireAdmin();
 
        // Upload foto kabesha (card depan)
        $foto = '';
        if (!empty($_FILES['foto_kabesha']['name'])) {
            $foto = $this->uploadFoto($_FILES['foto_kabesha'], 'kabesha');
        }
 
        // Upload foto casual (popup)
        $foto_casual = '';
        if (!empty($_FILES['foto_casual']['name'])) {
            $foto_casual = $this->uploadFoto($_FILES['foto_casual'], 'casual');
        }
 
        $data = [
            'nama_member'   => trim($_POST['nama_member']),
            'tanggal_lahir' => $_POST['tanggal_lahir'],
            'foto'          => $foto,
            'foto_casual'   => $foto_casual,
            'gen'           => $_POST['gen'],
            'asal'          => trim($_POST['asal']),
            'deskripsi'     => trim($_POST['deskripsi']),
        ];
 
        $_SESSION['flash'] = $this->memberModel->create($data)
            ? ['type' => 'success', 'msg' => 'Member berhasil ditambahkan!']
            : ['type' => 'error',   'msg' => 'Gagal menambahkan member.'];
 
        header("Location: index.php?act=admin-member");
        exit;
    }

    public function adminMemberEdit() {
        $this->requireAdmin();
        $id     = (int)($_GET['id'] ?? 0);
        $member = $this->memberModel->getById($id);
        if (!$member) { header("Location: index.php?act=admin-member"); exit; }
        include 'app/view/admin/member/form.php';
    }
 
    public function adminMemberUpdate() {
        $this->requireAdmin();
        $id       = (int)($_GET['id'] ?? 0);
        $existing = $this->memberModel->getById($id);
 
        // Foto kabesha: pakai yang lama kalau tidak diupload baru
        $foto = $existing['foto'] ?? '';
        if (!empty($_FILES['foto_kabesha']['name'])) {
            $foto = $this->uploadFoto($_FILES['foto_kabesha'], 'kabesha');
        }
 
        // Foto casual: pakai yang lama kalau tidak diupload baru
        $foto_casual = $existing['foto_casual'] ?? '';
        if (!empty($_FILES['foto_casual']['name'])) {
            $foto_casual = $this->uploadFoto($_FILES['foto_casual'], 'casual');
        }
 
        $data = [
            'nama_member'   => trim($_POST['nama_member']),
            'tanggal_lahir' => $_POST['tanggal_lahir'],
            'foto'          => $foto,
            'foto_casual'   => $foto_casual,
            'gen'           => $_POST['gen'],
            'asal'          => trim($_POST['asal']),
            'deskripsi'     => trim($_POST['deskripsi']),
        ];
 
        $_SESSION['flash'] = $this->memberModel->update($id, $data)
            ? ['type' => 'success', 'msg' => 'Member berhasil diperbarui!']
            : ['type' => 'error',   'msg' => 'Gagal memperbarui member.'];
 
        header("Location: index.php?act=admin-member");
        exit;
    }

    // ==========================================
    // ADMIN — JADWAL CRUD
    // =========================================
// app/controllers/UsersControllers.php
// Tambahkan method-method ini ke class UsersControllers yang sudah ada.
// Ganti method adminJadwal, adminJadwalCreate, adminJadwalStore,
// adminJadwalEdit, adminJadwalUpdate, adminJadwalDelete
// dengan versi di bawah. Tambahkan method baru: adminJadwalSync,
// adminJadwalSyncProcess, adminJadwalPreview.

// ==========================================
// ADMIN — JADWAL CRUD  (ganti yang lama)
// ==========================================

public function adminJadwal() {
    $this->requireAdmin();
    $jadwals = $this->jadwalModel->getAll();
    include 'app/view/admin/jadwal/index.php';
}

public function adminJadwalCreate() {
    $this->requireAdmin();
    include 'app/view/admin/jadwal/form.php';
}

public function adminJadwalStore() {
    $this->requireAdmin();

    $foto = '';
    if (!empty($_FILES['foto']['name'])) {
        $foto = $this->uploadJadwalFoto($_FILES['foto']);
    }

    $data = [
        'tanggal_jadwal' => $_POST['tanggal_jadwal'],
        'waktu_jadwal'   => $_POST['waktu_jadwal'] ?? null,
        'nama_acara'     => trim($_POST['nama_acara']),
        'tipe'           => $_POST['tipe'] ?? 'Theater Show',
        'lokasi'         => trim($_POST['lokasi']),
        'deskripsi'      => trim($_POST['deskripsi'] ?? ''),
        'foto'           => $foto,
    ];

    $_SESSION['flash'] = $this->jadwalModel->create($data)
        ? ['type' => 'success', 'msg' => 'Jadwal berhasil ditambahkan!']
        : ['type' => 'error',   'msg' => 'Gagal menambahkan jadwal.'];

    header("Location: index.php?act=admin-jadwal");
    exit;
}

public function adminJadwalEdit() {
    $this->requireAdmin();
    $id     = (int)($_GET['id'] ?? 0);
    $jadwal = $this->jadwalModel->getById($id);
    if (!$jadwal) { header("Location: index.php?act=admin-jadwal"); exit; }
    include 'app/view/admin/jadwal/form.php';
}

public function adminJadwalUpdate() {
    $this->requireAdmin();
    $id       = (int)($_GET['id'] ?? 0);
    $existing = $this->jadwalModel->getById($id);

    $foto = $existing['foto'] ?? '';
    if (!empty($_FILES['foto']['name'])) {
        $foto = $this->uploadJadwalFoto($_FILES['foto']);
    }
    if (isset($_POST['hapus_foto']) && $_POST['hapus_foto'] === '1') {
        $foto = '';
    }

    $data = [
        'tanggal_jadwal' => $_POST['tanggal_jadwal'],
        'waktu_jadwal'   => $_POST['waktu_jadwal'] ?? null,
        'nama_acara'     => trim($_POST['nama_acara']),
        'tipe'           => $_POST['tipe'] ?? 'Theater Show',
        'lokasi'         => trim($_POST['lokasi']),
        'deskripsi'      => trim($_POST['deskripsi'] ?? ''),
        'foto'           => $foto,
    ];

    $_SESSION['flash'] = $this->jadwalModel->update($id, $data)
        ? ['type' => 'success', 'msg' => 'Jadwal berhasil diperbarui!']
        : ['type' => 'error',   'msg' => 'Gagal memperbarui jadwal.'];

    header("Location: index.php?act=admin-jadwal");
    exit;
}

public function adminJadwalDelete() {
    $this->requireAdmin();
    $id = (int)($_GET['id'] ?? 0);
    $_SESSION['flash'] = $this->jadwalModel->delete($id)
        ? ['type'=>'success','msg'=>'Jadwal berhasil dihapus.']
        : ['type'=>'error',  'msg'=>'Gagal menghapus jadwal.'];
    header("Location: index.php?act=admin-jadwal");
    exit;
}

// ==========================================
// ADMIN — SYNC JADWAL DARI JKT48.COM (baru)
// ==========================================

/**
 * Halaman preview sebelum sync.
 * Tampilkan dulu apa yang akan diimport dari jkt48.com.
 */
public function adminJadwalPreview() {
    $this->requireAdmin();

    $year  = (int)($_GET['year']  ?? date('Y'));
    $month = (int)($_GET['month'] ?? date('n'));

    // Validasi
    $year  = max(2024, min($year,  (int)date('Y') + 1));
    $month = max(1,    min($month, 12));

    $scraped = $this->jadwalModel->scrapeFromJKT48($year, $month);

    include 'app/view/admin/jadwal/sync.php';
}

/**
 * Proses sync: insert hasil scrape ke DB.
 */
public function adminJadwalSync() {
    $this->requireAdmin();

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        header("Location: index.php?act=admin-jadwal");
        exit;
    }

    $year  = (int)($_POST['year']  ?? date('Y'));
    $month = (int)($_POST['month'] ?? date('n'));

    $result = $this->jadwalModel->syncFromJKT48($year, $month);

    if ($result['error']) {
        $_SESSION['flash'] = [
            'type' => 'error',
            'msg'  => '❌ ' . $result['error'],
        ];
    } else {
        $_SESSION['flash'] = [
            'type' => 'success',
            'msg'  => "✅ Sync selesai! {$result['inserted']} jadwal diimport"
                    . ($result['skipped'] > 0 ? ", {$result['skipped']} dilewati (sudah ada)." : "."),
        ];
    }

    header("Location: index.php?act=admin-jadwal");
    exit;
}

    // ==========================================
    // ADMIN — POST CRUD
    // ==========================================
    public function adminPost() {
        $this->requireAdmin();
        $posts = $this->postModel->getAll();
        include 'app/view/admin/post/index.php';
    }

    public function adminPostCreate() {
        $this->requireAdmin();
        include 'app/view/admin/post/form.php';
    }

    public function adminPostStore() {
        $this->requireAdmin();
 
        $foto = '';
        if (!empty($_FILES['foto']['name'])) {
            $foto = $this->uploadPostFoto($_FILES['foto']);
        }
 
        $data = [
            'judul'   => trim($_POST['judul']),
            'isi'     => trim($_POST['isi']),
            'foto'    => $foto,
            'id_user' => (int)$_SESSION['user_id'],
        ];
 
        $_SESSION['flash'] = $this->postModel->create($data)
            ? ['type' => 'success', 'msg' => 'Post berhasil dipublikasikan!']
            : ['type' => 'error',   'msg' => 'Gagal mempublikasikan post.'];
 
        header("Location: index.php?act=admin-post");
        exit;
    }

    public function adminPostEdit() {
        $this->requireAdmin();
        $id   = (int)($_GET['id'] ?? 0);
        $post = $this->postModel->getById($id);
        if (!$post) { header("Location: index.php?act=admin-post"); exit; }
        include 'app/view/admin/post/form.php';
    }
 
    public function adminPostUpdate() {
        $this->requireAdmin();
        $id       = (int)($_GET['id'] ?? 0);
        $existing = $this->postModel->getById($id);
 
        // Pakai foto lama kalau tidak upload baru
        $foto = $existing['foto'] ?? '';
        if (!empty($_FILES['foto']['name'])) {
            $foto = $this->uploadPostFoto($_FILES['foto']);
        }
 
        // Kalau admin centang "hapus foto"
        if (isset($_POST['hapus_foto']) && $_POST['hapus_foto'] === '1') {
            $foto = '';
        }
 
        $data = [
            'judul' => trim($_POST['judul']),
            'isi'   => trim($_POST['isi']),
            'foto'  => $foto,
        ];

        $_SESSION['flash'] = $this->postModel->update($id, $data)
            ? ['type' => 'success', 'msg' => 'Post berhasil diperbarui!']
            : ['type' => 'error',   'msg' => 'Gagal memperbarui post.'];
 
        header("Location: index.php?act=admin-post");
        exit;
    }

    public function adminPostDelete() {
        $this->requireAdmin();
        $id = (int)($_GET['id'] ?? 0);
        $_SESSION['flash'] = $this->postModel->delete($id)
            ? ['type'=>'success','msg'=>'Post berhasil dihapus.']
            : ['type'=>'error',  'msg'=>'Gagal menghapus post.'];
        header("Location: index.php?act=admin-post");
        exit;
    }

    // ==========================================
    // USER — KONTAK & SARAN
    // ==========================================
 
    public function kirimSaran() {
        $nama  = trim($_POST['nama']  ?? '');
        $pesan = trim($_POST['pesan'] ?? '');
 
        if (!$nama || !$pesan) {
            $_SESSION['flash'] = ['type'=>'error','msg'=>'Nama dan pesan wajib diisi!'];
            header("Location: index.php?act=kontak"); exit;
        }
        if (strlen($pesan) < 10) {
            $_SESSION['flash'] = ['type'=>'error','msg'=>'Pesan terlalu singkat, minimal 10 karakter.'];
            header("Location: index.php?act=kontak"); exit;
        }
        if ($this->saranModel->create($nama, $pesan)) {
            $_SESSION['flash'] = ['type'=>'success','msg'=>'Terima kasih atas saranmu! 🌸'];
        } else {
            $_SESSION['flash'] = ['type'=>'error','msg'=>'Gagal mengirim saran, coba lagi.'];
        }
        header("Location: index.php?act=kontak"); exit;
    }

    // ══════════════════════════════
    // USER — Halaman Galeri
    // ══════════════════════════════
 
    // Level 1: Daftar event
    public function galeriPage() {
        $events = $this->galeriModel->getAllEvents();
        $flash  = $_SESSION['flash'] ?? null;
        unset($_SESSION['flash']);
        include 'app/view/user/galeri/index.php';
    }
 
    // Level 2: Pilih member di event ini
    public function galeriEvent() {
        $idEvent = (int)($_GET['event'] ?? 0);
        $event   = $this->galeriModel->getEventById($idEvent);
        if (!$event) { header("Location: index.php?act=galeri"); exit; }
 
        $members = $this->galeriModel->getMembersByEvent($idEvent);
        // Semua member untuk dropdown upload
        $allMembers = $this->memberModel->getAll();
        $flash = $_SESSION['flash'] ?? null;
        unset($_SESSION['flash']);
        include 'app/view/user/galeri/event.php';
    }
 
    // Level 3: Grid foto per member per event
    public function galeriFoto() {
    $idEvent  = (int)($_GET['event']  ?? 0);
    $idMember = (int)($_GET['member'] ?? 0);
    $event    = $this->galeriModel->getEventById($idEvent);
    $member   = $this->memberModel->getById($idMember);
    if (!$event || !$member) { header("Location: index.php?act=galeri"); exit; }

    $fotos = $this->galeriModel->getFotoByEventMember($idEvent, $idMember);

    $komentarsPerFoto = [];
    foreach ($fotos as $f) {
        $komentarsPerFoto[$f['id_foto']] = $this->galeriModel->getKomentarByFoto((int)$f['id_foto']);
    }

    $flash = $_SESSION['flash'] ?? null;
    unset($_SESSION['flash']);
    include 'app/view/user/galeri/foto.php';
    }
 
    public function galeriUpload() {
        if (!isset($_SESSION['user_id'])) {
            $_SESSION['flash'] = ['type'=>'error','msg'=>'Kamu harus login untuk upload foto.'];
            header("Location: index.php?act=login"); exit;
        }
 
        $idEvent  = (int)($_POST['id_event']  ?? 0);
        $idMember = (int)($_POST['id_member'] ?? 0);
 
        if (empty($_FILES['file']['name'])) {
            $_SESSION['flash'] = ['type'=>'error','msg'=>'Pilih file terlebih dahulu.'];
            header("Location: index.php?act=galeri-foto&event={$idEvent}&member={$idMember}"); exit;
        }
 
        $result = $this->uploadGaleriFile($_FILES['file']);
        if (!$result['ok']) {
            $_SESSION['flash'] = ['type'=>'error','msg'=>$result['msg']];
            header("Location: index.php?act=galeri-foto&event={$idEvent}&member={$idMember}"); exit;
        }
 
        $data = [
            'id_event'  => $idEvent,
            'id_member' => $idMember,
            'id_user'   => (int)$_SESSION['user_id'],
            'file_path' => $result['path'],
            'tipe_file' => $result['tipe'],
            'caption'   => trim($_POST['caption'] ?? ''),
        ];
 
        if ($this->galeriModel->uploadFoto($data)) {
            $_SESSION['flash'] = ['type'=>'success','msg'=>'File berhasil diupload! 🌸'];
        } else {
            $_SESSION['flash'] = ['type'=>'error','msg'=>'Gagal upload, coba lagi.'];
        }
        header("Location: index.php?act=galeri-foto&event={$idEvent}&member={$idMember}"); exit;
    }
 
    // Hapus foto (pemilik atau admin)
    public function galeriHapusFoto() {
        if (!isset($_SESSION['user_id'])) {
            header("Location: index.php?act=login"); exit;
        }
 
        $id    = (int)($_GET['id']     ?? 0);
        $event  = (int)($_GET['event'] ?? 0);
        $member = (int)($_GET['member']?? 0);
        $foto  = $this->galeriModel->getFotoById($id);
 
        if (!$foto) {
            $_SESSION['flash'] = ['type'=>'error','msg'=>'Foto tidak ditemukan.'];
            header("Location: index.php?act=galeri-foto&event={$event}&member={$member}"); exit;
        }
 
        // Hanya pemilik atau admin yang boleh hapus
        $isOwner = (int)$foto['id_user'] === (int)$_SESSION['user_id'];
        $isAdmin = $_SESSION['role'] === 'admin';
        if (!$isOwner && !$isAdmin) {
            $_SESSION['flash'] = ['type'=>'error','msg'=>'Kamu tidak punya izin untuk menghapus ini.'];
            header("Location: index.php?act=galeri-foto&event={$event}&member={$member}"); exit;
        }
 
        // Hapus file fisik
        if (file_exists($foto['file_path'])) unlink($foto['file_path']);
 
        if ($this->galeriModel->deleteFoto($id)) {
            $_SESSION['flash'] = ['type'=>'success','msg'=>'Foto berhasil dihapus.'];
        } else {
            $_SESSION['flash'] = ['type'=>'error','msg'=>'Gagal menghapus foto.'];
        }
        header("Location: index.php?act=galeri-foto&event={$event}&member={$member}"); exit;
    }
 
    // Kirim komentar
    public function galeriKomentar() {
        if (!isset($_SESSION['user_id'])) {
            header("Location: index.php?act=login"); exit;
        }
        $idFoto  = (int)($_POST['id_foto']  ?? 0);
        $idEvent  = (int)($_POST['id_event'] ?? 0);
        $idMember = (int)($_POST['id_member']?? 0);
        $isi      = trim($_POST['isi'] ?? '');
 
        if (!$isi) {
            $_SESSION['flash'] = ['type'=>'error','msg'=>'Komentar tidak boleh kosong.'];
            header("Location: index.php?act=galeri-foto&event={$idEvent}&member={$idMember}#foto-{$idFoto}"); exit;
        }
 
        $this->galeriModel->addKomentar($idFoto, (int)$_SESSION['user_id'], $isi);
        header("Location: index.php?act=galeri-foto&event={$idEvent}&member={$idMember}#foto-{$idFoto}"); exit;
    }
 
    // Hapus komentar (pemilik atau admin)
    public function galeriHapusKomentar() {
        if (!isset($_SESSION['user_id'])) {
            header("Location: index.php?act=login"); exit;
        }
        $id       = (int)($_GET['id']      ?? 0);
        $idFoto   = (int)($_GET['id_foto'] ?? 0);
        $idEvent  = (int)($_GET['event']   ?? 0);
        $idMember = (int)($_GET['member']  ?? 0);
        $kom      = $this->galeriModel->getKomentarById($id);
 
        if ($kom) {
            $isOwner = (int)$kom['id_user'] === (int)$_SESSION['user_id'];
            $isAdmin = $_SESSION['role'] === 'admin';
            if ($isOwner || $isAdmin) {
                $this->galeriModel->deleteKomentar($id);
            }
        }
        header("Location: index.php?act=galeri-foto&event={$idEvent}&member={$idMember}#foto-{$idFoto}"); exit;
    }
 
    // ══════════════════════════════
    // ADMIN — Kelola Event Galeri
    // ══════════════════════════════
 
    public function adminGaleri() {
        $this->requireAdmin();
        $events = $this->galeriModel->getAllEvents();
        include 'app/view/admin/galeri/index.php';
    }
 
    public function adminGaleriCreate() {
        $this->requireAdmin();
        include 'app/view/admin/galeri/form.php';
    }
 
    public function adminGaleriStore() {
        $this->requireAdmin();
        $data = [
            'nama_event' => trim($_POST['nama_event']),
            'tipe'       => $_POST['tipe'] ?? 'Theater Show',
            'tanggal'    => $_POST['tanggal'],
            'deskripsi'  => trim($_POST['deskripsi'] ?? ''),
        ];
        $_SESSION['flash'] = $this->galeriModel->createEvent($data)
            ? ['type'=>'success','msg'=>'Event galeri berhasil dibuat!']
            : ['type'=>'error',  'msg'=>'Gagal membuat event galeri.'];
        header("Location: index.php?act=admin-galeri"); exit;
    }
 
    public function adminGaleriEdit() {
        $this->requireAdmin();
        $id    = (int)($_GET['id'] ?? 0);
        $event = $this->galeriModel->getEventById($id);
        if (!$event) { header("Location: index.php?act=admin-galeri"); exit; }
        include 'app/view/admin/galeri/form.php';
    }
 
    public function adminGaleriUpdate() {
        $this->requireAdmin();
        $id   = (int)($_GET['id'] ?? 0);
        $data = [
            'nama_event' => trim($_POST['nama_event']),
            'tipe'       => $_POST['tipe'] ?? 'Theater Show',
            'tanggal'    => $_POST['tanggal'],
            'deskripsi'  => trim($_POST['deskripsi'] ?? ''),
        ];
        $_SESSION['flash'] = $this->galeriModel->updateEvent($id, $data)
            ? ['type'=>'success','msg'=>'Event galeri berhasil diperbarui!']
            : ['type'=>'error',  'msg'=>'Gagal memperbarui event galeri.'];
        header("Location: index.php?act=admin-galeri"); exit;
    }
 
    public function adminGaleriDelete() {
        $this->requireAdmin();
        $id = (int)($_GET['id'] ?? 0);
        $_SESSION['flash'] = $this->galeriModel->deleteEvent($id)
            ? ['type'=>'success','msg'=>'Event galeri berhasil dihapus.']
            : ['type'=>'error',  'msg'=>'Gagal menghapus event galeri.'];
        header("Location: index.php?act=admin-galeri"); exit;
    }
        
    // ==========================================
    // HELPERS
    // ==========================================
    private function requireAdmin(): void {
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
            header("Location: index.php");
            exit;
        }
    }

    private function uploadFoto(array $file, string $prefix = 'mbr'): string {
        $uploadDir = 'public/images/member/uploads/';
        if (!is_dir($uploadDir)) mkdir($uploadDir, 0755, true);
 
        $ext     = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        $allowed = ['jpg', 'jpeg', 'png', 'webp'];
 
        if (!in_array($ext, $allowed)) return '';
        if ($file['size'] > 2 * 1024 * 1024) return ''; // max 2MB
 
        $filename = $prefix . '_' . uniqid() . '.' . $ext;
        if (move_uploaded_file($file['tmp_name'], $uploadDir . $filename)) {
            return $uploadDir . $filename;
        }
        return '';
    }

    private function uploadPostFoto(array $file): string {
        $uploadDir = 'public/images/post/';
        if (!is_dir($uploadDir)) mkdir($uploadDir, 0755, true);
 
        $ext     = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        $allowed = ['jpg', 'jpeg', 'png', 'webp'];
 
        if (!in_array($ext, $allowed)) return '';
        if ($file['size'] > 3 * 1024 * 1024) return ''; // max 3MB
 
        $filename = 'post_' . uniqid() . '.' . $ext;
        if (move_uploaded_file($file['tmp_name'], $uploadDir . $filename)) {
            return $uploadDir . $filename;
        }
        return '';
    }

    private function uploadJadwalFoto(array $file): string {
        $uploadDir = 'public/images/jadwal/';
        if (!is_dir($uploadDir)) mkdir($uploadDir, 0755, true);
 
        $ext     = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        $allowed = ['jpg', 'jpeg', 'png', 'webp'];
 
        if (!in_array($ext, $allowed)) return '';
        if ($file['size'] > 3 * 1024 * 1024) return '';
 
        $filename = 'jadwal_' . uniqid() . '.' . $ext;
        if (move_uploaded_file($file['tmp_name'], $uploadDir . $filename)) {
            return $uploadDir . $filename;
        }
        return '';
    }

    private function uploadGaleriFile(array $file): array {
        $ext     = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        $fotoExt = ['jpg','jpeg','png','webp'];
        $vidExt  = ['mp4','mov','webm'];
 
        if (in_array($ext, $fotoExt)) {
            $tipe   = 'foto';
            $maxMB  = 10;
            $subdir = 'public/images/galeri/';
        } elseif (in_array($ext, $vidExt)) {
            $tipe   = 'video';
            $maxMB  = 100;
            $subdir = 'public/video/galeri/';
        } else {
            return ['ok'=>false,'msg'=>'Format file tidak didukung. Gunakan JPG/PNG/WEBP untuk foto atau MP4/MOV/WEBM untuk video.'];
        }
 
        if ($file['size'] > $maxMB * 1024 * 1024) {
            return ['ok'=>false,'msg'=>"Ukuran file terlalu besar. Maks {$maxMB}MB untuk {$tipe}."];
        }
 
        if (!is_dir($subdir)) mkdir($subdir, 0755, true);
 
        $filename = uniqid('galeri_') . '.' . $ext;
        $path     = $subdir . $filename;
 
        if (!move_uploaded_file($file['tmp_name'], $path)) {
            return ['ok'=>false,'msg'=>'Gagal menyimpan file.'];
        }
 
        return ['ok'=>true,'path'=>$path,'tipe'=>$tipe,'msg'=>'OK'];
    }
 
}