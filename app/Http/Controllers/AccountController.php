<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AccountController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function createAcount(Request $request)
    {
        $user = Auth::user();

        try {

            $accont = Account::where('user_id', $user->id)->first();

            if ($accont) {
                return response()->json(['message' => 'Compte déjà créé']);
            }

            $validator = Validator::make($request->all(), [
                'Solde_actuel' => 'required|numeric',
            ]);

            if ($validator->fails()) {
                return response()->json(['error' => $validator->errors()], 422);
            }

            $account = Account::create([
                'Solde_actuel' => $request->Solde_actuel,
                'user_id' => $user->id,
                'numero_compte' => 'ACC' . str_pad(mt_rand(1, 999999), 6, '0', STR_PAD_LEFT)

            ]);

            return response()->json(['message' => 'Compte créé avec succès', 'account' => $account], 201);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erreur: ' . $e->getMessage()], 500);
        }
    }


    /**
     * Store a newly created resource in storage.
     */
    public function deposit(Request $request)
    {
        $user = Auth::user();

        try {

            $account = Account::where('user_id', $user->id)->first();

            if (!$account) {
                return response()->json(['error' => 'Compte introuvable'], 404);
            }

            $validator = Validator::make($request->all(), [
                'Solde_actuel' => 'required|numeric',
            ]);

            if ($validator->fails()) {
                return response()->json(['error' => $validator->errors()], 422);
            }

            $account->update([
                'Solde_actuel' => $request->Solde_actuel + $account->Solde_actuel,
            ]);

            return response()->json(['message' => 'Dépôt effectué avec succès', 'account' => $account], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erreur: ' . $e->getMessage()], 500);
        }
    }


    /**
     * Display the specified resource.
     */
    public function show(Account $account)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Account $account)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Account $account)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Account $account)
    {
        //
    }
}
