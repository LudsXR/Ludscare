# ====== Front Build ======
FROM node:lts-alpine as front-build

WORKDIR /app

COPY . /app

RUN npm install

RUN npm run production


# ====== Backend ======
FROM webdevops/php-nginx:8.1
ENV WEB_DOCUMENT_ROOT=/app/public
WORKDIR /app

# Copiando o projeto com o usuário e grupo
# usados para a execução da aplicação
COPY --chown=application:application --from=front-build /app /app

# Instalando as dependências do laravel
RUN composer install --ignore-platform-reqs

EXPOSE 80
