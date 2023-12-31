<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Project;
use App\Models\Company;

class HomepageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \App\Models\lain  $lain
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::check()) {
            return redirect('/projects');
        }

        return view('pages.homepage');
    }

    public function showFaqPage(){
        if (Auth::check()){
            return redirect('/projects');
        }
        return view('pages.faq');
    }
    public function showAboutUsPage(){
        if (Auth::check()){
            return redirect('/projects');
        }
        return view('pages.about_us');
    }
   
}