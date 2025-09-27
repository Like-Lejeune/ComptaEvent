<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'evenement_id',
        's_name',
        's_description',
        's_photo',
        's_budget',
    ];

     public function evenement()
    {
        return $this->belongsTo(Evenement::class, 'evenement_id');
    }

}
