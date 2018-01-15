<?php
/**
 * Created by PhpStorm.
 * User: fakhar
 * Date: 13/12/2016
 * Time: 3:27 PM
 */

namespace Softpyramid\GeneralLedger\Services;


use Softpyramid\GeneralLedger\Repositories\CompanyRepository;

class CompanyService extends ServiceAbstract
{

    protected $repository;

    protected $rules = [];

    public function __construct(CompanyRepository $repository)
    {
        $this->repository = $repository;
    }

    public function updateCompany($id){

        $company = request()->except('_token','_method');

        if(request()->hasFile('image')){


            $company['image']  = $this->uploadImage();
        }

        return $this->repository->updateCompany($id, $company);

    }

    public function uploadImage(){

        $image = request()->file('image');

        $image_name = md5(time()).'.'.$image->getClientOriginalExtension();

        $destinationPath = public_path('company/images');

        $image->move($destinationPath, $image_name);

        return $image_name;
    }

}