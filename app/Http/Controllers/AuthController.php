<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function regester(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'nom' => 'required|string|min:3|max:30',
                'prenom' => 'required|string|min:3|max:30',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:8',
            ]);

            if ($validator->fails()) {
                return response()->json(['error' => $validator->errors()], 422);
            }

            $user = User::create([
                'nom' => $request->nom,
                'prenom' => $request->prenom,
                'email' => $request->email,
                'password' => bcrypt($request->password),
            ]);

            return response()->json(['message' => 'Utilisateur créé avec succès', 'user' => $user], 201);
        } catch (\Exception $e) {
            return response()->json(['error' => 'error' . $e->getMessage()], 500);
        }
    }





    // login 

    public function login(Request $request)
    {
        try {
            $credentials = $request->only('email', 'password');

            $validator = Validator::make($request->all(), [
                'email' => 'required|string|email|max:255',
                'password' => 'required|string|min:8',
            ]);

            if ($validator->fails()) {
                return response()->json(['error' => $validator->errors()], 422);
            }

            $user = User::where('email', $request->email)->first();

            if ($user && password_verify($credentials['password'], $user->password)) {


                Auth::login($user);

                $token = $user->createToken($user->nom)->plainTextToken;

                $authenticatedUser = Auth::user();

                return response()->json(['user' => $authenticatedUser, 'token' => $token], 200);
            } else {
                return response()->json(['error' => 'Email or password is incorrect'], 401);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred while processing your request'], 500);
        }
    }


    public function getUserFromToken()
    {
        $user = Auth::user();

        return response()->json(['user' => $user]);
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return response()->json(['message' => 'Déconnexion réussie']);
    }
}
