@extends('layouts.Dashbord')
@section('content')
    <div class="container mx-auto mb-8 px-4">
        <h1 class="mt-5 text-3xl font-bold">Recherche d'employés</h1>
        <form action="{{ route('search') }}" method="post" class="mt-8">
            @csrf
            <div class="mb-4">
                <label for="matricule" class="block text-sm font-medium text-gray-700">Matricule :</label>
                <input type="text" id="matricule" name="matricule" class="bg-white border border-gray-300 text-gray-300 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-3/4 ps-10 p-2.5  dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Enter your matricule">
            </div>
            <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-base font-medium  rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                Rechercher
            </button>
        </form>
    </div>

    <!-- Ajouter le lien vers Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
@endsection
