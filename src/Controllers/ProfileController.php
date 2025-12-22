<?php
namespace App\Controllers;

use App\Models\User;

class ProfileController
{
    public function show()
    {
        $this->ensureAuth();
        $user = $_SESSION['user'];
        $userData = User::find($user['id']);
        $template = __DIR__ . '/../Views/profile.php';
        view($template, ['title' => 'Profile', 'user' => $userData]);
    }

    public function update()
    {
        $this->ensureAuth();
        if (!csrf_verify($_POST['csrf'] ?? '')) die('CSRF failed');

        $name = trim($_POST['name'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $phone = trim($_POST['phone'] ?? '');
        $address = trim($_POST['address'] ?? '');

        if (!$name || !$email) {
            $_SESSION['flash'] = 'Name and email are required';
            return redirect('/profile');
        }

        $user = $_SESSION['user'];
        $updateData = [
            'name' => $name,
            'email' => $email,
            'phone' => $phone,
            'address' => $address,
        ];

        if (User::update($user['id'], $updateData)) {
            $_SESSION['user']['name'] = $name;
            $_SESSION['user']['email'] = $email;
            $_SESSION['flash'] = 'Profile updated successfully';
        } else {
            $_SESSION['flash'] = 'Failed to update profile';
        }

        redirect('/profile');
    }

    private function ensureAuth()
    {
        if (empty($_SESSION['user'])) redirect('/login');
    }
}
