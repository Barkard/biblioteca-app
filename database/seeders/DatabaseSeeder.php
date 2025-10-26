<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();
        $this->call(\Database\Seeders\RoleSeeder::class);

        User::factory()->create([
            'name' => 'Biscocho',
            'last_name' => 'Gay',
            'email' => 'biscochogay@gmail.com',
            'password' => '1234',
            'id_user' => '12345678',
            'nationality' => 'V',
            'role_id' => 1,
            'birthdate' => '2000-01-01',
            'status' => true,
        ]);
    }
}
