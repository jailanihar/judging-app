<?php

namespace App\Livewire\Admin;

use App\Models\User;
use Illuminate\Contracts\View\View;
use Livewire\Component;
use Livewire\WithPagination;

class JudgesOverview extends Component
{
    use WithPagination;

    public string $roleFilter = 'all';

    public function updatedRoleFilter(): void
    {
        $this->resetPage();
    }

    public function render(): View
    {
        $query = User::query()
            ->whereIn('role', ['internal_judge', 'external_judge'])
            ->with('judgingAssignments.project');

        if ($this->roleFilter !== 'all') {
            $query->where('role', $this->roleFilter);
        }

        $judges = $query->orderBy('role')->orderBy('name')->paginate(15);

        return view('livewire.admin.judges-overview', [
            'judges' => $judges,
        ])->layout('layouts.app');
    }
}
