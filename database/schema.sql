-- Criar banco de dados
CREATE DATABASE IF NOT EXISTS emporio CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE emporio;

-- Tabela de usuários
CREATE TABLE users (
    id INT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(50) UNIQUE NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    role ENUM('Admin', 'Gerente', 'Operador') DEFAULT 'Operador',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_email (email)
) ENGINE=InnoDB;

-- Tabela de categorias
CREATE TABLE categories (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    description TEXT,
    parent_id INT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (parent_id) REFERENCES categories(id) ON DELETE SET NULL,
    INDEX idx_parent (parent_id)
) ENGINE=InnoDB;

-- Tabela de fornecedores
CREATE TABLE suppliers (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(200) NOT NULL,
    cnpj VARCHAR(18) UNIQUE,
    email VARCHAR(100),
    phone VARCHAR(20),
    address TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_cnpj (cnpj)
) ENGINE=InnoDB;

-- Tabela de produtos
CREATE TABLE products (
    id INT PRIMARY KEY AUTO_INCREMENT,
    sku VARCHAR(50) UNIQUE NOT NULL,
    barcode VARCHAR(50),
    name VARCHAR(200) NOT NULL,
    description TEXT,
    category_id INT,
    supplier_id INT,
    quantity INT DEFAULT 0,
    min_quantity INT DEFAULT 10,
    unit_price DECIMAL(10,2),
    status ENUM('ativo', 'inativo') DEFAULT 'ativo',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE SET NULL,
    FOREIGN KEY (supplier_id) REFERENCES suppliers(id) ON DELETE SET NULL,
    INDEX idx_sku (sku),
    INDEX idx_status (status),
    INDEX idx_category (category_id),
    INDEX idx_supplier (supplier_id)
) ENGINE=InnoDB;

-- Tabela de movimentações de estoque
CREATE TABLE stock_movements (
    id INT PRIMARY KEY AUTO_INCREMENT,
    product_id INT NOT NULL,
    user_id INT NOT NULL,
    type ENUM('entrada', 'saida', 'ajuste') NOT NULL,
    quantity INT NOT NULL,
    reason VARCHAR(200),
    notes TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(id),
    INDEX idx_product (product_id),
    INDEX idx_user (user_id),
    INDEX idx_date (created_at),
    INDEX idx_type (type)
) ENGINE=InnoDB;

-- Inserir usuários padrão (senha: admin123)
INSERT INTO users (username, email, password, role) VALUES
('admin', 'admin@emporio.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Admin'),
('gerente', 'gerente@emporio.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Gerente'),
('operador', 'operador@emporio.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Operador');

-- Inserir categorias padrão
INSERT INTO categories (name, description) VALUES
('Alimentos', 'Produtos alimentícios diversos'),
('Bebidas', 'Bebidas alcoólicas e não alcoólicas'),
('Limpeza', 'Produtos de limpeza e higiene'),
('Mercearia', 'Produtos de mercearia em geral');

-- Inserir fornecedores padrão
INSERT INTO suppliers (name, cnpj, email, phone) VALUES
('Distribuidora Alpha', '12.345.678/0001-99', 'contato@alpha.com', '(51) 3333-4444'),
('Fornecedor Beta', '98.765.432/0001-11', 'vendas@beta.com', '(51) 5555-6666');
