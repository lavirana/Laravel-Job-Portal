<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Job;
use App\Models\JobType;
use Illuminate\Http\Request;

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

}
