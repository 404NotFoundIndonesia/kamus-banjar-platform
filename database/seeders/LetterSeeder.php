<?php

namespace Database\Seeders;

use App\Models\Letter;
use Illuminate\Database\Seeder;

class LetterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $alphabet = [
            'a', 'b', 'c', 'd', 'g', 'h', 'i', 'j', 'k', 'l',
            'm', 'n', 'p', 'r', 's', 't', 'u', 'w', 'y',
        ];
        foreach ($alphabet as $i => $letter) {
            $alphabet[$i] = [
                'letter' => $letter,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        Letter::insert($alphabet);
    }
}
