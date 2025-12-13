<?php

namespace App\Core;

use App\Models\User;

class Auth
{
    public static function attempt(string $email, string $password): bool
    {
        $user = User::findByEmail($email);
        
        if ($user && password_verify($password, $user['password'])) {
            self::login($user);
            return true;
        }
        
        return false;
    }
    
    public static function login(array $user): void
    {
        Session::regenerate();
        Session::set('user_id', $user['id']);
        Session::set('user_email', $user['email']);
        Session::set('user_role', $user['role']);
        Session::set('user_username', $user['username']);
    }
    
    public static function logout(): void
    {
        Session::destroy();
    }
    
    public static function check(): bool
    {
        return Session::has('user_id');
    }
    
    public static function user(): ?array
    {
        if (!self::check()) {
            return null;
        }
        
        return [
            'id' => Session::get('user_id'),
            'email' => Session::get('user_email'),
            'role' => Session::get('user_role'),
            'username' => Session::get('user_username'),
        ];
    }
    
    public static function id(): ?int
    {
        return Session::get('user_id');
    }
    
    public static function hasRole(string $role): bool
    {
        $user = self::user();
        return $user && $user['role'] === $role;
    }
    
    public static function isAdmin(): bool
    {
        return self::hasRole('Admin');
    }
    
    public static function isGerente(): bool
    {
        return self::hasRole('Gerente');
    }
    
    public static function canManage(): bool
    {
        return self::isAdmin() || self::isGerente();
    }
}
