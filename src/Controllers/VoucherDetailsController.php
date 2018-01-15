<?php
/**
 * Created by Soft Pyramid.
 * User: fakhar
 */

namespace Softpyramid\GeneralLedger\Controllers;


use Softpyramid\GeneralLedger\Models\VoucherDetails;
use Softpyramid\GeneralLedger\Services\VoucherDetailsService;
use App\Http\Requests;
use App\Http\Controllers\Controller as BaseController;

use Illuminate\Http\Request;




class VoucherDetailsController extends BaseController
{

    protected $service;


    public function __construct(VoucherDetailsService $service)
    {
        $this->service = $service;

    }

    public function store()
    {

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
        $voucher = $this->service->find($id);

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
        $this->service->updateDetails($id,$request);
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

        return redirect(route('vouchers.index'));
    }
}
