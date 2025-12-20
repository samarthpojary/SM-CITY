<?php $user = $user ?? $_SESSION['user']; ?>
<div class="bg-white rounded shadow p-6">
  <h2 class="text-2xl font-semibold mb-4">Profile</h2>
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
