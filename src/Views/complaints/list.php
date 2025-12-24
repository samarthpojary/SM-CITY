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
  <div class="divide-y divide-gray-200">
<div class="bg-white rounded shadow divide-y">
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
    <div class="p-8 text-center">
      <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
      </svg>
      <h4 class="text-lg font-medium text-gray-900 mb-2">No Complaints Found</h4>
      <p class="text-gray-500">There are currently no complaints in the system.</p>
    </div>
  <?php endif; ?>
  </div>
</div>
