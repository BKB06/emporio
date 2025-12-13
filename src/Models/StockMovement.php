<?php

namespace App\Models;

use App\Core\Model;
use App\Core\Database;

class StockMovement extends Model
{
    protected static string $table = 'stock_movements';
    
    public static function withRelations(): array
    {
        $sql = "SELECT sm.*, p.name as product_name, p.sku, u.username 
                FROM stock_movements sm
                INNER JOIN products p ON sm.product_id = p.id
                INNER JOIN users u ON sm.user_id = u.id
                ORDER BY sm.created_at DESC
                LIMIT 100";
        return Database::query($sql)->fetchAll();
    }
    
    public static function getRecent(int $limit = 10): array
    {
        $sql = "SELECT sm.*, p.name as product_name, p.sku, u.username 
                FROM stock_movements sm
                INNER JOIN products p ON sm.product_id = p.id
                INNER JOIN users u ON sm.user_id = u.id
                ORDER BY sm.created_at DESC
                LIMIT ?";
        return Database::query($sql, [$limit])->fetchAll();
    }
    
    public static function getByProduct(int $productId): array
    {
        $sql = "SELECT sm.*, u.username 
                FROM stock_movements sm
                INNER JOIN users u ON sm.user_id = u.id
                WHERE sm.product_id = ?
                ORDER BY sm.created_at DESC";
        return Database::query($sql, [$productId])->fetchAll();
    }
    
    public static function getByPeriod(string $startDate, string $endDate): array
    {
        $sql = "SELECT sm.*, p.name as product_name, p.sku, u.username 
                FROM stock_movements sm
                INNER JOIN products p ON sm.product_id = p.id
                INNER JOIN users u ON sm.user_id = u.id
                WHERE DATE(sm.created_at) BETWEEN ? AND ?
                ORDER BY sm.created_at DESC";
        return Database::query($sql, [$startDate, $endDate])->fetchAll();
    }
}
