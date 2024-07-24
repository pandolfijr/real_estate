<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Supplier extends Model
{
    use HasFactory;
    use SoftDeletes;

    const ACTIVE = '1';
    const INACTIVE = '2';
    const ALL = '3';


    protected $table = 'suppliers';

    protected $fillable = [
        'id',
        'type_person',
        'cpf',
        'name',
        'cnpj',
        'address',
        'telephone',
        'cellphone',
        'email',
        'site',
        'responsible',
        'category',
        'observations',
        'id_city',
    ];

    protected $primaryKey = 'id';

    public $incrementing = true;

    protected $keyType = 'string';
}
