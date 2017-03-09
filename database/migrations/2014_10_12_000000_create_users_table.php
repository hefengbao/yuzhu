<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('avatar',50)->nullable()->comment('头像');
            $table->string('website',50)->nullable()->comment('个人网站');
            $table->string('github',50)->nullable()->comment('Github');
            $table->string('weibo',50)->nullable()->comment('微博');
            $table->string('wechat',50)->nullable()->comment('微信二维码');
            $table->string('wechatpay',50)->nullable()->comment('微信支付二维码');
            $table->string('alipay',50)->nullable()->comment('支付宝二维码');
            $table->string('city',50)->nullable()->comment('城市');
            $table->string('company',50)->nullable()->comment('公司');
            $table->string('introduction')->nullable()->comment('个人简介');
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('users');
    }
}
