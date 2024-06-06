@extends('layouts.Dashbord')

@section('content')
<div class="container mx-auto px-4">
    <h1 class="mt-12 text-3xl font-semibold">Liste des Absences</h1>

    <!-- Formulaire de filtrage -->
    <form action="{{ route('absences.index') }}" method="GET" class="mt-6">
        <!-- Filtrer par type de formateur -->
        <div class="mb-4">
            <label for="type_formateur" class="block text-sm font-medium text-gray-700">Type de formateur :</label>
            <select name="type_formateur" id="type_formateur" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                <option value="">Tous</option>
                <option value="permanent">Permanent</option>
                <option value="vacataire">Vacataire</option>
            </select>
        </div>

        <!-- Filtrer par date de début -->
        <div class="mb-4">
            <label for="date_debut" class="block text-sm font-medium text-gray-700">Date de début :</label>
            <input type="date" name="date_debut" id="date_debut" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
        </div>

        <!-- Filtrer par filière de formateur -->
        <div class="mb-4">
            <label for="filiere_formateur" class="block text-sm font-medium text-gray-700">Filière de formateur :</label>
            <select name="filiere_formateur" id="filiere_formateur" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                <option value="">Tous</option>
                @foreach($filieres as $filiere)
                    <option value="{{ $filiere }}">{{ $filiere }}</option>
                @endforeach
            </select>
        </div>

        <!-- Filtrer par rôle de personnel administratif -->
        <div class="mb-4">
            <label for="role_personnel" class="block text-sm font-medium text-gray-700">Rôle de personnel administratif :</label>
            <select name="role_personnel" id="role_personnel" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                <option value="">Tous</option>
                @foreach($roles as $role)
                    <option value="{{ $role }}">{{ $role }}</option>
                @endforeach
            </select>
        </div>
    </form>

    <!-- Tableau des résultats -->
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
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Autorisation</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($absences as $absence)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if ($absence->formateur)
                                        {{ $absence->formateur->nom }}
                                    @elseif ($absence->personnelAdministratif)
                                        {{ $absence->personnelAdministratif->nom }}
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if ($absence->formateur)
                                        {{ $absence->formateur->prenom }}
                                    @elseif ($absence->personnelAdministratif)
                                        {{ $absence->personnelAdministratif->prenom }}
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $absence->date_debut }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $absence->date_fin }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $absence->autorisation ? 'Oui' : 'Non' }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
