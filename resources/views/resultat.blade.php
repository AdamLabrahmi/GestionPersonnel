@extends('layouts.Dashbord')
@section('content')
<div class="container mx-auto px-4">
    @if(isset($error))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mt-5" role="alert">
            {{ $error }}
        </div>
    @else
        <div class="bg-white shadow-md rounded-lg mt-5">
            <div class="bg-gray-200 px-4 py-2 rounded-t-lg font-semibold">Les informations de {{ $nom }} {{ $prenom }}</div>
            <div class="px-4 py-2">
                <p class="text-gray-700">Nom : {{ $nom }}</p>
                <p class="text-gray-700">Prénom : {{ $prenom }}</p>
                <p class="text-gray-700">Type : {{ $type }}</p>
            </div>
        </div>
    @endif
    <a href="{{ route('mat') }}" class="inline-block mt-3 px-4 py-2 bg-blue-500 text-white font-semibold rounded-lg shadow-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-opacity-75">Retour</a>
</div>


    <!-- Ajouter le lien vers Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
@endsection
