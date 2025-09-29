<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;

    // Les champs autorisés pour les opérations de création et de mise à jour
    protected $fillable = [
        'name',
        'description',
        'list_action',
    ];

    // Si le champ JSON doit être manipulé comme tableau
    protected $casts = [
        'list_action' => 'array',
    ];

     /**
     * 🔗 Relation : un profil peut avoir plusieurs utilisateurs
     */
    public function users()
    {
        return $this->hasMany(User::class, 'profil_id');
    }
}
