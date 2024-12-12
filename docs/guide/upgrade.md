# 升级

进入站点目录,切换到 release 分支：

```shell
git checkout release
```

拉取最新代码：

```shell
git pull
```

安装最新依赖：

```shell
composer install
```

新功能初始化：

```shell
php artisan yuzhu:init
```

优化：

```shell
php artisan optimize
php artisan filament:optimize
```

