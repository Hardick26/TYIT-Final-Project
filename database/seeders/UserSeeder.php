<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder{
    /**
     * Run the database seeds.
     */
    public function run(): void {
        //
        $users = [
            [ 'role_id' => 1, 'name' => 'Hardik', 'email' => 'hardik@gmail.com', 'phone' => '+91 123465789', 'status' => 1, 'password' => Hash::make('admin') ],
            [ 'role_id' => 1, 'name' => 'Jyoti Singh', 'email' => 'jyoti@gmail.com', 'phone' => '+91 987654321', 'status' => 1, 'password' => Hash::make('admin') ],
            [ 'role_id' => 1, 'name' => 'Admin NoMan', 'email' => 'admin@gmail.com', 'phone' => '+91 1234554321', 'status' => 1, 'password' => Hash::make('admin') ],
            [ 'role_id' => 2, 'name' => 'Tony Stark', 'email' => 'tony@stark.com', 'phone' => '+88 (012) 34-567890', 'status' => 1, 'password' => Hash::make('secret') ],
            [ 'role_id' => 3, 'name' => 'John Doe', 'email' => 'admin@email.com', 'phone' => '+88 (012) 34-567891', 'status' => 1, 'password' => Hash::make('secret') ],
            [ 'role_id' => 3, 'name' => 'Jane Smith', 'email' => 'jsmith@email.com', 'phone' => '+88 (012) 34-567892', 'status' => 1, 'password' => Hash::make('secret') ],
        ];

        foreach ($users as $user) {
            User::create($user);
        }
    }
}
