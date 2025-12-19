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
  <nav class="bg-white shadow">
    <div class="max-w-6xl mx-auto px-4 py-3 flex justify-between items-center">
      <a href="<?= $base ?>/" class="text-xl font-semibold">AI Smart City</a>
      <div class="space-x-4">
        <a class="hover:underline" href="<?= $base ?>/">Home</a>
        <a class="hover:underline" href="<?= $base ?>/complaints">Complaints</a>
        <?php if (empty($_SESSION['user'])): ?>
        <a class="hover:underline" href="<?= $base ?>/login">Login</a>
        <a class="hover:underline" href="<?= $base ?>/register">Register</a>
        <?php else: ?>
        <a class="hover:underline" href="<?= $base ?>/dashboard">Dashboard</a>
        <a class="hover:underline" href="<?= $base ?>/logout">Logout</a>
        <?php endif; ?>
      </div>
    </div>
  </nav>

  <main class="max-w-6xl mx-auto p-4">
    <?php if (!empty($_SESSION['flash'])): ?>
      <div class="bg-yellow-100 border border-yellow-300 px-4 py-2 rounded mb-4"> <?= htmlspecialchars($_SESSION['flash']); unset($_SESSION['flash']); ?> </div>
    <?php endif; ?>
    <?php include $template; ?>
  </main>

  <footer class="text-center text-sm text-gray-500 py-6">&copy; <?= date('Y') ?> Smart City</footer>
</body>
</html>
