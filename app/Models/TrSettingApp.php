<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TrSettingApp extends Model
{
    public $incrementing = false;
    protected $table = 'tr_setting_app';
    protected $primaryKey = 'id_setting';
    public $keyType = 'string';
}
