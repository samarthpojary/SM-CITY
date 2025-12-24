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
    <div class="p-4 text-gray-500">No complaints found.</div>
  <?php endif; ?>
</div>
