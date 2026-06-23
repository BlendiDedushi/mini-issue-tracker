<?php

namespace Database\Seeders;

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $this->seedUser('admin@test.com', 'System Admin', UserRole::Admin);

        foreach ([
            ['email' => 'owner@test.com', 'name' => 'Project Owner'],
            ['email' => 'jane@test.com', 'name' => 'Jane Cooper'],
            ['email' => 'mark@test.com', 'name' => 'Mark Rivera'],
        ] as $ownerData) {
            $this->seedUser($ownerData['email'], $ownerData['name'], UserRole::ProjectOwner);
        }

        foreach ([
            ['email' => 'member@test.com', 'name' => 'Team Member'],
            ['email' => 'alex@test.com', 'name' => 'Alex Nguyen'],
            ['email' => 'sam@test.com', 'name' => 'Sam Patel'],
        ] as $memberData) {
            $this->seedUser($memberData['email'], $memberData['name'], UserRole::Member);
        }
    }

    private function seedUser(string $email, string $name, UserRole $role): User
    {
        $user = User::firstOrCreate(
            ['email' => $email],
            [
                'name' => $name,
                'password' => Hash::make('password'),
            ]
        );

        $user->assignRole($role->value);

        return $user;
    }
}
