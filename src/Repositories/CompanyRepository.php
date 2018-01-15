<?php
/**
 * Created by PhpStorm.
 * User: fakhar
 * Date: 13/12/2016
 * Time: 3:28 PM
 */

namespace Softpyramid\GeneralLedger\Repositories;


use Softpyramid\GeneralLedger\Models\Company;

class CompanyRepository extends Repository
{

    public function model()
    {
       return Company::class;
    }

    public function updateCompany($id , $company_data){

        $company = $this->model->find($id);

        $company->update($company_data);

        return $company;
    }

}