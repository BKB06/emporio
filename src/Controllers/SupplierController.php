<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Session;
use App\Core\Validator;
use App\Models\Supplier;

class SupplierController extends Controller
{
    public function index(): void
    {
        $this->requireAuth();
        
        $suppliers = Supplier::all();
        
        $this->view('suppliers/index', ['suppliers' => $suppliers]);
    }
    
    public function create(): void
    {
        $this->requireAuth();
        
        $this->view('suppliers/create');
    }
    
    public function store(): void
    {
        $this->requireAuth();
        
        $validator = new Validator();
        
        if (!$validator->validate($_POST, [
            'name' => 'required|max:200',
            'email' => 'email',
        ])) {
            Session::flash('errors', $validator->errors());
            $this->back();
            return;
        }
        
        Supplier::create([
            'name' => $_POST['name'],
            'cnpj' => $_POST['cnpj'] ?? null,
            'email' => $_POST['email'] ?? null,
            'phone' => $_POST['phone'] ?? null,
            'address' => $_POST['address'] ?? null,
        ]);
        
        Session::flash('success', 'Fornecedor cadastrado com sucesso!');
        $this->redirect('/suppliers');
    }
    
    public function delete(int $id): void
    {
        $this->requireAuth();
        
        Supplier::delete($id);
        
        Session::flash('success', 'Fornecedor removido com sucesso!');
        $this->redirect('/suppliers');
    }
}
