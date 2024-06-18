<?php

namespace Database\Seeders;

use App\Models\Bulletin;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BulletinSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Bulletin::factory()->count(5)->create();
    }
}
