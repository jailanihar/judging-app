<section class="w-full space-y-6">
    <div class="flex flex-col gap-1 sm:flex-row sm:items-center sm:justify-between">
        <div class="flex flex-col gap-1">
            <flux:heading size="xl">{{ __('Grade Project') }}</flux:heading>
            <flux:text class="text-zinc-500 dark:text-zinc-400">{{ $assignment->project->name }}</flux:text>
        </div>
        <flux:badge :color="$assignment->stage === 'internal' ? 'teal' : 'blue'" size="lg">
            {{ ucfirst($assignment->stage) }} Judging
        </flux:badge>
    </div>

    <flux:card class="p-6">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="flex items-center justify-center rounded-lg bg-navy-100 p-2 dark:bg-navy-800">
                    <flux:icon icon="chart-bar" class="size-5 text-navy-700 dark:text-navy-300" />
                </div>
                <flux:text class="font-medium">{{ __('Progress') }}</flux:text>
            </div>
            <flux:text class="text-sm font-semibold text-zinc-700 dark:text-zinc-300">{{ $gradedCount }} / {{ $totalCriteria }} {{ __('criteria graded') }}</flux:text>
        </div>
        <div class="mt-4">
            <flux:progress :value="$totalCriteria > 0 ? round(($gradedCount / $totalCriteria) * 100) : 0" class="h-3" />
            <div class="mt-2 flex items-center justify-between text-xs text-zinc-500 dark:text-zinc-400">
                <flux:text>{{ __('Complete all criteria to submit') }}</flux:text>
                <flux:text class="font-medium">{{ $totalCriteria > 0 ? round(($gradedCount / $totalCriteria) * 100) : 0 }}%</flux:text>
            </div>
        </div>
    </flux:card>

    <form wire:submit="saveScores" class="space-y-4">
        @foreach($activeCriteria as $criterion)
            <flux:card class="group p-6 transition-shadow hover:shadow-md">
                <div class="flex items-start justify-between gap-4">
                    <div class="flex-1">
                        <div class="flex items-center gap-3">
                            <span class="inline-flex items-center justify-center rounded-lg bg-navy-100 px-3 py-1.5 text-sm font-bold text-navy-700 dark:bg-navy-800 dark:text-navy-200">{{ $criterion->code }}</span>
                            <flux:heading size="md" class="text-navy-900 dark:text-navy-100">{{ $criterion->name }}</flux:heading>
                        </div>
                        @if($criterion->description)
                            <flux:text class="mt-3 text-sm text-zinc-500 dark:text-zinc-400">{{ $criterion->description }}</flux:text>
                        @endif
                        <div class="mt-2 flex items-center gap-2">
                            <flux:text class="text-xs text-zinc-400">{{ __('Weight') }}:</flux:text>
                            <div class="flex h-1.5 w-12 overflow-hidden rounded-full bg-zinc-200 dark:bg-zinc-700">
                                <div class="h-full rounded-full bg-gradient-to-r from-navy-500 to-teal-500" style="width: {{ min(100, ($criterion->weight / 5) * 100) }}%"></div>
                            </div>
                            <flux:text class="text-xs font-medium text-zinc-600 dark:text-zinc-400">{{ $criterion->weight }}</flux:text>
                        </div>
                    </div>
                    <div class="w-36 shrink-0">
                        <flux:select wire:model="scores.{{ $criterion->id }}" :label="__('Score')" required>
                            <option value="">{{ __('Select') }}</option>
                            @for($i = 0; $i <= 5; $i++)
                                <option value="{{ $i }}">{{ $i }}</option>
                            @endfor
                        </flux:select>
                    </div>
                </div>
            </flux:card>
        @endforeach

        <div class="flex items-center justify-between rounded-xl border border-zinc-200 bg-zinc-50/50 p-4 dark:border-zinc-700 dark:bg-zinc-800/50">
            <flux:button variant="ghost" :href="route('judge.assignments')" wire:navigate>
                <flux:icon icon="arrow-left" class="size-4" />
                {{ __('Back to Assignments') }}
            </flux:button>
            <flux:button type="submit" variant="primary">
                <flux:icon icon="check" class="size-4" />
                {{ __('Save Scores') }}
            </flux:button>
        </div>
    </form>
</section>
