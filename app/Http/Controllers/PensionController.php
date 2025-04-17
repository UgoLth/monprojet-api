<?php

namespace App\Http\Controllers;

use App\Models\Pension;
use Illuminate\Http\Request;

class PensionController extends Controller
{
    public function index()
    {
        return response()->json(Pension::all(), 200);
    }

    public function show($id)
    {
        $pension = Pension::with('boxes')->find($id);

        if (!$pension) {
            return response()->json(['message' => 'Pension non trouvée'], 404);
        }

        return response()->json($pension, 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'Ville' => 'required|string|max:255',
            'Adresse' => 'required|string|max:255',
            'Telephone' => 'required|string|max:20',
            'Responsable' => 'required|string|max:255',
        ]);

        $pension = Pension::create($request->all());
        return response()->json($pension, 201);
    }

    public function update(Request $request, $id)
    {
        $pension = Pension::find($id);

        if (!$pension) {
            return response()->json(['message' => 'Pension non trouvée'], 404);
        }

        $request->validate([
            'Ville' => 'string|max:255',
            'Adresse' => 'string|max:255',
            'Telephone' => 'string|max:20',
            'Responsable' => 'string|max:255',
        ]);

        $pension->update($request->all());
        return response()->json($pension, 200);
    }

    public function destroy($id)
    {
        $pension = Pension::find($id);

        if (!$pension) {
            return response()->json(['message' => 'Pension non trouvée'], 404);
        }

        $pension->delete();
        return response()->json(['message' => 'Pension supprimée'], 200);
    }
}
