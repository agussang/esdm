<?php
namespace App\Repositories;

use App\Models\User;
use Illuminate\Support\Facades\DB;

class Repouser extends Repository
{
    protected $model;

    public function __construct(User $model)
    {
        $this->model = $model;
    }

    public function get($with = null)
    {
        return $this->model->orderBy('created_at','asc')
            ->get();
    }

    public function paginate($with = null,$text = null, $id_role = null)
    {
        return $this->model
            ->when($with, function ($query) use ($with) {
                return $query->with($with);
            })->when($text, function ($query) use ($text) {
                return $query->whereRaw("( trim(lower(nama_user)) like '%$text%' or trim(lower(username)) = '%$text%' )");
            })->when($id_role, function ($query) use ($id_role) {
                return $query->where('id_role', $id_role);
            })->orderBy('created_at','desc')->paginate(25);
    }
}