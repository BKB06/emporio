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
        
        $type = $_GET['type'] ?? 'stock';
        $startDate = $_GET['start_date'] ?? date('Y-m-01');
        $endDate = $_GET['end_date'] ?? date('Y-m-d');
        
        // Buscar dados baseado no tipo de relatório
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
        
        // Gerar HTML do relatório
        $html = $this->generateReportHtml($type, $data, $startDate, $endDate);
        
        // Configurar DomPDF
        $options = new \Dompdf\Options();
        $options->set('defaultFont', 'DejaVu Sans');
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isRemoteEnabled', false);
        
        $dompdf = new \Dompdf\Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        
        // Enviar PDF para download
        $filename = 'relatorio_' . $type . '_' . date('Y-m-d') . '.pdf';
        $dompdf->stream($filename, ['Attach' => true]);
    }
    
    private function generateReportHtml(string $type, array $data, string $startDate, string $endDate): string
    {
        $reportTitles = [
            'stock' => 'Estoque Atual - Todos os Produtos',
            'low_stock' => 'Produtos com Estoque Baixo',
            'movements' => 'Movimentações de Estoque'
        ];
        
        $title = $reportTitles[$type] ?? 'Relatório';
        $generatedAt = date('d/m/Y H:i');
        
        // CSS para o PDF
        $css = '
        <style>
            * { margin: 0; padding: 0; box-sizing: border-box; }
            body { font-family: DejaVu Sans, sans-serif; font-size: 10pt; color: #333; }
            .header { background-color: #0d6efd; color: white; padding: 20px; text-align: center; margin-bottom: 20px; }
            .header h1 { font-size: 20pt; margin-bottom: 5px; }
            .header .subtitle { font-size: 10pt; }
            .info-section { margin-bottom: 15px; padding: 10px; background-color: #f8f9fa; }
            .info-section p { margin: 3px 0; }
            table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
            th { background-color: #0d6efd; color: white; padding: 8px; text-align: left; font-size: 9pt; }
            td { padding: 6px 8px; border-bottom: 1px solid #dee2e6; font-size: 9pt; }
            tr:nth-child(even) { background-color: #f8f9fa; }
            .text-right { text-align: right; }
            .text-center { text-align: center; }
            .badge { padding: 2px 6px; border-radius: 3px; font-size: 8pt; font-weight: bold; }
            .badge-success { background-color: #198754; color: white; }
            .badge-danger { background-color: #dc3545; color: white; }
            .badge-warning { background-color: #ffc107; color: black; }
            .low-stock { color: #dc3545; font-weight: bold; }
            .footer { margin-top: 30px; padding-top: 10px; border-top: 2px solid #0d6efd; text-align: center; font-size: 8pt; color: #666; }
            .total-row { background-color: #cfe2ff; font-weight: bold; }
        </style>
        ';
        
        // Iniciar HTML
        $html = '<!DOCTYPE html><html><head><meta charset="UTF-8">' . $css . '</head><body>';
        
        // Header
        $html .= '<div class="header">';
        $html .= '<h1>🏪 EMPÓRIO - Sistema de Gestão</h1>';
        $html .= '<div class="subtitle">' . htmlspecialchars($title) . '</div>';
        $html .= '</div>';
        
        // Info Section
        $html .= '<div class="info-section">';
        $html .= '<p><strong>Data de Geração:</strong> ' . $generatedAt . '</p>';
        if ($type === 'movements') {
            $html .= '<p><strong>Período:</strong> ' . date('d/m/Y', strtotime($startDate)) . ' até ' . date('d/m/Y', strtotime($endDate)) . '</p>';
        }
        $html .= '<p><strong>Total de Registros:</strong> ' . count($data) . '</p>';
        $html .= '</div>';
        
        // Conteúdo específico por tipo de relatório
        if ($type === 'stock') {
            $html .= $this->generateStockTable($data);
        } elseif ($type === 'low_stock') {
            $html .= $this->generateLowStockTable($data);
        } elseif ($type === 'movements') {
            $html .= $this->generateMovementsTable($data);
        }
        
        // Footer
        $html .= '<div class="footer">';
        $html .= '<p>Empório - Sistema de Gestão de Armazém</p>';
        $html .= '<p>Relatório gerado automaticamente em ' . $generatedAt . '</p>';
        $html .= '</div>';
        
        $html .= '</body></html>';
        
        return $html;
    }
    
    private function generateStockTable(array $data): string
    {
        $html = '<table>';
        $html .= '<thead><tr>';
        $html .= '<th>SKU</th>';
        $html .= '<th>Produto</th>';
        $html .= '<th>Categoria</th>';
        $html .= '<th>Fornecedor</th>';
        $html .= '<th class="text-right">Qtd.</th>';
        $html .= '<th class="text-right">Mín.</th>';
        $html .= '<th class="text-right">Valor Unit.</th>';
        $html .= '<th class="text-right">Valor Total</th>';
        $html .= '</tr></thead><tbody>';
        
        $totalValue = 0;
        foreach ($data as $product) {
            $itemValue = $product['quantity'] * $product['unit_price'];
            $totalValue += $itemValue;
            
            $isLowStock = $product['quantity'] <= $product['min_quantity'];
            $qtyClass = $isLowStock ? ' class="low-stock"' : '';
            
            $html .= '<tr>';
            $html .= '<td>' . htmlspecialchars($product['sku']) . '</td>';
            $html .= '<td>' . htmlspecialchars($product['name']) . '</td>';
            $html .= '<td>' . htmlspecialchars($product['category_name'] ?? '-') . '</td>';
            $html .= '<td>' . htmlspecialchars($product['supplier_name'] ?? '-') . '</td>';
            $html .= '<td' . $qtyClass . ' class="text-right">' . $product['quantity'] . '</td>';
            $html .= '<td class="text-right">' . $product['min_quantity'] . '</td>';
            $html .= '<td class="text-right">R$ ' . number_format($product['unit_price'], 2, ',', '.') . '</td>';
            $html .= '<td class="text-right">R$ ' . number_format($itemValue, 2, ',', '.') . '</td>';
            $html .= '</tr>';
        }
        
        // Linha de total
        $html .= '<tr class="total-row">';
        $html .= '<td colspan="7" class="text-right"><strong>VALOR TOTAL DO ESTOQUE:</strong></td>';
        $html .= '<td class="text-right"><strong>R$ ' . number_format($totalValue, 2, ',', '.') . '</strong></td>';
        $html .= '</tr>';
        
        $html .= '</tbody></table>';
        
        return $html;
    }
    
    private function generateLowStockTable(array $data): string
    {
        if (empty($data)) {
            return '<p class="text-center">Nenhum produto com estoque baixo no momento.</p>';
        }
        
        $html = '<table>';
        $html .= '<thead><tr>';
        $html .= '<th>SKU</th>';
        $html .= '<th>Produto</th>';
        $html .= '<th>Categoria</th>';
        $html .= '<th>Fornecedor</th>';
        $html .= '<th class="text-right">Qtd. Atual</th>';
        $html .= '<th class="text-right">Qtd. Mínima</th>';
        $html .= '<th class="text-right">Diferença</th>';
        $html .= '<th class="text-right">Valor Unit.</th>';
        $html .= '</tr></thead><tbody>';
        
        foreach ($data as $product) {
            $difference = $product['min_quantity'] - $product['quantity'];
            
            $html .= '<tr>';
            $html .= '<td>' . htmlspecialchars($product['sku']) . '</td>';
            $html .= '<td>' . htmlspecialchars($product['name']) . '</td>';
            $html .= '<td>' . htmlspecialchars($product['category_name'] ?? '-') . '</td>';
            $html .= '<td>' . htmlspecialchars($product['supplier_name'] ?? '-') . '</td>';
            $html .= '<td class="text-right low-stock">' . $product['quantity'] . '</td>';
            $html .= '<td class="text-right">' . $product['min_quantity'] . '</td>';
            $html .= '<td class="text-right low-stock">-' . $difference . '</td>';
            $html .= '<td class="text-right">R$ ' . number_format($product['unit_price'], 2, ',', '.') . '</td>';
            $html .= '</tr>';
        }
        
        $html .= '</tbody></table>';
        
        return $html;
    }
    
    private function generateMovementsTable(array $data): string
    {
        if (empty($data)) {
            return '<p class="text-center">Nenhuma movimentação encontrada no período.</p>';
        }
        
        $html = '<table>';
        $html .= '<thead><tr>';
        $html .= '<th>Data/Hora</th>';
        $html .= '<th>Produto</th>';
        $html .= '<th>SKU</th>';
        $html .= '<th class="text-center">Tipo</th>';
        $html .= '<th class="text-right">Quantidade</th>';
        $html .= '<th>Observação</th>';
        $html .= '<th>Usuário</th>';
        $html .= '</tr></thead><tbody>';
        
        foreach ($data as $movement) {
            $badgeClass = $movement['type'] === 'entrada' ? 'badge-success' : 'badge-danger';
            $typeLabel = ucfirst($movement['type']);
            
            $html .= '<tr>';
            $html .= '<td>' . date('d/m/Y H:i', strtotime($movement['created_at'])) . '</td>';
            $html .= '<td>' . htmlspecialchars($movement['product_name']) . '</td>';
            $html .= '<td>' . htmlspecialchars($movement['sku']) . '</td>';
            $html .= '<td class="text-center"><span class="badge ' . $badgeClass . '">' . $typeLabel . '</span></td>';
            $html .= '<td class="text-right">' . $movement['quantity'] . '</td>';
            $html .= '<td>' . htmlspecialchars($movement['reason'] ?? '-') . '</td>';
            $html .= '<td>' . htmlspecialchars($movement['username']) . '</td>';
            $html .= '</tr>';
        }
        
        $html .= '</tbody></table>';
        
        return $html;
    }
}
