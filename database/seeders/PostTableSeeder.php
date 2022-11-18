<?php

namespace Database\Seeders;

use DB;
use Illuminate\Database\Seeder;

class OptionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('options')->insert([
            [
                'id' => 1,
                'name' => 'title',
                'value' => 'One',
                'autoload' => 'yes',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ],
            [
                'id' => 2,
                'name' => 'subtitle',
                'value' => '一个简洁的博客、微博客',
                'autoload' => 'yes',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ],
            [
                'id' => 3,
                'name' => 'keywords',
                'value' => 'one,blog,博客,微博客',
                'autoload' => 'yes',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ],
            [
                'id' => 4,
                'name' => 'description',
                'value' => 'one 一个简洁的博客、微博客。',
                'autoload' => 'yes',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ],
            [
                'id' => 5,
                'name' => 'icp',
                'value' => '',
                'autoload' => 'yes',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ],
            [
                'id' => 6,
                'name' => 'users_can_register',
                'value' => '0',
                'autoload' => 'yes',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ]
        ]);
    }
}
