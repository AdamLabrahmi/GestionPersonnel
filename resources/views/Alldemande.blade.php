@extends('layouts.Dashbord')

@section('content')
<div class="container mx-auto px-4 mb-8">
    <h1 class="mt-5 text-2xl font-bold">Liste des Demandes d'Absence</h1>

    @if (session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mt-4" role="alert">
        <span class="block sm:inline">{{ session('success') }}</span>
    </div>
    @endif

    <a href="{{ route('demandes.create') }}" class="btn btn-warning mt-4 inline-flex items-center space-x-2 py-2 px-4 rounded-md bg-yellow-500 hover:bg-yellow-600 text-white">
        <i class="fas fa-plus"></i>
        <span>Ajouter une demande</span>
    </a>

    @if($demandesToday->isNotEmpty())
    <h2 class="mt-4 text-xl font-semibold">Demandes d'aujourd'hui ({{ \Carbon\Carbon::now()->format('d M Y') }})</h2>
    <div class="grid grid-cols-1 gap-4 mb-8">
        @foreach ($demandesToday as $demande)
        <div class="p-4 border rounded-lg shadow-sm bg-white">
            <div class="flex justify-between items-center">
                <div>
                    <p class="text-lg font-bold">{{ $demande->formateur ? $demande->formateur->nom : ($demande->personnelAdministratif ? $demande->personnelAdministratif->nom : '') }} {{ $demande->formateur ? $demande->formateur->prenom : ($demande->personnelAdministratif ? $demande->personnelAdministratif->prenom : '') }}</p>
                    <p>Motif: {{ $demande->Motif }}</p>
                    <p>Du: {{ \Carbon\Carbon::parse($demande->DateDebut)->format('d M Y') }} au {{ \Carbon\Carbon::parse($demande->DateFin)->format('d M Y') }}</p>
                </div>
                <div class="flex items-center space-x-2">
                    <form action="{{ route('demandes.updateStatus', $demande->id) }}" method="post">
                        @csrf
                        @method('PATCH')
                        <select name="status" class="form-select border rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 mr-2">
                            <option value="en attente" {{ $demande->status == 'en attente' ? 'selected' : '' }}>En attente</option>
                            <option value="informer" {{ $demande->status == 'informer' ? 'selected' : '' }}>Informer</option>
                        </select>
                        <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white py-2 px-4 rounded-md">
                            <i class="fas fa-check"></i>
                        </button>
                    </form>
                    <form action="{{ route('demandes.updateAuthorization', $demande->id) }}" method="post">
                        @csrf
                        @method('PATCH')
                        <select name="autorisation" class="form-select border rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 mr-2">
                            <option value="0" {{ $demande->autorisation == false ? 'selected' : '' }}>Non</option>
                            <option value="1" {{ $demande->autorisation == true ? 'selected' : '' }}>Oui</option>
                        </select>
                        <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white py-2 px-4 rounded-md">
                            <i class="fas fa-check"></i>
                        </button>
                    </form>
                    <form action="{{ route('demandes.destroy', $demande->id) }}" method="post">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger py-2 px-4 bg-red-500 hover:bg-red-600 text-white rounded-md"><i class="fas fa-trash-alt"></i></button>
                    </form>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @else
    <p>Aucune demande d'absence pour aujourd'hui.</p>
    @endif

    @if($demandesYesterday->isNotEmpty())
    <h2 class="mt-4 text-xl font-semibold">Demandes d'hier ({{ \Carbon\Carbon::yesterday()->format('d M Y') }})</h2>
    <div class="grid grid-cols-1 gap-4 mb-8">
        @foreach ($demandesYesterday as $demande)
        <div class="p-4 border rounded-lg shadow-sm bg-white">
            <div class="flex justify-between items-center">
                <div>
                    <p class="text-lg font-bold">{{ $demande->formateur ? $demande->formateur->nom : ($demande->personnelAdministratif ? $demande->personnelAdministratif->nom : '') }} {{ $demande->formateur ? $demande->formateur->prenom : ($demande->personnelAdministratif ? $demande->personnelAdministratif->prenom : '') }}</p>
                    <p>Motif: {{ $demande->Motif }}</p>
                    <p>Du: {{ \Carbon\Carbon::parse($demande->DateDebut)->format('d M Y') }} au {{ \Carbon\Carbon::parse($demande->DateFin)->format('d M Y') }}</p>
                </div>
                <div class="flex items-center space-x-2">
                    <form action="{{ route('demandes.updateStatus', $demande->id) }}" method="post">
                        @csrf
                        @method('PATCH')
                        <select name="status" class="form-select border rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 mr-2">
                            <option value="en attente" {{ $demande->status == 'en attente' ? 'selected' : '' }}>En attente</option>
                            <option value="informer" {{ $demande->status == 'informer' ? 'selected' : '' }}>Informer</option>
                        </select>
                        <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white py-2 px-4 rounded-md">
                            <i class="fas fa-check"></i>
                        </button>
                    </form>
                    <form action="{{ route('demandes.updateAuthorization', $demande->id) }}" method="post">
                        @csrf
                        @method('PATCH')
                        <select name="autorisation" class="form-select border rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 mr-2">
                            <option value="0" {{ $demande->autorisation == false ? 'selected' : '' }}>Non</option>
                            <option value="1" {{ $demande->autorisation == true ? 'selected' : '' }}>Oui</option>
                        </select>
                        <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white py-2 px-4 rounded-md">
                            <i class="fas fa-check"></i>
                        </button>
                    </form>
                    <form action="{{ route('demandes.destroy', $demande->id) }}" method="post">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger py-2 px-4 bg-red-500 hover:bg-red-600 text-white rounded-md"><i class="fas fa-trash-alt"></i></button>
                    </form>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @else
    <p>Aucune demande d'absence pour hier.</p>
    @endif
</div>
@endsection
