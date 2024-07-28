<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaction extends Model
{
    use HasFactory;
    use SoftDeletes;

    const ACTIVE = '1';
    const INACTIVE = '2';
    const ALL = '3';

    //modality
    const MODALITY_GUARANTOR = 1;
    const MODALITY_DEPOSIT = 2;
    const MODALITY_INSURANCE = 3;

    //financial type
    const TRANSACTION_SALE = 1;
    const TRANSACTION_RENT = 2;

    //transaction type
    const TRANSACTION_TO_PAY = 1;
    const TRANSACTION_TO_RECEIVE = 2;

    //status_contract
    const CONTRACT_ACTIVE = 1;
    const CONTRACT_WON = 2;
    const CONTRACT_CANCELED = 3;

    // status account
    const STATUS_PENDING = 1;
    const STATUS_PAID = 2;
    const STATUS_LATE = 3;

    // payment method
    const PAYMENT_MONEY = 1;
    const PAYMENT_PIX = 2;
    const PAYMENT_CREDIT_CARD = 3;
    const PAYMENT_DEBIT_CARD = 4;
    const PAYMENT_CHECK = 5;

    // responsible insurance
    const RESPONSIBLE_INSURANCE_RENTER = 1;
    const RESPONSIBLE_INSURANCE_COMPANY = 2;
    protected $table = 'transactions';

    protected $fillable = [
        'id', 'contract_start_date', 'contract_end_date', 'contract_status', 'due_day', 'first_due_date', 'generation_date', 'transaction_type', 'modality', 'responsible_insurance', 'responsible_iptu', 'type_of_charge', 'observations', 'witness', 'insurance_number', 'status_transact', 'security_deposit', 'penalty_value', 'interest_month_value', 'administrative_tax', 'other_transfers', 'property_value', 'condo_value', 'iptu_value', 'final_value', 'number_installments', 'id_locator', 'id_renter', 'id_first_guarantor', 'id_second_guarantor', 'id_keys', 'id_broker', 'deleted_at', 'created_at', 'updated_at', 'id_property', 'id_condo', 'insurance_value', 'keys_return', 'termination_contract'
    ];

    protected $primaryKey = 'id';

    public $incrementing = true;

    protected $keyType = 'string';

    public function locator()
    {
        return $this->belongsTo(Locator::class, 'id_locator');
    }

    public function renter()
    {
        return $this->belongsTo(Renter::class, 'id_renter');
    }

    public function guarantor()
    {
        return $this->belongsTo(Guarantor::class, 'id_guarantor');
    }

    public function keys()
    {
        return $this->belongsTo(KeyProperty::class, 'id_keys');
    }

    public function broker()
    {
        return $this->belongsTo(User::class, 'id_broker');
    }

    public function property()
    {
        return $this->belongsTo(Property::class, 'id_property');
    }

    public function installments()
    {
        return $this->hasMany(Installment::class, 'id_transact');
    }
}
