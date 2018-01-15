<?php
/**
 * Created by Soft Pyramid.
 * User: fakhar
 */

namespace Softpyramid\GeneralLedger\Controllers;

use Softpyramid\GeneralLedger\Models\AccountGroup;

use Softpyramid\GeneralLedger\Models\City;
use Softpyramid\GeneralLedger\Models\AccountType;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use Softpyramid\GeneralLedger\Services\AccountService;
use Softpyramid\GeneralLedger\Models\Account;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Carbon\Carbon;


class AccountsController extends Controller
{

    protected $service;


    public function __construct(AccountService $service)
    {
        $this->service = $service;
        $account_groups = AccountGroup::pluck('name', 'id')->toArray();
        $account_types = AccountType::pluck('name', 'id')->toArray();
        $cities = City::pluck('name', 'id')->toArray();


        view()->share('account_groups', $account_groups);
        view()->share('account_types', $account_types);
        view()->share('cities', $cities);
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $orderBy = request()->query('orderBy', 'asc');
        $field = request()->query('field', 'code');
        $searchString = request()->query('string', null);
        $paginate = request()->query('paginate', 10);

        if($searchString){

            $searchFields = 'code,description';

            $accounts = Account::where(DB::raw('concat('.$searchFields.')') , 'LIKE' , '%'.$searchString.'%')->orderBy($field , $orderBy)->paginate($paginate);

        }else{

            $accounts = Account::orderBy($field , $orderBy)->paginate($paginate);

        }

        if($orderBy == 'asc'){

            $orderBy = 'desc';

        }else{

            $orderBy = 'asc';
        }

        return view('accounts.index', compact('accounts','paginate','orderBy','field','searchString'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $account  = $this->service->model();

        $accounts = Account::where('nlevel' , 1)->with('level2.level3')->get();
       
        return view('accounts.create',compact('accounts'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request)
    {

        $this->service->createAccount();

        return redirect()->route('accounts.create');
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
        $account = $this->service->find($id);
        return view('accounts.show', compact('account'));
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
        $account = $this->service->find($id);
        $accounts = Account::where('nlevel' , 1)->with('level2.level3')->get();
        
        return view('accounts.edit', compact('accounts','account'));
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

        return redirect()->route('accounts.create');
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

        return redirect(route('accounts.index'));
    }

    public function openingBalance()
    {

        $accounts = Account::where('nlevel' , 3)->get();
        
        return view('accounts.opening_balance', compact('accounts'));
    }

    public function savOpeningBalance(){

        $this->service->updateBalance();

    }

    public function searchAccounts()
    {
        $searchFields = 'description, code';
        $str =  request()->query('q');
        $accounts = Account::where(DB::raw('concat('.$searchFields.')') , 'LIKE' , '%'.$str.'%')
            ->where('nlevel' , 3)
            ->select('id' , 'description AS text')
            ->get()
            ->take(10);

        return $accounts->toArray();
    }
    public function getAccounts(Request $request)
    {
        $searchFields = 'description, code';
        $str =  request()->account;

        $accounts = Account::where(DB::raw('concat('.$searchFields.')') , 'LIKE' , '%'.$str.'%')->where('nlevel' , 3)
            ->get();

        return view('accounts.opening_balance', compact('accounts'));
    }

    public function switchCompany($id)
    {

    }

}
