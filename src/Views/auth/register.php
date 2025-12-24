<div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-green-50 via-white to-blue-50 py-12 px-4 sm:px-6 lg:px-8">
  <div class="max-w-md w-full space-y-8">
    <!-- Header -->
    <div class="text-center">
      <div class="mx-auto h-16 w-16 bg-gradient-to-br from-green-500 to-blue-600 rounded-2xl flex items-center justify-center shadow-lg">
        <svg class="h-8 w-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
        </svg>
      </div>
      <h2 class="mt-6 text-3xl font-extrabold text-gray-900">Join Smart City</h2>
      <p class="mt-2 text-sm text-gray-600">Create your account to start reporting issues</p>
    </div>

    <!-- Info Banner -->
    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
      <div class="flex">
        <div class="flex-shrink-0">
          <svg class="h-5 w-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
          </svg>
        </div>
        <div class="ml-3">
          <h3 class="text-sm font-medium text-blue-800">Citizen Registration</h3>
          <div class="mt-1 text-sm text-blue-700">
            <p>Report issues and track complaints in your community.</p>
            <p class="mt-1"><strong>Note:</strong> Authority officers and administrators are created by existing admins.</p>
          </div>
        </div>
      </div>
    </div>

    <!-- Registration Form -->
    <div class="bg-white py-8 px-6 shadow-xl rounded-2xl border border-gray-100">
      <form method="POST" action="<?= $base ?>/register" class="space-y-6" id="registerForm">
        <input type="hidden" name="csrf" value="<?= csrf_token() ?>">

        <!-- Name Field -->
        <div>
          <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Full Name</label>
          <div class="relative">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
              <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
              </svg>
            </div>
            <input id="name" name="name" type="text" autocomplete="name" required
                   class="appearance-none relative block w-full px-10 py-3 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent focus:z-10 sm:text-sm transition-all duration-200"
                   placeholder="Enter your full name">
          </div>
        </div>

        <!-- Email Field -->
        <div>
          <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email Address</label>
          <div class="relative">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
              <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"></path>
              </svg>
            </div>
            <input id="email" name="email" type="email" autocomplete="email" required
                   class="appearance-none relative block w-full px-10 py-3 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent focus:z-10 sm:text-sm transition-all duration-200"
                   placeholder="Enter your email">
          </div>
        </div>

        <!-- Phone Field -->
        <div>
          <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">Phone Number <span class="text-gray-500">(optional)</span></label>
          <div class="relative">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
              <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
              </svg>
            </div>
            <input id="phone" name="phone" type="tel" autocomplete="tel"
                   class="appearance-none relative block w-full px-10 py-3 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent focus:z-10 sm:text-sm transition-all duration-200"
                   placeholder="Enter your phone number">
          </div>
        </div>

        <!-- Address Field -->
        <div>
          <label for="address" class="block text-sm font-medium text-gray-700 mb-2">Address <span class="text-gray-500">(optional)</span></label>
          <div class="relative">
            <div class="absolute top-3 left-0 pl-3 flex items-start pointer-events-none">
              <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
              </svg>
            </div>
            <textarea id="address" name="address" rows="3"
                      class="appearance-none relative block w-full px-10 py-3 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent focus:z-10 sm:text-sm transition-all duration-200"
                      placeholder="Enter your address"></textarea>
          </div>
        </div>

        <!-- Password Field -->
        <div>
          <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Password</label>
          <div class="relative">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
              <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
              </svg>
            </div>
            <input id="password" name="password" type="password" autocomplete="new-password" required minlength="8"
                   class="appearance-none relative block w-full px-10 py-3 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent focus:z-10 sm:text-sm transition-all duration-200"
                   placeholder="Create a strong password">
          </div>
          <div class="mt-1 text-xs text-gray-500">
            Must be at least 8 characters long
          </div>
        </div>

        <!-- Confirm Password Field -->
        <div>
          <label for="confirm_password" class="block text-sm font-medium text-gray-700 mb-2">Confirm Password</label>
          <div class="relative">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
              <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
              </svg>
            </div>
            <input id="confirm_password" name="confirm_password" type="password" autocomplete="new-password" required
                   class="appearance-none relative block w-full px-10 py-3 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent focus:z-10 sm:text-sm transition-all duration-200"
                   placeholder="Confirm your password">
          </div>
        </div>

        <!-- Terms and Conditions -->
        <div class="flex items-start">
          <div class="flex items-center h-5">
            <input id="terms" name="terms" type="checkbox" required
                   class="h-4 w-4 text-green-600 focus:ring-green-500 border-gray-300 rounded">
          </div>
          <div class="ml-3 text-sm">
            <label for="terms" class="text-gray-700">
              I agree to the <a href="#" class="text-green-600 hover:text-green-500">Terms and Conditions</a> and <a href="#" class="text-green-600 hover:text-green-500">Privacy Policy</a>
            </label>
          </div>
        </div>

        <!-- Submit Button -->
        <div>
          <button type="submit" class="group relative w-full flex justify-center py-3 px-4 border border-transparent text-sm font-medium rounded-lg text-white bg-gradient-to-r from-green-600 to-blue-600 hover:from-green-700 hover:to-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transform hover:scale-105 transition-all duration-200 shadow-lg">
            <span class="absolute left-0 inset-y-0 flex items-center pl-3">
              <svg class="h-5 w-5 text-green-500 group-hover:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
              </svg>
            </span>
            Create Account
          </button>
        </div>
      </form>

      <!-- Password Strength Indicator (Optional Enhancement) -->
      <div id="passwordStrength" class="mt-4 hidden">
        <div class="text-sm font-medium text-gray-700 mb-2">Password Strength</div>
        <div class="w-full bg-gray-200 rounded-full h-2">
          <div id="strengthBar" class="h-2 rounded-full transition-all duration-300"></div>
        </div>
        <div id="strengthText" class="text-xs text-gray-500 mt-1"></div>
      </div>
    </div>

    <!-- Login Link -->
    <div class="text-center">
      <p class="text-sm text-gray-600">
        Already have an account?
        <a href="<?= $base ?>/login" class="font-medium text-green-600 hover:text-green-500 transition-colors duration-200">Sign in here</a>
      </p>
    </div>
  </div>
