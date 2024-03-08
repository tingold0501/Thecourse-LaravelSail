<?php

namespace App\Http\Controllers;

use App\Models\Bill;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
class BillController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function getSumBill(){
        $result = DB::table('bills')->where('status',1)->count();
        return response()->json($result);
    }
    public function index()
    {
        $result= DB::Table('bills')
        ->join('classes','bills.classe_id','=','classes.id')
        ->join('courses_durations','bills.courses_duration_id','courses_durations.id')
        ->join('courses','courses_durations.course_id','=','courses.id')
        ->join('users','classes.user_id','=','users.id')
        ->select('bills.*','classes.schedule as schedule','users.name as teacher','courses_durations.duration as duration','courses.name as coursename')
        ->get();
        return response()->json($result);
    }
    public function create(Request $request)
    {
        $validator =  Validator::make(
            $request->all(),
            [
                'name' => 'required',
                'phone'=>'required',
                'email'=>'required|email',
                'idSchedule'=>'required|exists:classes,id',
                'idDuration'=>'required|exists:courses_durations,id',

            ],
            [
                'duration.required' => 'Thiếu thời lượng khoá học',
                'duration.min' => 'Thời lượng khoá học không hợp lệ',
                'price.required'=>'Thiếu giá khoá học',
                'price.min'=>'Giá khoá học không hợp lệ',
                'id.required'=>'Thiếu mã khoá học',
                'id.exists'=>'Mã khoá học không tồn tại',
            ],
        );
        if ($validator->fails()) {
            return response()->json(['check' => false, 'msg' => $validator->errors()]);
        }
        Bill::create(['name'=>$request->name,'email'=>$request->email,'phone'=>$request->phone,'classe_id'=>$request->idSchedule,'courses_duration_id'=>$request->idDuration]);
        $result =  DB::Table('classes')
        ->join('courses','classes.course_id','=','courses.id')
        ->join('courses_durations','courses.id','=','courses_durations.course_id')
        ->where('classes.id',$request->idSchedule)
        ->where('courses_durations.id',$request->idDuration)
        ->select('courses.name as name','courses_durations.price as price','courses.discount as discount')
        ->first();
        $course = (object) [
                'name'=>'',
                'price'=>0,
            ];
            $course->name = $result->name;
            $course->price =$result->price * (100-$result->discount)/100;
            $mailData=[
                'name'=>$request->name,
                'course'=>$course,
            ];
            Mail::to($request->email)->cc('huynhtin0501@gmail.com')->send(new BillMail($mailData));
            return  response()->json(['check'=>true]);
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
    public function show(Bill $bill)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Bill $bill)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Bill $bill)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Bill $bill)
    {
        //
    }
}
