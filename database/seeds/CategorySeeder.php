<?php

use Illuminate\Database\Seeder;
use App\Category;


class CategorySeeder extends Seeder
{
    public function run()
    {
        Category::create([
            'name' => 'Tailwind',
            'user_id' => 1
        ]);
        Category::create([
            'name' => 'Laravel',
            'user_id' => 1
        ]);
        Category::create([
            'name' => 'CSS',
            'user_id' => 1
        ]);
    }
}
