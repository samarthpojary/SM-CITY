<?php
require_once __DIR__ . '/src/bootstrap.php';

use App\Models\User;

try {
    $id = User::create([
        'name' => 'Administrator',
        'email' => 'admin@smcity.com',
        'password' => 'admin123',
        'role' => 'admin'
    ]);

    if ($id) {
        echo "Admin user created successfully!\n";
        echo "Email: admin@smcity.com\n";
        echo "Password: admin123\n";
    } else {
        echo "Failed to create admin user\n";
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
?>