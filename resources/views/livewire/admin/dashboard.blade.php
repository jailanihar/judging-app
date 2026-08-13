<section class="w-full space-y-8">
    <div class="flex flex-col gap-1">
        <flux:heading size="xl">{{ __('Dashboard') }}</flux:heading>
        <flux:text class="text-zinc-500 dark:text-zinc-400">{{ __('Welcome to the Institutional Innovation Award Platform.') }}</flux:text>
    </div>

    <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-4">
        <flux:card class="relative overflow-hidden p-6">
            <div class="absolute inset-0 bg-gradient-to-br from-navy-500/10 to-transparent dark:from-navy-400/10"></div>
            <div class="relative">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3 rounded-lg bg-navy-100 p-2.5 dark:bg-navy-800">
                        <flux:icon icon="folder" class="size-5 text-navy-700 dark:text-navy-300" />
                    </div>
                </div>
                <flux:text class="mt-4 text-sm font-medium text-zinc-500 dark:text-zinc-400">{{ __('Total Projects') }}</flux:text>
                <flux:heading class="mt-1 text-3xl font-bold text-navy-900 dark:text-navy-100">{{ $totalProjects }}</flux:heading>
            </div>
        </flux:card>

        <flux:card class="relative overflow-hidden p-6">
            <div class="absolute inset-0 bg-gradient-to-br from-teal-500/10 to-transparent dark:from-teal-400/10"></div>
            <div class="relative">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3 rounded-lg bg-teal-100 p-2.5 dark:bg-teal-900/30">
                        <flux:icon icon="user-group" class="size-5 text-teal-700 dark:text-teal-300" />
                    </div>
                </div>
                <flux:text class="mt-4 text-sm font-medium text-zinc-500 dark:text-zinc-400">{{ __('Internal Judges') }}</flux:text>
                <flux:heading class="mt-1 text-3xl font-bold text-navy-900 dark:text-navy-100">{{ $totalInternalJudges }}</flux:heading>
                <div class="mt-3 flex items-center gap-3">
                    <flux:progress :value="$internalCompletionPercentage" class="h-1.5 flex-1" />
                    <flux:text class="text-xs font-medium text-zinc-500 dark:text-zinc-400">{{ $internalCompletionPercentage }}%</flux:text>
                </div>
            </div>
        </flux:card>

        <flux:card class="relative overflow-hidden p-6">
            <div class="absolute inset-0 bg-gradient-to-br from-blue-500/10 to-transparent dark:from-blue-400/10"></div>
            <div class="relative">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3 rounded-lg bg-blue-100 p-2.5 dark:bg-blue-900/30">
                        <flux:icon icon="user-group" class="size-5 text-blue-700 dark:text-blue-300" />
                    </div>
                </div>
                <flux:text class="mt-4 text-sm font-medium text-zinc-500 dark:text-zinc-400">{{ __('External Judges') }}</flux:text>
                <flux:heading class="mt-1 text-3xl font-bold text-navy-900 dark:text-navy-100">{{ $totalExternalJudges }}</flux:heading>
                <div class="mt-3 flex items-center gap-3">
                    <flux:progress :value="$externalCompletionPercentage" class="h-1.5 flex-1" />
                    <flux:text class="text-xs font-medium text-zinc-500 dark:text-zinc-400">{{ $externalCompletionPercentage }}%</flux:text>
                </div>
            </div>
        </flux:card>

        <flux:card class="relative overflow-hidden p-6">
            <div class="absolute inset-0 bg-gradient-to-br from-{{ $incompleteAssignmentsCount > 0 ? 'red' : 'emerald' }}-500/10 to-transparent dark:from-{{ $incompleteAssignmentsCount > 0 ? 'red' : 'emerald' }}-400/10"></div>
            <div class="relative">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3 rounded-lg bg-{{ $incompleteAssignmentsCount > 0 ? 'red' : 'emerald' }}-100 p-2.5 dark:bg-{{ $incompleteAssignmentsCount > 0 ? 'red' : 'emerald' }}-900/30">
                        <flux:icon icon="exclamation-circle" class="size-5 text-{{ $incompleteAssignmentsCount > 0 ? 'red' : 'emerald' }}-700 dark:text-{{ $incompleteAssignmentsCount > 0 ? 'red' : 'emerald' }}-300" />
                    </div>
                    @if($incompleteAssignmentsCount > 0)
                        <flux:badge color="red" size="sm">{{ __('Alert') }}</flux:badge>
                    @endif
                </div>
                <flux:text class="mt-4 text-sm font-medium text-zinc-500 dark:text-zinc-400">{{ __('Incomplete Assignments') }}</flux:text>
                <flux:heading class="mt-1 text-3xl font-bold {{ $incompleteAssignmentsCount > 0 ? 'text-red-600 dark:text-red-400' : 'text-emerald-600 dark:text-emerald-400' }}">{{ $incompleteAssignmentsCount }}</flux:heading>
            </div>
        </flux:card>
    </div>

    <div class="grid gap-6 lg:grid-cols-3">
        <flux:card class="lg:col-span-2 p-6">
            <div class="flex items-center justify-between pb-4">
                <div>
                    <flux:heading size="md">{{ __('Judging Progress') }}</flux:heading>
                    <flux:text class="text-sm text-zinc-500 dark:text-zinc-400">{{ __('Track completion across both judging stages') }}</flux:text>
                </div>
            </div>
            <div class="space-y-6">
                <div class="rounded-xl border border-zinc-200 bg-zinc-50/50 p-5 dark:border-zinc-700 dark:bg-zinc-800/50">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="flex items-center justify-center rounded-lg bg-teal-100 p-2 dark:bg-teal-900/30">
                                <flux:icon icon="user-group" class="size-4 text-teal-700 dark:text-teal-300" />
                            </div>
                            <flux:text class="font-medium">{{ __('Internal Judging') }}</flux:text>
                        </div>
                        <flux:text class="text-sm font-semibold text-zinc-700 dark:text-zinc-300">{{ $internalCompletionPercentage }}%</flux:text>
                    </div>
                    <flux:progress :value="$internalCompletionPercentage" class="mt-4 h-2.5" />
                    <div class="mt-3 flex items-center justify-between text-xs text-zinc-500 dark:text-zinc-400">
                        <flux:text>{{ __('Completion rate') }}</flux:text>
                        <flux:text>{{ $internalCompletionPercentage }}% {{ __('complete') }}</flux:text>
                    </div>
                </div>
                <div class="rounded-xl border border-zinc-200 bg-zinc-50/50 p-5 dark:border-zinc-700 dark:bg-zinc-800/50">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="flex items-center justify-center rounded-lg bg-blue-100 p-2 dark:bg-blue-900/30">
                                <flux:icon icon="user-group" class="size-4 text-blue-700 dark:text-blue-300" />
                            </div>
                            <flux:text class="font-medium">{{ __('External Judging') }}</flux:text>
                        </div>
                        <flux:text class="text-sm font-semibold text-zinc-700 dark:text-zinc-300">{{ $externalCompletionPercentage }}%</flux:text>
                    </div>
                    <flux:progress :value="$externalCompletionPercentage" class="mt-4 h-2.5" />
                    <div class="mt-3 flex items-center justify-between text-xs text-zinc-500 dark:text-zinc-400">
                        <flux:text>{{ __('Completion rate') }}</flux:text>
                        <flux:text>{{ $externalCompletionPercentage }}% {{ __('complete') }}</flux:text>
                    </div>
                </div>
            </div>
        </flux:card>

        <flux:card class="p-6">
            <div class="flex items-center gap-3 pb-4">
                <div class="flex items-center justify-center rounded-lg bg-navy-100 p-2 dark:bg-navy-800">
                    <flux:icon icon="chart-bar" class="size-5 text-navy-700 dark:text-navy-300" />
                </div>
                <flux:heading size="md">{{ __('Overview') }}</flux:heading>
            </div>
            <div class="space-y-4">
                <div class="flex items-center justify-between rounded-lg border border-zinc-200 p-3 dark:border-zinc-700">
                    <flux:text class="text-sm text-zinc-600 dark:text-zinc-400">{{ __('Total Projects') }}</flux:text>
                    <flux:badge color="navy">{{ $totalProjects }}</flux:badge>
                </div>
                <div class="flex items-center justify-between rounded-lg border border-zinc-200 p-3 dark:border-zinc-700">
                    <flux:text class="text-sm text-zinc-600 dark:text-zinc-400">{{ __('Internal Judges') }}</flux:text>
                    <flux:badge color="teal">{{ $totalInternalJudges }}</flux:badge>
                </div>
                <div class="flex items-center justify-between rounded-lg border border-zinc-200 p-3 dark:border-zinc-700">
                    <flux:text class="text-sm text-zinc-600 dark:text-zinc-400">{{ __('External Judges') }}</flux:text>
                    <flux:badge color="blue">{{ $totalExternalJudges }}</flux:badge>
                </div>
                <div class="flex items-center justify-between rounded-lg border border-zinc-200 p-3 dark:border-zinc-700">
                    <flux:text class="text-sm text-zinc-600 dark:text-zinc-400">{{ __('Pending Assignments') }}</flux:text>
                    <flux:badge :color="$incompleteAssignmentsCount > 0 ? 'red' : 'emerald'">{{ $incompleteAssignmentsCount }}</flux:badge>
                </div>
            </div>
        </flux:card>
    </div>
</section>
