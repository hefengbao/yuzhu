<?php

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //角色
        $admin = Role::create([
            'id' => 1,
            'name' => 'Admin',
            'display_name' => '管理员',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        $user = Role::create([
            'id' => 2,
            'name' => 'User',
            'display_name' => '用户',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);


        //给角色赋予权限
        /*$permissions = Permission::all();

        $admin->syncPermissions($permissions);*/

        $userPermissions = Permission::whereIn('name', ['post.index','post.create','post.store',
            'post.destroy','post.update','post.edit','user.profile'])
            ->get();
        $user->syncPermissions($userPermissions);
    }
}
