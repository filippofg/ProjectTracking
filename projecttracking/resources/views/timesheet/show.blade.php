@extends('layouts.app')

@section('head')
<title>Dettagli scheda oraria</title>
@endsection

@section('content')
	<div class="row">
		<div class="col-md-12">
            <h1>Data: {{ $timesheet->date }}</h1>
            <h3>
                <a href="#">
                    {{ $timesheet->user->name }} {{ $timesheet->user->surname }}
                </a>
                ha lavorato su<br>
                <a href="#">
                    {{ $timesheet->project->name }}
                </a><br>
                Per {{ $timesheet->time_spent }}
                @if($timesheet->time_spent == 1)
                    ora.
                @else
                    ore.
                @endif
            </h3>
		</div>
	</div>

	<div class="row">
		<div class="col-md-12">
            <a class="btn btn-secondary" href="{{  URL::action('TimesheetController@edit', $timesheet->id) }}" >Modifica</a>
            <a class="btn btn-danger" href="{{ URL::action('TimesheetController@destroy', $timesheet->id) }}" >Elimina</a><br>
            <a class="btn btn-success" href="{{ URL::action('TimesheetController@index') }}" >Torna alla lista</a>

		</div>
	</div>
@endsection
