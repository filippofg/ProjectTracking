@extends('layouts.app')

@section('head')
<title>ProjectTracking - Project - {{ $link->user->name }} {{ $link->user->surname }} - {{ $link->project->name }} - edit</title>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-6">
            <h1>Modifica il link {{ $link->user->name }} {{ $link->user->surname }} - {{ $link->project->name }}</h1>

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ URL::action('WorkingOnController@update', $link->id) }}" method="POST">
                {{ csrf_field() }}
                {{ method_field('PATCH') }}

                <div class="form-group">
                    <label for="user_id">Utente*</label>
                    <select class="form-control" name="user_id">
                        @foreach ($users as $user)
                        <option value="{{ $user->id }}" {{ ($user->id == $link->user_id) ? 'selected' : '' }}>{{ $user->name }} {{ $user->surname }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="project_id">Progetto*</label>
                    <select class="form-control" name="project_id">
                        @foreach ($projects as $project)
                        <option value="{{ $project->id }}" {{ ($project->id == $link->project_id) ? 'selected' : '' }}>{{ $project->name }}</option>
                        @endforeach
                    </select>
                </div>

                <h6><i>*Campi obbligatori</i></h6>
                <input class="btn btn-primary" type="submit" value="Aggiorna">
            </form>
        </div>
    </div>
@endsection
