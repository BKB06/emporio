# 🏪 Sistema Empório

Sistema moderno de gestão de armazém/estoque desenvolvido com PHP 8.2+, Bootstrap 5 e arquitetura MVC.

## 🚀 Funcionalidades

- 📊 **Dashboard** - Estatísticas em tempo real, alertas de estoque baixo
- 📦 **Gestão de Produtos** - CRUD completo com SKU, código de barras, categorias
- 📋 **Categorias** - Organização hierárquica de produtos
- 🏭 **Fornecedores** - Cadastro completo com CNPJ, contatos
- 📈 **Controle de Estoque** - Entrada/Saída com histórico completo
- 📄 **Relatórios** - Exportação em PDF, filtros por período
- 👥 **Usuários** - Sistema com 3 níveis (Admin/Gerente/Operador)
- 🔐 **Segurança** - Autenticação bcrypt, proteção XSS/SQL Injection

## 💻 Tecnologias

- PHP 8.2+ com arquitetura MVC
- MySQL 8.0+
- Bootstrap 5
- DomPDF para relatórios
- PSR-4 Autoloading

## 📋 Requisitos

- PHP >= 8.2
- MySQL >= 8.0
- Composer
- Servidor Apache/Nginx (ou PHP built-in server)

## 🔧 Instalação

```bash
# 1. Clone o repositório
git clone https://github.com/BKB06/emporio.git
cd emporio

# 2. Instale dependências
composer install

# 3. Configure ambiente
cp .env.example .env
# Edite o .env com suas credenciais MySQL

# 4. Crie o banco de dados
mysql -u root -p -e "CREATE DATABASE emporio"
mysql -u root -p emporio < database/schema.sql

# 5. Inicie o servidor
php -S localhost:8000 -t public

# 6. Acesse o sistema
# URL: http://localhost:8000
# Login: admin@emporio.com
# Senha: admin123
```

## 📁 Estrutura do Projeto

```
/
├── config/           # Configurações do sistema
│   ├── config.php
│   └── database.php
├── database/         # Schema SQL
│   └── schema.sql
├── public/           # Entrada pública
│   ├── css/
│   ├── js/
│   └── index.php
├── src/
│   ├── Core/         # Classes framework
│   ├── Controllers/  # Lógica de negócio
│   ├── Models/       # Acesso a dados
│   └── Views/        # Templates
├── vendor/           # Dependências Composer
├── .env.example      # Exemplo de configuração
├── .htaccess
└── composer.json
```

## 🎯 Credenciais Padrão

**Usuário Admin:**
- Email: `admin@emporio.com`
- Senha: `admin123`

⚠️ **Importante:** Altere essas credenciais após o primeiro login!

## 🔒 Segurança

- ✅ PDO Prepared Statements
- ✅ Senhas com Bcrypt
- ✅ Proteção contra XSS
- ✅ Proteção contra SQL Injection
- ✅ Validação de inputs
- ✅ Controle de acesso por roles

## 📦 Funcionalidades Detalhadas

### Dashboard
- Total de produtos em estoque
- Valor total do inventário
- Produtos com estoque baixo
- Últimas movimentações

### Produtos
- Cadastro com SKU único
- Código de barras
- Categoria e fornecedor
- Controle de quantidade mínima
- Status ativo/inativo
- Busca e filtros avançados

### Estoque
- Registro de entradas (compras, devoluções)
- Registro de saídas (vendas, perdas)
- Histórico completo
- Auditoria por usuário

### Relatórios
- Estoque atual
- Produtos com estoque baixo
- Movimentações por período
- Exportação em PDF

## 🤝 Contribuindo

Contribuições são bem-vindas! Sinta-se à vontade para abrir issues e pull requests.

## 📄 Licença

MIT License - sinta-se livre para usar este projeto.

## 👨‍💻 Autor

Desenvolvido por BKB06

---

⭐ Se este projeto foi útil, considere dar uma estrela!