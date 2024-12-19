<?php

use App\Http\Controllers\MilestonesController;
use App\Http\Controllers\NotificationsController;
use App\Http\Controllers\ProjectsController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\TasksController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['middleware' => 'auth:api'], function () {
    Route::get('all-users', [UserController::class, 'getAllUser']);
    Route::get('users', [UserController::class, 'allUser']);
    Route::get('edit-user/{id}', [UserController::class, 'EditUser']);
    Route::get('filter-role/{role}', [UserController::class, 'FilterByStatus']);
    Route::get('login-user', [UserController::class, 'loginUser']);
    Route::post('create-user', [UserController::class, 'createUser']);
    Route::post('update-user/{id}', [UserController::class, 'UpdateUser']);
    Route::post('filter-role/{id}', [UserController::class, 'FilterOfRole']);
    Route::post('user-search', [UserController::class, 'userSearch']);
    Route::post('user-profile', [UserController::class, 'ProfileUpdateUser']);
    Route::post('user-password-update', [UserController::class, 'passwordUpdate']);
    Route::delete('delete-user/{id}', [UserController::class, 'deleteUser']);

    // project api
    Route::post('create-project', [ProjectsController::class, 'createProject']);
    Route::post('update-project/{id}', [ProjectsController::class, 'UpdateProject']);
    Route::post('update-percentage/{id}', [ProjectsController::class, 'updatePercentage']);
    Route::post('project-search', [ProjectsController::class, 'ProjectSearch']);
    Route::get('projects', [ProjectsController::class, 'allPorjects']);
    Route::get('edit-project/{id}', [ProjectsController::class, 'editPorjects']);
    Route::get('filter-percentage/{percentage}', [ProjectsController::class, 'filterPercentage']);
    Route::delete('delete-project/{id}', [ProjectsController::class, 'deleteProject']);


    // milestores
    Route::post('create-milestore', [MilestonesController::class, 'createMilestones']);
    Route::post('update-milestore/{id}', [MilestonesController::class, 'updateMilestones']);
    Route::post('update-milestore-status/{id}', [MilestonesController::class, 'updateStatusMilestone']);
    Route::post('milestones-search', [MilestonesController::class, 'MilestonesSearch']);
    Route::get('milestore', [MilestonesController::class, 'allMilestones']);
    Route::get('edit-milestore/{id}', [MilestonesController::class, 'editMileStone']);
    Route::get('milestore-status/{status}', [MilestonesController::class, 'MilestonesStatus']);
    Route::get('all-milestone', [MilestonesController::class, 'getAllMilestones']);
    Route::delete('delete-milestore/{id}', [MilestonesController::class, 'deleteMileStone']);


    // tasks
    Route::post('store-tasks', [TasksController::class,'storeTasks']);
    Route::post('update-task/{id}', [TasksController::class,'UpdateTasks']);
    Route::post('search-task', [TasksController::class,'searchTasks']);
    Route::post('update-task-status/{id}', [TasksController::class,'UpdateStatusTasks']);
    Route::get('show-tasks', [TasksController::class,'ShowTasks']);
    Route::get('edit-tasks/{id}', [TasksController::class,'editTasks']);
    Route::get('filttle-tasks/{task}', [TasksController::class,'FilttleTasks']);
    Route::delete('delete-tasks/{id}', [TasksController::class,'deleteTasks']);

    // services
    Route::post('store-services', [ServiceController::class,'storeService']);
    Route::post('update-services/{id}', [ServiceController::class,'updateService']);
    Route::post('/generate-pdf', [ServiceController::class, 'generatePDF']);
    Route::post('service-search', [ServiceController::class, 'ServiceSearch']);
    Route::get('show-services', [ServiceController::class,'showService']);
    Route::get('alert-message-package', [ServiceController::class,'alertMessageOnEndPackage']);
    Route::get('edit-services/{id}', [ServiceController::class,'editService']);
    Route::get('filttle-services/{service}', [ServiceController::class,'filttleByService']);
    Route::get('filttle-services-status/{status}', [ServiceController::class,'filteByServiceStatus']);
    Route::delete('delete-services/{id}', [ServiceController::class,'deleteService']);

    // Notifications
    Route::post('send-email', [NotificationsController::class, 'sendEmail']);
    Route::post('update-notification/{id}', [NotificationsController::class, 'UpdateNotfication']);
    Route::post('search-notification', [NotificationsController::class, 'NotificationSearch']);
    Route::get('show-notification', [NotificationsController::class, 'showNotification']);
    Route::get('edit-notification/{id}', [NotificationsController::class, 'editNotfication']);
    Route::delete('delete-notification/{id}', [NotificationsController::class, 'deleteNotfication']);


    // dashboard
    Route::get('show-count', [NotificationsController::class, 'ShowMilestonesCount']);

});
Route::post('login', [UserController::class, 'login']);
