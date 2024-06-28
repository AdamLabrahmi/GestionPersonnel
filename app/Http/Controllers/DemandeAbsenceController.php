<?php

namespace App\Http\Controllers;

use App\Models\DemandeAbsence;
use Illuminate\Http\Request;
use App\Models\Formateur;
use App\Models\PersonnelAdministratif;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

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


    // ca marche bien
    public function index()
{
    $today = \Carbon\Carbon::today();
    $yesterday = \Carbon\Carbon::yesterday();

    // Récupérer les demandes d'absence d'aujourd'hui et d'hier
    $demandesToday = DemandeAbsence::with(['formateur', 'personnelAdministratif'])->whereDate('date_demande', $today)->get();
    $demandesYesterday = DemandeAbsence::with(['formateur', 'personnelAdministratif'])->whereDate('date_demande', $yesterday)->get();

    return view('Alldemande', compact('demandesToday', 'demandesYesterday'));
}




// public function index(Request $request)
// {
//     $query = DemandeAbsence::query();

//     if ($request->filled('type_demande')) {
//         $typeDemande = $request->input('type_demande');

//         if ($typeDemande == 'formateur') {
//             $query->whereHas('formateur', function($q) use ($request) {
//                 if ($request->filled('search')) {
//                     $q->where('nom', 'like', '%' . $request->input('search') . '%')
//                       ->orWhere('prenom', 'like', '%' . $request->input('search') . '%');
//                 }
//             });
//         } elseif ($typeDemande == 'personnel') {
//             $query->whereHas('personnelAdministratif', function($q) use ($request) {
//                 if ($request->filled('search')) {
//                     $q->where('nom', 'like', '%' . $request->input('search') . '%')
//                       ->orWhere('prenom', 'like', '%' . $request->input('search') . '%');
//                 }
//                 if ($request->filled('role_personnel')) {
//                     $q->where('role', $request->input('role_personnel'));
//                 }
//             });
//         }
//     }

//     if ($request->filled('date_debut')) {
//         $query->where('date_debut', '>=', $request->input('date_debut'));
//     }

//     if ($request->filled('date_fin')) {
//         $query->where('date_fin', '<=', $request->input('date_fin'));
//     }

//     $absences = $query->get();
//     $roles = ['Rôle1', 'Rôle2']; // Remplacez par vos rôles réels

//     return view('absences.index', compact('absences', 'roles'));
// }


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







//fonctionne
//     public function store(Request $request)
// {
//     $request->validate([
//         'nom' => 'required|string|max:255',
//         'prenom' => 'required|string|max:255',
//         'motif' => 'required|string|max:255',
//         'date_debut' => 'required|date',
//         'date_fin' => [
//             'required',
//             'date',
//             function ($attribute, $value, $fail) use ($request) {
//                 // Vérifie si la date de fin est supérieure à la date de début
//                 if (strtotime($value) <= strtotime($request->input('date_debut'))) {
//                     $fail('La date fin doit être supérieure à la date début.');
//                 }
//             },
//         ],
//         'pdf_files' => 'nullable|file|mimes:pdf|max:2048',
//     ]);

//     // Recherche du formateur ou du personnel administratif par nom et prénom
//     $formateur = Formateur::where('nom', $request->input('nom'))->where('prenom', $request->input('prenom'))->first();
//     $personnelAdministratif = PersonnelAdministratif::where('nom', $request->input('nom'))->where('prenom', $request->input('prenom'))->first();

