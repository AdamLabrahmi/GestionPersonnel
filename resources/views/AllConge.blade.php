@extends('layouts.Dashbord')

@section('content')
<div class="container mx-auto">
    <h1 class="text-3xl font-bold mb-8">Toutes les demandes de congés</h1>
    <div class="overflow-x-auto">
        <table class="table-auto w-full border-collapse border border-gray-800">
            <thead>
                <tr>
                    <th class="px-4 py-2 bg-gray-200 border border-gray-600">Date de début</th>
                    <th class="px-4 py-2 bg-gray-200 border border-gray-600">Date de fin</th>
                    <th class="px-4 py-2 bg-gray-200 border border-gray-600">Durée</th>
                    <th class="px-4 py-2 bg-gray-200 border border-gray-600">Statut</th>
                    <th class="px-4 py-2 bg-gray-200 border border-gray-600">Employé</th>
                    <th class="px-4 py-2 bg-gray-200 border border-gray-600">Type de congé</th>
                    <th class="px-4 py-2 bg-gray-200 border border-gray-600">Motif</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($demandesConges as $demandeConge)
                <tr>
                    <td class="px-4 py-2 border border-gray-600">{{ $demandeConge->dateDebutConge }}</td>
                    <td class="px-4 py-2 border border-gray-600">{{ $demandeConge->dateFinConge }}</td>
                    <td class="px-4 py-2 border border-gray-600">{{ $demandeConge->durreeConge }}</td>
                    <td class="px-4 py-2 border border-gray-600">{{ $demandeConge->statut }}</td>
                    <td class="px-4 py-2 border border-gray-600">
                        @if ($demandeConge->formateur)
                        {{ $demandeConge->formateur->nom }} {{ $demandeConge->formateur->prenom }}
                        @elseif ($demandeConge->personnelAdministratif)
                        {{ $demandeConge->personnelAdministratif->nom }} {{ $demandeConge->personnelAdministratif->prenom }}
                        @endif
                    </td>
                    <td class="px-4 py-2 border border-gray-600">{{ $demandeConge->typeConge->TypeConge }}</td>
                    <td class="px-4 py-2 border border-gray-600">{{ $demandeConge->motif }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
