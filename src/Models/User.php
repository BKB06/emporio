<?php

namespace App\Models;

use App\Core\Model;
use App\Core\Database;

class User extends Model
{
    protected static string $table = 'users';
    
    public static function findByEmail(string $email): ?array
    {
        $sql = "SELECT * FROM users WHERE email = ?";
        $result = Database::query($sql, [$email])->fetch();
        return $result ?: null;
    }
    
    public static function register(array $data): int
    {
        $data['password'] = password_hash($data['password'], PASSWORD_BCRYPT);
        return self::create($data);
    }
}
