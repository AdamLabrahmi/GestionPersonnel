@extends('layouts.Dashbord')

@section('content')
<div class="container mx-auto px-4">
    <h1 class="mt-12 text-3xl font-semibold">Modifier Demande d'Absence</h1>

    <form action="{{ route('demandes.update', $demandeAbsence->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label for="motif" class="block text-sm font-bold text-gray-700 mb-2">Motif :</label>
            <select name="motif" id="motif" required class="block appearance-none w-full bg-white border border-gray-400 hover:border-gray-500 px-4 py-2 pr-8 rounded shadow leading-tight focus:outline-none focus:shadow-outline" onchange="toggleFields()">
                <option value="formation_continue" {{ old('motif', $demandeAbsence->Motif) == 'formation_continue' ? 'selected' : '' }}>Formation Continue</option>
                <option value="formation_drif_drh" {{ old('motif', $demandeAbsence->Motif) == 'formation_drif_drh' ? 'selected' : '' }}>Formation DRIF/DRH</option>
                <option value="reunion" {{ old('motif', $demandeAbsence->Motif) == 'reunion' ? 'selected' : '' }}>Réunion</option>
                <option value="validation_conception_examens" {{ old('motif', $demandeAbsence->Motif) == 'validation_conception_examens' ? 'selected' : '' }}>Validation & Conception des Examens</option>
                <option value="mission_drh" {{ old('motif', $demandeAbsence->Motif) == 'mission_drh' ? 'selected' : '' }}>Mission DRH</option>
                <option value="maladie" {{ old('motif', $demandeAbsence->Motif) == 'maladie' ? 'selected' : '' }}>Maladie</option>
                <option value="autre" {{ old('motif', $demandeAbsence->Motif) == 'autre' ? 'selected' : '' }}>Autre</option>
            </select>
        </div>

        <div class="mb-4">
            <label for="date_debut" class="block text-sm font-medium text-gray-700">Date de début :</label>
            <input type="date" name="date_debut" id="date_debut" value="{{ old('date_debut', $demandeAbsence->DateDebut) }}" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
        </div>

        <div class="mb-4">
            <label for="date_fin" class="block text-sm font-medium text-gray-700">Date de fin :</label>
            <input type="date" name="date_fin" id="date_fin" value="{{ old('date_fin', $demandeAbsence->DateFin) }}" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
        </div>

        <div class="mb-4" id="certificat_medical_div" style="display: none;">
            <label for="certificat_medical" class="block text-sm font-medium text-gray-700">Certificat Médical :</label>
            <input type="file" name="certificat_medical" id="certificat_medical" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
        </div>

        <div class="mb-4" id="autre_motif_div" style="display: none;">
            <label for="autre_motif" class="block text-sm font-medium text-gray-700">Préciser le motif :</label>
            <input type="text" name="autre_motif" id="autre_motif" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
        </div>

        <div class="mb-4" id="pdf_files_div" style="display: none;">
            <label for="pdf_files" class="block text-sm font-medium text-gray-700">PDF File :</label>
            <input type="file" name="pdf_files" id="pdf_files" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
            @if ($demandeAbsence->pdf_files)
    {{-- <p class="mt-2">Fichier existant: <a href="{{ route('download', $demandeAbsence->pdf_files) }}" class="text-blue-500 hover:underline">Télécharger</a></p> --}}
@endif
</div>

<div class="mb-4">
    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
        Mettre à jour
    </button>
</div>
</form>
</div>

<script>
function toggleFields() {
    const motif = document.getElementById('motif').value;
    const certificatMedicalDiv = document.getElementById('certificat_medical_div');
    const autreMotifDiv = document.getElementById('autre_motif_div');
    const pdfFilesDiv = document.getElementById('pdf_files_div');

    if (motif === 'maladie') {
        certificatMedicalDiv.style.display = 'block';
        autreMotifDiv.style.display = 'none';
        pdfFilesDiv.style.display = 'none';
    } else if (motif === 'autre') {
        certificatMedicalDiv.style.display = 'none';
        autreMotifDiv.style.display = 'block';
        pdfFilesDiv.style.display = 'block';
    } else {
        certificatMedicalDiv.style.display = 'none';
        autreMotifDiv.style.display = 'none';
        pdfFilesDiv.style.display = 'none';
    }
}

// Appel initial pour s'assurer que les champs sont correctement affichés lors du chargement de la page
toggleFields();
</script>
@endsection

