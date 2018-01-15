<?php
/**
 * Created by PhpStorm.
 * User: fakhar
 * Date: 13/12/2016
 * Time: 3:28 PM
 */

namespace Softpyramid\GeneralLedger\Repositories;


use Softpyramid\GeneralLedger\Models\AccountGroup;

class AccountGroupRepository extends Repository
{

    public function model()
    {
       return AccountGroup::class;
    }


}