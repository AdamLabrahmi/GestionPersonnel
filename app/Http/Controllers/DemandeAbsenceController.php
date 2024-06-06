<?php

namespace App\Http\Controllers;

use App\Models\DemandeAbsence;
use Illuminate\Http\Request;
use App\Models\Formateur;
use App\Models\PersonnelAdministratif;
use Carbon\Carbon;

class DemandeAbsenceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    // public function index()
    // {
    //     $demandesAbsence = DemandeAbsence::with(['formateur', 'personnelAdministratif'])->get();
    //     // $groupedDemandes = $demandesAbsence->groupBy('date_demande')->sortKeysDesc();
    //     return view('Alldemande', compact('demandesAbsence'));
    // }


    public function index()
{
    $today = \Carbon\Carbon::today();
    $yesterday = \Carbon\Carbon::yesterday();

    // Récupérer les demandes d'absence d'aujourd'hui et d'hier
    $demandesToday = DemandeAbsence::with(['formateur', 'personnelAdministratif'])
                                    ->whereDate('date_demande', $today)
                                    ->get();
    $demandesYesterday = DemandeAbsence::with(['formateur', 'personnelAdministratif'])
                                        ->whereDate('date_demande', $yesterday)
                                        ->get();

    return view('Alldemande', compact('demandesToday', 'demandesYesterday'));
}



    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('demande');
    }

    /**
     * Store a newly created resource in storage.
     */
    // public function store(Request $request)
    // {
    //     $request->validate([
    //         'nom' => 'required|string|max:255',
    //         'prenom' => 'required|string|max:255',
    //         'motif' => 'required|string|max:255',
    //         'date_debut' => 'required|date',
    //         'date_fin' => 'required|date|after_or_equal:date_debut',
    //         'pdf_files' => 'nullable|file|mimes:pdf|max:2048',
    //     ]);

    //     // Recherche du formateur ou personnel administratif par nom et prénom
    //     $formateur = Formateur::where('nom', $request->input('nom'))->where('prenom', $request->input('prenom'))->first();
    //     $personnelAdministratif = PersonnelAdministratif::where('nom', $request->input('nom'))->where('prenom', $request->input('prenom'))->first();

    //     if (!$formateur && !$personnelAdministratif) {
    //         return redirect()->back()->withErrors(['error' => 'Aucun Employees trouvé avec ce nom et prénom.']);
    //     }

    //     $demandeAbsence = new DemandeAbsence();
    //     $demandeAbsence->Motif = $request->input('motif');
    //     $demandeAbsence->DateDebut = $request->input('date_debut');
    //     $demandeAbsence->DateFin = $request->input('date_fin');
    //     $demandeAbsence->date_demande = Carbon::now();

    //     if ($formateur) {
    //         $demandeAbsence->matriculeFm = $formateur->matricule;
    //     } elseif ($personnelAdministratif) {
    //         $demandeAbsence->matriculePA = $personnelAdministratif->matricule;
    //     }

    //     if ($request->hasFile('pdf_files')) {
    //         $file = $request->file('pdf_files');
    //         $path = $file->store('pdf_files', 'public');
    //         $demandeAbsence->pdf_files = $path;
    //     }

    //     $demandeAbsence->save();

    //     return redirect()->back()->with('success', 'Demande d\'absence soumise avec succès.');
    // }








    public function store(Request $request)
{
    $request->validate([
        'nom' => 'required|string|max:255',
        'prenom' => 'required|string|max:255',
        'motif' => 'required|string|max:255',
        'date_debut' => 'required|date',
        'date_fin' => [
            'required',
            'date',
            function ($attribute, $value, $fail) use ($request) {
                // Vérifie si la date de fin est supérieure à la date de début
                if (strtotime($value) <= strtotime($request->input('date_debut'))) {
                    $fail('La date fin doit être supérieure à la date début.');
                }
            },
        ],
        'pdf_files' => 'nullable|file|mimes:pdf|max:2048',
    ]);

    // Recherche du formateur ou du personnel administratif par nom et prénom
    $formateur = Formateur::where('nom', $request->input('nom'))->where('prenom', $request->input('prenom'))->first();
    $personnelAdministratif = PersonnelAdministratif::where('nom', $request->input('nom'))->where('prenom', $request->input('prenom'))->first();

    if (!$formateur && !$personnelAdministratif) {
        return redirect()->back()->withErrors(['error' => 'Aucun employé trouvé avec ce nom et prénom.']);
    }

    $demandeAbsence = new DemandeAbsence();
    $demandeAbsence->Motif = $request->input('motif');
    $demandeAbsence->DateDebut = $request->input('date_debut');
    $demandeAbsence->DateFin = $request->input('date_fin');
    $demandeAbsence->date_demande = Carbon::now();

    if ($formateur) {
        $demandeAbsence->matriculeFm = $formateur->matricule;
    } elseif ($personnelAdministratif) {
        $demandeAbsence->matriculePA = $personnelAdministratif->matricule;
    }

    if ($request->hasFile('pdf_files')) {
        $file = $request->file('pdf_files');
        $path = $file->store('pdf_files', 'public');
        $demandeAbsence->pdf_files = $path;
    }

    $demandeAbsence->save();

    return redirect()->back()->with('success', 'Demande d\'absence soumise avec succès.');
}


    /**
     * Display the specified resource.
     */


     public function updateStatus(Request $request, $id)
    {
        $request->validate(['status' => 'required|in:en attente,informer']);

        $demandeAbsence = DemandeAbsence::findOrFail($id);
        $demandeAbsence->status = $request->input('status');
        $demandeAbsence->save();

        return redirect()->back()->with('success', 'Statut mis à jour avec succès..');
    }

    public function updateAuthorization(Request $request, $id)
    {
        $request->validate(['autorisation' => 'required|boolean']);

        $demandeAbsence = DemandeAbsence::findOrFail($id);
        $demandeAbsence->autorisation = $request->input('autorisation');
        $demandeAbsence->save();

        return redirect()->back()->with('success', 'Autorisation mise à jour avec succès.');
    }




    public function show(DemandeAbsence $demandeAbsence)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(DemandeAbsence $demandeAbsence)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, DemandeAbsence $demandeAbsence)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
{
    // Trouver la demande d'absence par son ID
    $demandeAbsence = DemandeAbsence::findOrFail($id);

    // Supprimer la demande d'absence
    $demandeAbsence->delete();

    // Rediriger avec un message de succès
    return redirect()->back()->with('success', 'Demande d\'absence supprimée avec succès.');
}


