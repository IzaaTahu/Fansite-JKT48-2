<?php
// app/models/MemberModel.php

class MemberModel {
    private PDO $db;
    private string $table = "member";

    public function __construct(PDO $db) {
        $this->db = $db;
    }

    public function getAll(): array {
    return $this->db->query("SELECT * FROM {$this->table} ORDER BY nama_member ASC")->fetchAll();
}

    public function getById(int $id): array|false {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE id_member = :id");
        $stmt->execute([':id' => $id]);
        return $stmt->fetch();
    }

    public function create(array $d): bool {
        $stmt = $this->db->prepare(
            "INSERT INTO {$this->table} (nama_member, tanggal_lahir, foto, foto_casual, gen, asal, deskripsi)
             VALUES (:nama, :tgl, :foto, :foto_casual, :gen, :asal, :desk)"
        );
        return $stmt->execute([
            ':nama'        => $d['nama_member'], ':tgl'  => $d['tanggal_lahir'],
            ':foto'        => $d['foto'],        ':gen'  => $d['gen'],
            ':foto_casual' => $d['foto_casual'], ':desk' => $d['deskripsi'],
            ':asal'        => $d['asal'],        
        ]);
    }

    public function update(int $id, array $d): bool {
        $stmt = $this->db->prepare(
            "UPDATE {$this->table}
             SET nama_member=:nama, tanggal_lahir=:tgl, foto=:foto, foto_casual=:foto_casual, gen=:gen, asal=:asal, deskripsi=:desk
             WHERE id_member=:id"
        );
        return $stmt->execute([
            ':nama'        => $d['nama_member'], ':tgl'  => $d['tanggal_lahir'],
            ':foto'        => $d['foto'],        ':gen'  => $d['gen'],
            ':foto_casual' => $d['foto_casual'], ':desk' => $d['deskripsi'],
            ':asal'        => $d['asal'],        
            ':id'          => $id,
        ]);
    }

    public function delete(int $id): bool {
        $stmt = $this->db->prepare("DELETE FROM {$this->table} WHERE id_member = :id");
        return $stmt->execute([':id' => $id]);
    }

    public function count(): int {
        return (int)$this->db->query("SELECT COUNT(*) FROM {$this->table}")->fetchColumn();
    }
}