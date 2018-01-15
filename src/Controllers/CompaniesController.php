<?php
/**
 * Created by Soft Pyramid.
 * User: fakhar
 */

namespace Softpyramid\GeneralLedger\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller as BaseController;


use Softpyramid\GeneralLedger\Services\CompanyService;
use Softpyramid\GeneralLedger\Models\Company;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Carbon\Carbon;


class CompaniesController extends BaseController
{

    protected $service;


    public function __construct(CompanyService $service)
    {
        $this->service = $service;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $orderBy = request()->query('orderBy', 'asc');
        $field = request()->query('field', 'name');
        $searchString = request()->query('string', null);
        $paginate = request()->query('paginate', 10);

        if($searchString){


            $searchFields = 'code,name,abbreviation';

            $companies = Company::where(DB::raw('concat('.$searchFields.')') , 'LIKE' , '%'.$searchString.'%')->orderBy($field , $orderBy)->paginate($paginate);

        }else{

            $companies = Company::orderBy($field , $orderBy)->paginate($paginate);

        }

        if($orderBy == 'asc'){

            $orderBy = 'desc';

        }else{

            $orderBy = 'asc';
        }

        return view('companies.index', compact('companies','paginate','orderBy','field','searchString'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $company = $this->service->model();
        return view('companies.create',compact('company'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request)
    {
        $this->validate($request, ['name' => 'required', 'abbreviation' => 'required', ]);

        $this->service->create($request);
       

        if(request()->has('SAVE_AND_NEW') and request()->get('SAVE_AND_NEW')==1)
               return redirect(route('companies.create'));


        return redirect(route('companies.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     *
     * @return Response
     */
    public function show($id)
    {
        $company = $this->service->find($id);
        return view('companies.show', compact('company'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $company = $this->service->find($id);
        return view('companies.edit', compact('company'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     *
     * @return Response
     */
    public function update($id, Request $request)
    {
        $this->validate($request, ['name' => 'required', 'abbreviation' => 'required', ]);

        $company  = $this->service->updateCompany($id);

        return redirect(route('companies.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $company = $this->service->find($id);
        $company->offices()->delete();
        $company->account()->delete();
        $company->voucher()->delete();
        $status  = $this->service->destroy($id);

        if(request()->ajax())
        {

            return response()->json([
                'success' => $status == 1 ? 'true' : 'false'
            ]);
        }

        return redirect(route('companies.index'));
    }

}
