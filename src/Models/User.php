<?php
namespace App\Models;

use App\Core\DB;
use PDO;

class User
{
    public static function create(array $data): int
    {
        $sql = 'INSERT INTO users (name, email, password, role, phone, address) VALUES (:name, :email, :password, :role, :phone, :address)';
        $stmt = DB::conn()->prepare($sql);
        $stmt->execute([
            ':name' => $data['name'],
            ':email' => $data['email'],
            ':password' => password_hash($data['password'], PASSWORD_BCRYPT),
            ':role' => $data['role'] ?? 'citizen',
            ':phone' => $data['phone'] ?? null,
            ':address' => $data['address'] ?? null,
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

    public static function allByRole(string|array $roles): array
    {
        $roles = is_array($roles) ? $roles : [$roles];
        $placeholders = str_repeat('?,', count($roles) - 1) . '?';
        $stmt = DB::conn()->prepare("SELECT * FROM users WHERE role IN ($placeholders) ORDER BY created_at DESC");
        $stmt->execute($roles);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function update(int $id, array $data): bool
    {
        $setParts = [];
        $params = [':id' => $id];
        foreach ($data as $key => $value) {
            $setParts[] = "$key = :$key";
            $params[":$key"] = $value;
        }
        $setClause = implode(', ', $setParts);
        $sql = "UPDATE users SET $setClause WHERE id = :id";
        $stmt = DB::conn()->prepare($sql);
        return $stmt->execute($params);
    }
}
