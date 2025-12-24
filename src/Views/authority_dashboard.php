<?php $user = $user ?? $_SESSION['user']; $newComplaints = $newComplaints ?? []; $solvedComplaints = $solvedComplaints ?? []; $pendingComplaints = $pendingComplaints ?? []; ?>

<!-- Modern Hero Header -->
<div class="bg-gradient-to-br from-green-600 via-teal-600 to-emerald-600 rounded-3xl p-8 mb-8 text-white shadow-2xl relative overflow-hidden">
  <div class="absolute inset-0 bg-black/10"></div>
  <div class="absolute -top-10 -right-10 w-40 h-40 bg-white/10 rounded-full blur-3xl"></div>
  <div class="absolute -bottom-10 -left-10 w-32 h-32 bg-white/10 rounded-full blur-2xl"></div>

  <div class="relative flex flex-col md:flex-row md:items-center md:justify-between">
    <div class="mb-6 md:mb-0">
      <div class="flex items-center mb-3">
        <div class="w-12 h-12 bg-white/20 backdrop-blur-sm rounded-2xl flex items-center justify-center mr-4">
          <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
          </svg>
        </div>
        <div>
          <h1 class="text-4xl font-bold mb-1">Authority Dashboard</h1>
          <p class="text-green-100 text-lg">Welcome back, <?= htmlspecialchars($user['name']) ?> - Managing city complaints</p>
        </div>
      </div>
    </div>
    <div class="flex flex-col sm:flex-row gap-4">
      <a href="<?= $base ?>/profile" class="inline-flex items-center px-6 py-3 bg-white/10 backdrop-blur-sm border border-white/20 rounded-2xl text-white hover:bg-white/20 transition-all duration-300 hover:scale-105">
        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
        </svg>
        Profile
      </a>
      <a href="<?= $base ?>/logout" class="inline-flex items-center px-6 py-3 bg-red-500 hover:bg-red-600 rounded-2xl text-white transition-all duration-300 hover:scale-105 shadow-lg">
        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
        </svg>
        Logout
      </a>
    </div>
  </div>
</div>

