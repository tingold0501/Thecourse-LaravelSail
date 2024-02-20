<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Cate;
use App\Models\Duration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $courses = DB::table('courses')->get();
        return response()->json($courses);
    }

    public function getCoursesCate($id){
        $result = DB::table('course_cates')->where('edu_id',$id)->get();
        return $result;
    }

    public function getDuration($id){
        $result = DB::table('courses_durations')->where('course_id',$id)->select('id','duration','price')->get();
        return $result;
    }

    public function getCourseCreate(){
        $result = DB::table('courses')->where('status',1)->get()
        ->select('id','name')->get();
        return response()->json($result);
    }

    public function singleCourseUser($id){
        $course = DB::table('courses')->where('id',$id)->get();
        $duration = $this->getDuration($id);
        $class = DB::table('classes')->join('users','classes.user_id', '=', 'users.id')->where('course_id',$id)
        ->select('classes.*','users.name')->get();
        return response()->json(['course'=>$course, 'duration'=>$duration,'class'=>$class]);
    }

    public function currentCourses(){
        $result = DB::table('courses')
        ->where('status',1)->inRandomOrder()
        ->select('courses.*')
        ->limit(3)->get();
    }
    //===================================================
    public function getActiveCourses(){
        $result = DB::table('courses')->where('status',1)->select('id','name')->get();
        return response()->json($result);
    }
    //====================================================
    public function getCoursePrice($id){
        $result =$this->getDuration($id);
        return response()->json($result);
    }

    public function addPrice(Request $request){
        $validator =  Validator::make(
            $request->all(),
            [
                'duration' => 'required|min:0',
                'id'=>'required|exists:courses,id',
                'price'=>'required|min:0'
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
        Duration::create(['course_id'=>$request->id,'duration'=>$request->duration,'price'=>$request->price]);
        $result = $this->getDuration($request->id);
        return response()->json(['check'=>true, 'result'=>$result]);
    }
    public function deleteDuration($id){
        $check = Duration::where('id',$id)->count('id');
        if($check==0){
            return response()->json(['check'=>false,'msg'=>'Không tồn tại giá trị']);
        }
        $idCourse=Duration::where('id',$id)->value('course_id');
        Duration::where('id',$id)->delete();
        $result =$this->getDuration($idCourse);
        return response()->json(['check'=>true,'result'=>$result]);
    
    }
    //======================
    public function createCourse(Request $request){
        $validator =  Validator::make(
            $request->all(),
            [
                'coursename' => 'required|unique:courses,name',
                'summary'=>'required',
                'grade'=>'required',
                'course_cate_id'=>'required|exists:course_cates,id',
                'file'=>'required|mimes:gif,jpeg,png,webp,jpg,JPG,jfif,GIF,JPEG,PNG,WEBP',
                'module'=>'required'
            ],
            [
                'coursename.required' => 'Thiếu tên khoá học',
                'coursename.unique' => 'Tên khoá học bị trùng',
                'summary.required' => 'Thiếu tóm tắt nội dung khoá học',
                'grade.required' => 'Thiếu khối lớp của khoá học',
                'course_cate_id.required' => 'Thiếu mã loại hình lớp',
                'course_cate_id.exists' => 'Mã loại hình lớp không tồn tại',
                'file.required' => 'Thiếu hình ảnh khoá học',
                'file.mimes' => 'Hình ảnh khoá học không đúng định dạng',
                'module.required'=>'Thiếu module khoá học',
            ],
        );
        if ($validator->fails()) {
            return response()->json(['check' => false, 'msg' => $validator->errors()]);
        }
        $filename=$_FILES['file']['name'];
        $file_tmp=$_FILES['file']['tmp_name'];
        move_uploaded_file($file_tmp,'images/'.$filename);
        Course::create(['name'=>$request->coursename,'summary'=>$request->summary,'image'=>$filename,
        'discount'=>$request->discount,'course_cate_id'=>$request->course_cate_id,'Grade'=>$request->grade,'detail'=>$request->module]);
        $result = $this->getCourse($request->course_cate_id);
        return  response()->json(['check'=>true,'result'=>$result]);
    
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Course $course)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Course $course)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Course $course)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Course $course)
    {
        //
    }
}
