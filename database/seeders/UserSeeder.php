<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    protected static ?string $password;
    public function run(): void
    {
        $users = [
            ['name' => 'Danilo', 'last_name' => 'Amico', 'email' => 'danilo@gmail.com', 'date_of_birth' => '1994-10-31', 'password' => static::$password ??= Hash::make('password')],
            ['name' => 'Riccardo', 'last_name' => 'Garbo', 'email' => 'riccardo@gmail.com', 'date_of_birth' => '1994-12-29', 'password' => static::$password ??= Hash::make('password')],
            ['name' => 'Lorenzo', 'last_name' => 'Chierisini', 'email' => 'lorenzo@gmail.com', 'date_of_birth' => '1997-04-14', 'password' => static::$password ??= Hash::make('password')],
            ['name' => 'Diego', 'last_name' => 'Brotza', 'email' => 'diego@gmail.com', 'date_of_birth' => '2005-02-10', 'password' => static::$password ??= Hash::make('password')],
            ['name' => 'Andrea', 'last_name' => 'Bevilacqua', 'email' => 'andrea@gmail.com', 'date_of_birth' => '2000-11-04', 'password' => static::$password ??= Hash::make('password')]
        ];

        foreach ($users as $user) {
            $new_user = new User();
            $new_user->fill($user);
            $new_user->save();
        }
    }
}
