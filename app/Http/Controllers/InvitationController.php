<?php

namespace App\Http\Controllers;

use App\Mail\invitationMailable;
use App\Models\Invitation;
use Illuminate\Support\Str;
use App\Models\Invitation_User;
use App\Models\Project;
use Illuminate\Support\Facades\Mail;
use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
class InvitationController extends Controller
{
    // Get All Invitations
    public function get_invitation($id)
    {
        $invitation = Invitation::find($id);
        return response()->json([
            "data" => $invitation,
            "status" => 200
        ]);
    }

    // Add Invitation
    public function add(Request $request)
    {
        $validate = Validator::make($request->all(),[
            // المستخدم يدخل في مشروع واحد
            "email"=> "required|email|unique:invitations",
            "description" => "string|min:8|required:invitations",
            "project_id"=> "integer|max:10|required",
        ]);
        if ($validate->fails()) {
            return response()->json([
                "error" => $validate->errors(),
                "status" => 400
            ]);
        }
        $token = $request->header('Authorization');
        if ($token) {
            $user = User::where('token_api', $token)->first();
            $user_email = User::where('email', $request->email)->exists();
            $project = Project::find($request->project_id);
            if ($user) {
                if (Gate::forUser($user)->allows('create-project')) {
                    if($user_email)
                    {
                        if($project)
                        {
                        // add to table
                        $invitation = Invitation::create([
                            "email" => $request->email,
                            "description" => $request->description,
                            "project_id" => $request->project_id,
                        ]);

                        $project->invitations()->save($invitation);
                        $invitation->users()->attach($user->id,);

                        // Sending to a real email
                        Mail::to($request->email)->send(new invitationMailable($invitation->id , $invitation->email , $project->name));
                        return response()->json([
                            'data' => $invitation,
                            'msg' => 'create invitation Successfully and Send completed to email',
                            'status' => 200
                        ]);
                        }
                        else{
                            return response()->json([
                                'error' => 'project not found',
                                'status' => 403
                            ]);
                        }

                    }
                    else{
                        return response()->json([
                            'error' => 'email not found',
                            'status' => 403
                        ]);
                    }
                } else {
                    return response()->json([
                        'error' => 'Unauthorized',
                        'status' => 403
                    ]);
                }
            } else {
                return response()->json([
                    'error' => 'Unauthorized',
                    'status' => 403
                ]);
            }
        } else {
            return response()->json([
                'error' => 'Token not provided',
                'status' => 401
            ]);
        }
    }

    // Add the user to the project and change the invitation status to Accepted
    public function acceptInvitation($invitationId, $userId)
    {
    // تحقق من صحة الدعوة
    $invitation = Invitation::findOrFail($invitationId);

    // تحديث حالة الدعوة إلى "مقبول"
    $invitationStatus = Invitation_User::where('invitation_id', $invitationId)
                                        ->where('user_id', $userId)
                                        ->firstOrFail();
    $invitationStatus->status = 'accepted';
    $invitationStatus->save();

    // إضافة المستخدم إلى المشروع
    $user = User::find($userId);
    $project = Project::find($invitation->project_id);

    $project->users()->attach($user);
    }

    // When the user clicks on the message he received on his email that he agrees, this function is called
    public function acceptInvitation1($invitationId , $email)
    {
        $user =  User::where('email', $email)->first();
        $this->acceptInvitation($invitationId, $user->id);
        return response()->json([
            'message' => "Hello $user->name You have been successfully added to the project ",
            'status' => 200
        ]);
    }
}
