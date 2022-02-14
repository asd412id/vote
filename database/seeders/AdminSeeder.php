<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $cek = User::where('username', 'admin')->first();
        if ($cek) {
            $cek->delete();
        }
        User::create([
            'name' => 'Administrator',
            'username' => 'admin',
            'password' => bcrypt('P4sswrd'),
        ]);
    }
}
