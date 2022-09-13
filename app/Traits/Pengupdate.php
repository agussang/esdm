<?php

namespace App\Traits;

use Session;

trait Pengupdate
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
            $model->id_updater = Session::get('id_pengguna');
        });
    }
}
