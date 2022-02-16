@extends('layouts.app')

@section('head')
<title>ProjectTracking - link - Create</title>
@endsection

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-4">
            <h1>Inserire i dati del nuovo link</h1>

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ URL::action('WorkingOnController@store') }}" method="POST">
                {{ csrf_field() }}
                <div class="form-group">
                    <label for="user_id">Utente*</label>
                    <select class="form-control" name="user_id">
                        @foreach ($users as $user)
                        <option value="{{ $user->id }}">{{ $user->name }} {{ $user->surname }} ({{ $user->email }})</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="project_id">Progetto*</label>
                    <select class="form-control" name="project_id">
                        @foreach ($projects as $project)
                        <option value="{{ $project->id }}">{{ $project->name }}</option>
                        @endforeach
                    </select>
                </div>

                <h6><i>*Campi obbligatori</i></h6>
                <input class="btn btn-primary" type="submit" value="Crea">
            </form>
        </div>
    </div>
@endsection
