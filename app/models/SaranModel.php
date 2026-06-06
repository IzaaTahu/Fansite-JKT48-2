<?php
// app/models/SaranModel.php

class SaranModel {
    private PDO $db;
    private string $table = "saran";

    public function __construct(PDO $db) {
        $this->db = $db;
    }

    public function getAll(): array {
        return $this->db->query(
            "SELECT * FROM {$this->table} ORDER BY dibuat_pada DESC"
        )->fetchAll();
    }

    public function create(string $nama, string $pesan): bool {
        $stmt = $this->db->prepare(
            "INSERT INTO {$this->table} (nama, pesan) VALUES (:nama, :pesan)"
        );
        return $stmt->execute([
            ':nama'  => htmlspecialchars(strip_tags(trim($nama))),
            ':pesan' => htmlspecialchars(strip_tags(trim($pesan))),
        ]);
    }

    public function delete(int $id): bool {
        $stmt = $this->db->prepare(
            "DELETE FROM {$this->table} WHERE id_saran = :id"
        );
        return $stmt->execute([':id' => $id]);
    }

    public function count(): int {
        return (int)$this->db->query(
            "SELECT COUNT(*) FROM {$this->table}"
        )->fetchColumn();
    }
}