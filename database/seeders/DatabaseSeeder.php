<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\User::create([
            'name'              => 'Admin User',
            'email'             => 'admin@movietime.com',
            'password'          => Hash::make('admin123'),
            'is_admin'          => true,
            'email_verified_at' => Carbon::now()
        ]);

        \App\Models\User::factory(1500)->create();

        $this->call([
            MovieSeeder::class,
        ]);
    }
}
