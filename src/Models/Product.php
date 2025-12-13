<?php

namespace App\Models;

use App\Core\Model;
use App\Core\Database;

class Product extends Model
{
    protected static string $table = 'products';
    
    public static function withRelations(): array
    {
        $sql = "SELECT p.*, c.name as category_name, s.name as supplier_name 
                FROM products p
                LEFT JOIN categories c ON p.category_id = c.id
                LEFT JOIN suppliers s ON p.supplier_id = s.id
                ORDER BY p.id DESC";
        return Database::query($sql)->fetchAll();
    }
    
    public static function findWithRelations(int $id): ?array
    {
        $sql = "SELECT p.*, c.name as category_name, s.name as supplier_name 
                FROM products p
                LEFT JOIN categories c ON p.category_id = c.id
                LEFT JOIN suppliers s ON p.supplier_id = s.id
                WHERE p.id = ?";
        $result = Database::query($sql, [$id])->fetch();
        return $result ?: null;
    }
    
    public static function getLowStock(): array
    {
        $sql = "SELECT p.*, c.name as category_name 
                FROM products p
                LEFT JOIN categories c ON p.category_id = c.id
                WHERE p.quantity <= p.min_quantity AND p.status = 'ativo'
                ORDER BY p.quantity ASC";
        return Database::query($sql)->fetchAll();
    }
    
    public static function getTotalValue(): float
    {
        $sql = "SELECT SUM(quantity * unit_price) as total FROM products WHERE status = 'ativo'";
        return (float) Database::query($sql)->fetchColumn();
    }
    
    public static function search(string $search, int $page = 1, int $perPage = 10): array
    {
        $offset = ($page - 1) * $perPage;
        
        $sql = "SELECT p.*, c.name as category_name, s.name as supplier_name 
                FROM products p
                LEFT JOIN categories c ON p.category_id = c.id
                LEFT JOIN suppliers s ON p.supplier_id = s.id
                WHERE p.name LIKE ? OR p.sku LIKE ? OR p.barcode LIKE ?
                ORDER BY p.id DESC
                LIMIT ? OFFSET ?";
        
        $searchTerm = "%{$search}%";
        $items = Database::query($sql, [$searchTerm, $searchTerm, $searchTerm, $perPage, $offset])->fetchAll();
        
        $countSql = "SELECT COUNT(*) FROM products WHERE name LIKE ? OR sku LIKE ? OR barcode LIKE ?";
        $total = Database::query($countSql, [$searchTerm, $searchTerm, $searchTerm])->fetchColumn();
        
        return [
            'items' => $items,
            'total' => $total,
            'page' => $page,
            'perPage' => $perPage,
            'lastPage' => ceil($total / $perPage)
        ];
    }
}
