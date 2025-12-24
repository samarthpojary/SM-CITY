<?php
// Basic bootstrap
session_start();

// Session timeout (30 minutes)
if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 1800)) {
    session_destroy();
    header('Location: ' . (isset($_SERVER['HTTP_HOST']) ? 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['SCRIPT_NAME']) . '/' : '/'));
    exit;
}
$_SESSION['LAST_ACTIVITY'] = time();

// Simple autoloader
spl_autoload_register(function ($class) {
    $prefix = 'App\\';
    $base_dir = __DIR__ . '/';
    $len = strlen($prefix);
    if (strncmp($prefix, $class, $len) !== 0) {
        return;
    }
    $relative_class = substr($class, $len);
    $file = $base_dir . str_replace('\\', '/', $relative_class) . '.php';
    if (file_exists($file)) {
        require $file;
    }
});

// Load env
$envPath = __DIR__ . '/../.env';
if (file_exists($envPath)) {
    $lines = file($envPath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        if (str_starts_with(trim($line), '#')) continue;
        [$k, $v] = array_map('trim', explode('=', $line, 2));
        $_ENV[$k] = $v;
    }
} else {
    // fallback to example
    $lines = file(__DIR__ . '/../.env.example', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        if (str_starts_with(trim($line), '#')) continue;
        [$k, $v] = array_map('trim', explode('=', $line, 2));
        $_ENV[$k] = $v;
    }
}

// Global helpers
function env($key, $default = null) {
    return $_ENV[$key] ?? $default;
}

function base_url() {
    return rtrim(dirname($_SERVER['SCRIPT_NAME']), '/');
}

function project_base_url() {
    return dirname(base_url());
}

function view($template, $data = [], $layout = 'layout.php') {
    extract($data);
    $tileUrl = env('LEAFLET_TILE_URL');
    $tileAttr = env('LEAFLET_ATTRIBUTION');
    $base = base_url();
    $dashboard_url = '/' . ($_SESSION['user']['role'] ?? 'citizen') . '/dashboard';
    include __DIR__ . '/Views/' . $layout;
}

function redirect($path) {
    header('Location: ' . base_url() . $path);
    exit;
}

function csrf_token() {
    if (empty($_SESSION['csrf'])) {
        $_SESSION['csrf'] = bin2hex(random_bytes(16));
    }
    return $_SESSION['csrf'];
}

function csrf_verify($token) {
    return isset($_SESSION['csrf']) && hash_equals($_SESSION['csrf'], $token);
}

// Caching functions
function cache_get($key) {
    $cacheFile = __DIR__ . '/../cache/' . md5($key) . '.cache';
    if (file_exists($cacheFile) && (time() - filemtime($cacheFile) < 3600)) { // 1 hour cache
        return unserialize(file_get_contents($cacheFile));
    }
    return false;
}

function cache_set($key, $data, $ttl = 3600) {
    $cacheDir = __DIR__ . '/../cache/';
    if (!is_dir($cacheDir)) {
        mkdir($cacheDir, 0755, true);
    }
    $cacheFile = $cacheDir . md5($key) . '.cache';
    file_put_contents($cacheFile, serialize($data));
}

function cache_delete($key) {
    $cacheFile = __DIR__ . '/../cache/' . md5($key) . '.cache';
    if (file_exists($cacheFile)) {
        unlink($cacheFile);
    }
}
