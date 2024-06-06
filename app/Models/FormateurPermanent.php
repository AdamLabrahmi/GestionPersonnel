<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormateurPermanent extends Model
{
    use HasFactory;
    protected $fillable = [
        'Date_Recrutement',
        'Date_Depart_Retrait',
        'Echelle',
        'Echelon',
        'Grade',
        'matriculeFm',
    ];
}
