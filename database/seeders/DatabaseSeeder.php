<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'M. Iqbal Effendi',
            'email' => 'iqbaleff214@gmail.com',
        ]);
        User::factory()->create([
            'name' => 'Andika Sujanadi',
            'email' => 'andikasujanadi@gmail.com',
        ]);
    }
}
