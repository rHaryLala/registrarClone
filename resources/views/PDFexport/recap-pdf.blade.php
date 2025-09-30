<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Fiche d'inscription - {{ $student->prenom }} {{ $student->nom }}</title>
    @include('layouts.pdf-style')
</head>
<body>
<!-- HEADER UAZ -->
<table style="width: 100%; color : black; border-bottom: 1px solid #8e9bb2;">
    <tr>
        <td style="width: 20%;"><img src="{{ public_path('favicon.png') }}" style="height: 100px;"></td>
        <td style="width: 60%; text-align: center;">
            <p>UNIVERSITÉ ADVENTISTE ZURCHER</p>
            <b>BUREAU DES AFFAIRES ACADÉMIQUES</b>
            <p class="text-xs">BP 325, Antsirabe 110, MADAGASCAR 
                <br>Tél : 034 18 810 86 / 034 46 000 08 / 034 38 180 81 
                <br> Email : registraroffice@zurcher.edu.mg 
                <br>
                <span style="font-style: italic; font-family: 'Old English Text MT', 'Gothic', cursive, serif;">
                    "Préparer aujourd'hui les leaders de demain"
                </span>
            </p>
        </td>
        <td style="width: 20%;"></td>
    </tr>
</table>
<!-- END HEADER UAZ -->
<div class="col-lg-8">
    <div class="head">
        <center>
            <div>
                <h2>Fiche d'inscription {{ $student->created_at->format('Y') }} - {{ $student->created_at->format('Y')+1 }} <br>Premier semestre</h2>
            </div>
        </center>
    </div>
    <div class="inline">
        <div class="infotitre">
            <b>INFORMATIONS</b>
        </div>
        <div class="informationbox">
            <table style="width:100%;">
                <tr>
                    <td style="width:80%; vertical-align:top; font-size:9px; line-height:1.25;">
                        <table style="width:100%; border-collapse: collapse;">
                            <tr>
                                <td style="width:40%; vertical-align:top; padding-right:8px;">
                                    <div style="margin-bottom:4px;"><b>Matricule :</b> {{ $student->matricule }}</div>
                                    <div style="margin-bottom:4px;"><b>N° de compte :</b> {{ $student->account_code }}</div>
                                    <div style="margin-bottom:4px;"><b>Nom :</b> {{ $student->nom }} {{ $student->prenom }}</div>
                                    <div style="margin-bottom:4px;"><b>Mention :</b> {{ $student->mention ? $student->mention->nom : '-' }}</div>
                                    <div style="margin-bottom:4px;"><b>Parcours :</b> {{ $student->parcours ? $student->parcours->nom : '-' }}</div>
                                    <div style="margin-bottom:4px;"><b>Niveau d'étude :</b> {{ $student->yearLevel ? $student->yearLevel->label : ($student->annee_etude ?? '-') }}</div>
                                </td>
                                <td style="width:60%; vertical-align:top;">
                                    <div style="margin-bottom:4px;"><b>Email / Tél:</b> {{ $student->email }} / {{ $student->telephone }}</div>
                                    <div style="margin-bottom:4px;"><b>Adresse :</b> {{ $student->adresse }}</div>
                                    <div><b>Résidence :</b> {{ $student->statut_interne }}</div>
                                </td>
                            </tr>
                        </table>
                    </td>
                    <td style="width:20%; text-align:right; vertical-align:top;">
                        @if($student->image)
                            <img src="{{ public_path($student->image) }}"
                                 alt="Photo de profil"
                                 style="width: 100px; height: 100px; object-fit: cover; border-radius: 8px; border: 1px solid #aaa; margin-top: 1px; margin-right: 10px; display: inline-block;">
                        @else
                            <div style="width: 100px; height: 100px; background: #eaeaea; border-radius: 8px; border: 1px solid #aaa; display: flex; align-items: center; justify-content: center; color: #888; font-size: 32px; margin-top: -6px; margin-right: 10px;">
                                
                            </div>
                        @endif
                    </td>
                </tr>
            </table>
        </div>
        <center>
            <h3 style="text-align: left">LISTE DES COURS</h3>
        </center>
        <div style="min-height: 300px;">
            @php
                // Load taken courses once and compute totals.
                $takenCourses = $student->courses()->wherePivot('deleted_at', null)->with('yearLevels')->get();
                $totalCredits = 0; // credits counted towards the main credit total (excludes L1R-only courses)
                $l1r_cost = 0; // monetary cost for courses that belong only to L1R
                $laboCount = 0;

                foreach($takenCourses as $course) {
                    $codes = $course->yearLevels->pluck('code')->map(function($c){ return strtoupper($c); })->filter()->values()->toArray();
                    // If the course is attached only to L1R (all year codes are L1R), treat specially
                    if(count($codes) > 0 && collect($codes)->unique()->count() === 1 && strtoupper($codes[0]) === 'L1R') {
                        $l1r_cost += ($course->credits * 19000);
                    } else {
                        $totalCredits += $course->credits;
                    }
                    if ($course->labo_info) $laboCount++;
                }

            @endphp

            <div class="informationbox col-lg-12" style="border-radius: 0px;">
                <table class="tbl">
                    <thead>
                        <tr>
                            <th>SIGLE</th>
                            <th>TITRE DU COURS</th>
                            <th>CREDITS</th>
                            <th>Catégorie</th>
                            <th>Prix</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($takenCourses as $course)
                            @php
                                $codes = $course->yearLevels->pluck('code')->map(function($c){ return strtoupper($c); })->filter()->values()->toArray();
                                $isOnlyL1R = (count($codes) > 0 && collect($codes)->unique()->count() === 1 && strtoupper($codes[0]) === 'L1R');
                            @endphp
                            <tr>
                                <td>{{ $course->sigle }}</td>
                                <td>{{ $course->nom }}</td>
                                <td>
                                    @if($isOnlyL1R)
                                        -
                                    @else
                                        {{ $course->credits }}
                                    @endif
                                </td>
                                <td>
                                    {{ $course->categorie ?? '-' }}
                                </td>
                                <td>
                                    {{ number_format($course->credits * 19000, 0, ',', ' ') }} Ar
                                </td>
                            </tr>
                        @endforeach
                        <tr>
                            <td class="marck">Cours : {{ $takenCourses->count() }}</td>
                            <td></td>
                            <td class="marck">{{ $totalCredits }}</td>
                            <td></td>
                            <td></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <br>
            <!-- Tableau Finance adapté ici -->
            <div  style="border-radius: 0px; margin-bottom: 15px;">
                @php
                    // Read values directly from StudentSemesterFee (no calculation in the view)
                    // Try to find the SSF that matches the student's current academic_year_id/semester_id.
                    // If that fails (e.g. student record hasn't the same semester as the computed SSF),
                    // fall back to the latest computed SSF for this student.
                    $ssf = null;
                    if(isset($student->academic_year_id) && isset($student->semester_id)) {
                        $ssf = \App\Models\StudentSemesterFee::where('student_id', $student->id)
                            ->where('academic_year_id', $student->academic_year_id)
                            ->where('semester_id', $student->semester_id)
                            ->first();
                    }

                    if(! $ssf) {
                        // Fallback: pick the most recently computed SSF for the student.
                        $ssf = \App\Models\StudentSemesterFee::where('student_id', $student->id)
                            ->orderByDesc('computed_at')
                            ->orderByDesc('updated_at')
                            ->first();
                    }

                    // When SSF exists, prefer its fields. Otherwise default to zero (we no longer compute from courses here).
                    $fraisGeneraux = $ssf ? (float) ($ssf->frais_generaux ?? 0) : 0.0;
                    $coutCredit = $ssf ? (float) ($ssf->ecolage ?? 0) : 0.0;
                    $coutDortoir = $ssf ? (float) ($ssf->dortoir ?? 0) : 0.0;
                    $coutCantine = $ssf ? (float) ($ssf->cantine ?? 0) : 0.0;
                    $labo_info_only = $ssf ? (float) ($ssf->labo_info ?? 0) : 0.0;
                    $labo_comm_only = $ssf ? (float) ($ssf->labo_comm ?? 0) : 0.0;
                    $labo_lang_only = $ssf ? (float) ($ssf->labo_langue ?? 0) : 0.0;
                    $labo_info = $labo_info_only + $labo_comm_only + $labo_lang_only;
                    $voyage_etude = $ssf ? (float) ($ssf->voyage_etude ?? 0) : 0.0;
                    $colloque = $ssf ? (float) ($ssf->colloque ?? 0) : 0.0;
                    $costume = $ssf ? (float) ($ssf->frais_costume ?? 0) : 0.0;
                    $totalFinance = $ssf ? (float) ($ssf->total_amount ?? 0) : 0.0;

                    // Subtotals derived from persisted fields only
                    $subtotal1 = $fraisGeneraux + $coutCredit + $labo_info + $coutDortoir + $coutCantine;
                    $voyage_or_colloque = ($colloque && $colloque > 0) ? $colloque : $voyage_etude;
                    $subtotal2 = $voyage_or_colloque + $costume;

                    // Determine payment mode (plan) from latest finance row for this student (by matricule)
                    $modeP = \App\Models\Finance::where('student_id', $student->matricule)
                        ->orderByDesc('date_entry')
                        ->value('plan') ?? 'A';

                    // Montant sans frais généraux = montant total à payer (persisted) - fraisGeneraux
                    $Montant_sans_frais_Generaux = max(0, $totalFinance - $fraisGeneraux);

                    // Detect if we should show the 'Costume' column: only for mention 'théologie'
                    $mentionName = isset($student->mention->nom) ? $student->mention->nom : '';
                    // Normalize accents without relying on iconv
                    $map = [
                        'À'=>'A','Á'=>'A','Â'=>'A','Ã'=>'A','Ä'=>'A','Å'=>'A','Æ'=>'AE',
                        'Ç'=>'C','È'=>'E','É'=>'E','Ê'=>'E','Ë'=>'E','Ì'=>'I','Í'=>'I',
                        'Î'=>'I','Ï'=>'I','Ð'=>'D','Ñ'=>'N','Ò'=>'O','Ó'=>'O','Ô'=>'O',
                        'Õ'=>'O','Ö'=>'O','Ø'=>'O','Ù'=>'U','Ú'=>'U','Û'=>'U','Ü'=>'U',
                        'Ý'=>'Y','Þ'=>'P','ß'=>'ss','à'=>'a','á'=>'a','â'=>'a','ã'=>'a',
                        'ä'=>'a','å'=>'a','æ'=>'ae','ç'=>'c','è'=>'e','é'=>'e','ê'=>'e',
                        'ë'=>'e','ì'=>'i','í'=>'i','î'=>'i','ï'=>'i','ð'=>'d','ñ'=>'n',
                        'ò'=>'o','ó'=>'o','ô'=>'o','õ'=>'o','ö'=>'o','ø'=>'o','ù'=>'u',
                        'ú'=>'u','û'=>'u','ü'=>'u','ý'=>'y','þ'=>'p','ÿ'=>'y'
                    ];
                    $mentionAscii = strtolower(strtr($mentionName, $map));
                    $showCostume = (strpos($mentionAscii, 'theolog') !== false);
                @endphp

                <div style="display:flex; gap:24px;">
                    <!-- Part 1 -->
                    <div style="flex:1; padding:6px;">
                        <table class="tbl">
                            <thead>
                                <tr>
                                    <th>Frais généraux</th>
                                    <th>Écolage</th>
                                    <th>Laboratoire (Info)</th>
                                    @if(isset($student->statut_interne) && $student->statut_interne)
                                        <th>Dortoir</th>
                                    @endif
                                    @if(isset($student->abonne_caf) && $student->abonne_caf)
                                        <th>Cantine</th>
                                    @endif
                                    <th>Sous-total</th>
                                    <th>Mode de paiement</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>{{ number_format($fraisGeneraux ?? 0, 0, ',', ' ') }} Ar</td>
                                    <td>{{ number_format($coutCredit ?? 0, 0, ',', ' ') }} Ar</td>
                                    <td>{{ number_format($labo_info ?? 0, 0, ',', ' ') }} Ar</td>
                                    @if(isset($student->statut_interne) && $student->statut_interne)
                                        <td>{{ number_format($coutDortoir ?? 0, 0, ',', ' ') }} Ar</td>
                                    @endif
                                    @if(isset($student->abonne_caf) && $student->abonne_caf)
                                        <td>{{ number_format($coutCantine ?? 0, 0, ',', ' ') }} Ar</td>
                                    @endif
                                    <td><strong><span>{{ number_format($subtotal1, 0, ',', ' ') }} Ar</span></strong></td>
                                    <td style="text-align:center;"><strong><span>{{ $modeP ?? 'A' }}</span></strong></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- Part 2 -->
                    <div style="flex:1; padding:6px;">
                        <table class="tbl">
                            <thead>
                                <tr>
                                    <th>Voyage d'étude / Colloque</th>
                                    @if($showCostume)
                                        <th>Costume</th>
                                    @endif
                                    <th>Sous-total</th>
                                    <th>Plan de paiement</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>{{ number_format($voyage_or_colloque ?? 0, 0, ',', ' ') }} Ar</td>
                                            @if($showCostume)
                                                <td>{{ number_format($costume ?? 0, 0, ',', ' ') }} Ar</td>
                                            @endif
                                    <td><strong><span>{{ number_format($subtotal2, 0, ',', ' ') }} Ar</span></strong></td>
                                    <td><strong><span>à payer pendant le semestre</span></strong></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- Fin tableau Finance -->
            <div style="text-align:left; font-size:15px; font-weight:bold; margin-bottom:10px;">
                Montant total : {{ number_format($totalFinance, 0, ',', ' ') }} Ar <span style="font-style: italic; font-size: 10px;">(à payer lors de l'inscription : {{ number_format($fraisGeneraux, 0, ',', ' ') }} Ar)</span>
            </div>
            <table style="width:100%; border-collapse:collapse; margin-bottom:10px;">
            <tr>
                <!-- Colonne gauche -->
                <td style="width:30%; padding:1px; min-height:120px; font-size:8px; vertical-align:top;">
                @php
                    // Montant sans frais généraux = montant total à payer (totalFinance) - fraisGeneraux
                    $Montant_sans_frais_Generaux = ($totalFinance ?? 0) - ($fraisGeneraux ?? 0) - ($costume ?? 0) - ($voyage_or_colloque ?? 0);
                @endphp

                <div style="width:100%;">
                    @if(!empty($student->bursary_status) && ($student->bursary_status == 1 || $student->bursary_status === true))
                            <p style="margin:0 0 8px 0; font-size:3em; line-height:1;"><strong>Boursier par {{ trim(($student->sponsor_nom ?? '') . ' ' . ($student->sponsor_prenom ?? '')) ?: '—' }}</strong></p>
                    @else
                        <b class="text-xl">Mode de paiement</b>
                        <table class="tbl mb-2 payment-table">
                            <thead>
                                <tr>
                                    <th colspan="3" class="text-center text-bold">Ecolage + Labo + Dortoir + Cantine</th>
                                </tr>
                                <tr>
                                    <th colspan="3" class="text-center text-bold">À payer en tranches de TYPE {{ $modeP }} : {{ number_format($Montant_sans_frais_Generaux, 0, ',', ' ') }} ar </th>
                                </tr>
                            </thead>
                            <tbody>
                                @if($modeP === 'A')
                                    <tr>
                                        <td>100 %</td>
                                        <td class="text-right">{{ number_format($Montant_sans_frais_Generaux, 0, ',', ' ') }} ar</td>
                                        <td><input type="text" class="date-input" value="3-oct.-25"></td>
                                    </tr>
                                @elseif($modeP === 'B')
                                    <tr>
                                        <td>50 %</td>
                                        <td class="text-right">{{ number_format(($Montant_sans_frais_Generaux * 50) / 100, 0, ',', ' ') }} ar</td>
                                        <td><input type="text" class="date-input" value="3-oct.-25"></td>
                                    </tr>
                                    <tr>
                                        <td>50 %</td>
                                        <td class="text-right">{{ number_format(($Montant_sans_frais_Generaux * 50) / 100, 0, ',', ' ') }} ar</td>
                                        <td><input type="text" class="date-input" value="30-janv.-26"></td>
                                    </tr>
                                @elseif($modeP === 'C')
                                    <tr>
                                        <td>50 %</td>
                                        <td class="text-right">{{ number_format(($Montant_sans_frais_Generaux * 50) / 100, 0, ',', ' ') }} ar</td>
                                        <td><input type="text" class="date-input" value="3-oct.-25"></td>
                                    </tr>
                                    <tr>
                                        <td>25 %</td>
                                        <td class="text-right">{{ number_format(($Montant_sans_frais_Generaux * 25) / 100, 0, ',', ' ') }} ar</td>
                                        <td><input type="text" class="date-input" value="19-déc.-25"></td>
                                    </tr>
                                    <tr>
                                        <td>25 %</td>
                                        <td class="text-right">{{ number_format(($Montant_sans_frais_Generaux * 25) / 100, 0, ',', ' ') }} ar</td>
                                        <td><input type="text" class="date-input" value="30-janv.-26"></td>
                                    </tr>
                                @elseif($modeP === 'D')
                                    <tr>
                                        <td>75 %</td>
                                        <td class="text-right">{{ number_format(($Montant_sans_frais_Generaux * 75) / 100, 0, ',', ' ') }} ar</td>
                                        <td><input type="text" class="date-input" value="3-oct.-25"></td>
                                    </tr>
                                    <tr>
                                        <td>25 %</td>
                                        <td class="text-right">{{ number_format(($Montant_sans_frais_Generaux * 25) / 100, 0, ',', ' ') }} ar</td>
                                        <td><input type="text" class="date-input" value="30-janv.-26"></td>
                                    </tr>
                                @elseif($modeP === 'E')
                                    <tr>
                                        <td>25 %</td>
                                        <td class="text-right">{{ number_format(($Montant_sans_frais_Generaux * 25) / 100, 0, ',', ' ') }} ar</td>
                                        <td><input type="text" class="date-input" value="24-oct.-25"></td>
                                    </tr>
                                    <tr>
                                        <td>25 %</td>
                                        <td class="text-right">{{ number_format(($Montant_sans_frais_Generaux * 25) / 100, 0, ',', ' ') }} ar</td>
                                        <td><input type="text" class="date-input" value="28-nov.-25"></td>
                                    </tr>
                                    <tr>
                                        <td>25 %</td>
                                        <td class="text-right">{{ number_format(($Montant_sans_frais_Generaux * 25) / 100, 0, ',', ' ') }} ar</td>
                                        <td><input type="text" class="date-input" value="19-déc.-25"></td>
                                    </tr>
                                    <tr>
                                        <td>25 %</td>
                                        <td class="text-right">{{ number_format(($Montant_sans_frais_Generaux * 25) / 100, 0, ',', ' ') }} ar</td>
                                        <td><input type="text" class="date-input" value="30-janv.-26"></td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    @endif
                </div>

                </td>

                <!-- Colonne droite -->
                <td style="width:70%; padding-left:15px; vertical-align:top; font-size:12px;">
                <div style="text-align:left; font-weight:bold; margin-bottom:10px;">
                    WORK EDUCATION : __________________________
                </div>
                <h4>ENGAGEMENT</h4>
                <b>Je sousigné(e), {{ $student->nom }} {{ $student->prenom }},</b>
                <p style="font-size: 09px;">
                    m’engage, durant mon séjour à l’Université Adventiste Zurcher, à maintenir une conduite et une attitude exemplaires, en harmonie avec la philosophie chrétienne de cette institution qui m’accueille ; à contribuer positivement à la vie universitaire ; et à vivre en conformité avec ses principes et règlements. Le non-respect de cet engagement pourra entraîner une sanction, voire un renvoi temporaire.
                </p>
                <hr>
                </td>
            </tr>
            </table>


        </div>
        <div>
            <p>Sambaina, le {{ \Carbon\Carbon::now()->locale('fr')->isoFormat('D MMMM YYYY') }}</p>
        </div>
        <p>Approuvée par :</p>
        <p></p>
        <table class="signature-table" style="width: 100%">
			<tbody>
				<tr>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td style="height: 40px;border"></td>
				</tr>
				<tr style="font-size: 8px;">
					<td style="border-top: 1px solid black; text-align: center;">______________ <br> Etudiant(e)</td>
					<td style="width: 20px"></td>
					<td style="border-top: 1px solid black; text-align: center;">___________________ <br> Chef de mention</td>
					<td style="width: 20px"></td>
					<td style="border-top: 1px solid black; text-align: center;">________________________ <br> Vice-Recteur<br>aux affaires financières</td>
					<td style="width: 20px"></td>
					<td style="border-top: 1px solid black; text-align: center;">________________________ <br> Vice-Recteur<br>aux affaires estudiantines</td>
					<td style="width: 20px"></td>
					<td style="border-top: 1px solid black; text-align: center;">______________ <br> Registraire</td>
				</tr>
			</tbody>
        </table>
        <br>
        <div style="border-top:1px solid black; width: 100%;">
            <table class="tbl">
                <tr>
                    <td><em>Université Adventiste Zurcher</em></td>
                    <td><em>
                        - ref: {{ now()->year }}{{ $student->account_code }} -
                    </em></td>
                </tr>
            </table>
        </div>
    </div>
</div>
</body>
</html>