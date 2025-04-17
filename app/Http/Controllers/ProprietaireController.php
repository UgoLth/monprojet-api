<?php

namespace App\Http\Controllers;

use App\Models\Proprietaire;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;

class ProprietaireController extends Controller
{
    // Récupérer tous les propriétaires
    public function index()
    {
        try {
            $proprietaires = Proprietaire::all();
            return response()->json($proprietaires);
        } catch (\Exception $e) {
            Log::error('Erreur lors de la récupération des propriétaires: ' . $e->getMessage());
            return response()->json([
                'message' => 'Erreur lors de la récupération des propriétaires',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // Récupérer un propriétaire par ID
    public function show($id)
    {
        try {
            $proprietaire = Proprietaire::findOrFail($id);
            return response()->json($proprietaire);
        } catch (\Exception $e) {
            Log::error('Erreur lors de la récupération du propriétaire: ' . $e->getMessage());
            return response()->json([
                'message' => 'Erreur lors de la récupération du propriétaire',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // Ajouter un nouveau propriétaire
    public function store(Request $request)
    {
        try {
            $request->validate([
                'nom' => 'required|string|max:255',
                'prenom' => 'required|string|max:255',
                'email' => 'required|email|unique:proprietaires',
                'password' => 'required|string|min:6',
                'telephone' => 'required|string|max:20',
                'adresse' => 'required|string|max:255'
            ]);

            $proprietaire = new Proprietaire();
            $proprietaire->nom = $request->nom;
            $proprietaire->prenom = $request->prenom;
            $proprietaire->email = $request->email;
            $proprietaire->password = Hash::make($request->password);
            $proprietaire->telephone = $request->telephone;
            $proprietaire->adresse = $request->adresse;
            
            if ($proprietaire->save()) {
                return response()->json([
                    'message' => 'Propriétaire créé avec succès',
                    'proprietaire' => $proprietaire
                ], 201);
            } else {
                throw new \Exception('Erreur lors de la sauvegarde du propriétaire');
            }
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Erreur de validation: ' . $e->getMessage());
            return response()->json([
                'message' => 'Erreur de validation',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            Log::error('Erreur lors de la création du propriétaire: ' . $e->getMessage());
            return response()->json([
                'message' => 'Erreur lors de la création du propriétaire',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // Mettre à jour un propriétaire
    public function update(Request $request, $id)
    {
        try {
            $proprietaire = Proprietaire::findOrFail($id);

            $validationRules = [
                'nom' => 'required|string|max:255',
                'prenom' => 'required|string|max:255',
                'email' => 'required|email|unique:proprietaires,email,' . $id,
                'telephone' => 'required|string|max:20',
                'adresse' => 'required|string|max:255'
            ];

            // Ajouter la validation du mot de passe seulement s'il est fourni
            if ($request->has('password') && !empty($request->password)) {
                $validationRules['password'] = 'string|min:6';
            }

            $request->validate($validationRules);

            $proprietaire->nom = $request->nom;
            $proprietaire->prenom = $request->prenom;
            $proprietaire->email = $request->email;
            $proprietaire->telephone = $request->telephone;
            $proprietaire->adresse = $request->adresse;

            // Mettre à jour le mot de passe seulement s'il est fourni
            if ($request->has('password') && !empty($request->password)) {
                $proprietaire->password = Hash::make($request->password);
            }

            if ($proprietaire->save()) {
                return response()->json([
                    'message' => 'Propriétaire mis à jour avec succès',
                    'proprietaire' => $proprietaire
                ]);
            } else {
                throw new \Exception('Erreur lors de la mise à jour du propriétaire');
            }
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Erreur de validation: ' . $e->getMessage());
            return response()->json([
                'message' => 'Erreur de validation',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            Log::error('Erreur lors de la mise à jour du propriétaire: ' . $e->getMessage());
            return response()->json([
                'message' => 'Erreur lors de la mise à jour du propriétaire',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // Supprimer un propriétaire
    public function destroy($id)
    {
        try {
            $proprietaire = Proprietaire::findOrFail($id);
            if ($proprietaire->delete()) {
                return response()->json([
                    'message' => 'Propriétaire supprimé avec succès'
                ]);
            } else {
                throw new \Exception('Erreur lors de la suppression du propriétaire');
            }
        } catch (\Exception $e) {
            Log::error('Erreur lors de la suppression du propriétaire: ' . $e->getMessage());
            return response()->json([
                'message' => 'Erreur lors de la suppression du propriétaire',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
