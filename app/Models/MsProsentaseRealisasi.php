<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuid;
use Illuminate\Database\Eloquent\SoftDeletes;

class MsProsentaseRealisasi extends Model
{
    use Uuid;
    use SoftDeletes;
    public $incrementing = false;
    protected $table = 'ms_prosentase_realisasi';
    protected $primaryKey = 'id_prosentase';
    public $keyType = 'string';

    protected $guarded = [];
}
