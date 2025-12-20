<?php $items = $complaints ?? []; ?>
<div class="flex justify-between items-center mb-4">
  <h2 class="text-2xl font-semibold">Complaints</h2>
  <a href="<?= $base ?>/complaints/new" class="bg-blue-600 text-white px-4 py-2 rounded">New</a>
</div>
<div class="bg-white rounded shadow divide-y">
  <?php foreach ($items as $c): ?>
    <a class="block p-4 hover:bg-gray-50" href="<?= $base ?>/complaints/view?id=<?= $c['id'] ?>">
      <div class="flex justify-between items-center">
        <div>
          <div class="font-medium">#<?= $c['id'] ?> - <?= htmlspecialchars($c['title']) ?></div>
          <div class="text-sm text-gray-600"><?= htmlspecialchars($c['category']) ?> | <?= htmlspecialchars($c['priority']) ?> | <?= htmlspecialchars($c['status']) ?></div>
        </div>
        <div class="text-xs text-gray-500"><?= htmlspecialchars($c['created_at'] ?? '') ?></div>
      </div>
    </a>
  <?php endforeach; ?>
  <?php if (empty($items)): ?>
    <div class="p-4 text-gray-500">No complaints found.</div>
  <?php endif; ?>
</div>
