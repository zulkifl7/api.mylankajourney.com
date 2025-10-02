# My Lanka Journey - Deployment Guide

This guide outlines the steps to deploy the My Lanka Journey backend API to production.

## Domain Structure

- **Frontend**: mylankajourney.com and www.mylankajourney.com
- **Admin Panel**: admin.mylankajourney.com
- **API Backend**: api.mylankajourney.com

## Deployment Steps

### 1. Server Requirements

- PHP 8.1 or higher
- Composer
- MySQL 8.0 or higher
- Web server (Apache/Nginx)
- SSL certificate for all domains

### 2. Server Setup

1. Set up a web server with the required domains pointing to the correct directories
2. Configure SSL certificates for all domains
3. Create a MySQL database for the application

### 3. Application Deployment

1. Clone the repository to your server
2. Copy the `.env.production` file to `.env`:
   ```
   cp .env.production .env
   ```
3. Update the `.env` file with your database credentials and other settings
4. Install dependencies (this must be done before any artisan commands):
   ```
   composer install --optimize-autoloader --no-dev
   ```
5. Generate an application key:
   ```
   php artisan key:generate
   ```
6. Run database migrations:
   ```
   php artisan migrate
   ```
7. Seed the database (if needed):
   ```
   php artisan db:seed
   ```
8. Optimize the application:
   ```
   php artisan optimize
   php artisan route:cache
   php artisan config:cache
   php artisan view:cache
   ```
9. Set proper permissions:
   ```
   chmod -R 755 storage bootstrap/cache
   ```

### 4. Web Server Configuration

#### Apache Configuration

The `.htaccess` file in the public directory has been updated with the necessary configurations for production, including:

- HTTPS redirection
- Security headers
- CORS configuration for the frontend domains
- PHP settings optimization

#### Nginx Configuration (Alternative)

If using Nginx, use this configuration:

```nginx
server {
    listen 80;
    server_name api.mylankajourney.com;
    return 301 https://$host$request_uri;
}

server {
    listen 443 ssl;
    server_name api.mylankajourney.com;
    
    ssl_certificate /path/to/certificate.crt;
    ssl_certificate_key /path/to/private.key;
    
    root /path/to/my-lanka-journey-backend/public;
    index index.php;
    
    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }
    
    location ~ \.php$ {
        include fastcgi_params;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
        fastcgi_pass unix:/var/run/php/php8.1-fpm.sock;
        fastcgi_read_timeout 300;
    }
    
    # CORS headers
    add_header 'Access-Control-Allow-Origin' 'https://mylankajourney.com, https://admin.mylankajourney.com' always;
    add_header 'Access-Control-Allow-Methods' 'GET, POST, PUT, DELETE, OPTIONS' always;
    add_header 'Access-Control-Allow-Headers' 'Authorization, Content-Type, X-Requested-With, X-XSRF-TOKEN' always;
    add_header 'Access-Control-Allow-Credentials' 'true' always;
    
    # Security headers
    add_header X-Content-Type-Options "nosniff" always;
    add_header X-XSS-Protection "1; mode=block" always;
    add_header X-Frame-Options "SAMEORIGIN" always;
    add_header Referrer-Policy "strict-origin-when-cross-origin" always;
    
    client_max_body_size 64M;
}
```

### 5. Maintenance and Updates

To update the application in the future:

1. Pull the latest changes:
   ```
   git pull origin main
   ```
2. Install dependencies:
   ```
   composer install --optimize-autoloader --no-dev
   ```
3. Run migrations:
   ```
   php artisan migrate
   ```
4. Clear and rebuild caches:
   ```
   php artisan optimize:clear
   php artisan optimize
   ```

## Troubleshooting

- **Missing Vendor Directory**: If you see errors like `Failed to open stream: No such file or directory in /path/to/artisan` or `Failed opening required '/path/to/vendor/autoload.php'`, it means you need to run `composer install` before any artisan commands.

- **CORS Issues**: Verify that the CORS configuration in `config/cors.php` includes all necessary frontend domains.

- **Authentication Problems**: Check that the `SANCTUM_STATEFUL_DOMAINS` in the `.env` file includes all frontend domains.

- **Database Connection Issues**: Verify database credentials and connection settings in the `.env` file.

- **Permission Issues**: Ensure proper permissions on storage and cache directories:
  ```
  chmod -R 755 storage bootstrap/cache
  chown -R www-data:www-data storage bootstrap/cache
  ```

- **Artisan Command Errors**: If artisan commands fail, try clearing the configuration cache:
  ```
  php artisan config:clear
  php artisan cache:clear
  ```

## Security Considerations

- Keep the `.env` file secure and never commit it to version control
- Regularly update dependencies with `composer update`
- Set up a firewall to restrict access to the server
- Configure regular backups of the database and application files