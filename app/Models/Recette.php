<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recette extends Model
{
    use HasFactory;

    protected $table = 'recette';
    protected $primaryKey = 'id_recette';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'service_id',
        'r_name',
        'user_id',
        'r_description',
        's_recette',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        's_recette' => 'integer',
    ];

    /**
     * Get the service that owns the recette.
     */
    public function service()
    {
        return $this->belongsTo(Service::class, 'service_id', 'id_service');
    }

    /**
     * Get the user that created the recette.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
