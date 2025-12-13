<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Session;
use App\Core\Validator;
use App\Models\Category;

class CategoryController extends Controller
{
    public function index(): void
    {
        $this->requireAuth();
        
        $categories = Category::withParent();
        
        $this->view('categories/index', ['categories' => $categories]);
    }
    
    public function create(): void
    {
        $this->requireAuth();
        
        $parents = Category::getParents();
        
        $this->view('categories/create', ['parents' => $parents]);
    }
    
    public function store(): void
    {
        $this->requireAuth();
        
        $validator = new Validator();
        
        if (!$validator->validate($_POST, [
            'name' => 'required|max:100',
        ])) {
            Session::flash('errors', $validator->errors());
            $this->back();
            return;
        }
        
        Category::create([
            'name' => $_POST['name'],
            'description' => $_POST['description'] ?? null,
            'parent_id' => !empty($_POST['parent_id']) ? $_POST['parent_id'] : null,
        ]);
        
        Session::flash('success', 'Categoria cadastrada com sucesso!');
        $this->redirect('/categories');
    }
    
    public function delete(int $id): void
    {
        $this->requireAuth();
        
        Category::delete($id);
        
        Session::flash('success', 'Categoria removida com sucesso!');
        $this->redirect('/categories');
    }
}
