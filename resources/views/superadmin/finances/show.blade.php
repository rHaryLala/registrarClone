@extends('superadmin.layout')
@section('content')
<main class="p-6 max-w-xl mx-auto">
    <h1 class="text-2xl font-bold mb-6">Détail de la finance</h1>
    <div class="bg-white shadow rounded-lg p-8">
        <p><strong>Étudiant :</strong> {{ $finance->student->prenom ?? '' }} {{ $finance->student->nom ?? '' }}</p>
        <p><strong>Type :</strong> {{ $finance->type }}</p>
        <p><strong>Montant :</strong> {{ number_format($finance->montant, 2) }} Ar</p>
        <p><strong>Statut :</strong> {{ $finance->status }}</p>
        <p><strong>Cours :</strong> {{ $finance->course->nom ?? '-' }}</p>
        <p><strong>Description :</strong> {{ $finance->description }}</p>
        @if($finance->extra)
            <p><strong>Extra :</strong> {{ json_encode($finance->extra) }}</p>
        @endif
        <div class="mt-4 flex space-x-2">
            <a href="{{ route('superadmin.finances.edit', $finance->id) }}" class="bg-yellow-500 text-white px-4 py-2 rounded-lg hover:bg-yellow-600">Modifier</a>
            <a href="{{ route('superadmin.finances.list') }}" class="bg-gray-300 text-gray-800 px-4 py-2 rounded-lg hover:bg-gray-400">Retour</a>
        </div>
    </div>
</main>
@endsection
