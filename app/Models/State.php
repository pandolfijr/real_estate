<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class State extends Model
{
    use HasFactory;

    protected $table = 'states';

    protected $fillable = [
        'id', 'name', 'country'
    ];

    protected $primaryKey = 'id';

    public $incrementing = true;

    protected $keyType = 'string';
}
