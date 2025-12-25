<div class="mb-6">
  <a href="javascript:history.back()" class="inline-flex items-center px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg transition-colors duration-200">
    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
    </svg>
    Back
  </a>
</div>
<div class="max-w-4xl mx-auto bg-white rounded-2xl shadow-xl border border-gray-100 p-8">
  <div class="mb-8">
    <div class="flex items-center justify-between mb-4">
      <h2 class="text-4xl font-bold text-gray-900">Submit a New Complaint</h2>
      <div class="text-sm text-gray-500" id="stepIndicator">Step 1 of 4</div>
    </div>
    <p class="text-gray-600 mb-4">Help us improve our city by reporting issues</p>
    <div class="w-full bg-gray-200 rounded-full h-2.5">
      <div class="bg-blue-600 h-2.5 rounded-full transition-all duration-300" id="progressBar" style="width: 25%"></div>
    </div>
  </div>

  <form method="POST" action="<?= $base ?>/complaints" enctype="multipart/form-data" class="space-y-6" id="complaintForm">
    <input type="hidden" name="csrf" value="<?= csrf_token() ?>" />

    <!-- Basic Information Section -->
    <div class="bg-gray-50 rounded-xl p-6">
      <h3 class="text-xl font-semibold text-gray-800 mb-4 flex items-center">
        <svg class="w-6 h-6 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
        </svg>
        Basic Information
      </h3>

      <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-2">Complaint Title</label>
          <input class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all" type="text" name="title" placeholder="Brief title for your complaint" required />
          <p class="text-xs text-gray-500 mt-1">Keep it concise and descriptive</p>
        </div>

        <div>
          <label class="block text-sm font-medium text-gray-700 mb-2">Category</label>
          <select name="category" class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
            <option value="">Select a category</option>
            <option value="Infrastructure">Infrastructure</option>
            <option value="Sanitation">Sanitation</option>
            <option value="Public Safety">Public Safety</option>
            <option value="Environment">Environment</option>
            <option value="Traffic">Traffic</option>
            <option value="Utilities">Utilities</option>
            <option value="Other">Other</option>
          </select>
        </div>
      </div>

      <div class="mt-6">
        <label class="block text-sm font-medium text-gray-700 mb-2">Detailed Description</label>
        <textarea class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all" name="description" rows="5" placeholder="Please provide detailed information about the issue..." required></textarea>
        <p class="text-xs text-gray-500 mt-1">Include as much detail as possible to help us understand and resolve the issue</p>
      </div>
    </div>

    <!-- Location Section -->
    <div class="bg-gray-50 rounded-xl p-6">
      <h3 class="text-xl font-semibold text-gray-800 mb-4 flex items-center">
        <svg class="w-6 h-6 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
        </svg>
        Location Details
      </h3>

      <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-2">Latitude</label>
          <input id="lat" class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all" type="number" step="0.000001" name="latitude" placeholder="e.g., 28.6139" required />
        </div>
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-2">Longitude</label>
          <input id="lng" class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all" type="number" step="0.000001" name="longitude" placeholder="e.g., 77.2090" required />
        </div>
      </div>

      <div class="mb-4">
        <button type="button" id="getLocationBtn" class="inline-flex items-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg transition-colors duration-200">
          <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
          </svg>
          Use My Current Location
        </button>
        <p class="text-xs text-gray-500 mt-1">Click to automatically fill coordinates</p>
      </div>

      <div id="map" class="w-full h-80 rounded-lg border border-gray-300 shadow-sm"></div>
      <p class="text-xs text-gray-500 mt-2">Click on the map to set the exact location</p>
    </div>

    <!-- Evidence Section -->
    <div class="bg-gray-50 rounded-xl p-6">
      <h3 class="text-xl font-semibold text-gray-800 mb-4 flex items-center">
        <svg class="w-6 h-6 mr-2 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
        </svg>
        Supporting Evidence
      </h3>

      <div>
        <label class="block text-sm font-medium text-gray-700 mb-2">Upload Image (Optional)</label>
        <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center hover:border-purple-400 transition-colors">
          <input type="file" name="image" accept="image/*" id="imageInput" class="hidden" />
          <label for="imageInput" class="cursor-pointer">
            <svg class="w-12 h-12 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
            </svg>
            <p class="text-gray-600">Click to upload an image</p>
            <p class="text-xs text-gray-500 mt-1">PNG, JPG, GIF up to 10MB</p>
          </label>
        </div>
        <div id="imagePreview" class="mt-4 hidden">
          <img id="previewImg" src="" alt="Preview" class="max-w-full h-48 object-cover rounded-lg border">
        </div>
      </div>
    </div>

    <!-- Submit Section -->
    <div class="bg-blue-50 rounded-xl p-6">
      <div class="flex flex-col sm:flex-row justify-between items-center">
        <div class="mb-4 sm:mb-0">
          <h4 class="text-lg font-semibold text-gray-800">Ready to Submit?</h4>
          <p class="text-sm text-gray-600">Please review your information before submitting</p>
        </div>
        <button type="submit" class="inline-flex items-center px-8 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-semibold transition-colors duration-200 shadow-lg">
          <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
          </svg>
          Submit Complaint
        </button>
      </div>
    </div>
  </form>
</div>
<script>
  // Init map & geolocation pick
  const map = L.map('map').setView([20.5937, 78.9629], 5);
  L.tileLayer('<?= $tileUrl ?>', { attribution: '<?= $tileAttr ?>' }).addTo(map);
  let marker;
  function setLatLng(latlng){
    document.getElementById('lat').value = latlng.lat.toFixed(6);
    document.getElementById('lng').value = latlng.lng.toFixed(6);
    if (marker) marker.setLatLng(latlng); else marker = L.marker(latlng).addTo(map);
    updateProgress();
  }
  map.on('click', (e)=> setLatLng(e.latlng));
  if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(pos=>{
      const latlng = {lat: pos.coords.latitude, lng: pos.coords.longitude};
      map.setView(latlng, 14);
      setLatLng(latlng);
    });
  }

  // Progress bar and step indicator
  function updateProgress() {
    const form = document.getElementById('complaintForm');
    const inputs = form.querySelectorAll('input[required], textarea[required], select[required]');
    let filled = 0;
    inputs.forEach(input => {
      if (input.value.trim() !== '') filled++;
    });
    const progress = (filled / inputs.length) * 100;
    document.getElementById('progressBar').style.width = progress + '%';
    const step = Math.min(Math.ceil(progress / 25), 4);
    document.getElementById('stepIndicator').textContent = `Step ${step} of 4`;
  }

  // Add event listeners for real-time updates
  document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('complaintForm');
    const inputs = form.querySelectorAll('input, textarea, select');
    inputs.forEach(input => {
      input.addEventListener('input', updateProgress);
      input.addEventListener('change', updateProgress);
    });
    updateProgress(); // Initial update
  });
</script>
