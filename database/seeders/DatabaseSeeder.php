<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
         // Tambahkan admin
         User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => bcrypt('password123'),
        ]);
        
        $this->call([
            KeretaSeeder::class,
            TiketSeeder::class,
        ]);

        // Tambahkan pengguna massal
        User::factory(10)->create(); // Buat 10 pengguna
    }
}
