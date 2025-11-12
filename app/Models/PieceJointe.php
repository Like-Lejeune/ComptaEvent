<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PieceJointe extends Model
{
    use HasFactory;

    protected $table = 'piece_jointe';
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'piece_name',
        'depense_id',
    ];

    /**
     * Get the depense that owns the piece jointe.
     */
    public function depense()
    {
        return $this->belongsTo(Depense::class, 'depense_id', 'id_depense');
    }
}
