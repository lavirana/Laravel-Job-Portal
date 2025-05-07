<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Job;
use App\Models\JobType;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(){

        $categories = Category::where('status',1)->orderBy('name','ASC')->take(8)->get();
    $featuredJobs = Job::where('status',1)->orderBy('created_at','DESC')->with('JobType')->where('isFeatured', 1)->take(6)->get();

    $latestJobs = Job::where('status',1)->orderBy('created_at','DESC')->with('jobType')->take(6)->get();

        return view('front.home',[
          'categories' => $categories,
         'featuredJobs' => $featuredJobs,
          'latestJobs' => $latestJobs]);
    }

    public function contact(){
        return view('front.contact ');
    }
}
