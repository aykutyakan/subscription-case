<?php

namespace Database\Seeders;

use App\Models\Device;
use App\Models\Purchase;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\PurchaseCallback::factory(1)->create();
        Device::factory(50)->create();
        Purchase::factory(50)->create();
        // \App\Models\User::factory(10)->create();
    }
}
