<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Condo extends Model
{
    use HasFactory;

    use SoftDeletes;

    const ACTIVE = '1';
    const INACTIVE = '2';
    const ALL = '3';

    protected $table = 'condos';

    protected $fillable = [
        'id', 'description', 'type', 'number_floors', 'number_towers', 'number_lots', 'number_courts', 'address', 'number', 'district', 'cep', 'id_city'
    ];

    protected $primaryKey = 'id';

    public $incrementing = true;

    protected $keyType = 'string';

    public function city()
    {
        return $this->belongsTo(City::class, 'id_city');
    }

    public function property()
    {
        return $this->hasMany(Property::class, 'id_property');
    }
}
