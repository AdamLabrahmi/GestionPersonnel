<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FormateurPermanent;
use App\Models\Formateur;
use App\Models\FormateurVacataire;
use App\Models\PersonnelAdministratif;

class VerificationMatriculeController extends Controller
{
    public function index()
    {
        return view('matricule');
    }

    public function search(Request $request)
{
    $matricule = $request->input('matricule');

    // Recherche dans la table formateurs
    $formateur = Formateur::where('matricule', $matricule)->first();

    if ($formateur) {
        // Vérifier le type de formateur en fonction du champ "type"
        if ($formateur->type === 'permanent') {
            return view('resultat', [
                'nom' => $formateur->nom,
                'prenom' => $formateur->prenom,
                'type' => 'Formateur Permanent'
            ]);
        } elseif ($formateur->type === 'vacataire') {
            return view('resultat', [
                'nom' => $formateur->nom,
                'prenom' => $formateur->prenom,
                'type' => 'Formateur Vacataire'
            ]);
        }
    }

    // Recherche dans la table personnel administratif
    $personnel = PersonnelAdministratif::where('matricule', $matricule)->first();

    if ($personnel) {
        return view('resultat', [
            'nom' => $personnel->nom,
            'prenom' => $personnel->prenom,
            'type' => 'Personnel Administratif'
        ]);
    }

    // Aucun utilisateur trouvé
    return view('resultat', ['error' => 'Aucun résultat trouvé pour le matricule spécifié.']);
}

}
