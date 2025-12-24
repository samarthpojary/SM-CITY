<?php $user = $user ?? $_SESSION['user']; $stats = $stats ?? []; $users = $users ?? []; $authorities = $authorities ?? []; $allComplaints = $allComplaints ?? []; ?>

<!-- Modern Hero Header -->
<div class="bg-gradient-to-br from-indigo-600 via-purple-600 to-pink-600 rounded-3xl p-8 mb-8 text-white shadow-2xl relative overflow-hidden">
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
          <h1 class="text-4xl font-bold mb-1">Admin Dashboard</h1>
          <p class="text-indigo-100 text-lg">Welcome back, <?= htmlspecialchars($user['name']) ?> - System Overview</p>
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

<!-- Enhanced Analytics Cards -->
<div class="grid md:grid-cols-4 gap-6 mb-8">
  <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100 hover:shadow-xl transition-all duration-300 hover:scale-105">
    <div class="flex items-center justify-between">
      <div>
        <p class="text-sm font-medium text-gray-600 mb-1">Total Complaints</p>
        <p class="text-3xl font-bold text-gray-900"><?= $stats['total'] ?? 0 ?></p>
        <p class="text-xs text-gray-500 mt-1">All time</p>
      </div>
      <div class="w-14 h-14 bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl flex items-center justify-center shadow-lg">
        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
        </svg>
      </div>
    </div>
  </div>

  <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100 hover:shadow-xl transition-all duration-300 hover:scale-105">
    <div class="flex items-center justify-between">
      <div>
        <p class="text-sm font-medium text-gray-600 mb-1">Resolved</p>
        <p class="text-3xl font-bold text-green-600"><?= $stats['status']['Resolved'] ?? 0 ?></p>
        <p class="text-xs text-green-600 mt-1">Successfully completed</p>
      </div>
      <div class="w-14 h-14 bg-gradient-to-br from-green-500 to-green-600 rounded-2xl flex items-center justify-center shadow-lg">
        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
        </svg>
      </div>
    </div>
  </div>

  <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100 hover:shadow-xl transition-all duration-300 hover:scale-105">
    <div class="flex items-center justify-between">
      <div>
        <p class="text-sm font-medium text-gray-600 mb-1">Pending</p>
        <p class="text-3xl font-bold text-orange-600"><?= ($stats['total'] ?? 0) - ($stats['status']['Resolved'] ?? 0) ?></p>
        <p class="text-xs text-orange-600 mt-1">Requires attention</p>
      </div>
      <div class="w-14 h-14 bg-gradient-to-br from-orange-500 to-orange-600 rounded-2xl flex items-center justify-center shadow-lg">
        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
        </svg>
      </div>
    </div>
  </div>

  <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100 hover:shadow-xl transition-all duration-300 hover:scale-105">
    <div class="flex items-center justify-between">
      <div>
        <p class="text-sm font-medium text-gray-600 mb-1">High Priority</p>
        <p class="text-3xl font-bold text-red-600"><?= $stats['priority']['High'] ?? 0 ?></p>
        <p class="text-xs text-red-600 mt-1">Urgent matters</p>
      </div>
      <div class="w-14 h-14 bg-gradient-to-br from-red-500 to-red-600 rounded-2xl flex items-center justify-center shadow-lg">
        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
        </svg>
      </div>
    </div>
  </div>
</div>

