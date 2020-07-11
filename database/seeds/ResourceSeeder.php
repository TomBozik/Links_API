<?php

use Illuminate\Database\Seeder;
use App\Resource;


class ResourceSeeder extends Seeder
{
    public function run()
    {
        Resource::create([
            'name' => 'Test',
            'description' => 'Test',
            'url' => 'https://www.google.sk',
            'user_id' => 1,
            'category_id' => 1,

        ]);

        Resource::create([
            'name' => 'Test2',
            'description' => 'Test2',
            'url' => 'https://www.google.sk',
            'user_id' => 1,
            'category_id' => 2,
            
        ]);

        Resource::create([
            'name' => 'Test3',
            'description' => 'Test3',
            'url' => 'https://www.google.sk',
            'user_id' => 1,
            'category_id' => 3,
            
        ]);

        Resource::create([
            'name' => 'Test4',
            'description' => 'Test4',
            'url' => 'https://www.google.sk',
            'user_id' => 1,
            'category_id' => 1,
            
        ]);
    }
}
