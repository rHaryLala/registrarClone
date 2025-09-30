<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\AcademicYear;

class ChiefAccountantController extends Controller
{
    public function dashboard()
    {
        $user = auth()->user();

        // Récupérer l'année académique active
        $activeAcademicYear = AcademicYear::where('active', true)->first();

        $counts = [
            'total' => 0,
            'interne' => 0,
            'externe' => 0,
            'boursier' => 0,
        ];

        if ($activeAcademicYear) {
            $aqId = $activeAcademicYear->id;

            $query = Student::where('academic_year_id', $aqId);

            $counts['total'] = $query->count();

            // statut_interne stored as string or boolean; treat 'interne' (case-insensitive) as internal
            $counts['interne'] = Student::where('academic_year_id', $aqId)
                ->where(function($q) {
                    $q->where('statut_interne', 'interne')
                      ->orWhere('statut_interne', true)
                      ->orWhere('statut_interne', 1);
                })->count();

            $counts['externe'] = max(0, $counts['total'] - $counts['interne']);

            // bursary_status is cast to boolean on the model
            $counts['boursier'] = Student::where('academic_year_id', $aqId)
                ->where(function($q) {
                    $q->where('bursary_status', true)
                      ->orWhere('bursary_status', 1);
                })->count();

            // Récupérer les 5 derniers étudiants inscrits pour l'année académique active
            $recentStudents = Student::where('academic_year_id', $aqId)
                ->with(['mention', 'yearLevel'])
                ->orderByDesc('created_at')
                ->take(5)
                ->get(['id','nom','prenom','matricule','bursary_status','statut_interne','created_at','mention_id','year_level_id']);
        }

        // Fallback empty collection when there's no active year
        if (!isset($recentStudents)) {
            $recentStudents = collect();
        }

        return view('chief_accountant.dashboard', compact('user', 'counts', 'activeAcademicYear', 'recentStudents'));
    }
}
