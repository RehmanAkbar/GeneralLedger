<?php
/**
 * Created by PhpStorm.
 * User: fakhar
 * Date: 13/12/2016
 * Time: 3:27 PM
 */

namespace Softpyramid\GeneralLedger\Services;


use Softpyramid\GeneralLedger\Models\Account;
use Softpyramid\GeneralLedger\Repositories\AccountRepository;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;

class AccountService extends ServiceAbstract
{

    protected $repository;
    protected $user;

    protected $rules = [];

    public function __construct(AccountRepository $repository)
    {
        $this->repository = $repository;

    }

    public function createAccount(){

        $user = Auth::user();

        $account_data                = request()->except('_token' , '_method');
        $account_data['company_id']  = $user->company->id;
        $account_data['office_id']   = $user->office->id;
        $account_data['user_id']     = $user->id;
        $code                        = $account_data['code'];

        $level = $this->getLevel($code);
        if(!$level){

            flash('Parent not found')->error();
            return 0;
        }


        $parent_id = null;
        if($level != 1)
        {
            $parentCode = $this->getParentCode($code, $level);

            $parent_id = $this->findParentId($parentCode);

            if(!$parent_id){

                flash('Parent not found')->error();
                return 0;
            }
        }


        $account_data['parent_id'] = $parent_id;

        $duplicate = $this->checkForDuplicateAccount($code,$level);

        if($duplicate){

            flash('Account not found')->error();
            return 0;
        }
        $account_data['nlevel']  = $level;

        $parent = $this->isParent($level);
        $account_data['is_parent'] = $parent;


        return $this->repository->createAccount($account_data);

    }

    public function updateAccount()
    {
        
    }

    public function updateBalance(){

        $accounts = request()->accounts;

        foreach($accounts as $account){

            $this->repository->updateBalance($account);

        }

    }
    public function getLevel($code)
    {
        $level = 0;

        // if code is 00-000-0000
        if(empty($code))
        {
            return $level;
        }

        $code = explode("-",$code);

        // if all levels of account is set
        if(((int)$code[2] >= 1) && ((int)$code[1] >= 1) && ((int)$code[0] >= 1))
        {
            $level = 3;

        // if first and second level of account is set
        }else if(((int)$code[1] >= 1) && ((int)$code[0] >= 1))
        {
            $level = 2;

        // if only first level of account is set
        }else if((int)$code[0] >= 1 && ((int)$code[1] == 0) && ((int)$code[2] == 0))
        {
            $level = 1;
        }

        return $level;
    }

    public function isParent($level)
    {
        if($level == 1 || $level == 2)
        {
            return 1;
        }
        else
        {
            return 0;
        }
    }

    public function findParentId($code)
    {

        $level = substr_count($code,'-') + 1;

        $parentAccount = Account::where('code' , 'LIKE', $code.'%')->where('nlevel' , $level)->first();

        return isset($parentAccount->id) ? $parentAccount->id : 0;
    }

    public function checkForDuplicateAccount($code,$level)
    {

        /*$array = explode('-', $code);
        $code = implode('-', array_slice($array, 0, $level));*/

        $account = Account::where('code' , $code)->first();

        return ($account) ? 1 : 0;
    }

    public function getParentCode($code, $level)
    {
        $code = explode("-",$code);
        if($level == 1 || $level == 2)
        {
            return $code[0];
        }

        return $code[0]."-".$code[1];
    }
    public function getAccountsFromCode($from_account, $to_account)
    {
        return $this->repository->getAccountsFromCode($from_account, $to_account);
    }
    public function openingBalance(){


    }
}