<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Formateur extends Model
{
    use HasFactory;
    protected $fillable = [
        'matricule',
        'password',
        'nom',
        'prenom',
        'numTel',
        'civilite',
        'Echelle',
        'Echelon',
        'Date_Recrutement',
        'Date_Depart_Retrait',
        'dateNaissance',
        'Adresse',
        'Grade',
        'Diplome',
        'situationFamiliale',
        'MasseHoaraireHeb',
        'massHorRealiseeAnnuel',
        'Filiere',
        'Categorie',
        'idEtablissement',
        'type', // Indique si le formateur est permanent ou vacataire
    ];
}
