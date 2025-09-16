@extends('superadmin.layout')
@section('content')
<main class="p-6 max-w-xl mx-auto">
    <h1 class="text-2xl font-bold mb-6">Modifier la finance</h1>
    <div class="bg-white shadow rounded-lg p-8">
        <form action="{{ route('superadmin.finances.update', $finance->id) }}" method="POST">
            @csrf @method('PUT')
            <div class="mb-4">
                <label class="block font-semibold mb-2">Étudiant</label>
                <select name="student_id" class="w-full border rounded-lg px-3 py-2" required>
                    @foreach($students as $student)
                        <option value="{{ $student->id }}" @if($finance->student_id == $student->id) selected @endif>
                            {{ $student->prenom }} {{ $student->nom }} ({{ $student->matricule }})
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="mb-4">
                <label class="block font-semibold mb-2">Type</label>
                <input type="text" name="type" class="w-full border rounded-lg px-3 py-2" value="{{ $finance->type }}" required>
            </div>
            <div class="mb-4">
                <label class="block font-semibold mb-2">Montant</label>
                <input type="number" name="montant" step="0.01" class="w-full border rounded-lg px-3 py-2" value="{{ $finance->montant }}" required>
            </div>
            <div class="mb-4">
                <label class="block font-semibold mb-2">Statut</label>
                <select name="status" class="w-full border rounded-lg px-3 py-2" required>
                    <option value="pending" @if($finance->status=='pending') selected @endif>En attente</option>
                    <option value="paid" @if($finance->status=='paid') selected @endif>Payé</option>
                    <option value="overdue" @if($finance->status=='overdue') selected @endif>Retard</option>
                </select>
            </div>
            <div class="mb-4">
                <label class="block font-semibold mb-2">Cours (optionnel)</label>
                <select name="course_id" class="w-full border rounded-lg px-3 py-2">
                    <option value="">Aucun</option>
                    @foreach($courses as $course)
                        <option value="{{ $course->id }}" @if($finance->course_id == $course->id) selected @endif>
                            {{ $course->sigle }} - {{ $course->nom }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="mb-4">
                <label class="block font-semibold mb-2">Description</label>
                <textarea name="description" class="w-full border rounded-lg px-3 py-2">{{ $finance->description }}</textarea>
            </div>
            <div class="flex justify-end">
                <button type="submit" class="bg-blue-700 text-white px-6 py-2 rounded-lg hover:bg-blue-800">Enregistrer</button>
            </div>
        </form>
    </div>
</main>
@endsection
