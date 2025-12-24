<?php $user = $user ?? $_SESSION['user']; $newComplaints = $newComplaints ?? []; $allComplaints = $allComplaints ?? []; ?>

<!-- Modern Header -->
<div class="bg-gradient-to-r from-blue-600 via-purple-600 to-blue-800 rounded-2xl p-8 mb-8 text-white shadow-xl">
  <div class="flex flex-col md:flex-row md:items-center md:justify-between">
    <div class="mb-4 md:mb-0">
      <h1 class="text-3xl font-bold mb-2">Welcome back, <?= htmlspecialchars($user['name']) ?>!</h1>
      <p class="text-blue-100">Manage your complaints and help improve our city</p>
    </div>
    <div class="flex flex-col sm:flex-row gap-3">
      <a href="<?= $base ?>/profile" class="inline-flex items-center px-4 py-2 bg-white/10 backdrop-blur-sm border border-white/20 rounded-lg text-white hover:bg-white/20 transition-all duration-200">
        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
        </svg>
        Profile
      </a>
      <a href="<?= $base ?>/logout" class="inline-flex items-center px-4 py-2 bg-red-500 hover:bg-red-600 rounded-lg text-white transition-all duration-200">
        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
        </svg>
        Logout
      </a>
    </div>
  </div>
</div>

<!-- Quick Actions Cards -->
<div class="grid md:grid-cols-3 gap-6 mb-8">
  <a href="<?= $base ?>/complaints/new" class="group bg-white rounded-2xl shadow-lg hover:shadow-2xl p-6 border border-gray-100 hover:border-blue-200 transition-all duration-300 transform hover:-translate-y-1">
    <div class="flex items-center justify-between mb-4">
      <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform duration-200">
        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
        </svg>
      </div>
      <svg class="w-5 h-5 text-gray-400 group-hover:text-blue-500 transition-colors duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
      </svg>
    </div>
    <h3 class="text-xl font-semibold text-gray-900 mb-2">Report Issue</h3>
    <p class="text-gray-600">Submit a new complaint about city issues</p>
  </a>

  <a href="<?= $base ?>/complaints" class="group bg-white rounded-2xl shadow-lg hover:shadow-2xl p-6 border border-gray-100 hover:border-green-200 transition-all duration-300 transform hover:-translate-y-1">
    <div class="flex items-center justify-between mb-4">
      <div class="w-12 h-12 bg-gradient-to-br from-green-500 to-green-600 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform duration-200">
        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
        </svg>
      </div>
      <svg class="w-5 h-5 text-gray-400 group-hover:text-green-500 transition-colors duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
      </svg>
    </div>
    <h3 class="text-xl font-semibold text-gray-900 mb-2">Track Complaints</h3>
    <p class="text-gray-600">Monitor status of your submitted complaints</p>
  </a>

  <a href="<?= $base ?>/" class="group bg-white rounded-2xl shadow-lg hover:shadow-2xl p-6 border border-gray-100 hover:border-purple-200 transition-all duration-300 transform hover:-translate-y-1">
    <div class="flex items-center justify-between mb-4">
      <div class="w-12 h-12 bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform duration-200">
        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"></path>
        </svg>
      </div>
      <svg class="w-5 h-5 text-gray-400 group-hover:text-purple-500 transition-colors duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
      </svg>
    </div>
    <h3 class="text-xl font-semibold text-gray-900 mb-2">City Overview</h3>
    <p class="text-gray-600">Explore the interactive city map</p>
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

<!-- Enhanced Feedback Modal -->
<div id="feedbackModal" class="fixed inset-0 bg-gray-900 bg-opacity-50 backdrop-blur-sm hidden z-50 transition-opacity duration-300">
  <div class="flex items-center justify-center min-h-screen p-4">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md transform transition-all duration-300 scale-100">
      <!-- Modal Header -->
      <div class="bg-gradient-to-r from-green-500 to-green-600 p-6 rounded-t-2xl">
        <div class="flex items-center justify-between">
          <div class="flex items-center">
            <div class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center mr-3">
              <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
              </svg>
            </div>
            <div>
              <h3 class="text-lg font-semibold text-white">Share Your Feedback</h3>
              <p class="text-green-100 text-sm">Help us improve our services</p>
            </div>
          </div>
          <button onclick="closeFeedbackModal()" class="text-white hover:bg-white/20 rounded-lg p-1 transition-colors duration-200">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
          </button>
        </div>
      </div>

      <!-- Modal Body -->
      <div class="p-6">
        <form id="feedbackForm" method="POST" action="<?= $base ?>/complaints/add-feedback">
          <input type="hidden" name="csrf" value="<?= csrf_token() ?>" />
          <input type="hidden" name="complaint_id" id="feedbackComplaintId" />

          <!-- Rating Section -->
          <div class="mb-6">
            <label class="block text-sm font-semibold text-gray-900 mb-3">How satisfied are you with the resolution?</label>
            <div class="flex items-center justify-center space-x-2">
              <?php for ($i = 1; $i <= 5; $i++): ?>
                <input type="radio" name="rating" value="<?= $i ?>" id="star<?= $i ?>" class="hidden peer" />
                <label for="star<?= $i ?>" class="cursor-pointer text-gray-300 text-3xl hover:text-yellow-400 peer-checked:text-yellow-400 transition-colors duration-200 star-label hover:scale-110 transform">
                  ★
                </label>
              <?php endfor; ?>
            </div>
            <div class="flex justify-center mt-2">
              <span id="ratingText" class="text-sm text-gray-500">Select a rating</span>
            </div>
          </div>

          <!-- Comments Section -->
          <div class="mb-6">
            <label for="feedbackComment" class="block text-sm font-semibold text-gray-900 mb-2">Comments <span class="text-gray-500 font-normal">(optional)</span></label>
            <textarea id="feedbackComment" name="comment" rows="4"
                      class="w-full border border-gray-300 rounded-xl px-4 py-3 text-gray-900 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent resize-none transition-all duration-200"
                      placeholder="Tell us what you think about the service..."></textarea>
          </div>

          <!-- Action Buttons -->
          <div class="flex gap-3">
            <button type="button" onclick="closeFeedbackModal()"
                    class="flex-1 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium py-3 px-4 rounded-xl transition-colors duration-200">
              Cancel
            </button>
            <button type="submit"
                    class="flex-1 bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 text-white font-medium py-3 px-4 rounded-xl shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-200">
              Submit Feedback
            </button>
          </div>
        </form>
      </div>
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
    const ratingValue = index + 1;
    const ratingText = document.getElementById('ratingText');

    document.querySelectorAll('.star-label').forEach((l, i) => {
      l.classList.toggle('text-yellow-400', i <= index);
      l.classList.toggle('text-gray-300', i > index);
    });

    // Update rating text
    const ratingTexts = ['Poor', 'Fair', 'Good', 'Very Good', 'Excellent'];
    ratingText.textContent = ratingTexts[index] || 'Select a rating';
    ratingText.style.color = '#374151'; // gray-700
  });
});
</script>
