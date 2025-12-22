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
        $this->ensureAuth(['admin','authority']);
        if (!csrf_verify($_POST['csrf'] ?? '')) {
            $_SESSION['flash'] = 'Security check failed.';
            return redirect('/complaints');
        }

        $id = (int)($_POST['id'] ?? 0);
        $status = $_POST['status'] ?? '';

        if (!$id || !$status) {
            $_SESSION['flash'] = 'Invalid request data.';
            return redirect('/complaints');
        }

        $complaint = Complaint::find($id);
        if (!$complaint) {
            $_SESSION['flash'] = 'Complaint not found.';
            return redirect('/complaints');
        }

        // Check if authority is assigned to this complaint or if admin
        $user = $_SESSION['user'];
        if ($user['role'] === 'authority' && $complaint['assigned_authority_id'] != $user['id']) {
            $_SESSION['flash'] = 'You are not authorized to update this complaint.';
            return redirect('/complaints/view?id=' . $id);
        }

        if (Complaint::updateStatus($id, $status, $user['id'])) {
            $_SESSION['flash'] = 'Complaint status updated successfully.';
        } else {
            $_SESSION['flash'] = 'Failed to update complaint status.';
        }

        redirect('/complaints/view?id=' . $id);
    }

    public function resolve()
    {
        $this->ensureAuth(['admin','authority']);
        if (!csrf_verify($_POST['csrf'] ?? '')) {
            $_SESSION['flash'] = 'Security check failed.';
            return redirect('/complaints');
        }

        $id = (int)($_POST['id'] ?? 0);
        $evidencePath = null;

        if (!$id) {
            $_SESSION['flash'] = 'Invalid complaint ID.';
            return redirect('/complaints');
        }

        $complaint = Complaint::find($id);
        if (!$complaint) {
            $_SESSION['flash'] = 'Complaint not found.';
            return redirect('/complaints');
        }

        // Check authorization
        $user = $_SESSION['user'];
        if ($user['role'] === 'authority' && $complaint['assigned_authority_id'] != $user['id']) {
            $_SESSION['flash'] = 'You are not authorized to resolve this complaint.';
            return redirect('/complaints/view?id=' . $id);
        }

        // Handle file upload for evidence
        if (isset($_FILES['evidence']) && $_FILES['evidence']['error'] === UPLOAD_ERR_OK) {
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

        if (Complaint::resolve($id, $evidencePath, $user['id'])) {
            $_SESSION['flash'] = 'Complaint resolved successfully.';
        } else {
            $_SESSION['flash'] = 'Failed to resolve complaint.';
        }

        redirect('/complaints/view?id=' . $id);
    }

    public function assignAuthority()
    {
        $this->ensureAuth(['admin']);
        if (!csrf_verify($_POST['csrf'] ?? '')) {
            $_SESSION['flash'] = 'Security check failed.';
            return redirect('/complaints');
        }

        $id = (int)($_POST['complaint_id'] ?? 0);
        $authorityId = (int)($_POST['authority_id'] ?? 0);

        if (!$id || !$authorityId) {
            $_SESSION['flash'] = 'Invalid request data.';
            return redirect('/complaints');
        }

        $user = $_SESSION['user'];
        if (Complaint::assignToAuthority($id, $authorityId, $user['id'])) {
            $_SESSION['flash'] = 'Complaint assigned to authority successfully.';
        } else {
            $_SESSION['flash'] = 'Failed to assign complaint.';
        }

        redirect('/complaints/view?id=' . $id);
    }

    public function addFeedback()
    {
        $this->ensureAuth(['citizen']);
        if (!csrf_verify($_POST['csrf'] ?? '')) {
            $_SESSION['flash'] = 'Security check failed.';
            return redirect('/complaints');
        }

        $complaintId = (int)($_POST['complaint_id'] ?? 0);
        $rating = (int)($_POST['rating'] ?? 0);
        $comment = trim($_POST['comment'] ?? '');

        if (!$complaintId || $rating < 1 || $rating > 5) {
            $_SESSION['flash'] = 'Invalid feedback data.';
            return redirect('/complaints/view?id=' . $complaintId);
        }

        $complaint = Complaint::find($complaintId);
        if (!$complaint) {
            $_SESSION['flash'] = 'Complaint not found.';
            return redirect('/complaints');
        }

        // Check if user owns this complaint and it's resolved
        $user = $_SESSION['user'];
        if ($complaint['user_id'] != $user['id']) {
            $_SESSION['flash'] = 'You can only provide feedback on your own complaints.';
            return redirect('/complaints/view?id=' . $complaintId);
        }

        if ($complaint['status'] !== 'Resolved') {
            $_SESSION['flash'] = 'You can only provide feedback on resolved complaints.';
            return redirect('/complaints/view?id=' . $complaintId);
        }

        // Check if feedback already exists
        $existingFeedback = Complaint::getFeedback($complaintId);
        $userFeedback = array_filter($existingFeedback, fn($f) => $f['user_id'] == $user['id']);
        if (!empty($userFeedback)) {
            $_SESSION['flash'] = 'You have already provided feedback for this complaint.';
            return redirect('/complaints/view?id=' . $complaintId);
        }

        Complaint::addFeedback($complaintId, $user['id'], $rating, $comment ?: null);
        $_SESSION['flash'] = 'Thank you for your feedback!';

        redirect('/complaints/view?id=' . $complaintId);
    }

    private function ensureAuth(array $roles = [])
    {
        if (empty($_SESSION['user'])) redirect('/login');
        if ($roles) {
            if (!in_array($_SESSION['user']['role'], $roles)) redirect('/dashboard');
        }
    }
}
