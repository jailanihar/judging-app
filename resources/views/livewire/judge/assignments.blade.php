<section class="w-full space-y-6">
    <div class="flex flex-col gap-1">
        <flux:heading size="xl">{{ __('My Judging Assignments') }}</flux:heading>
        <flux:text class="text-zinc-500 dark:text-zinc-400">{{ __('Select an assignment to begin grading.') }}</flux:text>
    </div>

    <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-3">
        @forelse($assignments as $assignment)
            <flux:card class="group relative overflow-hidden p-6 transition-shadow hover:shadow-lg">
                <div class="absolute inset-0 bg-gradient-to-br from-navy-500/5 to-transparent dark:from-navy-400/5 opacity-0 transition-opacity group-hover:opacity-100"></div>
                <div class="relative">
                    <div class="flex items-start justify-between">
                        <div class="flex items-center gap-3">
                            <div class="flex items-center justify-center rounded-lg bg-navy-100 p-2 dark:bg-navy-800">
                                <flux:icon icon="folder" class="size-4 text-navy-700 dark:text-navy-300" />
                            </div>
                            <div>
                                <flux:heading size="md" class="text-navy-900 dark:text-navy-100">{{ $assignment->project->name }}</flux:heading>
                                <flux:badge :color="$assignment->stage === 'internal' ? 'teal' : 'blue'" class="mt-1.5" size="sm">
                                    {{ ucfirst($assignment->stage) }} Judging
                                </flux:badge>
                            </div>
                        </div>
                        <flux:badge :color="$assignment->status === 'completed' ? 'emerald' : 'amber'" size="sm">
                            {{ ucfirst($assignment->status) }}
                        </flux:badge>
                    </div>

                    @php
                        $gradedCount = $assignment->scores->count();
                        $totalCriteria = \App\Models\Criterion::where('is_active', true)->count();
                        $progressPercent = $totalCriteria > 0 ? round(($gradedCount / $totalCriteria) * 100) : 0;
                    @endphp

                    <div class="mt-5">
                        <div class="flex items-center justify-between text-sm">
                            <flux:text class="text-zinc-500 dark:text-zinc-400">{{ __('Progress') }}</flux:text>
                            <flux:text class="font-medium text-zinc-700 dark:text-zinc-300">{{ $gradedCount }} / {{ $totalCriteria }}</flux:text>
                        </div>
                        <flux:progress :value="$progressPercent" class="mt-2 h-2" />
                        <div class="mt-1.5 flex items-center justify-between">
                            <flux:text class="text-xs text-zinc-400">{{ __('criteria graded') }}</flux:text>
                            <flux:text class="text-xs font-medium text-zinc-600 dark:text-zinc-400">{{ $progressPercent }}%</flux:text>
                        </div>
                    </div>

                    <div class="mt-5">
                        <flux:button variant="primary" :href="route('judge.grade', $assignment->id)" wire:navigate class="w-full">
                            {{ $assignment->status === 'completed' ? __('Review Grades') : __('Grade Project') }}
                        </flux:button>
                    </div>
                </div>
            </flux:card>
        @empty
            <div class="md:col-span-2 lg:col-span-3">
                <flux:card class="p-8 text-center">
                    <div class="flex flex-col items-center justify-center gap-4">
                        <div class="flex items-center justify-center rounded-full bg-zinc-100 p-4 dark:bg-zinc-800">
                            <flux:icon icon="clipboard-document-list" class="size-8 text-zinc-400" />
                        </div>
                        <flux:text class="text-zinc-500 dark:text-zinc-400">{{ __('You have no judging assignments at this time.') }}</flux:text>
                    </div>
                </flux:card>
            </div>
        @endforelse
    </div>
</section>
