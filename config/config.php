<?php

// Carregar variáveis de ambiente
if (file_exists(__DIR__ . '/../.env')) {
    $lines = file(__DIR__ . '/../.env', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        if (strpos(trim($line), '#') === 0) {
            continue;
        }
        list($name, $value) = explode('=', $line, 2);
        $_ENV[trim($name)] = trim($value);
    }
}

// Configurações da aplicação
define('APP_NAME', $_ENV['APP_NAME'] ?? 'Sistema Empório');
define('APP_URL', $_ENV['APP_URL'] ?? 'http://localhost:8000');
define('APP_ENV', $_ENV['APP_ENV'] ?? 'development');

// Configurações de sessão
define('SESSION_LIFETIME', $_ENV['SESSION_LIFETIME'] ?? 7200);

// Timezone
date_default_timezone_set('America/Sao_Paulo');

// Error reporting
if (APP_ENV === 'development') {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
} else {
    error_reporting(0);
    ini_set('display_errors', 0);
}
