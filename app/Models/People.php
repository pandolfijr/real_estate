<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class People extends Model
{
    use HasFactory;
    use SoftDeletes;

    const ACTIVE = '1';
    const INACTIVE = '2';
    const ALL = '3';

    protected $table = 'people';

    protected $fillable = [
        'id', 'name', 'surname', 'cpf', 'rg', 'cellphone', 'email', 'address', 'complement', 'number', 'marital_status', 'birth_date', 'district', 'id_city', 'cep', 'created_at','profession', 'cnpj'
    ];

    protected $primaryKey = 'id';

    public $incrementing = true;

    protected $keyType = 'string';

	protected $dates = [
		'created_at',
		'updated_at'
	];

    public function documents() {
        return $this->hasMany(DocumentsPeople::class, 'id_people');
    }


}
