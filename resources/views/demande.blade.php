@extends('layouts.Dashbord')

@section('content')
<div class="container mx-auto px-4">
    <h1 class="mt-5 text-2xl font-bold">Faire une Demande d'Absence</h1>

    {{-- Error Alert --}}
    {{-- @if ($errors->any())
    <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4" role="alert">
        <p class="font-bold">Attention</p>
        <p>Il y a eu des problèmes avec votre saisie:</p>
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif --}}

    {{-- Error Alert --}}
@if ($errors->any())
<div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4" role="alert">
    <p class="font-bold">Attention</p>
    {{-- <p>Il y a eu des problèmes avec votre saisie:</p> --}}
    <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error === 'The date fin field is required.' ? 'La date fin doit être supérieure à la date début.' : $error }}</li>
        @endforeach
    </ul>
</div>
@endif


    {{-- Success Alert --}}
    @if (session('success'))
    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4" role="alert">
        <p class="font-bold">Succès</p>
        <p>{{ session('success') }}</p>
    </div>
    @endif

    {{-- Form --}}
    <form action="{{ route('demandes.store') }}" method="post" enctype="multipart/form-data" class="mt-6" onsubmit="return validateForm()">
        @csrf

        {{-- Nom Input --}}
        <div class="mb-4">
            <label for="nom" class="block text-sm font-bold text-gray-700 mb-2">Nom :</label>
            <input type="text" name="nom" id="nom" required
                   class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" value="{{ old('nom') }}">
        </div>

        {{-- Prénom Input --}}
        <div class="mb-4">
            <label for="prenom" class="block text-sm font-bold text-gray-700 mb-2">Prénom :</label>
            <input type="text" name="prenom" id="prenom" required
                   class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" value="{{ old('prenom') }}">
        </div>

        {{-- Motif Input --}}
        <div class="mb-4">
            <label for="motif" class="block text-sm font-bold text-gray-700 mb-2">Motif :</label>
            <select name="motif" id="motif" required class="block appearance-none w-full bg-white border border-gray-400 hover:border-gray-500 px-4 py-2 pr-8 rounded shadow leading-tight focus:outline-none focus:shadow-outline" onchange="togglePdfInput()">
                <option value="formation_continue" {{ old('motif') == 'formation_continue' ? 'selected' : '' }}>Formation Continue</option>
                <option value="formation_drif_drh" {{ old('motif') == 'formation_drif_drh' ? 'selected' : '' }}>Formation DRIF/DRH</option>
                <option value="reunion" {{ old('motif') == 'reunion' ? 'selected' : '' }}>Réunion</option>
                <option value="validation_conception_examens" {{ old('motif') == 'validation_conception_examens' ? 'selected' : '' }}>Validation & Conception des Examens</option>
                <option value="mission_drh" {{ old('motif') == 'mission_drh' ? 'selected' : '' }}>Mission DRH</option>
                <option value="maladie" {{ old('motif') == 'maladie' ? 'selected' : '' }}>Maladie</option>
                <option value="autre" {{ old('motif') == 'autre' ? 'selected' : '' }}>Autre</option>
            </select>
        </div>

        {{-- Date Début Input --}}
        <div class="mb-4">
            <label for="date_debut" class="block text-sm font-bold text-gray-700 mb-2">Date Début :</label>
            <input type="date" name="date_debut" id="date_debut" required
                   class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" value="{{ old('date_debut') }}">
        </div>

        {{-- Date Fin Input --}}
        <div class="mb-4">
            <label for="date_fin" class="block text-sm font-bold text-gray-700 mb-2">Date Fin :</label>
            <input type="date" name="date_fin" id="date_fin" required
                   class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" value="{{ old('date_fin') }}">
        </div>

        {{-- PDF File Input --}}
        <div class="mb-4" id="pdf_files_div" style="display: {{ old('motif') == 'formation_continue' || old('motif') == 'formation_drif_drh' ? 'block' : 'none' }};">
            <label for="pdf_files" class="block text-sm font-bold text-gray-700 mb-2">Fichier PDF :</label>
            <input type="file" name="pdf_files" id="pdf_files"
                   class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
        </div>

        {{-- Submit Button --}}
        <button type="submit" class="bg-blue-500 hover:bg-blue-700 mb-8 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
            Soumettre
        </button>

        {{-- Error Message --}}
        <div id="date-error" class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mt-4" role="alert" style="display:none;">
            <p class="font-bold">Erreur</p>
            <p>La date de fin ne peut pas être antérieure à la date de début.</p>
        </div>
    </form>
</div>

<script>
    function togglePdfInput() {
        const motif = document.getElementById('motif').value;
        const pdfDiv = document.getElementById('pdf_files_div');
        if (motif === 'formation_continue' || motif === 'formation_drif_drh') {
            pdfDiv.style.display = 'block';
        } else {
            pdfDiv.style.display = 'none';
        }
    }

    function validateForm() {
        const dateDebut = document.getElementById('date_debut').value;
        const dateFin = document.getElementById('date_fin').value;
        const dateDebutObj = new Date(dateDebut);
        const dateFinObj = new Date(dateFin);

        if (dateFin && dateDebutObj > dateFinObj) {
            document.getElementById('date-error').style.display = 'block';
            return false;
        }

        return true;
    }
</script>
@endsection
