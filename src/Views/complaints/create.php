<div class="max-w-2xl mx-auto bg-white p-6 rounded shadow">
  <h2 class="text-xl font-semibold mb-4">Submit Complaint</h2>
  <form method="POST" action="/complaints" enctype="multipart/form-data" class="space-y-4">
    <input type="hidden" name="csrf" value="<?= csrf_token() ?>" />
    <div>
      <label class="block text-sm mb-1">Title</label>
      <input class="w-full border rounded px-3 py-2" type="text" name="title" required />
    </div>
    <div>
      <label class="block text-sm mb-1">Description</label>
      <textarea class="w-full border rounded px-3 py-2" name="description" rows="4" required></textarea>
    </div>
    <div class="grid grid-cols-2 gap-4">
      <div>
        <label class="block text-sm mb-1">Latitude</label>
        <input id="lat" class="w-full border rounded px-3 py-2" type="number" step="0.000001" name="latitude" required />
      </div>
      <div>
        <label class="block text-sm mb-1">Longitude</label>
        <input id="lng" class="w-full border rounded px-3 py-2" type="number" step="0.000001" name="longitude" required />
      </div>
    </div>
    <div>
      <label class="block text-sm mb-1">Image</label>
      <input type="file" name="image" accept="image/*" />
    </div>
    <div id="map" class="w-full h-72 rounded"></div>
    <button class="bg-blue-600 text-white px-4 py-2 rounded" type="submit">Submit</button>
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
  }
  map.on('click', (e)=> setLatLng(e.latlng));
  if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(pos=>{
      const latlng = {lat: pos.coords.latitude, lng: pos.coords.longitude};
      map.setView(latlng, 14);
      setLatLng(latlng);
    });
  }
</script>
