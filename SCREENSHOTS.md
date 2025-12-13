# 📸 Sistema Empório - Interface Overview

This document describes the visual interface and user experience of the Sistema Empório.

## 🎨 Design Theme

### Color Palette
- **Primary**: Gradient Purple/Blue (#667eea → #764ba2)
- **Success**: Pink/Red Gradient (#f093fb → #f5576c)
- **Warning**: Peach Gradient (#fad0c4 → #ffd1ff)
- **Info**: Blue Gradient (#a1c4fd → #c2e9fb)
- **Dark**: #212529 (navbar and sidebar)
- **Light**: #f5f5f5 (background)

### Typography
- Font Family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif
- Icons: Bootstrap Icons 1.10.0

## 📱 Screen Descriptions

### 1. Login Page (`/login`)
**Full-screen authentication page**
```
┌─────────────────────────────────────────┐
│   [Purple Gradient Background]          │
│                                          │
│   ┌────────────────────────────┐        │
│   │  [Box Icon - Large]         │        │
│   │  Sistema Empório            │        │
│   │  Faça login para continuar  │        │
│   │                             │        │
│   │  📧 E-mail                  │        │
│   │  [input field]              │        │
│   │                             │        │
│   │  🔒 Senha                   │        │
│   │  [input field]              │        │
│   │                             │        │
│   │  [Entrar Button - Full]     │        │
│   │                             │        │
│   │  Não tem conta? [Registre-se]│      │
│   │                             │        │
│   │  Credenciais padrão:        │        │
│   │  admin@emporio.com/admin123 │        │
│   └────────────────────────────┘        │
└─────────────────────────────────────────┘
```

### 2. Dashboard (`/dashboard`)
**Main dashboard with statistics and alerts**
```
┌─────────────────────────────────────────────────────────┐
│ [Navbar Dark - Fixed]  Sistema Empório    [User] ▼     │
├────────────┬────────────────────────────────────────────┤
│ [Sidebar]  │  Dashboard                                 │
│            │                                            │
│ Dashboard  │  ┌────────┐ ┌────────┐ ┌────────┐ ┌────┐│
│ Produtos   │  │Total   │ │Valor   │ │Estoque │ │Mov ││
│ Categorias │  │Produtos│ │Estoque │ │Baixo   │ │Rec ││
│ Fornec.    │  │  150   │ │R$25.5k │ │   12   │ │ 45 ││
│ Estoque    │  │[Purple]│ │[Pink]  │ │[Peach] │ │[Sky│
│ Relatórios │  └────────┘ └────────┘ └────────┘ └────┘│
│ Usuários   │                                            │
│            │  ┌──────────────────┐ ┌──────────────────┐│
│            │  │ Estoque Baixo    │ │ Últimas Moviment.││
│            │  │ ⚠️ [Warning]     │ │ 🕐 [Recent]      ││
│            │  │                  │ │                  ││
│            │  │ [Table with 5]   │ │ [Table with 10]  ││
│            │  │ low stock items  │ │ recent movements ││
│            │  │                  │ │                  ││
│            │  │ [Ver todos →]    │ │ [Ver histórico →]││
│            │  └──────────────────┘ └──────────────────┘│
└────────────┴────────────────────────────────────────────┘
```

### 3. Products List (`/products`)
**Product management interface**
```
┌─────────────────────────────────────────────────────────┐
│ [Navbar + Sidebar]                                      │
├────────────┬────────────────────────────────────────────┤
│ [Sidebar]  │  Produtos          [+ Novo Produto]        │
│            │                                            │
│            │  ┌─────────────────────────────────┐      │
│            │  │ 🔍 [Search box]      [Buscar]  │      │
│            │  └─────────────────────────────────┘      │
│            │                                            │
│            │  ┌────────────────────────────────────────┐│
│            │  │ SKU │ Nome │ Cat │ For │ Qtd │ Status ││
│            │  ├─────┼──────┼─────┼─────┼─────┼────────┤│
│            │  │PRD1│Prod A│Food │Sup1 │ 50  │[✓Ativo]││
│            │  │PRD2│Prod B│Drink│Sup2 │ 15  │[✓Ativo]││
│            │  │PRD3│Prod C│Clean│Sup1 │  5  │[!Baixo]││
│            │  │     │      │     │     │     │ [Ações]││
│            │  └────────────────────────────────────────┘│
│            │  [◄] 1 2 3 4 5 [►]                         │
└────────────┴────────────────────────────────────────────┘
```

### 4. Product Form (`/products/create`)
**Product creation/edit form**
```
┌─────────────────────────────────────────────────────────┐
│ [Navbar + Sidebar]                                      │
├────────────┬────────────────────────────────────────────┤
│ [Sidebar]  │  Novo Produto               [← Voltar]     │
│            │                                            │
│            │  ┌────────────────────────────────────────┐│
│            │  │ SKU *          │ Código Barras        ││
│            │  │ [input]        │ [input]              ││
│            │  │                                        ││
│            │  │ Nome *                                 ││
│            │  │ [input - full width]                   ││
│            │  │                                        ││
│            │  │ Descrição                              ││
│            │  │ [textarea]                             ││
│            │  │                                        ││
│            │  │ Categoria *    │ Fornecedor *         ││
│            │  │ [select]       │ [select]             ││
│            │  │                                        ││
│            │  │ Qtd Inicial *  │ Qtd Mínima * │ Preço *││
│            │  │ [number]       │ [number]     │[number]││
│            │  │                                        ││
│            │  │ Status: [select: Ativo/Inativo]        ││
│            │  │                                        ││
│            │  │ [Cancelar]              [✓ Salvar]     ││
│            │  └────────────────────────────────────────┘│
└────────────┴────────────────────────────────────────────┘
```

### 5. Product Details (`/products/{id}`)
**Detailed product view**
```
┌─────────────────────────────────────────────────────────┐
│ [Navbar + Sidebar]                                      │
├────────────┬────────────────────────────────────────────┤
│ [Sidebar]  │  Detalhes do Produto  [✏️ Editar][← Voltar]│
│            │                                            │
│            │  ┌──────────────────┐ ┌──────────────┐   │
│            │  │ Informações      │ │ Ações Rápidas│   │
│            │  │                  │ │              │   │
│            │  │ SKU: PRD-001     │ │ [+ Entrada]  │   │
│            │  │ Barcode: 123456  │ │ [- Saída]    │   │
│            │  │ Nome: Product A  │ │ [📊 Histórico]│  │
│            │  │ Desc: Lorem...   │ │              │   │
│            │  │                  │ │──────────────│   │
│            │  │ Categoria: Food  │ │ Resumo       │   │
│            │  │ Fornec.: Sup A   │ │              │   │
│            │  │                  │ │ Valor Total: │   │
│            │  │ Quantidade: 50   │ │ R$ 1,250.00  │   │
│            │  │ Mín: 10          │ │              │   │
│            │  │ Preço: R$ 25.00  │ │ [✓ OK]       │   │
│            │  │ Status: [✓Ativo] │ │              │   │
│            │  └──────────────────┘ └──────────────┘   │
└────────────┴────────────────────────────────────────────┘
```

### 6. Stock Movement (`/stock/movement`)
**Stock movement registration**
```
┌─────────────────────────────────────────────────────────┐
│ [Navbar + Sidebar]                                      │
├────────────┬────────────────────────────────────────────┤
│ [Sidebar]  │  Nova Movimentação           [← Voltar]    │
│            │                                            │
│            │  ┌────────────────────────────────────────┐│
│            │  │ Produto *                              ││
│            │  │ [select: Nome (SKU) - Estoque: X]      ││
│            │  │                                        ││
│            │  │ Tipo de Movimentação * │ Quantidade *  ││
│            │  │ [select:              │ [number]      ││
│            │  │  - Entrada            │               ││
│            │  │  - Saída              │               ││
│            │  │  - Ajuste]            │               ││
│            │  │                                        ││
│            │  │ Motivo                                 ││
│            │  │ [input: Ex: Compra do fornecedor X]    ││
│            │  │                                        ││
│            │  │ Observações                            ││
│            │  │ [textarea]                             ││
│            │  │                                        ││
│            │  │ ℹ️ Esta ação irá alterar o estoque    ││
│            │  │                                        ││
│            │  │ [Cancelar]  [✓ Registrar Movimentação] ││
│            │  └────────────────────────────────────────┘│
└────────────┴────────────────────────────────────────────┘
```

### 7. Reports (`/reports`)
**Reporting interface**
```
┌─────────────────────────────────────────────────────────┐
│ [Navbar + Sidebar]                                      │
├────────────┬────────────────────────────────────────────┤
│ [Sidebar]  │  Relatórios                                │
│            │                                            │
│            │  ┌────────────────────────────────────────┐│
│            │  │ Tipo │ Data Inicial │ Data Final │[⚙️]││
│            │  │[sel] │   [date]     │   [date]   │[Fil]││
│            │  └────────────────────────────────────────┘│
│            │                                            │
│            │  [📄 Exportar PDF]                         │
│            │                                            │
│            │  ┌────────────────────────────────────────┐│
│            │  │ 📊 Estoque Atual - Todos os Produtos   ││
│            │  ├────────────────────────────────────────┤│
│            │  │ SKU │ Produto │ Qtd │ Preço │ Total   ││
│            │  ├─────┼─────────┼─────┼───────┼─────────┤│
│            │  │PRD1 │ Prod A  │ 50  │ 25.00 │ 1250.00││
│            │  │PRD2 │ Prod B  │ 30  │ 15.00 │  450.00││
│            │  │PRD3 │ Prod C  │ 20  │ 10.00 │  200.00││
│            │  ├─────┴─────────┴─────┴───────┼─────────┤│
│            │  │        VALOR TOTAL:         │ R$1900  ││
│            │  └────────────────────────────────────────┘│
└────────────┴────────────────────────────────────────────┘
```

### 8. Sidebar Navigation (Responsive)
**Left sidebar with collapsible menu**
```
Desktop View:            Mobile View (Collapsed):
┌────────────┐          ┌┐
│[☰] Sidebar│          ││  [Tap to expand]
├────────────┤          │├─────────────────┐
│ Dashboard  │          ││  Dashboard      │
│ Produtos   │          ││  Produtos       │
│ Categorias │          ││  Categorias     │
│ Fornec.    │          ││  Fornecedores   │
│ Estoque    │          ││  Estoque        │
│ Relatórios │          ││  Relatórios     │
│ Usuários   │          ││  Usuários       │
└────────────┘          │└─────────────────┘
```

## 🎨 UI Components

### Badges (Status Indicators)
```
[✓ Ativo]     - Green badge (success)
[● Inativo]   - Gray badge (secondary)
[! Baixo]     - Red badge (danger - low stock)
[⚠️ Alerta]   - Yellow badge (warning)
[50]          - Blue badge (info - quantity)
```

### Buttons
```
[+ Novo]           - Primary blue button
[✏️ Editar]        - Warning yellow button
[🗑️ Excluir]       - Danger red button
[👁️ Ver]           - Info light blue button
[← Voltar]         - Secondary gray button
[✓ Salvar]         - Success green button
```

### Cards with Gradients
```
┌────────────────┐
│ [Gradient BG]  │  Purple gradient
│                │
│     150        │  Large number
│ Total Produtos │  Description
└────────────────┘
```

### Tables
```
┌─────────────────────────────────────────┐
│ [Table Header - Gray Background]        │
├─────┬────────┬────────┬────────┬────────┤
│ ID  │ Name   │ Status │ Date   │ Actions│
├─────┼────────┼────────┼────────┼────────┤
│ 1   │ Item A │ [✓]    │ 12/13  │ [Icons]│
│ 2   │ Item B │ [!]    │ 12/12  │ [Icons]│
└─────┴────────┴────────┴────────┴────────┘
```

### Forms
```
┌──────────────────────────────┐
│ Field Label *                │
│ [input field with border]    │
│                              │
│ Textarea Label               │
│ ┌──────────────────────────┐│
│ │                          ││
│ └──────────────────────────┘│
│                              │
│ Select Label *               │
│ [▼ Dropdown]                 │
└──────────────────────────────┘
```

### Notifications (Toasts)
```
┌────────────────────────────────┐
│ ✓ Success!                     │
│ Operation completed successfully│
│                          [Dismiss]
└────────────────────────────────┘

┌────────────────────────────────┐
│ ⚠️ Warning!                     │
│ Stock is below minimum         │
│                          [Dismiss]
└────────────────────────────────┘
```

## 📱 Responsive Behavior

### Desktop (> 992px)
- Sidebar always visible (250px width)
- Full navbar with all elements
- Multi-column layouts
- Larger cards and spacing

### Tablet (768px - 992px)
- Sidebar collapsible
- Navbar condensed
- 2-column layouts
- Medium cards

### Mobile (< 768px)
- Sidebar hidden by default (toggle button)
- Hamburger menu
- Single column layouts
- Stacked cards
- Touch-friendly buttons

## 🎯 User Experience Features

### Visual Feedback
- ✅ Hover effects on buttons and links
- ✅ Loading indicators (where needed)
- ✅ Color-coded status badges
- ✅ Smooth transitions and animations
- ✅ Toast notifications (auto-hide after 5s)

### Form Validation
- ✅ Required field indicators (*)
- ✅ Real-time validation
- ✅ Error messages in red
- ✅ Success confirmations in green

### Data Display
- ✅ Pagination for large datasets
- ✅ Search with debounce
- ✅ Sortable tables
- ✅ Color-coded quantities
- ✅ Formatted numbers (currency, dates)

### Accessibility
- ✅ Semantic HTML
- ✅ ARIA labels (where needed)
- ✅ Keyboard navigation
- ✅ Clear focus indicators
- ✅ High contrast text

## 🌈 Theme Consistency

All screens follow a consistent design language:
- **Header**: Fixed dark navbar with brand and user menu
- **Sidebar**: Collapsible navigation with icons
- **Content Area**: White cards on light gray background
- **Actions**: Color-coded buttons (blue/green/yellow/red)
- **Status**: Badge system with semantic colors
- **Typography**: Clear hierarchy with proper spacing

---

**Note**: This is a textual representation. The actual system uses modern CSS with gradients, shadows, and smooth animations for a polished professional look.

**Desenvolvido por BKB06** | Sistema Empório v1.0
