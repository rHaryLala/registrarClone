<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Liste des étudiants - {{ $course->sigle ?? 'Cours' }}</title>
    <style>
        body { font-family: DejaVu Sans, Arial, Helvetica, sans-serif; font-size: 10px; }
        table { border-collapse: collapse; width: 100%; }
        th, td { border: 1px solid #444; padding: 6px; text-align: left; }
        th { background: #f0f0f0; }
        .header { margin-bottom: 12px; }
        .title { font-size: 12px; font-weight: bold; }
    </style>
</head>
<body>
    @php
        // Try to embed a logo from public path for DomPDF compatibility
        $logoPath = public_path('favicon.png');
        $logoData = null;
        if (file_exists($logoPath)) {
            $type = pathinfo($logoPath, PATHINFO_EXTENSION);
            $data = file_get_contents($logoPath);
            $logoData = 'data:image/' . $type . ';base64,' . base64_encode($data);
        }
    @endphp

    <div class="header" style="margin-bottom:14px;">
        <table style="width:100%; border-collapse:collapse;">
            <tr>
                <td style="width:85px; vertical-align:middle;">
                    @if($logoData)
                        <img src="{{ $logoData }}" alt="logo" style="width:72px; height:auto;" />
                    @endif
                </td>
                <td style="text-align:left; vertical-align:middle;">
                    <div style="font-size:16px; font-weight:bold;">{{ $course->sigle ?? '' }}</div>
                    <div style="font-size:14px; font-weight:600; margin-top:4px;">{{ $course->nom ?? '' }}</div>
                    <div style="font-size:12px; margin-top:6px;">Professeur: {{ $course->teacher->name ?? 'Non attribué' }}</div>
                </td>
                <td style="width:140px; text-align:right; vertical-align:middle; font-size:10px;">
                    <div>Date d'export: <br> {{ now()->isoFormat('LL LTS') }}</div>
                </td>
            </tr>
        </table>
        <hr style="border:none; border-top:1px solid #444; margin-top:10px;" />
    </div>

    <table>
        <thead>
            <tr>
                <th>Matricule</th>
                <th>Nom</th>
                <th>Prénom</th>
                <th>Email</th>
                <th>Mention</th>
                <th>Niveau</th>
            </tr>
        </thead>
        <tbody>
            @foreach($course->students as $i => $student)
                <tr>
                    <td>{{ $student->matricule }}</td>
                    <td>{{ $student->nom }}</td>
                    <td>{{ $student->prenom }}</td>
                    <td>{{ $student->email }}</td>
                    <td>{{ optional($student->mention)->nom }}</td>
                    <td>{{ $student->yearLevel ? $student->yearLevel->label : ($student->annee_etude ?? $student->niveau_etude ?? '') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>