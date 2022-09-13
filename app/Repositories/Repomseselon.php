<?php
namespace App\Repositories;

use App\Models\MsEselon;
use Illuminate\Support\Facades\DB;

class Repomseselon extends Repository
{
    protected $model;

    public function __construct(MsEselon $model)
    {
        $this->model = $model;
    }

    public function get($with = null)
    {
        return $this->model->orderBy('namaeselon','asc')
            ->get();
    }
}