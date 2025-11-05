# Official PHP + Apache image
FROM php:8.3-apache

# Copy your code into the web root
COPY . /var/www/html/

# Enable mod_rewrite (optional)
RUN a2enmod rewrite

# Expose the port Render expects
EXPOSE 10000

# Apache will run automatically
CMD ["apache2-foreground"]
