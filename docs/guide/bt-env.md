# 搭建环境

玉竹（Yuzhu）使用 PHP 语言开发。


## `PHP` 版本选择 8.2 及以上版本：

![](../images/bt10.png)


设置：

![](../images/bt16.png)

安装扩展：

![](../images/bt17.png)

需要安装的扩展参考 [https://laravel.com/docs/11.x/deployment#server-requirements](https://laravel.com/docs/11.x/deployment#server-requirements)


删除被禁用的函数：`proc_open `，`symlink`,`pcntl_*` 相关的函数

![](../images/bt29.png)


## 服务器软件选择 `Nginx`:


![](../images/bt4.png)


![](../images/bt5.png)



## 数据库选择 `MySql`:

![](../images/bt6.png)

![](../images/bt7.png)


顺便安装 phpMyAdmin,选择最高的版本即可：


![](../images/bt20.png)


## 缓存使用 `Redis` 数据库：


![](../images/bt8.png)

![](../images/bt9.png)







