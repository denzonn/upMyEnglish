<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MateriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('materis')->insert([
            [
                'name' => 'Pronouncation',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Vocabulary',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Grammer',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
