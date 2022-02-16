@extends('layouts.app')

@section('head')
<title>Nuova scheda oraria</title>
@endsection

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-6">
            <h1>Inserire i dati del nuovo timesheet</h1>

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ URL::action('TimesheetController@store') }}" method="POST">
                {{ csrf_field() }}
                <div class="form-group">
                    <label for="date">Data*</label>
                    <input class="form-control" type="date" name="date" value="{{ date('Y-m-d') }}"/>
                </div>
                <div class="form-group">
                    <label for="time_spent">Tempo speso*</label>
                    <input class="form-control" type="number" name="time_spent" min="1" max="12" step="1" value="1"/>
                </div>
                <div class="form-group">
                    <label for="notes">Note</label>
                    <input class="form-control" type="text" name="notes" maxlength="255"/>
                </div>
                <div class="form-group">
                    <label for="user_id">Utente*</label>
                    <select class="form-control" name="user_id">
                        @foreach ($users as $user)
                    <option value="{{ $user->id }}">{{ $user->name }} {{ $user->surname }}</option>
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
