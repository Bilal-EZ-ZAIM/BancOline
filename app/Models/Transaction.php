<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = ['amount',  'recipient_account_id', 'sender_account_id'];


    public function recipient()
    {
        return $this->hasMany(Account::class, "id" ,'recipient_account_id');
    }

    public function sender()
    {
        return $this->hasMany(Account::class, "id" ,'sender_account_id');
    }
}
