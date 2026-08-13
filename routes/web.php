<?php

use App\Livewire\Admin\Criteria;
use App\Livewire\Admin\Dashboard;
use App\Livewire\Admin\JudgesOverview;
use App\Livewire\Admin\Projects;
use App\Livewire\Judge\Assignments;
use App\Livewire\Judge\GradeAssignment;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome')->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/home', function () {
        $user = auth()->user();

        if ($user->isAdmin()) {
            return redirect()->route('dashboard');
        }

        if ($user->isInternalJudge() || $user->isExternalJudge()) {
            return redirect()->route('judge.assignments');
        }

        return redirect()->route('dashboard');
    })->name('home.redirect');

    Route::middleware('role:admin')->group(function () {
        Route::livewire('dashboard', Dashboard::class)->name('dashboard');
        Route::livewire('projects', Projects::class)->name('projects');
        Route::livewire('criteria', Criteria::class)->name('criteria');
        Route::livewire('judges', JudgesOverview::class)->name('judges');
    });

    Route::middleware('role:internal_judge,external_judge')->group(function () {
        Route::livewire('my-assignments', Assignments::class)->name('judge.assignments');
        Route::livewire('grade/{assignmentId}', GradeAssignment::class)->name('judge.grade');
    });
});

require __DIR__.'/settings.php';
