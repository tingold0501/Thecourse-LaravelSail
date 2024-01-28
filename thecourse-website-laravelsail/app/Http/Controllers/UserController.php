<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = DB::table('users')->get();
        return response()->json($users);
        dd($user);
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
        return response()->json(['check' => true, 'msg' => 'Đăng Ký Thành Công']);
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
        User::where('id',$request->id)->update(['name'=>$request->name]);
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
        User::where('id',$request->id)->update(['email'=>$request->email]);
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
