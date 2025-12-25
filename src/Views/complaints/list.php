<?php $items = $complaints ?? []; ?>
<div class="mb-6">
  <a href="javascript:history.back()" class="inline-flex items-center px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg transition-colors duration-200">
    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
    </svg>
    Back
  </a>
</div>
<div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
  <div class="bg-gradient-to-r from-blue-500 to-blue-600 p-6">
    <div class="flex justify-between items-center">
      <div class="flex items-center">
        <div class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center mr-3">
          <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
          </svg>
        </div>
        <div>
          <h2 class="text-2xl font-bold text-white">Complaints Management</h2>
          <p class="text-blue-100 text-sm">View and manage all complaints</p>
        </div>
      </div>
      <a href="<?= $base ?>/complaints/new" class="inline-flex items-center px-4 py-2 bg-white/20 backdrop-blur-sm border border-white/30 rounded-lg text-white hover:bg-white/30 transition-all duration-200">
        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
        </svg>
        New Complaint
      </a>
    </div>
  </div>
  <!-- Search and Filter Section -->
  <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200 mb-6">
    <div class="flex flex-col md:flex-row gap-4">
      <div class="flex-1">
        <input type="text" id="searchInput" placeholder="Search complaints by title or ID..." class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
      </div>
      <div class="flex gap-2">
        <select id="statusFilter" class="px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
          <option value="">All Statuses</option>
          <option value="Submitted">Submitted</option>
          <option value="In Progress">In Progress</option>
          <option value="On Hold">On Hold</option>
          <option value="Resolved">Resolved</option>
          <option value="Rejected">Rejected</option>
        </select>
        <select id="categoryFilter" class="px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
          <option value="">All Categories</option>
          <option value="Infrastructure">Infrastructure</option>
          <option value="Sanitation">Sanitation</option>
          <option value="Public Safety">Public Safety</option>
          <option value="Environment">Environment</option>
          <option value="Traffic">Traffic</option>
          <option value="Utilities">Utilities</option>
          <option value="Other">Other</option>
        </select>
      </div>
    </div>
  </div>

  <div class="divide-y divide-gray-200">
<div class="bg-white rounded-lg shadow-sm divide-y divide-gray-100">
  <?php foreach ($items as $c): ?>
    <a class="block p-4 hover:bg-gray-50" href="<?= $base ?>/complaints/view?id=<?= $c['id'] ?>">
      <div class="flex justify-between items-center">
        <div>
          <div class="font-medium">#<?= $c['id'] ?> - <?= htmlspecialchars($c['title']) ?></div>
          <div class="text-sm text-gray-600"><?= htmlspecialchars($c['category']) ?> | <?= htmlspecialchars($c['priority']) ?> | <?= htmlspecialchars($c['status']) ?></div>
          <!-- Status Flow Indicator -->
          <div class="mt-2">
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
            <div class="flex items-center justify-between text-xs">
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
                    <div class="w-6 h-6 rounded-full flex items-center justify-center <?= $bgColor ?> <?= $textColor ?> font-semibold text-xs">
                      <?php if ($isCompleted && !$isCurrent): ?>
                        ✓
                      <?php else: ?>
                        <?= $index + 1 ?>
                      <?php endif; ?>
                    </div>
                    <?php if ($index < count($statuses) - 1): ?>
                      <div class="absolute top-3 left-6 w-8 h-0.5 <?= $index < $currentIndex ? "bg-{$color}-500" : "bg-gray-300" ?>"></div>
                    <?php endif; ?>
                  </div>
                  <span class="text-xs mt-1 text-center <?= $isCurrent ? "font-semibold text-{$color}-600" : "text-gray-600" ?>">
                    <?= $status ?>
                  </span>
                </div>
              <?php endforeach; ?>
            </div>
          </div>
        </div>
        <div class="text-xs text-gray-500"><?= htmlspecialchars($c['created_at'] ?? '') ?></div>
      </div>
    </a>
  <?php endforeach; ?>
  <?php if (empty($items)): ?>
    <div class="p-12 text-center">
      <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-6">
        <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
        </svg>
      </div>
      <h4 class="text-xl font-semibold text-gray-900 mb-2">No Complaints Found</h4>
      <p class="text-gray-600 mb-4">There are currently no complaints in the system that match your criteria.</p>
      <a href="<?= $base ?>/complaints/new" class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors duration-200">
        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
        </svg>
        Submit First Complaint
      </a>
    </div>
  <?php endif; ?>
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
  const searchInput = document.getElementById('searchInput');
  const statusFilter = document.getElementById('statusFilter');
  const categoryFilter = document.getElementById('categoryFilter');
  const complaintCards = document.querySelectorAll('.complaint-card');

  function filterComplaints() {
    const searchTerm = searchInput.value.toLowerCase();
    const statusValue = statusFilter.value;
    const categoryValue = categoryFilter.value;

    complaintCards.forEach(card => {
      const title = card.dataset.title.toLowerCase();
      const id = card.dataset.id;
      const status = card.dataset.status;
      const category = card.dataset.category;

      const matchesSearch = title.includes(searchTerm) || id.includes(searchTerm);
      const matchesStatus = !statusValue || status === statusValue;
      const matchesCategory = !categoryValue || category === categoryValue;

      if (matchesSearch && matchesStatus && matchesCategory) {
        card.style.display = 'block';
      } else {
        card.style.display = 'none';
      }
    });
  }

  searchInput.addEventListener('input', filterComplaints);
  statusFilter.addEventListener('change', filterComplaints);
  categoryFilter.addEventListener('change', filterComplaints);
});
</script>
