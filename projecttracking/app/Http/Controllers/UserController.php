<?php

namespace App\Http\Controllers;

use App\User;
use App\Project;
use App\WorkingOn;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Validator;
use Hash;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class UserController extends Controller
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

        $users = User::all();

        return view('user.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        abort_unless(Auth::user()->is_admin, 403, 'Utente non autorizzato');

        return view('user.create');
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
            'email'             => 'email|confirmed|unique:users,email|max:255',
            'name'              => 'max:255',
            'surname'           => 'max:255'
        ]);

        if($validator->fails()) {
            return redirect('/user/create')
                ->withErrors($validator)
                ->withInput();
        }

        $pw = Hash::make(Carbon::now()->getTimestamp());
        $pw = substr($pw, -8, 8);

        $input['password'] = Hash::make($pw);

        Mail::raw("Benvenuto " .$input['name']
            .", puoi effettuare il login al sito con la seguente password: " .$pw,
            function ($message) use ($input) {
                $message->to($input['email'])
                    ->subject('Registrazione ProjectTracking');
        });

        $user = User::create($input);

        $work = WorkingOn::where('user_id', $user->id)->select('project_id');
        $projects = Project::whereNotIn('id', $work)->get();
        $actives = Project::join('working_on', 'projects.id', '=', 'working_on.project_id')
        ->select('projects.*', 'working_on.id as working_on_id', 'working_on.user_id as user_id')
        ->where('user_id', $user->id)
        ->get();

        return view('user.show', compact('user', 'projects', 'actives'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        abort_unless(Auth::user()->is_admin, 403, 'Utente non autorizzato');

        $user = User::find($id);
        $work = WorkingOn::where('user_id', $id)->select('project_id');
        $projects = Project::whereNotIn('id', $work)->where('terminated_at', NULL)->get();//->where('terminated_at', NULL)
        $actives = Project::join('working_on', 'projects.id', '=', 'working_on.project_id')
        ->select('projects.*', 'working_on.id as working_on_id', 'working_on.user_id as user_id')
        ->where('user_id', $id)
        ->get();

        return view('user.show', compact('user', 'projects', 'actives'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        abort_unless(Auth::user()->is_admin, 403, 'Utente non autorizzato');

        $user = User::find($id);

        return view('user.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
           'email'      => 'email|max:255',
           'name'       => 'max:255',
           'surname'    => 'max:255'
        ]);

        if($validator->fails()) {
            return redirect("user/{$id}/edit")
                ->withErrors($validator)
                ->withInput();
        }

        $user = User::find($id);

        if(!$user)
            return redirect('/user');

        $user->update($input);

        return redirect('/user');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::find($id)->delete();

        return json_encode( ['message' => 'ok']);

        //return redirect('/user');
    }
    public function setAdmin($id) {
        $user = User::find($id);
        if($user) {
            $user->is_admin = 1;
            $user->save();
        }

        // return redirect("/user/{$id}");
        return json_encode( ['message' => 'ok']);
    }
    public function removeAdmin($id) {
        $user = User::find($id);
        if($user) {
            $user->is_admin = 0;
            $user->save();
        }

        // return redirect("/user/{$id}");
        return json_encode( ['message' => 'ok']);
    }

    public function search(Request $request) {
        $users = User::where('name', 'LIKE', '%'.$request->name.'%')->where('surname', 'LIKE', '%'.$request->surname.'%')->get();

        return view('user.index', compact('users'));
    }
}
