<div class="max-w-md mx-auto bg-white p-6 rounded shadow">
  <h2 class="text-xl font-semibold mb-4">Register</h2>

  <div class="bg-blue-100 border border-blue-300 text-blue-700 px-4 py-2 rounded mb-4 text-sm">
    Register as a Citizen to report issues and track complaints.
    <br><strong>Note:</strong> Authority Officers and Administrators must be created by existing admins.
  </div>

  <form method="POST" action="/register" class="space-y-4">
    <input type="hidden" name="csrf" value="<?= csrf_token() ?>">
    <div>
      <label class="block text-sm mb-1">Name</label>
      <input class="w-full border rounded px-3 py-2" type="text" name="name" required />
    </div>
    <div>
      <label class="block text-sm mb-1">Email</label>
      <input class="w-full border rounded px-3 py-2" type="email" name="email" required />
    </div>
    <div>
      <label class="block text-sm mb-1">Password</label>
      <input class="w-full border rounded px-3 py-2" type="password" name="password" required minlength="6" />
    </div>
    <div>
      <label class="block text-sm mb-1">Role</label>
      <select class="w-full border rounded px-3 py-2" name="role">
        <option value="citizen">Citizen</option>
        <option value="officer" disabled>Authority/Officer (Contact Admin)</option>
        <option value="admin" disabled>Admin (Contact Admin)</option>
      </select>
    </div>
    <button class="bg-green-600 text-white px-4 py-2 rounded w-full" type="submit">Create Citizen Account</button>
  </form>

  <div class="mt-4 text-center">
    <p class="text-sm text-gray-600">
      Already have an account?
      <a href="/login" class="text-blue-600 hover:underline">Login here</a>
    </p>
  </div>
</div>
