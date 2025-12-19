<?php
namespace App\Core;

use PDO;
use PDOException;

class DB
{
    private static ?PDO $pdo = null;

    public static function conn(): PDO
    {
        if (self::$pdo === null) {
            $dsn = 'mysql:host=' . env('DB_HOST') . ';port=' . env('DB_PORT') . ';dbname=' . env('DB_NAME') . ';charset=utf8mb4';
            try {
                self::$pdo = new PDO($dsn, env('DB_USER'), env('DB_PASS'), [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                ]);
            } catch (PDOException $e) {
                die('Database connection failed: ' . $e->getMessage());
            }
        }
        return self::$pdo;
    }
}
