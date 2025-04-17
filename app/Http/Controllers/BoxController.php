<?php

namespace App\Http\Controllers;

use App\Models\Box;
use App\Models\Tarification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class BoxController extends Controller
{
    // Récupérer les boxes d'une tarification
    public function index(Request $request)
    {
        Log::info('Requête reçue avec les paramètres:', $request->all());
        
        try {
            $request->validate([
                'tarification_id' => 'required|exists:tarification,id'
            ]);

            $tarificationId = $request->tarification_id;
            Log::info('Recherche des boxes pour tarification_id: ' . $tarificationId);

            // Ajout d'une requête pour vérifier la tarification
            $tarification = Tarification::find($tarificationId);
            Log::info('Tarification trouvée:', ['tarification' => $tarification]);

            // Requête avec toQuery() pour voir la requête SQL
            $query = Box::where('tarification_id', $tarificationId)->orderBy('numero');
            Log::info('Requête SQL:', ['sql' => $query->toSql(), 'bindings' => $query->getBindings()]);

            $boxes = $query->get();
            Log::info('Boxes trouvés:', ['count' => $boxes->count(), 'boxes' => $boxes->toArray()]);

            return response()->json($boxes, 200);
        } catch (\Exception $e) {
            Log::error('Erreur dans BoxController@index:', ['error' => $e->getMessage()]);
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    // Récupérer un box par ID
    public function show($id)
    {
        $box = Box::find($id);

        if (!$box) {
            return response()->json(['message' => 'Box non trouvé'], 404);
        }

        return response()->json($box, 200);
    }

    // Ajouter un nouveau box
    public function store(Request $request)
    {
        Log::info('Requête de création de box reçue :', $request->all());

        // Validation
        $request->validate([
            'numero' => 'required|string|max:255',
            'taille' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'disponibilite' => 'boolean',
            'tarification_id' => 'required|exists:tarification,id'
        ]);

        Log::info('Validation passée, tarification_id = ' . $request->tarification_id);

        // Vérifier si le numéro est déjà utilisé dans cette tarification
        $existingBox = Box::where('tarification_id', $request->tarification_id)
            ->where('numero', $request->numero)
            ->first();

        if ($existingBox) {
            Log::warning('Numéro de box déjà utilisé : ' . $request->numero . ' pour tarification_id = ' . $request->tarification_id);
            return response()->json([
                'message' => 'Ce numéro de box est déjà utilisé pour cette tarification'
            ], 422);
        }

        // Si disponibilite n'est pas fourni, on met true par défaut
        if (!$request->has('disponibilite')) {
            $request->merge(['disponibilite' => true]);
        }

        $box = Box::create($request->all());
        Log::info('Box créé avec succès : ', [
            'id' => $box->id,
            'numero' => $box->numero,
            'tarification_id' => $box->tarification_id
        ]);
        
        return response()->json($box, 201);
    }

    // Modifier un box existant
    public function update(Request $request, $id)
    {
        $box = Box::find($id);

        if (!$box) {
            return response()->json(['message' => 'Box non trouvé'], 404);
        }

        // Validation
        $request->validate([
            'numero' => 'string|max:255',
            'taille' => 'string|max:255',
            'type' => 'string|max:255',
            'disponibilite' => 'boolean',
            'tarification_id' => 'exists:tarification,id'
        ]);

        // Vérifier si le nouveau numéro est déjà utilisé
        if ($request->has('numero') && $request->numero != $box->numero) {
            $existingBox = Box::where('tarification_id', $request->has('tarification_id') ? $request->tarification_id : $box->tarification_id)
                ->where('numero', $request->numero)
                ->first();

            if ($existingBox) {
                return response()->json([
                    'message' => 'Ce numéro de box est déjà utilisé pour cette tarification'
                ], 422);
            }
        }

        $box->update($request->all());
        Log::info('Box mis à jour : ' . $box->id);

        return response()->json($box, 200);
    }

    // Supprimer un box
    public function destroy($id)
    {
        $box = Box::find($id);

        if (!$box) {
            return response()->json(['message' => 'Box non trouvé'], 404);
        }

        $box->delete();
        Log::info('Box supprimé : ' . $id);

        return response()->json(['message' => 'Box supprimé avec succès'], 200);
    }
}
