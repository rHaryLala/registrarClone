<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Liste des étudiants</title>
    <style>
        body { font-family: Arial, Helvetica, sans-serif; font-size:9px; color:#222 }
        .header { text-align:center; margin-bottom:12px }
        table { width:100%; border-collapse:collapse; margin-top:10px }
        th, td { border:1px solid #ddd; padding:2px 8px; text-align:left }
        th { background:#f3f4f6; font-weight:700 }
    </style>
</head>
<body>
    @include('partials.pdf-header')
    <div class="header">
        <h2>Liste des étudiants</h2>
    </div>


    @if(isset($grouped) && $grouped)
        @php $sectionIndex = 0; @endphp
        @foreach($grouped as $mentionName => $studentsList)
            <h3 style="margin-top:18px; margin-bottom:6px; font-size:14px; font-weight:700; border-top:1px solid #ccc; padding-top:8px;">Mention: {{ $mentionName }} ({{ $studentsList->count() }})</h3>
            <table>
                <thead>
                    <tr>
                        <th style="width:10%">Matricule</th>
                        <th style="width:38%">Nom et Prénom</th>
                        <th style="width:15%">Niveau</th>
                        @php $extraCols = $fields ?? []; @endphp
                        @if(in_array('email', $extraCols))
                            <th style="width:20%">Email</th>
                        @endif
                        @if(in_array('plain_password', $extraCols))
                            <th style="width:12%">Mot de passe</th>
                        @endif
                        @if(in_array('telephone', $extraCols))
                            <th style="width:12%">Téléphone</th>
                        @endif
                        @if(in_array('religion', $extraCols))
                            <th style="width:12%">Religion</th>
                        @endif
                        @if(in_array('abonne_caf', $extraCols))
                            <th style="width:8%">Cantine</th>
                        @endif
                        @if(in_array('statut_interne', $extraCols))
                            <th style="width:8%">Résidence</th>
                        @endif
                        @if(in_array('taille', $extraCols))
                            <th style="width:8%">Taille</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @php
                        $sorted = $studentsList->sortBy('matricule')->values();
                    @endphp
                    @foreach($sorted as $s)
                        <tr>
                            <td>{{ $s->matricule ?? '' }}</td>
                            <td>{{ trim(($s->nom ?? '') . ' ' . ($s->prenom ?? '')) }}</td>
                            <td>
                                @php
                                    $lvl = optional($s->yearLevel)->label ?? ($s->year_level_id ?? '');
                                    if (is_string($lvl)) {
                                        $lvl = preg_replace('/\s*\(.*\)$/', '', $lvl);
                                    }
                                @endphp
                                {{ $lvl }}
                            </td>
                            @php $ec = $extraCols ?? []; @endphp
                            @if(in_array('email', $ec))
                                <td>{{ $s->email ?? '' }}</td>
                            @endif
                            @if(in_array('plain_password', $ec))
                                <td>{{ $s->plain_password ?? '' }}</td>
                            @endif
                            @if(in_array('telephone', $ec))
                                <td>{{ $s->telephone ?? '' }}</td>
                            @endif
                            @if(in_array('religion', $ec))
                                <td>{{ $s->religion ?? '' }}</td>
                            @endif
                            @if(in_array('abonne_caf', $ec))
                                <td>{{ ($s->abonne_caf) ? 'Oui' : 'Non' }}</td>
                            @endif
                            @if(in_array('statut_interne', $ec))
                                <td>{{ $s->statut_interne ?? '' }}</td>
                            @endif
                            @if(in_array('taille', $ec))
                                <td>{{ $s->taille ?? '' }}</td>
                            @endif
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endforeach
    @else
        @php $extraCols = $fields ?? []; @endphp
        <table>
            <thead>
                <tr>
                    <th style="width:16%">Matricule</th>
                    <th style="width:38%">Nom et Prénom</th>
                    <th style="width:15%">Niveau</th>
                    @if(in_array('email', $extraCols))
                        <th style="width:20%">Email</th>
                    @endif
                    @if(in_array('plain_password', $extraCols))
                        <th style="width:12%">Mot de passe</th>
                    @endif
                    @if(in_array('telephone', $extraCols))
                        <th style="width:12%">Téléphone</th>
                    @endif
                    @if(in_array('religion', $extraCols))
                        <th style="width:12%">Religion</th>
                    @endif
                    @if(in_array('abonne_caf', $extraCols))
                        <th style="width:8%">Abonné CAF</th>
                    @endif
                    @if(in_array('statut_interne', $extraCols))
                        <th style="width:8%">Résidence</th>
                    @endif
                    @if(in_array('taille', $extraCols))
                        <th style="width:6%">Taille</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @foreach($students->sortBy('matricule')->values() as $s)
                    <tr>
                        <td>{{ $s->matricule ?? '' }}</td>
                        <td>{{ trim(($s->nom ?? '') . ' ' . ($s->prenom ?? '')) }}</td>
                        <td>
                            @php
                                $lvl = optional($s->yearLevel)->label ?? ($s->year_level_id ?? '');
                                if (is_string($lvl)) {
                                    $lvl = preg_replace('/\s*\(.*\)$/', '', $lvl);
                                }
                            @endphp
                            {{ $lvl }}
                        </td>
                        @php $ec = $extraCols ?? []; @endphp
                        @if(in_array('email', $ec))
                            <td>{{ $s->email ?? '' }}</td>
                        @endif
                        @if(in_array('plain_password', $ec))
                            <td>{{ $s->plain_password ?? '' }}</td>
                        @endif
                        @if(in_array('telephone', $ec))
                            <td>{{ $s->telephone ?? '' }}</td>
                        @endif
                        @if(in_array('religion', $ec))
                            <td>{{ $s->religion ?? '' }}</td>
                        @endif
                        @if(in_array('abonne_caf', $ec))
                            <td>{{ ($s->abonne_caf) ? 'Oui' : 'Non' }}</td>
                        @endif
                        @if(in_array('statut_interne', $ec))
                            <td>{{ $s->statut_interne ?? '' }}</td>
                        @endif
                        @if(in_array('taille', $ec))
                            <td>{{ $s->taille ?? '' }}</td>
                        @endif
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    @php
        // Calculer le total d'étudiants affichés
        if(isset($grouped) && $grouped) {
            $total = 0;
            foreach($grouped as $studentsList) {
                $total += $studentsList->count();
            }
        } else {
            // $students peut être une Collection ou un tableau
            if(isset($students) && is_object($students) && method_exists($students, 'count')) {
                $total = $students->count();
            } elseif(isset($students) && is_array($students)) {
                $total = count($students);
            } else {
                $total = 0;
            }
        }

        // Nom de l'utilisateur qui a exporté (utilise Auth si disponible)
        $exporter = optional(auth()->user())->name ?? (optional(auth()->user())->username ?? 'Utilisateur inconnu');
    @endphp

    <div style="margin-top:12px; text-align:left; font-size:12px;">
        <strong>Arrêté au nombre total :</strong> {{ $total }} étudiant{{ $total > 1 ? 's' : '' }}
    </div>

    <footer style="position: fixed; bottom: 0; left: 0; right: 0; font-size:11px; color:#555; border-top:1px solid #ccc; padding:6px 8px; text-align:right; background: white;">
        Exporté par : {{ $exporter }} — le {{ now()->format('d/m/Y H:i') }}
    </footer>
</body>
</html>