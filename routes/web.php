<?php
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PropertyTypeController;
use App\Http\Controllers\PropertyController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\SectionController;
use App\Http\Controllers\PropertyImageController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\RatingController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\RegionController;

use App\Http\Controllers\LessonController;

use App\Http\Controllers\ContentController;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\AnswerController;

Route::resource('lessons', LessonController::class);

Route::resource('contents', ContentController::class);
Route::resource('quizzes', QuizController::class);
Route::resource('questions', QuestionController::class);
Route::resource('answers', AnswerController::class);
Route::resource('sections', SectionController::class)->middleware('auth');
Route::resource('units', UnitController::class)->middleware('auth');
Route::get('/', function () {
    return view('auth.login'); // افتراضًا أن صفحة تسجيل الدخول موجودة في resources/views/auth/login.blade.php
});

//Route::get('/', [PropertyController::class, 'index_web'])->name('indexproperty');
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
require __DIR__.'/auth.php';
 // روابط التحكم بالمستخدمين 
Route::get('/users', [UserController::class, 'index'])->name('users.index'); // عرض قائمة المستخدمين
Route::get('/users/create', [UserController::class, 'create'])->name('users.create'); // إضافة مستخدم جديد
Route::post('/users', [UserController::class, 'store'])->name('users.store'); // تخزين مستخدم جديد
Route::get('/users/{id}', [UserController::class, 'show'])->name('users.show'); // عرض تفاصيل مستخدم معين
Route::get('/users/{id}/edit', [UserController::class, 'edit'])->name('users.edit'); // تعديل مستخدم
Route::put('/users/{id}', [UserController::class, 'update'])->name('users.update'); // تحديث بيانات المستخدم
Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('users.destroy'); // حذف مستخدم
//Route::match(['get', 'post'], '/users/{user}/assign-role', [UserController::class, 'assignRole'])->name('user.assign.role');
Route::post('/users/assign-role', [UserController::class, 'assignRole'])->name('user.assign.role');
//Route::post('/users/{user}/assign-role', [UserController::class, 'assignRole'])->name('user.assign.role');
Route::delete('/users/{user}/remove-role/{role}', [UserController::class, 'removeRole'])->name('user.remove.role');
Route::middleware(['auth'])->group(function () {
    Route::resource('roles', RoleController::class);
    Route::resource('permissions', PermissionController::class);
    
});
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'dashboard'])->name('dashboard');
});
Route::get('admin-page',function(){
    return view('admin.index');
});
Route::get('template',function(){
    return view('website.index');
});
Route::resource('properties', PropertyController::class);
Route::resource('properties.property-images', PropertyImageController::class);
Route::resource('locations', LocationController::class);
Route::resource('regions', RegionController::class);
Route::resource('property-types', PropertyTypeController::class);
/**************************************************   website   */
Route::post('/properties/filterweb', [PropertyController::class, 'filterweb'])->name('properties.filterweb');
Route::get('indexproperty', [PropertyController::class, 'index_web'])->name('indexproperty2');
Route::get('about-web',function(){
    return view('website.pages.about');
})->name('about');
Route::get('property-agent-web',function(){
    return view('website.pages.property-agent');
});
Route::get('property-list-web',[PropertyController::class, 'propertyList']);
Route::get('/property-web/{id}', [PropertyController::class, 'show_web'])->name('propertyweb.details');
Route::get('property-type-web',[PropertyController::class, 'propertyTypeList']);
Route::get('property-type-web-single/{propertyTypeId}', [PropertyController::class, 'propertyTypeSingle'])
    ->name('propertytypeweb.single');

//Route::get('property-type-web-single',[PropertyController::class, 'propertyTypeSingle'])->name('propertytypeweb.single');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/advance-search', [SearchController::class, 'advanceSearch'])->name('search');
});
Route::post('/properties/{property}/rate', [RatingController::class, 'store'])->name('properties.rate');
Route::resource('ratings', RatingController::class);
// Route لعرض التعليقات الخاصة بالعقار
Route::get('properties/{propertyId}/comments', [CommentController::class, 'index'])->name('comments.index');
Route::post('properties/{propertyId}/comments', [CommentController::class, 'store'])->name('comments.store');
Route::get('comments/{comment}/edit', [CommentController::class, 'edit'])->name('comments.edit');
Route::delete('comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');
Route::put('comments/{comment}', [CommentController::class, 'update'])->name('comments.update.put');
Route::patch('comments/{comment}', [CommentController::class, 'update'])->name('comments.update.patch');



