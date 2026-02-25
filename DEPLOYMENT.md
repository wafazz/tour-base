# Tour Base — VPS Deployment Guide

**Domain**: `tour-base.codexlure.tech`
**Stack**: Nginx + PHP-FPM + MySQL

---

## 1. Server Requirements

```bash
sudo apt update && sudo apt upgrade -y

# PHP 8.3 + extensions
sudo apt install -y php8.3-fpm php8.3-mysql php8.3-mbstring php8.3-xml \
    php8.3-curl php8.3-zip php8.3-gd php8.3-bcmath php8.3-intl php8.3-dom \
    unzip git nginx mysql-server

# Composer
curl -sS https://getcomposer.org/installer | php
sudo mv composer.phar /usr/local/bin/composer

# Node.js 20 (for Vite build)
curl -fsSL https://deb.nodesource.com/setup_20.x | sudo -E bash -
sudo apt install -y nodejs
```

## 2. Clone & Install

```bash
cd /var/www
sudo git clone https://github.com/wafazz/tour-base.git
sudo chown -R www-data:www-data tour-base
cd tour-base

composer install --no-dev --optimize-autoloader
npm install && npm run build

cp .env.example .env
php artisan key:generate
```

## 3. Environment (.env)

```env
APP_NAME="Tour Base"
APP_ENV=production
APP_DEBUG=false
APP_URL=https://tour-base.codexlure.tech

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=tour_base
DB_USERNAME=tourbase_user
DB_PASSWORD=YOUR_STRONG_PASSWORD

SESSION_DRIVER=database
QUEUE_CONNECTION=database
CACHE_STORE=database

MAIL_MAILER=smtp
MAIL_HOST=smtp.your-provider.com
MAIL_PORT=587
MAIL_USERNAME=your@email.com
MAIL_PASSWORD=your_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="noreply@codexlure.tech"
MAIL_FROM_NAME="Tour Base"
```

## 4. Database

```bash
sudo mysql -u root
```

```sql
CREATE DATABASE tour_base;
CREATE USER 'tourbase_user'@'localhost' IDENTIFIED BY 'YOUR_STRONG_PASSWORD';
GRANT ALL PRIVILEGES ON tour_base.* TO 'tourbase_user'@'localhost';
FLUSH PRIVILEGES;
EXIT;
```

```bash
php artisan migrate --seed
php artisan storage:link
```

## 5. Permissions

```bash
sudo chown -R www-data:www-data /var/www/tour-base
sudo chmod -R 775 storage bootstrap/cache
```

## 6. Nginx Config

```bash
sudo nano /etc/nginx/sites-available/tour-base
```

```nginx
server {
    listen 80;
    server_name tour-base.codexlure.tech;
    root /var/www/tour-base/public;

    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-Content-Type-Options "nosniff";

    index index.php;
    charset utf-8;

    client_max_body_size 20M;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location = /favicon.ico { access_log off; log_not_found off; }
    location = /robots.txt  { access_log off; log_not_found off; }

    error_page 404 /index.php;

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.3-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }
}
```

```bash
sudo ln -s /etc/nginx/sites-available/tour-base /etc/nginx/sites-enabled/
sudo nginx -t && sudo systemctl reload nginx
```

## 7. SSL (Let's Encrypt)

```bash
sudo apt install certbot python3-certbot-nginx -y
sudo certbot --nginx -d tour-base.codexlure.tech
```

## 8. Queue Worker (for notifications)

```bash
sudo nano /etc/systemd/system/tourbase-queue.service
```

```ini
[Unit]
Description=Tour Base Queue Worker
After=network.target

[Service]
User=www-data
Group=www-data
Restart=always
RestartSec=5
WorkingDirectory=/var/www/tour-base
ExecStart=/usr/bin/php artisan queue:work --sleep=3 --tries=3 --max-time=3600

[Install]
WantedBy=multi-user.target
```

```bash
sudo systemctl enable tourbase-queue
sudo systemctl start tourbase-queue
```

## 9. Cron (Scheduler)

```bash
sudo crontab -u www-data -e
```

Add this line:

```
* * * * * cd /var/www/tour-base && php artisan schedule:run >> /dev/null 2>&1
```

## 10. Optimize for Production

```bash
cd /var/www/tour-base
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan icons:cache
php artisan filament:cache-components
```

## DNS Setup

Add an **A record** in your DNS provider:

| Type | Name | Value |
|------|------|-------|
| A | tour-base | YOUR_VPS_IP |

## Quick Deploy Script (future updates)

```bash
cd /var/www/tour-base
git pull origin main
composer install --no-dev --optimize-autoloader
npm install && npm run build
php artisan migrate --force
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan filament:cache-components
sudo systemctl restart tourbase-queue
```

## Login Credentials (seeded)

| Role | Email | Password | Panel |
|------|-------|----------|-------|
| Admin | admin@tourbase.com | password | /admin |
| Agency | agency@tourbase.com | password | /agency |
| Guide | guide@tourbase.com | password | /guide |

> **Important**: Change these passwords immediately after first login in production!
