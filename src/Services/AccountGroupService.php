<?php
/**
 * Created by PhpStorm.
 * User: fakhar
 * Date: 13/12/2016
 * Time: 3:27 PM
 */

namespace Softpyramid\GeneralLedger\Services;


use Softpyramid\GeneralLedger\Repositories\AccountGroupRepository;

class AccountGroupService extends ServiceAbstract
{

    protected $repository;

    protected $rules = [];

    public function __construct(AccountGroupRepository $repository)
    {
        $this->repository = $repository;
    }


}