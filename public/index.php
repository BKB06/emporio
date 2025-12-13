<?php

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../config/config.php';

use App\Core\Router;
use App\Core\Session;

Session::start();

$router = new Router();

// Rotas de autenticação
$router->get('/', 'HomeController', 'index');
$router->get('/login', 'AuthController', 'showLogin');
$router->post('/login', 'AuthController', 'login');
$router->get('/register', 'AuthController', 'showRegister');
$router->post('/register', 'AuthController', 'register');
$router->get('/logout', 'AuthController', 'logout');

// Dashboard
$router->get('/dashboard', 'HomeController', 'dashboard');

// Produtos
$router->get('/products', 'ProductController', 'index');
$router->get('/products/create', 'ProductController', 'create');
$router->post('/products', 'ProductController', 'store');
$router->get('/products/{id}', 'ProductController', 'show');
$router->get('/products/{id}/edit', 'ProductController', 'edit');
$router->post('/products/{id}/update', 'ProductController', 'update');
$router->post('/products/{id}/delete', 'ProductController', 'delete');

// Categorias
$router->get('/categories', 'CategoryController', 'index');
$router->get('/categories/create', 'CategoryController', 'create');
$router->post('/categories', 'CategoryController', 'store');
$router->post('/categories/{id}/delete', 'CategoryController', 'delete');

// Fornecedores
$router->get('/suppliers', 'SupplierController', 'index');
$router->get('/suppliers/create', 'SupplierController', 'create');
$router->post('/suppliers', 'SupplierController', 'store');
$router->post('/suppliers/{id}/delete', 'SupplierController', 'delete');

// Estoque
$router->get('/stock', 'StockController', 'index');
$router->get('/stock/movement', 'StockController', 'showMovement');
$router->post('/stock/movement', 'StockController', 'storeMovement');

// Relatórios
$router->get('/reports', 'ReportController', 'index');
$router->get('/reports/pdf', 'ReportController', 'exportPdf');

// Usuários
$router->get('/users', 'UserController', 'index');

$router->dispatch();
