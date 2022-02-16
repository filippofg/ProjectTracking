@extends('layouts.app')

@section('head')
    <title>{{ $exception->getStatusCode() }} - ProjectTracking</title>
@endsection

@section('content')
    <div class="text-center">
        <h2>{{ $exception->getMessage() }}</h2>
        <h5>Torna alla <a href="{{ URL::action('HomeController@index') }}">home</a></h5>
    </div>
@endsection
