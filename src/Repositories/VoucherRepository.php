<?php
/**
 * Created by PhpStorm.
 * User: fakhar
 * Date: 13/12/2016
 * Time: 3:28 PM
 */

namespace Softpyramid\GeneralLedger\Repositories;


use Softpyramid\GeneralLedger\Models\Voucher;

use Image;
use Illuminate\Support\Facades\Storage;
class VoucherRepository extends Repository
{

    public function model()
    {
       return Voucher::class;
    }

    public function createVoucher($voucher_data,$details){

        $voucher = $this->model->create($voucher_data);
        if(request()->hasFile('files')) {

            $this->uploadVoucherFile($voucher);

        }

        if(count($details)){
            foreach($details as $detail){

                $data["account_id"] = $detail->account_id;
                $data["cheque_no"] = $detail->cheque_no;
                $data["narration"] = $detail->narration;
                $data["debit"] = $detail->debit != "" ? $detail->debit : 0;
                $data["credit"] = $detail->credit != "" ? $detail->credit : 0;

                $voucher->details()->create($data);
            }
        }


        return $voucher;
    }

    public function uploadVoucherFile($voucher)
    {

        $files  = request()->file('files');

        foreach ($files as $index => $file){

            $filePath    = md5(auth()->user()->id) . "-" . time().'.'.$file->getClientOriginalExtension();
            $originalName = $file->getClientOriginalName();

            $fileName = request()->fileName;

            $filePath = isset($fileName[$index]) ? $fileName[$index] : $filePath ;

            Storage::cloud('google')->putFileAs('/', $file, $filePath);
//            Storage::cloud('google')->put($filePath, $file->stream()->detach());

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
//        return ['name' => $originalName , 'path' => $imagePath];

    }

    public function updateVoucher($id,$voucher_data,$details)
    {

        $voucher = $this->model->find($id);
        $voucher->update($voucher_data);

        $voucher->details()->delete();

        if(count($details)){

            foreach($details as $detail){

                $data["account_id"] = $detail->account_id;
                $data["cheque_no"] = $detail->cheque_no;
                $data["narration"] = $detail->narration;
                $data["debit"] = $detail->debit != "" ? $detail->debit : 0;
                $data["credit"] = $detail->credit != "" ? $detail->credit : 0;

                $voucher->details()->create($data);
            }
        }


    }

    public function loadVoucherRelations($vouchers)
    {
        if(count($vouchers) > 0){

            $vouchers->load('type','details.account' , 'company','office');
        }

        return $vouchers;
    }

    public function voucherByType($id)
    {

        return $this->findBy('voucher_type_id' , $id);
    }
    public function findVoucherByDates($from_date, $to_date,$voucher)
    {

        if(!$voucher){

            $voucher = new Voucher();
        }

        $from_date = parseDate($from_date);
        $to_date   = parseDate($to_date);

        return $voucher->whereBetween('voucher_date', [$from_date , $to_date]);
    }

    public function getVoucher($vouchers)
    {
        return $vouchers->get();
    }
}