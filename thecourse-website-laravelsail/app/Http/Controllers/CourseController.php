<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Cate;
use App\Models\Duration;
use App\Models\Classes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    
    public function getAllCourse(){
        $result = DB::table('courses')
        // ->join('courses_durations','courses.id','=','courses_durations.course_id')
        // ->join('proccesses','courses.id','=','proccesses.course_id')
        // ->select('courses.*','proccesses.pass','courses_durations.price')
        ->get();
        return response()->json($result);
    }
    public function getLatestCourses()
    {
        $latestCourse = DB::table('courses')->where('status',1)->orderBy('id','desc')->take(4)->get();
        return response()->json($latestCourse);
    }
    public function getSumCourse(){
        $result = DB::table('courses')->where('status',1)->count();
        return response()->json($result);
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

    public function deleteCourse(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id'=>'required|exists:courses,id',
        ],[
            'id.required'=>'Thiếu mã khoá học',
            'id.exists'=>'Mã khoá học không hợp lệ',
        ]);
        if ($validator->fails()) {
             return response()->json(['check'=>false, 'msg' => $validator->errors()]);
        }
        $check=Classes::where('course_id',$request->id)->count('id');
        if($check!=0){
            return response()->json(['check'=>false,'msg'=>'Có khoá học đang hoàn tại trong lớp học']);
        }
        
        Course::where('id',$request->id)->delete();
        return response()->json(['check'=>true,'msg'=>'Xoá khoá học thành Thành Công']);

    }
    public function switchCate(Request $request){
        $validator =  Validator::make(
            $request->all(),
            [
                'status' => 'required|min:0|max:1',
                'id'=>'required|numeric|exists:course_cates,id',
            ],
            [
                'status.required' => 'Thiếu mã trạng thái loại hình lớp học',
                'status.min|status.max'=>'Mã trạng thái không hợp lệ',
                'id.required'=>'Thiếu mã loại hình lớp học',
                'id.exists'=>'Mã loại hình lớp học không tồn tại',
            ],
        );
        if ($validator->fails()) {
            return response()->json(['check' => false, 'msg' => $validator->errors()]);
        }
        Cate::where('id',$request->id)->update(['status'=>$request->status,'updated_at'=>now()]);
        $idEdu = Cate::where('id',$request->id)->value('edu_id');
        $result = $this->getCourseCate($idEdu);
        return  response()->json(['check'=>true,'result'=>$result]);
    }
    public function activeCate(){
        $result = Cate::where('status',1)->select('id','name')->get();
        return response()->json($result);
    }
    public function editCourseCate(Request $request){
        $validator =  Validator::make(
            $request->all(),
            [
                'name' => 'required',
                'id'=>'required|numeric|exists:course_cates,id',
            ],
            [
                'name.required' => 'Thiếu tên loại hình lớp học',
                'id.required'=>'Thiếu mã loại hình lớp học',
                'id.exists'=>'Mã loại hình lớp học không tồn tại',
            ],
        );
        if ($validator->fails()) {
            return response()->json(['check' => false, 'msg' => $validator->errors()]);
        }
        Cate::where('id',$request->id)->update(['name'=>$request->name,'updated_at'=>now()]);
        $idEdu = Cate::where('id',$request->id)->value('edu_id');
        $result = $this->getCourseCate($idEdu);
        return  response()->json(['check'=>true,'result'=>$result]);
    }
    public function DelCate(Request $request){
        $validator =  Validator::make(
            $request->all(),
            [
                'idD'=>'required|exists:course_cates,id',
            ],
            [
                'idD.required'=>'Thiếu mã loại hình lớp học',
                'idD.exists'=>'Mã loại hình lớp học không tồn tại',
            ],
        );
        if ($validator->fails()) {
            return response()->json(['check' => false, 'msg' => $validator->errors()]);
        }
        $idEdu = Cate::where('id',$request->idD)->value('edu_id');
        $check= Course::where('course_cate_id',$request->idD)->count('id');
        if($check!=0){
            return response()->json(['check'=>false,'msg'=>'Có khoá học trong loại này']);
        }
        $idEdu = Cate::where('id',$request->idD)->value('edu_id');
        Cate::where('id',$request->idD)->delete();
        $result =  DB::Table('course_cates')->where('edu_id',$idEdu)->get();

        return  response()->json(['check'=>true,'result'=>$result]);
    }
    public function createCourseCate(Request $request){
        $validator =  Validator::make(
            $request->all(),
            [
                'name' => 'required',
                'idEdu'=>'required|exists:edus,id',
            ],
            [
                'name.required' => 'Thiếu tên loại hình lớp học',
                'idEdu.required'=>'Thiếu mã loại hình giáo dục',
                'idEdu.exists'=>'Mã loại hình giáo dục không tồn tại',
            ],
        );
        if ($validator->fails()) {
            return response()->json(['check' => false, 'msg' => $validator->errors()]);
        }
        Cate::create(['name'=>$request->name,'edu_id'=>$request->idEdu]);
        $result = $this->getCourseCate($request->idEdu);
        return  response()->json(['check'=>true,'result'=>$result]);
    }
    public function index($id)
    {
        $result = $this->getCourseCate($id);
        return response()->json($result);
    }
    public function getCourse($id){
        $result = DB::Table('courses')->where('course_cate_id',$id)->get();
        return $result;
    }
    public function getAdminCourses (){
        $result= $this->getCourse();
        return response()->json($result);
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
                // 'module'=>'required'
                'detail'=>'required',

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
                // 'module.required'=>'Thiếu module khoá học',
                'detail.required'=>'Thiếu chi tiết khoá học',
            ],
        );
        if ($validator->fails()) {
            return response()->json(['check' => false, 'msg' => $validator->errors()]);
        }
        $filename=$_FILES['file']['name'];
        $file_tmp=$_FILES['file']['tmp_name'];
        move_uploaded_file($file_tmp,'images/'.$filename);
        Course::create(['name'=>$request->coursename,'summary'=>$request->summary,'image'=>$filename,
        'discount'=>$request->discount,'course_cate_id'=>$request->course_cate_id,
        'Grade'=>$request->grade,'detail'=>$request->detail]);
        $result = $this->getCourse($request->course_cate_id);
        return  response()->json(['check'=>true,'result'=>$result]);
    
    }
    public function switchCourse (Request $request){
        $validator =  Validator::make(
            $request->all(),
            [
                'id'=>'required|exists:courses,id',
                'status'=>'required|numeric|min:0|max:1',
            ],
            [
                'id.required'=>'Thiếu mã khoá học',
                'id.exists'=>'Mã khoá học không tồn tại',
                'status.required'=>'Thiếu trạng thái khoá học',
                'status.numeric'=>'Trạng thái khoá học không hợp lệ',
                'status.max'=>'Trạng thái khoá học không hợp lệ',
                'status.max'=>'Trạng thái khoá học không hợp lệ',
            ],
        );
        if ($validator->fails()) {
            return response()->json(['check' => false, 'msg' => $validator->errors()]);
        }
        Course::where('id',$request->id)->update(['status'=>$request->status,'updated_at'=>now()]);
        $idCate=  Course::where('id',$request->id)->value('course_cate_id');
        $result = $this->getCourse($idCate);
        return  response()->json(['check'=>true,'result'=>$result, 'msg'=>'Thêm khoá học thành công']);
    }
    public function editcourse(Request $request)
    {
        $validator =  Validator::make(
            $request->all(),
            [
                'id'=>'required|exists:courses,id',
                'coursename' => 'required',
                'summary'=>'required',
                'grade'=>'required',
                'idCate'=>'required|exists:course_cates,id',
                // 'module'=>'required',
                'detail'=>'required',
            ],
            [
                'id.required'=>'Thiếu mã khoá học',
                'id.exists'=>'Mã khoá học không tồn tại',
                'coursename.required' => 'Thiếu tên khoá học',
                'coursename.unique' => 'Tên khoá học bị trùng',
                'summary.required' => 'Thiếu tóm tắt nội dung khoá học',
                'grade.required' => 'Thiếu khối lớp của khoá học',
                'idCate.required' => 'Thiếu mã loại hình lớp',
                'idCate.exists' => 'Mã loại hình lớp không tồn tại',
                // 'module.required'=>'Thiếu module khoá học',
                'detail.required'=>'Thiệu chi tiết khoá học',
            ],
        );
        if ($validator->fails()) {
            return response()->json(['check' => false, 'msg' => $validator->errors()]);
        }
        Course::where('id',$request->id)->update(['name'=>$request->coursename,'summary'=>$request->summary,
        'discount'=>$request->discount,'course_cate_id'=>$request->idCate,
        'Grade'=>$request->grade,'detail'=>$request->detail]);
        $idCate=  Course::where('id',$request->id)->value('course_cate_id');
        $result = $this->getCourse($idCate);
        return  response()->json(['check'=>true,'result'=>$result, 'msg'=>'Cap nhap khoa hoc thanh cong']);
    }
    public function editFileCourse(Request $request)
    {
        $validator =  Validator::make(
            $request->all(),
            [
                'id'=>'required|exists:courses,id',
                'coursename' => 'required',
                'summary'=>'required',
                'grade'=>'required',
                'idCate'=>'required|exists:course_cates,id',
                // 'module'=>'required',
                'detail'=>'required',
                'file'=>'required|mimes:gif,jpeg,png,webp,jpg,JPG,jfif,GIF,JPEG,PNG,WEBP',
            ],
            [
                'id.required'=>'Thiếu mã khoá học',
                'id.exists'=>'Mã khoá học không tồn tại',
                'coursename.required' => 'Thiếu tên khoá học',
                'coursename.unique' => 'Tên khoá học bị trùng',
                'summary.required' => 'Thiếu tóm tắt nội dung khoá học',
                'grade.required' => 'Thiếu khối lớp của khoá học',
                'idCate.required' => 'Thiếu mã loại hình lớp',
                'idCate.exists' => 'Mã loại hình lớp không tồn tại',
                'file.required' => 'Thiếu hình ảnh khoá học',
                // 'module.required'=>'Thiếu module khoá học',
                'detail.required'=>'Thiếu module khoá học',
                'file.required' => 'Thiếu hình ảnh khoá học',
                'file.mimes' => 'Hình ảnh khoá học không hợp lệ',

            ],
        );
        if ($validator->fails()) {
            return response()->json(['check' => false, 'msg' => $validator->errors()]);
        }
        $filenameold=Course::where('id',$request->id)->value('image');
        $check = Course::where('image',$filenameold)->where('id','!=',$request->id)->count('id');
        $filename=$_FILES['file']['name'];
        $file_tmp=$_FILES['file']['tmp_name'];
        if($check==0){
            File::delete(public_path("images/".$filenameold));
        }else{
            $temp = explode(".", $_FILES['file']['name']);
            $filename = $_FILES['file']['name'].random_int(1,9). '.' . end($temp);
        }
        move_uploaded_file($file_tmp,'images/'.$filename);
        Course::where('id',$request->id)->update(['name'=>$request->coursename,
        'summary'=>$request->summary,'image'=>$filename,
        'discount'=>$request->discount,'course_cate_id'=>$request->idCate,
        'Grade'=>$request->grade,'detail'=>$request->detail]);
        $result = $this->getCourse($request->idCate);
        return  response()->json(['check'=>true,'result'=>$result, 'msg'=>'Cap nhap hinh anh thanh cong 1']);
    }
    public function singleCourse($id){
        $result = Course::where('id',$id)->first();
        return response()->json($result);
    }
    /**
     * Store a newly created resource in storage.
     */
    public function singleCourse1($id)
    {
        $result = Course::where('id',$id)->first();
        $duration =Duration::where('course_id',$id)->get();
        return response()->json(['course'=>$result,'duration'=>$duration]);
    }
    // public function activeCate(){
    //     $result = CourseCateM::where('status',1)->select('id','name')->get();
    //     return response()->json($result);
    // }
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
