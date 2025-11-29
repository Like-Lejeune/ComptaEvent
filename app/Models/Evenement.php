<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Evenement extends Model
{
    use HasFactory;

    protected $table = 'evenements';

    protected $fillable = [
        'utilisateur_id',
        'nom',
        'description',
        'date_debut',
        'date_fin',
        'budget_total',
        'annee',
    ];

    public $timestamps = false; // si tu n’as pas created_at et updated_at

    /**
     * 🔗 Relation : un événement appartient à un utilisateur
     */
    public function utilisateur()
    {
        return $this->belongsTo(User::class, 'utilisateur_id');
    }

    /**
     * 🔗 Relation : un événement peut avoir plusieurs services
     */
    public function services()
    {
        return $this->hasMany(Service::class, 'evenement_id');
    }
    public function depenses()
    {
        return $this->hasMany(Depense::class, 'evenement_id');
    }
}
