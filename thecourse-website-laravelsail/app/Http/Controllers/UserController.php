<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Mail\MailCreateUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = DB::table('users')->get();
        return response()->json($users);
    }

    

    public function indexActive(){
        $users = DB::table('users')->where('status', 1)->select()->get();
        return response()->json($users);
    }

    public function getAllNewUser(){
        $query = DB::table('users')->orderBy('id','desc')->take(5)->get();
        return response()->json($query);
    }

    public function getSumUsers(){
        $users = DB::table('users')->where('status', 1)->count();
        return response()->json($users);
    }
    public function getTeacher(){
        $teachers = DB::table('users')
        ->join('roles','users.role_id', '=', 'roles.id')
        ->where('roles.name','=','Teacher')
        ->count();
        return response()->json($teachers);
    }
    public function getAdmin(){
        $teachers = DB::table('users')
        ->join('roles','users.role_id', '=', 'roles.id')
        ->where('roles.name','=','Admin')
        ->count();
        return response()->json($teachers);
    }

    public function loginAdmin(Request $request, User $user){
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
        if(Auth::attempt(['email' => $request->email, 'password' =>  $request->password,'status'=>1,'role_id'=>1],true)){
            return response()->json(['check'=>true,'token'=>Auth::user()->remember_token, 'msg'=>'Admin Đăng Nhập Thành Công']);
        }else{
            return response()->json(['check'=>false,'msg'=>'Tài khoàn đăng nhập không hợp lệ']);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function loginTeacher(Request $request, User $user){
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
        if(Auth::attempt(['email' => $request->email, 'password' =>  $request->password,'status'=>1,'role_id'=>1],true)){
            return response()->json(['check'=>true,'token'=>Auth::user()->remember_token]);
        }else{
            return response()->json(['check'=>false,'msg'=>'Tài khoàn đăng nhập không hợp lệ']);
        }
    }
    public function loginStudent(Request $request, User $user){
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
        if(Auth::attempt(['email' => $request->email, 'password' =>  $request->password,'status'=>1,'role_id'=>3],true)){
            return response()->json(['check'=>true,'token'=>Auth::user()->remember_token]);
        }else{
            return response()->json(['check'=>false,'msg'=>'Tài khoàn đăng nhập không hợp lệ']);
        }
    }
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
        User::create(['name'=>$request->name, 'email'=>$request->email, 'password'=>$password, 
        'phone'=>$request->phone, 'role_id'=>$request->idRole]);
        $mailData = [
            // 'name' => $request->name,
            'email' => $request->email,
            'password' => $password,
        ];
        Mail::to($request->email)->send(new MailCreateUser($mailData));
        return response()->json(['check' => true, 'msg' => 'Đăng Ký Thành Công']);
    }

    public function updateRole(Request $request, User $user){
        $validator = Validator::make($request->all(), [
            'id' => 'required|exists:users,id',
            'idRole' => 'required|exists:roles,id',
        ],[
            'id.required' => 'Mã Người Dùng Không Được Trống',
            'id.exists' => 'Mã Người Dùng Không Tồn Tại',
            'idRole.required' => 'Mã Loại Không Được Trống',
            'idRole.exists' => 'Mã Loại Không Tồn Tại',
        ]);
 
        if ($validator->fails()) {
            return response()->json(['check' => false, 'msg' => $validator->errors()]);
        }
        User::where('id',$request->id)->update(['role_id'=>$request->idRole, 'updated_at'=>now()]);
        return response()->json(['check'=>true, 'msg'=>'Cập Nhập Thành Công']);
   
    }

    public function updateName(Request $request, User $user){
        $validator = Validator::make($request->all(), [
            'id' => 'required|exists:users,id',
            'name' => 'required',
        ],[
            'id.required' => 'Mã Người Không Được Trống',
            'id.exists' => 'Mã Không Tồn Tại',
            'name.required' => 'Tên Không Được Rỗng',
        ]);
        if ($validator->fails()) {
            return response()->json(['check' => false, 'msg' => $validator->errors()]);
        }
        User::where('id',$request->id)->update(['name'=>$request->name, 'updated_at'=>now()]);
        return response()->json(['check'=>true, 'msg'=>'Cập Nhập Thành Công']);
   
    }

    public function updateStatus(Request $request, User $user){
        $validator = Validator::make($request->all(), [
            'id' => 'required|exists:users,id',
            'status' => 'required|min:0|max:1',
        ],[
            'id.required' => 'Mã Người Không Được Trống',
            'id.exists' => 'Mã Không Tồn Tại',
            'status.required' => 'Trạng Thái Không Được Rỗng',
            'status.max' => 'Trạng Thái Vượt Quá Mức Quy Định',
            'status.min' => 'Trạng Thái Bé Quá Mực Quy Định',
        ]);
        if ($validator->fails()) {
            return response()->json(['check' => false, 'msg' => $validator->errors()]);
        }
        User::where('id',$request->id)->update(['status'=>$request->status]);
        return response()->json(['check'=>true, 'msg'=>'Cập Nhập Thành Công']);
    
    }

    public function updateEmail(Request $request, User $user){
        $validator = Validator::make($request->all(), [
            'id' => 'required|exists:users,id',
            'email' => 'required|email|unique:users,email',
        ],[
            'id.required' => 'Mã Người Không Được Trống',
            'id.exists' => 'Mã Không Tồn Tại',
            'email.required' => 'Email Không Được Rỗng',
            'email.email' => 'Email Không Đúng Định Dạng Email',
            'email.unique' => 'Email Đã Tồn Tại',
        ]);
        if ($validator->fails()) {
            return response()->json(['check' => false, 'msg' => $validator->errors()]);
        }
        User::where('id',$request->id)->update(['email'=>$request->email]);
        return response()->json(['check'=>true, 'msg'=>'Cập Nhập Thành Công']);
    
    }

    public function delete(Request $request, User $user){
        $validator = Validator::make($request->all(), [
            'id' => 'required|exists:users,id',
        ],[
            'id.required' => 'Mã Người Không Được Trống',
            'id.exists' => 'Mã Không Tồn Tại',
        ]);
        if ($validator->fails()) {
            return response()->json(['check' => false, 'msg' => $validator->errors()]);
        }
        User::where('id',$request->id)->delete();
        return response()->json(['check'=>true, 'msg'=>'Xóa Thành Công']);
    }


    public function updatePhone(Request $request, User $user){
        $validator = Validator::make($request->all(), [
            'id' => 'required|exists:users,id',
            'phone' => 'required|unique:users,phone',
        ],[
            'id.required' => 'Mã Người Không Được Trống',
            'id.exists' => 'Mã Không Tồn Tại',
            'phone.required' => 'Số Điện Thoại Không Được Rỗng',
            'phone.unique' => 'Số Điện Thoại Đã Tồn Tại',
            
        ]);
        if ($validator->fails()) {
            return response()->json(['check' => false, 'msg' => $validator->errors()]);
        }
        User::where('id',$request->id)->update(['phone'=>$request->phone]);
        return response()->json(['check'=>true, 'msg'=>'Cập Nhập Thành Công']);
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
