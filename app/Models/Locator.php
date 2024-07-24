<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Locator extends Model
{
    use HasFactory;
    use SoftDeletes;

    const ACTIVE = '1';
    const INACTIVE = '2';
    const ALL = '3';

    protected $table = 'locators';

    protected $fillable = [
        'id', 'income', 'income_proof', 'address_proof', 'rg', 'cpf', 'id_people'
    ];

    protected $primaryKey = 'id';

    public $incrementing = true;

    protected $keyType = 'string';

    public function people()
    {
        return $this->belongsTo(People::class, 'id_people')->withTrashed();
    }

    public function property()
    {
        return $this->hasMany(Property::class, 'id_locator');
    }

    public function transaction()
    {
        return $this->hasMany(Transaction::class, 'id_locator');
    }
}
