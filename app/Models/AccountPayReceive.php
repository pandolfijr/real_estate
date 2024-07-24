<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AccountPayReceive extends Model
{
    use HasFactory;
    use SoftDeletes;

    //status
    const PENDING = '1';
    const PAIDOUT  = '2';
    const LATE = '3';


    //type
    const TO_PAY = 1;
    const TO_RECEIVE = 2;


    protected $table = 'accounts_pay_receive';

    protected $fillable = [
        'id', 'description', 'original_value', 'penalty_value', 'final_value', 'type', 'status', 'payment_method', 'category', 'observations',
        'discharge_date', 'expect_date', 'id_supplier', 'id_check', 'created_at', 'updated_at', 'deleted_at', 'id_property', 'id_transaction',
        'id_renter', 'id_bank_account', 'id_casher', 'discount_value', 'id_locator'
    ];

    protected $primaryKey = 'id';

    public $incrementing = true;

    protected $keyType = 'string';

    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'id_supplier')->withTrashed();
    }

    public function bank_account()
    {
        return $this->belongsTo(BankAccount::class, 'id_bank_account')->withTrashed();
    }

    public function locator()
    {
        return $this->belongsTo(Locator::class, 'id_locator')->withTrashed();
    }

    public function property()
    {
        return $this->belongsTo(Property::class, 'id_property')->withTrashed();
    }
}
