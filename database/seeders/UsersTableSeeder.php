<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $usersCount=(int)$this->command->ask('How many users to add:',20);
        User::factory()->count(1)->john_doe()->create();
        User::factory(10)->count($usersCount)->create();
        
    }
}
