<?php
namespace App\Models;

use App\Core\DB;
use PDO;

class User
{
    public static function create(array $data): int
    {
        $sql = 'INSERT INTO users (name, email, password, role) VALUES (:name, :email, :password, :role)';
        $stmt = DB::conn()->prepare($sql);
        $stmt->execute([
            ':name' => $data['name'],
            ':email' => $data['email'],
            ':password' => password_hash($data['password'], PASSWORD_BCRYPT),
            ':role' => $data['role'] ?? 'citizen',
        ]);
        return (int)DB::conn()->lastInsertId();
    }

    public static function findByEmail(string $email): ?array
    {
        $stmt = DB::conn()->prepare('SELECT * FROM users WHERE email = :email LIMIT 1');
        $stmt->execute([':email' => $email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        return $user ?: null;
    }

    public static function find(int $id): ?array
    {
        $stmt = DB::conn()->prepare('SELECT * FROM users WHERE id = :id LIMIT 1');
        $stmt->execute([':id' => $id]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        return $user ?: null;
    }
}
