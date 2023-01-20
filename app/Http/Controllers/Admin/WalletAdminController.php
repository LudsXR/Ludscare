<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Bavix\Wallet\Models\Transaction;
use App\Models\User;
class WalletAdminController extends Controller
{
    public function index(){
        $transactions=Transaction::where('payable_id',1)->orderBy('id','DESC')->get();
        $user=User::find(1);
        $balance=$user->balance;
            foreach($transactions as $transaction){

                $date=date("Y-m-d", strtotime($transaction->created_at));
                $time=date("h:i a", strtotime($transaction->created_at));
                $transaction['date']=$date;
                $transaction['time']=$time;


            }
        return view('new_admin.wallet.index',compact('transactions','balance'));
    }
}
