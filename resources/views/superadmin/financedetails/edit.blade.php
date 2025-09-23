<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier un détail finance - Université Adventiste Zurcher</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link href="https://fonts.googleapis.com/css2?family=Work+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { font-family: 'Work Sans', sans-serif; background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);}
        .main-content { margin-left: 260px; }
        .finance-card {
            background: rgba(255,255,255,0.97);
            border-radius: 16px;
            box-shadow: 0 8px 32px rgba(0,0,0,0.08);
            padding: 2rem;
            margin-top: 2rem;
            max-width: 700px;
            margin-left: auto;
            margin-right: auto;
        }
        .form-label {
            font-weight: 500;
            color: #1e40af;
        }
        .form-control, select {
            width: 100%;
            padding: 0.5rem 1rem;
            border-radius: 8px;
            border: 1px solid #cbd5e1;
            margin-bottom: 1rem;
            font-size: 1rem;
        }
        .btn {
            display: inline-block;
            padding: 0.5rem 1.25rem;
            border-radius: 8px;
            font-weight: 500;
            text-decoration: none;
            margin-right: 0.5rem;
            transition: background 0.2s;
        }
        .btn-success {
            background: #10b981;
            color: #fff;
        }
        .btn-success:hover {
            background: #059669;
        }
        .btn-secondary {
            background: #e5e7eb;
            color: #1e40af;
        }
        .btn-secondary:hover {
            background: #c7d2fe;
        }
    </style>
</head>
<body>
    @include('superadmin.components.sidebar')
    <div class="main-content min-h-screen">
        @include('superadmin.components.header')
        <main class="p-6">
            <div class="finance-card">
                <h1 class="text-2xl font-bold mb-6 text-blue-900 flex items-center gap-2">
                    <i class="fas fa-edit"></i> Modifier un détail finance
                </h1>
                <form action="{{ route('superadmin.financedetails.update', $detail->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <label class="form-label">Statut étudiant</label>
                    <select name="statut_etudiant" class="form-control" required>
                        <option value="interne" @if($detail->statut_etudiant=='interne') selected @endif>Interne</option>
                        <option value="externe" @if($detail->statut_etudiant=='externe') selected @endif>Externe</option>
                        <option value="bungalow" @if($detail->statut_etudiant=='bungalow') selected @endif>Bungalow</option>
                    </select>
                    <label class="form-label">Mention</label>
                    <select name="mention_id" class="form-control">
                        <option value="">--</option>
                        @foreach($mentions as $mention)
                            <option value="{{ $mention->id }}" @if($detail->mention_id==$mention->id) selected @endif>{{ $mention->nom }}</option>
                        @endforeach
                    </select>
                    <label class="form-label">Frais généraux</label>
                    <input type="number" name="frais_generaux" class="form-control" value="{{ $detail->frais_generaux }}" required>
                    <label class="form-label">Ecolage</label>
                    <input type="number" name="ecolage" class="form-control" value="{{ $detail->ecolage }}" required>
                    <label class="form-label">Laboratoire</label>
                    <input type="number" name="laboratory" class="form-control" value="{{ $detail->laboratory }}" required>
                    <label class="form-label">Dortoir</label>
                    <input type="number" name="dortoir" class="form-control" value="{{ $detail->dortoir }}" required>
                    <label class="form-label">Nb jours semestre</label>
                    <input type="number" name="nb_jours_semestre" class="form-control" value="{{ $detail->nb_jours_semestre }}">
                    <label class="form-label">Nb jours semestre L2</label>
                    <input type="number" name="nb_jours_semestre_L2" class="form-control" value="{{ $detail->nb_jours_semestre_L2 }}">
                    <label class="form-label">Nb jours semestre L3</label>
                    <input type="number" name="nb_jours_semestre_L3" class="form-control" value="{{ $detail->nb_jours_semestre_L3 }}">
                    <label class="form-label">Cafétéria</label>
                    <input type="number" name="cafeteria" class="form-control" value="{{ $detail->cafeteria }}" required>
                    <label class="form-label">Fond dépôt</label>
                    <input type="number" name="fond_depot" class="form-control" value="{{ $detail->fond_depot }}" required>
                    <label class="form-label">Frais graduation</label>
                    <input type="number" name="frais_graduation" class="form-control" value="{{ $detail->frais_graduation }}" required>
                    <label class="form-label">Frais costume</label>
                    <input type="number" name="frais_costume" class="form-control" value="{{ $detail->frais_costume }}" required>
                    <label class="form-label">Frais voyage</label>
                    <input type="number" name="frais_voyage" class="form-control" value="{{ $detail->frais_voyage }}" required>
                    <div class="mt-4">
                        <button type="submit" class="btn btn-success"><i class="fas fa-save mr-1"></i> Mettre à jour</button>
                        <a href="{{ route('superadmin.financedetails.index') }}" class="btn btn-secondary"><i class="fas fa-arrow-left mr-1"></i> Annuler</a>
                    </div>
                </form>
            </div>
        </main>
    </div>
</body>
</html>
