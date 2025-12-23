<?php
require_once __DIR__ . '/src/bootstrap.php';

use App\Models\User;

try {
    $id = User::create([
        'name' => 'Authority Officer',
        'email' => 'authority@smcity.com',
        'password' => 'authority123',
        'role' => 'authority'
    ]);

    if ($id) {
        echo "Authority user created successfully!\n";
        echo "Email: authority@smcity.com\n";
        echo "Password: authority123\n";
    } else {
        echo "Failed to create authority user\n";
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
?>
