<?php
/**
 * Created by PhpStorm.
 * User: fakhar
 * Date: 13/12/2016
 * Time: 3:27 PM
 */

namespace Softpyramid\GeneralLedger\Services;


use Softpyramid\GeneralLedger\Repositories\AccountTypeRepository;

class AccountTypeService extends ServiceAbstract
{

    protected $repository;

    protected $rules = [];

    public function __construct(AccountTypeRepository $repository)
    {
        $this->repository = $repository;
    }


}