<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     * 
     * Run: php artisan migrate:fresh --seed
     */
    public function run(): void
    {
        // Use the comprehensive Konter HP Seeder
        $this->call([
            KonterHPSeeder::class,
        ]);
    }
}