<!-- Enhanced Feedback Section -->
<div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden mb-8">
  <div class="bg-gradient-to-r from-purple-500 to-purple-600 p-6">
    <div class="flex items-center justify-between">
      <div class="flex items-center">
        <div class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center mr-3">
          <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
          </svg>
        </div>
        <div>
          <h3 class="text-xl font-semibold text-white">Citizen Feedback</h3>
          <p class="text-purple-100 text-sm">Insights from resolved complaints</p>
        </div>
      </div>
      <div class="text-right">
        <div class="text-2xl font-bold text-white">
          <?php
          $totalFeedback = 0;
          $resolvedComplaints = array_filter($solvedComplaints, fn($c) => $c['status'] === 'Resolved');
          foreach ($resolvedComplaints as $c) {
            $feedback = \App\Models\Complaint::getFeedback($c['id']);
            $totalFeedback += count($feedback);
          }
          echo $totalFeedback;
          ?>
        </div>
        <div class="text-purple-100 text-sm">Total Reviews</div>
      </div>
    </div>
  </div>

  <div class="p-6">
    <?php
    $resolvedComplaints = array_filter($solvedComplaints, fn($c) => $c['status'] === 'Resolved');
    if (empty($resolvedComplaints)):
    ?>
      <div class="text-center py-12">
        <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
        </svg>
        <h4 class="text-lg font-medium text-gray-900 mb-2">No Feedback Yet</h4>
        <p class="text-gray-500">Feedback from resolved complaints will appear here</p>
      </div>
    <?php else: ?>
      <div class="space-y-6">
        <?php foreach ($resolvedComplaints as $c): ?>
          <?php
          $feedback = \App\Models\Complaint::getFeedback($c['id']);
          if (!empty($feedback)):
          ?>
            <div class="bg-gray-50 rounded-xl p-6 border border-gray-200">
              <div class="flex items-start justify-between mb-4">
                <div>
                  <h4 class="font-semibold text-gray-900">#<?= $c['id'] ?> - <?= htmlspecialchars($c['title']) ?></h4>
                  <p class="text-sm text-gray-600">Resolved complaint</p>
                </div>
                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                  <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                  </svg>
                  Resolved
                </span>
              </div>

              <div class="space-y-4">
                <?php foreach ($feedback as $f): ?>
                  <div class="bg-white rounded-lg p-4 shadow-sm border border-gray-100">
                    <div class="flex items-start justify-between mb-3">
                      <div class="flex items-center">
                        <div class="w-8 h-8 bg-gradient-to-br from-blue-500 to-blue-600 rounded-full flex items-center justify-center mr-3">
                          <span class="text-white text-sm font-medium">
                            <?= strtoupper(substr($f['user_name'], 0, 1)) ?>
                          </span>
                        </div>
                        <div>
                          <div class="font-medium text-gray-900">Citizen: <?= htmlspecialchars($f['user_name']) ?></div>
                          <div class="text-sm text-gray-500">
                            <?= date('M j, Y \a\t g:i A', strtotime($f['created_at'])) ?>
                          </div>
                        </div>
                      </div>
                      <div class="flex items-center">
                        <?php for ($i = 1; $i <= 5; $i++): ?>
                          <span class="text-lg <?= $i <= $f['rating'] ? 'text-yellow-400' : 'text-gray-300' ?>">★</span>
                        <?php endfor; ?>
                        <span class="ml-2 text-sm font-medium text-gray-700">
                          <?php
                          $ratingTexts = ['Poor', 'Fair', 'Good', 'Very Good', 'Excellent'];
                          echo $ratingTexts[$f['rating'] - 1] ?? $f['rating'] . '/5';
                          ?>
                        </span>
                      </div>
                    </div>

                    <?php if ($f['comment']): ?>
                      <div class="bg-gray-50 rounded-lg p-3">
                        <p class="text-gray-700 italic">"<?= nl2br(htmlspecialchars($f['comment'])) ?>"</p>
                      </div>
                    <?php endif; ?>
                  </div>
                <?php endforeach; ?>
              </div>
            </div>
          <?php endif; ?>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>
  </div>
</div>

<!-- Statistics Cards -->
<div class="grid md:grid-cols-4 gap-6 mb-8">
  <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100">
    <div class="flex items-center justify-between">
      <div>
        <p class="text-sm font-medium text-gray-600">New Complaints</p>
        <p class="text-3xl font-bold text-gray-900"><?= count($newComplaints) ?></p>
      </div>
      <div class="w-12 h-12 bg-gradient-to-br from-red-500 to-red-600 rounded-xl flex items-center justify-center">
        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
        </svg>
      </div>
    </div>
  </div>

  <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100">
    <div class="flex items-center justify-between">
      <div>
        <p class="text-sm font-medium text-gray-600">In Progress</p>
        <p class="text-3xl font-bold text-gray-900"><?= count($pendingComplaints) ?></p>
      </div>
      <div class="w-12 h-12 bg-gradient-to-br from-yellow-500 to-yellow-600 rounded-xl flex items-center justify-center">
        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
        </svg>
      </div>
    </div>
  </div>

  <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100">
    <div class="flex items-center justify-between">
      <div>
        <p class="text-sm font-medium text-gray-600">Resolved</p>
        <p class="text-3xl font-bold text-gray-900"><?= count(array_filter($solvedComplaints, fn($c) => $c['status'] === 'Resolved')) ?></p>
      </div>
      <div class="w-12 h-12 bg-gradient-to-br from-green-500 to-green-600 rounded-xl flex items-center justify-center">
        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
        </svg>
      </div>
    </div>
  </div>

  <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100">
    <div class="flex items-center justify-between">
      <div>
        <p class="text-sm font-medium text-gray-600">Total Complaints</p>
        <p class="text-3xl font-bold text-gray-900"><?= count($newComplaints) + count($solvedComplaints) + count($pendingComplaints) ?></p>
      </div>
      <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center">
        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
        </svg>
      </div>
    </div>
  </div>
