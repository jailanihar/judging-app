<section class="w-full space-y-6">
    <div class="flex flex-col gap-1 sm:flex-row sm:items-center sm:justify-between">
        <div class="flex flex-col gap-1">
            <flux:heading size="xl">{{ __('Evaluation Criteria') }}</flux:heading>
            <flux:text class="text-zinc-500 dark:text-zinc-400">{{ __('Define and configure alphanumeric evaluation criteria.') }}</flux:text>
        </div>
        <flux:button variant="primary" icon="plus" wire:click="$dispatch('open-modal', 'create-criterion')">
            {{ __('New Criterion') }}
        </flux:button>
    </div>

    <flux:card class="overflow-hidden p-0">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="bg-zinc-50/80 dark:bg-zinc-800/80">
                    <tr>
                        <th class="px-6 py-4 font-semibold text-zinc-500 dark:text-zinc-400">{{ __('Code') }}</th>
                        <th class="px-6 py-4 font-semibold text-zinc-500 dark:text-zinc-400">{{ __('Name') }}</th>
                        <th class="px-6 py-4 font-semibold text-zinc-500 dark:text-zinc-400">{{ __('Weight') }}</th>
                        <th class="px-6 py-4 font-semibold text-zinc-500 dark:text-zinc-400">{{ __('Status') }}</th>
                        <th class="px-6 py-4 text-right font-semibold text-zinc-500 dark:text-zinc-400">{{ __('Actions') }}</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-200 dark:divide-zinc-700">
                    @forelse($criteria as $criterion)
                        <tr class="group transition-colors hover:bg-zinc-50/80 dark:hover:bg-zinc-800/40">
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center justify-center rounded-lg bg-navy-100 px-3 py-1.5 text-sm font-bold text-navy-700 dark:bg-navy-800 dark:text-navy-200">{{ $criterion->code }}</span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div>
                                        <div class="font-semibold text-navy-900 dark:text-navy-100">{{ $criterion->name }}</div>
                                        @if($criterion->description)
                                            <div class="mt-1 line-clamp-1 text-xs text-zinc-500 dark:text-zinc-400">{{ $criterion->description }}</div>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-2">
                                    <div class="flex h-2 w-16 overflow-hidden rounded-full bg-zinc-200 dark:bg-zinc-700">
                                        <div class="h-full rounded-full bg-gradient-to-r from-navy-500 to-teal-500" style="width: {{ min(100, ($criterion->weight / 5) * 100) }}%"></div>
                                    </div>
                                    <span class="text-sm font-medium text-zinc-600 dark:text-zinc-400">{{ $criterion->weight }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                @if($criterion->is_active)
                                    <flux:badge color="emerald" size="sm">{{ __('Active') }}</flux:badge>
                                @else
                                    <flux:badge color="zinc" size="sm">{{ __('Inactive') }}</flux:badge>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center justify-end gap-1 opacity-100 transition-opacity sm:opacity-0 sm:group-hover:opacity-100">
                                    <flux:button size="xs" variant="ghost" icon="pencil" wire:click="edit({{ $criterion->id }})" wire:key="edit-{{ $criterion->id }}"></flux:button>
                                    <flux:button size="xs" variant="ghost" :icon="$criterion->is_active ? 'eye-slash' : 'eye'" wire:click="toggleActive({{ $criterion->id }})" wire:key="toggle-{{ $criterion->id }}"></flux:button>
                                    <flux:button size="xs" variant="ghost" icon="trash" wire:click="delete({{ $criterion->id }})" wire:key="delete-{{ $criterion->id }}"></flux:button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center justify-center gap-3">
                                    <div class="flex items-center justify-center rounded-full bg-zinc-100 p-3 dark:bg-zinc-800">
                                        <flux:icon icon="clipboard-document-list" class="size-6 text-zinc-400" />
                                    </div>
                                    <flux:text class="text-zinc-500 dark:text-zinc-400">{{ __('No criteria found.') }}</flux:text>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </flux:card>

    <div class="flex items-center justify-between">
        <flux:text class="text-sm text-zinc-500 dark:text-zinc-400">
            {{ __('Showing :count criteria', ['count' => $criteria->total()]) }}
        </flux:text>
        {{ $criteria->links() }}
    </div>

    <flux:modal name="create-criterion" focusable>
        <flux:card>
            <div class="p-6 pb-0">
                <flux:heading size="lg">{{ $editingId ? __('Edit Criterion') : __('New Criterion') }}</flux:heading>
                <flux:text class="mt-1 text-sm text-zinc-500 dark:text-zinc-400">{{ $editingId ? __('Update criterion details below.') : __('Create a new evaluation criterion.') }}</flux:text>
            </div>
            <div class="p-6">
                <form wire:submit="{{ $editingId ? 'update' : 'create' }}" class="space-y-5">
                    <flux:input wire:model="code" :label="__('Code')" required placeholder="1.1" />
                    <flux:input wire:model="name" :label="__('Name')" required placeholder="Criterion name" />
                    <flux:textarea wire:model="description" :label="__('Description')" rows="3" placeholder="Describe this criterion"></flux:textarea>
                    <flux:input type="number" wire:model="weight" :label="__('Weight')" step="0.01" min="0" required />
                    <flux:switch wire:model="is_active" :label="__('Active')" />
                    <div class="flex items-center justify-end gap-3">
                        <flux:button type="button" variant="ghost" wire:click="$dispatch('close-modal', 'create-criterion')">{{ __('Cancel') }}</flux:button>
                        <flux:button type="submit" variant="primary">{{ $editingId ? __('Update') : __('Create') }}</flux:button>
                    </div>
                </form>
            </div>
        </flux:card>
    </flux:modal>
</section>
