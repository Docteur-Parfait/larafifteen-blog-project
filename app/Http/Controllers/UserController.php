<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function register(Request $request)
    {
        //validate the request
        $validator = Validator::make($request->json()->all(), [
            "nom" => "required",
            "prenom" => "required",
            "name" => "required",
            "email" => "required|unique:users,email",
            "password" => "required",
        ]);

        // Verifier si la validation a échoué
        if ($validator->fails()) {
            Log::error(serialize($validator->errors()));

            return response()->json([
                "status" => "FAIL",
                "errors" => $validator->errors()
            ]);
        }

        // Enregistrement dans la BDD
        $user = User::create([
            "nom" => $request->json("nom"),
            "prenom" => $request->json("prenom"),
            "name" => $request->json("name"),
            "email" => $request->json("email"),
            "password" => Hash::make($request->json("password")), //On hash le mot de passe
        ]);

        return response()->json([
            "status" => "SUCCESS",
            "information" => $user
        ]);
    }

    public function login(Request $request)
    {
        //validate the request
        $validator = Validator::make($request->json()->all(), [
            "email" => "required",
            "password" => "required",
        ]);

        // Verifier si la validation a échoué
        if ($validator->fails()) {
            Log::error(serialize($validator->errors()));

            return response()->json([
                "status" => "FAIL",
                "errors" => $validator->errors()
            ]);
        }

        // Verification
        $user = User::where("email", $request->json("email"))->first();

        if (!$user) {
            return response()->json([
                "status" => "FAIL",
                "errors" => "Votre email est incorrect!"
            ]);
        }

        // On verifie si le mot de passe est correct
        if (Hash::check($request->json("password"), $user->password)) {
            // Connexion de l'utilisateur
            Auth::login($user);

            // Creation de token
            $token = $user->createToken("LARAFIFTEEN")->plainTextToken;

            return response()->json([
                "status" => "SUCCESS",
                "information" => [
                    "user" => $user,
                    "token" => $token
                ]
            ]);
        }

        // On retourne l'erreur du mot de passe
        return response()->json([
            "status" => "FAIL",
            "errors" => "Votre mot de passe est incorrect!"
        ]);
    }
}
