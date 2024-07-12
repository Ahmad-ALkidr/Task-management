<?php

use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TaskController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\InvitationController;
use App\Http\Controllers\ProjectCommentController;
use App\Http\Controllers\TaskCommentController;
use Illuminate\Support\Str;
use App\Models\User;



// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });


//--------------------- tasks ----------------------------
Route::get('tasks' , [TaskController::class,'index']);

Route::get('task/{id}' , [TaskController::class,'index2']);

Route::post('task_create' , [TaskController::class,'create']);

Route::post('task_delete/{id}' , [TaskController::class,'destroy']);

Route::post('task_update/{id}' , [TaskController::class,'update']);



//--------------------- User ----------------------------
Route::post('/user/register', [AuthController::class, 'register']);

Route::post('/login', [AuthController::class, 'login']);

Route::get('/users',[AuthController::class ,'index']);

Route::post('/user/{id}',[AuthController::class ,'get_user']);

Route::post('/user/delete/{id}',[AuthController::class ,'destroy']);

Route::post('/user/update/{id}',[AuthController::class ,'update']);



//--------------------- Project ----------------------------
Route::get('/projects',[ProjectController::class ,'index']);

Route::post('/project/{id}',[ProjectController::class ,'get_project']);

Route::post('create',[ProjectController::class ,'create']);

Route::post('/project/delete/{id}',[ProjectController::class ,'destroy']);

Route::post('/project/update/{id}',[ProjectController::class ,'update']);

Route::post('/projects/{project}/users/{user}', [ProjectController::class, 'addUser']);


//--------------------- Invitations ----------------------------
Route::post('/send', [InvitationController::class, 'add']);

Route::post('/get/{id}', [InvitationController::class, 'get_invitation']);

Route::get('/accept-invitation1/{invitationId}/{userId}', [InvitationController::class, 'acceptInvitation']);

Route::get('/accept-invitation/{invitation_id}/{email}', [InvitationController::class, 'acceptInvitation1'])->name('accept-invitation');


//--------------------- Comments ----------------------------
Route::get('/CommentsP',[ProjectCommentController::class ,'index']);

Route::get('/CommentsT',[TaskCommentController::class ,'index']);

Route::post('/addCommentP',[ProjectCommentController::class ,'create']);

Route::post('/addCommentT',[TaskCommentController::class ,'create']);





//api_token
Route::get('/genrate_api_token/{id}',function($id){
    $user=User::findOrFail($id);
    if(!$user->token_api){
        $user->token_api=Str::random(60);
        $user->save();
        return "TM created Token";
    }
    return $user->token_api;
});

