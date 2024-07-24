<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Installment extends Model
{
    use HasFactory;

    use SoftDeletes;

    const INSTALLMENT_SALE = 1;
    const INSTALLMENT_RENT = 2;

    const INSTALLMENT_PENDING = 1;
    const INSTALLMENT_RECEIVED = 2;
    const INSTALLMENT_LATE = 3;

    const INSTALLMENT_STATUS_TRANSFER_PENDING = 0;

    const INSTALLMENT_STATUS_TRANSFER_DONE = 1;


    protected $table = 'installments';

    protected $fillable = [
        'id', 'current_installment', 'total_installments', 'status', 'due_date', 'date_received', 'description', 'identification_code',
        'observations', 'type_installment', 'id_transact', 'id_locator', 'id_property', 'created_at', 'updated_at', 'payment_method', 'id_check',
        'installment_value', 'insurance_value', 'insurance_number', 'installment_total_value', 'id_renter', 'penalty_value', 'discount_value',
        'id_casher', 'id_bank_account', 'status_transfer', 'id_casher_transfer', 'id_bank_account_transfer'
    ];

    protected $primaryKey = 'id';

    public $incrementing = true;

    protected $keyType = 'string';

    public function locator()
    {
        return $this->belongsTo(Locator::class, 'id_locator');
    }

    public function property()
    {
        return $this->belongsTo(Property::class, 'id_property');
    }

    public function renter()
    {
        return $this->belongsTo(Renter::class, 'id_renter');
    }

    public function bank_account()
    {
        return $this->belongsTo(BankAccount::class, 'id_bank_account')->withTrashed();
    }

    public function transaction()
    {
        return $this->hasMany(Transaction::class, 'id_transact');
    }

    public function casher()
    {
        return $this->belongsTo(Casher::class, 'id_casher_transfer');
    }
}
