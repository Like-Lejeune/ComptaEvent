<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Depense extends Model
{
    use HasFactory;

    protected $table = 'depense';
    protected $primaryKey = 'id_depense';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'service_id',
        'd_name',
        'user_id',
        'd_description',
        'date_operation',
        's_depense',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'date_operation' => 'datetime',
        's_depense' => 'integer',
    ];

    /**
     * Get the service that owns the depense.
     */
    public function service()
    {
        return $this->belongsTo(Service::class, 'service_id', 'id_service');
    }

    /**
     * Get the user that created the depense.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Get the pieces jointes for the depense.
     */
    public function piecesJointes()
    {
        return $this->hasMany(PieceJointe::class, 'depense_id', 'id_depense');
    }
}
