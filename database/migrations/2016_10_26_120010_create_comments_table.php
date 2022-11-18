<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('post_id');
            $table->unsignedBigInteger('user_id')->nullable()->comment("注册用户ID");
            $table->unsignedBigInteger('parent_id')->nullable()->comment("被回复评论ID");
            $table->text('body')->comment('评论内容');
            $table->string('guest_name', 50)->nullable()->comment('游客用户名');
            $table->string('guest_email', 80)->nullable()->comment('游客邮箱');
            $table->ipAddress('ip')->nullable()->comment('IP');
            $table->string('user_agent')->nullable();
            $table->enum('status', ['spam', 'trash', 'pending', 'approved'])->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('comments');
    }
};
