<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Access Codes</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #ccc; padding: 6px 8px; text-align: left; }
        th { background: #f5f5f5; }
    </style>
</head>
<body>
    <h2>Liste des Access Codes</h2>
    <table>
        <thead>
            <tr>
                <th>Code</th>
                <th>Actif</th>
                <th>Créé le</th>
            </tr>
        </thead>
        <tbody>
            @foreach($codes as $c)
            <tr>
                <td>{{ $c->code }}</td>
                <td>{{ $c->is_active ? 'Oui' : 'Non' }}</td>
                <td>{{ \Carbon\Carbon::parse($c->created_at)->format('d/m/Y H:i') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>