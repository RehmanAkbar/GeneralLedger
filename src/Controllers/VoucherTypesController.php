<?php
/**
 * Created by Soft Pyramid.
 * User: fakhar
 */

namespace Softpyramid\GeneralLedger\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller as BaseController;

use Softpyramid\GeneralLedger\Services\VoucherTypeService;
use Softpyramid\GeneralLedger\Models\VoucherType;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Carbon\Carbon;


class VoucherTypesController extends BaseController
{

    protected $service;


    public function __construct(VoucherTypeService $service)
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
        $field = request()->query('field', 'type');
        $searchString = request()->query('string', null);
        $paginate = request()->query('paginate', 10);

        if($searchString){


            $searchFields = 'type,description';

            $vouchertypes = VoucherType::where(DB::raw('concat('.$searchFields.')') , 'LIKE' , '%'.$searchString.'%')->orderBy($field , $orderBy)->paginate($paginate);

        }else{

            $vouchertypes = VoucherType::orderBy($field , $orderBy)->paginate($paginate);

        }

        if($orderBy == 'asc'){

            $orderBy = 'desc';

        }else{

            $orderBy = 'asc';
        }

        return view('vouchertypes.index', compact('vouchertypes','paginate','orderBy','field','searchString'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $vouchertype = $this->service->model();
        return view('vouchertypes.create',compact('vouchertype'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request)
    {
        $this->validate($request, ['type' => 'required', ]);

        $this->service->createVoucherType($request);
       

        return redirect(route('vouchertypes.index'));
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
        $vouchertype = $this->service->find($id);
        return view('vouchertypes.show', compact('vouchertype'));
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
        $vouchertype = $this->service->find($id);
        return view('vouchertypes.edit', compact('vouchertype'));
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
        $this->validate($request, ['type' => 'required', ]);

        $this->service->update($id,$request);
        return redirect(route('vouchertypes.index'));
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

        return redirect(route('vouchertypes.index'));
    }

}
