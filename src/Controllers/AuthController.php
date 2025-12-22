<?php
namespace App\Controllers;

use App\Models\User;

class AuthController
{
    public function showLogin()
    {
        $role = $_GET['role'] ?? '';
        $template = __DIR__ . '/../Views/auth/login.php';
        view($template, ['title' => 'Login', 'role' => $role]);
    }

    public function login()
    {
        if (!csrf_verify($_POST['csrf'] ?? '')) {
            $_SESSION['flash'] = 'Security check failed. Please try again.';
            return redirect('/login');
        }

        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';
        $requestedRole = $_POST['role'] ?? null;

        if (!$email || !$password) {
            $_SESSION['flash'] = 'Email and password are required';
            return redirect('/login' . ($requestedRole ? '?role=' . $requestedRole : ''));
        }

        $user = User::findByEmail($email);
        if (!$user || !password_verify($password, $user['password'])) {
            $_SESSION['flash'] = 'Invalid email or password';
            return redirect('/login' . ($requestedRole ? '?role=' . $requestedRole : ''));
        }

        // Check if user is active (you can add an 'active' field later if needed)
        if ($requestedRole && $user['role'] !== $requestedRole) {
            $_SESSION['flash'] = 'Access denied. Please use the correct login portal for your role.';
            return redirect('/login' . ($requestedRole ? '?role=' . $requestedRole : ''));
        }

        // Set session data
        $_SESSION['user'] = [
            'id' => $user['id'],
            'name' => $user['name'],
            'email' => $user['email'],
            'role' => $user['role'],
        ];

        // Regenerate session ID for security
        session_regenerate_id(true);

        // Redirect based on role
        switch ($user['role']) {
            case 'admin':
                redirect('/admin/dashboard');
                break;
            case 'authority':
                redirect('/authority/dashboard');
                break;
            case 'citizen':
            default:
                redirect('/citizen/dashboard');
                break;
        }
    }

    public function showRegister()
    {
        $template = __DIR__ . '/../Views/auth/register.php';
        view($template, ['title' => 'Register']);
    }

    public function register()
    {
        if (!csrf_verify($_POST['csrf'] ?? '')) {
            $_SESSION['flash'] = 'Security check failed. Please try again.';
            return redirect('/register');
        }

        $name = trim($_POST['name'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';
        $confirmPassword = $_POST['confirm_password'] ?? '';
        $phone = trim($_POST['phone'] ?? '');
        $address = trim($_POST['address'] ?? '');
        $role = 'citizen'; // Only citizens can register through public form

        // Validation
        if (!$name || !$email || !$password || !$confirmPassword) {
            $_SESSION['flash'] = 'All fields are required';
            return redirect('/register');
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $_SESSION['flash'] = 'Please enter a valid email address';
            return redirect('/register');
        }

        if (strlen($password) < 8) {
            $_SESSION['flash'] = 'Password must be at least 8 characters long';
            return redirect('/register');
        }

        if ($password !== $confirmPassword) {
            $_SESSION['flash'] = 'Passwords do not match';
            return redirect('/register');
        }

        if (User::findByEmail($email)) {
            $_SESSION['flash'] = 'Email already registered';
            return redirect('/register');
        }

        // Create user
        $id = User::create([
            'name' => $name,
            'email' => $email,
            'password' => $password,
            'role' => $role,
            'phone' => $phone,
            'address' => $address,
        ]);

        // Set session
        $_SESSION['user'] = [
            'id' => $id,
            'name' => $name,
            'email' => $email,
            'role' => $role,
        ];
        session_regenerate_id(true);

        $_SESSION['flash'] = 'Registration successful! Welcome to the Smart City platform.';
        redirect('/citizen/dashboard');
    }

    public function logout()
    {
        // Clear session data
        $_SESSION = [];

        // Destroy session
        if (session_id()) {
            session_destroy();
        }

        // Clear session cookie
        if (isset($_COOKIE[session_name()])) {
            setcookie(session_name(), '', time() - 3600, '/');
        }

        redirect('/');
    }
}
