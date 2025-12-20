<?php
// Layout wrapper expects $template, $title, optional $tileUrl, $tileAttr
$base = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/');
?><!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title><?= htmlspecialchars($title ?? 'App') ?></title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
  <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
</head>
<body class="bg-gray-50 text-gray-800">

  <main class="max-w-6xl mx-auto p-4">
    <?php if (!empty($_SESSION['flash'])): ?>
      <div class="bg-yellow-100 border border-yellow-300 px-4 py-2 rounded mb-4"> <?= htmlspecialchars($_SESSION['flash']); unset($_SESSION['flash']); ?> </div>
    <?php endif; ?>
    <?php include $template; ?>
  </main>

  <footer class="text-center text-sm text-gray-500 py-6">&copy; <?= date('Y') ?> Smart City</footer>
</body>
</html>
