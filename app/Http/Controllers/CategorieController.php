<?php

namespace App\Http\Controllers;

use App\Models\Categorie;
use Illuminate\Http\Request;

class CategorieController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Categorie::with("articles")->get();

        return response()->json($categories, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $categorie = new Categorie();
        $categorie->nom =  $request->json("nom");
        $categorie->description =  $request->json("description");
        $categorie->save();

        return response()->json($categorie, 200);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $categorie = Categorie::where("id", $id)->with("articles")->first();

        return response()->json($categorie, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $categorie = Categorie::find($id);
        $categorie->nom =  $request->json("nom");
        $categorie->description =  $request->json("description", 200);
        $categorie->save();

        return response()->json($categorie);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $categorie = Categorie::find($id);

        $categorie->delete();

        return response()->json("Categorie supprimée avec succès", 200);
    }
}
