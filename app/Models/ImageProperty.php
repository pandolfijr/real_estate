<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ImageProperty extends Model
{
    use HasFactory;
    use SoftDeletes;

    public const IMAGES_FOLDER = 'images_property/';
    public const SETTINGS_FOLDER = 'images_setting/';
    public const BACKUP_FOLDER = 'images_backup/';

    protected $table = 'images_property';

    protected $fillable = [
        'id', 'description', 'main', 'folder', 'id_property'
    ];

    protected $primaryKey = 'id';

    public $incrementing = true;

    protected $keyType = 'string';

    public function property()
    {
        return $this->belongsTo(Property::class, 'id_property');
    }
}
