<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function task_comment(): HasMany
    {
        return $this->hasMany(TaskComment::class);
    }
    public function task(): HasMany
    {
        return $this->hasMany(Task::class);
    }
    public function project_comment(): HasMany
    {
        return $this->hasMany(ProjectComment::class);
    }

    public function projects()
    {
        return $this->belongsToMany(Project::class);
    }
    public function invitations()
    {
        return $this->belongsToMany(Invitation::class , 'invitation_user')->withPivot('status');
    }
}
