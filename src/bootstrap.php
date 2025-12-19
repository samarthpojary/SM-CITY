<?php
// Basic bootstrap
session_start();

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

function view($template, $data = []) {
    extract($data);
    $tileUrl = env('LEAFLET_TILE_URL');
    $tileAttr = env('LEAFLET_ATTRIBUTION');
    include __DIR__ . '/Views/layout.php';
}

function redirect($path) {
    header('Location: ' . $path);
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
