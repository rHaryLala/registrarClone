<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;

use App\Models\YearLevel;
use App\Models\AcademicYear;
use App\Models\Semester;

class MultimediaController extends Controller
{
    /**
     * Show multimedia dashboard.
     */
    public function dashboard(Request $request)
    {
        $q = $request->query('q');

        $studentsQuery = Student::query();

        if ($q) {
            $studentsQuery->where(function ($query) use ($q) {
                $query->where('nom', 'like', "%{$q}%")
                    ->orWhere('prenom', 'like', "%{$q}%")
                    ->orWhere('matricule', 'like', "%{$q}%")
                    ->orWhere('account_code', 'like', "%{$q}%");
            });
        }

        // Order by id descending to show most recent students first
        $students = $studentsQuery->orderBy('id', 'desc')->limit(400)->get();

        // Prepare simplified arrays for client-side rendering (like SuperAdminController)
        $studentsArray = $students->map(function ($s) {
            $acadLibelle = null;
            try {
                $acadLibelle = $s->academicYear ? $s->academicYear->libelle : ($s->academic_year_id ?? null);
            } catch (\Throwable $e) {
                $acadLibelle = $s->academic_year_id ?? null;
            }

            return [
                'id' => $s->id,
                'matricule' => $s->matricule,
                'nom' => $s->nom,
                'prenom' => $s->prenom,
                'email' => $s->email ?? '',
                'mention_id' => $s->mention_id,
                'mention_nom' => $s->mention ? $s->mention->nom : '-',
                'academic_year' => $acadLibelle,
                'year_level_id' => $s->year_level_id,
                'year_level_label' => $s->yearLevel ? $s->yearLevel->label : '-',
                'account_code' => $s->account_code ?? null,
                'fee_check' => $s->fee_check ? 1 : 0,
            ];
        })->values()->toArray();

        $mentions = \App\Models\Mention::all();
        $mentionsArray = $mentions->map(function ($m) {
            return ['id' => $m->id, 'nom' => $m->nom];
        })->values()->toArray();

        $yearLevels = YearLevel::all();

        return view('multimedia.dashboard', compact('students', 'studentsArray', 'mentions', 'mentionsArray', 'yearLevels'));
    }

    /**
     * Show a single student record (multimedia view)
     */
    public function show($id)
    {
        $student = Student::with('lastChangedBy')->findOrFail($id);
        $yearLevels = YearLevel::all();
        return view('multimedia.students.show', compact('student', 'yearLevels'));
    }

    /**
     * Update fee_check via AJAX
     */
    public function updateFeeCheck(Request $request, Student $student)
    {
        $validated = $request->validate([
            'fee_check' => 'required|boolean',
        ]);

        $student->fee_check = $validated['fee_check'];
        $student->save();

        return response()->json(['success' => true, 'fee_check' => $student->fee_check]);
    }

    /**
     * Upload helper copied/adapted from SuperAdminController
     */
    private function uploadImage(Request $request)
    {
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = time() . '_' . preg_replace('/\s+/', '_', $image->getClientOriginalName());
            $directory = public_path('storage/students');
            $path = 'storage/students/' . $filename;

            if (!file_exists($directory)) {
                if (!mkdir($directory, 0777, true) && !is_dir($directory)) {
                    throw new \RuntimeException(sprintf('Directory "%s" was not created', $directory));
                }
            }

            $srcPath = $image->getRealPath();
            [$width, $height, $type] = getimagesize($srcPath);

            switch ($type) {
                case IMAGETYPE_JPEG:
                    $srcImg = imagecreatefromjpeg($srcPath);
                    break;
                case IMAGETYPE_PNG:
                    $srcImg = imagecreatefrompng($srcPath);
                    break;
                case IMAGETYPE_GIF:
                    $srcImg = imagecreatefromgif($srcPath);
                    break;
                default:
                    $image->move($directory, $filename);
                    return $path;
            }

            $side = min($width, $height);
            $src_x = ($width > $height) ? intval(($width - $height) / 2) : 0;
            $src_y = ($height > $width) ? intval(($height - $width) / 2) : 0;

            $dstImg = imagecreatetruecolor($side, $side);

            if ($type == IMAGETYPE_PNG || $type == IMAGETYPE_GIF) {
                imagecolortransparent($dstImg, imagecolorallocatealpha($dstImg, 0, 0, 0, 127));
                imagealphablending($dstImg, false);
                imagesavealpha($dstImg, true);
            }

            imagecopyresampled($dstImg, $srcImg, 0, 0, $src_x, $src_y, $side, $side, $side, $side);

            switch ($type) {
                case IMAGETYPE_JPEG:
                    imagejpeg($dstImg, $directory . '/' . $filename, 90);
                    break;
                case IMAGETYPE_PNG:
                    imagepng($dstImg, $directory . '/' . $filename);
                    break;
                case IMAGETYPE_GIF:
                    imagegif($dstImg, $directory . '/' . $filename);
                    break;
            }

            imagedestroy($srcImg);
            imagedestroy($dstImg);

            return $path;
        }

