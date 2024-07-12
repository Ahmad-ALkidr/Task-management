<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invitation_User extends Model
{
    protected $table = "invitation_user";
    protected $fillable = [
        'user_id',
        'invitation_id',
    ];
    use HasFactory;
}