</div>

<!-- Complaint Management Cards -->
<div class="grid md:grid-cols-3 gap-6 mb-8">
  <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
    <div class="bg-gradient-to-r from-red-500 to-red-600 p-4">
      <div class="flex items-center justify-between">
        <h3 class="text-lg font-semibold text-white">New Complaints</h3>
        <span class="bg-white/20 text-white text-sm px-2 py-1 rounded-full"><?= count($newComplaints) ?> items</span>
      </div>
    </div>
    <div class="p-4 max-h-64 overflow-y-auto">
      <?php if (empty($newComplaints)): ?>
        <div class="text-center py-8">
          <svg class="w-12 h-12 text-gray-400 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
          </svg>
          <p class="text-gray-500 text-sm">No new complaints</p>
        </div>
      <?php else: ?>
        <div class="space-y-3">
          <?php foreach (array_slice($newComplaints, 0, 5) as $c): ?>
            <a href="<?= $base ?>/complaints/view?id=<?= $c['id'] ?>" class="block p-3 border border-gray-200 rounded-lg hover:bg-gray-50 hover:border-red-200 transition-all duration-200">
              <div class="flex items-start justify-between">
                <div class="flex-1">
                  <div class="font-medium text-gray-900">#<?= $c['id'] ?> - <?= htmlspecialchars($c['title']) ?></div>
                  <div class="flex items-center mt-1">
                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium
                      <?php
                      switch($c['priority']) {
                        case 'High': echo 'bg-red-100 text-red-800'; break;
                        case 'Medium': echo 'bg-yellow-100 text-yellow-800'; break;
                        case 'Low': echo 'bg-green-100 text-green-800'; break;
                        default: echo 'bg-gray-100 text-gray-800';
                      }
                      ?>">
                      <?= htmlspecialchars($c['priority']) ?> Priority
                    </span>
                  </div>
                </div>
                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
              </div>
            </a>
          <?php endforeach; ?>
          <?php if (count($newComplaints) > 5): ?>
            <div class="text-center pt-2">
              <a href="<?= $base ?>/complaints" class="text-red-600 hover:text-red-800 text-sm font-medium">View all new complaints →</a>
            </div>
          <?php endif; ?>
        </div>
      <?php endif; ?>
    </div>
  </div>

  <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
    <div class="bg-gradient-to-r from-yellow-500 to-yellow-600 p-4">
      <div class="flex items-center justify-between">
        <h3 class="text-lg font-semibold text-white">In Progress</h3>
        <span class="bg-white/20 text-white text-sm px-2 py-1 rounded-full"><?= count($pendingComplaints) ?> items</span>
      </div>
    </div>
    <div class="p-4 max-h-64 overflow-y-auto">
      <?php if (empty($pendingComplaints)): ?>
        <div class="text-center py-8">
          <svg class="w-12 h-12 text-gray-400 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
          </svg>
          <p class="text-gray-500 text-sm">No complaints in progress</p>
        </div>
      <?php else: ?>
        <div class="space-y-3">
          <?php foreach (array_slice($pendingComplaints, 0, 5) as $c): ?>
            <a href="<?= $base ?>/complaints/view?id=<?= $c['id'] ?>" class="block p-3 border border-gray-200 rounded-lg hover:bg-gray-50 hover:border-yellow-200 transition-all duration-200">
              <div class="flex items-start justify-between">
                <div class="flex-1">
                  <div class="font-medium text-gray-900">#<?= $c['id'] ?> - <?= htmlspecialchars($c['title']) ?></div>
                  <div class="flex items-center mt-1 space-x-2">
                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                      <?= htmlspecialchars($c['status']) ?>
                    </span>
                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium
                      <?php
                      switch($c['priority']) {
                        case 'High': echo 'bg-red-100 text-red-800'; break;
                        case 'Medium': echo 'bg-yellow-100 text-yellow-800'; break;
                        case 'Low': echo 'bg-green-100 text-green-800'; break;
                        default: echo 'bg-gray-100 text-gray-800';
                      }
                      ?>">
                      <?= htmlspecialchars($c['priority']) ?> Priority
                    </span>
                  </div>
                </div>
                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
              </div>
            </a>
          <?php endforeach; ?>
          <?php if (count($pendingComplaints) > 5): ?>
            <div class="text-center pt-2">
              <a href="<?= $base ?>/complaints" class="text-yellow-600 hover:text-yellow-800 text-sm font-medium">View all in progress →</a>
            </div>
          <?php endif; ?>
        </div>
      <?php endif; ?>
    </div>
  </div>

  <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
    <div class="bg-gradient-to-r from-green-500 to-green-600 p-4">
      <div class="flex items-center justify-between">
        <h3 class="text-lg font-semibold text-white">Resolved</h3>
        <span class="bg-white/20 text-white text-sm px-2 py-1 rounded-full"><?= count(array_filter($solvedComplaints, fn($c) => $c['status'] === 'Resolved')) ?> items</span>
      </div>
    </div>
    <div class="p-4 max-h-64 overflow-y-auto">
      <?php
      $resolvedComplaints = array_filter($solvedComplaints, fn($c) => $c['status'] === 'Resolved');
      if (empty($resolvedComplaints)):
      ?>
        <div class="text-center py-8">
          <svg class="w-12 h-12 text-gray-400 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
          </svg>
          <p class="text-gray-500 text-sm">No resolved complaints</p>
        </div>
      <?php else: ?>
        <div class="space-y-3">
          <?php foreach (array_slice($resolvedComplaints, 0, 5) as $c): ?>
            <a href="<?= $base ?>/complaints/view?id=<?= $c['id'] ?>" class="block p-3 border border-gray-200 rounded-lg hover:bg-gray-50 hover:border-green-200 transition-all duration-200">
              <div class="flex items-start justify-between">
                <div class="flex-1">
                  <div class="font-medium text-gray-900">#<?= $c['id'] ?> - <?= htmlspecialchars($c['title']) ?></div>
                  <div class="flex items-center mt-1">
                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                      Resolved
                    </span>
                    <?php if (isset($c['resolved_at'])): ?>
                      <span class="text-xs text-gray-500 ml-2">
                        <?= date('M j', strtotime($c['resolved_at'])) ?>
                      </span>
                    <?php endif; ?>
                  </div>
                </div>
                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
              </div>
            </a>
          <?php endforeach; ?>
          <?php if (count($resolvedComplaints) > 5): ?>
            <div class="text-center pt-2">
              <a href="<?= $base ?>/complaints" class="text-green-600 hover:text-green-800 text-sm font-medium">View all resolved →</a>
            </div>
          <?php endif; ?>
        </div>
      <?php endif; ?>
    </div>
  </div>
