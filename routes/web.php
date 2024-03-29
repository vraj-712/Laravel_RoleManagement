<?php

use App\Models\Post;
use App\Models\User;
use App\Mail\MailerForGmail;
use Jorenvh\Share\ShareFacade;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use Laravel\Socialite\Facades\Socialite;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SocialiteController;
use App\Http\Controllers\FileUploadController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ActionPermissionController;
use App\Http\Controllers\PermissionCategoryController;
use App\Http\Controllers\SocialShareButtonsController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/', function () {
    
    return view('welcome')->with(['posts'=>Post::all()]);
});

Route::get('/auth/google/redirect',[SocialiteController::class,'redirectForProvider']);
 
Route::get('/auth/google/callback', [SocialiteController::class,'callbackForProvider']);

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::group(['middleware' =>['auth', 'role:Admin|Super_admin'], 'prefix' => 'backpanel'],function(){
    Route::get('/', [UserController::class, 'index'])->name('backpanel.index');
    Route::get('/role/{role}/assignPermission',[RoleController::class,'assignPermissionView'])->name('role.assign.permission');
    Route::post('/role/{role}/assignPermission',[RoleController::class,'assignPermission'])->name('role.store.permission');
    Route::get('/category',[PermissionCategoryController::class,'index'])->name('category.index');
    Route::get('/category/create',[PermissionCategoryController::class,'create'])->name('category.create');
    Route::post('/category/create',[PermissionCategoryController::class,'store'])->name('category.store');
    Route::post('/action/create',[ActionPermissionController::class, 'store'])->name('action.store');
    Route::resource('/role',RoleController::class);
    Route::resource('/permission',PermissionController::class);
    Route::resource('/user',UserController::class);
});

Route::group(['middleware' =>['auth', 'role:Admin|Super_admin|Editor|User'],'prefix' => 'frontpanel'],function(){
    
    Route::get('/', [PostController::class, 'index'])->name('frontpanel.index');
    Route::post('/comment-approve/{comment}',[CommentController::class, 'approveComment'])->name('approve-comment');
    Route::resource('/post',PostController::class);
    Route::resource('/comment',CommentController::class);
});
Route::get('file-upload', [FileUploadController::class, 'index'])->name('files.index');
Route::post('file-upload/upload-large-files', [FileUploadController::class, 'uploadLargeFiles'])->name('files.upload.large');

require __DIR__.'/auth.php';
