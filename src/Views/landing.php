<?php $ms = $markers ?? []; ?>
<section class="grid md:grid-cols-2 gap-6 items-start">
  <div>
    <h1 class="text-3xl font-bold mb-2">AI-Powered Smart City Complaint System</h1>
    <p class="text-gray-600 mb-4">Report issues like garbage, potholes, water leakage, drainage, and streetlights. Track status and view them on the map.</p>
    <div class="space-x-3">
      <a href="<?= $base ?>/register" class="bg-blue-600 text-white px-4 py-2 rounded">Get Started</a>
      <a href="<?= $base ?>/complaints" class="bg-gray-200 px-4 py-2 rounded">Browse Complaints</a>
    </div>
  </div>
  <div>
    <div id="map" class="w-full h-96 rounded shadow"></div>
  </div>
</section>
<script>
  const map = L.map('map').setView([20.5937, 78.9629], 5);
  L.tileLayer('<?= $tileUrl ?>', { attribution: '<?= $tileAttr ?>' }).addTo(map);
  const markers = <?= json_encode($ms) ?>;
  markers.forEach(m => {
    if (!m.latitude || !m.longitude) return;
    const marker = L.marker([parseFloat(m.latitude), parseFloat(m.longitude)]).addTo(map);
    marker.bindPopup(`<strong>${m.title}</strong><br/>${m.category} | ${m.priority} | ${m.status}`);
  })
</script>