</div>

<!-- Enhanced Complaints Management Table -->
<div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
  <div class="bg-gradient-to-r from-indigo-500 to-indigo-600 p-6">
    <div class="flex items-center justify-between">
      <div class="flex items-center">
        <div class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center mr-3">
          <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
          </svg>
        </div>
        <div>
          <h3 class="text-xl font-semibold text-white">Complaints Management</h3>
          <p class="text-indigo-100 text-sm">Update status and manage all complaints</p>
        </div>
      </div>
      <div class="text-right">
        <div class="text-2xl font-bold text-white">
          <?= count($newComplaints) + count($solvedComplaints) + count($pendingComplaints) ?>
        </div>
        <div class="text-indigo-100 text-sm">Total Complaints</div>
      </div>
    </div>
  </div>

  <div class="overflow-x-auto">
    <table class="w-full">
      <thead class="bg-gray-50">
        <tr>
          <th class="text-left p-4 font-semibold text-gray-900">ID</th>
          <th class="text-left p-4 font-semibold text-gray-900">Title</th>
          <th class="text-left p-4 font-semibold text-gray-900">Status</th>
          <th class="text-left p-4 font-semibold text-gray-900">Priority</th>
          <th class="text-left p-4 font-semibold text-gray-900">Actions</th>
        </tr>
      </thead>
      <tbody class="divide-y divide-gray-200">
        <?php foreach (array_merge($newComplaints, $solvedComplaints, $pendingComplaints) as $c): ?>
          <tr class="hover:bg-gray-50 transition-colors duration-200">
            <td class="p-4">
              <div class="flex items-center">
                <div class="w-8 h-8 bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg flex items-center justify-center mr-3">
                  <span class="text-white text-sm font-bold">#</span>
                </div>
                <span class="font-medium text-gray-900"><?= $c['id'] ?></span>
              </div>
            </td>
            <td class="p-4">
              <div class="max-w-xs">
                <div class="font-medium text-gray-900 truncate"><?= htmlspecialchars($c['title']) ?></div>
                <div class="text-sm text-gray-500">Click to view details</div>
              </div>
            </td>
            <td class="p-4">
              <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                <?php
                switch($c['status']) {
                  case 'Submitted': echo 'bg-gray-100 text-gray-800'; break;
                  case 'In Progress': echo 'bg-blue-100 text-blue-800'; break;
                  case 'On Hold': echo 'bg-yellow-100 text-yellow-800'; break;
                  case 'Resolved': echo 'bg-green-100 text-green-800'; break;
                  case 'Rejected': echo 'bg-red-100 text-red-800'; break;
                  default: echo 'bg-gray-100 text-gray-800';
                }
                ?>">
                <?php
                switch($c['status']) {
                  case 'Submitted': echo '⏳'; break;
                  case 'In Progress': echo '🔄'; break;
                  case 'On Hold': echo '⏸️'; break;
                  case 'Resolved': echo '✅'; break;
                  case 'Rejected': echo '❌'; break;
                }
                ?>
                <?= htmlspecialchars($c['status']) ?>
              </span>
            </td>
            <td class="p-4">
              <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                <?php
                switch($c['priority']) {
                  case 'High': echo 'bg-red-100 text-red-800'; break;
                  case 'Medium': echo 'bg-yellow-100 text-yellow-800'; break;
                  case 'Low': echo 'bg-green-100 text-green-800'; break;
                  default: echo 'bg-gray-100 text-gray-800';
                }
                ?>">
                <?php
                switch($c['priority']) {
                  case 'High': echo '🔴'; break;
                  case 'Medium': echo '🟡'; break;
                  case 'Low': echo '🟢'; break;
                }
                ?>
                <?= htmlspecialchars($c['priority']) ?> Priority
              </span>
            </td>
            <td class="p-4">
              <div class="flex items-center space-x-3">
                <a href="<?= $base ?>/complaints/view?id=<?= $c['id'] ?>"
                   class="inline-flex items-center px-3 py-2 bg-blue-50 hover:bg-blue-100 text-blue-700 rounded-lg text-sm font-medium transition-colors duration-200">
                  <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                  </svg>
                  View
                </a>

                <form method="POST" action="<?= $base ?>/complaints/update-status" class="inline-flex items-center">
                  <input type="hidden" name="csrf" value="<?= csrf_token() ?>" />
                  <input type="hidden" name="id" value="<?= $c['id'] ?>" />
                  <select name="status" class="bg-white border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 mr-2">
                    <?php foreach (['Submitted','In Progress','On Hold','Resolved','Rejected'] as $s): ?>
                      <option value="<?= $s ?>" <?= $c['status']===$s?'selected':'' ?>><?= $s ?></option>
                    <?php endforeach; ?>
                  </select>
                  <button type="submit" class="inline-flex items-center px-3 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg text-sm font-medium transition-colors duration-200">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                    </svg>
                    Update
                  </button>
                </form>
              </div>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>

  <?php if (empty(array_merge($newComplaints, $solvedComplaints, $pendingComplaints))): ?>
    <div class="text-center py-12">
      <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
      </svg>
      <h4 class="text-lg font-medium text-gray-900 mb-2">No Complaints Found</h4>
      <p class="text-gray-500">There are currently no complaints in the system.</p>
    </div>
  <?php endif; ?>
</div>