<!-- User Statistics Cards -->
<div class="grid md:grid-cols-3 gap-6 mb-8">
  <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100 hover:shadow-xl transition-all duration-300 hover:scale-105">
    <div class="flex items-center justify-between">
      <div>
        <p class="text-sm font-medium text-gray-600 mb-1">Citizens</p>
        <p class="text-3xl font-bold text-blue-600"><?= $stats['users']['citizen'] ?? 0 ?></p>
        <p class="text-xs text-blue-600 mt-1">Active community members</p>
      </div>
      <div class="w-14 h-14 bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl flex items-center justify-center shadow-lg">
        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
        </svg>
      </div>
    </div>
  </div>

  <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100 hover:shadow-xl transition-all duration-300 hover:scale-105">
    <div class="flex items-center justify-between">
      <div>
        <p class="text-sm font-medium text-gray-600 mb-1">Authorities</p>
        <p class="text-3xl font-bold text-green-600"><?= $stats['users']['authority'] ?? 0 ?></p>
        <p class="text-xs text-green-600 mt-1">System administrators</p>
      </div>
      <div class="w-14 h-14 bg-gradient-to-br from-green-500 to-green-600 rounded-2xl flex items-center justify-center shadow-lg">
        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
        </svg>
      </div>
    </div>
  </div>

  <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100 hover:shadow-xl transition-all duration-300 hover:scale-105">
    <div class="flex items-center justify-between">
      <div>
        <p class="text-sm font-medium text-gray-600 mb-1">Admins</p>
        <p class="text-3xl font-bold text-purple-600"><?= $stats['users']['admin'] ?? 0 ?></p>
        <p class="text-xs text-purple-600 mt-1">System administrators</p>
      </div>
      <div class="w-14 h-14 bg-gradient-to-br from-purple-500 to-purple-600 rounded-2xl flex items-center justify-center shadow-lg">
        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
        </svg>
      </div>
    </div>
  </div>
</div>

<!-- Enhanced Users Management -->
<div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden mb-8">
  <div class="bg-gradient-to-r from-blue-500 to-blue-600 p-6">
    <div class="flex items-center justify-between">
      <div class="flex items-center">
        <div class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center mr-3">
          <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
          </svg>
        </div>
        <div>
          <h3 class="text-xl font-semibold text-white">User Management</h3>
          <p class="text-blue-100 text-sm">Manage all system users and their roles</p>
        </div>
      </div>
      <div class="text-right">
        <div class="text-2xl font-bold text-white"><?= count($users) ?></div>
        <div class="text-blue-100 text-sm">Total Users</div>
      </div>
    </div>
  </div>

  <div class="p-6">
    <div class="overflow-x-auto">
      <table class="w-full">
        <thead class="bg-gray-50">
          <tr>
            <th class="text-left p-4 font-semibold text-gray-900">User</th>
            <th class="text-left p-4 font-semibold text-gray-900">Contact</th>
            <th class="text-left p-4 font-semibold text-gray-900">Role</th>
            <th class="text-left p-4 font-semibold text-gray-900">Actions</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-gray-200">
          <?php foreach ($users as $u): ?>
            <tr class="hover:bg-gray-50 transition-colors duration-200">
              <td class="p-4">
                <div class="flex items-center">
                  <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-blue-600 rounded-full flex items-center justify-center mr-3">
                    <span class="text-white text-sm font-bold">
                      <?= strtoupper(substr($u['name'], 0, 1)) ?>
                    </span>
                  </div>
                  <div>
                    <div class="font-medium text-gray-900">#<?= $u['id'] ?> - <?= htmlspecialchars($u['name']) ?></div>
                    <div class="text-sm text-gray-500">User ID: <?= $u['id'] ?></div>
                  </div>
                </div>
              </td>
              <td class="p-4">
                <div class="text-sm">
                  <div class="font-medium text-gray-900"><?= htmlspecialchars($u['email']) ?></div>
                  <div class="text-gray-500">Email verified</div>
                </div>
              </td>
              <td class="p-4">
                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                  <?php
                  switch($u['role']) {
                    case 'admin': echo 'bg-purple-100 text-purple-800'; break;
                    case 'authority': echo 'bg-green-100 text-green-800'; break;
                    case 'citizen': echo 'bg-blue-100 text-blue-800'; break;
                    default: echo 'bg-gray-100 text-gray-800';
                  }
                  ?>">
                  <?php
                  switch($u['role']) {
                    case 'admin': echo '👑'; break;
                    case 'authority': echo '🛡️'; break;
                    case 'citizen': echo '👤'; break;
                  }
                  ?>
                  <?= ucfirst(htmlspecialchars($u['role'])) ?>
                </span>
              </td>
              <td class="p-4">
                <div class="flex items-center space-x-3">
                  <a href="<?= $base ?>/admin/edit-user?id=<?= $u['id'] ?>"
                     class="inline-flex items-center px-3 py-2 bg-blue-50 hover:bg-blue-100 text-blue-700 rounded-lg text-sm font-medium transition-colors duration-200">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                    Edit
                  </a>
                  <a href="<?= $base ?>/admin/delete-user?id=<?= $u['id'] ?>"
                     class="inline-flex items-center px-3 py-2 bg-red-50 hover:bg-red-100 text-red-700 rounded-lg text-sm font-medium transition-colors duration-200"
                     onclick="return confirm('Are you sure you want to delete this user?')">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                    </svg>
                    Delete
                  </a>
                </div>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>

    <?php if (empty($users)): ?>
      <div class="text-center py-12">
        <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
        </svg>
        <h4 class="text-lg font-medium text-gray-900 mb-2">No Users Found</h4>
        <p class="text-gray-500">There are currently no users in the system.</p>
      </div>
    <?php endif; ?>
  </div>
