<?php

namespace App\Http\Controllers;

use App\Models\FinanceDetail;
use App\Models\Mention;
use Illuminate\Http\Request;

class FinanceDetailController extends Controller
{
    public function index()
    {
        $details = FinanceDetail::with('mention')->get();
        return view('financedetails.index', compact('details'));
    }

    public function create()
    {
        $mentions = Mention::all();
        return view('financedetails.create', compact('mentions'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'statut_etudiant' => 'required|string',
            'mention_id' => 'nullable|exists:mentions,id',
            'frais_generaux' => 'required|numeric',
            'ecolage' => 'required|numeric',
            'laboratory' => 'required|numeric',
            'dortoir' => 'required|numeric',
            'nb_jours_semestre' => 'nullable|integer',
            'nb_jours_semestre_L2' => 'nullable|integer',
            'nb_jours_semestre_L3' => 'nullable|integer',
            'cafeteria' => 'required|numeric',
            'fond_depot' => 'required|numeric',
            'frais_graduation' => 'required|numeric',
            'frais_costume' => 'required|numeric',
            'frais_voyage' => 'required|numeric',
        ]);
        FinanceDetail::create($validated);
        return redirect()->route('financedetails.index')->with('success', 'Détail finance ajouté.');
    }

    public function show($id)
    {
        $detail = FinanceDetail::with('mention')->findOrFail($id);
        return view('financedetails.show', compact('detail'));
    }

    public function edit($id)
    {
        $detail = FinanceDetail::findOrFail($id);
        $mentions = Mention::all();
        return view('financedetails.edit', compact('detail', 'mentions'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'statut_etudiant' => 'required|string',
            'mention_id' => 'nullable|exists:mentions,id',
            'frais_generaux' => 'required|numeric',
            'ecolage' => 'required|numeric',
            'laboratory' => 'required|numeric',
            'dortoir' => 'required|numeric',
            'nb_jours_semestre' => 'nullable|integer',
            'nb_jours_semestre_L2' => 'nullable|integer',
            'nb_jours_semestre_L3' => 'nullable|integer',
            'cafeteria' => 'required|numeric',
            'fond_depot' => 'required|numeric',
            'frais_graduation' => 'required|numeric',
            'frais_costume' => 'required|numeric',
            'frais_voyage' => 'required|numeric',
        ]);
        $detail = FinanceDetail::findOrFail($id);
        $detail->update($validated);
        return redirect()->route('financedetails.index')->with('success', 'Détail finance modifié.');
    }

    public function destroy($id)
    {
        $detail = FinanceDetail::findOrFail($id);
        $detail->delete();
        return redirect()->route('financedetails.index')->with('success', 'Détail finance supprimé.');
    }
}
