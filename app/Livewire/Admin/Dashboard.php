<?php

namespace App\Livewire\Admin;

use App\Models\JudgingAssignment;
use App\Models\Project;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class Dashboard extends Component
{
    public int $totalProjects;

    public int $totalInternalJudges;

    public int $totalExternalJudges;

    public int $internalCompletionPercentage;

    public int $externalCompletionPercentage;

    public int $incompleteAssignmentsCount;

    public function mount(): void
    {
        $this->loadMetrics();
    }

    public function loadMetrics(): void
    {
        $this->totalProjects = Project::count();
        $this->totalInternalJudges = User::where('role', 'internal_judge')->count();
        $this->totalExternalJudges = User::where('role', 'external_judge')->count();

        $internalTotal = JudgingAssignment::where('stage', 'internal')->count();
        $internalCompleted = JudgingAssignment::where('stage', 'internal')->where('status', 'completed')->count();
        $this->internalCompletionPercentage = $internalTotal > 0 ? (int) round(($internalCompleted / $internalTotal) * 100) : 0;

        $externalTotal = JudgingAssignment::where('stage', 'external')->count();
        $externalCompleted = JudgingAssignment::where('stage', 'external')->where('status', 'completed')->count();
        $this->externalCompletionPercentage = $externalTotal > 0 ? (int) round(($externalCompleted / $externalTotal) * 100) : 0;

        $this->incompleteAssignmentsCount = JudgingAssignment::where('status', 'pending')->count();
    }

    public function render(): View
    {
        return view('livewire.admin.dashboard')
            ->layout('layouts.app');
    }
}