</div>

<!-- Enhanced Authorities Management -->
<div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden mb-8">
  <div class="bg-gradient-to-r from-green-500 to-green-600 p-6">
    <div class="flex items-center justify-between">
      <div class="flex items-center">
        <div class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center mr-3">
          <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
          </svg>
        </div>
        <div>
          <h3 class="text-xl font-semibold text-white">Authority Management</h3>
          <p class="text-green-100 text-sm">Manage system authorities and administrators</p>
        </div>
      </div>
      <div class="text-right">
        <div class="text-2xl font-bold text-white"><?= count($authorities) ?></div>
        <div class="text-green-100 text-sm">Total Authorities</div>
      </div>
    </div>
  </div>

  <div class="p-6">
    <div class="overflow-x-auto">
      <table class="w-full">
        <thead class="bg-gray-50">
          <tr>
            <th class="text-left p-4 font-semibold text-gray-900">Authority</th>
            <th class="text-left p-4 font-semibold text-gray-900">Contact</th>
            <th class="text-left p-4 font-semibold text-gray-900">Role</th>
            <th class="text-left p-4 font-semibold text-gray-900">Actions</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-gray-200">
          <?php foreach ($authorities as $a): ?>
            <tr class="hover:bg-gray-50 transition-colors duration-200">
              <td class="p-4">
                <div class="flex items-center">
                  <div class="w-10 h-10 bg-gradient-to-br from-green-500 to-green-600 rounded-full flex items-center justify-center mr-3">
                    <span class="text-white text-sm font-bold">
                      <?= strtoupper(substr($a['name'], 0, 1)) ?>
                    </span>
                  </div>
                  <div>
                    <div class="font-medium text-gray-900">#<?= $a['id'] ?> - <?= htmlspecialchars($a['name']) ?></div>
                    <div class="text-sm text-gray-500">Authority ID: <?= $a['id'] ?></div>
                  </div>
                </div>
              </td>
              <td class="p-4">
                <div class="text-sm">
                  <div class="font-medium text-gray-900"><?= htmlspecialchars($a['email']) ?></div>
                  <div class="text-gray-500">Email verified</div>
                </div>
              </td>
              <td class="p-4">
                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                  <?php
                  switch($a['role']) {
                    case 'admin': echo 'bg-purple-100 text-purple-800'; break;
                    case 'authority': echo 'bg-green-100 text-green-800'; break;
                    case 'citizen': echo 'bg-blue-100 text-blue-800'; break;
                    default: echo 'bg-gray-100 text-gray-800';
                  }
                  ?>">
                  <?php
                  switch($a['role']) {
                    case 'admin': echo '👑'; break;
                    case 'authority': echo '🛡️'; break;
                    case 'citizen': echo '👤'; break;
                  }
                  ?>
                  <?= ucfirst(htmlspecialchars($a['role'])) ?>
                </span>
              </td>
              <td class="p-4">
                <div class="flex items-center space-x-3">
                  <a href="<?= $base ?>/admin/edit-user?id=<?= $a['id'] ?>"
                     class="inline-flex items-center px-3 py-2 bg-green-50 hover:bg-green-100 text-green-700 rounded-lg text-sm font-medium transition-colors duration-200">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                    Edit
                  </a>
                  <a href="<?= $base ?>/admin/delete-user?id=<?= $a['id'] ?>"
                     class="inline-flex items-center px-3 py-2 bg-red-50 hover:bg-red-100 text-red-700 rounded-lg text-sm font-medium transition-colors duration-200"
                     onclick="return confirm('Are you sure you want to delete this authority?')">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                    </svg>
                    Delete
                  </a>
                </div>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>

    <?php if (empty($authorities)): ?>
      <div class="text-center py-12">
        <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
        </svg>
        <h4 class="text-lg font-medium text-gray-900 mb-2">No Authorities Found</h4>
        <p class="text-gray-500">There are currently no authorities in the system.</p>
      </div>
    <?php endif; ?>
  </div>
