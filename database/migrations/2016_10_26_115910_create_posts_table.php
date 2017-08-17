<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->bigIncrements('id')->index();
            $table->bigInteger('user_id')->unsigned()->index()->comment('用户ID');
            $table->bigInteger('category_id')->unsigned()->comment('类别ID');
            $table->string('post_title',100)->nullable(false)->commen('标题');
            $table->string('post_slug',100)->unique()->index()->comment('链接');
            $table->longText('post_content')->nullable(false)->comment('内容');
            $table->longText('post_content_filter')->nullable(false)->comment('内容过滤');
            $table->string('post_excerpt')->comment('文章摘要');
            $table->tinyInteger('post_status')->comment('状态：发布/草稿');
            $table->tinyInteger('comment_status')->comment('是否允许评论');
            $table->char('post_type',10)->comment('文章类型');
            $table->integer('comment_count')->default(0)->comment('评论数');
            $table->integer('view_count')->default(0)->comment('浏览数');
            $table->timestamp('published_at')->nullable();
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
        Schema::dropIfExists('posts');
    }
}
