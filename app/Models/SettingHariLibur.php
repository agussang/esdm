<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SettingHariLibur extends Model
{
    use Uuid;
    use SoftDeletes;
    public $incrementing = false;
    protected $table = 'setting_hari_libur';
    protected $primaryKey = 'id_hari_libur';
    public $keyType = 'string';

    protected $guarded = [];
}
