<?php
namespace App\Controllers;

use App\Models\Complaint;
use App\Services\AIService;

class ComplaintController
{
    public function create()
    {
        $this->ensureAuth();
        $template = __DIR__ . '/../Views/complaints/create.php';
        view($template, ['title' => 'New Complaint']);
    }

    public function store()
    {
        $this->ensureAuth();
        if (!csrf_verify($_POST['csrf'] ?? '')) die('CSRF failed');
        $title = trim($_POST['title'] ?? '');
        $description = trim($_POST['description'] ?? '');
        $latitude = (float)($_POST['latitude'] ?? 0);
        $longitude = (float)($_POST['longitude'] ?? 0);

        if (!$title || !$description || !$latitude || !$longitude) {
            $_SESSION['flash'] = 'All fields including location are required';
            return redirect('/complaints/new');
        }

        // Handle file upload
        $imagePath = null;
        if (!empty($_FILES['image']['name'])) {
            $uploadDir = __DIR__ . '/../../' . env('UPLOAD_DIR');
            if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);
            $maxBytes = (int)env('MAX_UPLOAD_MB', 10) * 1024 * 1024;
            if ($_FILES['image']['size'] > $maxBytes) {
                $_SESSION['flash'] = 'Image too large';
                return redirect('/complaints/new');
            }
            $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
            $safe = 'c_' . time() . '_' . bin2hex(random_bytes(4)) . '.' . $ext;
            $target = $uploadDir . '/' . $safe;
            if (!move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
                $_SESSION['flash'] = 'Upload failed';
                return redirect('/complaints/new');
            }
            $imagePath = env('UPLOAD_DIR') . '/' . $safe;
        }

        // AI classification
        $ai = AIService::classify($title, $description, $latitude, $longitude);

        $id = Complaint::create([
            'user_id' => $_SESSION['user']['id'],
            'title' => $title,
            'description' => $description,
            'category' => $ai['category'],
            'priority' => $ai['priority'],
            'latitude' => $latitude,
            'longitude' => $longitude,
            'image_path' => $imagePath,
        ]);

        $message = 'Complaint submitted successfully';
        if ($ai['duplicate']) {
            $message .= ' (Note: Similar complaints exist in this area)';
        }
        $_SESSION['flash'] = $message;
        redirect('/complaints/view?id=' . $id);
    }

    public function list()
    {
        $this->ensureAuth();
        $user = $_SESSION['user'];
        $complaints = Complaint::listForRole($user['role'], $user['id']);
        $template = __DIR__ . '/../Views/complaints/list.php';
        view($template, ['title' => 'Complaints', 'complaints' => $complaints]);
    }

    public function view()
    {
        $this->ensureAuth();
        $id = (int)($_GET['id'] ?? 0);
        $complaint = Complaint::find($id);
        if (!$complaint) return redirect('/complaints');
        $template = __DIR__ . '/../Views/complaints/view.php';
        view($template, ['title' => 'Complaint #' . $id, 'complaint' => $complaint]);
    }

    public function updateStatus()
    {
        $this->ensureAuth(['admin','officer']);
        if (!csrf_verify($_POST['csrf'] ?? '')) die('CSRF failed');
        $id = (int)($_POST['id'] ?? 0);
        $status = $_POST['status'] ?? '';
        if ($id && $status) Complaint::updateStatus($id, $status);
        redirect('/complaints/view?id=' . $id);
    }

    public function resolve()
    {
        $this->ensureAuth(['admin','officer']);
        if (!csrf_verify($_POST['csrf'] ?? '')) die('CSRF failed');
        $id = (int)($_POST['id'] ?? 0);
        if (!$id) return redirect('/complaints');

        $evidencePath = null;
        if (!empty($_FILES['evidence']['name'])) {
            $uploadDir = __DIR__ . '/../../' . env('UPLOAD_DIR');
            if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);
            $ext = pathinfo($_FILES['evidence']['name'], PATHINFO_EXTENSION);
            $safe = 'r_' . time() . '_' . bin2hex(random_bytes(4)) . '.' . $ext;
            $target = $uploadDir . '/' . $safe;
            if (!move_uploaded_file($_FILES['evidence']['tmp_name'], $target)) {
                $_SESSION['flash'] = 'Evidence upload failed';
                return redirect('/complaints/view?id=' . $id);
            }
            $evidencePath = env('UPLOAD_DIR') . '/' . $safe;
        }
        Complaint::resolve($id, $evidencePath);
        redirect('/complaints/view?id=' . $id);
    }

    private function ensureAuth(array $roles = [])
    {
        if (empty($_SESSION['user'])) redirect('/login');
        if ($roles) {
            if (!in_array($_SESSION['user']['role'], $roles)) redirect('/dashboard');
        }
    }
}
