<?php
/**
 * Created by PhpStorm.
 * User: fakhar
 * Date: 13/12/2016
 * Time: 3:27 PM
 */

namespace Softpyramid\GeneralLedger\Services;


use Softpyramid\GeneralLedger\Repositories\VoucherTypeRepository;
use Illuminate\Support\Facades\Auth;

class VoucherTypeService extends ServiceAbstract
{

    protected $repository;

    protected $rules = [];

    public function __construct(VoucherTypeRepository $repository)
    {
        $this->repository = $repository;
    }

    public function createVoucherType(){

        $user = Auth::user();

        $type               = request()->except('_token' , '_method');
        $type['company_id'] = $user->company->id;
        $type['office_id']  = $user->office->id;
        $type['user_id']    = $user->id;

        return $this->repository->createVoucherType($type);
    }


}