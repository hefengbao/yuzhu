# FAQ

可能遇到的问题。

## The POST method is not supported for route admin/login. Supported methods: GET, HEAD

在登陆后台时遇到如图提示：

![](../images/faq1.png)

解决：

```shell
php artisan vendor:publish --force --tag=livewire:assets
```