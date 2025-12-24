<?php
namespace App\Controllers;

use App\Models\Complaint;
use App\Models\User;

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
        $user = $_SESSION['user'];
        if ($user['role'] === 'admin') {
            return $this->adminDashboard();
        } elseif ($user['role'] === 'authority') {
            return $this->authorityDashboard();
        } else {
            return $this->citizenDashboard();
        }
    }

    public function adminDashboard()
    {
        if (empty($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') return redirect('/login');
        $template = __DIR__ . '/../Views/admin_dashboard.php';
        $user = $_SESSION['user'];
        $stats = Complaint::stats();
        $users = User::allByRole('citizen');
        $authorities = User::allByRole(['authority', 'admin']);
        $allComplaints = Complaint::allWithUsers();
        $allFeedback = Complaint::getAllFeedback();
        view($template, ['title' => 'Admin Dashboard', 'user' => $user, 'stats' => $stats, 'users' => $users, 'authorities' => $authorities, 'allComplaints' => $allComplaints, 'allFeedback' => $allFeedback], 'dashboard_layout.php');
    }

    public function authorityDashboard()
    {
        if (empty($_SESSION['user']) || $_SESSION['user']['role'] !== 'authority') return redirect('/login');
        $template = __DIR__ . '/../Views/officer_dashboard.php';
        $user = $_SESSION['user'];
        $complaints = Complaint::listForRole($user['role'], $user['id']);
        $newComplaints = array_filter($complaints, fn($c) => $c['status'] === 'Submitted');
        $solvedComplaints = array_filter($complaints, fn($c) => $c['status'] === 'Resolved');
        $pendingComplaints = array_filter($complaints, fn($c) => in_array($c['status'], ['In Progress', 'On Hold']));
        view($template, ['title' => 'Authority Dashboard', 'user' => $user, 'newComplaints' => $newComplaints, 'solvedComplaints' => $solvedComplaints, 'pendingComplaints' => $pendingComplaints], 'dashboard_layout.php');
    }

    public function citizenDashboard()
    {
        if (empty($_SESSION['user']) || $_SESSION['user']['role'] !== 'citizen') return redirect('/login');
        $template = __DIR__ . '/../Views/citizen_dashboard.php';
        $user = $_SESSION['user'];
        $complaints = Complaint::listForRole($user['role'], $user['id']);
        $newComplaints = array_filter($complaints, fn($c) => $c['status'] === 'Submitted');
        $allComplaints = $complaints;
        view($template, ['title' => 'Citizen Dashboard', 'user' => $user, 'newComplaints' => $newComplaints, 'allComplaints' => $allComplaints], 'dashboard_layout.php');
    }
}
