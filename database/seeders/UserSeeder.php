<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::create([
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'password' => bcrypt('admin')
        ])->assignRole('Admin');


        User::factory()->create();
        (new \Laravolt\Avatar\Avatar)->create('Admin')->save(storage_path('app/public/avatar-' . $user->id . '.png'));

        $user2 = User::create([
            'name' => 'Collaborator',
            'email' => 'collaborator@collaborator.com',
            'password' => bcrypt('admin')
        ])->assignRole('Collaborator');


        User::factory()->create();
        (new \Laravolt\Avatar\Avatar)->create('Admin')->save(storage_path('app/public/avatar-' . $user2->id . '.png'));
    }
}
