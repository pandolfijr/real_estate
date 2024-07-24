<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Check extends Model
{
    use HasFactory;

    const ACTIVE = '1';
    const INACTIVE = '2';
    const ALL = '3';

    protected $table = 'checks';

    protected $fillable = [
        'id',
        'number',
        'issuance_date',
        'due_date',
        'deposit_date',
        'compensation_date',
        'bank_name',
        'bank_agency',
        'bank_account',
        'favored_name',
        'description',
        'status',
        'type',
        'id_transaction'
    ];

    protected $primaryKey = 'id';

    public $incrementing = true;

    protected $keyType = 'string';
}
