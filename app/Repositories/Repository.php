<?php

namespace App\Repositories;
use Session;

abstract class Repository
{
    protected $model;

    public function findId($with = null, $id = null, $id_field = 'id')
    {
        return $this->model
            ->when($with, function ($query) use ($with) {
                return $query->with($with);
            })
            ->when($id, function ($query) use ($id, $id_field) {
                return $query->where($id_field, $id);
            })
            ->first();
    }

    public function findWhereRaw($with = null, $whereRaw){
        return $this->model
            ->when($with, function ($query) use ($with) {
                return $query->with($with);
            })
            ->when($whereRaw, function ($query) use ($whereRaw) {
                return $query->whereRaw($whereRaw);
            })
            ->first();
    }

    public function getWhereRaw($with = null, $whereRaw,$orderby){
        return $this->model
            ->when($with, function ($query) use ($with) {
                return $query->with($with);
            })
            ->when($whereRaw, function ($query) use ($whereRaw) {
                return $query->whereRaw($whereRaw);
            })
            ->orderBy($orderby,'asc')
            ->get();
    }

    public function store($request,$user=null)
    {
        if($user==null){
            $user=Session::get('id_pengguna');
        }
        $request['id_updater'] = $user;
        return $this->model->create($request);
    }

    public function update($where, $request,$user=null)
    {
        if($user==null){
            $user=Session::get('id_pengguna');
        }
        $request['id_updater'] = $user;
        return $this->model->where($where)->update($request);
    }

    public function updatefinger($where, $request)
    {
        return $this->model->where($where)->update($request);
    }

    public function destroy($id,$id_field = 'id')
    {
        return $this->model->where($id_field,$id)->delete();
    }

    public function update_or_create($where,$request,$user=null)
    {
        if($user==null){
            $user=Session::get('id_pengguna');
        }
        $request['id_updater'] = $user;
        return $this->model->Create($where,$request);
    }

    public function updatewherenot($id,$reqnot){
        return $this->model->where('id','!=',$id)->update($reqnot);
    }
}
