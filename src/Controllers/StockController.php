<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Session;
use App\Core\Auth;
use App\Core\Validator;
use App\Models\Product;
use App\Models\StockMovement;

class StockController extends Controller
{
    public function index(): void
    {
        $this->requireAuth();
        
        $movements = StockMovement::withRelations();
        
        $this->view('stock/index', ['movements' => $movements]);
    }
    
    public function showMovement(): void
    {
        $this->requireAuth();
        
        $products = Product::all();
        
        $this->view('stock/movement', ['products' => $products]);
    }
    
    public function storeMovement(): void
    {
        $this->requireAuth();
        
        $validator = new Validator();
        
        if (!$validator->validate($_POST, [
            'product_id' => 'required|numeric',
            'type' => 'required',
            'quantity' => 'required|numeric',
        ])) {
            Session::flash('errors', $validator->errors());
            $this->back();
            return;
        }
        
        $productId = (int)$_POST['product_id'];
        $type = $_POST['type'];
        $quantity = (int)$_POST['quantity'];
        
        // Buscar produto atual
        $product = Product::find($productId);
        
        if (!$product) {
            Session::flash('error', 'Produto não encontrado.');
            $this->back();
            return;
        }
        
        // Calcular nova quantidade
        $newQuantity = $product['quantity'];
        
        if ($type === 'entrada' || $type === 'ajuste') {
            $newQuantity += $quantity;
        } elseif ($type === 'saida') {
            $newQuantity -= $quantity;
            
            // Validar estoque negativo
            if ($newQuantity < 0) {
                Session::flash('error', 'Estoque insuficiente para esta operação.');
                $this->back();
                return;
            }
        }
        
        // Atualizar quantidade do produto
        Product::update($productId, ['quantity' => $newQuantity]);
        
        // Registrar movimentação
        StockMovement::create([
            'product_id' => $productId,
            'user_id' => Auth::id(),
            'type' => $type,
            'quantity' => $quantity,
            'reason' => $_POST['reason'] ?? null,
            'notes' => $_POST['notes'] ?? null,
        ]);
        
        Session::flash('success', 'Movimentação registrada com sucesso!');
        $this->redirect('/stock');
    }
}
