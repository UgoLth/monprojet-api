<?php

namespace App\Http\Controllers;

use App\Models\Espece;
use Illuminate\Http\Request;

class EspeceController extends Controller
{
    public function index()
    {
        try {
            $especes = Espece::all();
            return response()->json([
                'data' => $especes
            ]);
        } catch (\Exception $e) {
            \Log::error('Erreur lors de la récupération des espèces: ' . $e->getMessage());
            return response()->json([
                'message' => 'Erreur lors de la récupération des espèces',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nom' => 'required|string|max:255'
        ]);

        try {
            $espece = Espece::create($validatedData);
            return response()->json([
                'message' => 'Espèce créée avec succès',
                'data' => $espece
            ], 201);
        } catch (\Exception $e) {
            \Log::error('Erreur lors de la création de l\'espèce: ' . $e->getMessage());
            return response()->json([
                'message' => 'Erreur lors de la création de l\'espèce',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function show($id)
    {
        try {
            $espece = Espece::findOrFail($id);
            return response()->json([
                'data' => $espece
            ]);
        } catch (\Exception $e) {
            \Log::error('Erreur lors de la récupération de l\'espèce: ' . $e->getMessage());
            return response()->json([
                'message' => 'Erreur lors de la récupération de l\'espèce',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'nom' => 'required|string|max:255'
        ]);

        try {
            $espece = Espece::findOrFail($id);
            $espece->update($validatedData);
            return response()->json([
                'message' => 'Espèce mise à jour avec succès',
                'data' => $espece
            ]);
        } catch (\Exception $e) {
            \Log::error('Erreur lors de la mise à jour de l\'espèce: ' . $e->getMessage());
            return response()->json([
                'message' => 'Erreur lors de la mise à jour de l\'espèce',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $espece = Espece::findOrFail($id);
            $espece->delete();
            return response()->json([
                'message' => 'Espèce supprimée avec succès'
            ]);
        } catch (\Exception $e) {
            \Log::error('Erreur lors de la suppression de l\'espèce: ' . $e->getMessage());
            return response()->json([
                'message' => 'Erreur lors de la suppression de l\'espèce',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
