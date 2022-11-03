<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Iclocktransaction extends Model
{
    protected $connection = 'pgsqlfinger';
    public $incrementing = false;
    public $timestamps = false;
    protected $table = 'iclock_transaction';
    protected $primaryKey = 'id';
    public $keyType = 'string';
    protected $guarded = [];

}
