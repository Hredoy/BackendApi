<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\Products;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Products::factory(10)->create();
    }
}
