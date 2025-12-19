<?php
namespace App\Controllers;

use App\Models\User;

class AuthController
{
    public function showLogin()
    {
        if (!empty($_SESSION['user'])) return redirect('/dashboard');
        $template = __DIR__ . '/../Views/auth/login.php';
        view($template, ['title' => 'Login']);
    }

    public function login()
    {
        if (!csrf_verify($_POST['csrf'] ?? '')) die('CSRF failed');
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';
        $user = User::findByEmail($email);
        if (!$user || !password_verify($password, $user['password'])) {
            $_SESSION['flash'] = 'Invalid credentials';
            return redirect('/login');
        }
        $_SESSION['user'] = [
            'id' => $user['id'],
            'name' => $user['name'],
            'email' => $user['email'],
            'role' => $user['role'],
        ];
        redirect('/dashboard');
    }

    public function showRegister()
    {
        if (!empty($_SESSION['user'])) return redirect('/dashboard');
        $template = __DIR__ . '/../Views/auth/register.php';
        view($template, ['title' => 'Register']);
    }

    public function register()
    {
        if (!csrf_verify($_POST['csrf'] ?? '')) die('CSRF failed');
        $name = trim($_POST['name'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';
        $role = 'citizen'; // Only citizens can register through public form

        if (!$name || !$email || !$password) {
            $_SESSION['flash'] = 'All fields are required';
            return redirect('/register');
        }

        if (strlen($password) < 6) {
            $_SESSION['flash'] = 'Password must be at least 6 characters long';
            return redirect('/register');
        }

        if (User::findByEmail($email)) {
            $_SESSION['flash'] = 'Email already registered';
            return redirect('/register');
        }

        $id = User::create(compact('name','email','password','role'));
        $_SESSION['user'] = ['id'=>$id,'name'=>$name,'email'=>$email,'role'=>$role];
        $_SESSION['flash'] = 'Registration successful! Welcome to the Smart City platform.';
        redirect('/dashboard');
    }

    public function logout()
    {
        session_destroy();
        redirect('/');
    }
}
