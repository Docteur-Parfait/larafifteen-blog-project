<?php

namespace App\Http\Controllers;

use App\Models\Categorie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

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
        try {
            $validator = Validator::make($request->json()->all(), [
                "nom" => "required|unique:categories,nom",
                "description" => "required|max:20"
            ], [
                "nom.unique" => "Ce nom existe déjà"
            ]);

            $validator->validate();


            $categorie = new Categorie();
            $categorie->nom =  $request->json("nom");
            $categorie->description =  $request->json("description");
            $categorie->save();

            Log::info("la categorie $categorie->nom a été ajouté avec succès par Parfait");

            return response()->json($categorie, 200);
        } catch (ValidationException $e) {

            return response()->json($e->validator->errors());
        } catch (\Exception $e) {

            return response()->json($e);
        }
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
