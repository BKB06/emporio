<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Auth;
use App\Models\Product;
use App\Models\StockMovement;

class HomeController extends Controller
{
    public function index(): void
    {
        if (Auth::check()) {
            $this->redirect('/dashboard');
        }
        
        $this->redirect('/login');
    }
    
    public function dashboard(): void
    {
        $this->requireAuth();
        
        // Estatísticas
        $totalProducts = count(Product::all());
        $totalValue = Product::getTotalValue();
        $lowStock = Product::getLowStock();
        $recentMovements = StockMovement::getRecent(10);
        
        $this->view('dashboard/index', [
            'totalProducts' => $totalProducts,
            'totalValue' => $totalValue,
            'lowStock' => $lowStock,
            'recentMovements' => $recentMovements
        ]);
    }
}
