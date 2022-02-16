@extends('layouts.app')

@section('head')
<title>Modifica scheda oraria</title>
@endsection

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-4">
            <h1>Modifica scheda oraria</h1>
            <h4>di {{ $timesheet->user->name }} {{ $timesheet->user->surname }} su {{ $timesheet->project->name }}</h4>

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ URL::action('TimesheetController@update', $timesheet->id) }}" method="POST">
                {{ csrf_field() }}
                {{ method_field('PATCH') }}

                <div class="form-group">
                    <label for="date">Date*</label>
                    <input class="form-control" type="date" name="date" value="{{ $timesheet->date }}" />
                </div>
                <div class="form-group">
                    <label for="time_spent">Tempo speso*</label>
                    <input class="form-control" type="number" name="time_spent" min ="1" max="12" step="1" value="{{ $timesheet->time_spent }}" />
                </div>
                <div class="form-group">
                    <label for="notes">Note</label>
                    <input class="form-control" type="text" name="notes" maxlength="255" value="{{ $timesheet->notes }}" />
                </div>
                <input type="hidden" name="project_id" value="{{ $timesheet->project_id }}"/>
                <input type="hidden" name="user_id" value="{{ $timesheet->user_id }}"/>

                <h6><i>*Campi obbligatori</i></h6>
                <input class="btn btn-primary" type="submit" value="Aggiorna">
            </form>
        </div>
    </div>
@endsection
