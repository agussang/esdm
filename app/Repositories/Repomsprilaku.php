<?php
namespace App\Repositories;

use App\Models\MsPrilaku;
use Illuminate\Support\Facades\DB;

class Repomsprilaku extends Repository
{
    protected $model;

    public function __construct(MsPrilaku $model)
    {
        $this->model = $model;
    }

    public function get($with = null)
    {
        return $this->model
            ->when($with, function ($query) use ($with) {
                return $query->with($with);
            })->orderBy('kode','asc')
            ->get();
    }
}