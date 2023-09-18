## 环境要求

建议服务器选用 Linux 操作系统。需要按装的软件有 php, nginx, mysql, redis, memcached, supervisor, git, composer。

::: tip Tips
php 版本需要 8.1 及以上，需要的 php 扩展：bcmath,ctype,dom,fileinfo,json,mbstring,openssl,pcre,pdo,tokenizer,xml。

nginx 可替换为 apache

mysql 可替换 MariaDB 等 MySQL 衍生数据库，以及 Laravel 支持的 Sqlite,PostgreSQL。
:::

创建新的系统用户
:::warning 注意
我们不推荐直接使用系统 root 用户来运行 One。如果您需要直接使用 root 用户，请跳过这一步。
:::

创建一个名为 one 的用户（名字可以随意）

```shell
sudo useradd -d /home/one -s /bin/bash -m one
```

加入 `www-data` 用户组

```shell
sudo usermod -aG www-data web
```

为 one 用户创建密码

```shell
sudo passwd one
```

登录到 one 账户

```shell
su - one
```

## 安装部署

### 创建数据库

```bash
mysql -u root -p

create database if not exists one default character set utf8mb4 default collate utf8mb4_general_ci;

create user 'one'@'localhost' identified with caching_sha2_password by '密码';  # 密码自行定义

grant all privileges on one.* to 'one'@'localhost';

flush privileges;

exit;
```

### 克隆代码：

```
git clone https://github.com/hefengbao/one.git
````

::: tips 提示
Ubuntu 系统，如果要把项目放在 `/var/www` 目录下，则可能出现权限问题，
:::

### 安装扩展包：

```bash
composer install --optimize-autoloader --no-dev
```

```shell
php artisan storage:link
```

### 配置：

```
cp .env.example .env
php artisan key:generate
```

在 `.env` 文件中修改配置，主要是下面几项：

```
APP_NAME=Laravel #修改为自己的博客名称，若中间有空格、标点符号，请用英文引号（""）包裹
APP_ENV=production
APP_KEY=
APP_DEBUG=false
APP_URL=http://localhost # 修改为自己博客域名

...

DB_DATABASE=one // 修改数据库名称
DB_USERNAME=one    //修改数据库账号
DB_PASSWORD=        //修改数据库密码

...

MAIL_MAILER=smtp
MAIL_HOST=mailhog 
MAIL_PORT=1025
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS="hello@example.com"

```

验证邮箱是否配置成功：

```shell
php artisan one:check-email
```

### 生成数据表及数据填充:

```
php artisan migrate --seed
```

### 目录权限

```
chmod -R 775 storage/ bootstrap/
```

### 初始化管理员

```shell
php artisan one:init-admin
```

### nginx 站点配置

可参考：

```bash
server {
     listen 80;
     server_name one.test;
     rewrite ^(.*)$ https://$host$1 permanent;
     location / {
        index index.html index.htm;
     }
}

server {
    listen 443 ssl http2;
    server_name one.test;
    root "/var/www/one/public";
    
    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-Content-Type-Options "nosniff";
    
    index index.php;

    charset utf-8;

    location / {
        try_files $uri $uri/ /index.php?$query_string;

    }

    location = /favicon.ico { access_log off; log_not_found off; }
    location = /robots.txt  { access_log off; log_not_found off; }

    error_page 404 /index.php;

    access_log off;
    error_log  /var/log/nginx/one-error.log error;

    sendfile off;
    
    location ~ \.php$ {
        fastcgi_split_path_info ^(.+\.php)(/.+)$;
        fastcgi_pass unix:/var/run/php/php8.1-fpm.sock;
        fastcgi_index index.php;
        include fastcgi_params;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;


        fastcgi_intercept_errors off;
        fastcgi_buffer_size 16k;
        fastcgi_buffers 4 16k;
        fastcgi_connect_timeout 300;
        fastcgi_send_timeout 300;
        fastcgi_read_timeout 300;
    }

    location ~ /\.ht {
        deny all;
    }

    ssl_certificate     /etc/ssl/certs/one.test.crt;
    ssl_certificate_key /etc/ssl/certs/one.test.key;
    ssl_session_timeout 5m;
    #请按照以下协议配置
    ssl_protocols TLSv1.2 TLSv1.3; 
    #请按照以下套件配置，配置加密套件，写法遵循 openssl 标准。
    ssl_ciphers ECDHE-RSA-AES128-GCM-SHA256:HIGH:!aNULL:!MD5:!RC4:!DHE; 
    ssl_prefer_server_ciphers on;
}
```

:::tips 提示
Nginx 服务器 SSL 证书安装部署 https://cloud.tencent.com/document/product/400/35244
:::

### horizon

在 `/etc/supervisor/conf.d` 目录中添加 `one-horizon.conf` 文件，内容如下：

```shell
[program:one-horizon]
process_name=%(program_name)s
command=php /var/www/one/artisan horizon
autostart=true
autorestart=true
user=www-data
redirect_stderr=true
stdout_logfile=/var/www/one/storage/logs/horizon.log
stopwaitsecs=3600
```

```shell
sudo supervisorctl reread

sudo supervisorctl update

sudo supervisorctl start one-horizon:*
```

### 添加 cron 配置项

```shell
crontab -u www-data -e
```

```shell
* * * * * cd /var/www/one && php artisan schedule:run >> /dev/null 2>&1
```

## 优化

```shell
php artisan route:cache
php artisan view:cache
php artisan config:cache
```

:::tips 提示
安装成功后，登陆后台，修改个人资料，上传头像，这样做是为了生成 `upload` 目录，备份文件的时候只备份这个目录里的文件，初始状态这个目录不存在。
:::
