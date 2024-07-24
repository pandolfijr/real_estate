<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use HasFactory;

    const ACTIVE = '1';
    const INACTIVE = '2';
    const ALL = '3';

    protected $table = 'cities';

    protected $fillable = [
        'id', 'name', 'id_state'
    ];

    protected $primaryKey = 'id';

    public $incrementing = true;

    protected $keyType = 'string';

    public function state()
    {
        return $this->belongsTo(State::class, 'id_state');
    }
}
