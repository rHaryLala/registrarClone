<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\AcademicYear;
use App\Models\YearLevel;
use Barryvdh\DomPDF\Facade\Pdf;

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

    /**
     * Export student's registration recap as PDF (chief accountant)
     */
    public function exportStudentPdf($id)
    {
        $student = Student::with(['mention', 'parcours', 'yearLevel'])->findOrFail($id);

        // Ensure StudentSemesterFee exists for this student's academic year & semester so recap-pdf can read persisted values
        try {
            if ($student->academic_year_id && $student->semester_id) {
                $ssfExists = \App\Models\StudentSemesterFee::where('student_id', $student->id)
                    ->where('academic_year_id', $student->academic_year_id)
                    ->where('semester_id', $student->semester_id)
                    ->exists();
                if (!$ssfExists) {
                    try {
                        (new \App\Services\InstallmentService())->computeSemesterFees($student->fresh(), $student->academic_year_id, $student->semester_id, auth()->id() ?? null);
                        $student = $student->fresh(['mention', 'parcours', 'yearLevel']);
                    } catch (\Throwable $e) {
                        logger()->warning('Failed to compute StudentSemesterFee during PDF export for student '.$student->id.': '.$e->getMessage());
                    }
                }
            }
        } catch (\Throwable $e) {
            // ignore and continue rendering fallback values
        }

        // Ensure the student's courses relation used by the Blade template returns only non-deleted pivots
        try {
            $courses = $student->courses()->wherePivot('deleted_at', null)->get();
            $student->setRelation('courses', $courses);
        } catch (\Throwable $e) {
            // ignore
        }

        // Render the view to HTML so we can transform image src attributes
        $html = view('PDFexport.recap-pdf', compact('student'))->render();

        // Normalize paths and prepare variables
        $html = str_replace('\\', '/', $html);
        $baseUrl = rtrim(url('/'), '/');
        $publicPath = str_replace('\\', '/', public_path());
        $publicPathNormalized = rtrim($publicPath, '/');

        // Helper to resolve candidate filesystem paths for a given src
        $resolveCandidate = function (string $src) use ($baseUrl, $publicPathNormalized) {
            $srcNorm = str_replace('\\','/',$src);

            // If already data URI or remote URL, skip
            if (stripos($srcNorm, 'data:') === 0 || preg_match('#^[a-zA-Z][a-zA-Z0-9+.-]*://#', $srcNorm) || strpos($srcNorm, '//') === 0) {
                return null;
            }

            // If src contains baseUrl -> map back to public path
            if (!empty($baseUrl) && strpos($srcNorm, $baseUrl) === 0) {
                $rel = ltrim(substr($srcNorm, strlen($baseUrl)), '/');
                $cand = $publicPathNormalized . '/' . $rel;
                if (file_exists($cand)) return $cand;
            }

            // Absolute path on domain (e.g. /storage/...)
            if (strpos($srcNorm, '/') === 0) {
                $cand = $publicPathNormalized . '/' . ltrim($srcNorm, '/');
                if (file_exists($cand)) return $cand;
            }

            // storage/.. path
            if (strpos($srcNorm, 'storage/') === 0) {
                $cand = $publicPathNormalized . '/' . $srcNorm;
                if (file_exists($cand)) return $cand;
                $cand2 = storage_path('app/public/' . substr($srcNorm, strlen('storage/')));
                if (file_exists($cand2)) return $cand2;
            }

            // Try public_path relative
            $cand = $publicPathNormalized . '/' . ltrim($srcNorm, '/');
            if (file_exists($cand)) return $cand;

            // Try storage/app
            $cand3 = storage_path('app/' . ltrim($srcNorm, '/'));
            if (file_exists($cand3)) return $cand3;

            return null;
        };

        // Inline <img> tags as data URIs
        $html = preg_replace_callback('/<img[^>]+src=["\']([^"\']+)["\'][^>]*>/i', function ($m) use ($resolveCandidate) {
            $origTag = $m[0];
            $src = $m[1];
            $candidate = $resolveCandidate($src);

            if ($candidate && is_readable($candidate)) {
                try {
                    $data = file_get_contents($candidate);
                    if ($data !== false) {
                        $finfo = @finfo_open(FILEINFO_MIME_TYPE);
                        $mime = $finfo ? @finfo_file($finfo, $candidate) : @mime_content_type($candidate);
                        if ($finfo) @finfo_close($finfo);
                        if (!$mime) $mime = 'application/octet-stream';
                        $b64 = base64_encode($data);
                        $newTag = preg_replace('/src=["\']([^"\']+)["\']/', 'src="data:'.$mime.';base64,'.$b64.'"', $origTag, 1);
                        return $newTag;
                    }
                } catch (\Throwable $e) {
                    // fallback to original
                }
            }
            return $origTag;
        }, $html);

        // Inline CSS url(...) occurrences
        $html = preg_replace_callback('/url\(([^)]+)\)/i', function($m) use ($resolveCandidate) {
            $inside = trim($m[1], " \t\n\r'\"");
            $candidate = $resolveCandidate($inside);
            if ($candidate && is_readable($candidate)) {
                try {
                    $data = file_get_contents($candidate);
                    if ($data !== false) {
                        $finfo = @finfo_open(FILEINFO_MIME_TYPE);
                        $mime = $finfo ? @finfo_file($finfo, $candidate) : @mime_content_type($candidate);
                        if ($finfo) @finfo_close($finfo);
                        if (!$mime) $mime = 'application/octet-stream';
                        $b64 = base64_encode($data);
                        return "url('data:{$mime};base64,{$b64}')";
                    }
                } catch (\Throwable $e) {
                    // fallback
                }
            }
            return $m[0];
        }, $html);

        // Save debug HTML for inspection on the host (non-blocking)
        try {
            \Storage::disk('local')->put('debug/pdf-html-'.$student->id.'.html', $html);
        } catch (\Throwable $e) {
            // ignore write failures
        }

        // Generate PDF from transformed HTML
        $pdf = Pdf::loadHTML($html);

        try {
            $pdf->setOptions([
                'isRemoteEnabled' => true,
                'isHtml5ParserEnabled' => true,
                'chroot' => public_path(),
            ]);
        } catch (\Throwable $e) {
            // ignore if not supported
        }

        return $pdf->download('fiche-inscription-' . ($student->matricule ?? $student->id) . '.pdf');
    }

    // Students list for chief accountant (replicates SuperAdmin list shape)
    public function studentsList(Request $request)
    {
        $sort = $request->get('sort', 'id');
        $direction = $request->get('direction', 'desc');
        $query = Student::query();

        if ($request->filled('q')) {
            $q = $request->q;
            $query->where(function($sub) use ($q) {
                $sub->where('matricule', 'like', "%$q%")
                    ->orWhere('nom', 'like', "%$q%")
                    ->orWhere('prenom', 'like', "%$q%")
                    ->orWhere('email', 'like', "%$q%");
            });
        }

        $students = $query->orderBy($sort, $direction)->get();

        $mentions = \App\Models\Mention::all();
        $yearLevels = \App\Models\YearLevel::all();

        $studentsArray = $students->map(function($student) {
            $acadLibelle = null;
            try {
                if ($student->academicYear) {
                    $acadLibelle = $student->academicYear->libelle;
                } elseif (is_numeric($student->academic_year_id)) {
                    $ay = \App\Models\AcademicYear::find($student->academic_year_id);
                    $acadLibelle = $ay ? $ay->libelle : null;
                } else {
                    $acadLibelle = $student->academic_year_id ?? null;
                }
            } catch (\Throwable $e) {
                $acadLibelle = $student->academic_year_id ?? null;
            }

            return [
                'id' => $student->id,
                'matricule' => $student->matricule,
                'nom' => $student->nom,
                'prenom' => $student->prenom,
                'email' => $student->email,
                'mention_id' => $student->mention_id,
                'mention_nom' => $student->mention ? $student->mention->nom : '-',
                'academic_year' => $acadLibelle,
                'year_level_id' => $student->year_level_id,
                'year_level_label' => $student->yearLevel ? $student->yearLevel->label : '-',
            ];
        })->values()->toArray();

        $mentionsArray = $mentions->map(function($mention) {
            return [
                'id' => $mention->id,
                'nom' => $mention->nom,
            ];
        })->values()->toArray();

        // Reuse SuperAdmin students view which contains the JS filter UI
        return view('chief_accountant.students.list', compact('students', 'mentions', 'studentsArray', 'mentionsArray', 'yearLevels'));
    }

    public function showStudent($id)
    {
        $student = Student::with('lastChangedBy')->findOrFail($id);
        $yearLevels = YearLevel::all();
        return view('chief_accountant.students.show', compact('student', 'yearLevels'));
    }

    public function updateStudent(Request $request, $id)
    {
        $student = Student::findOrFail($id);
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => 'nullable|email',
            // add other fields as needed
        ]);
        $student->update($validated);
        return redirect()->route('chief.accountant.students.show', $student->id)->with('success', 'Étudiant mis à jour.');
    }

    public function showStudentCourses($id)
    {
        $student = Student::with('courses')->findOrFail($id);
        return view('chief_accountant.students.courses-history', compact('student'));
    }

    public function addCourseToStudent($studentId)
    {
        $student = Student::findOrFail($studentId);
        $courses = \App\Models\Course::all();
        return view('chief_accountant.students.courses-add', compact('student', 'courses'));
    }

    public function storeCourseToStudent(Request $request, $studentId)
    {
        $student = Student::findOrFail($studentId);
        $validated = $request->validate([
            'course_id' => 'required|exists:courses,id'
        ]);
        $student->courses()->attach($validated['course_id']);
        return redirect()->route('chief.accountant.students.show', $student->id)->with('success', 'Cours ajouté.');
    }

    public function removeCourseFromStudent($studentId, $courseId)
    {
        $student = Student::findOrFail($studentId);
        $student->courses()->detach($courseId);
        return redirect()->route('chief.accountant.students.show', $student->id)->with('success', 'Cours retiré.');
    }

    public function recomputeStudentSemesterFee(Request $request, $studentId)
    {
        // Simple wrapper around InstallmentService but kept local to ChiefAccountantController
        $student = Student::findOrFail($studentId);
        $academicYearId = $student->academic_year_id;
        $semesterId = $student->semester_id;

        if (!$academicYearId || !$semesterId) {
            return response()->json(['error' => 'Contexte insuffisant pour recalculer.'], 422);
        }

        try {
            $service = new \App\Services\InstallmentService();
            $record = $service->computeSemesterFees($student->fresh(), $academicYearId, $semesterId, auth()->id() ?? null);
            return response()->json(['success' => true, 'record' => $record]);
        } catch (\Throwable $e) {
            logger()->error('recomputeStudentSemesterFee error: ' . $e->getMessage());
            return response()->json(['error' => 'Erreur lors du recalcul.'], 500);
        }
    }

    // FINANCES - copy/adapt from SuperAdminController so ChiefAccountant handles finances locally
    public function financesList(Request $request)
    {
        $with = [
            'student.installments' => function($q) { $q->orderBy('sequence'); },
            'semester',
            'lastChangedBy'
        ];

        if ($request->filled('student_id')) {
            $studentFilter = $request->get('student_id');
            $student = \App\Models\Student::find($studentFilter);
            if ($student) {
                $finances = \App\Models\Finance::with($with)->where('student_id', $student->matricule)->orderByDesc('date_entry')->get();
            } else {
                $finances = \App\Models\Finance::with($with)->where('student_id', $studentFilter)->orderByDesc('date_entry')->get();
            }
        } else {
            $finances = \App\Models\Finance::with($with)->orderByDesc('date_entry')->get();
        }

        $lastChange = \App\Models\Finance::whereNotNull('last_change_datetime')
            ->orderByDesc('last_change_datetime')
            ->with('lastChangedBy')
            ->first();

        $lastChangedBy = null;
        $lastChangedAt = null;
        if ($lastChange) {
            $lastChangedBy = $lastChange->lastChangedBy;
            $lastChangedAt = $lastChange->last_change_datetime;
        }

        $feeTypeNames = ['Frais Généraux', 'Écolage', 'Cantine', 'Dortoir'];
        $feeTypes = \App\Models\FeeType::whereIn('name', $feeTypeNames)->get()->keyBy('name');

        foreach ($finances as $finance) {
            if (!$finance->student && $finance->student_id) {
                $resolved = \App\Models\Student::where('matricule', $finance->student_id)
                    ->with(['installments' => function($q) { $q->orderBy('sequence'); }])
                    ->first();
                if ($resolved) {
                    $finance->student = $resolved;
                }
            }

            $student = $finance->student;
            $computed = [
                'frais_generaux' => 0,
                'ecolage' => 0,
                'cantine' => 0,
                'dortoir' => 0,
                'labo_info' => 0,
                'labo_comm' => 0,
                'labo_langue' => 0,
                'voyage_etude' => 0,
                'colloque' => 0,
                'frais_costume' => 0,
                'total_amount' => 0,
                'total_due' => 0,
            ];

            if ($student) {
                $query = \App\Models\AcademicFee::where('mention_id', $student->mention_id)
                    ->where('year_level_id', $student->year_level_id)
                    ->where('academic_year_id', $student->academic_year_id);

                if ($student->semester_id) {
                    $query->where('semester_id', $student->semester_id);
                }

                $fees = $query->get()->keyBy(function ($row) { return $row->feeType ? $row->feeType->name : $row->fee_type_id; });

                if (isset($feeTypes['Frais Généraux'])) {
                    $fgRow = $fees->firstWhere('fee_type_id', $feeTypes['Frais Généraux']->id) ?? $fees->get('Frais Généraux');
                    $computed['frais_generaux'] = $fgRow->amount ?? 0;
                }

                if (isset($feeTypes['Écolage'])) {
                    $ecRow = $fees->firstWhere('fee_type_id', $feeTypes['Écolage']->id) ?? $fees->get('Écolage');
                    $computed['ecolage'] = $ecRow->amount ?? 0;
                }

                if ($student->abonne_caf) {
                    if (isset($feeTypes['Cantine'])) {
                        $cRow = $fees->firstWhere('fee_type_id', $feeTypes['Cantine']->id) ?? $fees->get('Cantine');
                        $computed['cantine'] = $cRow->amount ?? 0;
                    }
                }

                if ($student->statut_interne === 'interne') {
                    if (isset($feeTypes['Dortoir'])) {
                        $dRow = $fees->firstWhere('fee_type_id', $feeTypes['Dortoir']->id) ?? $fees->get('Dortoir');
                        $computed['dortoir'] = $dRow->amount ?? 0;
                    }
                }

                $computed['total_amount'] = array_sum([
                    $computed['frais_generaux'], $computed['ecolage'], $computed['cantine'], $computed['dortoir'],
                    $computed['labo_info'], $computed['labo_comm'], $computed['labo_langue'], $computed['voyage_etude'], $computed['colloque'], $computed['frais_costume']
                ]);
                $computed['total_due'] = $computed['total_amount'];
            }

            $ssf = null;
            if ($student && isset($student->academic_year_id) && isset($student->semester_id)) {
                $ssf = \App\Models\StudentSemesterFee::where('student_id', $student->id)
                    ->where('academic_year_id', $student->academic_year_id)
                    ->where('semester_id', $student->semester_id)
                    ->first();
            }

            if ($ssf) {
                $finance->computed = (object)[
                    'frais_generaux' => $ssf->frais_generaux ?? 0,
                    'ecolage' => $ssf->ecolage ?? 0,
                    'cantine' => $ssf->cantine ?? 0,
                    'dortoir' => $ssf->dortoir ?? 0,
                    'labo_info' => $ssf->labo_info ?? 0,
                    'labo_comm' => $ssf->labo_comm ?? 0,
                    'labo_langue' => $ssf->labo_langue ?? 0,
                    'voyage_etude' => $ssf->voyage_etude ?? 0,
                    'colloque' => $ssf->colloque ?? 0,
                    'frais_costume' => $ssf->frais_costume ?? 0,
                    'total_amount' => $ssf->total_amount ?? 0,
                    'total_due' => $ssf->total_amount ?? ($computed['total_due'] ?? 0),
                ];
            } else {
                if ($student && isset($student->academic_year_id) && isset($student->semester_id)) {
                    try {
                        $service = new \App\Services\InstallmentService();
                        $record = $service->computeSemesterFees($student->fresh(), $student->academic_year_id, $student->semester_id, auth()->id() ?? null);
                        if ($record) {
                            $finance->computed = (object)[
                                'frais_generaux' => $record->frais_generaux ?? 0,
                                'ecolage' => $record->ecolage ?? 0,
                                'cantine' => $record->cantine ?? 0,
                                'dortoir' => $record->dortoir ?? 0,
                                'labo_info' => $record->labo_info ?? 0,
                                'labo_comm' => $record->labo_comm ?? 0,
                                'labo_langue' => $record->labo_langue ?? 0,
                                'voyage_etude' => $record->voyage_etude ?? 0,
                                'colloque' => $record->colloque ?? 0,
                                'frais_costume' => $record->frais_costume ?? 0,
                                'total_amount' => $record->total_amount ?? 0,
                                'total_due' => $record->total_amount ?? ($computed['total_due'] ?? 0),
                            ];
                        } else {
                            $finance->computed = (object)$computed;
                        }
                    } catch (\Throwable $e) {
                        logger()->warning('financesList: failed to compute StudentSemesterFee for student ' . ($student->id ?? 'unknown') . ': ' . $e->getMessage());
                        $finance->computed = (object)$computed;
                    }
                } else {
                    $finance->computed = (object)$computed;
                }
            }
        }

        return view('chief_accountant.finances.list', compact('finances', 'lastChangedBy', 'lastChangedAt'));
    }

    public function updateFinancePlan(Request $request, $financeId)
    {
        $finance = \App\Models\Finance::findOrFail($financeId);

        $validated = $request->validate([
            'plan' => 'required|string|in:A,B,C,D,E'
        ]);

        $finance->plan = $validated['plan'];
        $finance->last_change_user_id = auth()->id() ?? $finance->last_change_user_id;
        $finance->last_change_datetime = now();
        $finance->save();

        return response()->json(['success' => true, 'plan' => $finance->plan]);
    }

    public function createFinance()
    {
        $students = \App\Models\Student::all();
        $courses = \App\Models\Course::all();
        return view('chief_accountant.finances.create', compact('students', 'courses'));
    }

    public function storeFinance(Request $request)
    {
        $validated = $request->validate([
            'student_id' => 'required|exists:students,id',
            'type' => 'required|string|max:255',
            'montant' => 'required|numeric|min:0',
            'status' => 'required|string|max:50',
            'description' => 'nullable|string',
            'course_id' => 'nullable|exists:courses,id',
            'extra' => 'nullable|array',
        ]);
        if (isset($validated['extra'])) {
            $validated['extra'] = json_encode($validated['extra']);
        }
        \App\Models\StudentFinance::create($validated);
        return redirect()->route('chief.accountant.finances.list')->with('success', 'Finance ajoutée avec succès.');
    }

    public function showFinance($id)
    {
        $finance = \App\Models\StudentFinance::with(['student', 'course'])->findOrFail($id);
        return view('chief_accountant.finances.show', compact('finance'));
    }

    public function editFinance($id)
    {
        $finance = \App\Models\StudentFinance::findOrFail($id);
        $students = \App\Models\Student::all();
        $courses = \App\Models\Course::all();
        return view('chief_accountant.finances.edit', compact('finance', 'students', 'courses'));
    }

    public function updateFinance(Request $request, $id)
    {
        $finance = \App\Models\StudentFinance::findOrFail($id);
        $validated = $request->validate([
            'student_id' => 'required|exists:students,id',
            'type' => 'required|string|max:255',
            'montant' => 'required|numeric|min:0',
            'status' => 'required|string|max:50',
            'description' => 'nullable|string',
            'course_id' => 'nullable|exists:courses,id',
            'extra' => 'nullable|array',
        ]);
        if (isset($validated['extra'])) {
            $validated['extra'] = json_encode($validated['extra']);
        }
        $finance->update($validated);
        return redirect()->route('chief.accountant.finances.list')->with('success', 'Finance modifiée avec succès.');
    }

    public function destroyFinance($id)
    {
        $finance = \App\Models\StudentFinance::findOrFail($id);
        $finance->delete();
        return redirect()->route('chief.accountant.finances.list')->with('success', 'Finance supprimée avec succès.');
    }

    // Preview endpoints (allow chief accountant to preview PDF content before export)
    public function previewIndex(Request $request)
    {
        $ptype = $request->get('ptype', 'Fiche_inscription');

        // Map default scale/quality per ptype (simple defaults)
        $map = [
            'Fiche_inscription' => ['scale' => 3, 'quality' => 3],
            'Badge' => ['scale' => 4, 'quality' => 4],
            'Diplôme' => ['scale' => 4, 'quality' => 4],
            'worked' => ['scale' => 1, 'quality' => 1],
        ];

        $cfg = $map[$ptype] ?? ['scale' => 3, 'quality' => 3];

        return view('preview.print-preview', [
            'ptype' => $ptype,
            'scale' => $cfg['scale'],
            'quality' => $cfg['quality'],
            'printName' => strtoupper($ptype),
        ]);
    }

    public function previewContent(Request $request)
    {
        $ptype = $request->get('ptype', 'Fiche_inscription');

        // allow previewing a specific student if provided
        $studentId = $request->get('student_id');

        if ($ptype === 'Fiche_inscription') {
            $student = null;
            // Defensive: ensure user still authenticated as SuperAdmin. The route is protected,
            // but fetch() from the preview wrapper may follow redirects to login if session expired.
            if (!auth()->check() || !method_exists(auth()->user(), 'isSuperAdmin') || !auth()->user()->isSuperAdmin()) {
                return '<div style="padding:20px">Vous devez être connecté en tant que SuperAdmin pour voir cette prévisualisation. Veuillez vous reconnecter.</div>';
            }

            if ($studentId) {
                // Load student basic relations; we'll set the courses relation explicitly later to filter deleted pivots
                $student = Student::with(['mention', 'parcours', 'yearLevel'])
                    ->find($studentId);
            }
            if (!$student) {
                $student = Student::with(['mention', 'parcours', 'yearLevel'])->first();
            }
            if (!$student) {
                return '<div style="padding:20px">Aucun étudiant trouvé pour la prévisualisation.</div>';
            }

            // Ensure StudentSemesterFee exists for this student's academic year & semester so recap-pdf can read persisted values
            try {
                if ($student->academic_year_id && $student->semester_id) {
                    $ssfExists = \App\Models\StudentSemesterFee::where('student_id', $student->id)
                        ->where('academic_year_id', $student->academic_year_id)
                        ->where('semester_id', $student->semester_id)
                        ->exists();
                    if (!$ssfExists) {
                        // compute and persist
                        try {
                            (new InstallmentService())->computeSemesterFees($student->fresh(), $student->academic_year_id, $student->semester_id, auth()->id() ?? null);
                            // refresh student to pick up any changes (don't force-reload courses here)
                            $student = $student->fresh(['mention', 'parcours', 'yearLevel']);
                        } catch (\Throwable $e) {
                            logger()->warning('Failed to compute StudentSemesterFee during preview for student '.$student->id.': '.$e->getMessage());
                        }
                    }
                }
            } catch (\Throwable $e) {
                // ignore and continue rendering fallback values
            }

            // Ensure the student's courses relation used by the Blade template returns only non-deleted pivots
            try {
                $courses = $student->courses()->wherePivot('deleted_at', null)->get();
                $student->setRelation('courses', $courses);
            } catch (\Throwable $e) {
                // ignore; the Blade view may re-query if necessary
            }

            // Render the existing recap pdf view (full HTML)
            $fullHtml = view('PDFexport.recap-pdf', ['student' => $student])->render();

            // Extract only the body contents (strip outer <!doctype><html><head>..</head><body>..</body></html>)
            $bodyHtml = $fullHtml;
            if (preg_match('#<body[^>]*>(.*)</body>#is', $fullHtml, $bm)) {
                $bodyHtml = $bm[1];
            }

            // Shared PDF styles (as fragment)
            $styles = '';
            if (view()->exists('layouts.pdf-style')) {
                $styles = view('layouts.pdf-style')->render();
            }

            // If the client requested full HTML (full=1), we will transform and return the complete HTML
            $returnFull = (bool)$request->get('full');

            $html = $returnFull ? $fullHtml : ($styles . $bodyHtml);

            // Convert any server filesystem paths (public_path) to web URLs so images load in browser preview
            try {
                $publicPath = str_replace('\\', '/', public_path());
                $publicPath = rtrim($publicPath, '/');
                $publicPathNormalized = $publicPath;
                $baseUrl = rtrim(url('/'), '/');

                // Normalize HTML backslashes to forward slashes for matching
                $html = str_replace('\\', '/', $html);

                // 1) Replace occurrences where the full public path appears
                if (!empty($publicPathNormalized)) {
                    $html = str_replace($publicPathNormalized, $baseUrl, $html);
                }

                // 2) Replace src/href attributes that point to filesystem paths or file:// urls
                $html = preg_replace_callback('/(src|href)=["\']([^"\']+)["\']/i', function($m) use ($baseUrl, $publicPathNormalized) {
                    $attr = $m[1];
                    $val = $m[2];
                    $valNorm = str_replace('\\', '/', $val);

                    // Keep already valid web URLs (http, https, //, data)
                    if (preg_match('#^[a-zA-Z][a-zA-Z0-9+.-]*://#', $valNorm) || strpos($valNorm, '//') === 0 || strpos($valNorm, 'data:') === 0) {
                        return $m[0];
                    }

                    // If value contains public path, map to baseUrl + relative
                    if (!empty($publicPathNormalized) && strpos($valNorm, $publicPathNormalized) !== false) {
                        $rel = substr($valNorm, strlen($publicPathNormalized));
                        $rel = ltrim($rel, '/');
                        $new = $baseUrl . '/' . $rel;
                        return $attr . '="' . $new . '"';
                    }

                    // Windows drive absolute path like C:/... or file:///C:/...
                    if (preg_match('#^[A-Za-z]:/#', $valNorm) || preg_match('#^file:///#i', $valNorm) || preg_match('#^file://#i', $valNorm)) {
                        $parts = explode('/', $valNorm);
                        $file = end($parts);
                        $new = $baseUrl . '/' . ltrim($file, '/');
                        return $attr . '="' . $new . '"';
                    }

                    // Relative storage path (storage/...) -> map to baseUrl/storage/...
                    if (strpos($valNorm, 'storage/') === 0) {
                        $new = $baseUrl . '/' . ltrim($valNorm, '/');
                        return $attr . '="' . $new . '"';
                    }

                    // If it's an absolute path on the domain (starts with /), keep as-is
                    if (strpos($valNorm, '/') === 0) {
                        return $attr . '="' . $valNorm . '"';
                    }

                    // Fallback: return the original value
                    return $m[0];
                }, $html);

                // 3) Replace CSS url(...) occurrences
                $html = preg_replace_callback('/url\(([^)]+)\)/i', function($m) use ($baseUrl, $publicPathNormalized) {
                    $inside = trim($m[1], " \"'\t\n\r");
                    $valNorm = str_replace('\\', '/', $inside);

                    if (preg_match('#^[a-zA-Z][a-zA-Z0-9+.-]*://#', $valNorm) || strpos($valNorm, '//') === 0 || strpos($valNorm, 'data:') === 0) {
                        return 'url(' . $inside . ')';
                    }

                    if (!empty($publicPathNormalized) && strpos($valNorm, $publicPathNormalized) !== false) {
                        $rel = substr($valNorm, strlen($publicPathNormalized));
                        $rel = ltrim($rel, '/');
                        $new = $baseUrl . '/' . $rel;
                        return 'url(' . $new . ')';
                    }

                    if (preg_match('#^[A-Za-z]:/#', $valNorm) || preg_match('#^file:///#i', $valNorm) || preg_match('#^file://#i', $valNorm)) {
                        $parts = explode('/', $valNorm);
                        $file = end($parts);
                        $new = $baseUrl . '/' . ltrim($file, '/');
                        return 'url(' . $new . ')';
                    }

                    if (strpos($valNorm, 'storage/') === 0) {
                        $new = $baseUrl . '/' . ltrim($valNorm, '/');
                        return 'url(' . $new . ')';
                    }

                    return 'url(' . $inside . ')';
                }, $html);

                // 4) Try to inline local images (<img src="...">) as data URIs so preview loads even when files are not publicly served
                $html = preg_replace_callback('/<img[^>]+src=["\']([^"\']+)["\'][^>]*>/i', function($m) use ($baseUrl, $publicPathNormalized) {
                    $orig = $m[0];
                    $src = $m[1];
                    $srcNorm = str_replace('\\', '/', $src);

                    // skip already data or remote URLs
                    if (strpos($srcNorm, 'data:') === 0 || preg_match('#^[a-zA-Z][a-zA-Z0-9+.-]*://#', $srcNorm) || strpos($srcNorm, '//') === 0) {
                        return $orig;
                    }

                    $fs = null;

                    // If URL starts with baseUrl, map back to public path
                    if (!empty($baseUrl) && strpos($srcNorm, $baseUrl) === 0) {
                        $rel = substr($srcNorm, strlen($baseUrl));
                        $rel = ltrim($rel, '/');
                        $candidate = $publicPathNormalized . '/' . $rel;
                        if (file_exists($candidate)) $fs = $candidate;
                    }

                    // If it's an absolute path on the domain (/storage/...), map to public_path
                    if (!$fs && strpos($srcNorm, '/') === 0) {
                        $candidate = public_path(ltrim($srcNorm, '/'));
                        if (file_exists($candidate)) $fs = $candidate;
                    }

                    // If it looks like storage/filename
                    if (!$fs && strpos($srcNorm, 'storage/') === 0) {
                        $candidate = public_path($srcNorm);
                        if (file_exists($candidate)) $fs = $candidate;
                    }

                    // Windows drive path or file://
                    if (!$fs) {
                        $tmp = preg_replace('#^file:///#i', '', $srcNorm);
                        $tmp = preg_replace('#^file://#i', '', $tmp);
                        $tmp = str_replace('/', DIRECTORY_SEPARATOR, $tmp);
                        if (preg_match('#^[A-Za-z]:\\#', $tmp) && file_exists($tmp)) {
                            $fs = $tmp;
                        }
                    }

                    if ($fs && is_readable($fs)) {
                        try {
                            $data = file_get_contents($fs);
                            if ($data !== false) {
                                $finfo = finfo_open(FILEINFO_MIME_TYPE);
                                $mime = $finfo ? finfo_file($finfo, $fs) : mime_content_type($fs);
                                if ($finfo) finfo_close($finfo);
                                if (!$mime) $mime = 'application/octet-stream';
                                $b64 = base64_encode($data);
                                $dataUri = 'data:' . $mime . ';base64,' . $b64;

                                // replace src attribute value with data URI
                                $new = preg_replace('/(src=["\'])([^"\']+)(["\'])/i', '\\1' . $dataUri . '\\3', $orig, 1);
                                return $new;
                            }
                        } catch (\Throwable $e) {
                            // ignore and keep original
                        }
                    }

                    return $orig;
                }, $html);

            } catch (\Exception $e) {
                // If anything fails, just return the raw HTML
            }

            return $html;
        }

        // Attempt to include a blade partial under preview.partials.{ptype}
        $partial = 'preview.partials.' . $ptype;
        if (view()->exists($partial)) {
            return view($partial)->render();
        }

        // Fallback message
        return "<div style='padding:20px'>Aucun contenu de prévisualisation disponible pour <strong>{$ptype}</strong>.</div>";
    }
}
