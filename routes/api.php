<?php

use App\Http\Controllers\BusinessinforController;
use App\Http\Controllers\MilestonesController;
use App\Http\Controllers\NotificationsController;
use App\Http\Controllers\ProjectsController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\ServiceDetailsController;
use App\Http\Controllers\TasksController;
use App\Http\Controllers\TeamsController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\TutorialController;
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
    Route::post('update-user/{id}', [UserController::class, 'UpdateUser']);
    Route::post('filter-role/{id}', [UserController::class, 'FilterOfRole']);
    Route::post('user-search', [UserController::class, 'userSearch']);
    Route::post('user-profile', [UserController::class, 'ProfileUpdateUser']);
    Route::post('user-password-update', [UserController::class, 'passwordUpdate']);
    Route::get('all-users', [UserController::class, 'getAllUser']);
    Route::get('users', [UserController::class, 'allUser']);
    Route::get('edit-user/{id}', [UserController::class, 'EditUser']);
    Route::get('filter-role/{role}', [UserController::class, 'FilterByStatus']);
    Route::get('login-user', [UserController::class, 'loginUser']);
    Route::delete('delete-user/{id}', [UserController::class, 'deleteUser']);

    // project api
    Route::post('create-project', [ProjectsController::class, 'createProject']);
    Route::post('update-project/{id}', [ProjectsController::class, 'UpdateProject']);
    Route::post('update-percentage/{id}', [ProjectsController::class, 'updatePercentage']);
    Route::post('project-search', [ProjectsController::class, 'ProjectSearch']);
    Route::get('projects', [ProjectsController::class, 'allPorjects']);
    Route::get('edit-project/{id}', [ProjectsController::class, 'editPorjects']);
    Route::get('filter-percentage/{percentage}', [ProjectsController::class, 'filterPercentage']);
    Route::get('get-all-porjects', [ProjectsController::class, 'getAllPorjects']);
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
    Route::post('store-tasks', [TasksController::class, 'storeTasks']);
    Route::post('update-task/{id}', [TasksController::class, 'UpdateTasks']);
    Route::post('search-task', [TasksController::class, 'searchTasks']);
    Route::post('update-task-status/{id}', [TasksController::class, 'UpdateStatusTasks']);
    Route::get('show-tasks', [TasksController::class, 'ShowTasks']);
    Route::get('edit-tasks/{id}', [TasksController::class, 'editTasks']);
    Route::get('filttle-tasks/{task}', [TasksController::class, 'FilttleTasks']);
    Route::delete('delete-tasks/{id}', [TasksController::class, 'deleteTasks']);
    Route::post('send-task-email', [TasksController::class, 'sendTaskEmail']);

    // services
    Route::post('store-services', [ServiceController::class, 'storeService']);
    Route::post('update-services/{id}', [ServiceController::class, 'updateService']);
    Route::post('/generate-pdf', [ServiceController::class, 'generatePDF']);
    Route::post('service-search', [ServiceController::class, 'ServiceSearch']);
    Route::get('show-services', [ServiceController::class, 'showService']);
    Route::get('show-all-services', [ServiceController::class, 'AllshowService']);
    Route::get('alert-message-package', [ServiceController::class, 'alertMessageOnEndPackage']);
    Route::get('edit-services/{id}', [ServiceController::class, 'editService']);
    Route::get('filttle-services/{service}', [ServiceController::class, 'filttleByService']);
    Route::get('filttle-services-status/{status}', [ServiceController::class, 'filteByServiceStatus']);
    Route::delete('delete-services/{id}', [ServiceController::class, 'deleteService']);
    Route::post('send-service-email', [ServiceController::class, 'sendServiceEmail']);



    Route::post('store-services-details', [ServiceDetailsController::class, 'storeServiceDetails']);
    Route::post('update-services-details/{id}', [ServiceDetailsController::class, 'updateServiceDetails']);
    Route::get('services-details-data', [ServiceDetailsController::class, 'allServiceDetailsData']);
    Route::get('show-services-details', [ServiceDetailsController::class, 'showService']);
    Route::get('edit-services-details/{id}', [ServiceDetailsController::class, 'editServiceDetails']);
    Route::delete('delete-services-details/{id}', [ServiceDetailsController::class, 'deleteServiceDetails']);


    // Notifications
    Route::post('send-email', [NotificationsController::class, 'sendEmail']);
    Route::post('update-notification/{id}', [NotificationsController::class, 'UpdateNotfication']);
    Route::post('search-notification', [NotificationsController::class, 'NotificationSearch']);
    Route::get('show-notification', [NotificationsController::class, 'showNotification']);
    Route::get('edit-notification/{id}', [NotificationsController::class, 'editNotfication']);
    Route::delete('delete-notification/{id}', [NotificationsController::class, 'deleteNotfication']);


    // dashboard
    Route::get('show-count', [NotificationsController::class, 'ShowMilestonesCount']);


    // teams 
    Route::post('store-team', [TeamsController::class, 'storeTeamName']);
    Route::post('update-team/{id}', [TeamsController::class, 'updateTeamName']);
    Route::get('show-team', [TeamsController::class, 'showTeam']);
    Route::get('show-all-team', [TeamsController::class, 'showAllTeam']);
    Route::get('edit-team/{id}', [TeamsController::class, 'editTeam']);
    Route::delete('delete-team/{id}', [TeamsController::class, 'DeleteTeam']);
    
    // team member
    Route::post('store-team-members', [TeamsController::class, 'storeTeamMembrs']);
    Route::post('update-team-membrs/{id}', [TeamsController::class, 'updateTeamMembrs']);
    Route::get('show-team-membrs/{id}', [TeamsController::class, 'showTeamMembrs']);
    Route::get('edit-team-membrs/{id}', [TeamsController::class, 'editTeamMembrs']);
    Route::delete('delete-team-membrs/{id}', [TeamsController::class, 'deleteTeamMembrs']);
    
    // support stsyem
    Route::post('create-ticket', [TicketController::class, 'createTicket']);
    Route::get('get-ticket/{id}', [TicketController::class, 'getTicketId']);
    Route::get('show-ticket', [TicketController::class, 'showTicket']);
    Route::get('show-all-ticket', [TicketController::class, 'allTicket']);
    // reply
    Route::post('give-reply', [TicketController::class, 'gaveReply']);
    Route::get('show-ticket-reply/{id}', [TicketController::class, 'AllTicketRely']);
    Route::get('ticket-status', [TicketController::class, 'updateTicketStatusForAdmin']);
    
    // business information

    
    // show agent
    Route::get('show-affiliate', [UserController::class, 'showAgent']);
    // affiliate-client
    Route::post('affiliate-client-search', [BusinessinforController::class, 'BusinessInformationSearch']);
    Route::get('show-affiliate-client', [BusinessinforController::class, 'showAllBusinessInformation']);
    Route::get('edit-affiliate-client/{id}', [BusinessinforController::class, 'editBusinessInformation']);
    Route::delete('delete-affiliate-client/{id}', [BusinessinforController::class, 'DeleteBusinessInformation']);
    Route::post('affiliate-client-payment-status/{id}', [BusinessinforController::class, 'BusinessInformationPaymentStatus']);
    Route::get('affiliate-payment-range', [BusinessinforController::class, 'clientPaymentRange']);
    Route::get('business-information-client', [BusinessinforController::class, 'businessinformationforClient']);
    
    // user affiliate-client
    Route::get('show-user-affiliate-client', [BusinessinforController::class, 'UserBusinessInformation']);
    Route::get('show-business-payment-status', [BusinessinforController::class, 'UserBusinessPayemntstatus']);
    
    // tutorial
    Route::post('create-tutorial', [TutorialController::class, 'videoCreate']);
    Route::post('update-tutorial/{id}', [TutorialController::class, 'videoUpdate']);
    Route::get('show-tutorial', [TutorialController::class, 'index']);
    Route::get('edit-tutorial/{id}', [TutorialController::class, 'editvideoLink']);
    Route::delete('delete-tutorial/{id}', [TutorialController::class, 'DeletevideoLink']);
});
Route::post('login', [UserController::class, 'login']);
Route::post('create-user', [UserController::class, 'createUser']);
Route::post('create-business-information/{id}', [BusinessinforController::class, 'createBusinessInfor']);
