<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\ProjectComment;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class ProjectCommentController extends Controller
{
    // Get All Comments
    public function index(){
        $users = ProjectComment::all();
        return response()->json([
            'data' => $users,
            'msg' => 'Successfully',
            'status'=> 200
        ]);
    }
    public function create(Request $request)
    {
        $validate = Validator::make($request->all(),[
            "comment" => "string|required",
            "user_id"=> "integer|max:10|required",
            "project_id"=> "integer|max:10|required",
        ]);
        if ($validate->fails()) {
            return response()->json([
                "error" => $validate->errors(),
                "status" => 400
            ]);
        }
        $userExists = User::where('id', $request->user_id)->exists();
        $projectExists = Project::where('id', $request->project_id)->exists();

        if (!$userExists || !$projectExists) {
            return response()->json([
                "error" => "User or Project not found",
                "status" => 404
            ]);
        }
         $comment = ProjectComment::create([
            "comment" => $request->comment,
            "user_id"=> $request->user_id,
            "project_id"=> $request->project_id,
         ]);
         return response()->json([
             'data' => $comment,
             'msg' => 'Create Comment Successfully',
             'status' => 200
         ]);

    }
}