//     if (!$formateur && !$personnelAdministratif) {
//         return redirect()->back()->withErrors(['error' => 'Aucun employé trouvé avec ce nom et prénom.']);
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
        'preciser_motif' => 'nullable|string|max:255',
        'date_debut' => 'required|date',
        'date_fin' => [
            'required',
            'date',
            function ($attribute, $value, $fail) use ($request) {
                if (strtotime($value) <= strtotime($request->input('date_debut'))) {
                    $fail('La date fin doit être supérieure à la date début.');
                }
            },
        ],
        'pdf_files' => 'nullable|file|mimes:pdf|max:2048',
        'certificat_medical' => 'nullable|file|mimes:pdf|max:2048',
    ]);

    $formateur = Formateur::where('nom', $request->input('nom'))->where('prenom', $request->input('prenom'))->first();
    $personnelAdministratif = PersonnelAdministratif::where('nom', $request->input('nom'))->where('prenom', $request->input('prenom'))->first();

    if (!$formateur && !$personnelAdministratif) {
        return redirect()->back()->withErrors(['error' => 'Aucun employé trouvé avec ce nom et prénom.']);
    }

    $demandeAbsence = new DemandeAbsence();
    $demandeAbsence->Motif = $request->input('motif');
    if ($request->input('motif') == 'autre') {
        $demandeAbsence->Motif .= ': ' . $request->input('preciser_motif');
    }
    $demandeAbsence->DateDebut = $request->input('date_debut');
    $demandeAbsence->DateFin = $request->input('date_fin');
    $demandeAbsence->date_demande = now();

    if ($formateur) {
        $demandeAbsence->matriculeFm = $formateur->matricule;
    } elseif ($personnelAdministratif) {
        $demandeAbsence->matriculePA = $personnelAdministratif->matricule;
    }

    if ($request->hasFile('pdf_files')) {
        $file = $request->file('pdf_files');
        $path = $file->store('pdf_files', 'public');
        $demandeAbsence->pdf_files = $path;
    } elseif ($request->hasFile('certificat_medical')) {
        $file = $request->file('certificat_medical');
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
    public function edit($id)
{
    $demandeAbsence = DemandeAbsence::findOrFail($id);
    return view('edit', compact('demandeAbsence'));
}

// fonctionne
    // public function update(Request $request, $id)
    // {
    //     // Validation et mise à jour de la demande d'absence
    //     $request->validate([
    //         'motif' => 'required|string|max:255',
    //         'date_debut' => 'required|date',
    //         'date_fin' => [
    //             'required',
    //             'date',
    //             function ($attribute, $value, $fail) use ($request) {
    //                 if (strtotime($value) <= strtotime($request->input('date_debut'))) {
    //                     $fail('La date fin doit être supérieure à la date début.');
    //                 }
    //             },
    //         ],
    //         'pdf_files' => 'nullable|file|mimes:pdf|max:2048',
    //     ]);

    //     $demandeAbsence = DemandeAbsence::findOrFail($id);
    //     $demandeAbsence->Motif = $request->input('motif');
    //     $demandeAbsence->DateDebut = $request->input('date_debut');
    //     $demandeAbsence->DateFin = $request->input('date_fin');

    //     if ($request->hasFile('pdf_files')) {
    //         $file = $request->file('pdf_files');
    //         $path = $file->store('pdf_files', 'public');
    //         $demandeAbsence->pdf_files = $path;
    //     }

    //     $demandeAbsence->save();

    //     return redirect()->route('demandes.index')->with('success', 'Demande d\'absence mise à jour avec succès.');
    // }

    // $request->validate([
    //     'motif' => 'required|string|max:255',
    //     'date_debut' => 'required|date',
    //     'date_fin' => 'required|date|after:date_debut',
    //     'pdf_files' => 'nullable|file|mimes:pdf|max:2048',
    // ]);





    public function update(Request $request, $id)
    {
        // Validation et mise à jour de la demande d'absence
        $request->validate([
            'motif' => 'required|string|max:255',
            'autre_motif' => 'nullable|string|max:255', // Ajoutez une règle de validation pour preciser_motif
            'date_debut' => 'required|date',
            'date_fin' => [
                'required',
                'date',
                'after:date_debut',
                function ($attribute, $value, $fail) use ($request) {
                    if (strtotime($value) <= strtotime($request->input('date_debut'))) {
                        $fail('La date fin doit être supérieure à la date début.');
                    }
                },
            ],
            'pdf_files' => 'nullable|file|mimes:pdf|max:2048',
        ]);

        $demandeAbsence = DemandeAbsence::findOrFail($id);
        $demandeAbsence->Motif = $request->input('motif');

        // Concaténation de la valeur de preciser_motif avec motif si motif est autre
        if ($request->input('motif') == 'autre') {
            $demandeAbsence->Motif = $request->input('motif') . ': ' . $request->input('autre_motif');
        }

        $demandeAbsence->DateDebut = $request->input('date_debut');
        $demandeAbsence->DateFin = $request->input('date_fin');

        if ($request->hasFile('pdf_files')) {
            $file = $request->file('pdf_files');
            $path = $file->store('pdf_files', 'public');
            $demandeAbsence->pdf_files = $path;
        }

        $demandeAbsence->save();

        return redirect()->route('demandes.index')->with('success', 'Demande d\'absence mise à jour avec succès.');
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
    // Initialiser une requête de base pour récupérer les absences
    $query = DemandeAbsence::query();

    // Filtrer par type de demande (formateur ou personnel administratif)
    if ($request->filled('type_demande')) {
        if ($request->type_demande === 'formateur') {
            $query->whereNotNull('matriculeFm');
        } elseif ($request->type_demande === 'personnel') {
            $query->whereNotNull('matriculePA');
        }

        // Filtrer par nom
        if ($request->filled('nom')) {
            $query->where(function($query) use ($request) {
                $query->whereHas('formateur', function ($q) use ($request) {
                    $q->where('nom', 'like', '%' . $request->nom . '%');
                })->orWhereHas('personnelAdministratif', function ($q) use ($request) {
                    $q->where('nom', 'like', '%' . $request->nom . '%');
                });
            });
        }

        // Filtrer par prénom
        if ($request->filled('prenom')) {
            $query->where(function($query) use ($request) {
                $query->whereHas('formateur', function ($q) use ($request) {
                    $q->where('prenom', 'like', '%' . $request->prenom . '%');
                })->orWhereHas('personnelAdministratif', function ($q) use ($request) {
                    $q->where('prenom', 'like', '%' . $request->prenom . '%');
                });
            });
        }

        // Filtrer par date de début
        if ($request->filled('date_debut')) {
            $query->whereDate('DateDebut', '>=', $request->date_debut);
        }

        // Filtrer par date de fin
        if ($request->filled('date_fin')) {
            $query->whereDate('DateFin', '<=', $request->date_fin);
        }
    }

    // Récupérer les absences
    $absences = $query->get();

    // Retourner la vue avec les données et la variable $showForm
    return view('TousDemande', compact('absences'));
}






public function showAllAbsences(Request $request)
{
    // Initialiser une requête de base pour récupérer les absences
    $query = DemandeAbsence::query();

    // Filtrer par type de demande (formateur ou personnel administratif)
    if ($request->filled('type_demande')) {
        if ($request->type_demande === 'formateur') {
            $query->whereNotNull('matriculeFm');
        } elseif ($request->type_demande === 'personnel') {
            $query->whereNotNull('matriculePA');
        }

        // Filtrer par nom
        if ($request->filled('nom')) {
            $query->where(function($query) use ($request) {
                $query->whereHas('formateur', function ($q) use ($request) {
                    $q->where('nom', 'like', '%' . $request->nom . '%');
                })->orWhereHas('personnelAdministratif', function ($q) use ($request) {
                    $q->where('nom', 'like', '%' . $request->nom . '%');
                });
            });
        }

        // Filtrer par prénom
        if ($request->filled('prenom')) {
            $query->where(function($query) use ($request) {
                $query->whereHas('formateur', function ($q) use ($request) {
                    $q->where('prenom', 'like', '%' . $request->prenom . '%');
                })->orWhereHas('personnelAdministratif', function ($q) use ($request) {
                    $q->where('prenom', 'like', '%' . $request->prenom . '%');
                });
            });
        }

        // Filtrer par date de début
        if ($request->filled('date_debut')) {
            $query->whereDate('DateDebut', '>=', $request->date_debut);
        }

        // Filtrer par date de fin
        if ($request->filled('date_fin')) {
            $query->whereDate('DateFin', '<=', $request->date_fin);
        }
    }

    // Récupérer les absences
    $absences = $query->get();

    // Retourner la vue avec les données
    return view('ToutesAbsences', compact('absences'));
}



// public function download($file)
// {
//     $filePath = 'pdf_files/' . $file;

//     if (Storage::disk('public')->exists($filePath)) {
//         return Storage::disk('public')->download($filePath);
//     }

//     return redirect()->back()->with('error', 'Le fichier n\'existe pas.');
// }

}
