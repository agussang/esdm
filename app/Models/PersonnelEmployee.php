<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PersonnelEmployee extends Model
{
    protected $connection = 'pgsqlfinger';
    public $incrementing = false;
    public $timestamps = false;
    protected $table = 'personnel_employee';
    protected $primaryKey = 'id';
    public $keyType = 'string';
    protected $guarded = [];
}
