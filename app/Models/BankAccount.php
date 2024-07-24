<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BankAccount extends Model
{
    use HasFactory;

    use SoftDeletes;
    const ACTIVE = '1';
    const INACTIVE = '2';
    const ALL = '3';
    protected $table = 'bank_accounts';

    protected $fillable = [
        'id', 'bank_code', 'bank_name', 'agency', 'account', 'account_type', 'account_name', 'locator', 'agreement', 'covenant'
    ];

    protected $primaryKey = 'id';

    public $incrementing = true;

    protected $keyType = 'string';


}
