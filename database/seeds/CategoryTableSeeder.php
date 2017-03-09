<?php

use Illuminate\Database\Seeder;

class CategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('categories')->insert([
            [
                'id'=>1,
                'category_name'=>'未分类',
                'category_slug'=>'uncategorized',
                'count'=>0,
                'category_parent'=>0
            ]
        ]);
    }
}
