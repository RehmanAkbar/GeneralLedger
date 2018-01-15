<?php

namespace Softpyramid\GeneralLedger\Repositories;

use Softpyramid\GeneralLedger\Contracts\RepositoryInterface;
use Softpyramid\GeneralLedger\Exceptions\RepositoryException;
use BadMethodCallException;
use Illuminate\Container\Container as App;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;

/**
 * Class Repository
 * @package Bosnadev\Repositories\Eloquent
 */
abstract class Repository implements RepositoryInterface {
    /**
     * @var App
     */
    private $app;
    /**
     * @var
     */
    protected $model;

    private $admin;

    /**
     * @param App $app
     * @throws \App\Erp\Exceptions\RepositoryException
     */
    public function __construct(App $app) {

        $this->app = $app;
        $this->makeModel();

    }

    /**
     * @return $this
     */
    public function instance() {
        return $this;
    }

    /**
     * Specify Model class name
     *
     * @return mixed
     */
    abstract function model();

    /**
     * @param array $columns
     * @return mixed
     */
    public function all($columns = array('*')) {


        return $this->model->get($columns);

    }


    public function allWithoutTrash($columns = array('*')){
        return $this->model->get($columns);
    }

    /**
     * @param int $perPage
     * @param array $columns
     * @return mixed
     */
    public function paginate($perPage = 15, $columns = array('*')) {

        return $this->model->paginate($perPage, $columns);
    }

    /**
     * @param array $data
     * @return mixed
     */
    public function create(array $data) {

        return $this->model->create($data);
    }

    /**
     * @param array $data
     * @return mixed
     */
    public function insert(array $data) {

        return $this->model->insert($data);
    }

    /**
     * @param array $data
     *
     * @param array $data
     * @pram array $where
     * @return mixed
     */
    public function update(Request $request, array $where) {
        $item = $this->model->where($where)->first();

        $fillable_fields = $this->model->getFillable();

        $fillable_fields = array_flip($fillable_fields);

        $data = array_intersect_key($request->all(), $fillable_fields);

        $item->update($data);

        return $item;

    }

    /**
     * @param array $where
     * @return mixed
     */
    public function delete(array $where) {

        return $this->model->where($where)->delete();
    }

    /**
     * @param array $where
     * @return mixed
     */
    public function disable(array $where) {


        return $this->model->where($where)->update(['disabled' => true]);
    }
    public function activate(array $where) {

        return $this->model->where($where)->update(['disabled' => false]);
    }

    /**
     * @param $id
     * @param array $columns
     * @return mixed
     */
    public function find($id, $columns = array('*')) {


        return $this->model->find($id, $columns);
    }

    /**
     * @param $attribute
     * @param $value
     * @param array $columns
     * @return mixed
     */
    public function findBy($attribute, $value, $columns = array('*')) {


        return $this->model->where($attribute, '=', $value)->first($columns);
    }

    /**
     * @param array $where
     * @param boolean $first
     * @return mixed
     */
    public function where(array $where) {

        return $this->model->where($where);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder
     * @throws RepositoryException
     */
    public function makeModel() {
        $model = $this->app->make($this->model());
        if (!$model instanceof Model) {
            throw new RepositoryException("Class {$this->model()} must be an instance of Illuminate\\Database\\Eloquent\\Model");
        }

        return $this->model = $model;
    }

    public function generateThumbnails($image_path,$image_name)
    {


        $path = $image_path . $image_name;
        
        if(file_exists($path) && $image_name) {

            $pathThumbnail =   $image_path.'/thumbnails';
            File::makeDirectory($pathThumbnail, $mode = 0777, true, true);

            $pathMedium = $image_path.'/medium';
            File::makeDirectory($pathMedium, $mode = 0777, true, true);

            $pathLarge =  $image_path.'/large';
            File::makeDirectory($pathLarge, $mode = 0777, true, true);

            $image = Image::make($path);
            //$width = $image->width();

            $image_thumbnail = $image->resize(100, null);
            $image_thumbnail->save( $image_path.'thumbnails/'.$image_name);

            $image_medium = $image->resize(300, null);
            $image_medium->save($image_path.'medium/'.$image_name);
        }
    }

}