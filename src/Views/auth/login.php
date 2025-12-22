<div class="max-w-md mx-auto bg-white p-6 rounded shadow">
  <h2 class="text-xl font-semibold mb-4">Login</h2>

  <?php
  $role = $role ?? '';
  $roleMessage = '';
  if ($role === 'admin') {
      $roleMessage = '<div class="bg-purple-100 border border-purple-300 text-purple-700 px-4 py-2 rounded mb-4 text-sm">Logging in as Administrator</div>';
  } elseif ($role === 'authority') {
      $roleMessage = '<div class="bg-green-100 border border-green-300 text-green-700 px-4 py-2 rounded mb-4 text-sm">Logging in as Authority Officer</div>';
  } else {
      $roleMessage = '<div class="bg-blue-100 border border-blue-300 text-blue-700 px-4 py-2 rounded mb-4 text-sm">Logging in as Citizen</div>';
  }
  echo $roleMessage;
  ?>

  <form method="POST" action="<?= $base ?>/login" class="space-y-4">
    <input type="hidden" name="csrf" value="<?= csrf_token() ?>">
    <input type="hidden" name="role" value="<?= htmlspecialchars($_GET['role'] ?? '') ?>">
    <div>
      <label class="block text-sm mb-1">Email</label>
      <input class="w-full border rounded px-3 py-2" type="email" name="email" required />
    </div>
    <div>
      <label class="block text-sm mb-1">Password</label>
      <input class="w-full border rounded px-3 py-2" type="password" name="password" required />
    </div>
    <button class="bg-blue-600 text-white px-4 py-2 rounded w-full" type="submit">Login</button>
  </form>

  <div class="mt-4 text-center">
    <p class="text-sm text-gray-600">
      Don't have an account?
      <a href="<?= $base ?>/register" class="text-blue-600 hover:underline">Register here</a>
    </p>
  </div>
</div>
