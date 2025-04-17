<?php

namespace App\Http\Controllers;

use App\Models\Affectation;
use Illuminate\Http\Request;

class AffectationController extends Controller
{
    // Récupérer toutes les affectations
    public function index()
    {
        return response()->json(Affectation::all(), 200);
    }

    // Récupérer une seule affectation
    public function show($id)
    {
        $affectation = Affectation::with('boxes')->find($id);

        if (!$affectation) {
            return response()->json(['message' => 'Affectation non trouvée'], 404);
        }

        return response()->json($affectation, 200);
    }

    // Créer une nouvelle affectation
    public function store(Request $request)
    {
        $affectation = Affectation::create($request->all());
        return response()->json($affectation, 201);
    }

    // Mettre à jour une affectation
    public function update(Request $request, $id)
    {
        $affectation = Affectation::find($id);

        if (!$affectation) {
            return response()->json(['message' => 'Affectation non trouvée'], 404);
        }

        $affectation->update($request->all());
        return response()->json($affectation, 200);
    }

    public function destroy($id)
    {
        $affectation = Affectation::find($id);

        if (!$affectation) {
            return response()->json(['message' => 'Affectation non trouvée'], 404);
        }

        $affectation->delete();
        return response()->json(['message' => 'Affectation supprimée'], 200);
    }
}
