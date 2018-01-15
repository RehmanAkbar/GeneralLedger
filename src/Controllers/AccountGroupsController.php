<?php
/**
 * Created by Soft Pyramid.
 * User: fakhar
 */

namespace Softpyramid\GeneralLedger\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller as BaseController;

use Softpyramid\GeneralLedger\Services\AccountGroupService;
use Softpyramid\GeneralLedger\Models\AccountGroup;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Carbon\Carbon;


class AccountGroupsController extends BaseController
{

    protected $service;


    public function __construct(AccountGroupService $service)
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


            $searchFields = 'name';

            $accountgroups = AccountGroup::where(DB::raw('concat('.$searchFields.')') , 'LIKE' , '%'.$searchString.'%')->orderBy($field , $orderBy)->paginate($paginate);

        }else{

            $accountgroups = AccountGroup::orderBy($field , $orderBy)->paginate($paginate);

        }

        if($orderBy == 'asc'){

            $orderBy = 'desc';

        }else{

            $orderBy = 'asc';
        }

        return view('accountgroups.index', compact('accountgroups','paginate','orderBy','field','searchString'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $accountgroup = $this->service->model();
        return view('accountgroups.create',compact('accountgroup'));
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
               return redirect(route('accountgroups.create'));


        return redirect(route('accountgroups.index'));
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
        $accountgroup = $this->service->find($id);
        return view('accountgroups.show', compact('accountgroup'));
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
        $accountgroup = $this->service->find($id);
        return view('accountgroups.edit', compact('accountgroup'));
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
        return redirect(route('accountgroups.index'));
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

        return redirect(route('accountgroups.index'));
    }

}