public function listAbsences(Request $request)
{
    // Récupérer les autorisations par défaut
    $autorisationAbsences = DemandeAbsence::where('autorisation', true)->get();

    // Récupérer les filières
    $filieres = Formateur::distinct()->pluck('filiere')->toArray();

    // Récupérer les rôles
    $roles = PersonnelAdministratif::distinct()->pluck('role')->toArray();

    // Si des critères de filtrage sont sélectionnés, filtrer les absences
    if ($request->filled(['type_formateur', 'date_debut', 'filiere_formateur', 'role_personnel'])) {
        $absences = DemandeAbsence::where('autorisation', true)
            ->when($request->filled('type_formateur'), function ($query) use ($request) {
                return $query->where('type', $request->type_formateur);
            })
            ->when($request->filled('date_debut'), function ($query) use ($request) {
                return $query->whereDate('date_debut', $request->date_debut);
            })
            ->when($request->filled('filiere_formateur'), function ($query) use ($request) {
                return $query->where('filiere', $request->filiere_formateur);
            })
            ->when($request->filled('role_personnel'), function ($query) use ($request) {
                return $query->where('role', $request->role_personnel);
            })
            ->get();
    } else {
        // Si aucun critère de filtrage n'est sélectionné, afficher uniquement les autorisations par défaut
        $absences = $autorisationAbsences;
    }

    return view('TousDemande', compact('absences', 'filieres', 'roles'));
}




}
