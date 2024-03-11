<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use App\Mail\MailCreateUser;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $result = DB::table('users')->get();
        return response()->json($result);
    }
    public function loginCustomer(Request $request, User $user){
        $validator = Validator::make(
            $request->all(),
            [
                'password' => 'required',
                'email' => 'required|email|exists:users,email',
            ],
            [
                'password.required' => 'Thiếu mật khẩu tài khoản',
                'email.required' => 'Thiếu email tài khoản',
                'email.email' => 'Email tài khoản không hợp lệ',
                'email.exists' => 'Email tài khoản không tồn tại',
            ],
        );
        if ($validator->fails()) {
            return response()->json(['check' => false, 'msg' => $validator->errors()]);
        }
        if(Auth::attempt(['email' => $request->email, 'password' => $request->password,'status'=>1,'role_id'=>4],true)){
            return response()->json(['check'=>true,'token'=>Auth::user()->remember_token]);
        }else{
            return response()->json(['check'=>false,'msg'=>'Tài khoàn đăng nhập không hợp lệ']);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request, User $user)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|unique:users,phone',
            'idRole' => 'required|exists:roles,id',
        ],[
            'name.required' => 'Tên Không Được Trống',
            'email.required' => 'Email Không Được Trống',
            'email.email' => 'Email Này Không Phải Dạng Email',
            'email.unique' => 'Email Đã Tồn Tại',
            'phone.required' => 'Số Điện Thoại Không Được Trống',
            'phone.unique' => 'Số Điện Thoại Đã Được Đăng Ký',
            'idRole.required' => 'Mã Loại Không Được Trống',
            'idRole.exists' => 'Mã Loại Không Tồn Tại',
        ]);
        if ($validator->fails()) {
            return response()->json(['check' => false, 'msg' => $validator->errors()]);
        }
        $password = random_int(111111,999999);
        User::create(['name'=>$request->name, 'email'=>$request->email, 'password'=>$password, 'phone'=>$request->phone, 'role_id'=>$request->idRole]);
        $mailData = [
            // 'name' => $request->name,
            'email' => $request->email,
            'password' => $password,
        ];
        Mail::to($request->email)->send(new MailCreateUser($mailData));
        return response()->json(['check'=>true, 'msg'=>'Đăng Ký Nhập Thành Công']);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        //
    }
}
