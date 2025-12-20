<?php $user = $user ?? $_SESSION['user']; $newComplaints = $newComplaints ?? []; $solvedComplaints = $solvedComplaints ?? []; $pendingComplaints = $pendingComplaints ?? []; ?>
<div class="flex justify-between items-center mb-6">
  <h2 class="text-2xl font-semibold">Authority Dashboard - Welcome, <?= htmlspecialchars($user['name']) ?></h2>
  <div class="space-x-4">
    <a href="<?= $base ?>/profile" class="bg-blue-600 text-white px-4 py-2 rounded">Profile</a>
    <a href="<?= $base ?>/logout" class="bg-red-600 text-white px-4 py-2 rounded">Logout</a>
  </div>
</div>

<div class="grid md:grid-cols-3 gap-6 mb-6">
  <div class="bg-white rounded shadow p-4">
    <h3 class="text-lg font-semibold mb-4">New Complaints</h3>
    <?php if (empty($newComplaints)): ?>
      <p class="text-gray-500">No new complaints.</p>
    <?php else: ?>
      <div class="space-y-2">
        <?php foreach ($newComplaints as $c): ?>
          <a href="<?= $base ?>/complaints/view?id=<?= $c['id'] ?>" class="block p-2 border rounded hover:bg-gray-50">
            <div class="font-medium">#<?= $c['id'] ?> - <?= htmlspecialchars($c['title']) ?></div>
            <div class="text-sm text-gray-600">Priority: <?= htmlspecialchars($c['priority']) ?></div>
          </a>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>
  </div>

  <div class="bg-white rounded shadow p-4">
    <h3 class="text-lg font-semibold mb-4">Solved Complaints</h3>
    <?php if (empty($solvedComplaints)): ?>
      <p class="text-gray-500">No solved complaints.</p>
    <?php else: ?>
      <div class="space-y-2">
        <?php foreach ($solvedComplaints as $c): ?>
          <a href="<?= $base ?>/complaints/view?id=<?= $c['id'] ?>" class="block p-2 border rounded hover:bg-gray-50">
            <div class="font-medium">#<?= $c['id'] ?> - <?= htmlspecialchars($c['title']) ?></div>
            <div class="text-sm text-gray-600">Resolved: <?= htmlspecialchars($c['resolved_at'] ?? 'N/A') ?></div>
          </a>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>
  </div>

  <div class="bg-white rounded shadow p-4">
    <h3 class="text-lg font-semibold mb-4">Pending Complaints</h3>
    <?php if (empty($pendingComplaints)): ?>
      <p class="text-gray-500">No pending complaints.</p>
    <?php else: ?>
      <div class="space-y-2">
        <?php foreach ($pendingComplaints as $c): ?>
          <a href="<?= $base ?>/complaints/view?id=<?= $c['id'] ?>" class="block p-2 border rounded hover:bg-gray-50">
            <div class="font-medium">#<?= $c['id'] ?> - <?= htmlspecialchars($c['title']) ?></div>
            <div class="text-sm text-gray-600">Status: <?= htmlspecialchars($c['status']) ?> | Priority: <?= htmlspecialchars($c['priority']) ?></div>
          </a>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>
  </div>
</div>

<div class="bg-white rounded shadow p-4">
  <h3 class="text-lg font-semibold mb-4">All Complaints</h3>
  <div class="overflow-x-auto">
    <table class="w-full text-sm">
      <thead>
        <tr class="border-b">
          <th class="text-left p-2">ID</th>
          <th class="text-left p-2">Title</th>
          <th class="text-left p-2">Status</th>
          <th class="text-left p-2">Priority</th>
          <th class="text-left p-2">Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach (array_merge($newComplaints, $solvedComplaints, $pendingComplaints) as $c): ?>
          <tr class="border-b">
            <td class="p-2">#<?= $c['id'] ?></td>
            <td class="p-2"><?= htmlspecialchars($c['title']) ?></td>
            <td class="p-2"><?= htmlspecialchars($c['status']) ?></td>
            <td class="p-2"><?= htmlspecialchars($c['priority']) ?></td>
      <td class="p-2">
        <a href="<?= $base ?>/complaints/view?id=<?= $c['id'] ?>" class="text-blue-600 hover:underline">View</a>
        <form method="POST" action="<?= $base ?>/complaints/update-status" class="inline ml-2">
          <input type="hidden" name="csrf" value="<?= csrf_token() ?>" />
          <input type="hidden" name="id" value="<?= $c['id'] ?>" />
          <select name="status" class="border rounded px-2 py-1 text-sm">
            <?php foreach (['Submitted','In Progress','On Hold','Resolved','Rejected'] as $s): ?>
              <option value="<?= $s ?>" <?= $c['status']===$s?'selected':'' ?>><?= $s ?></option>
            <?php endforeach; ?>
          </select>
          <button type="submit" class="bg-blue-600 text-white px-2 py-1 rounded text-sm ml-1">Update</button>
        </form>
      </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>