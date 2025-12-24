<?php $user = $user ?? $_SESSION['user']; ?>
<div class="mb-6">
  <a href="javascript:history.back()" class="inline-flex items-center px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg transition-colors duration-200">
    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
    </svg>
    Back
  </a>
</div>
<div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-8">
  <h2 class="text-3xl font-bold mb-6 text-gray-900">Profile Settings</h2>
  <form method="POST" action="<?= $base ?>/profile" class="space-y-4">
    <input type="hidden" name="csrf" value="<?= csrf_token() ?>" />
    <div>
      <label class="block text-sm font-medium mb-1">Name</label>
      <input type="text" name="name" value="<?= htmlspecialchars($user['name']) ?>" class="w-full border rounded px-3 py-2" required />
    </div>
    <div>
      <label class="block text-sm font-medium mb-1">Email</label>
      <input type="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" class="w-full border rounded px-3 py-2" required />
    </div>
    <div>
      <label class="block text-sm font-medium mb-1">Phone</label>
      <input type="text" name="phone" value="<?= htmlspecialchars($user['phone'] ?? '') ?>" class="w-full border rounded px-3 py-2" />
    </div>
    <div>
      <label class="block text-sm font-medium mb-1">Address</label>
      <textarea name="address" class="w-full border rounded px-3 py-2" rows="3"><?= htmlspecialchars($user['address'] ?? '') ?></textarea>
    </div>
    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Update Profile</button>
  </form>
</div>
