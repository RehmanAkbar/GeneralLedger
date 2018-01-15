<?php
/**
 * Created by PhpStorm.
 * User: fakhar
 * Date: 13/12/2016
 * Time: 3:28 PM
 */

namespace Softpyramid\GeneralLedger\Repositories;


use Softpyramid\GeneralLedger\Models\Office;

class OfficeRepository extends Repository
{

    public function model()
    {
       return Office::class;
    }


}