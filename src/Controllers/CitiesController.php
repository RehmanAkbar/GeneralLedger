<?php
/**
 * Created by Soft Pyramid.
 * User: fakhar
 */

namespace Softpyramid\GeneralLedger\Controllers;

use Softpyramid\GeneralLedger\Models\Country;
use App\Http\Requests;
use App\Http\Controllers\Controller as BaseController;

use Softpyramid\GeneralLedger\Services\CityService;
use Softpyramid\GeneralLedger\Models\City;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Carbon\Carbon;


class CitiesController extends BaseController
{

    protected $service;


    public function __construct(CityService $service)
    {
        $this->service = $service;
        $countries = Country::pluck('name','id');
        view()->share('countries' , $countries);
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


            $searchFields = 'name,name';

            $cities = City::where(DB::raw('concat('.$searchFields.')') , 'LIKE' , '%'.$searchString.'%')->orderBy($field , $orderBy)->paginate($paginate);

        }else{

            $cities = City::orderBy($field , $orderBy)->paginate($paginate);

        }

        if($orderBy == 'asc'){

            $orderBy = 'desc';

        }else{

            $orderBy = 'asc';
        }

        return view('cities.index', compact('cities','paginate','orderBy','field','searchString'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $city = $this->service->model();
        return view('cities.create',compact('city'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request)
    {
        
        $this->service->create($request);
       

        if(request()->has('SAVE_AND_NEW') and request()->get('SAVE_AND_NEW')==1)
               return redirect(route('cities.create'));


        return redirect(route('cities.index'));
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
        $city = $this->service->find($id);
        return view('cities.show', compact('city'));
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
        $city = $this->service->find($id);

        return view('cities.edit', compact('city'));
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
        
        $this->service->update($id,$request);
        return redirect(route('cities.index'));
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
        $status = $this->service->destroy($id);

        if(request()->ajax())
        {

            return response()->json([
                'success' => $status == 1 ? 'true' : 'false'
            ]);
        }

        return redirect(route('cities.index'));
    }

}
