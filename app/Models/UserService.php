<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserService extends Model
{
    use HasFactory;

    /**
     * Nom de la table
     *
     * @var string
     */
    protected $table = 'user_service';

    /**
     * Clé primaire personnalisée
     *
     * @var string
     */
    protected $primaryKey = 'id_user_service';

    /**
     * Les champs remplissables
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'service_id',
    ];

    /**
     * 🔗 Relation : un UserService appartient à un utilisateur
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * 🔗 Relation : un UserService appartient à un service
     */
    public function service()
    {
        return $this->belongsTo(Service::class, 'service_id');
    }
}
