<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Trainer;
use App\Models\Course;
use App\Models\ClassroomCourse;
use App\Models\ClassroomTrainer;
use Validator;
use Response;
use Image;
use Carbon\Carbon;

use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Storage;
class TrainerController extends Controller
{

    public function addTrainer(Request $request)
    {
        $image = $request->file('image');
        $signature = $request->file('signature');
        $name_gen=hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
        $name_gen1=hexdec(uniqid()).'.'.$signature->getClientOriginalExtension();
        Image::make($image)->resize(166,110)->save('uploads/trainer/'.$name_gen);
        Image::make($signature)->resize(166,110)->save('uploads/trainer/'.$name_gen1);
        $save_url = 'uploads/trainer/'.$name_gen;
        $save_url1 = 'uploads/trainer/'.$name_gen1;

        Trainer::insert([

            'name' => $request->name,
            'course_id' => $request->course_id,
            'designation' => $request->designation,
            'facebook_profile' => $request->facebook_profile,
            'linkdin_profile' => $request->linkdin_profile,
            'biography' => $request->biography,
            'image' => $save_url,
            'signature' => $save_url1,
            'created_at' => Carbon::now(),
        ]);

        $notification=array(
            'message'=>'Trainer Upload Success',
            'alert-type'=>'success'
        );
        return Redirect()->back()->with($notification);

    }
    public function create()
    {
        $trainer= Trainer::all();
        $course=Course::all();
        return view('backend.pages.trainer.create',compact('trainer','course'));
    }
    public function updateTrainer(Request $request)
    {


        $trainer_id = $request->id;
        $old_img = $request->old_image;
        $old_img1 = $request->old_image1;

        if ($request->file('image') || $request->file('signature')) {
            unlink($old_img);
            unlink($old_img1);
             $image = $request->file('image');
             $image1 = $request->file('signature');
             $name_gen=hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
             $name_gen1=hexdec(uniqid()).'.'.$image1->getClientOriginalExtension();
             Image::make($image)->resize(166,110)->save('uploads/trainer/'.$name_gen);
             Image::make($image1)->resize(166,110)->save('uploads/trainer/'.$name_gen1);
             $save_url = 'uploads/trainer/'.$name_gen;
             $save_url1 = 'uploads/trainer/'.$name_gen1;

             Trainer::findOrFail($trainer_id)->update([
                'name' => $request->name,
                'course_id' => $request->course_id,
                'designation' => $request->designation,
                'facebook_profile' => $request->facebook_profile,
                'linkdin_profile' => $request->linkdin_profile,
                'biography' => $request->biography,
                'image' => $save_url,
                'signature' => $save_url1,
                 'updated_at' => Carbon::now(),
             ]);

             $notification=array(
                 'message'=>'Trainer Success',
                 'alert-type'=>'success'
             );
             return Redirect()->back()->with($notification);
        }else {
         Trainer::findOrFail($trainer_id)->update([
            'name' => $request->name,
            'course_id' => $request->course_id,
            'designation' => $request->designation,
            'facebook_profile' => $request->facebook_profile,
            'linkdin_profile' => $request->linkdin_profile,
            'biography' => $request->biography,
             'updated_at' => Carbon::now(),
         ]);

         $notification=array(
             'message'=>'Trainer Update Success',
             'alert-type'=>'success'
         );
         return Redirect()->back()->with($notification);
        }

    }


    public function deleteTrainer($trainer_id){

        $trainer = Trainer::findOrFail($trainer_id);
        $img = $trainer->image;
        $img1 = $trainer->signature;
        unlink($img);
        unlink($img1);
        Trainer::findOrFail($trainer_id)->delete();
        $notification=array(
         'message'=>'Brand Delete Success',
         'alert-type'=>'success'
     );
     return Redirect()->back()->with($notification);
    }

  //classroom
 public function addTrainer1(Request $request)
   {

       $name = $request->name;
       $designation = $request->designation;
       $classroom_course_id=$request->classroom_course_id;

       $facebook_profile = $request->facebook_profile;
       $linkdin_profile = $request->linkdin_profile;
       $biography = $request->biography;
       $image =$request->file('file');
       $filename=null;
       if ($image) {
           $filename = time() . $image->getClientOriginalName();

           Storage::disk('public')->putFileAs(
               'trainer/',
               $image,
               $filename
           );
         }

       $trainer = new ClassroomTrainer();
       $trainer->name = $name;
       $trainer->designation =$designation;
       $trainer->classroom_course_id=$classroom_course_id;
       $trainer->facebook_profile = $facebook_profile;
       $trainer->linkdin_profile =$linkdin_profile;
       $trainer->biography = $biography;
       $trainer->image= $filename;
       $trainer->save();

       $notification=array(
           'message'=>'Trainer added successfully!!!',
           'alert-type'=>'success'
       );
       return Redirect()->back()->with($notification);
   }
   public function create1()
   {

       $trainer= ClassroomTrainer::all();
       $classroom_course=ClassroomCourse::all();
       return view('backend.pages.trainer.classroom-create',compact('trainer','classroom_course'));
   }
   public function updateTrainer1(Request $request)
   {
       $name = $request->name;
       $classroom_course_id=$request->classroom_course_id;
       $designation = $request->designation;
       $facebook_profile = $request->facebook_profile;
       $linkdin_profile = $request->linkdin_profile;
       $biography = $request->biography;
       $filename=null;
       $uploadedFile = $request->file('image');
       $oldfilename = $trainer['image'] ?? 'demo.jpg';

       $oldfileexists = Storage::disk('public')->exists('trainer/' . $oldfilename);

       if ($uploadedFile !== null) {

           if ($oldfileexists && $oldfilename != $uploadedFile) {
               //Delete old file
               Storage::disk('public')->delete('trainer/' . $oldfilename);
           }
           $filename_modified = str_replace(' ', '_', $uploadedFile->getClientOriginalName());
           $filename = time() . '_' . $filename_modified;

           Storage::disk('public')->putFileAs(
               'trainer/',
               $uploadedFile,
               $filename
           );

           $trainer['image'] = $filename;
       } elseif (empty($oldfileexists)) {
           //throw new GeneralException('Trainer image not found!');
           //return redirect()->back()->with(['flash_danger' => 'User image not found!']);
           //file check in storage

       }



       $trainer = ClassroomTrainer::find($request->id);
       $trainer->name = $name;
       $trainer->classroom_course_id=$classroom_course_id;
       $trainer->designation =$designation;
       $trainer->facebook_profile = $facebook_profile;
       $trainer->linkdin_profile =$linkdin_profile;
       $trainer->biography = $biography;
       $trainer->image= $filename;
       $trainer->save();

       $notification=array(
           'message'=>'Trainer Updated successfully!!!',
           'alert-type'=>'success'
       );
       return Redirect()->back()->with($notification);
   }


   public function deleteTrainer1($id){

       $trainer = ClassroomTrainer::find($id);

       $trainer->delete();

       $notification=array(
           'message'=>'Trainer Deleted successfully!!!',
           'alert-type'=>'success'
       );
       return Redirect()->back()->with($notification);
 }

}
