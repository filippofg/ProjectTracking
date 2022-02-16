<?php

namespace App\Http\Controllers;

use Validator;
use App\Customer;
use App\Timesheet;
use App\Project;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class TimesheetController extends Controller
{
	/* Costruttore del controller:
     * viene specificato qui il middleware
     * per l'autenticazione, anziché
     * specificarlo nelle routes.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
        abort_unless(Auth::user()->is_admin, 403, 'Utente non autorizzato');

		$projects = Project::all();
		$users = User::all();
		$timesheets = Timesheet::all();

		return view('timesheet.index', compact('projects', 'users', 'timesheets'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		$projects = Project::all();
		$users = User::all();

		return view('timesheet.create', compact('projects', 'users'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request)
	{
		$input = $request->all();
        $input['user_id'] = Auth::user()->id;
		$validator = Validator::make($input, [
			'date'          => 'required',
			'time_spent'    => 'required|integer|min:1|max:12',
			'notes'         => 'max:255',
			'user_id'       => 'required|exists:users,id',
            'project_id'    => 'required|exists:projects,id',

			'user_id'       => [
				'required',
				Rule::exists('working_on')->where(function ($query) use ($request) {
					$query->where('project_id', $request->project_id);
				})
            ]
		]);

		if($validator->fails()) {
			return redirect('/')
			->withErrors($validator)
			->withInput();
        }

        Timesheet::create($input);
        return json_encode(['message' => 'ok']);
        //return redirect('/');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  \App\Timesheet  $timesheet
	 * @return \Illuminate\Http\Response
	 */
	public function show($id)
	{
		$projects = Project::all();
		$users = User::all();
		$timesheet = Timesheet::find($id);

		if(!$timesheet) {
			return redirect('/timesheet');
		}

		return view('timesheet.show', compact('projects', 'users', 'timesheet'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  \App\Timesheet  $timesheet
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id)
	{
		$projects = Project::all();
		$users = User::all();
		$timesheet = Timesheet::find($id);

		if(!$timesheet) {
			return view('/');
		}

		return view('timesheet.edit', compact('projects', 'users', 'timesheet'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \App\Timesheet  $timesheet
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, $id)
	{
		$input = $request->all();
		$validator = Validator::make($input, [
			'date'          => 'required',
			'time_spent'    => 'required|min:1|max:12',
			'notes'         => 'max:255',
			'user_id'       => 'required|exists:users,id|exists:timesheets,user_id',
			'project_id'    => 'required|exists:projects,id|exists:timesheets,project_id',
		]);

		if($validator->fails()) {
			return redirect("timesheet/{$id}/edit")
			->withErrors($validator)
			->withInput();
		}

		$timesheet = Timesheet::find($id);
		if(!$timesheet) {
			return redirect('/');
		}

		$timesheet->update($input);

		return redirect("timesheet/showWorkOn/{$input['user_id']}/{$input['project_id']}");
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  \App\Timesheet  $timesheet
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id)
	{
		$timesheet = Timesheet::find($id);

		if(!$timesheet) {
			return view('/timesheet');
		}

		$timesheet->delete();

		return json_encode(['message' => 'ok']);
		//return view('/timesheet');
	}

	public function showWorkOn($user_id, $project_id)
	{
        $user = User::find($user_id);
        $project = Project::find($project_id);
		$timesheets = Timesheet::where('user_id', $user_id)->where('project_id', $project_id)->get();

		return view('timesheet.showWorkOn', compact('user', 'project', 'timesheets'));
    }

    public function setProjectsDates(Request $request)
    {
        $input = $request->all();
		$validator = Validator::make($input, [
			'start' => 'required|date',
            'end'   => 'required|date'
		]);

		if($validator->fails()) {
			return redirect("timesheet/projectsReport/".date('Y-m-d')."/".date('Y-m-d'))
			->withErrors($validator)
			->withInput();
        }

        if(date($request->start) > date($request->end)) {
            return redirect("timesheet/projectsReport/".date('Y-m-d')."/".date('Y-m-d'))
			->withErrors('Start date must be greater or equal than End date')
			->withInput();
        }

		return redirect("timesheet/projectsReport/{$request->start}/{$request->end}");
    }
    public function projectsReport($start, $end)
    {
        $customers = Customer::all();
        $data = Timesheet::where('date', '>=', $start)->where('date', '<=', $end)->get();
        $projects = Project::all();

        return view('timesheet.projectsReport', compact('data', 'projects', 'customers'));
    }

    public function setCustomersDates(Request $request)
    {
        $input = $request->all();
		$validator = Validator::make($input, [
			'start' => 'required|date',
            'end'   => 'required|date'
		]);

		if($validator->fails()) {
			return redirect("timesheet/customersReport/".date('Y-m-d')."/".date('Y-m-d'))
			->withErrors($validator)
			->withInput();
        }

        if(date($request->start) > date($request->end)) {
            return redirect("timesheet/customersReport/".date('Y-m-d')."/".date('Y-m-d'))
			->withErrors('Start date must be greater or equal than End date')
			->withInput();
        }

		return redirect("timesheet/customersReport/{$request->start}/{$request->end}");
	}

    public function customersReport($start, $end)
    {
        $customers = Customer::all();
        $data = Timesheet::where('date', '>=', $start)
            ->where('date', '<=', $end)
            ->join('projects', 'projects.id', '=', 'timesheets.project_id')
            ->select('timesheets.*', 'projects.customer_vat_number')
            ->get();

            return view('timesheet.customersReport', compact('customers', 'data'));
    }

    public function setRecapMonth(Request $request) {
        $input = $request->all();
		$validator = Validator::make($input, [
			'month' => 'required'
		]);

		if($validator->fails()) {
			return redirect("timesheet/monthlyRecap/".date('m'))
			->withErrors($validator)
			->withInput();
        }

        if(!($request->month >= 1 && $request->month <= 12)) {
            return redirect("timesheet/monthlyRecap/".date('m'))
			->withErrors('Invalid month')
			->withInput();
        }

		return redirect("timesheet/monthlyRecap/{$request->month}");
    }
    public function monthlyRecap($month) {
        if(!($month >= 1 && $month <= 12)) {
            return redirect("/");
        }

        $projects = Project::all();
        $customers = Customer::all();
        $timesheets = Timesheet::where('date', '>=', date('Y').$month.'01')
        ->where('date', '<=', date('Y').$month.cal_days_in_month(CAL_GREGORIAN, $month, date('Y')))
        ->where('user_id', Auth::user()->id)
        ->get();

        return view('timesheet.monthlyRecap', compact('projects', 'customers', 'timesheets'));
    }
}
