<?php

use Illuminate\Support\Facades\DB;
use App\Models\Student;
use App\Models\Mention;
use App\Models\Parcours;

$etudiants = DB::table('tbl_2024_etudiant')->get();

foreach ($etudiants as $etudiant) {
    // Trouver la mention correspondante
    $mention = Mention::where('nom', $etudiant->etude_envisage)->first();

    // Trouver le parcours correspondant (option ou champ dédié)
    $parcoursNom = $etudiant->etude_option ?? $etudiant->student_parcours ?? null;
    $parcours = null;
    if ($mention && $parcoursNom) {
        $parcours = Parcours::where('nom', $parcoursNom)->where('mention_id', $mention->id)->first();
    }

    // Vérifier si un étudiant existe déjà avec cet email ou ce matricule
    $students = Student::where('matricule', $etudiant->student_id)
        ->orWhere('email', $etudiant->student_email)
        ->get();

    // Si plusieurs étudiants existent (doublon email/matricule), on garde le premier et supprime les autres
    if ($students->count() > 1) {
        $student = $students->first();
        $students->slice(1)->each->delete();
    } else {
        $student = $students->first();
    }

    // Vérifier la validité de la date de naissance
    $dateNaissance = $etudiant->dateNaissance ?? '';
    if (
        empty($dateNaissance) ||
        $dateNaissance === '0000-00-00' ||
        $dateNaissance === '0001-01-01'
    ) {
        // On saute cet étudiant
        continue;
    }

    // Normaliser etat_civil
    $etatCivil = strtolower(trim($etudiant->etat_civil ?? ''));
    $etatCivilMap = [
        'célibataire' => 'célibataire',
        'celibataire' => 'célibataire',
        'marié' => 'marié',
        'marie' => 'marié',
        'divorcé' => 'divorcé',
        'divorce' => 'divorcé',
        'veuf' => 'veuf',
        'veuve' => 'veuf',
    ];
    $etatCivil = $etatCivilMap[$etatCivil] ?? 'célibataire';

    // Normaliser annee_etude
    $rawAnnee = $etudiant->annee_etude ?? '';
    $anneeMap = [
        '1' => 'L1',
        '2' => 'L2',
        '3' => 'L3',
        '4' => 'M1',
        '5' => 'M2',
        'l1' => 'L1',
        'l2' => 'L2',
        'l3' => 'L3',
        'm1' => 'M1',
        'm2' => 'M2',
    ];
    $anneeEtude = $anneeMap[strtolower(trim($rawAnnee))] ?? 'L1';

    $data = [
        'nom' => $etudiant->student_nom,
        'prenom' => $etudiant->student_prenom,
        'sexe' => ($etudiant->sex == '1' || $etudiant->sex == 'Masculin') ? 'M' : 'F',
        'date_naissance' => $dateNaissance,
        'lieu_naissance' => $etudiant->lieuNaissance,
        'nationalite' => $etudiant->nationalite ?? 'Malagasy',
        'religion' => $etudiant->religion,
        'etat_civil' => $etatCivil,
        'passport_status' => false,
        'passport_numero' => null,
        'passport_pays_emission' => null,
        'passport_date_emission' => null,
        'passport_date_expiration' => null,
        'nom_conjoint' => $etudiant->nom_conjoint,
        'nb_enfant' => $etudiant->nb_enfant ?? 0,
        'cin_numero' => $etudiant->num_cin,
        'cin_date_delivrance' => $etudiant->cin_date_delivre != '0000-00-00' ? $etudiant->cin_date_delivre : null,
        'cin_lieu_delivrance' => $etudiant->cin_region,
        'nom_pere' => $etudiant->father_name,
        'profession_pere' => $etudiant->father_prof,
        'contact_pere' => $etudiant->parent_tel,
        'nom_mere' => $etudiant->mother_name ?? '',
        'profession_mere' => $etudiant->mother_prof ?? '',
        'contact_mere' => $etudiant->contact_mere ?? '',
        'adresse_parents' => $etudiant->parent_adresse,
        'telephone' => $etudiant->student_tel,
        'email' => $etudiant->student_email,
        'adresse' => $etudiant->student_adresse,
        'region' => $etudiant->student_region,
        'district' => $etudiant->student_district ?? '',
        'bacc_serie' => $etudiant->bacc_serie,
        'bacc_date_obtention' => null,
        'bursary_status' => $etudiant->bursary_status == 1,
        'sponsor_nom' => $etudiant->sponsor_nom,
        'sponsor_prenom' => $etudiant->sponsor_prenom,
        'sponsor_telephone' => $etudiant->sponsor_tel,
        'sponsor_adresse' => $etudiant->sponsor_adresse,
        'annee_etude' => $anneeEtude,
        'mention_id' => $mention ? $mention->id : null,
        'parcours_id' => $parcours ? $parcours->id : null,
        'matricule' => $etudiant->student_id,
    ];

    if ($student) {
        // Mise à jour si email ou matricule déjà existant (après suppression des doublons)
        $student->update($data);
    } else {
        // Création sinon
        Student::create($data);
    }
}
echo "Migration terminée.\n";
