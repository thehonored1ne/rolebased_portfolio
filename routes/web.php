<?php

use App\Http\Controllers\Admin\AccessCodeSecurityController;
use App\Http\Controllers\Admin\ContactMessageController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ExperienceController;
use App\Http\Controllers\Admin\PortfolioProfileController;
use App\Http\Controllers\Admin\ProjectController;
use App\Http\Controllers\Admin\SkillController;
use App\Http\Controllers\Auth\AccessCodeController;
use App\Http\Controllers\PortfolioController;
use Illuminate\Support\Facades\Route;

// 1. Public Portfolio
Route::get('/', [PortfolioController::class, 'index'])->name('home');
Route::post('/contact', [PortfolioController::class, 'contact'])
    ->middleware('throttle:5,1')
    ->name('portfolio.contact');

// 2. Pre-Authentication Access Code Gate
Route::get('/gate', [AccessCodeController::class, 'show'])->name('access-gate.show');
Route::post('/gate/verify', [AccessCodeController::class, 'verify'])->name('access-gate.verify');
Route::post('/gate/forgot', [AccessCodeController::class, 'sendReset'])->name('access-gate.forgot');
Route::get('/gate/reset/{token}', [AccessCodeController::class, 'showReset'])->name('access-gate.reset');
Route::post('/gate/reset', [AccessCodeController::class, 'updateCode'])->name('access-gate.update');

// 3. Admin CMS Management Area
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

        // Profile Editor
        Route::get('/profile', [PortfolioProfileController::class, 'edit'])->name('profile.edit');
        Route::put('/profile', [PortfolioProfileController::class, 'update'])->name('profile.update');

        // Projects Management
        Route::get('/projects', [ProjectController::class, 'index'])->name('projects.index');
        Route::post('/projects', [ProjectController::class, 'store'])->name('projects.store');
        Route::put('/projects/{project}', [ProjectController::class, 'update'])->name('projects.update');
        Route::delete('/projects/{project}', [ProjectController::class, 'destroy'])->name('projects.destroy');

        // Skills Management
        Route::get('/skills', [SkillController::class, 'index'])->name('skills.index');
        Route::post('/skills', [SkillController::class, 'store'])->name('skills.store');
        Route::put('/skills/{skill}', [SkillController::class, 'update'])->name('skills.update');
        Route::delete('/skills/{skill}', [SkillController::class, 'destroy'])->name('skills.destroy');

        // Experiences Management
        Route::get('/experiences', [ExperienceController::class, 'index'])->name('experiences.index');
        Route::post('/experiences', [ExperienceController::class, 'store'])->name('experiences.store');
        Route::put('/experiences/{experience}', [ExperienceController::class, 'update'])->name('experiences.update');
        Route::delete('/experiences/{experience}', [ExperienceController::class, 'destroy'])->name('experiences.destroy');

        // Contact Messages
        Route::get('/messages', [ContactMessageController::class, 'index'])->name('messages.index');
        Route::patch('/messages/{message}/read', [ContactMessageController::class, 'toggleRead'])->name('messages.read');
        Route::delete('/messages/{message}', [ContactMessageController::class, 'destroy'])->name('messages.destroy');

        // Secret Access PIN Security
        Route::get('/security/access-code', [AccessCodeSecurityController::class, 'edit'])->name('access-code.edit');
        Route::put('/security/access-code', [AccessCodeSecurityController::class, 'update'])->name('access-code.update');
    });
});

require __DIR__.'/settings.php';
