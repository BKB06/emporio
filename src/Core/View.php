<?php

namespace App\Core;

class View
{
    public static function render(string $view, array $data = []): void
    {
        extract($data);
        
        $viewPath = __DIR__ . "/../Views/{$view}.php";
        
        if (!file_exists($viewPath)) {
            die("View não encontrada: {$view}");
        }
        
        require $viewPath;
    }
    
    public static function redirect(string $path): void
    {
        header("Location: {$path}");
        exit;
    }
    
    public static function back(): void
    {
        header("Location: " . ($_SERVER['HTTP_REFERER'] ?? '/'));
        exit;
    }
    
    public static function escape(string $string): string
    {
        return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
    }
}
