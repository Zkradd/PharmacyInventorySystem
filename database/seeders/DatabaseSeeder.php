<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        Role::create(['name' => 'admin']);

        $mainadmin = User::create([
            'name'=>'admin',
            'email'=>'admin@admin',
            'email_verified_at'=>now(),
            'password'=>'$2y$10$kThXAgBhgSX8g3LvPXKaA.NCbNJ.8tp2VVPoPGHicoSCwLHSfYY.2'      //Admin1!!
        ]);

        $mainadmin->assignRole('admin');
    }
}
