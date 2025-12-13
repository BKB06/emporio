<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Session;
use App\Core\Validator;
use App\Models\Product;
use App\Models\Category;
use App\Models\Supplier;

class ProductController extends Controller
{
    public function index(): void
    {
        $this->requireAuth();
        
        $search = $_GET['search'] ?? '';
        $page = (int)($_GET['page'] ?? 1);
        
        if ($search) {
            $result = Product::search($search, $page, 10);
        } else {
            $products = Product::withRelations();
            $result = [
                'items' => array_slice($products, ($page - 1) * 10, 10),
                'total' => count($products),
                'page' => $page,
                'perPage' => 10,
                'lastPage' => ceil(count($products) / 10)
            ];
        }
        
        $this->view('products/index', [
            'products' => $result['items'],
            'pagination' => $result,
            'search' => $search
        ]);
    }
    
    public function show(int $id): void
    {
        $this->requireAuth();
        
        $product = Product::findWithRelations($id);
        
        if (!$product) {
            Session::flash('error', 'Produto não encontrado.');
            $this->redirect('/products');
        }
        
        $this->view('products/show', ['product' => $product]);
    }
    
    public function create(): void
    {
        $this->requireAuth();
        
        $categories = Category::all();
        $suppliers = Supplier::all();
        
        $this->view('products/create', [
            'categories' => $categories,
            'suppliers' => $suppliers
        ]);
    }
    
    public function store(): void
    {
        $this->requireAuth();
        
        $validator = new Validator();
        
        if (!$validator->validate($_POST, [
            'sku' => 'required|unique:products,sku',
            'name' => 'required|max:200',
            'category_id' => 'required|numeric',
            'supplier_id' => 'required|numeric',
            'quantity' => 'required|numeric',
            'min_quantity' => 'required|numeric',
            'unit_price' => 'required|numeric',
        ])) {
            Session::flash('errors', $validator->errors());
            $this->back();
            return;
        }
        
        Product::create([
            'sku' => $_POST['sku'],
            'barcode' => $_POST['barcode'] ?? null,
            'name' => $_POST['name'],
            'description' => $_POST['description'] ?? null,
            'category_id' => $_POST['category_id'],
            'supplier_id' => $_POST['supplier_id'],
            'quantity' => $_POST['quantity'],
            'min_quantity' => $_POST['min_quantity'],
            'unit_price' => $_POST['unit_price'],
            'status' => $_POST['status'] ?? 'ativo',
        ]);
        
        Session::flash('success', 'Produto cadastrado com sucesso!');
        $this->redirect('/products');
    }
    
    public function edit(int $id): void
    {
        $this->requireAuth();
        
        $product = Product::find($id);
        
        if (!$product) {
            Session::flash('error', 'Produto não encontrado.');
            $this->redirect('/products');
        }
        
        $categories = Category::all();
        $suppliers = Supplier::all();
        
        $this->view('products/edit', [
            'product' => $product,
            'categories' => $categories,
            'suppliers' => $suppliers
        ]);
    }
    
    public function update(int $id): void
    {
        $this->requireAuth();
        
        $validator = new Validator();
        
        if (!$validator->validate($_POST, [
            'name' => 'required|max:200',
            'category_id' => 'required|numeric',
            'supplier_id' => 'required|numeric',
            'min_quantity' => 'required|numeric',
            'unit_price' => 'required|numeric',
        ])) {
            Session::flash('errors', $validator->errors());
            $this->back();
            return;
        }
        
        Product::update($id, [
            'barcode' => $_POST['barcode'] ?? null,
            'name' => $_POST['name'],
            'description' => $_POST['description'] ?? null,
            'category_id' => $_POST['category_id'],
            'supplier_id' => $_POST['supplier_id'],
            'min_quantity' => $_POST['min_quantity'],
            'unit_price' => $_POST['unit_price'],
            'status' => $_POST['status'] ?? 'ativo',
        ]);
        
        Session::flash('success', 'Produto atualizado com sucesso!');
        $this->redirect('/products');
    }
    
    public function delete(int $id): void
    {
        $this->requireAuth();
        
        Product::delete($id);
        
        Session::flash('success', 'Produto removido com sucesso!');
        $this->redirect('/products');
    }
}
