<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Fiche d'inscription - {{ $student->prenom }} {{ $student->nom }}</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 9px; }
        .head { border-bottom: 1px solid #6b6969; margin-bottom: 5px; }
        .infotitre { background-color: #7d7a8c; color: white; border-top-left-radius: 8px; border-top-right-radius: 8px; padding-left: 15px; height: 20px; padding-top: 5px; }
        .informationbox { border: 1px solid #6b6969; margin: 0px; }
        .tbl { width: 100%; border-collapse: collapse; }
        .tbl td, .tbl th { border: 1px solid #c8cae4; padding: 2px 6px; height: 8px; } /* Hauteur réduite ici */
        .tbl th { background: #dfe0ef; }
        /* Smaller table style for compact sections (payment breakdown) */
        .payment-table td, .payment-table th {
            padding: 1px 4px;
            font-size: 7px;
            height: 8px;
        }
        .payment-table input {
            font-size: 8px;
            padding: 1px;
        }
        /* Date input that fills the parent column and shows a border bounded by the left column */
        .date-input {
            display: block;
            width: 100%;
            padding: 2px 4px;
            font-size: 8px;
            background: transparent;
            border: none !important;
            outline: none !important;
            box-shadow: none !important;
        }
        .marck { background-color: #e8e6e6; font-weight: bold; }
        .center { text-align: center; }
        .inline { display: inline-grid; width: 100%; }
        .flex { display: flex; padding-left: 10px; padding-right: 10px; padding-top: 5px; padding-bottom: 5px; width: 90%; }
        .footer { border-top: 1px solid black; height: 200px; }
        .signature-table td { border: none !important; }
        /* Interligne plus petit */
        table, tr, td, th, p, div, span, b, h2, h3, h4 {
            line-height: 1 !important;
        }
        th {
            text-align: left;
        }
    </style>
</head>
<body>a
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
                        <div style="margin-bottom: 4px;">
                            <b>Matricule :</b> {{ $student->matricule }} &nbsp; 
                        </div>
                        <div style="margin-bottom: 4px;">
                            <b>N° de compte :</b> {{ $student->account_code }} &nbsp;
                        </div>
                        <div style="margin-bottom: 4px;">
                            <b>Nom :</b> {{ $student->nom }} {{ $student->prenom }} &nbsp; 
                        </div>
                        <div style="margin-bottom: 4px;">
                            <b>Mention :</b> {{ $student->mention ? $student->mention->nom : '-' }}
                        </div>
                        <div style="margin-bottom: 4px;">
                            <b>Parcours :</b> {{ $student->parcours ? $student->parcours->nom : '-' }}
                        </div>
                        <div style="margin-bottom: 4px;">
                            <b>Niveau d'étude :</b> {{ $student->yearLevel ? $student->yearLevel->label : ($student->annee_etude ?? '-') }}
                        </div>
                        <div style="margin-bottom: 4px;">
                            <b>Email / Tél:</b> {{ $student->email }} / {{ $student->telephone }} &nbsp; 
                        </div>
                        <div style="margin-bottom: 4px;">
                            <b>Adresse :</b> {{ $student->adresse }}
                        </div>
                        <div>
                            <b>Résidence :</b> {{ $student->statut_interne }}</b>
                        </div>
                    </td>
                    <td style="width:20%; text-align:right; vertical-align:top;">
                        @if($student->image)
                            <img src="{{ public_path($student->image) }}"
                                 alt="Photo de profil"
                                 style="width: 100px; height: 100px; object-fit: cover; border-radius: 8px; border: 1px solid #aaa; margin-top: 18px; margin-right: 18px; display: inline-block;">
                        @else
                            <div style="width: 100px; height: 100px; background: #eaeaea; border-radius: 8px; border: 1px solid #aaa; display: flex; align-items: center; justify-content: center; color: #888; font-size: 32px; margin-top: 18px; margin-right: 18px;">
                                
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
            <div class="informationbox col-lg-12" style="border-radius: 0px; margin-bottom: 15px;">
                @php
                    // Détection L1 (Licence 1)
                    $isL1 = false;
                    if(isset($student->yearLevel)) {
                        $label = strtolower($student->yearLevel->label ?? '');
                        $isL1 = (strpos($label, '1') !== false || strpos($label, 'l1') !== false || $label === 'l1' || $label === '1');
                    }
                    $fraisGeneraux = $isL1 ? 250000 : (isset($student->frais_generaux) ? $student->frais_generaux : 0);
                    $totalCredits = 0;
                    $laboCount = 0;
                    foreach($student->courses()->wherePivot('deleted_at', null)->get() as $course) {
                        $totalCredits += $course->credits;
                        if ($course->besoin_labo) $laboCount++;
                    }
                    $coutCredit = $totalCredits * 19000;
                    $coutDortoir = (isset($student->statut_interne) && $student->statut_interne) ? (3000 * 123) : (isset($student->cout_dortoir) ? $student->cout_dortoir : 0);
                    $coutCantine = (isset($student->abonne_caf) && $student->abonne_caf) ? (8000 * 123) : (isset($student->cout_cantine) ? $student->cout_cantine : 0);
                    // Coût labo : 35 000 par cours nécessitant le labo, plafonné à 70 000
                    $coutLabo = $laboCount > 0 ? min($laboCount * 35000, 70000) : 0;
                    $voyage_etude = 150000;
                    $totalFinance = $fraisGeneraux + $coutCredit + $coutLabo + $voyage_etude;
                    if(isset($student->statut_interne) && $student->statut_interne) $totalFinance += $coutDortoir;
                    if(isset($student->abonne_caf) && $student->abonne_caf) $totalFinance += $coutCantine;
                @endphp
                <table class="tbl">
                    <thead>
                        <tr>
                            <th>Frais généraux</th>
                            <th>Coût total des crédits</th>
                            @if($laboCount > 0)
                                <th>Laboratoire</th>
                            @endif
                            @if(isset($student->statut_interne) && $student->statut_interne)
                                <th>Dortoir</th>
                            @endif
                            @if(isset($student->abonne_caf) && $student->abonne_caf)
                                <th>Cantine</th>
                            @endif
                            <th>Voyage d'étude</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                {{ number_format($fraisGeneraux, 0, ',', ' ') }} Ar
                            </td>
                            <td>
                                {{ number_format($coutCredit, 0, ',', ' ') }} Ar
                            </td>
                            @if($laboCount > 0)
                                <td>
                                    {{ number_format($coutLabo, 0, ',', ' ') }} Ar
                                </td>
                            @endif
                            @if(isset($student->statut_interne) && $student->statut_interne)
                                <td>
                                    {{ number_format($coutDortoir, 0, ',', ' ') }} Ar
                                </td>
                            @endif
                            @if(isset($student->abonne_caf) && $student->abonne_caf)
                                <td>
                                    {{ number_format($coutCantine, 0, ',', ' ') }} Ar
                                </td>
                            @endif
                            <td>
                                {{ number_format($voyage_etude, 0, ',', ' ') }} Ar
                            </td>
                        </tr>
                    </tbody>
                </table>
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
                    // Determine payment mode (plan) from latest finance row for this student (by matricule)
                    $modeP = \App\Models\Finance::where('student_id', $student->matricule)
                        ->orderByDesc('date_entry')
                        ->value('plan') ?? 'A';

                    // Montant sans frais généraux = montant total à payer (totalFinance) - fraisGeneraux
                    $Montant_sans_frais_Generaux = ($totalFinance ?? 0) - ($fraisGeneraux ?? 0);
                @endphp

                <div style="width:100%;">
                    <p></p>
                    <b class="text-xl">Mode de paiement</b>
                    <table class="tbl mb-2 payment-table">
                        <thead>
                            <tr>
                                <th colspan="3" class="text-center text-bold">{{ number_format($Montant_sans_frais_Generaux, 0, ',', ' ') }} ar</th>
                            </tr>
                            <tr>
                                <th colspan="3" class="text-center text-bold">Payé en tranches de TYPE {{ $modeP }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if($modeP === 'A')
                                <tr>
                                    <td>100 %</td>
                                    <td class="text-right">{{ number_format($Montant_sans_frais_Generaux, 0, ',', ' ') }} ar</td>
                                    <td><input type="text" class="date-input" value="Mercredi, 16 octobre 2024"></td>
                                </tr>
                            @elseif($modeP === 'B')
                                <tr>
                                    <td>50 %</td>
                                    <td class="text-right">{{ number_format(($Montant_sans_frais_Generaux * 50) / 100, 0, ',', ' ') }} ar</td>
                                    <td><input type="text" class="date-input" value="Mercredi, 16 octobre 2024"></td>
                                </tr>
                                <tr>
                                    <td>50 %</td>
                                    <td class="text-right">{{ number_format(($Montant_sans_frais_Generaux * 50) / 100, 0, ',', ' ') }} ar</td>
                                    <td><input type="text" class="date-input" value="Vendredi, 17 janvier 2025"></td>
                                </tr>
                            @elseif($modeP === 'C')
                                <tr>
                                    <td>75 %</td>
                                    <td class="text-right">{{ number_format(($Montant_sans_frais_Generaux * 75) / 100, 0, ',', ' ') }} ar</td>
                                    <td><input type="text" class="date-input" value="Mercredi, 16 octobre 2024"></td>
                                </tr>
                                <tr>
                                    <td>25 %</td>
                                    <td class="text-right">{{ number_format(($Montant_sans_frais_Generaux * 25) / 100, 0, ',', ' ') }} ar</td>
                                    <td><input type="text" class="date-input" value="Vendredi, 17 janvier 2025"></td>
                                </tr>
                            @elseif($modeP === 'D')
                                <tr>
                                    <td>40 %</td>
                                    <td class="text-right">{{ number_format(($Montant_sans_frais_Generaux * 40) / 100, 0, ',', ' ') }} ar</td>
                                    <td><input type="text" class="date-input" value="Mercredi, 16 octobre 2024"></td>
                                </tr>
                                <tr>
                                    <td>30 %</td>
                                    <td class="text-right">{{ number_format(($Montant_sans_frais_Generaux * 30) / 100, 0, ',', ' ') }} ar</td>
                                    <td><input type="text" class="date-input" value="Vendredi, 22 novembre 2024"></td>
                                </tr>
                                <tr>
                                    <td>30 %</td>
                                    <td class="text-right">{{ number_format(($Montant_sans_frais_Generaux * 30) / 100, 0, ',', ' ') }} ar</td>
                                    <td><input type="text" class="date-input" value="Vendredi, 20 décembre 2024"></td>
                                </tr>
                            @elseif($modeP === 'E')
                                <tr>
                                    <td>25 %</td>
                                    <td class="text-right">{{ number_format(($Montant_sans_frais_Generaux * 25) / 100, 0, ',', ' ') }} ar</td>
                                    <td><input type="text" class="date-input" value="Mercredi, 16 octobre 2024"></td>
                                </tr>
                                <tr>
                                    <td>25 %</td>
                                    <td class="text-right">{{ number_format(($Montant_sans_frais_Generaux * 25) / 100, 0, ',', ' ') }} ar</td>
                                    <td><input type="text" class="date-input" value="Vendredi, 22 novembre 2024"></td>
                                </tr>
                                <tr>
                                    <td>25 %</td>
                                    <td class="text-right">{{ number_format(($Montant_sans_frais_Generaux * 25) / 100, 0, ',', ' ') }} ar</td>
                                    <td><input type="text" class="date-input" value="Vendredi, 20 décembre 2024"></td>
                                </tr>
                                <tr>
                                    <td>25 %</td>
                                    <td class="text-right">{{ number_format(($Montant_sans_frais_Generaux * 25) / 100, 0, ',', ' ') }} ar</td>
                                    <td><input type="text" class="date-input" value="Vendredi, 17 janvier 2025"></td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
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