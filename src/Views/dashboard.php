<?php $user = $user ?? $_SESSION['user']; $items = $complaints ?? []; ?>
<h2 class="text-2xl font-semibold mb-4">Welcome, <?= htmlspecialchars($user['name']) ?> (<?= htmlspecialchars($user['role']) ?>)</h2>
<div class="grid md:grid-cols-3 gap-4 mb-6">
  <a href="/complaints/new" class="block bg-white shadow p-4 rounded hover:shadow-md">
    <div class="text-gray-500">Create</div>
    <div class="text-xl">New Complaint</div>
  </a>
  <a href="/complaints" class="block bg-white shadow p-4 rounded hover:shadow-md">
    <div class="text-gray-500">View</div>
    <div class="text-xl">My/All Complaints</div>
  </a>
  <a href="/" class="block bg-white shadow p-4 rounded hover:shadow-md">
    <div class="text-gray-500">Map</div>
    <div class="text-xl">City Map</div>
  </a>
</div>
<div class="bg-white rounded shadow">
  <div class="p-4 border-b font-semibold">Recent Complaints</div>
  <div class="divide-y">
  <?php foreach ($items as $c): ?>
    <a class="block p-4 hover:bg-gray-50" href="/complaints/view?id=<?= $c['id'] ?>">
      <div class="font-medium">#<?= $c['id'] ?> - <?= htmlspecialchars($c['title']) ?></div>
      <div class="text-sm text-gray-600"><?= htmlspecialchars($c['category']) ?> | <?= htmlspecialchars($c['priority']) ?> | <?= htmlspecialchars($c['status']) ?></div>
    </a>
  <?php endforeach; ?>
  <?php if (empty($items)): ?>
    <div class="p-4 text-gray-500">No complaints yet.</div>
  <?php endif; ?>
  </div>
</div>
