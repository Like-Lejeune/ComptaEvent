<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Depense extends Model
{
    use HasFactory;

    protected $table = 'depenses'; // ⚠️ convention Laravel = pluriel

    protected $fillable = [
        'service_id',
        'evenement_id',
        'd_name',
        'user_id',
        'd_description',
        'date_operation',
        'annee',
    ];

    protected $casts = [
        'date_operation' => 'date', // permet $depense->date_operation->format('d/m/Y')
        'annee' => 'integer',
    ];

    /**
     * Relations
     */
    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function evenement()
    {
        return $this->belongsTo(Evenement::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
