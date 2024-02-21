<?php

namespace App\Http\Controllers;

use App\Models\Edu;
use App\Models\Cate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class EduController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $edus = DB::table('edus')->get();
        return response()->json($edus);
    }

    public function getData(){
        $result = DB::table('edus')->paginate(4);
        return $result;
    }
    public function activeEdu(){
        $edu = Edu::where('status',1)->select('id','name')->get();
        return response()->json($edu);
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:edus,name',
        ],[
            'name.required' => 'Tên Khoá Học Không Được Trống',
            'name.unique' => 'Tên Khoá Học Đã Tồn Tại ',
        ]);
        if ($validator->fails()) {
            return response()->json(['check' => false, 'msg' => $validator->errors()]);
        }
        Edu::create(['name'=>$request->name]);
        $result = $this->getData();
        return response()->json(['check' => true,'edu'=>$result, 'msg' => 'Thêm Loại Khoá Học Thành Công']);
    }

    public function editEdu(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:edus,name',
            'id' => 'required|exists:edus,id'
        ],[
            'name.required' => 'Tên Khoá Học Không Được Trống',
            'name.unique' => 'Tên Khoá Học Đã Tồn Tại ',
            'id.required' => 'Mã Edu Không Được Trống ',
            'id.exists' => 'Mã Edu Không Tồn Tại ',
        ]);
        if ($validator->fails()) {
            return response()->json(['check' => false, 'msg' => $validator->errors()]);
        }
        Edu::where('id', $request->id)->update(['name' => $request->name, 'updated_at' => now()]);
        $result = $this->getData();
        return response()->json(['check' => true, 'edu' => $result]);
    
    }
    public function switchEdu(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'status' => 'required|numeric|min:0|max:1',
                'id' => 'required|exists:edus,id',
            ],
            [
                'status.required' => 'Thiếu mã status hình giáo dục',
                'status.numeric' => 'Mã status không hợp lệ', 
                'status.min' => 'Mã status không hợp lệ',
                'status.max' => 'Mã status không hợp lệ',
                'id.required' => 'Thiếu mã loại giáo dục',
                'id.exists' => 'Mã loại giáo dục không tồn tại',
            ],
        );
        if ($validator->fails()) {
            return response()->json(['check' => false, 'msg' => $validator->errors()]);
        }
        Edu::where('id', $request->id)->update(['status' => $request->status, 'updated_at' => now()]);
        $result = $this->getData();
        return response()->json(['check' => true, 'edu' => $result]);
    }
    public function deleteEdu(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'id' => 'required|exists:edus,id',
            ],
            [
                'id.required' => 'Thiếu mã loại hình giáo dục',
                'id.exists' => 'Mã loại hình giáo dục không tồn tại',
            ],
        );
        if ($validator->fails()) {
            return response()->json(['check' => false, 'msg' => $validator->errors()]);
        }
        $check= Cate::where('edu_id',$request->id)->count('id');
        if($check!=0){
            return response()->json(['check'=>false,'msg'=>'Loại hình giáo dục có lớp']);
        }
        Edu::where('id',$request->id)->delete();
        $result = $this->getData();
        return response()->json(['check'=>true,'edu'=>$result]);
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
    public function show(Edu $edu)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    
    public function edit(Edu $edu)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Edu $edu)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Edu $edu)
    {
        //
    }
}
