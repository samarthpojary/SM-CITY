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
            $host = env('DB_HOST', 'localhost');
            $port = env('DB_PORT', 3306);
            $dbname = env('DB_NAME', 'sm_city');
            $user = env('DB_USER', 'root');
            $pass = env('DB_PASS', 'Samarth@9019');

            $dsn = "mysql:host={$host};port={$port};dbname={$dbname};charset=utf8mb4";

            try {
                self::$pdo = new PDO($dsn, $user, $pass, [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES => false,
                    PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4 COLLATE utf8mb4_unicode_ci"
                ]);
            } catch (PDOException $e) {
                error_log('Database connection failed: ' . $e->getMessage());
                die('Database connection failed. Please check your configuration.');
            }
        }
        return self::$pdo;
    }

    public static function query($sql, $params = []) {
        $stmt = self::conn()->prepare($sql);
        $stmt->execute($params);
        return $stmt;
    }

    public static function fetch($sql, $params = []) {
        return self::query($sql, $params)->fetch();
    }

    public static function fetchAll($sql, $params = []) {
        return self::query($sql, $params)->fetchAll();
    }

    public static function insert($table, $data) {
        $columns = implode(', ', array_keys($data));
        $placeholders = ':' . implode(', :', array_keys($data));
        $sql = "INSERT INTO {$table} ({$columns}) VALUES ({$placeholders})";
        self::query($sql, $data);
        return self::conn()->lastInsertId();
    }

    public static function update($table, $data, $where, $whereParams = []) {
        $set = implode(', ', array_map(fn($k) => "{$k} = :{$k}", array_keys($data)));
        $sql = "UPDATE {$table} SET {$set} WHERE {$where}";
        $params = array_merge($data, $whereParams);
        return self::query($sql, $params)->rowCount();
    }

    public static function delete($table, $where, $params = []) {
        $sql = "DELETE FROM {$table} WHERE {$where}";
        return self::query($sql, $params)->rowCount();
    }
}
