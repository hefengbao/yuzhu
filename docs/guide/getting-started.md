# 搭建环境

## 环境要求
建议服务器选用 Linux 操作系统。需要按装的软件有 php, nginx, mysql, redis, memcached, supervisor, git, composer。

::: tip Tips
php 版本需要 8.1 及以上，需要的 php 扩展：bcmath,ctype,dom,fileinfo,json,mbstring,openssl,pcre,pdo,tokenizer,xml。

nginx 可替换为 apache

mysql 可替换 MariaDB 等 MySQL 衍生数据库，以及 Laravel 支持的 Sqlite,PostgreSQL。
:::

::: warning 提示
以下说明基于 Ubuntu，如果使用其他版本的 Linux，请使用相应的命令。
:::

```shell
# Update Package List
apt-get update

# Update System Packages
apt-get upgrade -y

# Install Some PPAs
apt-add-repository ppa:ondrej/php -y

apt-get update
```

### 安装 PHP

```shell
# Install Generic PHP packages
apt-get install -y --allow-change-held-packages \
php-imagick php-memcached php-redis

# PHP 8.3
apt-get install -y --allow-change-held-packages \
php8.3 php8.3-bcmath php8.3-bz2 php8.3-cgi php8.3-cli php8.3-common php8.3-curl php8.3-dba php8.3-dev \
php8.3-enchant php8.3-fpm php8.3-gd php8.3-gmp php8.3-imap php8.3-interbase php8.3-intl php8.3-ldap \
php8.3-mbstring php8.3-mysql php8.3-odbc php8.3-opcache php8.3-pgsql php8.3-phpdbg php8.3-pspell php8.3-readline \
php8.3-snmp php8.3-soap php8.3-sqlite3 php8.3-sybase php8.3-tidy php8.3-xml php8.3-xsl \
php8.3-zip php8.3-imagick php8.3-memcached php8.3-redis php8.3-xmlrpc php8.3-xdebug
```

### 安装 Composer

```shell
  # Install Composer
  curl -sS https://getcomposer.org/installer | php
  mv composer.phar /usr/local/bin/composer
```

### 安装 Nginx

```shell
# Install Nginx
apt-get install -y --allow-downgrades --allow-remove-essential --allow-change-held-packages nginx
```

```shell
sudo apt install nginx
```

### 安装 Sqlite

```shell
apt-get install -y sqlite3 libsqlite3-dev
```

### 安装 Mysql

```shell
apt install -y mysql-server mysql-client mysql-common
```

### 安装 Redis, Memcached

```shell
apt-get install -y redis-server memcached

# redis 开机自启动
systemctl enable redis-server

service redis-server start
```

### 安装 Git

```shell
 apt install git
```


## 用户

创建新的系统用户

:::warning 注意
一般不推荐直接使用系统 root 用户来运行。如果您需要直接使用 root 用户，请跳过这一步。
:::

创建一个名为 web 的用户（名字可以随意）

```shell
useradd -m -s /bin/bash web
```

给予 sudo 权限

```shell
usermod -aG sudo web

# Centos 系统
usermod -G wheel web
```

为 web 用户创建密码

```shell
passwd web
```

登录到 one 账户

```shell
su - web
```

把当前用户添加到 www-data 用户组（Ubuntu 系统安装的 nginx、php8.3-fpm 默认使用 www-data 用户组）

```shell
usermod -a -G www-data $user
```


