@extends('superadmin.layout')
@section('content')
<div class="container">
    <h1>Détail finance</h1>
    <table class="table table-bordered">
        <!-- ...existing fields... -->
    </table>
    <a href="{{ route('superadmin.financedetails.index') }}" class="btn btn-secondary">Retour</a>
    <a href="{{ route('superadmin.financedetails.edit', $detail->id) }}" class="btn btn-warning">Modifier</a>
</div>
@endsection
