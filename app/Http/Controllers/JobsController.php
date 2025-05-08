<?php

namespace App\Http\Controllers;

use App\Mail\JobNotificationEmail;
use App\Models\Category;
use App\Models\Job;
use App\Models\JobApplication;
use App\Models\JobType;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class JobsController extends Controller
{
    

    public function index(Request $request){
                $categories = Category::where('status',1)->get();
                $JobTypes = JobType::where('status',1)->get();
                $latestJobs = Job::where('status',1);
                

                        if(!empty($request->keyword)) {
                            $latestJobs = $latestJobs->where(function($query) use($request){
                                $query->orWhere('title', 'like', '%'.$request->keyword.'%');
                                $query->orWhere('keywords', 'like', '%'.$request->keyword.'%');
                            });
                        }

                        if(!empty($request->location)) {
                            $latestJobs = $latestJobs->where('location', $request->location);
                        }

                        if(!empty($request->category)) {
                            $latestJobs = $latestJobs->where('category_id', $request->category);
                        }

                        $jobTypeArray = [];
                        if(!empty($request->jobType)) {
                            $jobTypeArray = explode(',',$request->jobType);
                            $latestJobs = $latestJobs->wherein('job_type_id', $jobTypeArray);
                        }

                        if(!empty($request->experience)) {
                            $latestJobs = $latestJobs->where('experience', $request->experience);
                        }

                        $latestJobs = $latestJobs->with(['jobType','category']);

                        if($request->sort == '0'){
                            $latestJobs = $latestJobs->orderBy('created_at','ASC');
                        }else{
                            $latestJobs = $latestJobs->orderBy('created_at','DESC');    
                        }
                       
                            $latestJobs = $latestJobs->paginate(9);

                            return view('front.jobs',[
                                'categories' => $categories,
                                'JobTypes' => $JobTypes,
                                'latestJobs' => $latestJobs,
                                'jobTypeArray' => $jobTypeArray
                            ]);
    }

                                    public function detail($id){
                                        $job = Job::where([
                                            'id' => $id,
                                            'status' => 1
                                        ])->with(['jobType','category'])->first();
                                        if($job == null){
                                            abort(404);
                                        }
                                        return view('front.jobDetail',['job' => $job]);
                                          }


                                          public function applyJob(Request $request){

                                            $id = $request->id;
                                            $job = Job::where('id', $id)->first();
                                            $employer_id = $job->user_id;
                                            
                                            if($job == null){
                                            session()->flash('error','Job does not exist');
                                            return response()->json([
                                                'status' => false,
                                                'message' => 'Job does not exist'
                                            ]);
                                        }

                                       
                                        if($employer_id == Auth::user()->id){
                                            session()->flash('error','You cannot apply on your own Job');
                                            return response()->json([
                                                'status' => false,
                                                'message' => 'You cannot apply on your own Job'
                                            ]);
                                        }

                                        //you can not apply on a job twise//
                                        $jobApplicationCount = JobApplication::where([
                                            'user_id' => Auth::user()->id,
                                            'job_id' => $id
                                        ])->count();

                                        if($jobApplicationCount > 0){
                                            session()->flash('error','You already applied on this job.');
                                            return response()->json([
                                                'status' => false,
                                                'message' => 'You already applied on this job.'
                                            ]);
                                        }

                                        $application = new JobApplication();
                                        $application->job_id = $id;
                                        $application->user_id = Auth::user()->id;
                                        $application->employer_id = $employer_id;
                                        $application->applied_date = now();
                                        $application->save();



                                        //send email notification to Employer
                                        $employer = User::where('id',$employer_id)->first();
                                        $mailData = [
                                            'employer' => $employer,
                                            'user' => Auth::user(),
                                            'job' => $job,
                                        ];
                                        Mail::to($employer->email)->send(new JobNotificationEmail($mailData));


                                        $message = 'You have successfully Applied.';
                                        session()->flash('success',$message);
                                        
                                        return response()->json([
                                            'status' => true,
                                            'message' => $message
                                        ]);

                                          }

}
