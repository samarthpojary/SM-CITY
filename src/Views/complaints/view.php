<?php $c = $complaint; ?>
<div class="bg-white rounded shadow p-6">
  <div class="flex justify-between items-start">
    <div>
      <h2 class="text-2xl font-semibold mb-1">#<?= $c['id'] ?> - <?= htmlspecialchars($c['title']) ?></h2>
      <div class="text-gray-600 mb-2"><?= htmlspecialchars($c['category']) ?> | <?= htmlspecialchars($c['priority']) ?> | <span class="font-medium"><?= htmlspecialchars($c['status']) ?></span></div>
    </div>
    <?php if ($c['image_path']): ?>
      <img src="/<?= htmlspecialchars($c['image_path']) ?>" alt="evidence" class="w-40 h-28 object-cover rounded border"/>
    <?php endif; ?>
  </div>
  <p class="mb-4 whitespace-pre-line"><?= nl2br(htmlspecialchars($c['description'])) ?></p>
  <div id="map" class="w-full h-72 rounded mb-4"></div>
  <script>
    const map = L.map('map').setView([<?= (float)$c['latitude'] ?>, <?= (float)$c['longitude'] ?>], 15);
    L.tileLayer('<?= $tileUrl ?>', { attribution: '<?= $tileAttr ?>' }).addTo(map);
    L.marker([<?= (float)$c['latitude'] ?>, <?= (float)$c['longitude'] ?>]).addTo(map);
  </script>

  <?php if (!empty($_SESSION['user']) && in_array($_SESSION['user']['role'], ['admin','officer'])): ?>
  <div class="border-t pt-4 mt-4">
    <form method="POST" action="<?= $base ?>/complaints/update-status" class="flex items-end gap-3">
      <input type="hidden" name="csrf" value="<?= csrf_token() ?>" />
      <input type="hidden" name="id" value="<?= $c['id'] ?>" />
      <div>
        <label class="block text-sm mb-1">Update Status</label>
        <select name="status" class="border rounded px-3 py-2">
          <?php foreach (['Submitted','In Progress','On Hold','Resolved','Rejected'] as $s): ?>
            <option value="<?= $s ?>" <?= $c['status']===$s?'selected':'' ?>><?= $s ?></option>
          <?php endforeach; ?>
        </select>
      </div>
      <button class="bg-indigo-600 text-white px-4 py-2 rounded" type="submit">Update</button>
    </form>

    <form method="POST" action="<?= $base ?>/complaints/resolve" enctype="multipart/form-data" class="flex items-end gap-3 mt-4">
      <input type="hidden" name="csrf" value="<?= csrf_token() ?>" />
      <input type="hidden" name="id" value="<?= $c['id'] ?>" />
      <div>
        <label class="block text-sm mb-1">Resolution Evidence</label>
        <input type="file" name="evidence" accept="image/*" />
      </div>
      <button class="bg-green-600 text-white px-4 py-2 rounded" type="submit">Mark Resolved</button>
    </form>
  </div>
  <?php endif; ?>

</div>
