<?php

namespace App\Repositories;

interface BaseRepositoryInterface
{
    //public function errors();

    public function all(array $related = null);

    public function get($id, array $related = null);

    public function getWhere($column, $value, array $related = null);
    
    public function getWherePaginate($column, $value, $paginateCount, array $related = null, array $columns = array('*'));

    //public function getRecent($limit, array $related = null);

    public function create(array $data);
    
    public function firstOrCreate(array $data);

    public function update($id, array $data);

    public function delete($id);

    public function deleteWhere($column, $value);
}

abstract class BaseRepository implements BaseRepositoryInterface
{
    protected $model;
    
    public function all(array $related = null)
    {
        if($related)
            return $this->model->with($related)->all($related);
        return $this->model->all($related);
    }

    public function get($id, array $related = null, array $columns = array('*'))
    {
        if($related)
            return $this->model->with($related)->find($id, $columns);
        return $this->model->findOrFail($id, $columns);
    }

    public function getWhere($column, $value, array $related = null, array $columns = array('*'))
    {
        if($related)
            return $this->model->with($related)->where($column, $value)->get($columns);
        return $this->model->where($column, $value)->get($columns);
    }
    
    public function getWherePaginate($column, $value, $paginateCount, array $related = null, array $columns = array('*'))
    {
        if($related)
            return $this->model->with($related)->where($column, $value)->paginate($paginateCount, $columns);
        return $this->model->where($column, $value)->paginate($paginateCount, $columns);
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }
    
    public function firstOrCreate(array $data)
    {
        return $this->model->firstOrCreate($data);
    }

    public function update($id, array $data)
    {
        return $this->get($id)->update($data);
    }

    public function delete($id)
    {
        return $this->get($id)->delete();
    }

    public function deleteWhere($column, $value)
    {
        return $this->model->where($column, $value)->delete();
    }
}
