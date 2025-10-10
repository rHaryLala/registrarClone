<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Fiche de présence - {{ optional($mention)->nom ?? 'Liste étudiants' }}</title>
    <style>
        /* Force landscape for PDF generators like Dompdf */
        @page { size: A4 landscape; margin: 10mm; }
        body { font-family: DejaVu Sans, Arial, Helvetica, sans-serif; font-size:11px; color:#222; margin:0 }
        .header { text-align:center; margin-bottom:6px }
        .meta { width:100%; margin-bottom:8px }
        .meta td { padding:3px 6px; vertical-align:top }
    .table { width:100%; border-collapse:collapse; font-size:8px }
    /* Uniform row height: set explicit height, line-height and vertical-align for consistent printed rows */
    .table th, .table td { border:1px solid #444; padding:1px; text-align:left; height:18px; line-height:18px; vertical-align:middle }
    /* date column compact style */
    .date-col { text-align:center; font-size:7.5px; padding:1px; }
    .table th { background:#f3f4f6 }
        .center { text-align:center }
        .small { font-size:10px }
        .notes { margin-top:8px; font-size:10px }
        .mention-title { margin-top:12px; margin-bottom:6px; font-weight:700 }
        .nowrap { white-space:nowrap }
    </style>
</head>
<body>
    <div class="header">
        <h2 style="margin:0">Université Adventiste Zurcher</h2>
        <h3 style="margin:2px 0">Fiche de présence — Exercice de chapelle</h3>
    </div>

    <table class="meta">
        <tr>
            <td><strong>Mention :</strong> {{ optional($mention)->nom ?? (isset($students) ? 'Toutes mentions' : '-') }}</td>
            <td><strong>Année académique :</strong> {{ optional($academicYear)->libelle ?? '-' }}</td>
            <td><strong>Semestre :</strong> {{ optional($semester)->libelle ?? '-' }}</td>
        </tr>
    </table>

    @php
        use Carbon\Carbon;

        // prepare 13 date headers: use $dates if provided and has values, otherwise numbered headers
        $dateHeaders = [];
        if (!empty($dates) && is_array($dates)) {
            $provided = array_slice($dates, 0, 50); // take more in case we drop some specific dates
            foreach ($provided as $d) {
                if (empty($d)) {
                    continue;
                }
                try {
                    $dt = Carbon::parse($d);
                } catch (\Exception $e) {
                    $ts = strtotime($d);
                    if ($ts !== false) {
                        $dt = Carbon::createFromTimestamp($ts);
                    } else {
                        // cannot parse, keep raw and continue
                        $raw = (string) $d;
                        // check textual match against unwanted patterns (01-10-25 / 20-10-25)
                        $shortRaw = preg_replace('/[^0-9-]/', '-', $raw);
                        if (strpos($shortRaw, '27-10-25') !== false || strpos($shortRaw, '01-12-25') !== false) {
                            continue;
                        }
                        $dateHeaders[] = $raw;
                        if (count($dateHeaders) >= 13) break;
                        continue;
                    }
                }

                // exclude 27-10-25 and 01-12-25 regardless of year-format (match day/month/year ending with 25)
                $day = (int) $dt->format('d');
                $month = (int) $dt->format('m');
                $year2 = (int) $dt->format('y');
                if (( $month === 10 && $year2 === 25 && $day === 27 ) || ( $month === 12 && $year2 === 25 && $day === 1 )) {
                    continue; // skip these dates
                }

                $dateHeaders[] = $dt->format('d-m-Y');
                if (count($dateHeaders) >= 13) break;
            }

            // pad if less than 13
            for ($i = count($dateHeaders); $i < 13; $i++) $dateHeaders[] = '';
        } else {
            for ($i = 1; $i <= 13; $i++) $dateHeaders[] = 'Date ' . $i;
        }

        // group students by mention name if $students provided
        $groups = [];
        if (!empty($students)) {
            try {
                $groups = $students->groupBy(function($s){ return optional($s->mention)->nom ?? 'Sans mention'; })->toArray();
            } catch (Exception $e) {
                // fallback: assume it's an array
                $tmp = [];
                foreach($students as $s) {
                    $k = isset($s->mention) ? ($s->mention->nom ?? 'Sans mention') : (is_array($s) && isset($s['mention_nom']) ? $s['mention_nom'] : 'Sans mention');
                    $tmp[$k][] = $s;
                }
                $groups = $tmp;
            }
        }
    @endphp

    @if(empty($groups))
        <div class="small">Aucun étudiant trouvé pour les critères sélectionnés.</div>
    @else
        @foreach($groups as $mentionName => $studentsForMention)
            <div class="mention-title">Mention : {{ $mentionName }} — Total étudiants : {{ count($studentsForMention) }}</div>

            <table class="table">
                <thead>
                    <tr>
                        <th style="width:8%">Matricule</th>
                        <th style="width:44%">Nom et prénom</th>
                        @foreach($dateHeaders as $dh)
                            <th class="center nowrap date-col" style="width:2.2%">{{ $dh }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @foreach($studentsForMention as $idx => $st)
                        <tr>
                            <td class="nowrap">{{ is_object($st) ? ($st->matricule ?? '-') : ($st['matricule'] ?? '-') }}</td>
                            <td>{{ is_object($st) ? trim((($st->nom ?? '') . ' ' . ($st->prenom ?? ''))) : trim((($st['nom'] ?? '') . ' ' . ($st['prenom'] ?? ''))) }}</td>
                            @for($c = 0; $c < 13; $c++)
                                <td></td>
                            @endfor
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div style="page-break-after:always"></div>
        @endforeach
    @endif

    <div class="notes">
        <strong>Remarques :</strong>
        <ul>
            <li>Conserver une copie papier au dossier de l'enseignant.</li>
            <li>Cette fiche ne remplace pas le registre officiel de l'établissement.</li>
        </ul>
    </div>
</body>
</html>
