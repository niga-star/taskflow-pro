<?php

namespace Database\Seeders;

use App\Models\Project;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class ProjectSeeder extends Seeder
{
    public function run(): void
    {
        $owner = User::firstOrCreate(
            ['email' => 'lead@taskflow.dev'],
            [
                'name' => 'Sara Connor',
                'password' => Hash::make('password123'),
                'job_title' => 'Tech Lead',
                'role' => 'admin',
                'avatar_url' => 'https://ui-avatars.com/api/?name=Sara+Connor&background=6366f1&color=fff',
            ]
        );

        $dev = User::firstOrCreate(
            ['email' => 'dev@taskflow.dev'],
            [
                'name' => 'Alex Mercer',
                'password' => Hash::make('password123'),
                'job_title' => 'Full Stack Developer',
                'role' => 'member',
                'avatar_url' => 'https://ui-avatars.com/api/?name=Alex+Mercer&background=10b981&color=fff',
            ]
        );

        $project = Project::firstOrCreate(
            ['key' => 'TFP'],
            [
                'owner_id' => $owner->id,
                'name' => 'TaskFlow Pro Web',
                'description' => 'Agile sprint and issue tracking platform for engineering teams.',
                'status' => 'active',
            ]
        );

        $project->members()->syncWithoutDetaching([
            $owner->id => ['role' => 'admin'],
            $dev->id => ['role' => 'member'],
        ]);
    }
}
