<?php

namespace App\Livewire\Admin;

use App\Models\Criterion;
use Flux\Flux;
use Illuminate\Contracts\View\View;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithPagination;

class Criteria extends Component
{
    use WithPagination;

    public string $code = '';

    public string $name = '';

    public ?string $description = null;

    public string $weight = '1.00';

    public bool $is_active = true;

    public ?int $editingId = null;

    /**
     * @return array<string, array<int, string|Rule>>
     */
    public function rules(): array
    {
        return [
            'code' => ['required', 'string', 'max:20'],
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'weight' => ['required', 'numeric', 'min:0'],
            'is_active' => ['required', 'boolean'],
        ];
    }

    public function resetForm(): void
    {
        $this->reset(['code', 'name', 'description', 'weight', 'is_active', 'editingId']);
        $this->resetValidation();
    }

    public function create(): void
    {
        $this->validate();
        Criterion::create([
            'code' => $this->code,
            'name' => $this->name,
            'description' => $this->description,
            'weight' => $this->weight,
            'is_active' => $this->is_active,
        ]);
        Flux::toast(variant: 'success', text: __('Criterion created.'));
        $this->resetForm();
        $this->dispatch('refresh-criteria');
    }

    public function edit(int $id): void
    {
        $criterion = Criterion::findOrFail($id);
        $this->editingId = $id;
        $this->code = $criterion->code;
        $this->name = $criterion->name;
        $this->description = $criterion->description;
        $this->weight = $criterion->weight;
        $this->is_active = $criterion->is_active;
    }

    public function update(): void
    {
        $this->validate();
        $criterion = Criterion::findOrFail($this->editingId);
        $criterion->update([
            'code' => $this->code,
            'name' => $this->name,
            'description' => $this->description,
            'weight' => $this->weight,
            'is_active' => $this->is_active,
        ]);
        Flux::toast(variant: 'success', text: __('Criterion updated.'));
        $this->resetForm();
        $this->dispatch('refresh-criteria');
    }

    public function toggleActive(int $id): void
    {
        $criterion = Criterion::findOrFail($id);
        $criterion->update(['is_active' => ! $criterion->is_active]);
        Flux::toast(variant: 'success', text: $criterion->is_active ? __('Criterion activated.') : __('Criterion deactivated.'));
        $this->dispatch('refresh-criteria');
    }

    public function delete(int $id): void
    {
        $criterion = Criterion::findOrFail($id);
        $criterion->delete();
        Flux::toast(variant: 'success', text: __('Criterion deleted.'));
        $this->dispatch('refresh-criteria');
    }

    public function render(): View
    {
        $criteria = Criterion::orderBy('code')->paginate(10);

        return view('livewire.admin.criteria', [
            'criteria' => $criteria,
        ])->layout('layouts.app');
    }
}
