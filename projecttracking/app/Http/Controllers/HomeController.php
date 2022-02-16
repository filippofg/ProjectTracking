<?php

namespace App\Http\Controllers;

use App\Project;
use App\Timesheet;
use App\WorkingOn;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $projects = Project::all();
        $links = WorkingOn::where('user_id', Auth::user()->id)->get();
        $timesheets = Timesheet::where('user_id', Auth::user()->id)
        ->where('date', '>=', date('Y-m-').'01')
        ->where('date', '<=', date('Y-m-').cal_days_in_month(CAL_GREGORIAN, date('m'), date('Y')))
        ->get();
        return view('home', compact('projects', 'timesheets', 'links'));
    }
}
