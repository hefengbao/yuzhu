<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('post_id')->comment('被评论文章ID');
            $table->string('comment_author', 50)->nullable(false)->comment('评论人');
            $table->string('comment_author_email', 80)->nullable(false)->comment('评论人邮箱');
            $table->string('comment_author_ip', 20)->comment('评论人IP地址');
            $table->text('comment_content')->comment('评论内容');
            $table->text('comment_content_filter')->comment('评论内容过滤');
            $table->bigInteger('comment_parent')->default(0)->comment("被回复评论ID");
            $table->bigInteger('user_id')->nullable()->comment("注册用户ID");
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
        Schema::dropIfExists('comments');
    }
}
