<?php

namespace App\Http\Controllers;

use App\Models\UserModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use  Illuminate\Support\Facades\Mail;
class LogController extends Controller
{
    public function login(Request $request){
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
        return redirect('/login');
        }
    }

    public function register(Request $request){
        $validator = Validator::make($request->input(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);
        
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
            Mail::send('successCreateMail',compact('name','code'),function($email)use ($user) {
                $email->to($user->email);
                $email->subject('Khánh gửi mail bằng Laravel');
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
