<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class KeyProperty extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'keys_property';

    protected $fillable = [
        'id', 'quantity', 'description', 'observations', 'id_property'
    ];

    protected $primaryKey = 'id';

    public $incrementing = true;

    protected $keyType = 'string';
}
