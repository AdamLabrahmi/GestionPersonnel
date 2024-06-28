<?php

namespace App\Http\Controllers;

use App\Models\DemandeAbsence;
use Carbon\Carbon;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\IOFactory;
use Illuminate\Support\Facades\Storage;

class AbsenceReportController extends Controller
{
    public function generateWeeklyReport()
    {
        // Obtenir la semaine actuelle
        $startOfWeek = Carbon::now()->startOfWeek();
        $endOfWeek = Carbon::now()->endOfWeek();

        // Récupérer les demandes d'absence pour la semaine actuelle
        $absences = DemandeAbsence::with('formateur')
            ->where(function ($query) use ($startOfWeek, $endOfWeek) {
                $query->whereBetween('DateDebut', [$startOfWeek, $endOfWeek])
                    ->orWhereBetween('DateFin', [$startOfWeek, $endOfWeek]);
            })
            ->get();

        // Créer un nouveau document Word
        $phpWord = new PhpWord();

        // Ajouter une section
        $section = $phpWord->addSection();

        // Ajouter un en-tête
        $section->addText(
            'Office de la formation professionnelle et de la promotion du travail',
            ['name' => 'Arial', 'size' => 14, 'bold' => true]
        );

        // Ajouter une ligne vide
        $section->addTextBreak(1);

        // Ajouter une table
        $table = $section->addTable();

        // Ajouter l'en-tête de la table
        $table->addRow();
        $table->addCell(4000)->addText('Nom et Prénom', ['bold' => true]);
        $table->addCell(2000)->addText('Date Début', ['bold' => true]);
        $table->addCell(2000)->addText('Date Fin', ['bold' => true]);

        // Remplir la table avec les données des absences
        foreach ($absences as $absence) {
            if ($absence->formateur) {
                $nomPrenom = $absence->formateur->nom . ' ' . $absence->formateur->prenom;
                $table->addRow();
                $table->addCell(4000)->addText($nomPrenom);
                $table->addCell(2000)->addText($absence->DateDebut->format('d/m/Y'));
                $table->addCell(2000)->addText($absence->DateFin->format('d/m/Y'));
            }
        }

        // Générer le nom de fichier
        $fileName = 'rapport_absences_semaine_' . $startOfWeek->format('d_m_Y') . '.docx';
        $filePath = storage_path('app/public/' . $fileName);

        // Sauvegarder le fichier généré dans le répertoire de stockage public
        $objWriter = IOFactory::createWriter($phpWord, 'Word2007');
        $objWriter->save($filePath);

        // Retourner le fichier téléchargé
        return response()->download($filePath)->deleteFileAfterSend(true);
    }
}
