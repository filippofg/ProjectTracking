<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Validator;
use App\WorkingOn;
use App\Project;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class WorkingOnController extends Controller
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

        $links = WorkingOn::all();
        $users = User::all();
        $projects = Project::all();

        return view('working_on.index', compact('links', 'users', 'projects'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $users = User::all();
        $projects = Project::where('terminated_at', NULL)->get();

        return view('working_on.create', compact('users', 'projects'));
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
            'user_id'                => 'required|exists:users,id',
            'project_id'                => 'required|exists:projects,id',

            'user_id'                =>  Rule::unique('working_on', 'user_id')->where('project_id', $request->project_id)
        ]);

        if($validator->fails()) {
            return redirect("user/{$request->user_id}")
            ->withErrors($validator)
            ->withInput();
        }

        if(!Project::where('id', $request->project_id)->where('terminated_at', NULL)->count() > 0) {
            return redirect("user/{$request->user_id}")
            ->withErrors('The selected project is terminated')
            ->withInput();
        }

        WorkingOn::create($input);
        return redirect("user/{$request->user_id}");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\WorkingOn  $workingOn
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $link = WorkingOn::find($id);
        $users = User::all();
        $projects = Project::all();

        if(!$link) {
            return redirect('/working_on');
        }

        return view('working_on.show', compact('link', 'users', 'projects'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\WorkingOn  $workingOn
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        abort_unless(Auth::user()->is_admin, 403, 'Utente non autorizzato');

        $link = WorkingOn::find($id);
        $users = User::all();
        $projects = Project::where('terminated_at', '')->get();

        return view('working_on.edit', compact('link', 'users', 'projects'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\WorkingOn  $workingOn
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'user_id'                => 'required|exists:users,id',
            'project_id'                => 'required|exists:projects,id',
        ]);

        if($validator->fails()) {
            return redirect('working_on/create')
            ->withErrors($validator)
            ->withInput();
        }


        $link = WorkingOn::find($id);
        if(!$link) {
            return redirect('/working_on');
        }

        $link->update($input);

        return redirect("/working_on/{$id}");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\WorkingOn  $workingOn
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $link = WorkingOn::find($id);

        if(!$link) {
            return redirect('/working_on');
        }

        $user = User::find($link->user_id);
        $link->delete();

        return redirect("/user/{$user->id}");
        // return json_encode(['message' => 'ok']);
    }
}
