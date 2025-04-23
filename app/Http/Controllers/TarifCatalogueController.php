<?php

namespace App\Http\Controllers;

use App\Models\TarifCatalogue;
use Illuminate\Http\Request;

class TarifCatalogueController extends Controller
{
    public function index()
    {
        return TarifCatalogue::all();
    }

    public function store(Request $request)
    {
        return TarifCatalogue::create($request->only(['pension_id', 'catalogue_id', 'prix']));
    }

    public function show($id)
    {
        return TarifCatalogue::findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $tarif = TarifCatalogue::findOrFail($id);
        $tarif->update($request->only(['pension_id', 'catalogue_id', 'prix']));
        return $tarif;
    }

    public function destroy($id)
    {
        $tarif = TarifCatalogue::findOrFail($id);
        $tarif->delete();
        return response(null, 204);
    }
}
