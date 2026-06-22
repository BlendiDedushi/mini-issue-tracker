<?php

namespace Database\Seeders;

use App\Enums\UserRole;
use App\Models\Project;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $this->seedUser('admin@test.com', 'System Admin', UserRole::Admin);

        $owners = [
            ['email' => 'owner@test.com', 'name' => 'Project Owner'],
            ['email' => 'jane@test.com', 'name' => 'Jane Cooper'],
            ['email' => 'mark@test.com', 'name' => 'Mark Rivera'],
        ];

        foreach ($owners as $ownerData) {
            $owner = $this->seedUser($ownerData['email'], $ownerData['name'], UserRole::ProjectOwner);
            $this->seedProjectsForOwner($owner);
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

    private function seedProjectsForOwner(User $owner, int $minCount = 15): void
    {
        $needed = max(0, $minCount - $owner->ownedProjects()->count());

        if ($needed === 0) {
            return;
        }

        Project::factory()
            ->count($needed)
            ->for($owner, 'owner')
            ->create();
    }
}
