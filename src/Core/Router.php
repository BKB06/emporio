<?php

namespace App\Core;

class Router
{
    private array $routes = [];
    
    public function add(string $method, string $path, string $controller, string $action): void
    {
        $this->routes[] = [
            'method' => strtoupper($method),
            'path' => $path,
            'controller' => $controller,
            'action' => $action
        ];
    }
    
    public function get(string $path, string $controller, string $action): void
    {
        $this->add('GET', $path, $controller, $action);
    }
    
    public function post(string $path, string $controller, string $action): void
    {
        $this->add('POST', $path, $controller, $action);
    }
    
    public function dispatch(): void
    {
        $method = $_SERVER['REQUEST_METHOD'];
        $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        
        // Remover /public/ do path se existir
        $path = preg_replace('#^/public#', '', $path);
        
        foreach ($this->routes as $route) {
            $pattern = '#^' . preg_replace('#\{([a-z]+)\}#', '([0-9]+)', $route['path']) . '$#';
            
            if ($route['method'] === $method && preg_match($pattern, $path, $matches)) {
                array_shift($matches); // Remove o match completo
                
                $controllerClass = "App\\Controllers\\{$route['controller']}";
                $controller = new $controllerClass();
                
                call_user_func_array([$controller, $route['action']], $matches);
                return;
            }
        }
        
        // Rota não encontrada
        http_response_code(404);
        View::render('errors/404');
    }
}
