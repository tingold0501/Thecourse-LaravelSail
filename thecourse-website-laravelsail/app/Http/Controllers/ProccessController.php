<?php

namespace App\Http\Controllers;

use App\Models\Proccess;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Models\Bill;
use App\Models\User;
use App\Models\ProccessDetail;
use App\Mail\UserMail;
use App\Mail\ClassMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
class ProccessController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function submitClass(Request $request){
        $validator = Validator::make(
            $request->all(),
            [
                'id' => 'required|exists:proccesses,id',
                'token' => 'required|exists:users,remember_token',
               
            ],
            
        );
        if ($validator->fails()) {
            return response()->json(['check' => false, 'msg' => $validator->errors()]);
        }  
        $idUser = User::where('remember_token',$request->token)->value('id');
        $check = Proccess::where('id',$request->id)
        ->where('user_id',$idUser)
        ->count('id');
        if($check==0){
            return response()->json(['check'=>false,'msg'=>'Không đúng lớp']);
        }
        $pass = Proccess::where('id',$request->id)->value('pass');
        $newpass=$pass+1;
        Proccess::where('id',$request->id)->update(['pass'=>$newpass,'updated_at'=>now()]);
        $result = DB::Table('proccesses')
        ->join('courses','proccesses.course_id','=','courses.id')
        ->join('users','proccesses.user_id','=','users.id')
        ->where('proccesses.user_id',$idUser)
        ->select('proccesses.name as className','proccesses.id as id','users.name as teacher','proccesses.pass as pass','courses.name as coursename')
        ->get();
        return response()->json(['check'=>true,'result'=>$result]);
    }
 //====================================
    public function getTeacherClass(Request $request){
        $validator = Validator::make(
            $request->all(),
            [
                'token' => 'required|exists:users,remember_token',
            ],
        );
        if ($validator->fails()) {
            return response()->json(['check' => false, 'msg' => $validator->errors()]);
        }
        $id = User::where('remember_token',$request->token)->value('id');
        $result = DB::Table('proccesses')
        ->join('courses','proccesses.course_id','=','courses.id')
        ->join('users','proccesses.user_id','=','users.id')
        ->where('proccesses.user_id',$id)
        ->select('proccesses.name as className','proccesses.id as id','users.name as teacher','proccesses.pass as pass','courses.name as coursename')
        ->get();
        return response()->json($result);
    }
    //====================================
    public function getStudentClass(Request $request){
        $validator = Validator::make(
            $request->all(),
            [
                'token' => 'required|exists:users,remember_token',
            ],
        );
        if ($validator->fails()) {
            return response()->json(['check' => false, 'msg' => $validator->errors()]);
        }
        $id = User::where('remember_token',$request->token)->value('id');
        $result = DB::Table('proccess_detail')
        ->join('process_tbl','proccess_detail.idProccess','=','process_tbl.id')
        ->join('courses','process_tbl.idCourse','=','courses.id')
        ->join('users','process_tbl.user_id','=','users.id')
        ->where('proccess_detail.idStudent',$id)
        ->select('process_tbl.name as className','users.name as teacher','process_tbl.pass as pass','proccess_detail.duration','courses.name as coursename')
        ->get();
        return response()->json($result);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $result = DB::table('process_tbl')
        ->join('courses','process_tbl.idCourse','=','courses.id')
        ->join('users','process_tbl.idTeacher','=','users.id')
        ->select('process_tbl.*','courses.name as coursename','users.name as username')
        ->get();
        return response()->json($result);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function addStudent(Request $request)
    {
         $validator = Validator::make(
            $request->all(),
            [
                'username' => 'required',
                'email' => 'required|email',
                'phone' => 'required|max:10',
                'duration'=>'required|exists:course_duration,id',
                'idProccess'=>'required|exists:process_tbl,id',
                'idBill'=>'required|exists:bill_tbl,id'
            ],
            
        );
        if ($validator->fails()) {
            return response()->json(['check' => false, 'msg' => $validator->errors()]);
        }
        $check = User::where('idRole',3)->where('email',$request->email)->count('id');
        if($check!=0){
            $idUser = User::where('idRole',3)->where('email',$request->email)->value('id');
            $idDetail = proccess_detailM::insertGetId(['idProccess'=>$request->idProccess,'idStudent'=>$idUser,'duration'=>$request->duration]);
            $result = DB::Table('proccess_detail')
            ->join('process_tbl','proccess_detail.idProccess','=','process_tbl.id')
            ->join('users','process_tbl.idTeacher','=','users.id')
            ->join('courses','process_tbl.idCourse','=','courses.id')
            ->where('proccess_detail.id','=',$idDetail)
            ->select('courses.name as name','users.name as teacher','process_tbl.schedules as schedule','proccess_detail.duration as duration')
            ->first();
            $course = (object) [
                'name'=>'',
                'teacher'=>'',
                'schedule'=>'',
                'duration'=>0
            ];
            $course->name = $result->name;
            $course->teacher = $result->teacher;
            $course->schedule = $result->schedule;
            $course->duration = $request->duration;
            
            $mailData=[
                'course'=>$course,
            ];

            Mail::to($request->email)->cc('leodomsolar@gmail.com')->send(new scheduleMail($mailData));
        }else{
            $idUser =User::insertGetId(['email'=>$request->email,'password'=>Hash::make(111111),'name'=>$request->username,'phone'=>$request->phone,'idRole'=>3]);
            $mailData = [
            'name' => $request->username,
            'email' => $request->email,
            'password' => 111111,
            ];
            Mail::to($request->email)->send(new UserMail($mailData));
            $idDetail = proccess_detailM::insertGetId(['idProccess'=>$request->idProccess,'idStudent'=>$idUser,'duration'=>$request->duration]);
            $result = DB::Table('proccess_detail')
            ->join('process_tbl','proccess_detail.idProccess','=','process_tbl.id')
            ->join('users','process_tbl.idTeacher','=','users.id')
            ->join('courses','process_tbl.idCourse','=','courses.id')
            ->where('proccess_detail.id','=',$idDetail)
            ->select('courses.name as name','users.name as teacher','process_tbl.schedules as schedule','proccess_detail.duration as duration')
            ->first();
            $course = (object) [
                'name'=>'',
                'teacher'=>'',
                'schedule'=>'',
                'duration'=>0
            ];
            
            $course->name = $result->name;
            $course->teacher = $result->teacher;
            $course->schedule = $result->schedule;
            $course->duration = $request->duration;
            $mailData=[
                'course'=>$course,
            ];
            Mail::to($request->email)->cc('leodomsolar@gmail.com')->send(new scheduleMail($mailData));
            $course->name = $result->name;
            $course->teacher = $result->teacher;
            $course->schedule = $result->schedule;
            $course->duration = $request->duration;
            $mailData=[
                'course'=>$course,
            ];
            Mail::to($request->email)->cc('leodomsolar@gmail.com')->send(new scheduleMail($mailData));
        }
        BillM::where('id',$request->idBill)->update(['status'=>1,'updated_at'=>now()]);
        return response()->json(['check'=>true]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'name' => 'required',
                'schedule' => 'required',
                'idCourse' => 'required|exists:courses,id',
                'idTeacher'=>'required|exists:users,id'
            ],
            
        );
        if ($validator->fails()) {
            return response()->json(['check' => false, 'msg' => $validator->errors()]);
        }
        Proccess::create(['name'=>$request->name,'idTeacher'=>$request->idTeacher,'idCourse'=>$request->idCourse,'schedules'=>$request->schedule]);
        return  response()->json(['check'=>true], 200);
    }
    // ============================================
    public function getRunning(){
        $result = DB::Table('process_tbl')->join('courses','process_tbl.idCourse','=','courses.id')
        ->join('users','process_tbl.idTeacher','=','users.id')
        ->join('proccess_detail','process_tbl.id','=','proccess_detail.idProccess')
        ->select('process_tbl.name as className','process_tbl.id as id','process_tbl.schedules as schedules','courses.name as courseName','users.name as teacher','process_tbl.pass as pass',DB::raw('count(proccess_detail.idStudent) as studentscount'))->groupBy('proccess_detail.idProccess')->get();
        return response()->json($result);
    }
    // =============================================
    public function updateClassChedule(Request $request){
         $validator = Validator::make(
            $request->all(),
            [
                'id' => 'required|exists:process_tbl,id',
                'schedules' => 'required',
                
            ],
            
        );
        if ($validator->fails()) {
            return response()->json(['check' => false, 'msg' => $validator->errors()]);
        }
        proccessM::where('id',$request->id)->update(['schedules'=>$request->schedules,'updated_at'=>now()]);
        $result = DB::Table('process_tbl')->join('courses','process_tbl.idCourse','=','courses.id')
        ->join('users','process_tbl.idTeacher','=','users.id')
        ->join('proccess_detail','process_tbl.id','=','proccess_detail.idProccess')
        ->select('process_tbl.name as className','process_tbl.id as id','process_tbl.schedules as schedules','courses.name as courseName','users.name as teacher','process_tbl.pass as pass',DB::raw('count(proccess_detail.idStudent) as studentscount'))->groupBy('proccess_detail.idProccess')->get();
        return response()->json(['check'=>true,'result'=>$result]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
   

    /**
     * Display the specified resource.
     */
    public function show(Proccess $proccess)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Proccess $proccess)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Proccess $proccess)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Proccess $proccess)
    {
        //
    }
}
