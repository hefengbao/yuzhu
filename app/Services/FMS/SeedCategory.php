<?php

namespace App\Services\FMS;

use App\Models\FMS\Category;
use App\Models\User;
use Illuminate\Support\Facades\Storage;

class SeedCategory
{
    public function seed(User $user)
    {
        $categories = Storage::json('template/fms/categories.json');

        foreach ($categories as $category) {
            $parent = Category::create([
                'user_id' => $user->id,
                'name' => $category['name'],
                'type' => $category['type']
            ]);
            if (count($category['children'])) {
                foreach ($category['children'] as $child) {
                    Category::create([
                        'user_id' => $user->id,
                        'parent_id' => $parent->id,
                        'name' => $child['name'],
                        'type' => $child['type']
                    ]);
                }
            }
        }
    }
}
