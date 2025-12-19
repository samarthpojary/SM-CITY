<div class="max-w-md mx-auto bg-white p-6 rounded shadow">
  <h2 class="text-xl font-semibold mb-4">Login</h2>
  <form method="POST" action="/login" class="space-y-4">
    <input type="hidden" name="csrf" value="<?= csrf_token() ?>">
    <div>
      <label class="block text-sm mb-1">Email</label>
      <input class="w-full border rounded px-3 py-2" type="email" name="email" required />
    </div>
    <div>
      <label class="block text-sm mb-1">Password</label>
      <input class="w-full border rounded px-3 py-2" type="password" name="password" required />
    </div>
    <button class="bg-blue-600 text-white px-4 py-2 rounded" type="submit">Login</button>
  </form>
</div>
