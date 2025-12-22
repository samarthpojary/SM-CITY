<?php
use App\Models\Complaint;
$c = $complaint;
$feedback = Complaint::getFeedback($c['id']);
$logs = Complaint::getLogs($c['id']);
$user = $_SESSION['user'] ?? null;
?>
<div class="bg-white rounded shadow p-6">
  <div class="flex justify-between items-start">
    <div>
      <h2 class="text-2xl font-semibold mb-1">#<?= $c['id'] ?> - <?= htmlspecialchars($c['title']) ?></h2>
      <div class="text-gray-600 mb-2">
        <?= htmlspecialchars($c['category']) ?> | <?= htmlspecialchars($c['priority']) ?> |
        <span class="font-medium
          <?php if ($c['status'] === 'Resolved') echo 'text-green-600';
                elseif ($c['status'] === 'Rejected') echo 'text-red-600';
                elseif ($c['status'] === 'In Progress') echo 'text-blue-600';
                else echo 'text-gray-600'; ?>">
          <?= htmlspecialchars($c['status']) ?>
        </span>
      </div>
      <div class="text-sm text-gray-500">
        Submitted by: <?= htmlspecialchars($c['user_name']) ?> |
        <?php if ($c['authority_name']): ?>
          Assigned to: <?= htmlspecialchars($c['authority_name']) ?>
        <?php else: ?>
          Not assigned
        <?php endif; ?>
      </div>
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

  <!-- Resolution Evidence -->
  <?php if ($c['resolution_proof']): ?>
    <div class="mb-4">
      <h3 class="font-semibold mb-2">Resolution Evidence</h3>
      <img src="/<?= htmlspecialchars($c['resolution_proof']) ?>" alt="resolution evidence" class="w-40 h-28 object-cover rounded border"/>
    </div>
  <?php endif; ?>

  <!-- Admin Actions -->
  <?php if ($user && $user['role'] === 'admin'): ?>
  <div class="border-t pt-4 mt-4">
    <h3 class="font-semibold mb-3">Admin Actions</h3>

    <!-- Authority Assignment -->
    <form method="POST" action="<?= $base ?>/complaints/assign-authority" class="flex items-end gap-3 mb-4">
      <input type="hidden" name="csrf" value="<?= csrf_token() ?>" />
      <input type="hidden" name="complaint_id" value="<?= $c['id'] ?>" />
      <div>
        <label class="block text-sm mb-1">Assign to Authority</label>
        <select name="authority_id" class="border rounded px-3 py-2">
          <option value="">Select Authority</option>
          <?php
          $authorities = \App\Models\User::allByRole('authority');
          foreach ($authorities as $auth): ?>
            <option value="<?= $auth['id'] ?>" <?= ($c['assigned_authority_id'] == $auth['id']) ? 'selected' : '' ?>>
              <?= htmlspecialchars($auth['name']) ?> (<?= htmlspecialchars($auth['email']) ?>)
            </option>
          <?php endforeach; ?>
        </select>
      </div>
      <button class="bg-purple-600 text-white px-4 py-2 rounded" type="submit">Assign</button>
    </form>
  </div>
  <?php endif; ?>

  <!-- Authority Actions -->
  <?php if ($user && $user['role'] === 'authority' && $c['assigned_authority_id'] == $user['id']): ?>
  <div class="border-t pt-4 mt-4">
    <h3 class="font-semibold mb-3">Authority Actions</h3>

    <form method="POST" action="<?= $base ?>/complaints/update-status" class="flex items-end gap-3 mb-4">
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

    <form method="POST" action="<?= $base ?>/complaints/resolve" enctype="multipart/form-data" class="flex items-end gap-3">
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

  <!-- Feedback Section -->
  <?php if ($c['status'] === 'Resolved'): ?>
  <div class="border-t pt-4 mt-4">
    <h3 class="font-semibold mb-3">Feedback</h3>

    <?php if (!empty($feedback)): ?>
      <div class="space-y-3 mb-4">
        <?php foreach ($feedback as $f): ?>
          <div class="bg-gray-50 p-3 rounded">
            <div class="flex items-center justify-between">
              <span class="font-medium"><?= htmlspecialchars($f['user_name']) ?></span>
              <div class="flex items-center">
                <?php for ($i = 1; $i <= 5; $i++): ?>
                  <span class="<?= $i <= $f['rating'] ? 'text-yellow-400' : 'text-gray-300' ?>">★</span>
                <?php endfor; ?>
              </div>
            </div>
            <?php if ($f['comment']): ?>
              <p class="text-gray-700 mt-1"><?= nl2br(htmlspecialchars($f['comment'])) ?></p>
            <?php endif; ?>
            <div class="text-xs text-gray-500 mt-1">
              <?= date('M j, Y g:i A', strtotime($f['created_at'])) ?>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>

    <!-- Feedback Form for Citizens -->
    <?php if ($user && $user['role'] === 'citizen' && $c['user_id'] == $user['id']): ?>
      <?php
      $userFeedback = array_filter($feedback, fn($f) => $f['user_id'] == $user['id']);
      if (empty($userFeedback)):
      ?>
        <form method="POST" action="<?= $base ?>/complaints/add-feedback" class="bg-blue-50 p-4 rounded">
          <input type="hidden" name="csrf" value="<?= csrf_token() ?>" />
          <input type="hidden" name="complaint_id" value="<?= $c['id'] ?>" />
          <h4 class="font-medium mb-2">Share your feedback</h4>
          <div class="mb-3">
            <label class="block text-sm mb-1">Rating</label>
            <select name="rating" class="border rounded px-3 py-2" required>
              <option value="">Select rating</option>
              <option value="5">5 - Excellent</option>
              <option value="4">4 - Very Good</option>
              <option value="3">3 - Good</option>
              <option value="2">2 - Fair</option>
              <option value="1">1 - Poor</option>
            </select>
          </div>
          <div class="mb-3">
            <label class="block text-sm mb-1">Comments (optional)</label>
            <textarea name="comment" rows="3" class="w-full border rounded px-3 py-2"></textarea>
          </div>
          <button class="bg-blue-600 text-white px-4 py-2 rounded" type="submit">Submit Feedback</button>
        </form>
      <?php else: ?>
        <p class="text-green-600">✓ You have already submitted feedback for this complaint.</p>
      <?php endif; ?>
    <?php endif; ?>
  </div>
  <?php endif; ?>

  <!-- Activity Log -->
  <?php if (!empty($logs)): ?>
  <div class="border-t pt-4 mt-4">
    <h3 class="font-semibold mb-3">Activity Log</h3>
    <div class="space-y-2">
      <?php foreach ($logs as $log): ?>
        <div class="text-sm text-gray-600">
          <span class="font-medium"><?= htmlspecialchars($log['user_name']) ?></span>
          <?php if ($log['action'] === 'status_change'): ?>
            changed status from "<?= htmlspecialchars($log['old_status']) ?>" to "<?= htmlspecialchars($log['new_status']) ?>"
          <?php elseif ($log['action'] === 'assigned'): ?>
            assigned the complaint
          <?php elseif ($log['action'] === 'resolved'): ?>
            resolved the complaint
          <?php else: ?>
            performed action: <?= htmlspecialchars($log['action']) ?>
          <?php endif; ?>
          <?php if ($log['notes']): ?>
            <span class="text-gray-500">(<?= htmlspecialchars($log['notes']) ?>)</span>
          <?php endif; ?>
          <span class="text-gray-400">- <?= date('M j, Y g:i A', strtotime($log['created_at'])) ?></span>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
  <?php endif; ?>

</div>
