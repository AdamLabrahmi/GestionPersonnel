@extends('layouts.Dashbord')

@section('content')
<div class="container mx-auto px-4">
    <h1 class="mt-12 text-3xl font-semibold">Tous les Absences</h1>
    <a href="{{ route('generateWeeklyReport') }}" class="btn btn-primary">Télécharger le Rapport Hebdomadaire des Absences</a>
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
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Motif</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">PDF File</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Action</th>
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
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $absence->Motif ?? '' }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if ($absence->pdf_files)
                                            <a href="{{ route('demandes.download', basename($absence->pdf_files)) }}" class="text-blue-500 hover:underline">Télécharger le fichier</a>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <a href="{{ route('demandes.edit', $absence->id) }}" class="text-blue-500 hover:underline">Modifier</a>
                                    </td>
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