</div>

<!-- Enhanced Complaints Management -->
<div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden mb-8">
  <div class="bg-gradient-to-r from-purple-500 to-purple-600 p-6">
    <div class="flex items-center justify-between">
      <div class="flex items-center">
        <div class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center mr-3">
          <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
          </svg>
        </div>
        <div>
          <h3 class="text-xl font-semibold text-white">Complaints Management</h3>
          <p class="text-purple-100 text-sm">Monitor and manage all system complaints</p>
        </div>
      </div>
      <div class="text-right">
        <div class="text-2xl font-bold text-white"><?= count($allComplaints) ?></div>
        <div class="text-purple-100 text-sm">Total Complaints</div>
      </div>
    </div>
  </div>

  <div class="p-6">
    <div class="overflow-x-auto">
      <table class="w-full">
        <thead class="bg-gray-50">
          <tr>
            <th class="text-left p-4 font-semibold text-gray-900">Complaint</th>
            <th class="text-left p-4 font-semibold text-gray-900">Citizen</th>
            <th class="text-left p-4 font-semibold text-gray-900">Status</th>
            <th class="text-left p-4 font-semibold text-gray-900">Priority</th>
            <th class="text-left p-4 font-semibold text-gray-900">Actions</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-gray-200">
          <?php foreach ($allComplaints as $c): ?>
            <tr class="hover:bg-gray-50 transition-colors duration-200">
              <td class="p-4">
                <div class="flex items-center">
                  <div class="w-10 h-10 bg-gradient-to-br from-purple-500 to-purple-600 rounded-full flex items-center justify-center mr-3">
                    <span class="text-white text-sm font-bold">#<?= $c['id'] ?></span>
                  </div>
                  <div>
                    <div class="font-medium text-gray-900 max-w-xs truncate" title="<?= htmlspecialchars($c['title']) ?>">
                      <?= htmlspecialchars($c['title']) ?>
                    </div>
                    <div class="text-sm text-gray-500">ID: <?= $c['id'] ?></div>
                  </div>
                </div>
              </td>
              <td class="p-4">
                <div class="text-sm">
                  <div class="font-medium text-gray-900">
                    <?= htmlspecialchars($c['user_name'] ?? 'Unknown') ?>
                  </div>
                  <div class="text-gray-500">Citizen</div>
                </div>
              </td>
              <td class="p-4">
                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                  <?php
                  switch($c['status']) {
                    case 'Resolved': echo 'bg-green-100 text-green-800'; break;
                    case 'In Progress': echo 'bg-blue-100 text-blue-800'; break;
                    case 'Pending': echo 'bg-yellow-100 text-yellow-800'; break;
                    case 'Rejected': echo 'bg-red-100 text-red-800'; break;
                    default: echo 'bg-gray-100 text-gray-800';
                  }
                  ?>">
                  <?php
                  switch($c['status']) {
                    case 'Resolved': echo '✅'; break;
                    case 'In Progress': echo '🔄'; break;
                    case 'Pending': echo '⏳'; break;
                    case 'Rejected': echo '❌'; break;
                    default: echo '📋';
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
                    case 'Medium': echo 'bg-orange-100 text-orange-800'; break;
                    case 'Low': echo 'bg-green-100 text-green-800'; break;
                    default: echo 'bg-gray-100 text-gray-800';
                  }
                  ?>">
                  <?php
                  switch($c['priority']) {
                    case 'High': echo '🔴'; break;
                    case 'Medium': echo '🟡'; break;
                    case 'Low': echo '🟢'; break;
                    default: echo '⚪';
                  }
                  ?>
                  <?= htmlspecialchars($c['priority']) ?>
                </span>
              </td>
              <td class="p-4">
                <a href="<?= $base ?>/complaints/view?id=<?= $c['id'] ?>"
                   class="inline-flex items-center px-3 py-2 bg-purple-50 hover:bg-purple-100 text-purple-700 rounded-lg text-sm font-medium transition-colors duration-200">
                  <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                  </svg>
                  View Details
                </a>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>

    <?php if (empty($allComplaints)): ?>
      <div class="text-center py-12">
        <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
        </svg>
        <h4 class="text-lg font-medium text-gray-900 mb-2">No Complaints Found</h4>
        <p class="text-gray-500">There are currently no complaints in the system.</p>
      </div>
    <?php endif; ?>
  </div>
