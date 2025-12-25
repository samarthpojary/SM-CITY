<?php
use App\Models\Complaint;
$c = $complaint;
$feedback = Complaint::getFeedback($c['id']);
$logs = Complaint::getLogs($c['id']);
$user = $_SESSION['user'] ?? null;
?>
<div class="mb-6">
  <a href="javascript:history.back()" class="inline-flex items-center px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg transition-colors duration-200">
    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
    </svg>
    Back
  </a>
</div>
<div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-8">
  <!-- Tab Navigation -->
  <div class="mb-6">
    <div class="border-b border-gray-200">
      <nav class="-mb-px flex space-x-8">
        <button class="tab-button border-b-2 border-blue-500 py-2 px-1 text-sm font-medium text-blue-600" data-tab="overview">Overview</button>
        <button class="tab-button border-b-2 border-transparent py-2 px-1 text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300" data-tab="details">Details</button>
        <button class="tab-button border-b-2 border-transparent py-2 px-1 text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300" data-tab="actions">Actions</button>
        <?php if ($c['status'] === 'Resolved'): ?>
          <button class="tab-button border-b-2 border-transparent py-2 px-1 text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300" data-tab="feedback">Feedback</button>
        <?php endif; ?>
        <?php if (!empty($logs)): ?>
          <button class="tab-button border-b-2 border-transparent py-2 px-1 text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300" data-tab="logs">Activity Log</button>
        <?php endif; ?>
      </nav>
    </div>
  </div>

  <!-- Overview Tab -->
  <div id="overview-tab" class="tab-content">
    <!-- Status Flow Indicator -->
    <div class="mb-6">
      <h3 class="text-lg font-semibold mb-4 flex items-center">
        <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
        </svg>
        Complaint Status Flow
      </h3>
    <?php
    $statuses = [
      'Submitted' => 'gray',
      'In Progress' => 'yellow',
      'On Hold' => 'orange',
      'Resolved' => 'green',
      'Rejected' => 'red'
    ];
    $currentStatus = $c['status'];
    $statusKeys = array_keys($statuses);
    $currentIndex = array_search($currentStatus, $statusKeys);
    ?>
    <div class="flex items-center justify-between">
      <?php foreach ($statuses as $status => $color): ?>
        <?php
        $index = array_search($status, $statusKeys);
        $isCompleted = $index <= $currentIndex;
        $isCurrent = $index === $currentIndex;
        $bgColor = $isCompleted ? "bg-{$color}-500" : "bg-gray-300";
        $textColor = $isCompleted ? "text-white" : "text-gray-500";
        ?>
        <div class="flex flex-col items-center">
          <div class="relative">
            <div class="w-10 h-10 rounded-full flex items-center justify-center <?= $bgColor ?> <?= $textColor ?> font-semibold text-sm">
              <?php if ($isCompleted && !$isCurrent): ?>
                ✓
              <?php else: ?>
                <?= $index + 1 ?>
              <?php endif; ?>
            </div>
            <?php if ($index < count($statuses) - 1): ?>
              <div class="absolute top-5 left-10 w-16 h-0.5 <?= $index < $currentIndex ? "bg-{$color}-500" : "bg-gray-300" ?>"></div>
            <?php endif; ?>
          </div>
          <span class="text-xs mt-2 text-center <?= $isCurrent ? "font-semibold text-{$color}-600" : "text-gray-600" ?>">
            <?= $status ?>
          </span>
        </div>
      <?php endforeach; ?>
    </div>
  </div>

  <div class="flex justify-between items-start">
  <div id="details-tab" class="tab-content hidden">
    <div class="space-y-6">
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

    <div class="space-y-6">
      <!-- Admin Actions -->
      <?php if ($user && $user['role'] === 'admin'): ?>
        <div class="bg-gray-50 p-6 rounded-lg">
          <h3 class="font-semibold mb-4 flex items-center">
            <svg class="w-5 h-5 mr-2 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
            </svg>
            Admin Actions
          </h3>

          <!-- Authority Assignment -->
          <form method="POST" action="<?= $base ?>/complaints/assign-authority" class="flex flex-col sm:flex-row items-end gap-3">
            <input type="hidden" name="csrf" value="<?= csrf_token() ?>" />
            <input type="hidden" name="complaint_id" value="<?= $c['id'] ?>" />
            <div class="flex-1">
              <label class="block text-sm font-medium mb-2">Assign to Authority</label>
              <select name="authority_id" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-purple-500 focus:border-transparent">
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
            <button class="bg-purple-600 hover:bg-purple-700 text-white px-6 py-2 rounded-lg font-medium transition-colors duration-200" type="submit">Assign Authority</button>
          </form>
        </div>
      <?php endif; ?>

      <!-- Authority Actions -->
      <?php if ($user && $user['role'] === 'authority' && $c['assigned_authority_id'] == $user['id']): ?>
        <div class="bg-gray-50 p-6 rounded-lg">
          <h3 class="font-semibold mb-4 flex items-center">
            <svg class="w-5 h-5 mr-2 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
            </svg>
            Authority Actions
          </h3>

          <div class="space-y-4">
            <form method="POST" action="<?= $base ?>/complaints/update-status" class="flex flex-col sm:flex-row items-end gap-3">
              <input type="hidden" name="csrf" value="<?= csrf_token() ?>" />
              <input type="hidden" name="id" value="<?= $c['id'] ?>" />
              <div class="flex-1">
                <label class="block text-sm font-medium mb-2">Update Status</label>
                <select name="status" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                  <?php foreach (['Submitted','In Progress','On Hold','Resolved','Rejected'] as $s): ?>
                    <option value="<?= $s ?>" <?= $c['status']===$s?'selected':'' ?>><?= $s ?></option>
                  <?php endforeach; ?>
                </select>
              </div>
              <button class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2 rounded-lg font-medium transition-colors duration-200" type="submit">Update Status</button>
            </form>

            <form method="POST" action="<?= $base ?>/complaints/resolve" enctype="multipart/form-data" class="flex flex-col sm:flex-row items-end gap-3">
              <input type="hidden" name="csrf" value="<?= csrf_token() ?>" />
              <input type="hidden" name="id" value="<?= $c['id'] ?>" />
              <div class="flex-1">
                <label class="block text-sm font-medium mb-2">Resolution Evidence</label>
                <input type="file" name="evidence" accept="image/*" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-green-500 focus:border-transparent" />
              </div>
              <button class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-lg font-medium transition-colors duration-200" type="submit">Mark Resolved</button>
            </form>
          </div>
        </div>
      <?php endif; ?>
    </div>
  </div>

  <!-- Feedback Tab -->
  <?php if ($c['status'] === 'Resolved'): ?>
  <div id="feedback-tab" class="tab-content hidden">

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

<script>
document.addEventListener('DOMContentLoaded', function() {
  const tabButtons = document.querySelectorAll('.tab-button');
  const tabContents = document.querySelectorAll('.tab-content');

  tabButtons.forEach(button => {
    button.addEventListener('click', () => {
      // Remove active classes
      tabButtons.forEach(btn => {
        btn.classList.remove('border-blue-500', 'text-blue-600');
        btn.classList.add('border-transparent', 'text-gray-500', 'hover:text-gray-700', 'hover:border-gray-300');
      });
      tabContents.forEach(content => content.classList.add('hidden'));

      // Add active class to clicked button
      button.classList.remove('border-transparent', 'text-gray-500', 'hover:text-gray-700', 'hover:border-gray-300');
      button.classList.add('border-blue-500', 'text-blue-600');

      // Show corresponding tab content
      const tabId = button.dataset.tab + '-tab';
      const tabContent = document.getElementById(tabId);
      if (tabContent) {
        tabContent.classList.remove('hidden');
      }
    });
  });
});
</script>
