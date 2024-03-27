<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Account extends Model
{
    use HasFactory;

    protected $fillable = [
        'Solde_actuel',
        'user_id',
        'numero_compte'
    ];

    public function users()
    {
        return $this->belongsTo(User::class ,  'user_id' , 'id' );
    }
}
