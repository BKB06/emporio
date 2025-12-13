<?php

namespace App\Core;

abstract class Controller
{
    protected function view(string $view, array $data = []): void
    {
        View::render($view, $data);
    }
    
    protected function redirect(string $path): void
    {
        View::redirect($path);
    }
    
    protected function back(): void
    {
        View::back();
    }
    
    protected function json(mixed $data, int $status = 200): void
    {
        http_response_code($status);
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }
    
    protected function requireAuth(): void
    {
        if (!Auth::check()) {
            Session::flash('error', 'Você precisa estar autenticado.');
            $this->redirect('/login');
        }
    }
    
    protected function requireRole(string $role): void
    {
        $this->requireAuth();
        
        if (!Auth::hasRole($role)) {
            Session::flash('error', 'Você não tem permissão para acessar esta página.');
            $this->redirect('/dashboard');
        }
    }
}
