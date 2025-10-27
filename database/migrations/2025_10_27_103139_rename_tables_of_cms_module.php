<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::rename('posts', 'cms_posts');
        Schema::rename('tags', 'cms_tags');
        Schema::rename('comments', 'cms_comments');
        Schema::rename('categories', 'cms_categories');
        Schema::rename('post_tag', 'cms_post_tag');
        Schema::rename('postmetas', 'cms_postmetas');
        Schema::rename('category_post', 'cms_category_post');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::rename('cms_posts', 'posts');
        Schema::rename('cms_tags', 'tags');
        Schema::rename('cms_comments', 'comments');
        Schema::rename('cms_categories', 'categories');
        Schema::rename('cms_post_tag', 'post_tag');
        Schema::rename('cms_postmetas', 'postmetas');
        Schema::rename('cms_category_post', 'category_post');
    }
};
