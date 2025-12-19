<?php
// Front controller
require_once __DIR__ . '/../src/bootstrap.php';

use App\Core\Router;
use App\Controllers\AuthController;
use App\Controllers\ComplaintController;
use App\Controllers\DashboardController;

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
$router->get('/complaints/new', [ComplaintController::class, 'create']);
$router->post('/complaints', [ComplaintController::class, 'store']);
$router->get('/complaints', [ComplaintController::class, 'list']);
$router->get('/complaints/view', [ComplaintController::class, 'view']);
$router->post('/complaints/update-status', [ComplaintController::class, 'updateStatus']);
$router->post('/complaints/resolve', [ComplaintController::class, 'resolve']);

$router->dispatch();
