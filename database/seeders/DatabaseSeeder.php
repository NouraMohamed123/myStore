<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\Store;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Database\Seeder;
use Database\Seeders\UserSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        //   Store::factory(5)->create();
        //  Category::factory(10)->create();
        Admin::factory(3)->create();
        //  Product::factory(100)->create();
        //  $this->call(UserSeeder::class);
    }
}