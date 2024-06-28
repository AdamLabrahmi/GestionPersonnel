@extends('layouts.Dashbord')

@section('content')
<div class="container mx-auto px-4">
    <h1 class="mt-12 text-3xl font-semibold">Demande de Congé </h1>

    <form action="{{ route('conges.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-4">
            <label for="nom" class="block text-sm font-bold text-gray-700 mb-2">Nom :</label>
            <input type="text" name="nom" id="nom" required class="block appearance-none w-full bg-white border border-gray-400 hover:border-gray-500 px-4 py-2 pr-8 rounded shadow leading-tight focus:outline-none focus:shadow-outline">
        </div>

        <div class="mb-4">
            <label for="prenom" class="block text-sm font-bold text-gray-700 mb-2">Prénom :</label>
            <input type="text" name="prenom" id="prenom" required class="block appearance-none w-full bg-white border border-gray-400 hover:border-gray-500 px-4 py-2 pr-8 rounded shadow leading-tight focus:outline-none focus:shadow-outline">
        </div>

        <div class="mb-4">
            <label for="dateDebutConge" class="block text-sm font-bold text-gray-700 mb-2">Date de début :</label>
            <input type="date" name="dateDebutConge" id="dateDebutConge" required class="block appearance-none w-full bg-white border border-gray-400 hover:border-gray-500 px-4 py-2 pr-8 rounded shadow leading-tight focus:outline-none focus:shadow-outline">
        </div>

        <div class="mb-4">
            <label for="dateFinConge" class="block text-sm font-bold text-gray-700 mb-2">Date de fin :</label>
            <input type="date" name="dateFinConge" id="dateFinConge" required class="block appearance-none w-full bg-white border border-gray-400 hover:border-gray-500 px-4 py-2 pr-8 rounded shadow leading-tight focus:outline-none focus:shadow-outline">
        </div>

        <div class="mb-4">
            <label for="idTypeConge" class="block text-sm font-bold text-gray-700 mb-2">Type de Congé :</label>
            <select name="idTypeConge" id="idTypeConge" required class="block appearance-none w-full bg-white border border-gray-400 hover:border-gray-500 px-4 py-2 pr-8 rounded shadow leading-tight focus:outline-none focus:shadow-outline">
                <option value="" disabled selected>Choisir un type de congé</option>
                @foreach($typeConges as $typeConge)
                    <option value="{{ $typeConge->id }}">{{ $typeConge->TypeConge }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-4" id="motifCongeSection" style="display: none;">
            <label for="motif" class="block text-sm font-bold text-gray-700 mb-2">Motif :</label>
            <select name="motif" id="motif" class="block appearance-none w-full bg-white border border-gray-400 hover:border-gray-500 px-4 py-2 pr-8 rounded shadow leading-tight focus:outline-none focus:shadow-outline">
                <option value="" disabled selected>Choisir un motif</option>
                @foreach($motifsExceptionnels as $motif)
                    <option value="{{ $motif }}">{{ $motif }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-4">
            <input type="hidden" name="matriculePA" id="matriculePA">
        </div>

        <div class="mb-4">
            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                Soumettre
            </button>
        </div>
    </form>
</div>

<script>
    document.getElementById('idTypeConge').addEventListener('change', function() {
        var selectedType = this.options[this.selectedIndex].text;
        if (selectedType === 'exceptionnel') {
            document.getElementById('motifCongeSection').style.display = 'block';
        } else {
            document.getElementById('motifCongeSection').style.display = 'none';
        }
    });
</script>
@endsection
