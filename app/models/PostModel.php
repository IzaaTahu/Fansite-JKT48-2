<?php
// app/models/PostModel.php

class PostModel {
    private PDO $db;
    private string $table = "post";

    public function __construct(PDO $db) { $this->db = $db; }

    public function getAll(): array {
        return $this->db->query(
            "SELECT p.*, u.nama AS nama_penulis
             FROM {$this->table} p
             LEFT JOIN users u ON p.id_user = u.id_user
             ORDER BY p.tanggal_terbit DESC"
        )->fetchAll();
    }

    public function getById(int $id): array|false {
        $stmt = $this->db->prepare(
            "SELECT p.*, u.nama AS nama_penulis
             FROM {$this->table} p
             LEFT JOIN users u ON p.id_user = u.id_user
             WHERE p.id_post = :id"
        );
        $stmt->execute([':id' => $id]);
        return $stmt->fetch();
    }

    public function create(array $d): bool {
        $stmt = $this->db->prepare(
            "INSERT INTO {$this->table} (judul, isi, foto, id_user)
             VALUES (:judul, :isi, :foto, :uid)"
        );
        return $stmt->execute([
            ':judul' => $d['judul'],
            ':isi'   => $d['isi'],
            ':foto'  => $d['foto'] ?? null,
            ':uid'   => $d['id_user'],
        ]);
    }

    public function update(int $id, array $d): bool {
        $stmt = $this->db->prepare(
            "UPDATE {$this->table}
             SET judul=:judul, isi=:isi, foto=:foto
             WHERE id_post=:id"
        );
        return $stmt->execute([
            ':judul' => $d['judul'],
            ':isi'   => $d['isi'],
            ':foto'  => $d['foto'] ?? null,
            ':id'    => $id,
        ]);
    }

    public function delete(int $id): bool {
        $stmt = $this->db->prepare("DELETE FROM {$this->table} WHERE id_post = :id");
        return $stmt->execute([':id' => $id]);
    }

    public function count(): int {
        return (int)$this->db->query("SELECT COUNT(*) FROM {$this->table}")->fetchColumn();
    }
}