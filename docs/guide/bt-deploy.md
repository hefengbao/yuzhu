# 部署

## 下载代码

[https://gitee.com/hefengbao/yuzhu/releases](https://gitee.com/hefengbao/yuzhu/releases) 或者 [https://github.com/hefengbao/yuzhu/releases](https://github.com/hefengbao/yuzhu/releases) 下载代码（压缩包）。

## 上传代码

![](../images/bt12.png)


解压代码：

![](../images/bt13.png)

![](../images/bt14.png)


## 添加数据库

![](../images/bt15.png)

## 添加站点

![](../images/bt18.png)

域名那里有域名填写域名，没有的话填写公网 IP。

根目录选择到 `public` 目录：

![](../images/bt19.png)

数据库选择 MySql, 用户名、账号填写上一步创建的。


一些设置：


![](../images/bt21.png)


复制粘贴如下内容，注意 `php8.3-fpm.sock` 这里根据实际的 PHP 版本修改，如果是 8.2 版本，则是 `php8.2-fpm.sock`, 以此类推。

```
location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

location ~ \.php$ {
    fastcgi_pass unix:/var/run/php/php8.3-fpm.sock;
    fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
    include fastcgi_params;
    fastcgi_hide_header X-Powered-By;
}
```

安装依赖：

![](../images/bt23.png)

点击【升级Composer】,提示升级成功后，点击左侧的【其他设置】，composer 会应用最新的版本。

复制 `--optimize-autoloader --no-dev --ignore-platform-reqs` 粘贴到【补充命令】那里。

配置好后点击【执行】。


![](../images/bt22.png)



一点修改：

![](../images/bt24.png)

![](../images/bt25.png)
