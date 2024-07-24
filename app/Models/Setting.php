<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Setting extends Model
{
    use HasFactory;

    public const SETTINGS_FOLDER = 'images_setting/';

    protected $table = 'settings';

    protected $fillable = [
        'id', 'fantasy_name', 'company_name', 'owner_name', 'menu_logo',
        'icon_logo', 'map', 'address', 'number', 'district', 'cep',
        'first_email', 'second_email', 'third_email', 'first_telephone',
        'second_telephone', 'third_telephone', 'first_whatsapp', 'second_whatsapp',
        'third_whatsapp', 'twitter', 'facebook', 'instagram', 'skype',
        'linkedin', 'youtube', 'opening_time', 'closing_time', 'id_city', 'administrative_tax'
    ];

    protected $primaryKey = 'id';

    public $incrementing = true;

    protected $keyType = 'string';
}
