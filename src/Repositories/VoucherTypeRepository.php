<?php
/**
 * Created by PhpStorm.
 * User: fakhar
 * Date: 13/12/2016
 * Time: 3:28 PM
 */

namespace Softpyramid\GeneralLedger\Repositories;


use Softpyramid\GeneralLedger\Models\VoucherType;

class VoucherTypeRepository extends Repository
{

    public function model()
    {
       return VoucherType::class;
    }

    public function createVoucherType($voucher){

        $this->model->create($voucher);

    }

}