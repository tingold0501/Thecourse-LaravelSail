<?php

namespace App\Http\Controllers;

use App\Models\Edu;
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

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request,)
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
        return response()->json(['check' => true, 'msg' => 'Thêm Loại Khoá Học Thành Công']);
    
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
