<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

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
        'matricule',
        'type',
        'status',
        'profil_id',
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
        'password' => 'hashed',
    ];

    /**
     * Get the profile that owns the user.
     */
    public function profile()
    {
        return $this->belongsTo(Profile::class, 'profil_id');
    }

    /**
     * Get the services associated with the user.
     */
    public function services()
    {
        return $this->belongsToMany(Service::class, 'user_service', 'user_id', 'service_id');
    }

    /**
     * Get the depenses for the user.
     */
    public function depenses()
    {
        return $this->hasMany(Depense::class, 'user_id');
    }

    /**
     * Get the recettes for the user.
     */
    public function recettes()
    {
        return $this->hasMany(Recette::class, 'user_id');
    }
}