</div>

<!-- Enhanced Feedback Management -->
<div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
  <div class="bg-gradient-to-r from-yellow-500 to-orange-500 p-6">
    <div class="flex items-center justify-between">
      <div class="flex items-center">
        <div class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center mr-3">
          <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
          </svg>
        </div>
        <div>
          <h3 class="text-xl font-semibold text-white">Feedback Management</h3>
          <p class="text-orange-100 text-sm">Monitor user satisfaction and feedback</p>
        </div>
      </div>
      <div class="text-right">
        <div class="text-2xl font-bold text-white"><?= count($allFeedback ?? []) ?></div>
        <div class="text-orange-100 text-sm">Total Feedback</div>
      </div>
    </div>
  </div>

  <div class="p-6">
    <?php if (empty($allFeedback)): ?>
      <div class="text-center py-12">
        <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
        </svg>
        <h4 class="text-lg font-medium text-gray-900 mb-2">No Feedback Yet</h4>
        <p class="text-gray-500">No feedback has been submitted yet.</p>
      </div>
    <?php else: ?>
      <div class="space-y-6">
        <?php foreach ($allFeedback as $f): ?>
          <div class="bg-gray-50 rounded-xl p-6 border border-gray-200 hover:shadow-md transition-shadow duration-200">
            <div class="flex items-start justify-between mb-4">
              <div class="flex-1">
                <div class="flex items-center mb-2">
                  <div class="w-8 h-8 bg-gradient-to-br from-yellow-500 to-orange-500 rounded-full flex items-center justify-center mr-3">
                    <span class="text-white text-xs font-bold">C</span>
                  </div>
                  <div>
                    <h4 class="font-semibold text-gray-900">Complaint #<?= $f['complaint_id'] ?></h4>
                    <p class="text-sm text-gray-600 truncate max-w-md" title="<?= htmlspecialchars($f['complaint_title']) ?>">
                      <?= htmlspecialchars($f['complaint_title']) ?>
                    </p>
                  </div>
                </div>
                <div class="flex items-center text-sm text-gray-500 mb-3">
                  <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                  </svg>
                  By: <?= htmlspecialchars($f['user_name']) ?>
                  <span class="mx-2">•</span>
                  <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                  </svg>
                  <?= date('M j, Y g:i A', strtotime($f['created_at'])) ?>
                </div>
              </div>
              <div class="flex items-center bg-white rounded-lg px-3 py-2 shadow-sm">
                <?php for ($i = 1; $i <= 5; $i++): ?>
                  <span class="text-lg <?= $i <= $f['rating'] ? 'text-yellow-400' : 'text-gray-300' ?>">
                    <?php if ($i <= $f['rating']): ?>⭐<?php else: ?>☆<?php endif; ?>
                  </span>
                <?php endfor; ?>
                <span class="ml-2 text-sm font-medium text-gray-700">(<?= $f['rating'] ?>/5)</span>
              </div>
            </div>

            <?php if ($f['comment']): ?>
              <div class="bg-white rounded-lg p-4 border-l-4 border-orange-400">
                <div class="flex items-start">
                  <svg class="w-5 h-5 text-orange-400 mr-3 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                  </svg>
                  <div class="flex-1">
                    <p class="text-gray-700 leading-relaxed"><?= nl2br(htmlspecialchars($f['comment'])) ?></p>
                  </div>
                </div>
              </div>
            <?php endif; ?>
          </div>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>
  </div>
</div>

<script>
function toggleSection(section) {
  const content = document.getElementById(section + '-content');
  const button = document.getElementById(section + '-toggle');

  if (content.classList.contains('hidden')) {
    content.classList.remove('hidden');
    button.textContent = 'Hide';
  } else {
    content.classList.add('hidden');
    button.textContent = 'Show';
  }
}
</script>
