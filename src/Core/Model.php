<?php

namespace App\Core;

abstract class Model
{
    protected static string $table;
    
    public static function all(): array
    {
        $sql = "SELECT * FROM " . static::$table;
        return Database::query($sql)->fetchAll();
    }
    
    public static function find(int $id): ?array
    {
        $sql = "SELECT * FROM " . static::$table . " WHERE id = ?";
        $result = Database::query($sql, [$id])->fetch();
        return $result ?: null;
    }
    
    public static function create(array $data): int
    {
        $fields = array_keys($data);
        $placeholders = array_fill(0, count($fields), '?');
        
        $sql = "INSERT INTO " . static::$table . " (" . implode(', ', $fields) . ") VALUES (" . implode(', ', $placeholders) . ")";
        Database::query($sql, array_values($data));
        
        return (int) Database::getInstance()->lastInsertId();
    }
    
    public static function update(int $id, array $data): bool
    {
        $fields = array_keys($data);
        $set = implode(' = ?, ', $fields) . ' = ?';
        
        $sql = "UPDATE " . static::$table . " SET {$set} WHERE id = ?";
        $values = array_values($data);
        $values[] = $id;
        
        Database::query($sql, $values);
        return true;
    }
    
    public static function delete(int $id): bool
    {
        $sql = "DELETE FROM " . static::$table . " WHERE id = ?";
        Database::query($sql, [$id]);
        return true;
    }
    
    public static function paginate(int $page = 1, int $perPage = 10, string $search = ''): array
    {
        $offset = ($page - 1) * $perPage;
        
        $whereCond = '';
        $params = [];
        
        if (!empty($search)) {
            $whereCond = " WHERE name LIKE ?";
            $params[] = "%{$search}%";
        }
        
        $sql = "SELECT * FROM " . static::$table . $whereCond . " LIMIT ? OFFSET ?";
        $params[] = $perPage;
        $params[] = $offset;
        
        $items = Database::query($sql, $params)->fetchAll();
        
        $countSql = "SELECT COUNT(*) FROM " . static::$table . $whereCond;
        $total = Database::query($countSql, array_slice($params, 0, -2))->fetchColumn();
        
        return [
            'items' => $items,
            'total' => $total,
            'page' => $page,
            'perPage' => $perPage,
            'lastPage' => ceil($total / $perPage)
        ];
    }
}
