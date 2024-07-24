<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DocumentsPeople extends Model
{
    use HasFactory;
    use SoftDeletes;

    public const IMAGES_FOLDER = 'documents_people/';

    protected $table = 'documents_people';

    protected $fillable = [
        'id', 'description', 'main', 'folder', 'id_people'
    ];

    protected $primaryKey = 'id';

    public $incrementing = true;

    protected $keyType = 'string';

    public function people()
    {
        return $this->belongsTo(People::class, 'id_people');
    }
}
