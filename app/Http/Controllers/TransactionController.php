<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Http\Controllers\Controller;
use App\Models\Account;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class TransactionController extends Controller
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
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function transfer(Request $request)
    {
        $user = Auth::user();


        try {

            $senderAccount = Account::where('user_id', $user->id)->first();



            $validator = Validator::make($request->all(), [
                'recipient_account_id' => 'required|exists:accounts,id',
                'amount' => 'required|numeric|min:1',
            ]);

            if ($validator->fails()) {
                return response()->json(['error' => $validator->errors()], 422);
            }

            $recipientAccount = Account::findOrFail($request->recipient_account_id);

            if ($senderAccount->Solde_actuel < $request->amount) {
                return response()->json(['error' => 'Le solde du compte expéditeur est insuffisant.'], 422);
            }

            $senderAccount->update(['Solde_actuel' => $senderAccount->Solde_actuel - $request->amount]);
            $recipientAccount->update(['Solde_actuel' => $recipientAccount->Solde_actuel + $request->amount]);

            $transaction =  Transaction::create([
                'sender_account_id' => $senderAccount->id,
                'recipient_account_id' => $recipientAccount->id,
                'amount' => $request->amount,
            ]);

            return response()->json(['message' => 'Le transfert a été effectué avec succès.' , "transaction" => $transaction], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erreur: ' . $e->getMessage()], 500);
        }
    }


    public function transactionHistory()
    {
        $user = Auth::user();

        try {
            $senderTransactions = Transaction::where('sender_account_id', $user->id)
                ->select('amount', 'sender_account_id', 'recipient_account_id')
                ->with('recipient')
                ->get();

            $recipientTransactions = Transaction::where('recipient_account_id', $user->id)
                ->select('amount', 'sender_account_id', 'recipient_account_id')
                ->with('sender')
                ->get();

            return response()->json([
                'sender_transactions' => $senderTransactions,
                'recipient_transactions' => $recipientTransactions
            ], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erreur: ' . $e->getMessage()], 500);
        }
    }







    /**
     * Display the specified resource.
     */
    public function show(Transaction $transaction)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Transaction $transaction)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Transaction $transaction)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Transaction $transaction)
    {
        //
    }
}
