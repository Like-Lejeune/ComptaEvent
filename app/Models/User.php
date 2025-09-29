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
    ];

     public function evenements()
    {
        return $this->hasMany(Evenement::class, 'utilisateur_id');
    }

     /**
     * 🔗 Relation : un utilisateur appartient à un profil
     */
    public function profil()
    {
        return $this->belongsTo(Profile::class, 'profil_id');
    }

    public function abonnement() {
    return $this->hasOne(Abonnement::class, 'utilisateur_id')->where('statut','actif');
    }

    public function checkplan($feature) {
        $plan = $this->abonnement?->plan;
        if (!$plan) return false;

        return match($feature) {
            'export_pdf' => $plan->export_pdf,
            'multi_users' => $plan->multi_users,
            default => false,
        };
    }
}