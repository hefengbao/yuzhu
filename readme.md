# One
This is a blog using Laravel framework (Laravel 5.4)

## 安装部署
1、克隆代码：
```
git clone https://github.com/fenble/one.git
````
2、安装扩展包：
```bash
composer install
```

3、生成配置文件：
```
cp .env.example .env
```
4、生成数据库及数据填充
```
php artisan migrate --seed
```
5、目录权限
```
chmod -R 775 storage/
```

## License
MIT