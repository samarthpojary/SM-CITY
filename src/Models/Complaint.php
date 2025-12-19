<?php
namespace App\Models;

use App\Core\DB;
use PDO;

class Complaint
{
    public static function create(array $data): int
    {
        $sql = 'INSERT INTO complaints (user_id, title, description, category, priority, status, latitude, longitude, image_path) VALUES (:user_id, :title, :description, :category, :priority, :status, :latitude, :longitude, :image_path)';
        $stmt = DB::conn()->prepare($sql);
        $stmt->execute([
            ':user_id' => $data['user_id'],
            ':title' => $data['title'],
            ':description' => $data['description'],
            ':category' => $data['category'] ?? 'Uncategorized',
            ':priority' => $data['priority'] ?? 'Low',
            ':status' => 'Submitted',
            ':latitude' => $data['latitude'],
            ':longitude' => $data['longitude'],
            ':image_path' => $data['image_path'] ?? null,
        ]);
        return (int)DB::conn()->lastInsertId();
    }

    public static function allByUser(int $userId): array
    {
        $stmt = DB::conn()->prepare('SELECT * FROM complaints WHERE user_id = :uid ORDER BY created_at DESC');
        $stmt->execute([':uid' => $userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function find(int $id): ?array
    {
        $stmt = DB::conn()->prepare('SELECT * FROM complaints WHERE id = :id');
        $stmt->execute([':id' => $id]);
        $c = $stmt->fetch(PDO::FETCH_ASSOC);
        return $c ?: null;
    }

    public static function listForRole(string $role, int $userId): array
    {
        if ($role === 'citizen') {
            return self::allByUser($userId);
        }
        $stmt = DB::conn()->query('SELECT * FROM complaints ORDER BY created_at DESC');
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function updateStatus(int $id, string $status)
    {
        $stmt = DB::conn()->prepare('UPDATE complaints SET status = :status WHERE id = :id');
        $stmt->execute([':status' => $status, ':id' => $id]);
    }

    public static function resolve(int $id, string $evidencePath)
    {
        $stmt = DB::conn()->prepare('UPDATE complaints SET status = :status, resolution_proof = :proof, resolved_at = NOW() WHERE id = :id');
        $stmt->execute([':status' => 'Resolved', ':proof' => $evidencePath, ':id' => $id]);
    }

    public static function recent(int $limit = 20): array
    {
        $stmt = DB::conn()->prepare('SELECT id, title, category, priority, status, latitude, longitude FROM complaints ORDER BY created_at DESC LIMIT :lim');
        $stmt->bindValue(':lim', $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
