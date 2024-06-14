# 快速开始

## 环境要求
建议服务器选用 Linux 操作系统。需要按装的软件有 php, nginx, mysql, redis, memcached, supervisor, git, composer。

::: tip Tips
php 版本需要 8.1 及以上，需要的 php 扩展：bcmath,ctype,dom,fileinfo,json,mbstring,openssl,pcre,pdo,tokenizer,xml。

nginx 可替换为 apache

mysql 可替换 MariaDB 等 MySQL 衍生数据库，以及 Laravel 支持的 Sqlite,PostgreSQL。
:::

::: alert 提示
以下说明基于 Ubuntu，如果使用其他版本的 Linux，请使用相应的命令。
:::

## 安装 PHP

## 安装 Composer

## 安装 Nginx

```shell
sudo apt install nginx
```

## 安装 Sqlite

```shell

```

## 安装 Mysql


## 安装 Git


创建新的系统用户
:::warning 注意
我们不推荐直接使用系统 root 用户来运行 One。如果您需要直接使用 root 用户，请跳过这一步。
:::

创建一个名为 one 的用户（名字可以随意）
```shell
useradd -m -s /bin/bash one
```
给予 sudo 权限
```shell
usermod -aG sudo one

# Centos 系统
usermod -G wheel one
```
为 one 用户创建密码
```shell
passwd one
```
登录到 one 账户
```shell
su - one
```

