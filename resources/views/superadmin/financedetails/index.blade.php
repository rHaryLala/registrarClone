@extends('superadmin.layout')
@section('content')
<div class="container">
    <h1>Détails Finance</h1>
    <a href="{{ route('superadmin.financedetails.create') }}" class="btn btn-primary mb-3">Ajouter</a>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Statut</th>
                <th>Mention</th>
                <th>Frais généraux</th>
                <th>Ecolage</th>
                <th>Laboratoire</th>
                <th>Dortoir</th>
                <th>Cafétéria</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($details as $detail)
            <tr>
                <td>{{ ucfirst($detail->statut_etudiant) }}</td>
                <td>{{ $detail->mention ? $detail->mention->nom : '-' }}</td>
                <td>{{ number_format($detail->frais_generaux, 0, ',', ' ') }}</td>
                <td>{{ number_format($detail->ecolage, 0, ',', ' ') }}</td>
                <td>{{ number_format($detail->laboratory, 0, ',', ' ') }}</td>
                <td>{{ number_format($detail->dortoir, 0, ',', ' ') }}</td>
                <td>{{ number_format($detail->cafeteria, 0, ',', ' ') }}</td>
                <td>
                    <a href="{{ route('superadmin.financedetails.show', $detail->id) }}" class="btn btn-info btn-sm">Voir</a>
                    <a href="{{ route('superadmin.financedetails.edit', $detail->id) }}" class="btn btn-warning btn-sm">Modifier</a>
                    <form action="{{ route('superadmin.financedetails.destroy', $detail->id) }}" method="POST" style="display:inline-block">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Supprimer ?')">Supprimer</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
