# Symfony shopping cart

## Live Demo

http://symfony-shopping-cart.efiton.com/

## Build/Run

#### Requirements

- Php 7.2+
- composer

```javascript

/* First, Install project into /var/www */
cd /var/www/
git clone https://github.com/harshan89/symfony-shopping-cart.git

/* Setup the database */
Create mysql database and import book_store.sql file.
Change the DATABASE_URL of the .env file
DATABASE_URL=mysql://username:password@127.0.0.1:3306/book_store?serverVersion=5.7

/* Install composer packages */
cd symfony-shopping-cart
composer install

```

## Server setup (Nginx)

```js
server 
{
    listen 80;
    root /var/www/symfony-shopping-cart/public;
    index index.php index.html index.htm index.nginx-debian.html;
    server_name symfony-shopping-cart.efiton.com;
    try_files $uri $uri/ /index.php?q=$uri&$args;

    location ~ \.php$ {
        proxy_buffer_size 128k;
        proxy_buffers 4 256k;
        proxy_busy_buffers_size 256k;
        fastcgi_buffer_size 128k;
        fastcgi_buffers 4 256k;
        fastcgi_busy_buffers_size 256k;
        include snippets/fastcgi-php.conf;
        fastcgi_pass unix:/var/run/php/php7.3-fpm.sock;
    }
}
```
