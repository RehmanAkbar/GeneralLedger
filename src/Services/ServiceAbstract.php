<?php

namespace Softpyramid\GeneralLedger\Services;

use Softpyramid\GeneralLedger\Exceptions\ValidatorException;
use Illuminate\Http\Request;
use Validator;

/**
 * ServiceAbstract Class
 *
 */
abstract class ServiceAbstract {
	/**
	 * Containing repository to make all our database calls to
	 *
	 * @var Object
	 */
	protected $repository;
	/**
	 * Rules for data validation, used before create, update, or delete
	 *
	 * @var Array
	 */
	protected $rules = [];
	/**
	 * Rules for data validation, used before create, update, or delete
	 *
	 * @var Array
	 */
	protected $validator;
	/**
	 * Loads our $repo with the actual Repo
	 *
	 * @param Object $repo
	 */
	public function __construct($repo) {
		$this->repository = $repo;
	}

	/**
	 * @return $this
	 */
	public function instance() {
		return $this;
	}

	/**
	 * Get validation rules
	 * @return Array rules
	 */
	protected function validatorRules($op) {
		$rules = $this->rules;
		if (isset($this->rules[$op])) {
			$rules = $this->rules[$op];
		}
		return $rules;
	}
	/**
	 * Attributes data validation before
	 * @throws ValidatorException
	 */
	public function isValid($attributes, $op = 'create') {
		$rules = $this->validatorRules($op);
		$this->validator = Validator::make($attributes, $rules);
		if ($this->validator->fails()) {
			throw new ValidatorException($this->validator->messages());
		}
		return true;
	}
	public function transformRequest($request) {
		$data = $request;
		if ($request instanceof Request) {
			//Do something with Request Object
			$data = $request->all();
		}
		return $data;
	}
	/**
	 * Create and add data to repository
	 * @param Request|Object $request
	 */
	public function create($request) {
		$data = $this->transformRequest($request);
		// validate
		$this->isValid($data, 'create');

		return $this->repository->create($data);
	}
	/**
	 * Update data to repository
	 * @param Request|Object $request
	 */
	public function update($id, $request) {

		// validate
		$this->isValid($request->all(), 'update');
		return $this->repository->update($request, ['id' => $id]);
	}
	/**
	 * Delete data to repository
	 * @param Request|Object $request
	 */
	public function delete($request) {
		$data = $this->transformRequest($request);
		// validate
		$this->isValid($data, 'delete');
		return $this->repository->delete($data['id']);
	}

	public function destroy($id) {
		return $this->repository->delete(['id' => $id]);
	}

	public function model() {
		return $this->repository->model();
	}

	public function paginate($perPage = 15, $columns = array('*')) {
		return $this->repository->paginate();
	}
	public function all($columns = array('*')) {
		return $this->repository->all($columns);
	}

	public function pluck($display, $id) {
		return $this->repository->pluck($display, $id);
	}

	public function find($id, $columns = array('*')) {
		return $this->repository->find($id, $columns);
	}

	/**
	 * Magic method to call model's methods
	 *
	 * @param string $method
	 * @param mixed $args
	 */
	public function __call($method, $args) {

		if (method_exists($this->repository, $method)) {
			return call_user_func_array(array($this->repository, $method), $args);
		}

		return call_user_func_array(array($this->repository, $method), $args);

	}
}