@extends('layouts.Dashbord')

@section('content')
<div class="container mx-auto px-4">
    <h1 class="mt-12 text-3xl font-semibold">Liste des Absences</h1>

    <!-- Boutons de sélection du type de demande -->
    <div class="mt-6 mb-6">
        <a href="{{ route('absences.index', ['type_demande' => 'formateur']) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mr-2">
            Liste des Formateurs
        </a>
        <a href="{{ route('absences.index', ['type_demande' => 'personnel']) }}" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
            Liste du Personnel Administratif
        </a>
    </div>

    @if(request('type_demande'))
    <!-- Formulaire de filtrage -->
    <form action="{{ route('absences.index') }}" method="GET" class="mt-6">
        <input type="hidden" name="type_demande" value="{{ request('type_demande') }}">

        <div class="flex flex-wrap -mx-2 mb-4">
            <div class="w-full md:w-1/5 px-2 mb-4 md:mb-0">
                <label for="nom" class="block text-sm font-medium text-gray-700">Nom :</label>
                <input type="text" name="nom" id="nom" value="{{ request('nom') }}" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
            </div>

            <div class="w-full md:w-1/5 px-2 mb-4 md:mb-0">
                <label for="prenom" class="block text-sm font-medium text-gray-700">Prénom :</label>
                <input type="text" name="prenom" id="prenom" value="{{ request('prenom') }}" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
            </div>

            <div class="w-full md:w-1/5 px-2 mb-4 md:mb-0">
                <label for="date_debut" class="block text-sm font-medium text-gray-700">Date de début :</label>
                <input type="date" name="date_debut" id="date_debut" value="{{ request('date_debut') }}" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
            </div>

            <div class="w-full md:w-1/5 px-2 mb-4 md:mb-0">
                <label for="date_fin" class="block text-sm font-medium text-gray-700">Date de fin :</label>
                <input type="date" name="date_fin" id="date_fin" value="{{ request('date_fin') }}" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
            </div>

            <div class="w-full md:w-1/5 px-2 mb-4 md:mb-0 flex items-end">
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                    Filtrer
                </button>
            </div>
        </div>
    </form>
    @endif

    <!-- Tableau des résultats -->
    @if($absences->isNotEmpty())
        <div class="flex flex-col mt-6 mb-8">
            <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                    <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                        <table class="min-w-full divide-y divide-gray-200 mb-8">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nom</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Prénom</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date de Début</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date de Fin</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date de la Demande</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Autorisation</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach ($absences as $absence)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        {{ $absence->formateur ? $absence->formateur->nom : $absence->personnelAdministratif->nom }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        {{ $absence->formateur ? $absence->formateur->prenom : $absence->personnelAdministratif->prenom }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $absence->DateDebut ? \Carbon\Carbon::parse($absence->DateDebut)->format('Y-m-d') : '' }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $absence->DateFin ? \Carbon\Carbon::parse($absence->DateFin)->format('Y-m-d') : '' }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $absence->date_demande ? \Carbon\Carbon::parse($absence->date_demande)->format('Y-m-d H:i:s') : '' }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $absence->autorisation ? 'Oui' : 'Non' }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    @else
        <p class="mt-6">Aucune absence trouvée.</p>
    @endif
</div>
@endsection
