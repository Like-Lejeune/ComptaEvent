<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    protected $fillable = [
        'nom','prix_mensuel','prix_annuel',
        'nb_evenements_max','nb_services_max',
        'export_pdf','multi_users'
    ];
}
