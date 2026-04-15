<?php

namespace Database\Seeders;

use App\Models\Student;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'email' => 'admin@example.com',
            'password' => Hash::make('P@ssw0rd123'),
            'role' => 'administrator',
        ]);

        $students = Student::factory(15)->create();

        $students->take(6)->each(function ($student) {
            $user = User::factory()->create([
                'role' => 'user'
            ]);
            $student->update([
                'user_id' => $user->id
            ]);
        });
    }
}
