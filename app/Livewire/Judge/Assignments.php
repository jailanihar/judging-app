<?php

namespace App\Livewire\Judge;

use App\Models\JudgingAssignment;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Assignments extends Component
{
    public function render(): View
    {
        $assignments = JudgingAssignment::where('user_id', Auth::id())
            ->with('project', 'scores.criterion')
            ->orderByDesc('created_at')
            ->get();

        return view('livewire.judge.assignments', [
            'assignments' => $assignments,
        ])->layout('layouts.app');
    }
}
