# Laravel 5.4 + Materialize CSS + OAuth GitHub (Тестовое задание)

Что необходимо для работы:
* PHP 5.6.4 или выше
* База данных, на Ваш выбор
* nginx
* Зарегистрированное OAuth приложение на GitHub

## Как использовать

Откройте консоль и выполните следующие команды.

```
$ git clone https://github.com/ThinkerSoft/gitsearch1.git
$ cd gitsearch1 
$ composer install
```

Откройте на редактирование файл '.env' и укажите необходимые параметры приложения, подключения к БД и приложения, созданного на GitGub:
```
...
APP_URL=http://localhost:8085
...
DB_CONNECTION=pgsql
DB_HOST=localhost
DB_PORT=5432
DB_DATABASE=gitsearch1
DB_USERNAME=postgres
DB_PASSWORD=1
...
GITHUB_CLIENT_ID=sdfkds8f9sdhfisdf8s
GITHUB_CLIENT_SECRET=dsfjsdh87fysd87fysdjfas87dft8a7s89dhsf
GITHUB_URL=http://localhost:8085/login/github/callback
```

Запустите миграции, выполнив в консоли:
```
$ php artisan migrate
``` 

Настройте сервер nginx. Создайте конфигурацию следующего содержания (отредактируйте такие параметры конфигурации, как listen, server_name, root, access_log, error_log и fastcgi_pass, так как необходимо вам):

```
server {
    listen 8085; ## здесь укажите порт, на который nginx будет принимать запросы
    
    server_name gitsearch1.local; ## укажите имя сервера
    
    root /path/to/gitsearch1/public; ## здесь укажите путь до директории public проекта
    
    index index.html index.htm index.php;
    
    charset utf-8;

    location / {
        try_files $uri $uri/ /index.php$is_args$args;
    }
    
    location = /favicon.ico { access_log off; log_not_found off; }
    location = /robots.txt  { access_log off; log_not_found off; }
    
    access_log off;
    error_log  /var/log/nginx/gitsearch1-error.log error;

    sendfile off;

    client_max_body_size 100m;

    location ~ \.php$ {
        fastcgi_split_path_info ^(.+\.php)(/.+)$;
        fastcgi_pass unix:/var/run/php7.0-fpm.sock;
        fastcgi_index index.php;
        include fastcgi_params;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
        fastcgi_intercept_errors off;
        fastcgi_buffer_size 16k;
        fastcgi_buffers 4 16k;
    }

    location ~ /\.ht {
        deny all;
    }
}
```

Не забудьте сделать симлинк на вашу конфигурацию и перезапутите nginx:
```
$ ln -s /etc/nginx/sites-available/gitsearch1 /etc/nginx/sites-enabled/
$ /etc/init.d/nginx restart
```

Для доступа к приложению по имени сервера необходимо изменить файл `/etc/hosts`, добавив:
```
127.0.0.1       gitsearch1.local
```

Откройте браузер и запустите приложение (при необходимости укажите свой порт):
[http://localhost:8085](http://localhost:8085) или [http://gitsearch1.local:8085](http://yii2test1.local:8393)
