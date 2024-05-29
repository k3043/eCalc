<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Bill;
use App\Models\Ecost;
use App\Models\EConsumption;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Http\Controllers\calcController;
use Illuminate\Support\Facades\Validator;
use  Illuminate\Support\Facades\Mail;

class AdminController extends Controller
{
    public function customer(){
        if (Auth::check()) {
            $users = User::where('role','user')->get();
            return view('admin_cus',compact('users'));
        } else {
            return redirect('/login'); 
        }
    }
    public function deletecus(Request $request){
        $uid = $request->query('uid');
        $user = User::find($uid);
        if ($user) { 
            $bills = Bill::where('uid', $uid);
            $econ = EConsumption::where('uid',$uid); 
            if($econ) $econ->delete();
            if($bills){
                $bills->delete();
            }
            $user->delete();
            return redirect()->back()->with('success', 'User deleted successfully');
        }
        return redirect()->back()->with('error', 'User not found');
    }
    public function changerole(Request $request){
        $uid = $request->query('uid');
        $user = User::find($uid);
        if ($user) {
            $user->role = "admin";
            $user->save();
            return redirect()->back()->with('success', 'change role successfully');
        }
        return redirect()->back()->with('error', 'User not found');
    }
    public function showcuskwh(){
        if (Auth::check()) {
            $users = User::where('role','user')
            ->join('eConsumptions', 'users.id', '=', 'eConsumptions.uid')
            ->select('users.*', 'eConsumptions.econ as econ','eConsumptions.period as period')
            // ->where('period','>',Carbon::now()->subMonths(1)->endOfMonth())
            ->get();
            // $users = User::whereNotNull('cus_code')->get();
            return view('admin_updatekwh',compact('users'));
        } else {
            return redirect('/login'); 
        }
    }
    public function updatekwh(Request $request){
        $users = User::where('role','user')->get();
        $rules = [];
        $messages = [];

        foreach ($users as $user) {
            $rules["kwh.{$user->id}"] = 'required|numeric|min:0';
            $messages["kwh.{$user->id}.required"] = "Số điện của người dùng {$user->name} không được để trống";
            $messages["kwh.{$user->id}.numeric"] = "Số điện của người dùng {$user->name} phải là số";
            $messages["kwh.{$user->id}.min"] = "Số điện của người dùng {$user->name} phải lớn hơn hoặc bằng 0";
        }

        $validator = Validator::make($request->all(), $rules,$messages);
        if ($validator->fails()) {
            return redirect('/kwh')->withErrors($validator);
        }
        $kwhData = $request->input('kwh');
        foreach ($kwhData as $userId => $kwh){
            $econ = EConsumption::where('uid', $userId)->first();
            if ($econ) {
                $econ->econ = $kwh;
                $econ->save();
            }
        }
        return redirect('/kwh');
    }
    public function showcost(){
        $ecost = Ecost::latest()->first();
        return view('update_cost',compact('ecost'));
    }
    public function updatecost(Request $request){
        $ecost = new Ecost();
        $messages = [
            'c1.required' => 'Số điện bậc 1 không được để trống',
            'c1.numeric' => 'Số điện phải là số',
            'c1.min' => 'Số điện phải lớn hơn hoặc bằng 0',
            
            'c2.required' => 'Số điện bậc 2 không được để trống',
            'c2.numeric' => 'Số điện phải là số',
            'c2.min' => 'Số điện phải lớn hơn hoặc bằng 0',
            
            'c3.required' => 'Số điện bậc 3 không được để trống',
            'c3.numeric' => 'Số điện phải là số',
            'c3.min' => 'Số điện phải lớn hơn hoặc bằng 0',
            
            'c4.required' => 'Số điện bậc 4 không được để trống',
            'c4.numeric' => 'Số điện phải là số',
            'c4.min' => 'Số điện phải lớn hơn hoặc bằng 0',
            
            'c5.required' => 'Số điện bậc 5 không được để trống',
            'c5.numeric' => 'Số điện phải là số',
            'c5.min' => 'Số điện phải lớn hơn hoặc bằng 0',
            
            'c6.required' => 'Số điện bậc 6 không được để trống',
            'c6.numeric' => 'Số điện phải là số',
            'c6.min' => 'Số điện phải lớn hơn hoặc bằng 0',
        ];
        
        $validator = Validator::make($request->input(), [
            'c1' => 'required|numeric|min:0',
            'c2' => 'required|numeric|min:0',
            'c3' => 'required|numeric|min:0',
            'c4' => 'required|numeric|min:0',
            'c5' => 'required|numeric|min:0',
            'c6' => 'required|numeric|min:0',
        ], $messages);
        
        if ($validator->fails()) {
            return redirect()->back()
                             ->withErrors($validator)
                             ->withInput();
        }
        
        $ecost->c1 = $request->input('c1');
        $ecost->c2 =  $request->input('c2');
        $ecost->c3 =  $request->input('c3');
        $ecost->c4 =  $request->input('c4');
        $ecost->c5 =  $request->input('c5');
        $ecost->c6 =  $request->input('c6');
        $ecost->save();
        return redirect('/showcost');
    }

    public function showbill(){
            $users =  DB::table('users')
            ->join('bills', 'users.id', '=', 'bills.uid')
            ->where('role','=','user')
            ->select('users.*', 'bills.amount','bills.kwh_used as used','status')
            // ->where('period','>',Carbon::now()->subMonths(1)->endOfMonth())
            ->get();
        return view('bill',compact('users'));
    }
    public function closebill(){
        $users = User::where('role','user')->get();
        foreach($users as $user){
            $econ = EConsumption::where('uid',$user->id)->latest()->first();
            $used = $econ->econ;
            Bill::updateOrCreate(
                ['uid'=>$user->id],
                [   
                    'uid' => $user->id,
                    'month'=> Carbon::now()->toDateString(),
                    'kwh_used'=> $used,
                    'amount'=> calcController::caculate($used),
                    'status'=> 'chờ thanh toán',
                ]
            );
            $econ->econ = 0;
            $econ->save();
        }
        return redirect('/bill');
    }
    public function noti(){
        $users =  DB::table('users')
            ->join('bills', 'users.id', '=', 'bills.uid')
            ->select('users.*')
            ->where('status','=','chờ thanh toán')
            ->get();

        foreach($users as $user){
            $bill = $latestBill = Bill::where('uid', $user->id)->latest('updated_at')->first();
            $mail = $user->email;
            Mail::send('mail',compact('user','bill'),function($email) use ($mail){
                $email->to($mail);
                $title = "Thanh toán hóa đơn điện tháng " . date('m');
                $email->subject($title);
            });
        }
        return redirect('/bill');
    }
}
