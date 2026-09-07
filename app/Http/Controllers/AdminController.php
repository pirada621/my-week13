<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Blog;

class AdminController extends Controller
{
    function __construct(){
        $this->middleware('auth');
    }
    function blogs()
    {
        $blogs = Blog::paginate(10);
        return view('blogs', compact('blogs'));
    }
    function abouts()
    {
        $name = "Pirada";
        $date = "6 กรกฏาคม 2569";
        return view("abouts", compact("name", "date"));
    }
   
    function create()
    {
        return view("form");
    }
    function form()
    {
        return view("form");
    }
    function claim()
    {
        return redirect()->route('form');
    }
    function insert(Request $request)
    {
        $request->validate([
            'title' => 'required|max:50',
            'content' => 'required'
        ],[
            'title.required' => 'กรุณากรอกชื่อบทความ',
            'title.max' => 'ชื่อบทความห้ามเกิน 50 ตัวอักษร',
            'content.required' => 'กรุณากรอกเนื้อหาบทความ'
        ]);
        $data=[
            'title'=>$request->title,
            'content'=>$request->content,
    
        ];
        Blog::insert($data);
return redirect('author/blogs');
    }
    function delete($id){
        Blog::find($id)->delete();
        return redirect()->back();
    }
    function change($id){
        $blogs = Blog::find($id);
        $data = [
            'status'=>$blogs->status
        ];
        if($blogs->status == 0){
            $data = ['status'=>1];
        }else{
            $data = ['status'=>0];
        }
        Blog::find($id)->update($data);
        return redirect()->back();
    }
    function update(Request $request,$id){
        $request->validate([
            'title' => 'required|max:50',
            'content' => 'required'
        ],[
            'title.required' => 'กรุณากรอกชื่อบทความ',
            'title.max' => 'ชื่อบทความห้ามเกิน 50 ตัวอักษร',
            'content.required' => 'กรุณากรอกเนื้อหาบทความ'
        ]);
        $data=[
            'title'=>$request->title,
            'content'=>$request->content,
    
        ];
        Blog::find($id)->update($data);
return redirect('/author/blogs');
    }
    
    function edit($id)
    {
        $blogs = Blog::find($id);
        return view('edit', compact('blogs'));
    }
    
    function claimInsert(Request $request)
    {
        $request->validate([
            'serial_number' => 'required',
            'email' => 'required|email',
            'symptoms' => 'required',
            'urgency' => 'required|in:low,medium,high'
        ],[
            'serial_number.required' => 'กรุณากรอกรหัสสินค้า',
            'email.required' => 'กรุณากรอกอีเมลผู้ติดต่อ',
            'email.email' => 'กรุณากรอกรูปแบบอีเมลที่ถูกต้อง',
            'symptoms.required' => 'กรุณากรอกอาการชำรุด',
            'urgency.required' => 'กรุณาเลือกระดับความเร่งด่วน',
            'urgency.in' => 'ระดับความเร่งด่วนไม่ถูกต้อง'
        ]);
        
        return redirect()->route('claim')->with('success', 'ส่งข้อมูลแจ้งเคลมสินค้าสำเร็จเรียบร้อยแล้ว!');
    }
}