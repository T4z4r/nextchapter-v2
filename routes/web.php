<?php

use App\Http\Controllers\Admin\AddonController;
use App\Http\Controllers\Admin\ContactMessageController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\FaqController;
use App\Http\Controllers\Admin\PlanController;
use App\Http\Controllers\Admin\PlatformFeatureController;
use App\Http\Controllers\Admin\SectionController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\StepController;
use App\Http\Controllers\Auth\AdminLoginController;
use App\Http\Controllers\Admin\TutorialController;
use App\Http\Controllers\Admin\ValueController;
use App\Http\Controllers\Admin\VisitController;
use App\Http\Controllers\EnquiryController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public site
|--------------------------------------------------------------------------
*/

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/legal', [HomeController::class, 'legal'])->name('legal');
Route::post('/enquiries', [EnquiryController::class, 'store'])->name('enquiries.store');
Route::post('/checkout-intent', [EnquiryController::class, 'checkoutIntent'])->name('checkout.intent');

/*
|--------------------------------------------------------------------------
| Admin authentication
|--------------------------------------------------------------------------
*/

Route::middleware('guest')->group(function () {
    Route::get('/admin/login', [AdminLoginController::class, 'showLogin'])->name('admin.login');
    Route::post('/admin/login', [AdminLoginController::class, 'login'])->name('admin.login.attempt');
});

Route::post('/admin/logout', [AdminLoginController::class, 'logout'])
    ->middleware('auth')
    ->name('admin.logout');

/*
|--------------------------------------------------------------------------
| Admin panel (content management)
|--------------------------------------------------------------------------
*/

Route::prefix('admin')
    ->name('admin.')
    ->middleware(['auth', App\Http\Middleware\EnsureAdmin::class])
    ->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

        Route::get('settings', [SettingController::class, 'edit'])->name('settings.edit');
        Route::put('settings', [SettingController::class, 'update'])->name('settings.update');

        Route::get('sections', [SectionController::class, 'index'])->name('sections.index');
        Route::get('sections/{section}/edit', [SectionController::class, 'edit'])->name('sections.edit');
        Route::put('sections/{section}', [SectionController::class, 'update'])->name('sections.update');

        Route::resource('steps', StepController::class)->except('show')->parameters(['steps' => 'id']);
        Route::post('steps/{id}/move/{direction}', [StepController::class, 'move'])
            ->whereIn('direction', ['up', 'down'])->name('steps.move');

        Route::resource('features', PlatformFeatureController::class)->except('show')->parameters(['features' => 'id']);
        Route::post('features/{id}/move/{direction}', [PlatformFeatureController::class, 'move'])
            ->whereIn('direction', ['up', 'down'])->name('features.move');

        Route::resource('tutorials', TutorialController::class)->except('show')->parameters(['tutorials' => 'id']);
        Route::post('tutorials/{id}/move/{direction}', [TutorialController::class, 'move'])
            ->whereIn('direction', ['up', 'down'])->name('tutorials.move');

        Route::resource('plans', PlanController::class)->except('show')->parameters(['plans' => 'id']);
        Route::post('plans/{id}/move/{direction}', [PlanController::class, 'move'])
            ->whereIn('direction', ['up', 'down'])->name('plans.move');

        Route::resource('addons', AddonController::class)->except('show')->parameters(['addons' => 'id']);
        Route::post('addons/{id}/move/{direction}', [AddonController::class, 'move'])
            ->whereIn('direction', ['up', 'down'])->name('addons.move');

        Route::resource('values', ValueController::class)->except('show')->parameters(['values' => 'id']);
        Route::post('values/{id}/move/{direction}', [ValueController::class, 'move'])
            ->whereIn('direction', ['up', 'down'])->name('values.move');

        Route::resource('faqs', FaqController::class)->except('show')->parameters(['faqs' => 'id']);
        Route::post('faqs/{id}/move/{direction}', [FaqController::class, 'move'])
            ->whereIn('direction', ['up', 'down'])->name('faqs.move');

        Route::get('messages', [ContactMessageController::class, 'index'])->name('messages.index');
        Route::get('messages/{message}', [ContactMessageController::class, 'show'])->name('messages.show');
        Route::delete('messages/{message}', [ContactMessageController::class, 'destroy'])->name('messages.destroy');

        Route::get('visits', [VisitController::class, 'index'])->name('visits.index');
    });
