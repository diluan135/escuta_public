#!/bin/bash

# Caminho para a pasta do projeto no servidor
PROJECT_PATH=/caminho/para/o/projeto/no/servidor/escuta

# Navegar para o diretório do projeto
cd $PROJECT_PATH

# Puxar as últimas mudanças do repositório
git pull origin main

# Instalar dependências PHP
composer install --no-dev --optimize-autoloader

# Instalar dependências NPM e rodar o build
npm install
npm run build

# Limpar caches
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Ajustar permissões
chown -R www-data:www-data $PROJECT_PATH
chmod -R 775 $PROJECT_PATH/storage
chmod -R 775 $PROJECT_PATH/bootstrap/cache

echo "Deploy realizado com sucesso!"
