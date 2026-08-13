<section class="w-full space-y-6">
    <div class="flex flex-col gap-1 sm:flex-row sm:items-center sm:justify-between">
        <div class="flex flex-col gap-1">
            <flux:heading size="xl">{{ __('Projects') }}</flux:heading>
            <flux:text class="text-zinc-500 dark:text-zinc-400">{{ __('Manage project submissions and judging workflow.') }}</flux:text>
        </div>
        <flux:button variant="primary" icon="plus" wire:click="$dispatch('open-modal', 'create-project')">
            {{ __('New Project') }}
        </flux:button>
    </div>

    <flux:card class="overflow-hidden p-0">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="bg-zinc-50/80 dark:bg-zinc-800/80">
                    <tr>
                        <th class="px-6 py-4 font-semibold text-zinc-500 dark:text-zinc-400">{{ __('Name') }}</th>
                        <th class="px-6 py-4 font-semibold text-zinc-500 dark:text-zinc-400">{{ __('Status') }}</th>
                        <th class="px-6 py-4 font-semibold text-zinc-500 dark:text-zinc-400">{{ __('Judging') }}</th>
                        <th class="px-6 py-4 font-semibold text-zinc-500 dark:text-zinc-400">{{ __('Created') }}</th>
                        <th class="px-6 py-4 text-right font-semibold text-zinc-500 dark:text-zinc-400">{{ __('Actions') }}</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-200 dark:divide-zinc-700">
                    @forelse($projects as $project)
                        <tr class="group transition-colors hover:bg-zinc-50/80 dark:hover:bg-zinc-800/40">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="flex items-center justify-center rounded-lg bg-navy-100 p-2 dark:bg-navy-800">
                                        <flux:icon icon="folder" class="size-4 text-navy-700 dark:text-navy-300" />
                                    </div>
                                    <div>
                                        <div class="font-semibold text-navy-900 dark:text-navy-100">{{ $project->name }}</div>
                                        @if($project->description)
                                            <div class="mt-1 line-clamp-1 text-xs text-zinc-500 dark:text-zinc-400">{{ $project->description }}</div>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <flux:badge :color="$project->status === 'active' ? 'emerald' : ($project->status === 'draft' ? 'zinc' : 'red')" size="sm">
                                    {{ ucfirst($project->status) }}
                                </flux:badge>
                            </td>
                            <td class="px-6 py-4">
                                @if($project->is_judging_open)
                                    <div class="flex items-center gap-2">
                                        <span class="relative flex h-2 w-2">
                                            <span class="absolute inline-flex h-full w-full animate-ping rounded-full bg-teal-400 opacity-75"></span>
                                            <span class="relative inline-flex h-2 w-2 rounded-full bg-teal-500"></span>
                                        </span>
                                        <flux:badge color="teal" size="sm">{{ __('Open') }}</flux:badge>
                                    </div>
                                @else
                                    <flux:badge color="zinc" size="sm">{{ __('Closed') }}</flux:badge>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-zinc-500 dark:text-zinc-400">{{ $project->created_at->format('M d, Y') }}</td>
                            <td class="px-6 py-4">
                                <div class="flex items-center justify-end gap-1 opacity-100 transition-opacity sm:opacity-0 sm:group-hover:opacity-100">
                                    <flux:button size="xs" variant="ghost" icon="pencil" wire:click="edit({{ $project->id }})" wire:key="edit-{{ $project->id }}"></flux:button>
                                    @if(! $project->is_judging_open)
                                        <flux:button size="xs" variant="ghost" icon="check-circle" wire:click="toggleJudging({{ $project->id }})" wire:key="toggle-{{ $project->id }}"></flux:button>
                                    @else
                                        <flux:button size="xs" variant="ghost" icon="x-circle" wire:click="toggleJudging({{ $project->id }})" wire:key="toggle-{{ $project->id }}"></flux:button>
                                    @endif
                                    <flux:button size="xs" variant="ghost" icon="trash" wire:click="delete({{ $project->id }})" wire:key="delete-{{ $project->id }}"></flux:button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center justify-center gap-3">
                                    <div class="flex items-center justify-center rounded-full bg-zinc-100 p-3 dark:bg-zinc-800">
                                        <flux:icon icon="folder-open" class="size-6 text-zinc-400" />
                                    </div>
                                    <flux:text class="text-zinc-500 dark:text-zinc-400">{{ __('No projects found.') }}</flux:text>
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
            {{ __('Showing :count projects', ['count' => $projects->total()]) }}
        </flux:text>
        {{ $projects->links() }}
    </div>

    <flux:modal name="create-project" focusable>
        <flux:card>
            <div class="p-6 pb-0">
                <flux:heading size="lg">{{ $editingId ? __('Edit Project') : __('New Project') }}</flux:heading>
                <flux:text class="mt-1 text-sm text-zinc-500 dark:text-zinc-400">{{ $editingId ? __('Update project details below.') : __('Create a new project submission.') }}</flux:text>
            </div>
            <div class="p-6">
                <form wire:submit="{{ $editingId ? 'update' : 'create' }}" class="space-y-5">
                    <flux:input wire:model="name" :label="__('Name')" required autofocus placeholder="Enter project name" />
                    <flux:textarea wire:model="description" :label="__('Description')" rows="3" placeholder="Brief project description"></flux:textarea>
                    <flux:select wire:model="status" :label="__('Status')">
                        <option value="draft">{{ __('Draft') }}</option>
                        <option value="active">{{ __('Active') }}</option>
                        <option value="archived">{{ __('Archived') }}</option>
                    </flux:select>
                    <div class="flex items-center justify-end gap-3">
                        <flux:button type="button" variant="ghost" wire:click="$dispatch('close-modal', 'create-project')">{{ __('Cancel') }}</flux:button>
                        <flux:button type="submit" variant="primary">{{ $editingId ? __('Update') : __('Create') }}</flux:button>
                    </div>
                </form>
            </div>
        </flux:card>
    </flux:modal>

    <flux:modal name="confirm-close-judging" focusable>
        <flux:card>
            <div class="p-6 pb-0">
                <div class="flex items-center gap-3">
                    <div class="flex items-center justify-center rounded-lg bg-red-100 p-2 dark:bg-red-900/30">
                        <flux:icon icon="exclamation-triangle" class="size-5 text-red-600 dark:text-red-400" />
                    </div>
                    <flux:heading size="lg">{{ __('Close Judging?') }}</flux:heading>
                </div>
            </div>
            <div class="p-6">
                <flux:text class="text-zinc-600 dark:text-zinc-400">{{ __('Are you sure you want to close judging for this project? This action can be reversed later.') }}</flux:text>
                <div class="mt-6 flex items-center justify-end gap-3">
                    <flux:button variant="ghost" wire:click="cancelCloseJudging">{{ __('Cancel') }}</flux:button>
                    <flux:button variant="danger" wire:click="confirmCloseJudging">{{ __('Close Judging') }}</flux:button>
                </div>
            </div>
        </flux:card>
    </flux:modal>
</section>
