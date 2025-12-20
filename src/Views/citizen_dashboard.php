<?php $user = $user ?? $_SESSION['user']; $newComplaints = $newComplaints ?? []; $allComplaints = $allComplaints ?? []; ?>
<div class="flex justify-between items-center mb-6">
  <h2 class="text-2xl font-semibold">Citizen Dashboard - Welcome, <?= htmlspecialchars($user['name']) ?></h2>
  <div class="space-x-4">
    <a href="<?= $base ?>/profile" class="bg-blue-600 text-white px-4 py-2 rounded">Profile</a>
    <a href="<?= $base ?>/logout" class="bg-red-600 text-white px-4 py-2 rounded">Logout</a>
  </div>
</div>

<div class="grid md:grid-cols-3 gap-4 mb-6">
  <a href="<?= $base ?>/complaints/new" class="block bg-white shadow p-4 rounded hover:shadow-md">
    <div class="text-gray-500">Create</div>
    <div class="text-xl">New Complaint</div>
  </a>
  <a href="<?= $base ?>/complaints" class="block bg-white shadow p-4 rounded hover:shadow-md">
    <div class="text-gray-500">Track</div>
    <div class="text-xl">Track Complaints</div>
  </a>
  <a href="<?= $base ?>/" class="block bg-white shadow p-4 rounded hover:shadow-md">
    <div class="text-gray-500">Map</div>
    <div class="text-xl">City Map</div>
  </a>
</div>

<div class="grid md:grid-cols-2 gap-6">
  <div class="bg-white rounded shadow p-4">
    <h3 class="text-lg font-semibold mb-4">New Complaints</h3>
    <?php if (empty($newComplaints)): ?>
      <p class="text-gray-500">No new complaints.</p>
    <?php else: ?>
      <div class="space-y-2">
        <?php foreach ($newComplaints as $c): ?>
          <a href="<?= $base ?>/complaints/view?id=<?= $c['id'] ?>" class="block p-2 border rounded hover:bg-gray-50">
            <div class="font-medium">#<?= $c['id'] ?> - <?= htmlspecialchars($c['title']) ?></div>
            <div class="text-sm text-gray-600">Status: <?= htmlspecialchars($c['status']) ?></div>
          </a>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>
  </div>

  <div class="bg-white rounded shadow p-4">
    <h3 class="text-lg font-semibold mb-4">All Complaints</h3>
    <?php if (empty($allComplaints)): ?>
      <p class="text-gray-500">No complaints yet.</p>
    <?php else: ?>
      <div class="space-y-2">
        <?php foreach ($allComplaints as $c): ?>
          <a href="<?= $base ?>/complaints/view?id=<?= $c['id'] ?>" class="block p-2 border rounded hover:bg-gray-50">
            <div class="font-medium">#<?= $c['id'] ?> - <?= htmlspecialchars($c['title']) ?></div>
            <div class="text-sm text-gray-600">Status: <?= htmlspecialchars($c['status']) ?> | Priority: <?= htmlspecialchars($c['priority']) ?></div>
          </a>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>
  </div>
</div>