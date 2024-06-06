<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DemandeAbsence extends Model
{
    use HasFactory;

    protected $fillable = [
        'Motif',
        'DateDebut',
        'DateFin',
        'pdf_files',
        'date_demande',
        'autorisation',
        'matriculeFm',
        'matriculePA',
        'status'
    ];

    protected $dates = ['date_demande', 'DateDebut', 'DateFin'];


    public function formateur()
{
    return $this->belongsTo(Formateur::class, 'matriculeFm', 'matricule');
}

public function personnelAdministratif()
{
    return $this->belongsTo(PersonnelAdministratif::class, 'matriculePA', 'matricule');
}
}
