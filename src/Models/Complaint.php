<?php
namespace App\Models;

use App\Core\DB;

class Complaint
{
    public static function create(array $data): int
    {
        $data['status'] = $data['status'] ?? 'Submitted';
        $data['priority'] = $data['priority'] ?? 'Low';
        $data['category'] = $data['category'] ?? 'Uncategorized';
        return DB::insert('complaints', $data);
    }

    public static function find(int $id): ?array
    {
        return DB::fetch('
            SELECT c.*, u.name as user_name, u.email as user_email,
                   a.name as authority_name, a.email as authority_email
            FROM complaints c
            LEFT JOIN users u ON c.user_id = u.id
            LEFT JOIN users a ON c.assigned_authority_id = a.id
            WHERE c.id = :id LIMIT 1
        ', ['id' => $id]);
    }

    public static function update(int $id, array $data): bool
    {
        return DB::update('complaints', $data, 'id = :id', ['id' => $id]) > 0;
    }

    public static function updateStatus(int $id, string $status, ?int $userId = null): bool
    {
        $complaint = self::find($id);
        if (!$complaint) return false;

        $oldStatus = $complaint['status'];
        $success = self::update($id, ['status' => $status]);

        if ($success && $userId) {
            // Log the status change
            self::logAction($id, $userId, 'status_change', $oldStatus, $status);
        }

        return $success;
    }

    public static function assignToAuthority(int $id, int $authorityId, ?int $userId = null): bool
    {
        $success = self::update($id, ['assigned_authority_id' => $authorityId]);

        if ($success && $userId) {
            self::logAction($id, $userId, 'assigned', null, null, "Assigned to authority ID: $authorityId");
        }

        return $success;
    }

    public static function listForRole(string $role, int $userId): array
    {
        switch ($role) {
            case 'admin':
                return DB::fetchAll('
                    SELECT c.*, u.name as user_name, u.email as user_email,
                           a.name as authority_name, a.email as authority_email
                    FROM complaints c
                    LEFT JOIN users u ON c.user_id = u.id
                    LEFT JOIN users a ON c.assigned_authority_id = a.id
                    ORDER BY c.created_at DESC
                ');
            case 'authority':
                return DB::fetchAll('
                    SELECT c.*, u.name as user_name, u.email as user_email
                    FROM complaints c
                    LEFT JOIN users u ON c.user_id = u.id
                    WHERE c.assigned_authority_id = :authority_id OR c.assigned_authority_id IS NULL
                    ORDER BY c.created_at DESC
                ', ['authority_id' => $userId]);
            case 'citizen':
            default:
                return DB::fetchAll('
                    SELECT c.*, a.name as authority_name, a.email as authority_email
                    FROM complaints c
                    LEFT JOIN users a ON c.assigned_authority_id = a.id
                    WHERE c.user_id = :user_id
                    ORDER BY c.created_at DESC
                ', ['user_id' => $userId]);
        }
    }

    public static function stats(): array
    {
        $stats = [
            'total' => 0,
            'status' => [],
            'priority' => [],
            'category' => [],
            'users' => []
        ];

        // Total complaints
        $result = DB::fetch('SELECT COUNT(*) as count FROM complaints');
        $stats['total'] = (int)$result['count'];

        // Status counts
        $statusResults = DB::fetchAll('SELECT status, COUNT(*) as count FROM complaints GROUP BY status');
        foreach ($statusResults as $row) {
            $stats['status'][$row['status']] = (int)$row['count'];
        }

        // Priority counts
        $priorityResults = DB::fetchAll('SELECT priority, COUNT(*) as count FROM complaints GROUP BY priority');
        foreach ($priorityResults as $row) {
            $stats['priority'][$row['priority']] = (int)$row['count'];
        }

        // Category counts
        $categoryResults = DB::fetchAll('SELECT category, COUNT(*) as count FROM complaints GROUP BY category');
        foreach ($categoryResults as $row) {
            $stats['category'][$row['category']] = (int)$row['count'];
        }

        // User role counts
        $userResults = DB::fetchAll('SELECT role, COUNT(*) as count FROM users GROUP BY role');
        foreach ($userResults as $row) {
            $stats['users'][$row['role']] = (int)$row['count'];
        }

        return $stats;
    }

    public static function recent(int $limit = 10): array
    {
        return DB::fetchAll('SELECT * FROM complaints ORDER BY created_at DESC LIMIT :limit', ['limit' => $limit]);
    }

    public static function duplicates(float $lat, float $lng, string $category, float $radiusKm = 1): array
    {
        $lat1 = $lat - ($radiusKm / 111.32);
        $lat2 = $lat + ($radiusKm / 111.32);
        $lng1 = $lng - ($radiusKm / (111.32 * cos(deg2rad($lat))));
        $lng2 = $lng + ($radiusKm / (111.32 * cos(deg2rad($lat))));

        return DB::fetchAll(
            'SELECT * FROM complaints WHERE category = :category AND latitude BETWEEN :lat1 AND :lat2 AND longitude BETWEEN :lng1 AND :lng2 AND created_at > DATE_SUB(NOW(), INTERVAL 30 DAY)',
            ['category' => $category, 'lat1' => $lat1, 'lat2' => $lat2, 'lng1' => $lng1, 'lng2' => $lng2]
        );
    }

    public static function resolve(int $id, ?string $evidencePath = null, ?int $userId = null): bool
    {
        $data = ['status' => 'Resolved', 'resolved_at' => date('Y-m-d H:i:s')];
        if ($evidencePath) {
            $data['resolution_proof'] = $evidencePath;
        }
        $success = self::update($id, $data);

        if ($success && $userId) {
            self::logAction($id, $userId, 'resolved', null, null, $evidencePath ? 'With evidence' : 'Without evidence');
        }

        return $success;
    }

    public static function allWithUsers(): array
    {
        return DB::fetchAll('
            SELECT c.*, u.name as user_name, u.email as user_email,
                   a.name as authority_name, a.email as authority_email
            FROM complaints c
            LEFT JOIN users u ON c.user_id = u.id
            LEFT JOIN users a ON c.assigned_authority_id = a.id
            ORDER BY c.created_at DESC
        ');
    }

    // Feedback methods
    public static function addFeedback(int $complaintId, int $userId, int $rating, ?string $comment = null): int
    {
        return DB::insert('feedback', [
            'complaint_id' => $complaintId,
            'user_id' => $userId,
            'rating' => $rating,
            'comment' => $comment,
        ]);
    }

    public static function getFeedback(int $complaintId): array
    {
        return DB::fetchAll('
            SELECT f.*, u.name as user_name
            FROM feedback f
            LEFT JOIN users u ON f.user_id = u.id
            WHERE f.complaint_id = :complaint_id
            ORDER BY f.created_at DESC
        ', ['complaint_id' => $complaintId]);
    }

    // Logging methods
    public static function logAction(int $complaintId, int $userId, string $action, ?string $oldStatus = null, ?string $newStatus = null, ?string $notes = null): int
    {
        return DB::insert('complaint_logs', [
            'complaint_id' => $complaintId,
            'user_id' => $userId,
            'action' => $action,
            'old_status' => $oldStatus,
            'new_status' => $newStatus,
            'notes' => $notes,
        ]);
    }

    public static function getLogs(int $complaintId): array
    {
        return DB::fetchAll('
            SELECT l.*, u.name as user_name
            FROM complaint_logs l
            LEFT JOIN users u ON l.user_id = u.id
            WHERE l.complaint_id = :complaint_id
            ORDER BY l.created_at DESC
        ', ['complaint_id' => $complaintId]);
    }
}
