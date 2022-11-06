<?php

namespace App\Models;


use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MsKategoriPelanggaran extends Model
{
    use Uuid;
    use SoftDeletes;
    public $incrementing = false;
    protected $table = 'master_kategori_pelanggaran';
    protected $primaryKey = 'id_pelanggaran';
    public $keyType = 'string';

    protected $guarded = [];
}
