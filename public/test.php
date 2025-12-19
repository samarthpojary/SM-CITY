<?php
// Test file to check if PHP and database are working
require_once '../src/bootstrap.php';

echo "<h1>SM City - System Test</h1>";

try {
    $pdo = App\Core\DB::conn();
    echo "<p style='color: green;'>✅ Database connection: SUCCESS</p>";

    // Check tables
    $stmt = $pdo->query("SHOW TABLES");
    $tables = $stmt->fetchAll(PDO::FETCH_COLUMN);
    echo "<p>📋 Tables found: " . implode(', ', $tables) . "</p>";

    // Check users
    $stmt = $pdo->query("SELECT COUNT(*) as count FROM users");
    $userCount = $stmt->fetch()['count'];
    echo "<p>👥 Users in database: $userCount</p>";

    // Check admin user
    $stmt = $pdo->prepare("SELECT name, email, role FROM users WHERE role = 'admin' LIMIT 1");
    $stmt->execute();
    $admin = $stmt->fetch();
    if ($admin) {
        echo "<p>👑 Admin user: {$admin['name']} ({$admin['email']})</p>";
    }

} catch (Exception $e) {
    echo "<p style='color: red;'>❌ Error: " . $e->getMessage() . "</p>";
}

echo "<hr>";
echo "<a href='../index.html'>← Back to Home</a>";
?>