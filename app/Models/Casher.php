<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Casher extends Model
{
    use HasFactory;

    const DEPOSIT = 1;
    const OUTFLOW = 2;

    protected $table = 'casher';

    protected $fillable = [
        'id', 'action', 'previous_value', 'current_value', 'date_last_action', 'date_current_action', 'id_bank_account', 'created_at', 'updated_at', 'id_installment_transfer'
    ];

    protected $primaryKey = 'id';

    public $incrementing = true;

    protected $keyType = 'string';

    public function bank_account()
    {
        return $this->belongsTo(BankAccount::class, 'id_bank_account');
    }

    public function account()
    {
        return $this->belongsTo(AccountPayReceive::class, 'id_account_pay_receive');
    }

    public function transaction()
    {
        return $this->belongsTo(Transaction::class, 'id_transaction');
    }



}
