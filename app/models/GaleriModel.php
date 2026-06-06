<?php
// app/models/GaleriModel.php

class GaleriModel {
    private PDO $db;

    public function __construct(PDO $db) { $this->db = $db; }

    // ══════════════════════════════════
    // GALERI EVENT
    // ══════════════════════════════════

    public function getAllEvents(): array {
        return $this->db->query(
            "SELECT ge.*,
                    COUNT(DISTINCT gf.id_foto)   AS total_foto,
                    COUNT(DISTINCT gf.id_member) AS total_member
             FROM galeri_event ge
             LEFT JOIN galeri_foto gf ON gf.id_event = ge.id_event
             GROUP BY ge.id_event
             ORDER BY ge.tanggal DESC"
        )->fetchAll();
    }

    public function getEventById(int $id): array|false {
        $stmt = $this->db->prepare(
            "SELECT * FROM galeri_event WHERE id_event = :id"
        );
        $stmt->execute([':id' => $id]);
        return $stmt->fetch();
    }

    public function createEvent(array $d): bool {
        $stmt = $this->db->prepare(
            "INSERT INTO galeri_event (nama_event, tipe, tanggal, deskripsi)
             VALUES (:nama, :tipe, :tgl, :desk)"
        );
        return $stmt->execute([
            ':nama' => $d['nama_event'],
            ':tipe' => $d['tipe'],
            ':tgl'  => $d['tanggal'],
            ':desk' => $d['deskripsi'] ?: null,
        ]);
    }

    public function updateEvent(int $id, array $d): bool {
        $stmt = $this->db->prepare(
            "UPDATE galeri_event
             SET nama_event=:nama, tipe=:tipe, tanggal=:tgl, deskripsi=:desk
             WHERE id_event=:id"
        );
        return $stmt->execute([
            ':nama' => $d['nama_event'], ':tipe' => $d['tipe'],
            ':tgl'  => $d['tanggal'],   ':desk' => $d['deskripsi'] ?: null,
            ':id'   => $id,
        ]);
    }

    public function deleteEvent(int $id): bool {
        $stmt = $this->db->prepare("DELETE FROM galeri_event WHERE id_event = :id");
        return $stmt->execute([':id' => $id]);
    }

    // ══════════════════════════════════
    // MEMBER YANG ADA DI EVENT INI
    // ══════════════════════════════════

    // Ambil member yang sudah punya foto di event ini
    public function getMembersByEvent(int $idEvent): array {
        $stmt = $this->db->prepare(
            "SELECT m.*, COUNT(gf.id_foto) AS total_foto
             FROM member m
             INNER JOIN galeri_foto gf ON gf.id_member = m.id_member
             WHERE gf.id_event = :ev
             GROUP BY m.id_member
             ORDER BY m.nama_member ASC"
        );
        $stmt->execute([':ev' => $idEvent]);
        return $stmt->fetchAll();
    }

    // ══════════════════════════════════
    // FOTO / VIDEO
    // ══════════════════════════════════

    public function getFotoByEventMember(int $idEvent, int $idMember): array {
        $stmt = $this->db->prepare(
            "SELECT gf.*, u.nama AS nama_uploader
             FROM galeri_foto gf
             LEFT JOIN users u ON gf.id_user = u.id_user
             WHERE gf.id_event = :ev AND gf.id_member = :mb
             ORDER BY gf.dibuat_pada DESC"
        );
        $stmt->execute([':ev' => $idEvent, ':mb' => $idMember]);
        return $stmt->fetchAll();
    }

    public function getFotoById(int $id): array|false {
        $stmt = $this->db->prepare(
            "SELECT gf.*, u.nama AS nama_uploader
             FROM galeri_foto gf
             LEFT JOIN users u ON gf.id_user = u.id_user
             WHERE gf.id_foto = :id"
        );
        $stmt->execute([':id' => $id]);
        return $stmt->fetch();
    }

    public function uploadFoto(array $d): bool {
        $stmt = $this->db->prepare(
            "INSERT INTO galeri_foto (id_event, id_member, id_user, file_path, tipe_file, caption)
             VALUES (:ev, :mb, :uid, :path, :tipe, :cap)"
        );
        return $stmt->execute([
            ':ev'   => $d['id_event'],
            ':mb'   => $d['id_member'],
            ':uid'  => $d['id_user'],
            ':path' => $d['file_path'],
            ':tipe' => $d['tipe_file'],
            ':cap'  => $d['caption'] ?: null,
        ]);
    }

    public function deleteFoto(int $id): bool {
        $stmt = $this->db->prepare("DELETE FROM galeri_foto WHERE id_foto = :id");
        return $stmt->execute([':id' => $id]);
    }

    // Semua foto (untuk admin)
    public function getAllFoto(): array {
        return $this->db->query(
            "SELECT gf.*, ge.nama_event, m.nama_member, u.nama AS nama_uploader
             FROM galeri_foto gf
             LEFT JOIN galeri_event ge ON gf.id_event = ge.id_event
             LEFT JOIN member m        ON gf.id_member = m.id_member
             LEFT JOIN users u         ON gf.id_user   = u.id_user
             ORDER BY gf.dibuat_pada DESC"
        )->fetchAll();
    }

    // ══════════════════════════════════
    // KOMENTAR
    // ══════════════════════════════════

    public function getKomentarByFoto(int $idFoto): array {
        $stmt = $this->db->prepare(
            "SELECT gk.*, u.nama AS nama_user
             FROM galeri_komentar gk
             LEFT JOIN users u ON gk.id_user = u.id_user
             WHERE gk.id_foto = :id
             ORDER BY gk.dibuat_pada ASC"
        );
        $stmt->execute([':id' => $idFoto]);
        return $stmt->fetchAll();
    }

    public function addKomentar(int $idFoto, int $idUser, string $isi): bool {
        $stmt = $this->db->prepare(
            "INSERT INTO galeri_komentar (id_foto, id_user, isi) VALUES (:foto, :uid, :isi)"
        );
        return $stmt->execute([
            ':foto' => $idFoto,
            ':uid'  => $idUser,
            ':isi'  => htmlspecialchars(strip_tags(trim($isi))),
        ]);
    }

    public function deleteKomentar(int $id): bool {
        $stmt = $this->db->prepare("DELETE FROM galeri_komentar WHERE id_komentar = :id");
        return $stmt->execute([':id' => $id]);
    }

    public function getKomentarById(int $id): array|false {
        $stmt = $this->db->prepare("SELECT * FROM galeri_komentar WHERE id_komentar = :id");
        $stmt->execute([':id' => $id]);
        return $stmt->fetch();
    }

    // Stats untuk dashboard admin
    public function countEvent(): int {
        return (int)$this->db->query("SELECT COUNT(*) FROM galeri_event")->fetchColumn();
    }
    public function countFoto(): int {
        return (int)$this->db->query("SELECT COUNT(*) FROM galeri_foto")->fetchColumn();
    }
}