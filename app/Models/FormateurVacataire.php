<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormateurVacataire extends Model
{
    use HasFactory;
    protected $fillable = [
        'Annee_Experience',
        'type',
        'metier',
        'etat',
        'Dossier_Depose',
        'N_ordre',
        'Date_decision',
        '_Validation_RRH',
        'Apparition_Enote',
        'N_ordre_Bordereau',
        'Date_Bordereau',
        'Decison',
        'MasseHoraireAnnuelle',
        'MasseHoraireProposee',
        'Dossier_Depose_DR',
        'matriculeFm',
    ];
}
