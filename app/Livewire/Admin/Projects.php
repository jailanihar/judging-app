<?php

namespace App\Livewire\Admin;

use App\Models\Project;
use Flux\Flux;
use Illuminate\Contracts\View\View;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithPagination;

class Projects extends Component
{
    use WithPagination;

    public string $name = '';

    public ?string $description = null;

    public string $status = 'draft';

    public ?int $editingId = null;

    public bool $showConfirmClose = false;

    public ?int $closingProjectId = null;

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'status' => ['required', 'string', Rule::in(['draft', 'active', 'archived'])],
        ];
    }

    public function resetForm(): void
    {
        $this->reset(['name', 'description', 'status', 'editingId']);
        $this->resetValidation();
    }

    public function create(): void
    {
        $this->validate();
        Project::create([
            'name' => $this->name,
            'description' => $this->description,
            'status' => $this->status,
        ]);
        Flux::toast(variant: 'success', text: __('Project created.'));
        $this->resetForm();
        $this->dispatch('refresh-projects');
    }

    public function edit(int $id): void
    {
        $project = Project::findOrFail($id);
        $this->editingId = $id;
        $this->name = $project->name;
        $this->description = $project->description;
        $this->status = $project->status;
    }

    public function update(): void
    {
        $this->validate();
        $project = Project::findOrFail($this->editingId);
        $project->update([
            'name' => $this->name,
            'description' => $this->description,
            'status' => $this->status,
        ]);
        Flux::toast(variant: 'success', text: __('Project updated.'));
        $this->resetForm();
        $this->dispatch('refresh-projects');
    }

    public function toggleJudging(int $id): void
    {
        $project = Project::findOrFail($id);
        if (! $project->is_judging_open) {
            $this->closingProjectId = null;
            $project->update(['is_judging_open' => true]);
            Flux::toast(variant: 'success', text: __('Judging opened for this project.'));
        } else {
            $this->closingProjectId = $id;
            $this->showConfirmClose = true;
        }
        $this->dispatch('refresh-projects');
    }

    public function confirmCloseJudging(): void
    {
        if ($this->closingProjectId) {
            $project = Project::findOrFail($this->closingProjectId);
            $project->update(['is_judging_open' => false]);
            Flux::toast(variant: 'success', text: __('Judging closed for this project.'));
        }
        $this->showConfirmClose = false;
        $this->closingProjectId = null;
        $this->dispatch('refresh-projects');
    }

    public function cancelCloseJudging(): void
    {
        $this->showConfirmClose = false;
        $this->closingProjectId = null;
    }

    public function delete(int $id): void
    {
        $project = Project::findOrFail($id);
        if ($project->is_judging_open) {
            Flux::toast(variant: 'danger', text: __('Cannot delete a project with open judging.'));

            return;
        }
        $project->delete();
        Flux::toast(variant: 'success', text: __('Project deleted.'));
        $this->dispatch('refresh-projects');
    }

    public function render(): View
    {
        $projects = Project::orderByDesc('created_at')->paginate(10);

        return view('livewire.admin.projects', [
            'projects' => $projects,
        ])->layout('layouts.app');
    }
}
