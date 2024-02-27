<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $roles = DB::table('roles')->get();
        return response()->json($roles);
        dd($roles);
    }

    public function getNewRole(){
        $query = DB::table('roles')->orderBy('id','desc')->take(5)->get();
        return response()->json($query);
    }

    public function getSumRole(){
        $roles = DB::table('roles')->where('status',1)->count();
        return response()->json($roles);
    }

    public function getAcctiveRole(){
        $roles = DB::table('roles')->where('status',1)->select()->get();
        return response()->json($roles);
    }



    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request,Role $role)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:roles,name',
        ],[
            'name.required' => 'Tên Loại Không Được Trống',
            'name.unique' => 'Tên Loại Đã Tồn Tại ',
        ]);
        if ($validator->fails()) {
            return response()->json(['check' => false, 'msg' => $validator->errors()]);
        }
        Role::create(['name'=>$request->name]);
        return response()->json(['check' => true, 'msg' => 'Thêm Loại Tài Khoản Thành Công']);
    
    }

    public function updateName(Request $request,Role $role){
        $validator = Validator::make($request->all(), [
            'id' => 'required|exists:roles,id',
            'name' => 'required|unique:roles,name',
        ],[
            'id.required' => 'Mã Loại Không Được Trống',
            'id.exists' => 'Mã Loại Không Tồn Tại',
            'name.required' => 'Tên Loại Không Được Trống',
            'name.unique' => 'Tên Loại Đã Tồn Tại ',
        ]);
        if ($validator->fails()) {
            return response()->json(['check' => false, 'msg' => $validator->errors()]);
        }
        Role::where('id', $request->id)->where('id', '>', 3)->update(['name'=>$request->name]);
        return response()->json(['check' => true, 'msg'=>'Tên Loại Đã Được Sửa']);
    }

    public function updateStatus(Request $request,Role $role){
        $validator = Validator::make($request->all(), [
            'id' => 'required|exists:roles,id',
            'status' => 'required|numeric|max:1|min:0',
        ],[
            'id.required' => 'Mã Loại Không Được Trống',
            'id.exists' => 'Mã Loại Không Tồn Tại',
            'status.required' => 'Tên Loại Không Được Trống',
            'status.numeric' => 'Trạng Thái Không Hợp Lệ',
            'status.max' => 'Trạng Thái Vượt Quá Quy Định',
            'status.min' => 'Trạng Thái Nhỏ Hơn Quy Định',
        ]);
        if ($validator->fails()) {
            return response()->json(['check' => false, 'msg' => $validator->errors()]);
        }
        Role::where('id', $request->id)->update(['status'=>$request->status]);
        return response()->json(['check' => true, 'msg'=>'Cập Nhập Trạng Thái Thành Công']);
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
    public function show(Role $role)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Role $role)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Role $role)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request,Role $role)
    {
        $validator = Validator::make($request->all(), [
            'id'=>'required|exists:roles,id',
        ],[
            'id.required'=>'Thiếu mã loại tài khoản',
            'id.exists'=>'Mã loại tài khoản không hợp lệ',
        ]);
        if ($validator->fails()) {
             return response()->json(['check'=>false, 'msg' => $validator->errors()]);
        }
        $check=User::where('role_id',$request->id)->count('id');
        if($check!=0){
            return response()->json(['check'=>false,'msg'=>'Có tài khoản tồn tại trong loại này']);
        }
        if($request->id ==1||$request->id==2||$request->id==3){
             return response()->json(['check'=>false,'msg'=>'Không được xoá']);
        }
        Role::where('id',$request->id)->delete();
        return response()->json(['check'=>true,'msg'=>'Xoá Loại Tài Tài Khoản Thành Công']);

    }
}
