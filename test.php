<?php
require_once 'src/bootstrap.php';

echo "Testing DB connection...\n";

try {
    $pdo = App\Core\DB::conn();
    echo "DB connected successfully.\n";
} catch (Exception $e) {
    echo "DB connection failed: " . $e->getMessage() . "\n";
    exit(1);
}

echo "Testing User::create...\n";

$userId = App\Models\User::create([
    'name' => 'Test User',
    'email' => 'test@example.com',
    'password' => password_hash('password', PASSWORD_DEFAULT),
    'role' => 'citizen',
]);

echo "User created with ID: $userId\n";

echo "Testing Complaint::create...\n";

$complaintId = App\Models\Complaint::create([
    'user_id' => $userId,
    'title' => 'Test Complaint',
    'description' => 'Test description',
    'latitude' => 12.9716,
    'longitude' => 77.5946,
]);

echo "Complaint created with ID: $complaintId\n";

echo "Testing AIService::classify...\n";

$result = App\Services\AIService::classify('Garbage on street', 'There is garbage overflowing', 12.9716, 77.5946);

echo "AI result: " . json_encode($result) . "\n";

echo "Testing Complaint::find...\n";

$complaint = App\Models\Complaint::find($complaintId);

if ($complaint) {
    echo "Complaint found: " . $complaint['title'] . "\n";
} else {
    echo "Complaint not found\n";
}

echo "Testing Complaint::listForRole...\n";

$complaints = App\Models\Complaint::listForRole('citizen', $userId);

echo "Complaints for user: " . count($complaints) . "\n";

echo "All tests passed!\n";
