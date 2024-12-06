<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\{
    SectionController
};

Route::get('/admin-dashboard', function () {
    return view('admin-dashboard');
})->name('admin-dashboard'); // New route pointing to admin-dashboard.blade.php

Route::get('/admin-dashboard', [App\Http\Controllers\HomeController::class, 'dashboard'])->name('admin-dashboard'); // HomeController route
Route::get('/api/admin-dashboard', [App\Http\Controllers\HomeController::class, 'getBounceData'])->name('api.admin-dashboard');

Auth::routes();

Route::get('/', function () {
    return view('welcome'); // This will load the welcome.blade.php view
});

Route::get('/manage-school-year', [App\Http\Controllers\SchoolYearController::class, 'loadAllSchoolYear'])->name('manage.school.year');
Route::post('/manage-school-year', [App\Http\Controllers\SchoolYearController::class, 'storeSchoolYear'])->name('storeSchoolYear');
Route::patch('/school-year/toggle-status/{id}', [App\Http\Controllers\SchoolYearController::class, 'toggleStatus'])->name('toggleStatus');

Route::get('/manage-year-level', [App\Http\Controllers\YearLevelController::class, 'loadYearLevel'])->name('manage.year.level');
Route::post('/manage-year-level', [App\Http\Controllers\YearLevelController::class, 'storeYearLevel'])->name('storeYearLevel');
Route::put('/manage-year-level', [App\Http\Controllers\YearLevelController::class, 'updateYearLevel'])->name('updateYearLevel');
Route::delete('/manage-year-level/{id}', [App\Http\Controllers\YearLevelController::class, 'destroyYearLevel'])->name('deleteYearLevel');

Route::get('/manage-section', [App\Http\Controllers\SectionController::class, 'loadSection'])->name('manage.section');
Route::post('/manage-section', [App\Http\Controllers\SectionController::class, 'storeSection'])->name('storeSection');
Route::put('/update-section', [App\Http\Controllers\SectionController::class, 'updateSection'])->name('updateSection');
Route::delete('/manage-section/{id}', [App\Http\Controllers\SectionController::class, 'destroySection'])->name('deleteSection');
Route::get('/api/get-sections/{yearLevelId}', [SectionController::class, 'getSectionsByYearLevel']);
Route::get('/get-sections/{yearLevelId}', [SectionController::class, 'getSections']);
Route::get('/get-details/{yearLevelId}/{sectionId}', [SectionController::class, 'getDetails']);

Route::get('/manage-schedule', [App\Http\Controllers\ScheduleController::class, 'loadSchedule'])->name('manage.schedule');
Route::post('/manage-schedule', [App\Http\Controllers\ScheduleController::class, 'storeSchedule'])->name('storeSchedule');
Route::put('/manage-schedule', [App\Http\Controllers\ScheduleController::class, 'updateSchedule'])->name('updateSchedule');
Route::delete('/manage-schedule/{id}', [App\Http\Controllers\ScheduleController::class, 'destroySchedule'])->name('deleteSchedule');

Route::get('/manage-billing', [App\Http\Controllers\BillingController::class, 'loadBilling'])->name('manageBilling');
Route::post('/manage-billing', [App\Http\Controllers\BillingController::class, 'storeBilling'])->name('storeBilling');
Route::put('/manage-billing', [App\Http\Controllers\BillingController::class, 'updateBilling'])->name('updateBilling');
Route::delete('/manage-billing/{id}', [App\Http\Controllers\BillingController::class, 'destroyBilling'])->name('deleteBilling');


Route::get('/manage-newsfeed', [App\Http\Controllers\NewsfeedController::class, 'index'])->name('manage.newsfeed');

Route::get('/manage-admission', [App\Http\Controllers\AdmissionController::class, 'loadAdmission'])->name('manage.admission');
Route::post('/manage-admission', [App\Http\Controllers\StudentController::class, 'storeStudentWithMedical'])->name('storeStudentWithMedical');


Route::get('/manage-enrollment', [App\Http\Controllers\EnrollmentController::class, 'index'])->name('manage.enrollment');

Route::get('/manage-parents', [App\Http\Controllers\ParentsController::class, 'loadParents'])->name('manage.parents');
Route::post('/manage-parents', [App\Http\Controllers\ParentsController::class, 'storeParentWithUsername'])->name('storeParentWithUsername');

Route::get('/manage-chat-support', [App\Http\Controllers\ChatSupportController::class, 'index'])->name('manage.chat.support');

Route::get('/manage-profile', [App\Http\Controllers\ProfileController::class, 'index'])->name('manage.profile');

Route::get('/manage-users', [App\Http\Controllers\UsersController::class, 'index'])->name('manage.users');
