@extends('superadmin.layout')
@section('content')
<div class="container">
    <h1>Modifier un détail finance</h1>
    <form action="{{ route('superadmin.financedetails.update', $detail->id) }}" method="POST">
        @csrf @method('PUT')
        <!-- ...existing form fields... -->
        <button type="submit" class="btn btn-success">Mettre à jour</button>
        <a href="{{ route('superadmin.financedetails.index') }}" class="btn btn-secondary">Annuler</a>
    </form>
</div>
@endsection
