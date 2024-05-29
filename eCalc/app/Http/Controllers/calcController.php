<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Bill;
use App\Models\Payment;
use App\Models\Ecost;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use  Illuminate\Support\Facades\Mail;
use Carbon\Carbon;
use Spatie\FlareClient\View;
use Illuminate\Support\Facades\Validator;

class calcController extends Controller
{
    public function index(){
        $ecost = Ecost::latest()->first();
        $c1 = $ecost->c1; $c2 =$ecost->c2; $c3 =$ecost->c3; $c4 =$ecost->c4; $c5 = $ecost->c5; $c6 = $ecost->c6;
        return view('calc',compact('c1','c2','c3','c4','c5','c6'));
    }
    public function calc(Request $request) {

        $messages = [
            'kWh.required' => 'Không được để trống số điện',
            'kWh.numeric' => 'Số điện phải là số',
            'kWh.min' => 'Số điện phải là số dương',
        ];
        $validator = Validator::make($request->input(), [
            'kWh' => 'required|numeric|min:0',
        ],$messages);
        
        if ($validator->fails()) {
            return redirect()->back()
                             ->withErrors($validator)
                             ->withInput();
        }
        $kWh = $request->input('kWh');
        $l1 = $l2 = $l3 = $l4 = $l5 = $l6 = $cost = $total = $tax = 0;
        $ecost = Ecost::latest()->first();
        $c1 = $ecost->c1; $c2 =$ecost->c2; $c3 =$ecost->c3; $c4 =$ecost->c4; $c5 = $ecost->c5; $c6 = $ecost->c6;
        if ($kWh <= 50) {
            $l1 = $kWh;
        } elseif ($kWh <= 100) {
            $l1 = 50;
            $l2 = $kWh - 50;
        } elseif ($kWh <= 200) {
            $l1 = $l2 = 50;
            $l3 = $kWh - 100;
        } elseif ($kWh <= 300) {
            $l1 = $l2 = 50;
            $l3 = 100;
            $l4 = $kWh - 200;
        } elseif ($kWh <= 400) {
            $l1 = $l2 = 50;
            $l3 = $l4 = 100;
            $l5 = $kWh - 300;
        } else {
            $l1 = $l2 = 50;
            $l3 = $l4 = $l5 = 100;
            $l6 = $kWh - 400;
        }

        $cost = $l1 * $c1 + $l2 * $c2 + $l3 * $c3 + $l4 * $c4 + $l5 * $c5 + $l6 * $c6;
        $tax = $cost * 0.1;
        $total = round($tax + $cost, 3);

        return view('calc', compact('kWh','total', 'cost','tax','l1','l2','l3','l4','l5','l6','c1','c2','c3','c4','c5','c6'));
    }
    public function showcost(){
        $ecost = Ecost::latest()->first();
        $c1 = $ecost->c1; $c2 =$ecost->c2; $c3 =$ecost->c3; $c4 =$ecost->c4; $c5 = $ecost->c5; $c6 = $ecost->c6;
        return view('cost',compact('c1','c2','c3','c4','c5','c6'));
    }
    public function search(Request $request){
        $querry = $request->input('querry');
        $re = DB::table('users')
        ->join('eConsumptions', 'users.id', '=', 'eConsumptions.uid')
        ->select('users.name as name','users.cus_code as code', 'eConsumptions.econ as econ', 'eConsumptions.updated_at as at')
        ->where('cus_Code','=',$querry)
        ->where('period','>',Carbon::now()->subMonths(1)->endOfMonth())
        // ->where('year','=',date('Y'))
        ->first();
        $result = $re;
        return view('search', compact('result'));
    }
    public function pay(){
        $user =  Auth::user();
        $bill = $latestBill = Bill::where('uid', $user->id)->latest('updated_at')->first();
        $bill->status = "đã thanh toán";
        $bill->save();
        $mail = $user->email;
        Mail::send('mail',compact('user','bill'),function($email) use ($mail){
            $email->to($mail);
            $email->subject('Ebill thông báo!');
        });
        return redirect('/pay');
    }
    public function showpay(){
        if (Auth::check()) {
            $user =  Auth::user();
            $bill = $latestBill = Bill::where('uid', $user->id)->latest('updated_at')->first();
            return view('pay', compact('bill','user'));
        } else {
            return view('login'); 
        }
    }
    public function showBill()
    {
        // // Validate input
        // $request->validate([
        //     'month' => 'required|date_format:Y-m',
        // ]);
            $user =  Auth::user();
        // Query bills for the specified month
        $bill = $latestBill = Bill::where('uid', $user->id)->latest()->first();

        // Return view with bills data (for web)
        return view('bill', compact('bill'));

        // Or return JSON response (for API)
        // return response()->json($bills);
    }
    public static function caculate($kWh){
        $l1 = $l2 = $l3 = $l4 = $l5 = $l6 = $cost = $total = $tax = 0;
        $ecost = Ecost::latest()->first();
        $c1 = $ecost->c1; $c2 =$ecost->c2; $c3 =$ecost->c3; $c4 =$ecost->c4; $c5 = $ecost->c5; $c6 = $ecost->c6;
        if ($kWh <= 50) {
            $l1 = $kWh;
        } elseif ($kWh <= 100) {
            $l1 = 50;
            $l2 = $kWh - 50;
        } elseif ($kWh <= 200) {
            $l1 = $l2 = 50;
            $l3 = $kWh - 100;
        } elseif ($kWh <= 300) {
            $l1 = $l2 = 50;
            $l3 = 100;
            $l4 = $kWh - 200;
        } elseif ($kWh <= 400) {
            $l1 = $l2 = 50;
            $l3 = $l4 = 100;
            $l5 = $kWh - 300;
        } else {
            $l1 = $l2 = 50;
            $l3 = $l4 = $l5 = 100;
            $l6 = $kWh - 400;
        }

        $cost = $l1 * $c1 + $l2 * $c2 + $l3 * $c3 + $l4 * $c4 + $l5 * $c5 + $l6 * $c6;
        $tax = $cost * 1.1;
        $total = round($tax, 3);

        return $total;
    }
}
