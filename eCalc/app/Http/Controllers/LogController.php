<?php

namespace App\Http\Controllers;

use App\Models\EConsumption;
use App\Models\UserModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use  Illuminate\Support\Facades\Mail;
use Carbon\Carbon;
use Illuminate\Support\Facades\Redirect;
class LogController extends Controller
{
    
    public function login(Request $request){
        $messages = [
            'email.required' => 'Không được để trống email',
            'email.string' => 'Email phải là chuỗi ký tự',
            'email.email' => 'Email phải đúng định dạng',
            'email.max' => 'Email không được vượt quá 255 ký tự',
            'password.required' => 'Không được để trống mật khẩu',
            'password.string' => 'Mật khẩu phải là chuỗi ký tự',
            'password.min' => 'Mật khẩu phải có ít nhất 8 ký tự',
        ];
        $validator = Validator::make($request->input(), [
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:8',
        ],$messages);
        
        if ($validator->fails()) {
            return redirect('login')->withErrors($validator);
        }
                        
        $email = $request->input('email');
        $password = $request->input('password');
        $user = User::where('email', $email)->first();

    if ($user && Hash::check($password, $user->password) ) {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            if($user->role == 'admin')
                return redirect('/customer');
            else return redirect('/calc');
        }
    } else {
        // Đăng nhập không thành công
        $err = 'Thông tin đăng nhập không hợp lệ';
        return redirect('/login')->withErrors($err);
                            
        }
   
    }

    public function register(Request $request){
        $messages = [
            'name.required' => 'Tên không được để trống',
            'name.string' => 'Tên phải là chuỗi ký tự',
            'name.max' => 'Tên không được vượt quá 255 ký tự',
            'email.required' => 'Email không được để trống',
            'email.string' => 'Email phải là chuỗi ký tự',
            'email.email' => 'Email phải đúng định dạng',
            'email.max' => 'Email không được vượt quá 255 ký tự',
            'email.unique' => 'Email đã tồn tại',
            'password.required' => 'Mật khẩu không được để trống',
            'password.string' => 'Mật khẩu phải là chuỗi ký tự',
            'password.min' => 'Mật khẩu phải có ít nhất 8 ký tự',
            'password.confirmed' => 'Xác nhận mật khẩu không khớp',
        ];
        $validator = Validator::make($request->input(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ],$messages);
        
        if ($validator->fails()) {
            return redirect('register')
                        ->withErrors($validator)
                        ->withInput();
        }   
            $user = User::create([
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'password' => Hash::make($request->input('password')),
            ]);
            $user->cus_code = $this->generateCustomerCode($user->id);
            $user->save();
            $code = $user->cus_code;
            $name = $user->name;
            $ec = new EConsumption();
            $ec->uid = $user->id;
            $ec->econ = 0;
            $ec->period = Carbon::now()->startOfMonth()->toDateString();
            $ec->save();
            Mail::send('successCreateMail',compact('name','code'),function($email)use ($user) {
                $email->to($user->email);
                $email->subject('Tạo tài khoản Ebill thành công!');
            });
            // Đăng nhập người dùng mới
            Auth::login($user);

            // Điều hướng đến trang đích sau khi đăng ký thành công
            return redirect()->intended('calc');
        }
        public function logout(){
            Auth::logout();
            return redirect('/');
        }
        public function generateCustomerCode($userId)
        {
            $customerId = str_pad($userId, 5, '0', STR_PAD_LEFT);
            $customerCode = 'KH' . $customerId;

            return $customerCode;
        }
}
