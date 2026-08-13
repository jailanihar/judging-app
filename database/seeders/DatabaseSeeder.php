<?php

namespace Database\Seeders;

use App\Models\Criterion;
use App\Models\JudgingAssignment;
use App\Models\Project;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $admin = User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'role' => 'admin',
        ]);

        $internalJudges = User::factory(3)->create()->each(fn ($user) => $user->update(['role' => 'internal_judge']));

        $externalJudges = User::factory(2)->create()->each(fn ($user) => $user->update(['role' => 'external_judge']));

        $projects = Project::factory(5)->create();

        $criteria = Criterion::factory(6)->create();

        foreach ($projects as $project) {
            foreach ($internalJudges as $judge) {
                JudgingAssignment::create([
                    'user_id' => $judge->id,
                    'project_id' => $project->id,
                    'stage' => 'internal',
                    'status' => 'pending',
                ]);
            }

            foreach ($externalJudges as $judge) {
                JudgingAssignment::create([
                    'user_id' => $judge->id,
                    'project_id' => $project->id,
                    'stage' => 'external',
                    'status' => 'pending',
                ]);
            }
        }
    }
}
