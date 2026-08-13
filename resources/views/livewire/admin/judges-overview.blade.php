<section class="w-full space-y-6">
    <div class="flex flex-col gap-1 sm:flex-row sm:items-center sm:justify-between">
        <div class="flex flex-col gap-1">
            <flux:heading size="xl">{{ __('Judges Overview') }}</flux:heading>
            <flux:text class="text-zinc-500 dark:text-zinc-400">{{ __('Track panel completion and identify incomplete assignments.') }}</flux:text>
        </div>
        <flux:select wire:model.live="roleFilter" class="w-64">
            <option value="all">{{ __('All Roles') }}</option>
            <option value="internal_judge">{{ __('Internal Judges') }}</option>
            <option value="external_judge">{{ __('External Judges') }}</option>
        </flux:select>
    </div>

    <flux:card class="overflow-hidden p-0">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="bg-zinc-50/80 dark:bg-zinc-800/80">
                    <tr>
                        <th class="px-6 py-4 font-semibold text-zinc-500 dark:text-zinc-400">{{ __('Judge') }}</th>
                        <th class="px-6 py-4 font-semibold text-zinc-500 dark:text-zinc-400">{{ __('Role') }}</th>
                        <th class="px-6 py-4 font-semibold text-zinc-500 dark:text-zinc-400">{{ __('Assigned Projects') }}</th>
                        <th class="px-6 py-4 font-semibold text-zinc-500 dark:text-zinc-400">{{ __('Completed') }}</th>
                        <th class="px-6 py-4 font-semibold text-zinc-500 dark:text-zinc-400">{{ __('Progress') }}</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-200 dark:divide-zinc-700">
                    @forelse($judges as $judge)
                        @php
                            $totalAssignments = $judge->judgingAssignments->count();
                            $completedAssignments = $judge->judgingAssignments->where('status', 'completed')->count();
                            $pendingAssignments = $totalAssignments - $completedAssignments;
                            $percentage = $totalAssignments > 0 ? round(($completedAssignments / $totalAssignments) * 100) : 0;
                        @endphp
                        <tr class="group transition-colors hover:bg-zinc-50/80 dark:hover:bg-zinc-800/40">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <flux:avatar :initials="$judge->initials()" :name="$judge->name" size="sm" class="rounded-lg" />
                                    <div>
                                        <div class="font-semibold text-navy-900 dark:text-navy-100">{{ $judge->name }}</div>
                                        <div class="text-xs text-zinc-500 dark:text-zinc-400">{{ $judge->email }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <flux:badge :color="$judge->role === 'internal_judge' ? 'teal' : 'blue'" size="sm">
                                    {{ ucfirst(str_replace('_', ' ', $judge->role)) }}
                                </flux:badge>
                            </td>
                            <td class="px-6 py-4 text-zinc-600 dark:text-zinc-400">{{ $totalAssignments }}</td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-2">
                                    <span class="text-zinc-600 dark:text-zinc-400">{{ $completedAssignments }} / {{ $totalAssignments }}</span>
                                    @if($pendingAssignments > 0)
                                        <flux:badge color="red" size="sm">{{ $pendingAssignments }} {{ __('pending') }}</flux:badge>
                                    @endif
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <flux:progress :value="$percentage" class="h-2 w-24" />
                                    <span class="text-xs font-medium text-zinc-600 dark:text-zinc-400">{{ $percentage }}%</span>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center justify-center gap-3">
                                    <div class="flex items-center justify-center rounded-full bg-zinc-100 p-3 dark:bg-zinc-800">
                                        <flux:icon icon="users" class="size-6 text-zinc-400" />
                                    </div>
                                    <flux:text class="text-zinc-500 dark:text-zinc-400">{{ __('No judges found.') }}</flux:text>
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
            {{ __('Showing :count judges', ['count' => $judges->total()]) }}
        </flux:text>
        {{ $judges->links() }}
    </div>
</section>
