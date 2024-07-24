<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Property extends Model
{
    use HasFactory;
    use SoftDeletes;

    const AVALIABLE = '1';
    const SOLD = '2';
    const RENTED = '3';
    const UNAVAILABLE = '4';
    const PURPOSE_SALE = 1;
    const PURPOSE_RENT = 2;

    protected $table = 'properties';

    protected $fillable = [
        'id', 'reference', 'description', 'address', 'number', 'district', 'display_address', 'status', 'purpose', 'type', 'cep',
        'area', 'bedrooms', 'suites', 'bathrooms', 'parking_space', 'emphasis', 'sale_value', 'rental_value', 'iptu_value', 'condo_value',
        'chronic_problem', 'apartment_number', 'court', 'tower', 'floor', 'lot', 'id_city', 'id_locator', 'id_condo', 'id_transaction',
        'administrative_tax_percentual', 'administrative_tax_value', 'id_renter'
    ];

    protected $primaryKey = 'id';

    public $incrementing = true;

    protected $keyType = 'string';

    public function city()
    {
        return $this->belongsTo(City::class, 'id_city');
    }

    public function locator()
    {
        return $this->belongsTo(Locator::class, 'id_locator');
    }

    public function condo()
    {
        return $this->belongsTo(Condo::class, 'id_condo')->withDefault();
    }

    public function pictures()
    {
        return $this->hasMany(ImageProperty::class, 'id_property');
    }

    public function keys()
    {
        return $this->belongsTo(KeyProperty::class, 'id_keys');
    }

    public function broker()
    {
        return $this->belongsTo(User::class, 'id_broker');
    }

    public function transaction()
    {
        return $this->hasMany(Transaction::class, 'id_property');
    }

    public function renter()
    {
        return $this->belongsTo(Renter::class, 'id_renter');
    }
}
