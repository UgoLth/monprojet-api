<?php

namespace App\Http\Controllers;

use App\Models\Catalogue;
use Illuminate\Http\Request;

class CatalogueController extends Controller
{
    public function index()
    {
        return Catalogue::all();
    }

    public function store(Request $request)
    {
        return Catalogue::create($request->only(['nom']));
    }

    public function show($id)
    {
        return Catalogue::findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $catalogue = Catalogue::findOrFail($id);
        $catalogue->update($request->only(['nom']));
        return $catalogue;
    }

    public function destroy($id)
    {
        $catalogue = Catalogue::findOrFail($id);
        $catalogue->delete();
        return response(null, 204);
    }
}
