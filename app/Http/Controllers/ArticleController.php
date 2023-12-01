<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    public function index()
    {
        $articles = Article::with("categorie")->get();

        return response()->json($articles, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $article = new Article();
        $article->categorie_id =  $request->json("categorie_id");
        $article->nom =  $request->json("nom");
        $article->description =  $request->json("description");
        $article->auteur =  $request->json("auteur");
        $article->tags =  $request->json("tags");
        $article->contenu =  $request->json("contenu");
        $article->save();

        return response()->json($article, 200);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $article = Article::where("id", $id)->with("categorie")->first();

        return response()->json($article, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $article = Article::find($id);
        $article->categorie_id =  $request->json("categorie_id");
        $article->nom =  $request->json("nom");
        $article->description =  $request->json("description");
        $article->auteur =  $request->json("auteur");
        $article->tags =  $request->json("tags");
        $article->contenu =  $request->json("contenu");
        $article->save();

        return response()->json($article);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $article = Article::find($id);

        $article->delete();

        return response()->json("article supprimée avec succès", 200);
    }
}
