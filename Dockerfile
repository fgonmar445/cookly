FROM richarvey/nginx-php-fpm:latest

# Copiar proyecto
COPY . /var/www/html

# Configurar webroot
ENV WEBROOT=/var/www/html/public
ENV RUN_SCRIPTS=1
ENV PHP_ERRORS_STDERR=1

# Copiar script de despliegue
COPY deploy.sh /usr/local/bin/deploy.sh
RUN chmod +x /usr/local/bin/deploy.sh

CMD ["/start.sh"]
