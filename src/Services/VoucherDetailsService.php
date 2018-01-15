<?php
/**
 * Created by PhpStorm.
 * User: fakhar
 * Date: 13/12/2016
 * Time: 3:27 PM
 */

namespace Softpyramid\GeneralLedger\Services;



use Softpyramid\GeneralLedger\Models\VoucherDetails;
use Softpyramid\GeneralLedger\Repositories\VoucherDetailsRepository;
use Illuminate\Support\Facades\Auth;

class VoucherDetailsService extends ServiceAbstract
{

    protected $repository;

    protected $rules = [];

    public function __construct(VoucherDetailsRepository $repository)
    {
        $this->repository = $repository;
    }

    public function updateDetails($id , $request)
    {
        $details = $request->all();
        VoucherDetails::updateOrCreate(
            ['id' => $id,'voucher_id' => $details['voucher_id'], 'account_id' => $details['account_id']],
            $details
        );
    }
}