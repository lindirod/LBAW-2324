<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\AdministratorController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\HomepageController;
use App\Http\Controllers\ContactsController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\Auth\PasswordResetController;


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

// Home
Route::controller(HomepageController::class)->group(function () {
    Route::get('/', 'index')->name("homepage");
    Route::get('/homepage','index');
    Route::get('/about_us','showAboutUsPage');
    Route::get('/faq', 'showFaqPage');
});

Route::get('/contact-us', [ContactsController::class, 'show']);
Route::post('/contact-us', [ContactsController::class, 'create']);

// Projects
Route::controller(ProjectController::class)->group(function () {
    Route::get('projects', 'list')->name('projects');   //Mais tarde mudar porque para ver os projetos do utilizador temos como /user/{id}/projects
    Route::get('favorites', 'listFavorites')->name('favorites');
    Route::get('archived', 'listArchived')->name('archived');
    Route::get('projects/{proj_id}', 'show')->name('projects.show');
    Route::post('projects/{proj_id}/addMember','addMember')->name('projects.members');
    Route::post('projects/{proj_id}/removeFavorite','removeFavorite');
    Route::post('projects/{proj_id}/addFavorite','addFavorite');
    Route::post('projects/{proj_id}/archive','archive');
    Route::post('projects/{proj_id}/unarchive','unarchive');
    Route::delete('projects/{proj_id}/members', 'removeMember')->name('projects.removeMember');
    Route::post('/projects/{proj_id}/change-coordinator', 'changeCoordinator')->name('projects.changeCoordinator');
    Route::post('/projects/{proj_id}/leaveProject', 'leaveProject')->name('projects.leaveProject');
    Route::get('/projects/{proj_id}/members', 'showMembers')->name('project.showMembers');
    Route::get('/projects/{proj_id}/tasks', 'showTasks')->name('project.showTasks');
});

//Projects API
Route::controller(ProjectController::class)->group(function () {
    Route::put('/api/projects', 'create')->name('projects.create');
    Route::delete('/api/projects/{proj_id}', 'delete');
    Route::put('/api/projects/{proj_id}/edit', 'edit');
});

// Tasks API
Route::controller(TaskController::class)->group(function () {
    Route::get('/tasks/{task_id}', 'show')->name('tasks.show');
    Route::get('/tasks', 'list')->name('tasks');
    Route::put('/api/projects/{proj_id}', 'create')->name('tasks.create');  //create tasks
    Route::delete('/api/tasks/{task_id}', 'delete');
    Route::put('/tasks/{task_id}/edit', 'edit');
    Route::post('/tasks/{id}/assign-member', 'assignMember')->name('tasks.assignMember');
    Route::delete('/tasks/{id}', 'delete')->name('tasks.delete');
    Route::put('/api/tasks/{task_id}/comment','comment')->name('tasks.comment');
});

Route::controller(UserController::class)->group(function () {
    Route::get('profile', 'showUserProfile')->name('profile');  // View user profile
    Route::get('editprofile', 'showEditProfile')->name('editprofile');  // Edit user profile form
    Route::post('editprofile','editProfile')->name('editProfile');  // Handle form submission for editing profile
    Route::get('/search', 'generalSearch')->name('search');
    Route::get('projects/profile/{user_id}', 'showMemberProfile')->name('memberProfile');
    Route::get('/acceptProjectInvite','acceptProjectInvite')->name('acceptEmailProjectInvite');
    Route::post('/delete','deleteUser')->name('deleteUser'); 
    Route::get('api/user/deleteUserPhoto', 'deletePhoto')->name('deleteUserPhoto');
});
// Notifications
Route::post('/notifications/project/{projectId}', [NotificationController::class, 'storeProjectNotification'])->name('storeNotifications');
Route::post('/notifications/mark-as-read', [NotificationController::class, 'markAsRead'])->name('markAsRead');
Route::get('/notifications', [NotificationController::class, 'getNotificationsView'])->name('notifications');


//AdminPerfil
Route::get('admin', [AdministratorController::class, 'showAdminDashboard'])->name('admin');  // show admin page
Route::get('admin/{user_id}', [AdministratorController::class, 'showUserEditPage'])->name('admin.editUser');  // show profile from admin page
Route::get('/admin/{user_id}/admedituser', [AdministratorController::class, 'showUserEditProf'])->name('adm.editprofile');  // Edit user profile form
Route::post('/admin/{user_id}/admedituser',[AdministratorController::class, 'updateUserProfile'])->name('adm.editProfile');  // Handle form submission for editing profile
Route::post('admin/{user_id}/deleteUser', [AdministratorController::class, 'deleteUserAccount'])->name('admin.deleteUser');  // delete user
Route::get('blocked', [AdministratorController::class, 'showBlocked'])->name('blocked');  // show blocked page 
Route::post('admin/{user_id}/blockedUser', [AdministratorController::class, 'blockUser'])->name('admin.blockUser');  // block user
Route::post('admin/{user_id}/unblockedUser', [AdministratorController::class, 'unblockUser'])->name('admin.unblockUser');  // unblock user
Route::get('createuser', [AdministratorController::class, 'showCreateUser'])->name('createuser');  // show create user page
Route::post('createuser', [AdministratorController::class, 'createUser'])->name('createUser');  // Handle form submission for creating profile



// Authentication
Route::controller(LoginController::class)->group(function () {
    Route::get('/login', 'showLoginForm')->name('login');
    Route::post('/login', 'authenticate');
    Route::get('/logout', 'logout')->name('logout');
});

Route::controller(RegisterController::class)->group(function () {
    Route::get('/register', 'showRegistrationForm')->name('register');
    Route::post('/register', 'register');
});


Route::controller(PasswordResetController::class)->group(function() {
    Route::get('/forgot-password', 'get')->middleware('guest')->name('password.request');
    Route::post('/forgot-password', 'sendResetLink')->middleware('guest')->name('password.email');
    Route::get('/reset-password/{token}', 'getResetForm')->middleware('guest')->name('password.reset');
    Route::post('/reset-password','resetPassword')->middleware('guest')->name('password.update');
});

