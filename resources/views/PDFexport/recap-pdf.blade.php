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
                        @php
                            $totalCredits = 0;
                        @endphp
                        @foreach($student->courses()->wherePivot('deleted_at', null)->get() as $course)
                            <tr>
                                <td>{{ $course->sigle }}</td>
                                <td>{{ $course->nom }}</td>
                                <td>{{ $course->credits }}</td>
                                <td>
                                    {{ $course->categorie ?? '-' }}
                                </td>
                                <td>
                                    {{ number_format($course->credits * 19000, 0, ',', ' ') }} Ar
                                </td>
                            </tr>
                            @php $totalCredits += $course->credits; @endphp
                        @endforeach
                        <tr>
                            <td class="marck">Cours : {{ $student->courses()->wherePivot('deleted_at', null)->count() }}</td>
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
                    // Try to load precomputed fees from StudentSemesterFee for the student's current academic year & semester
                    $ssf = null;
                    if(isset($student->academic_year_id) && isset($student->semester_id)) {
                        $ssf = \App\Models\StudentSemesterFee::where('student_id', $student->id)
                            ->where('academic_year_id', $student->academic_year_id)
                            ->where('semester_id', $student->semester_id)
                            ->first();
                    }

                    // Détection L1 (Licence 1)
                    $isL1 = false;
                    if(isset($student->yearLevel)) {
                        $label = strtolower($student->yearLevel->label ?? '');
                        $isL1 = (strpos($label, '1') !== false || strpos($label, 'l1') !== false || $label === 'l1' || $label === '1');
                    }

                    // Compute fallbacks (as before) but prefer stored SSF values when available
                    $totalCredits = 0;
                    $laboCount = 0;
                    foreach($student->courses()->wherePivot('deleted_at', null)->get() as $course) {
                        $totalCredits += $course->credits;
                        if ($course->labo_info) $laboCount++;
                    }
                    $coutCredit = $ssf ? ($ssf->ecolage ?? ($totalCredits * 19000)) : ($totalCredits * 19000);
                    $fraisGeneraux = $ssf ? ($ssf->frais_generaux ?? ($isL1 ? 250000 : 0)) : ($isL1 ? 250000 : (isset($student->frais_generaux) ? $student->frais_generaux : 0));
                    $coutDortoir = $ssf ? ($ssf->dortoir ?? ((isset($student->statut_interne) && $student->statut_interne) ? (3000 * 123) : (isset($student->cout_dortoir) ? $student->cout_dortoir : 0))) : ((isset($student->statut_interne) && $student->statut_interne) ? (3000 * 123) : (isset($student->cout_dortoir) ? $student->cout_dortoir : 0));
                    $coutCantine = $ssf ? ($ssf->cantine ?? ((isset($student->abonne_caf) && $student->abonne_caf) ? (8000 * 123) : (isset($student->cout_cantine) ? $student->cout_cantine : 0))) : ((isset($student->abonne_caf) && $student->abonne_caf) ? (8000 * 123) : (isset($student->cout_cantine) ? $student->cout_cantine : 0));
                    // Coût labo : 35 000 par cours nécessitant le labo, plafonné à 70 000
                    $coutLabo = $ssf ? (($ssf->labo_info + $ssf->labo_comm + $ssf->labo_langue) ?: ($laboCount > 0 ? min($laboCount * 35000, 70000) : 0)) : ($laboCount > 0 ? min($laboCount * 35000, 70000) : 0);
                    $voyage_etude = $ssf ? ($ssf->voyage_etude ?? 150000) : 150000;
                    $colloque = $ssf ? ($ssf->colloque ?? 0) : 0;
                    $costume = $ssf ? ($ssf->frais_costume ?? 0) : 0;

                    $totalFinance = ($fraisGeneraux ?? 0) + ($coutCredit ?? 0) + ($coutLabo ?? 0) + ($voyage_etude ?? 0) + ($colloque ?? 0) + ($costume ?? 0);
                    if(isset($student->statut_interne) && $student->statut_interne) $totalFinance += $coutDortoir;
                    if(isset($student->abonne_caf) && $student->abonne_caf) $totalFinance += $coutCantine;
                @endphp
                @php
                    // Labo info separated (prefer stored value)
                    $labo_info = $ssf ? ($ssf->labo_info ?? 0) : ($laboCount > 0 ? min($laboCount * 35000, 70000) : 0);

                    // Subtotals
                    $subtotal1 = ($fraisGeneraux ?? 0) + ($coutCredit ?? 0) + ($labo_info ?? 0);
                    if(isset($student->statut_interne) && $student->statut_interne) $subtotal1 += ($coutDortoir ?? 0);
                    if(isset($student->abonne_caf) && $student->abonne_caf) $subtotal1 += ($coutCantine ?? 0);

                    // Voyage / Colloque and costume
                    $voyage_or_colloque = ($colloque && $colloque > 0) ? $colloque : $voyage_etude;
                    $subtotal2 = ($voyage_or_colloque ?? 0) + ($costume ?? 0);

                    // Determine payment mode (plan) from latest finance row for this student (by matricule)
                    $modeP = \App\Models\Finance::where('student_id', $student->matricule)
                        ->orderByDesc('date_entry')
                        ->value('plan') ?? 'A';

                    // Montant sans frais généraux = montant total à payer (totalFinance) - fraisGeneraux
                    $Montant_sans_frais_Generaux = ($totalFinance ?? 0) - ($fraisGeneraux ?? 0);
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
                                    <th>Costume</th>
                                    <th>Sous-total</th>
                                    <th>Plan de paiement</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>{{ number_format($voyage_or_colloque ?? 0, 0, ',', ' ') }} Ar</td>
                                    <td>{{ number_format($costume ?? 0, 0, ',', ' ') }} Ar</td>
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