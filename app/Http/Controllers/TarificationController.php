<?php

namespace App\Http\Controllers;

use App\Models\Tarification;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class TarificationController extends Controller
{
    // Récupérer toutes les tarifications
    public function index(Request $request): JsonResponse
    {
        $query = Tarification::query();
        
        // Filtrer par pension_id si fourni
        if ($request->has('pension_id')) {
            $query->where('pension_id', $request->pension_id);
        }
        
        $tarifications = $query->get();
        return response()->json($tarifications, 200);
    }

    // Récupérer une tarification par ID
    public function show(int $id): JsonResponse
    {
        $tarification = Tarification::findOrFail($id);
        return response()->json($tarification, 200);
    }

    // Ajouter une nouvelle tarification
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'TypeGardiennage_id' => 'required|exists:typegardiennage,id',
            'Tarif' => 'required|numeric',
            'pension_id' => 'required|exists:pension,id'
        ]);

        $tarification = Tarification::create($validated);
        return response()->json($tarification, 201);
    }

    // Modifier une tarification existante
    public function update(Request $request, int $id): JsonResponse
    {
        $tarification = Tarification::findOrFail($id);
        
        $validated = $request->validate([
            'TypeGardiennage_id' => 'exists:typegardiennage,id',
            'Tarif' => 'numeric',
            'pension_id' => 'exists:pension,id'
        ]);

        $tarification->update($validated);
        return response()->json($tarification, 200);
    }

    // Supprimer une tarification
    public function destroy(int $id): JsonResponse
    {
        $tarification = Tarification::findOrFail($id);
        $tarification->delete();
        return response()->json(['message' => 'Tarification supprimée'], 200);
    }
}
