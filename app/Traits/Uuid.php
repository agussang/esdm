<?php

namespace App\Traits;

use Illuminate\Support\Str;
use Session;

trait Uuid
{
    /**
     * Boot function from Laravel.
     */
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->incrementing = false;
            $model->keyType = 'string';
            $model->{$model->getKeyName()} = Str::uuid()->toString();
            $model->id_updater = Session::get('ss_siakadu')['id_pengguna'];
        });
    }
}