</div>

<style>
  .animate-float {
    animation: float 6s ease-in-out infinite;
  }
  @keyframes float {
    0%, 100% { transform: translateY(0px); }
    50% { transform: translateY(-10px); }
  }
</style>

<script>
  // Password strength indicator
  document.getElementById('password').addEventListener('input', function() {
    const password = this.value;
    const strengthBar = document.getElementById('strengthBar');
    const strengthText = document.getElementById('strengthText');
    const passwordStrength = document.getElementById('passwordStrength');

    if (password.length === 0) {
      passwordStrength.classList.add('hidden');
      return;
    }

    passwordStrength.classList.remove('hidden');

    let strength = 0;
    let feedback = [];

    if (password.length >= 8) strength += 25;
    else feedback.push('At least 8 characters');

    if (/[a-z]/.test(password)) strength += 25;
    else feedback.push('Lowercase letter');

    if (/[A-Z]/.test(password)) strength += 25;
    else feedback.push('Uppercase letter');

    if (/[0-9]/.test(password)) strength += 25;
    else feedback.push('Number');

    strengthBar.style.width = strength + '%';

    if (strength < 25) {
      strengthBar.style.backgroundColor = '#ef4444';
      strengthText.textContent = 'Weak';
      strengthText.style.color = '#ef4444';
    } else if (strength < 50) {
      strengthBar.style.backgroundColor = '#f97316';
      strengthText.textContent = 'Fair';
      strengthText.style.color = '#f97316';
    } else if (strength < 75) {
      strengthBar.style.backgroundColor = '#eab308';
      strengthText.textContent = 'Good';
      strengthText.style.color = '#eab308';
    } else {
      strengthBar.style.backgroundColor = '#22c55e';
      strengthText.textContent = 'Strong';
      strengthText.style.color = '#22c55e';
    }
  });

  // Form validation
  document.getElementById('registerForm').addEventListener('submit', function(e) {
    const password = document.getElementById('password').value;
    const confirmPassword = document.getElementById('confirm_password').value;

    if (password !== confirmPassword) {
      e.preventDefault();
      alert('Passwords do not match. Please try again.');
      return;
    }

    if (password.length < 8) {
      e.preventDefault();
      alert('Password must be at least 8 characters long.');
      return;
    }
  });
</script>
