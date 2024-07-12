<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\TaskComment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TaskCommentController extends Controller
{
    // Get All Comments
    public function index(){
        $users = TaskComment::all();
        return response()->json([
            'data' => $users,
            'msg' => 'Successfully',
            'status'=> 200
        ]);
    }

    public function create(Request $request)
    {
        $validate = Validator::make($request->all(),[
            "comment" => "required",
            "user_id"=> "integer|max:10|required",
            "task_id"=> "integer|max:10|required",
        ]);
        if ($validate->fails()) {
            return response()->json([
                "error" => $validate->errors(),
                "status" => 400
            ]);
        }
        $userExists = User::where('id', $request->user_id)->exists();
        $TaskExists = Task::where('id', $request->task_id)->exists();

        if (!$userExists || !$TaskExists) {
            return response()->json([
                "error" => "User or task not found",
                "status" => 404
            ]);
        }
         $comment = TaskComment::create([
            "comment" => $request->comment,
            "user_id"=> $request->user_id,
            "task_id"=> $request->task_id,
         ]);
         return response()->json([
             'data' => $comment,
             'msg' => 'Create Comment Successfully',
             'status' => 200
         ]);

    }
}
