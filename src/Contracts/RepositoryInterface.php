<?php namespace Softpyramid\GeneralLedger\Contracts;
use Illuminate\Http\Request;
interface RepositoryInterface {
    public function all($columns = array('*'));
    public function paginate($perPage = 15, $columns = array('*'));
    public function create(array $data);
    public function update(Request $request, array $where);
    public function delete(array $where);
    public function find($id, $columns = array('*'));
    public function findBy($field, $value, $columns = array('*'));
    public function where(array $where);
}