<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Invitation extends Model
{
    protected $fillable = [
        'email',
        'description',
        'project_id',
    ];
    use HasFactory;
    public function users()
    {
        return $this->belongsToMany(User::class ,'invitation_user')->withPivot('status');
    }
    public function projects()
    {
        return $this->belongsToMany(Project::class);

    }
}
