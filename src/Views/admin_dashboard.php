<?php $user = $user ?? $_SESSION['user']; $stats = $stats ?? []; $users = $users ?? []; $authorities = $authorities ?? []; $allComplaints = $allComplaints ?? []; ?>
<div class="flex justify-between items-center mb-6">
  <h2 class="text-2xl font-semibold">Admin Dashboard - Welcome, <?= htmlspecialchars($user['name']) ?></h2>
  <div class="space-x-4">
    <a href="<?= $base ?>/profile" class="bg-blue-600 text-white px-4 py-2 rounded">Profile</a>
    <a href="<?= $base ?>/logout" class="bg-red-600 text-white px-4 py-2 rounded">Logout</a>
  </div>
</div>

<!-- Analytics -->
<div class="grid md:grid-cols-4 gap-4 mb-6">
  <div class="bg-white shadow p-4 rounded">
    <div class="text-gray-500">Total Complaints</div>
    <div class="text-2xl font-bold"><?= $stats['total'] ?? 0 ?></div>
  </div>
  <div class="bg-white shadow p-4 rounded">
    <div class="text-gray-500">Solved</div>
    <div class="text-2xl font-bold text-green-600"><?= $stats['status']['Resolved'] ?? 0 ?></div>
  </div>
  <div class="bg-white shadow p-4 rounded">
    <div class="text-gray-500">Not Solved</div>
    <div class="text-2xl font-bold text-red-600"><?= ($stats['total'] ?? 0) - ($stats['status']['Resolved'] ?? 0) ?></div>
  </div>
  <div class="bg-white shadow p-4 rounded">
    <div class="text-gray-500">High Priority</div>
    <div class="text-2xl font-bold text-orange-600"><?= $stats['priority']['High'] ?? 0 ?></div>
  </div>
</div>

<div class="grid md:grid-cols-3 gap-4 mb-6">
  <div class="bg-white shadow p-4 rounded">
    <div class="text-gray-500">Citizens</div>
    <div class="text-2xl font-bold text-blue-600"><?= $stats['users']['citizen'] ?? 0 ?></div>
  </div>
  <div class="bg-white shadow p-4 rounded">
    <div class="text-gray-500">Authorities</div>
    <div class="text-2xl font-bold text-green-600"><?= $stats['users']['authority'] ?? 0 ?></div>
  </div>
  <div class="bg-white shadow p-4 rounded">
    <div class="text-gray-500">Admins</div>
    <div class="text-2xl font-bold text-purple-600"><?= $stats['users']['admin'] ?? 0 ?></div>
  </div>
</div>

<!-- Users Management -->
<div class="bg-white rounded shadow p-4 mb-6">
  <h3 class="text-lg font-semibold mb-4">All Users</h3>
  <div class="overflow-x-auto">
    <table class="w-full text-sm">
      <thead>
        <tr class="border-b">
          <th class="text-left p-2">ID</th>
          <th class="text-left p-2">Name</th>
          <th class="text-left p-2">Email</th>
          <th class="text-left p-2">Role</th>
          <th class="text-left p-2">Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($users as $u): ?>
          <tr class="border-b">
            <td class="p-2"><?= $u['id'] ?></td>
            <td class="p-2"><?= htmlspecialchars($u['name']) ?></td>
            <td class="p-2"><?= htmlspecialchars($u['email']) ?></td>
            <td class="p-2"><?= htmlspecialchars($u['role']) ?></td>
            <td class="p-2 space-x-2">
              <a href="<?= $base ?>/admin/edit-user?id=<?= $u['id'] ?>" class="text-blue-600 hover:underline">Edit</a>
              <a href="<?= $base ?>/admin/delete-user?id=<?= $u['id'] ?>" class="text-red-600 hover:underline" onclick="return confirm('Delete user?')">Delete</a>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>

<!-- Authorities Management -->
<div class="bg-white rounded shadow p-4 mb-6">
  <h3 class="text-lg font-semibold mb-4">All Authorities</h3>
  <div class="overflow-x-auto">
    <table class="w-full text-sm">
      <thead>
        <tr class="border-b">
          <th class="text-left p-2">ID</th>
          <th class="text-left p-2">Name</th>
          <th class="text-left p-2">Email</th>
          <th class="text-left p-2">Role</th>
          <th class="text-left p-2">Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($authorities as $a): ?>
          <tr class="border-b">
            <td class="p-2"><?= $a['id'] ?></td>
            <td class="p-2"><?= htmlspecialchars($a['name']) ?></td>
            <td class="p-2"><?= htmlspecialchars($a['email']) ?></td>
            <td class="p-2"><?= htmlspecialchars($a['role']) ?></td>
            <td class="p-2 space-x-2">
              <a href="<?= $base ?>/admin/edit-user?id=<?= $a['id'] ?>" class="text-blue-600 hover:underline">Edit</a>
              <a href="<?= $base ?>/admin/delete-user?id=<?= $a['id'] ?>" class="text-red-600 hover:underline" onclick="return confirm('Delete authority?')">Delete</a>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>

<!-- All Complaints -->
<div class="bg-white rounded shadow p-4">
  <h3 class="text-lg font-semibold mb-4">All Complaints</h3>
  <div class="overflow-x-auto">
    <table class="w-full text-sm">
      <thead>
        <tr class="border-b">
          <th class="text-left p-2">ID</th>
          <th class="text-left p-2">Title</th>
          <th class="text-left p-2">User</th>
          <th class="text-left p-2">Status</th>
          <th class="text-left p-2">Priority</th>
          <th class="text-left p-2">Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($allComplaints as $c): ?>
          <tr class="border-b">
            <td class="p-2">#<?= $c['id'] ?></td>
            <td class="p-2"><?= htmlspecialchars($c['title']) ?></td>
            <td class="p-2"><?= htmlspecialchars($c['user_name'] ?? 'Unknown') ?></td>
            <td class="p-2"><?= htmlspecialchars($c['status']) ?></td>
            <td class="p-2"><?= htmlspecialchars($c['priority']) ?></td>
            <td class="p-2">
              <a href="<?= $base ?>/complaints/view?id=<?= $c['id'] ?>" class="text-blue-600 hover:underline">View</a>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>