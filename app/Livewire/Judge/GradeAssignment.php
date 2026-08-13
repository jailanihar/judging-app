<?php

namespace App\Livewire\Judge;

use App\Models\Criterion;
use App\Models\JudgingAssignment;
use App\Models\Score;
use Flux\Flux;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class GradeAssignment extends Component
{
    public JudgingAssignment $assignment;

    /**
     * @var array<int, int|string>
     */
    public array $scores = [];

    public int $gradedCount = 0;

    public int $totalCriteria = 0;

    public function mount(int $assignmentId): void
    {
        $this->assignment = JudgingAssignment::where('user_id', Auth::id())
            ->where('id', $assignmentId)
            ->with('project')
            ->firstOrFail();

        $this->loadScores();
    }

    public function loadScores(): void
    {
        $activeCriteria = Criterion::where('is_active', true)->orderBy('code')->get();
        $this->totalCriteria = $activeCriteria->count();

        $existingScores = $this->assignment->scores()->get()->keyBy('criterion_id');

        foreach ($activeCriteria as $criterion) {
            $this->scores[$criterion->id] = $existingScores[$criterion->id]->score ?? '';
        }

        $this->gradedCount = collect($this->scores)->filter(fn ($s) => $s !== '')->count();
    }

    public function saveScores(): void
    {
        foreach ($this->scores as $criterionId => $score) {
            if ($score !== '' && $score !== null) {
                Score::updateOrCreate(
                    [
                        'judging_assignment_id' => $this->assignment->id,
                        'criterion_id' => $criterionId,
                    ],
                    [
                        'score' => $score,
                    ]
                );
            }
        }

        $this->assignment->update(['status' => 'completed']);

        Flux::toast(variant: 'success', text: __('Scores saved successfully.'));
        $this->redirect(route('judge.assignments'), navigate: true);
    }

    public function render(): View
    {
        $activeCriteria = Criterion::where('is_active', true)->orderBy('code')->get();
        $this->totalCriteria = $activeCriteria->count();
        $this->gradedCount = collect($this->scores)->filter(fn ($s) => $s !== '')->count();

        return view('livewire.judge.grade-assignment', [
            'activeCriteria' => $activeCriteria,
        ])->layout('layouts.app');
    }
}
