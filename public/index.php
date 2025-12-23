<?php
// Front controller
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once __DIR__ . '/../src/bootstrap.php';

use App\Core\Router;
use App\Controllers\AuthController;
use App\Controllers\ComplaintController;
use App\Controllers\DashboardController;
use App\Controllers\ProfileController;

$router = new Router();

// Public routes
$router->get('/', [DashboardController::class, 'landing']);
$router->get('/login', [AuthController::class, 'showLogin']);
$router->post('/login', [AuthController::class, 'login']);
$router->get('/register', [AuthController::class, 'showRegister']);
$router->post('/register', [AuthController::class, 'register']);
$router->get('/logout', [AuthController::class, 'logout']);

// Authenticated routes
$router->get('/dashboard', [DashboardController::class, 'index']);
$router->get('/admin/dashboard', [DashboardController::class, 'adminDashboard']);
$router->get('/authority/dashboard', [DashboardController::class, 'authorityDashboard']);
$router->get('/citizen/dashboard', [DashboardController::class, 'citizenDashboard']);
$router->get('/complaints/new', [ComplaintController::class, 'create']);
$router->post('/complaints', [ComplaintController::class, 'store']);
$router->get('/complaints', [ComplaintController::class, 'list']);
$router->get('/complaints/view', [ComplaintController::class, 'view']);
$router->post('/complaints/update-status', [ComplaintController::class, 'updateStatus']);
$router->post('/complaints/resolve', [ComplaintController::class, 'resolve']);
$router->post('/complaints/assign-authority', [ComplaintController::class, 'assignAuthority']);
$router->post('/complaints/add-feedback', [ComplaintController::class, 'addFeedback']);
$router->get('/profile', [ProfileController::class, 'show']);
$router->post('/profile', [ProfileController::class, 'update']);

try {
    $router->dispatch();
} catch (Exception $e) {
    echo "<h1>Application Error</h1>";
    echo "<p><strong>Error:</strong> " . htmlspecialchars($e->getMessage()) . "</p>";
    echo "<p><strong>File:</strong> " . htmlspecialchars($e->getFile()) . "</p>";
    echo "<p><strong>Line:</strong> " . $e->getLine() . "</p>";
    echo "<hr>";
    echo "<pre>" . $e->getTraceAsString() . "</pre>";
}
