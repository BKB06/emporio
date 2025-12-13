<?php

namespace App\Models;

use App\Core\Model;
use App\Core\Database;

class Category extends Model
{
    protected static string $table = 'categories';
    
    public static function withParent(): array
    {
        $sql = "SELECT c.*, p.name as parent_name 
                FROM categories c
                LEFT JOIN categories p ON c.parent_id = p.id
                ORDER BY c.id DESC";
        return Database::query($sql)->fetchAll();
    }
    
    public static function getParents(): array
    {
        $sql = "SELECT * FROM categories WHERE parent_id IS NULL ORDER BY name";
        return Database::query($sql)->fetchAll();
    }
}
