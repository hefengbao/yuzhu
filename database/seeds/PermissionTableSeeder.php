<?php

use Illuminate\Database\Seeder;
use App\Models\Permission;
use Carbon\Carbon;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //权限
        $postIndex = Permission::create([
            'id' => 1,
            'name' => 'post.index',
            'display_name' => '文章列表',
            'description' => '文章列表',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        $postCreate = Permission::create([
            'id' => 2,
            'name' => 'post.create',
            'display_name' => '新建文章',
            'description' => '新建文章',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        $postEdit = Permission::create([
            'id' => 3,
            'name' => 'post.edit',
            'display_name' => '编辑文章',
            'description' => '编辑文章',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        $postDestroy = Permission::create([
            'id' => 4,
            'name' => 'post.destroy',
            'display_name' => '删除文章',
            'description' => '删除文章',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        $categoryIndex = Permission::create([
            'id' => 5,
            'name' => 'category.index',
            'display_name' => '分类目录',
            'description' => '分类目录',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        $categoryDestroy = Permission::create([
            'id' => 6,
            'name' => 'category.destroy',
            'display_name' => '删除分类',
            'description' => '删除分类',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        $tagIndex = Permission::create([
            'id' => 7,
            'name' => 'tag.index',
            'display_name' => '标签列表',
            'description' => '标签列表',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        $tagDestroy = Permission::create([
            'id' => 8,
            'name' => 'tag.destroy',
            'display_name' => '删除标签',
            'description' => '删除标签',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        $pageIndex = Permission::create([
            'id' => 9,
            'name' => 'page.index',
            'display_name' => '页面列表',
            'description' => '页面列表',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        $pageCreate = Permission::create([
            'id' => 10,
            'name' => 'page.create',
            'display_name' => '新建页面',
            'description' => '新建页面',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        $pageDestroy = Permission::create([
            'id' => 11,
            'name' => 'page.destroy',
            'display_name' => '删除页面',
            'description' => '删除页面',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        $pageEdit = Permission::create([
            'id' => 12,
            'name' => 'page.edit',
            'display_name' => '修改页面',
            'description' => '修改页面',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        $appearanceMenu = Permission::create([
            'id' => 13,
            'name' => 'appearance.menu',
            'display_name' => '主页菜单',
            'description' => '主页菜单',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        $userIndex = Permission::create([
            'id' => 14,
            'name' => 'user.index',
            'display_name' => '用户列表',
            'description' => '用户列表',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        $userProfile = Permission::create([
            'id' => 15,
            'name' => 'user.profile',
            'display_name' => '用户信息',
            'description' => '用户信息',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        $optionIndex = Permission::create([
            'id' => 16,
            'name' => 'option.index',
            'display_name' => '基本配置',
            'description' => '基本配置',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        $optionCache = Permission::create([
            'id' => 17,
            'name' => 'option.cache',
            'display_name' => '缓存配置',
            'description' => '缓存配置',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        $commentIndex = Permission::create([
            'id' => 18,
            'name' => 'comment.index',
            'display_name' => '评论列表',
            'description' => '评论列表',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        $commentDestroy = Permission::create([
            'id' => 19,
            'name' => 'comment.destroy',
            'display_name' => '删除评论',
            'description' => '删除评论',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
    }
}
