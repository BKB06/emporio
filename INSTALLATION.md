# 📦 Guia de Instalação - Sistema Empório

## Requisitos do Sistema

### Software Necessário
- **PHP**: >= 8.2
- **MySQL**: >= 8.0
- **Composer**: Última versão estável
- **Servidor Web**: Apache, Nginx ou PHP Built-in Server

### Extensões PHP Necessárias
- pdo_mysql
- mbstring
- json
- session

## Instalação Passo a Passo

### 1. Clone o Repositório

```bash
git clone https://github.com/BKB06/emporio.git
cd emporio
```

### 2. Instale as Dependências

```bash
composer install --no-dev --optimize-autoloader
```

### 3. Configure o Ambiente

```bash
# Copie o arquivo de exemplo
cp .env.example .env

# Edite o arquivo .env com suas configurações
nano .env  # ou use seu editor preferido
```

Exemplo de configuração `.env`:

```env
# Database
DB_HOST=localhost
DB_PORT=3306
DB_NAME=emporio
DB_USER=root
DB_PASS=sua_senha_aqui

# Application
APP_NAME="Sistema Empório"
APP_URL=http://localhost:8000
APP_ENV=production

# Session
SESSION_LIFETIME=7200
```

### 4. Configure o Banco de Dados

#### Opção A: Via MySQL CLI

```bash
# Criar o banco de dados
mysql -u root -p -e "CREATE DATABASE emporio CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"

# Importar o schema
mysql -u root -p emporio < database/schema.sql
```

#### Opção B: Via phpMyAdmin

1. Acesse o phpMyAdmin
2. Crie um novo banco de dados chamado `emporio`
3. Selecione o banco de dados
4. Vá em "Importar"
5. Selecione o arquivo `database/schema.sql`
6. Clique em "Executar"

### 5. Configure Permissões (Linux/Mac)

```bash
# Dar permissão de escrita para logs (se necessário)
chmod -R 775 storage/
chown -R www-data:www-data storage/
```

### 6. Inicie o Servidor

#### Opção A: PHP Built-in Server (Desenvolvimento)

```bash
php -S localhost:8000 -t public
```

#### Opção B: Apache

1. Configure um VirtualHost apontando para a pasta `public/`
2. Certifique-se de que mod_rewrite está ativado
3. Reinicie o Apache

Exemplo de VirtualHost:

```apache
<VirtualHost *:80>
    ServerName emporio.local
    DocumentRoot /caminho/para/emporio/public
    
    <Directory /caminho/para/emporio/public>
        AllowOverride All
        Require all granted
    </Directory>
</VirtualHost>
```

#### Opção C: Nginx

```nginx
server {
    listen 80;
    server_name emporio.local;
    root /caminho/para/emporio/public;
    index index.php;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.2-fpm.sock;
        fastcgi_index index.php;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }
}
```

### 7. Acesse o Sistema

Abra seu navegador e acesse:

- **URL**: http://localhost:8000
- **Email**: admin@emporio.com
- **Senha**: admin123

## Credenciais Padrão

O sistema vem com 3 usuários pré-cadastrados:

| Perfil | Email | Senha | Permissões |
|--------|-------|-------|------------|
| Admin | admin@emporio.com | admin123 | Acesso total |
| Gerente | gerente@emporio.com | admin123 | Gerenciamento |
| Operador | operador@emporio.com | admin123 | Operações básicas |

⚠️ **IMPORTANTE**: Altere todas as senhas após o primeiro acesso!

## Solução de Problemas

### Erro de Conexão com o Banco de Dados

1. Verifique as credenciais no arquivo `.env`
2. Certifique-se de que o MySQL está rodando
3. Verifique se o banco de dados foi criado

```bash
mysql -u root -p -e "SHOW DATABASES;"
```

### Erro 500 - Internal Server Error

1. Verifique os logs do PHP
2. Certifique-se de que todas as extensões PHP estão instaladas
3. Verifique as permissões dos arquivos

### Erro 404 em Rotas

1. Certifique-se de que o mod_rewrite está ativado (Apache)
2. Verifique se o arquivo `.htaccess` existe na pasta `public/`
3. Verifique a configuração do servidor web

## Testes de Validação

Após a instalação, teste as seguintes funcionalidades:

1. ✅ Login com usuário admin
2. ✅ Criar uma categoria
3. ✅ Criar um fornecedor
4. ✅ Criar um produto
5. ✅ Fazer uma movimentação de estoque
6. ✅ Visualizar o dashboard
7. ✅ Gerar um relatório

## Atualização

Para atualizar o sistema:

```bash
# Fazer backup do banco de dados
mysqldump -u root -p emporio > backup_emporio_$(date +%Y%m%d).sql

# Atualizar código
git pull origin main

# Atualizar dependências
composer install --no-dev --optimize-autoloader

# Aplicar migrações (se houver)
# mysql -u root -p emporio < database/migrations/nova_migracao.sql
```

## Suporte

Para suporte ou dúvidas:
- Abra uma issue no GitHub
- Consulte a documentação no README.md

---

**Desenvolvido por BKB06** | [GitHub](https://github.com/BKB06)
