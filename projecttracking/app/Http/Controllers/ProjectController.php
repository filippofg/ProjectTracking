<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Validator;
use App\Project;
use App\Customer;
use App\WorkingOn;
use App\User;
use Illuminate\Http\Request;

class ProjectController extends Controller
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

        $customers = Customer::all();
        $projects = Project::all();

        return view('project.index', compact('customers', 'projects'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        abort_unless(Auth::user()->is_admin, 403, 'Utente non autorizzato');

        $customers = Customer::all();

        return view('project.create', compact('customers'));
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

        $validator = Validator::make($input, [
            'name'                  => 'required|max:255',
            'description'           => 'required|max:255',
            'notes'                 => 'max:255',
            'customer_vat_number'   => 'required|digits:11|exists:customers,vat_number',
            'cost_per_hour'         => 'required|numeric|min:0|regex:/^\d+\.(\d{1,2})$/'
        ]);

        if($validator->fails()) {
            return redirect('project/create')
            ->withErrors($validator)
            ->withInput();
        }

        $project = Project::create($input);
        // return redirect('project/');

        $links = WorkingOn::where('working_on.project_id', $project->id)
            ->join('projects', 'projects.id', '=', 'working_on.project_id')
            ->join('users', 'working_on.user_id', '=', 'users.id')
            ->get(['users.id', 'users.name', 'users.surname', 'users.email', 'working_on.created_at']);

        return view('project.show', compact('project', 'links'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $project = Project::find($id);
        $links = WorkingOn::where('working_on.project_id', $id)
            ->join('projects', 'projects.id', '=', 'working_on.project_id')
            ->join('users', 'working_on.user_id', '=', 'users.id')
            ->get(['users.id', 'users.name', 'users.surname', 'users.email', 'working_on.created_at']);
        //$users = User::where('id', $users_id);

        if(!$project) {
            return redirect('/project');
        }

        return view('project.show', compact('project', 'links'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $customers = Customer::all();
        $project = Project::find($id);

        if(!$project) {
            return redirect('/project');
        }

        return view('project.edit', compact('project', 'customers'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'name'                  => 'required|max:255',
            'description'           => 'required|max:255',
            'notes'                 => 'max:255',
            'customer_vat_number'   => 'required|numeric|digits:11|exists:customers,vat_number',
            'cost_per_hour'         => 'required|numeric|min:0|regex:/^\d+\.(\d{1,2})$/'
        ]);

        if($validator->fails()) {
            return redirect("project/{$id}/edit")
            ->withErrors($validator)
            ->withInput();
        }

        $project = Project::find($id);

        if(!$project) {
            return redirect('/project');
        }

        $project->update($input);

        return redirect("/project/{$id}");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $project = Project::find($id);

        if(!$project) {
            return redirect('/project');
        }

        $project->delete();

        return json_encode( ['message' => 'ok']);
        //return redirect('/project');
    }

    public function terminate($id)
    {
        $project = Project::find($id);

        if(!$project) {
            return redirect('/project');
        }

        if(!$project->terminated_at) {
            $project->terminated_at = date('Y-m-d h:i:s');
            $project->save();

            WorkingOn::where('project_id', $project->id)->delete();

            return redirect("/project/{$id}");
        }
    }

    public function search(Request $request) {
        $projects = Project::where('name', 'LIKE', '%'.$request->name.'%')->get();
        $customers = Customer::all();

        return view('project.index', compact('projects', 'customers'));
    }
}
