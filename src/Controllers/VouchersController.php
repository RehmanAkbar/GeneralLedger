<?php
/**
 * Created by Soft Pyramid.
 * User: fakhar
 */

namespace Softpyramid\GeneralLedger\Controllers;

use Softpyramid\GeneralLedger\Models\Account;
use Softpyramid\GeneralLedger\Models\Upload;
use Softpyramid\GeneralLedger\Models\VoucherDetails;
use Softpyramid\GeneralLedger\Models\VoucherType;
use Softpyramid\GeneralLedger\Services\AccountService;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use Softpyramid\GeneralLedger\Services\VoucherService;
use Softpyramid\GeneralLedger\Models\Voucher;
use Barryvdh\DomPDF\PDF;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\View;
use Image;

class VouchersController extends Controller
{

    protected $service,$accountService;


    public function __construct(VoucherService $service,AccountService $accountService)
    {
        $this->service = $service;
        $this->accountService = $accountService;

        $voucherTypes = VoucherType::pluck('description','id')->toArray();
        $accounts = Account::all();

        view()->share('voucherTypes' , $voucherTypes);
        view()->share('accounts' , $accounts);
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $orderBy        = request()->query('orderBy', 'asc');
        $field          = request()->query('field', 'voucher_code');
        $searchString   = request()->query('string', null);
        $paginate       = request()->query('paginate', 10);
        $voucherType    = request()->query('voucher_type_id');

        $vouchers = Voucher::orderBy($field , $orderBy);

        if($searchString){

            $searchFields = 'voucher_code';
            $vouchers->where(DB::raw('concat('.$searchFields.')') , 'LIKE' , '%'.$searchString.'%');

        }elseif($voucherType){

            $vouchers->where('voucher_type_id', $voucherType);

        }

        $vouchers = $vouchers->paginate($paginate);

        if($orderBy == 'asc'){

            $orderBy = 'desc';

        }else{

            $orderBy = 'asc';
        }

        return view('vouchers.index', compact('vouchers','paginate','orderBy','field','searchString'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $voucher = $this->service->model();

        return view('vouchers.create',compact('voucher'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request)
    {

       $voucher = $this->service->createVoucher($request);

        return route('vouchers.edit' , [$voucher->id]);
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
        $voucher = $this->service->find($id);
        return view('vouchers.show', compact('voucher'));
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
        if(!empty($voucher)){

            $voucher->load('details.account');

        }
        return view('vouchers.edit', compact('voucher'));
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
//        $this->validate($request, ['voucher_type_id' => 'required', ]);

        return $request->all();
        $this->service->updateVoucher($id);

        redirect(route('vouchers.index'));
    }

    public function updateVoucher($id, Request $request)
    {

        $this->service->updateVoucher($id);

        return (route('vouchers.index'));
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

    public function lastVouchers($id)
    {

        $vouchers = Voucher::with('details.account','type')->where('voucher_type_id' , $id)->get();

        return $vouchers;
    }
    public function printVoucher(Voucher $voucher)
    {
        $this->service->loadVoucherRelations($voucher);

        $numberFormatter = getNumberFormatterObject();
        $buttons = true;
        return view('vouchers.details',compact('voucher','numberFormatter','buttons'));
    }

    public function downloadVoucherPdf(Voucher $voucher)
    {
        $this->service->loadVoucherRelations($voucher);

        $numberFormatter = getNumberFormatterObject();

        $pdf = App::make('dompdf.wrapper');
        $buttons = false;
        $viewHtml = view('vouchers.partials._pdf', compact('voucher','numberFormatter','buttons'));
        $pdf->loadHTML($viewHtml);

        return $pdf->stream();

    }

    public function downloadVoucher()
    {
        $vouchersQuery = $this->service->voucherByType(request()->voucher_type_id);

        $vouchersQuery = $this->service->findVoucherByDates(request()->from_date, request()->to_date,$vouchersQuery);

        $vouchers      =  $vouchersQuery->get();
        $numberFormatter = getNumberFormatterObject();
        $buttons = false;

        $this->service->loadVoucherRelations($vouchers);
        $pdf = App::make('dompdf.wrapper');
        $viewHtml = view('vouchers.partials._vouchers_pdf', compact('vouchers','numberFormatter','buttons'));

        $pdf->loadHTML($viewHtml);

        return $pdf->stream();
    }

    public function printing()
    {
        return view('vouchers.reports.criteria');
    }


    public function previewVoucherForPrinting()
    {
        $vouchersQuery = $this->service->voucherByType(request()->voucher_type_id);

        $vouchersQuery = $this->service->findVoucherByDates(request()->from_date, request()->to_date,$vouchersQuery);

        $paginate      =  request()->query('paginate' , 3);
        $vouchers      =  addPagination($vouchersQuery , $paginate);

        $this->service->loadVoucherRelations($vouchers);

        $numberFormatter = getNumberFormatterObject();
        $buttons = false;
        return view('vouchers.reports.preview',compact('vouchers','numberFormatter','buttons','paginate'));
    }

    public function transactionsListing()
    {
        return view('vouchers.reports.listing_criteria');
    }

    public function transactionsListingPreview()
    {
        $vouchersQuery = $this->service->voucherByType(request()->voucher_type_id);

        $vouchersQuery = $this->service->findVoucherByDates(request()->from_date, request()->to_date,$vouchersQuery);
        $vouchers      = $this->service->getVoucher($vouchersQuery);
        $this->service->loadVoucherRelations($vouchers);
        $numberFormatter = getNumberFormatterObject();
        $buttons = false;
        return view('vouchers.reports.preview_listing',compact('vouchers','numberFormatter','buttons'));
    }

    public function downloadTransactionsListingPdf(Voucher $voucher)
    {
        $vouchersQuery = $this->service->voucherByType(request()->voucher_type_id);

        $vouchersQuery = $this->service->findVoucherByDates(request()->from_date, request()->to_date,$vouchersQuery);
        $vouchers      = $this->service->getVoucher($vouchersQuery);
        $this->service->loadVoucherRelations($vouchers);
        $numberFormatter = getNumberFormatterObject();
        $buttons = false;

        $numberFormatter = getNumberFormatterObject();

        $pdf = App::make('dompdf.wrapper');
        $buttons = false;

        return view('vouchers.reports.download_preview_listing',compact('vouchers','numberFormatter','buttons'));


        $viewHtml = view('vouchers.partials._pdf', compact('voucher','numberFormatter','buttons'));
        $pdf->loadHTML($viewHtml);

        return $pdf->stream();

    }

    public function ledgerCriteriaForm()
    {
        return view('vouchers.reports.general_ledger_criteria');
    }

    public function trialBalanceCriteriaForm()
    {
        return view('vouchers.reports.trial_balance_criteria_form');
    }


    public function generalLedgerPreview()
    {
        $criteria =[
            'account_from'=>request('from_account_code'),
            'account_to'  =>request('to_account_code'),
            'date_from'   =>parseDate(request('from_date'))->format('Y-m-d 00:00:00'),
            'date_to'     =>parseDate(request('to_date'))->format('Y-m-d 23:59:59'),
        ];

        $accountsDetails = $this->service->getLedger($criteria);

        return view('vouchers.reports.general-ledger',compact('accountsDetails','criteria'));
    }

    public function downloadGeneralLedger()
    {
        $criteria =[
            'account_from'=>request('from_account_code'),
            'account_to'  =>request('to_account_code'),
            'date_from'   =>parseDate(request('from_date'))->format('Y-m-d 00:00:00'),
            'date_to'     =>parseDate(request('to_date'))->format('Y-m-d 23:59:59'),
        ];

        $accountsDetails = $this->service->getLedger($criteria);
        $viewHtml = view('vouchers.reports.download_gl',compact('accountsDetails','criteria'));

        return downloadPdf($viewHtml);
    }

    public function trialBalancePreview()
    {
        $criteria =[
            'account_from'=>request('from_account_code'),
            'account_to'  =>request('to_account_code'),
            'date_from'   =>parseDate(request('from_date'))->format('Y-m-d 00:00:00'),
            'date_to'     =>parseDate(request('to_date'))->format('Y-m-d 23:59:59'),
        ];
        $accountsDetails = $this->service->getLedger($criteria);
        return view('vouchers.reports.trial_balance',compact('accountsDetails','criteria'));
    }

    public function trialBalanceDownload()
    {
        $criteria =[
            'account_from'=>request('from_account_code'),
            'account_to'  =>request('to_account_code'),
            'date_from'   =>parseDate(request('from_date'))->format('Y-m-d 00:00:00'),
            'date_to'     =>parseDate(request('to_date'))->format('Y-m-d 23:59:59'),
        ];

        $accountsDetails = $this->service->getLedger($criteria);

        $view = view('vouchers.reports.download_trial_balance',compact('accountsDetails','criteria'));

        return downloadPdf($view);
//        return redirect()->back();
    }

    public function deleteVoucherFile($id)
    {
        $file = Upload::find($id);

        $res = Storage::cloud('google')->delete($file->path);
        $file->delete();

        return 'File was deleted from Google Drive';

        /*if($res){

            return Response::json(['data' => array('message' => 'delete success!')]);
        }*/
    }

    public function uploadVoucherFile($id)
    {
        $this->service->uploadVoucherFile($id);
    }

    public function downloadVoucherFile($id)
    {

    }
}
