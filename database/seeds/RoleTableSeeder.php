<?php

use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\Permission;
use Zizaco\Entrust\Traits\EntrustRoleTrait;
use Carbon\Carbon;

class RoleTableSeeder extends Seeder
{
    use EntrustRoleTrait;
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //角色
        $admin = Role::create([
            'name'=>'admin',
            'display_name'=>'管理员',
            'description'=>'管理员',
            'created_at'=>Carbon::now(),
            'updated_at'=>Carbon::now(),
        ]);

        $user = Role::create([
            'name'=>'user',
            'display_name'=>'用户',
            'description'=>'普通用户',
            'created_at'=>Carbon::now(),
            'updated_at'=>Carbon::now(),
        ]);


        //给角色赋予权限
        $permissions = Permission::all();
        foreach ($permissions as $permission){
            $admin->attachPermission($permission);
        }

        $userPermissions = Permission::where('name','post.index')
            ->orWhere('name','post.create')
            ->orWhere('name','post.destroy')
            ->orWhere('name','post.edit')
            ->orWhere('name','user.profile')
            ->get();
        foreach ($userPermissions as $permission){
            $user->attachPermission($permission);
        }
    }
}