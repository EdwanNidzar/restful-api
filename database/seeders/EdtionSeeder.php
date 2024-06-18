<?php

namespace Database\Seeders;

use App\Models\Edtion;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EdtionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Edtion::factory()->count(5)->create();
    }
}
