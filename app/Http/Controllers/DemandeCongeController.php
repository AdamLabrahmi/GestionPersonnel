<?php
namespace App\Http\Controllers;

use App\Models\DemandeConges;
use App\Models\Formateur;
use App\Models\TypeConge;
use App\Models\FormateurPermanent;
use App\Models\PersonnelAdministratif;
use Illuminate\Http\Request;
use Carbon\CarbonPeriod;
use Carbon\Carbon;

class DemandeCongeController extends Controller
{
    public function index()
{
    // Récupérer toutes les demandes de congé avec les données associées
    $demandesConges = DemandeConges::with(['formateur', 'personnelAdministratif', 'typeConge'])->get();

    // Retourner la vue avec les données
    return view('AllConge', compact('demandesConges'));
}

    public function create()
{
    $typeConges = TypeConge::all();
    $motifsExceptionnels = [
        'Mariage de la personne concernée',
        'Mariage d’un enfant',
        'Nouveau-né en croissance',
        'Hospitalisation du conjoint ou de l’enfant',
        'Décès d’un conjoint ou d’un enfant',
        'Décès d’un actif (frère-sœur)',
        'Excuses',
        'Naissance'
    ];

    return view('demandeConge', compact('typeConges', 'motifsExceptionnels'));
}

public function store(Request $request)
{
    $request->validate([
        'nom' => 'required|string|max:255',
        'prenom' => 'required|string|max:255',
        'dateDebutConge' => 'required|date',
        'dateFinConge' => [
            'required',
            'date',
            function ($attribute, $value, $fail) use ($request) {
                if (strtotime($value) <= strtotime($request->input('dateDebutConge'))) {
                    $fail('La date fin doit être supérieure à la date début.');
                }
            },
        ],
        'idTypeConge' => 'required|exists:type_conges,id',
        'motif' => 'nullable|string|max:255',
    ]);

    // Recherche de l'employé par nom et prénom
    $formateur = Formateur::where('nom', $request->input('nom'))
                      ->where('prenom', $request->input('prenom'))
                      ->first();

    $personnelAdministratif = null;

    // Si aucun formateur trouvé, recherche parmi le personnel administratif
    if (!$formateur) {
        $personnelAdministratif = PersonnelAdministratif::where('nom', $request->input('nom'))
                                                        ->where('prenom', $request->input('prenom'))
                                                        ->first();
    }

    // Vérifie s'il n'y a pas d'employé trouvé
    if (!$formateur && !$personnelAdministratif) {
        return redirect()->back()->withErrors(['error' => 'Aucun employé trouvé avec ce nom et prénom.']);
    }

    // Création de la demande de congé
    $demandeConge = new DemandeConges();
    $demandeConge->dateDebutConge = $request->input('dateDebutConge');
    $demandeConge->dateFinConge = $request->input('dateFinConge');
    $demandeConge->idTypeConge = $request->input('idTypeConge');
    $demandeConge->motif = $request->input('motif');
    $demandeConge->statut = 'en attente';

    // Calcul de la durée du congé en jours ouvrés
    $dateDebut = Carbon::parse($request->input('dateDebutConge'));
    $dateFin = Carbon::parse($request->input('dateFinConge'));
    $joursOuvres = $this->calculateBusinessDays($dateDebut, $dateFin);
    $demandeConge->durreeConge = $joursOuvres . ' jours';

    // Attribution du matricule à l'employé
    if ($formateur) {
        $demandeConge->idFMPR = $formateur->matricule;
    } elseif ($personnelAdministratif) {
        $demandeConge->matriculePA = $personnelAdministratif->matricule;
    }

    // Sauvegarde de la demande de congé
    $demandeConge->save();

    return redirect()->back()->with('success', 'Demande de congé soumise avec succès.');
}


    private function calculateBusinessDays($startDate, $endDate)
    {
        $period = CarbonPeriod::create($startDate, $endDate);
        $holidays = [
            // Add your list of holidays here
            '2024-01-01', '2024-05-01', '2024-07-14', '2024-08-15', '2024-11-01', '2024-12-25'
        ];

        $days = 0;
        foreach ($period as $date) {
            if ($date->isWeekday() && !in_array($date->format('Y-m-d'), $holidays)) {
                $days++;
            }
        }

        return $days;
    }


    public function show(DemandeConges $demande)
    {
        return view('demandes.show', compact('demande'));
    }

    public function edit(DemandeConges $demande)
    {
        $typeConges = TypeConge::all();
        return view('demandes.edit', compact('demande', 'typeConges'));
    }

    public function update(Request $request, DemandeConges $demande)
    {
        $request->validate([
            'dateDebutConge' => 'required|date',
            'dateFinConge' => 'required|date|after:dateDebutConge',
            'idTypeConge' => 'required|exists:type_conges,id',
            'idFMPR' => 'nullable|exists:formateurs__permanents,id',
            'matriculePA' => 'nullable|exists:personnel__administratifs,matricule'
        ]);

        $days = $this->calculateLeaveDays($request->dateDebutConge, $request->dateFinConge);

        $demande->update([
            'dateDebutConge' => $request->dateDebutConge,
            'dateFinConge' => $request->dateFinConge,
            'durreeConge' => $days,
            'idTypeConge' => $request->idTypeConge,
            'idFMPR' => $request->idFMPR,
            'matriculePA' => $request->matriculePA
        ]);

        return redirect()->route('demandes.index')->with('success', 'Demande de congé mise à jour avec succès.');
    }

    public function destroy(DemandeConges $demande)
    {
        $demande->delete();
        return redirect()->route('demandes.index')->with('success', 'Demande de congé supprimée avec succès.');
    }

    private function calculateLeaveDays($start, $end)
    {
        $period = CarbonPeriod::create($start, $end);
        $days = 0;

        foreach ($period as $date) {
            if (!$date->isWeekend() && !$this->isHoliday($date)) {
                $days++;
            }
        }

        return $days;
    }

    private function isHoliday($date)
    {
        $holidays = [
            '2024-01-01',
            '2024-05-01',
            '2024-07-14',
            '2024-12-25'
        ];

        return in_array($date->format('Y-m-d'), $holidays);
    }
}
