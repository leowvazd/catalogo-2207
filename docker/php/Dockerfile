FROM php:8.2-fpm


# Instala dependências do sistema
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip

# Instala o Node.js 20.x (exigido pelas versões recentes do Vite e Laravel)
RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs

# Limpa o cache para otimizar a imagem
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Instala extensões PHP essenciais
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Copia o Composer oficial
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www