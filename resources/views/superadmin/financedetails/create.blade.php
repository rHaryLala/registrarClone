@extends('superadmin.layout')
@section('content')
<div class="container">
    <h1>Ajouter un détail finance</h1>
    <form action="{{ route('superadmin.financedetails.store') }}" method="POST">
        @csrf
        <!-- ...existing form fields... -->
        <button type="submit" class="btn btn-success">Enregistrer</button>
        <a href="{{ route('superadmin.financedetails.index') }}" class="btn btn-secondary">Annuler</a>
    </form>
</div>
@endsection
