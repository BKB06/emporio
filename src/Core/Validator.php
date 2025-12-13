<?php

namespace App\Core;

class Validator
{
    private array $errors = [];
    
    public function validate(array $data, array $rules): bool
    {
        $this->errors = [];
        
        foreach ($rules as $field => $ruleSet) {
            $ruleList = explode('|', $ruleSet);
            $value = $data[$field] ?? null;
            
            foreach ($ruleList as $rule) {
                if (strpos($rule, ':') !== false) {
                    [$ruleName, $ruleValue] = explode(':', $rule, 2);
                } else {
                    $ruleName = $rule;
                    $ruleValue = null;
                }
                
                $this->applyRule($field, $value, $ruleName, $ruleValue);
            }
        }
        
        return empty($this->errors);
    }
    
    private function applyRule(string $field, mixed $value, string $rule, ?string $ruleValue): void
    {
        switch ($rule) {
            case 'required':
                if (empty($value) && $value !== '0') {
                    $this->errors[$field][] = "O campo {$field} é obrigatório.";
                }
                break;
                
            case 'email':
                if (!empty($value) && !filter_var($value, FILTER_VALIDATE_EMAIL)) {
                    $this->errors[$field][] = "O campo {$field} deve ser um e-mail válido.";
                }
                break;
                
            case 'min':
                if (!empty($value) && strlen($value) < (int)$ruleValue) {
                    $this->errors[$field][] = "O campo {$field} deve ter no mínimo {$ruleValue} caracteres.";
                }
                break;
                
            case 'max':
                if (!empty($value) && strlen($value) > (int)$ruleValue) {
                    $this->errors[$field][] = "O campo {$field} deve ter no máximo {$ruleValue} caracteres.";
                }
                break;
                
            case 'numeric':
                if (!empty($value) && !is_numeric($value)) {
                    $this->errors[$field][] = "O campo {$field} deve ser numérico.";
                }
                break;
                
            case 'unique':
                // Format: unique:table,column
                if (!empty($value) && $ruleValue) {
                    [$table, $column] = explode(',', $ruleValue);
                    $sql = "SELECT COUNT(*) FROM {$table} WHERE {$column} = ?";
                    $result = Database::query($sql, [$value])->fetchColumn();
                    if ($result > 0) {
                        $this->errors[$field][] = "O {$field} já está em uso.";
                    }
                }
                break;
        }
    }
    
    public function errors(): array
    {
        return $this->errors;
    }
    
    public function firstError(string $field): ?string
    {
        return $this->errors[$field][0] ?? null;
    }
}
