@extends('layouts.app')

@section('head')
<title>ProjectTracking - link - {{ $link->user->name }} {{ $link->user->surname }} - {{ $link->project->name }}</title>
@endsection

@section('content')
	<div class="row">
		<div class="col-md-12">
            <h1>Link: {{ $link->user->name }} {{ $link->user->surname }} - {{ $link->project->name }}</h1>
            <b>Utente:</b>
            {{-- <a href="{{  URL::action('UserController@show', $link->user_email) }}"> --}}
                <a href="#">
                {{ $link->user->name }} {{ $link->user->surname }}
            </a><br>
            <b>Lavora su: </b>
            <a href="{{  URL::action('ProjectController@show', $link->project_id) }}">
                {{ $link->project->name }}
            </a><br>
            @if($link->created_at)
                <b>Creato il:</b> {{ $link->created_at }}<br>
            @endif
            @if($link->updated_at)
                <b>Aggiornato il:</b> {{ $link->updated_at }}<br>
            @endif
		</div>
	</div>

	<div class="row">
		<div class="col-md-12">
            <a class="btn btn-secondary" href="{{  URL::action('WorkingOnController@edit', $link->id) }}" >Modifica</a>
            <a class="btn btn-danger" href="{{ URL::action('WorkingOnController@destroy', $link->id) }}" >Elimina</a><br>
            <a class="btn btn-success" href="{{ URL::action('WorkingOnController@index') }}" >Torna alla lista</a>

		</div>
	</div>
@endsection
