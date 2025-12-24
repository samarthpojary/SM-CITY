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
          <div class="p-2 border rounded hover:bg-gray-50">
            <a href="<?= $base ?>/complaints/view?id=<?= $c['id'] ?>" class="block">
              <div class="font-medium">#<?= $c['id'] ?> - <?= htmlspecialchars($c['title']) ?></div>
              <div class="text-sm text-gray-600">Status: <?= htmlspecialchars($c['status']) ?> | Priority: <?= htmlspecialchars($c['priority']) ?></div>
            </a>
            <?php if ($c['status'] === 'Resolved'): ?>
              <?php
              $feedback = \App\Models\Complaint::getFeedback($c['id']);
              $userFeedback = array_filter($feedback, fn($f) => $f['user_id'] == $user['id']);
              if (empty($userFeedback)):
              ?>
                <button onclick="openFeedbackModal(<?= $c['id'] ?>)" class="mt-2 bg-green-600 text-white px-3 py-1 rounded text-sm">Give Feedback</button>
              <?php else: ?>
                <span class="mt-2 text-green-600 text-sm">✓ Feedback submitted</span>
              <?php endif; ?>
            <?php endif; ?>
          </div>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>
  </div>
</div>

<!-- Feedback Modal -->
<div id="feedbackModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden z-50">
  <div class="flex items-center justify-center min-h-screen">
    <div class="bg-white rounded-lg shadow-lg p-6 w-full max-w-md">
      <h3 class="text-lg font-semibold mb-4">Provide Feedback</h3>
      <form id="feedbackForm" method="POST" action="<?= $base ?>/complaints/add-feedback">
        <input type="hidden" name="csrf" value="<?= csrf_token() ?>" />
        <input type="hidden" name="complaint_id" id="feedbackComplaintId" />
        <div class="mb-4">
          <label class="block text-sm font-medium mb-2">Rating</label>
          <div class="flex space-x-1">
            <?php for ($i = 1; $i <= 5; $i++): ?>
              <input type="radio" name="rating" value="<?= $i ?>" id="star<?= $i ?>" class="hidden" />
              <label for="star<?= $i ?>" class="cursor-pointer text-gray-300 text-2xl hover:text-yellow-400 star-label">★</label>
            <?php endfor; ?>
          </div>
        </div>
        <div class="mb-4">
          <label class="block text-sm font-medium mb-2">Comments (optional)</label>
          <textarea name="comment" rows="3" class="w-full border rounded px-3 py-2" placeholder="Share your thoughts..."></textarea>
        </div>
        <div class="flex justify-end space-x-2">
          <button type="button" onclick="closeFeedbackModal()" class="bg-gray-500 text-white px-4 py-2 rounded">Cancel</button>
          <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Submit Feedback</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
function openFeedbackModal(complaintId) {
  document.getElementById('feedbackComplaintId').value = complaintId;
  document.getElementById('feedbackModal').classList.remove('hidden');
}

function closeFeedbackModal() {
  document.getElementById('feedbackModal').classList.add('hidden');
  document.getElementById('feedbackForm').reset();
}

// Star rating functionality
document.querySelectorAll('.star-label').forEach((label, index) => {
  label.addEventListener('click', () => {
    document.querySelectorAll('.star-label').forEach((l, i) => {
      l.classList.toggle('text-yellow-400', i <= index);
      l.classList.toggle('text-gray-300', i > index);
    });
  });
});
</script>
