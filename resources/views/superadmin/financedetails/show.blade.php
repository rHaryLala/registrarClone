<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Détail finance - Université Adventiste Zurcher</title>
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
        .finance-table th, .finance-table td {
            padding: 0.75rem 1.25rem;
            border-bottom: 1px solid #e5e7eb;
        }
        .finance-table th {
            background: #1e40af;
            color: #fff;
            font-weight: 600;
            width: 260px;
        }
        .finance-table tr:last-child td, .finance-table tr:last-child th {
            border-bottom: none;
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
        .btn-secondary {
            background: #e5e7eb;
            color: #1e40af;
        }
        .btn-secondary:hover {
            background: #c7d2fe;
        }
        .btn-warning {
            background: #fbbf24;
            color: #fff;
        }
        .btn-warning:hover {
            background: #f59e42;
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
                    <i class="fas fa-money-bill-wave"></i> Détail finance
                </h1>
                <table class="finance-table w-full mb-6">
                    <tr><th>Statut étudiant</th><td>{{ ucfirst($detail->statut_etudiant) }}</td></tr>
                    <tr><th>Mention</th><td>{{ $detail->mention ? $detail->mention->nom : '-' }}</td></tr>
                    <tr><th>Frais généraux</th><td>{{ number_format($detail->frais_generaux, 0, ',', ' ') }} Ar</td></tr>
                    <tr><th>Ecolage</th><td>{{ number_format($detail->ecolage, 0, ',', ' ') }} Ar</td></tr>
                    <tr><th>Laboratoire</th><td>{{ number_format($detail->laboratory, 0, ',', ' ') }} Ar</td></tr>
                    <tr><th>Dortoir</th><td>{{ number_format($detail->dortoir, 0, ',', ' ') }} Ar</td></tr>
                    <tr><th>Nb jours semestre</th><td>{{ $detail->nb_jours_semestre }}</td></tr>
                    <tr><th>Nb jours semestre L2</th><td>{{ $detail->nb_jours_semestre_L2 }}</td></tr>
                    <tr><th>Nb jours semestre L3</th><td>{{ $detail->nb_jours_semestre_L3 }}</td></tr>
                    <tr><th>Cafétéria</th><td>{{ number_format($detail->cafeteria, 0, ',', ' ') }} Ar</td></tr>
                    <tr><th>Fond dépôt</th><td>{{ number_format($detail->fond_depot, 0, ',', ' ') }} Ar</td></tr>
                    <tr><th>Frais graduation</th><td>{{ number_format($detail->frais_graduation, 0, ',', ' ') }} Ar</td></tr>
                    <tr><th>Frais costume</th><td>{{ number_format($detail->frais_costume, 0, ',', ' ') }} Ar</td></tr>
                    <tr><th>Frais voyage</th><td>{{ number_format($detail->frais_voyage, 0, ',', ' ') }} Ar</td></tr>
                    <tr><th>Créé le</th><td>{{ $detail->created_at }}</td></tr>
                    <tr><th>Modifié le</th><td>{{ $detail->updated_at }}</td></tr>
                </table>
                <div>
                    <a href="{{ route('superadmin.financedetails.index') }}" class="btn btn-secondary"><i class="fas fa-arrow-left mr-1"></i> Retour</a>
                    <a href="{{ route('superadmin.financedetails.edit', $detail->id) }}" class="btn btn-warning"><i class="fas fa-edit mr-1"></i> Modifier</a>
                </div>
            </div>
        </main>
    </div>
</body>
</html>
