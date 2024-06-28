<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DemandeConges extends Model
{
    use HasFactory;

    protected $fillable = [
        'statut',
        'dateDebutConge',
        'dateFinConge',
        'durreeConge',
        'idFMPR',
        'matriculePA',
        'idTypeConge'
    ];

    public function formateur()
{
    return $this->belongsTo(Formateur::class, 'idFMPR', 'matricule');
}

    public function personnelAdministratif()
    {
        return $this->belongsTo(PersonnelAdministratif::class, 'matriculePA', 'matricule');
    }

    public function typeConge()
    {
        return $this->belongsTo(TypeConge::class, 'idTypeConge');
    }
}
