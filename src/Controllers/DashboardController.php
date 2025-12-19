<?php
namespace App\Controllers;

use App\Models\Complaint;

class DashboardController
{
    public function landing()
    {
        $template = __DIR__ . '/../Views/landing.php';
        $markers = Complaint::recent(50);
        view($template, ['title' => 'Smart City', 'markers' => $markers]);
    }

    public function index()
    {
        if (empty($_SESSION['user'])) return redirect('/login');
        $template = __DIR__ . '/../Views/dashboard.php';
        $user = $_SESSION['user'];
        $complaints = Complaint::listForRole($user['role'], $user['id']);
        $stats = ($user['role'] === 'admin') ? Complaint::stats() : null;
        view($template, ['title' => 'Dashboard', 'user' => $user, 'complaints' => $complaints, 'stats' => $stats]);
    }
}
