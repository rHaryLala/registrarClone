<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;

class ExportPreviewController extends Controller
{
    // Show the preview wrapper
    public function index(Request $request)
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

    // Return the content fragment to preview (selected by ptype)
    public function content(Request $request)
    {
        $ptype = $request->get('ptype', 'Fiche_inscription');

        // allow previewing a specific student if provided
        $studentId = $request->get('student_id');

        // For Fiche_inscription, reuse existing blade if present and pass a sample student
        if ($ptype === 'Fiche_inscription') {
            $student = null;
            if ($studentId) {
                $student = Student::find($studentId);
            }
            if (!$student) {
                $student = Student::first();
            }
            if (!$student) {
                return '<div style="padding:20px">Aucun étudiant trouvé pour la prévisualisation.</div>';
            }

            // Render the existing recap pdf view as fragment
            $html = view('PDFexport.recap-pdf', ['student' => $student])->render();

            // Prepend the shared PDF styles so the preview renders correctly
            if (view()->exists('layouts.pdf-style')) {
                $styles = view('layouts.pdf-style')->render();
                $html = $styles . $html;
            }

            // Convert any server filesystem paths (public_path) to web URLs so images load in browser preview
            try {
                $publicPath = str_replace('\\', '/', public_path());
                $baseUrl = rtrim(url('/'), '/');

                // Normalize HTML backslashes to forward slashes for matching
                $html = str_replace('\\', '/', $html);

                // Replace occurrences of the public path with the site base URL
                if (!empty($publicPath)) {
                    $html = str_replace($publicPath, $baseUrl, $html);
                }

                // Also replace any absolute filesystem paths that might not match public_path exactly
                // e.g. Windows drive letters like D:/.../public
                $html = preg_replace_callback('#[A-Za-z]:/[^"\'> ]+#', function($m) use ($baseUrl, $publicPath) {
                    $candidate = $m[0];
                    $candidate = str_replace('\\', '/', $candidate);
                    if (strpos($candidate, $publicPath) !== false) {
                        return str_replace($publicPath, $baseUrl, $candidate);
                    }
                    // fallback: try to find the filename at the end and map to base url
                    $parts = explode('/', $candidate);
                    $file = end($parts);
                    return $baseUrl . '/' . $file;
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
