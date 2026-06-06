<?php
// app/models/UsersModel.php

class UsersModel {
    private PDO $connect;
    private string $table = "users";

    public function __construct(PDO $db) {
        $this->connect = $db;
    }

    public function register(string $nama, string $email, string $password): bool {
        $stmt = $this->connect->prepare(
            "INSERT INTO {$this->table} (nama, email, password_pengguna, ROLE)
             VALUES (:nama, :email, :password, :role)"
        );
        return $stmt->execute([
            ':nama'     => htmlspecialchars(strip_tags($nama)),
            ':email'    => htmlspecialchars(strip_tags($email)),
            ':password' => password_hash($password, PASSWORD_DEFAULT),
            ':role'     => 'user',
        ]);
    }

    public function login(string $email, string $password): array|false {
        $stmt = $this->connect->prepare(
            "SELECT u.id_user, u.nama, u.password_pengguna, u.ROLE AS role, u.email, u.oshimen,
                    m.nama_member AS oshimen_nama, m.foto AS oshimen_foto, m.gen AS oshimen_gen
             FROM {$this->table} u
             LEFT JOIN member m ON u.oshimen = m.id_member
             WHERE u.email = :email LIMIT 1"
        );
        $stmt->execute([':email' => htmlspecialchars(strip_tags($email))]);
        $row = $stmt->fetch();
        if ($row && password_verify($password, $row['password_pengguna'])) {
            return $row;
        }
        return false;
    }

    public function getById(int $id): array|false {
        $stmt = $this->connect->prepare(
            "SELECT u.*, m.nama_member AS oshimen_nama, m.foto AS oshimen_foto,
                    m.gen AS oshimen_gen, m.asal AS oshimen_asal
             FROM {$this->table} u
             LEFT JOIN member m ON u.oshimen = m.id_member
             WHERE u.id_user = :id LIMIT 1"
        );
        $stmt->execute([':id' => $id]);
        return $stmt->fetch();
    }

    public function updateOshimen(int $userId, ?int $memberId): bool {
        $stmt = $this->connect->prepare(
            "UPDATE {$this->table} SET oshimen = :oshimen WHERE id_user = :id"
        );
        return $stmt->execute([':oshimen' => $memberId, ':id' => $userId]);
    }

    public function updateProfile(int $userId, string $nama): bool {
        $stmt = $this->connect->prepare(
            "UPDATE {$this->table} SET nama = :nama WHERE id_user = :id"
        );
        return $stmt->execute([':nama' => htmlspecialchars(strip_tags($nama)), ':id' => $userId]);
    }

    public function count(): int {
        return (int)$this->connect->query("SELECT COUNT(*) FROM {$this->table}")->fetchColumn();
    }
}