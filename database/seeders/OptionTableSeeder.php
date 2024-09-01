<?php

namespace Database\Seeders;

use App\Constant\CommentStatus;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OptionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        //
        DB::table('options')->insert([
            [
                'id' => 1,
                'name' => 'title',
                'value' => '玉竹',
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
                'value' => 'Yuzhu,玉竹,blog,博客,微博客',
                'autoload' => 'yes',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ],
            [
                'id' => 4,
                'name' => 'description',
                'value' => '玉竹，一个简洁的博客、微博客。',
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
            ],
            [
                'id' => 7,
                'name' => 'default_comment_status',
                'value' => CommentStatus::Approved->value,
                'autoload' => 'yes',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ],
            [
                'id' => 8,
                'name' => 'site_verify_meta',
                'value' => '',
                'autoload' => 'yes',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ],
        ]);
    }
}
