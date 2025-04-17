<?php

namespace App\Http\Controllers;

use App\Models\Animal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AnimalController extends Controller
{
    public function index(Request $request)
    {
        try {
            $proprietaireId = $request->query('proprietaire_id');
            if ($proprietaireId) {
                $animaux = Animal::with('espece')
                    ->where('proprietaire_id', $proprietaireId)
                    ->get();
            } else {
                $animaux = Animal::with('espece')->get();
            }
            return response()->json(['data' => $animaux], 200);
        } catch (\Exception $e) {
            Log::error('Erreur lors de la récupération des animaux: ' . $e->getMessage());
            return response()->json([
                'message' => 'Erreur lors de la récupération des animaux',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nom' => 'required|string|max:255',
            'race' => 'nullable|string|max:255',
            'date_naissance' => 'nullable|date',
            'espece_id' => 'required|exists:especes,id',
            'proprietaire_id' => 'required|exists:proprietaires,id',
            'age' => 'nullable|integer|min:0',
            'poids' => 'nullable|numeric|min:0'
        ]);

        try {
            Log::info('Données reçues:', $request->all());

            // S'assurer que race n'est jamais null
            $validatedData['race'] = $validatedData['race'] ?? '';

            $animal = Animal::create($validatedData);
            $animal->load('espece');

            Log::info('Animal créé avec succès:', ['id' => $animal->id]);

            return response()->json([
                'message' => 'Animal créé avec succès',
                'data' => $animal
            ], 201);
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Erreur de validation:', ['errors' => $e->errors()]);
            return response()->json([
                'message' => 'Erreur de validation',
                'errors' => $e->errors()
            ], 422);

        } catch (\Exception $e) {
            Log::error('Erreur lors de la création de l\'animal: ' . $e->getMessage());
            return response()->json([
                'message' => 'Erreur lors de la création de l\'animal',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function show($id)
    {
        try {
            $animal = Animal::with('espece')->findOrFail($id);
            return response()->json(['data' => $animal], 200);
        } catch (\Exception $e) {
            Log::error('Erreur lors de la récupération de l\'animal: ' . $e->getMessage());
            return response()->json([
                'message' => 'Animal non trouvé ou erreur',
                'error' => $e->getMessage()
            ], 404);
        }
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'nom' => 'required|string|max:255',
            'race' => 'nullable|string|max:255',
            'date_naissance' => 'nullable|date',
            'espece_id' => 'required|exists:especes,id',
            'proprietaire_id' => 'required|exists:proprietaires,id',
            'age' => 'nullable|integer|min:0',
            'poids' => 'nullable|numeric|min:0'
        ]);

        try {
            $animal = Animal::findOrFail($id);
            $animal->update($validatedData);
            $animal->load('espece');

            return response()->json([
                'message' => 'Animal mis à jour avec succès',
                'data' => $animal
            ], 200);
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Erreur de validation:', ['errors' => $e->errors()]);
            return response()->json([
                'message' => 'Erreur de validation',
                'errors' => $e->errors()
            ], 422);

        } catch (\Exception $e) {
            Log::error('Erreur lors de la mise à jour de l\'animal: ' . $e->getMessage());
            return response()->json([
                'message' => 'Erreur lors de la mise à jour de l\'animal',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $animal = Animal::findOrFail($id);
            $animal->delete();
            return response()->json(['message' => 'Animal supprimé avec succès'], 200);
        } catch (\Exception $e) {
            Log::error('Erreur lors de la suppression de l\'animal: ' . $e->getMessage());
            return response()->json([
                'message' => 'Erreur lors de la suppression',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function getAnimauxByProprietaire($id)
    {
        try {
            $animaux = Animal::with('espece')
                ->where('proprietaire_id', $id)
                ->get();
            
            if ($animaux->isEmpty()) {
                return response()->json([
                    'data' => []
                ], 200);
            }

            return response()->json([
                'data' => $animaux
            ], 200);
        } catch (\Exception $e) {
            Log::error('Erreur lors de la récupération des animaux: ' . $e->getMessage());
            return response()->json([
                'message' => 'Erreur lors de la récupération des animaux',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
