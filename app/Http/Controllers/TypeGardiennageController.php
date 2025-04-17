<?php

namespace App\Http\Controllers;

use App\Models\TypeGardiennage;
use Illuminate\Http\Request;

class TypeGardiennageController extends Controller
{
    // Récupérer tous les types de gardiennage
    public function index()
    {
        return response()->json(TypeGardiennage::all(), 200);
    }

    // Récupérer un type de gardiennage par ID
    public function show($id)
    {
        $typeGardiennage = TypeGardiennage::with('tarifications', 'boxes')->find($id);

        if (!$typeGardiennage) {
            return response()->json(['message' => 'Type de gardiennage non trouvé'], 404);
        }

        return response()->json($typeGardiennage, 200);
    }

    // Ajouter un nouveau type de gardiennage
    public function store(Request $request)
    {
        $request->validate([
            'libelle' => 'required|string|max:255'
        ]);

        $typeGardiennage = TypeGardiennage::create($request->all());
        return response()->json($typeGardiennage, 201);
    }

    // Modifier un type de gardiennage existant
    public function update(Request $request, $id)
    {
        $typeGardiennage = TypeGardiennage::find($id);

        if (!$typeGardiennage) {
            return response()->json(['message' => 'Type de gardiennage non trouvé'], 404);
        }

        $request->validate([
            'libelle' => 'string|max:255'
        ]);

        $typeGardiennage->update($request->all());
        return response()->json($typeGardiennage, 200);
    }

    // Supprimer un type de gardiennage
    public function destroy($id)
    {
        $typeGardiennage = TypeGardiennage::find($id);

        if (!$typeGardiennage) {
            return response()->json(['message' => 'Type de gardiennage non trouvé'], 404);
        }

        $typeGardiennage->delete();
        return response()->json(['message' => 'Type de gardiennage supprimé'], 200);
    }
}
