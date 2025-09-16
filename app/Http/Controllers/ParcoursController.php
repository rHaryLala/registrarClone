<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Parcours;

class ParcoursController extends Controller
{
    // Retourne les parcours liés à une mention (JSON)
    public function getByMention($mentionId)
    {
        $parcours = Parcours::where('mention_id', $mentionId)->get(['id', 'nom']);
        return response()->json($parcours);
    }
}
