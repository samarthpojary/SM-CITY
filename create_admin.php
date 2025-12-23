<?php
// Admin User Creation Script
// Run this once to create the first admin user
// Access: http://localhost/SM-City/create_admin.php

require_once __DIR__ . '/src/bootstrap.php';

use App\Models\User;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if (!$name || !$email || !$password) {
        $error = 'All fields are required';
    } elseif (strlen($password) < 6) {
        $error = 'Password must be at least 6 characters long';
    } elseif (User::findByEmail($email)) {
        $error = 'Email already exists';
    } else {
        $role = $_POST['role'] ?? 'admin';
        $id = User::create([
            'name' => $name,
            'email' => $email,
            'password' => $password,
            'role' => $role
        ]);

        if ($id) {
            $success = 'Admin user created successfully! You can now login.';
        } else {
            $error = 'Failed to create admin user';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Admin User - SM City</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 flex items-center justify-center min-h-screen">
    <div class="max-w-md w-full bg-white p-8 rounded-lg shadow-md">
        <h1 class="text-2xl font-bold text-center mb-6">Create Admin User</h1>

        <?php if (isset($error)): ?>
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                <?= htmlspecialchars($error) ?>
            </div>
        <?php endif; ?>

        <?php if (isset($success)): ?>
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                <?= htmlspecialchars($success) ?>
            </div>
            <div class="text-center">
                <a href="index.php" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                    Go to Main Page
                </a>
            </div>
        <?php else: ?>
            <form method="POST" class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Admin Name</label>
                    <input type="text" name="name" required
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Admin Email</label>
                    <input type="email" name="email" required
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                    <input type="password" name="password" required minlength="6"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <p class="text-xs text-gray-500 mt-1">Minimum 6 characters</p>
                </div>

                <button type="submit"
                        class="w-full bg-purple-600 text-white py-2 px-4 rounded-md hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-purple-500">
                    Create Admin User
                </button>
            </form>

            <div class="mt-6 text-center">
                <a href="index.php" class="text-blue-600 hover:text-blue-800 text-sm">
                    ← Back to Main Page
                </a>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>