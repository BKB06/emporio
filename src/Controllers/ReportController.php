<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\Product;
use App\Models\StockMovement;

class ReportController extends Controller
{
    public function index(): void
    {
        $this->requireAuth();
        
        $type = $_GET['type'] ?? 'stock';
        $startDate = $_GET['start_date'] ?? date('Y-m-01');
        $endDate = $_GET['end_date'] ?? date('Y-m-d');
        
        $data = [];
        
        switch ($type) {
            case 'stock':
                $data = Product::withRelations();
                break;
                
            case 'low_stock':
                $data = Product::getLowStock();
                break;
                
            case 'movements':
                $data = StockMovement::getByPeriod($startDate, $endDate);
                break;
        }
        
        $this->view('reports/index', [
            'type' => $type,
            'data' => $data,
            'startDate' => $startDate,
            'endDate' => $endDate
        ]);
    }
    
    public function exportPdf(): void
    {
        $this->requireAuth();
        
        // Implementação básica - pode ser expandida com DomPDF
        $type = $_GET['type'] ?? 'stock';
        
        header('Content-Type: application/pdf');
        header('Content-Disposition: attachment; filename="relatorio_' . $type . '_' . date('Y-m-d') . '.pdf"');
        
        // Por enquanto, retornar mensagem
        echo "Funcionalidade de exportação PDF em desenvolvimento.\n";
        echo "Use DomPDF para gerar relatórios completos.";
    }
}
