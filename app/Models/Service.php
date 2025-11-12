<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_service';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        's_name',
        's_description',
        's_photo',
        's_budget',
        's_solde',
    ];

    /**
     * Get the users associated with the service.
     */
    public function users()
    {
        return $this->belongsToMany(User::class, 'user_service', 'service_id', 'user_id');
    }

    /**
     * Get the depenses for the service.
     */
    public function depenses()
    {
        return $this->hasMany(Depense::class, 'service_id', 'id_service');
    }

    /**
     * Get the recettes for the service.
     */
    public function recettes()
    {
        return $this->hasMany(Recette::class, 'service_id', 'id_service');
    }
}
