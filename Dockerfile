# Use official PHP image with Apache
FROM php:8.2-apache

# Install any necessary extensions if needed (mbstring, etc.)
# For this project, standard PHP is enough

# Set the working directory to the Apache document root
WORKDIR /var/www/html

# Copy all the project files into the container
COPY . .

# Set permissions for the leads.txt file so PHP can write to it
RUN touch leads.txt && chmod 666 leads.txt

# Enable Apache mod_rewrite (common for PHP apps)
RUN a2enmod rewrite

# Update Apache configuration to allow .htaccess overrides
RUN sed -i 's/AllowOverride None/AllowOverride All/' /etc/apache2/apache2.conf

# Render uses the PORT environment variable
ENV PORT 80
EXPOSE 80

# Start Apache
CMD ["apache2-foreground"]
