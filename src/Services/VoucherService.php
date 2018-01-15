<?php
/**
 * Created by PhpStorm.
 * User: fakhar
 * Date: 13/12/2016
 * Time: 3:27 PM
 */

namespace Softpyramid\GeneralLedger\Services;

use Image;
use Illuminate\Support\Facades\Storage;
use Softpyramid\GeneralLedger\Models\Account;
use Softpyramid\GeneralLedger\Models\Voucher;
use Softpyramid\GeneralLedger\Models\VoucherDetails;
use Softpyramid\GeneralLedger\Repositories\VoucherRepository;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
class VoucherService extends ServiceAbstract
{

    protected $repository;

    protected $rules = [];

    public function __construct(VoucherRepository $repository)
    {
        $this->repository = $repository;
    }

    public function createVoucher($request)
    {

        $user = Auth::user();
        $voucher_data                  = request()->except('_token','_method','voucher');
        $voucher_data['company_id']    = $user->company->id;
        $voucher_data['office_id']     = $user->office->id;
        $voucher_data['user_id']       = $user->id;

        $input  = $voucher_data['voucher_date'];
        $format = 'Y-m-d';

        $date = parseDate($input);

        $voucher_data['voucher_date'] = $date;

        $voucher_data['voucher_code'] = $this->createVoucherCode($date);


        $voucher_details = json_decode(request()->details);
        return $this->repository->createVoucher($voucher_data,$voucher_details, $request);

    }

    public function updateVoucher($id)
    {
        $voucher_data  = request()->except('_token','_method','voucher');

        $input  = $voucher_data['voucher_date'];

        $date =  parseDate($input);
        $voucher_data['voucher_date']  = $date;

        $voucher_details = json_decode(request()->details);
        return $this->repository->updateVoucher($id,$voucher_data,$voucher_details);
        
    }

    public function createVoucherCode($date)
    {

        $year = substr($date->year, -2);
        $monthYear = $date->month.$year;
        $voucher_code_count = Voucher::where('voucher_code' , 'LIKE', '%'.$monthYear.'%')->count();

        $voucher_code_count++;
        $count = str_pad($voucher_code_count, 4, "0", STR_PAD_LEFT);

        return $monthYear.'/'.$count;

    }

    public function voucherByType($id)
    {
        return $this->repository->voucherByType($id);
    }
    public function loadVoucherRelations($vouchers)
    {
       $this->repository->loadVoucherRelations($vouchers);
    }

    public function findVoucherByDates($from_date, $to_date, $voucher = null)
    {
        return $this->repository->findVoucherByDates($from_date, $to_date, $voucher);

    }

    public function getVoucher($vouchers)
    {
        return $this->repository->getVoucher($vouchers);
    }


    /**
     * @param array $criteria
     * @return \Illuminate\Database\Eloquent\Builder|static
     */
    public function getLedger(Array $criteria)
    {
        $accountsIds = Account::whereBetween('code',[$criteria['account_from'],$criteria['account_to']])
            ->select('id')->get()->toArray();

        $accountsDetails  = Account::with(['voucherDetails' => function($transaction) use ($criteria, $accountsIds){

            $transaction->whereHas('voucher', function($voucher) use($criteria, $accountsIds) {

                $voucher->whereBetween('voucher_date',[$criteria['date_from'],$criteria['date_to']]);


            });

        }])->whereBetween('code',[$criteria['account_from'],$criteria['account_to']])->where('nlevel' , 3)
            ->orderBy('code')->get();

        return $accountsDetails;

    }

    public function uploadVoucherFile($id)
    {

        $voucher = $this->repository->find($id);

        if($voucher && request()->hasFile('files')) {

            $files  = request()->file('files');

            foreach ($files as $index => $file){

                $filePath    = md5(auth()->user()->id) . "-" . time().'.'.$file->getClientOriginalExtension();
                $originalName = $file->getClientOriginalName();

                $fileName = request()->fileName;

                $filePath = isset($fileName[$index]) ? $fileName[$index] : $filePath ;
                Storage::cloud('google')->putFileAs('/', $file, $fileName[$index]);

                $dir = '/';
                $recursive = false; // Get subdirectories also?
                $contents = collect(Storage::cloud()->listContents($dir, $recursive));
                $file = $contents
                    ->where('type', '=', 'file')
                    ->where('filename', '=', pathinfo($filePath, PATHINFO_FILENAME))
                    ->where('extension', '=', pathinfo($filePath, PATHINFO_EXTENSION))
                    ->first();

                $upload = $voucher->uploads()->create([
                    'original_name' => $fileName[$index],
                    'path' => $file['path'],
                    'media_type' => 'image',
                    'uploaded_by_user_id' => auth()->user()->id,
                ]);
            }
            return ['name' => $filePath , 'path' => $file['path']];

        }
    }
}