        return null;
    }

    /**
     * Update student (handle image upload and inline AJAX edits) for multimedia
     */
    public function update(Request $request, $id)
    {
        $student = Student::findOrFail($id);

        // Image upload via AJAX or form
        if ($request->hasFile('image')) {
            $request->validate([
                'image' => 'image|mimes:jpeg,png,jpg,gif'
            ]);

            $imagePath = $this->uploadImage($request);
            if ($imagePath) {
                $student->update(['image' => $imagePath]);
                return response()->json([
                    'success' => true,
                    'image_url' => asset($imagePath) . '?t=' . time()
                ]);
            }

            return response()->json(['success' => false, 'message' => 'Erreur lors du téléchargement'], 500);
        }

        // Inline AJAX quick edits
        if ($request->ajax() || $request->wantsJson()) {
            $keys = array_values(array_diff($request->keys(), ['_method', '_token']));
            $field = $keys[0] ?? null;

            $editableFields = [
                'sexe' => 'nullable|string|max:10',
                'date_naissance' => 'nullable|date',
                'lieu_naissance' => 'nullable|string|max:255',
                'nationalite' => 'nullable|string|max:255',
                'religion' => 'nullable|string|max:255',
                'etat_civil' => 'required|in:célibataire,marié,divorcé,veuf',
                'telephone' => 'nullable|string|max:255',
                'adresse' => 'nullable|string|max:255',
                'region' => 'nullable|string|max:255',
                'district' => 'nullable|string|max:255',
                'bacc_serie' => 'nullable|string|max:255',
                'bacc_date_obtention' => 'nullable|digits:4',
                'nom_conjoint' => 'nullable|string|max:255',
                'nb_enfant' => 'nullable|integer',
                'cin_numero' => 'nullable|string|max:255',
                'cin_date_delivrance' => 'nullable|date',
                'cin_lieu_delivrance' => 'nullable|string|max:255',
                'nom_pere' => 'nullable|string|max:255',
                'profession_pere' => 'nullable|string|max:255',
                'contact_pere' => 'nullable|string|max:255',
                'nom_mere' => 'nullable|string|max:255',
                'profession_mere' => 'nullable|string|max:255',
                'contact_mere' => 'nullable|string|max:255',
                'adresse_parents' => 'nullable|string|max:255',
                'sponsor_nom' => 'nullable|string|max:255',
                'sponsor_prenom' => 'nullable|string|max:255',
                'sponsor_telephone' => 'nullable|string|max:255',
                'sponsor_adresse' => 'nullable|string|max:255',
                'taille' => 'nullable|string|in:S,M,L,XL,XXL,XXXL',
                'year_level_id' => 'nullable|exists:year_levels,id',
                'mention_id' => 'nullable|exists:mentions,id',
                'parcours_id' => 'nullable|exists:parcours,id',
            ];

            if (!$field || !array_key_exists($field, $editableFields)) {
                return response()->json(['success' => false, 'message' => 'Champ non autorisé.'], 422);
            }

            $validated = $request->validate([$field => $editableFields[$field]]);

            if ($field === 'date_naissance' && $validated[$field]) {
                $validated[$field] = date('Y-m-d', strtotime($validated[$field]));
            }

            $student->update($validated);
            return response()->json(['success' => true]);
        }

        // Otherwise, treat as full form update (basic fields) - minimal implementation
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => 'required|email|unique:students,email,' . $id,
        ]);

        $student->update($validated);

        return redirect()->back()->with('success', 'Étudiant modifié avec succès.');
    }
}
