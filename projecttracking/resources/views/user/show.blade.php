@extends('layouts.app')

@section('head')
<title>Dettagli utente</title>
@endsection

@section('content')
<div class="d-flex justify-content-between bd-highlight mb-3">
    <div class="p-2 bd-highlight col-md-3">
        <h1>{{ $user->name }} {{ $user->surname }}</h1>
        <h5><em>{{ $user->email }}</em></h5>
        <h4>
            Ruolo:
            <strong>
                @if($user->is_admin)
                    <span id="role">Amministratore</span>
                @else
                    <span id="role">Utente Standard</span>
                @endif
            </strong>
        </h4>
        <h5>
            <table class="borderless-table">
                <tr>
                    <td>Registrato il:</td>
                    <td class="dates">{{ subStr($user->created_at, 0, 10) }}</td>
                </tr>
                @if ($user->updated_at != $user->created_at && $user->updated_at)
                    <tr>
                        <td>Aggiornato il:</td>
                        <td class="dates">{{ $user->updated_at }}</td>
                    </tr>
                @endif
            </table>
        </h5>
        <a class="btn btn-secondary" href="{{  URL::action('UserController@edit', $user->id) }}" >Modifica</a>
        @if ($user->id != Auth::user()->id)
            @if($user->is_admin)
                <a id="remove" class="btn btn-danger" href="{{ URL::action('UserController@removeAdmin', $user->id) }}" data-id="{{ $user->id }}">Rimuovi Admin</a>
            @else
                <a id="add" class="btn btn-success" href="{{ URL::action('UserController@setAdmin', $user->id) }}" data-id="{{ $user->id }}">Rendi Admin</a>
            @endif
        @endif

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

    </div>
    <div class="p-2 bd-highlight col-md-4">
        <div class="card">
            <div class="card-header text-center">Assegna ad un progetto</div>
            <div class="card-body">
                @if($projects->count() > 0)
                    <form action="{{ URL::action('WorkingOnController@store') }}" method="POST">
                        {{ csrf_field() }}
                        <input type="hidden" name="user_id" value="{{ $user->id }}">
                        <div class="form-group">
                            <label for="project_id">Progetto</label>
                            <select class="form-control" name="project_id">
                                @foreach ($projects as $project)
                                    <option value="{{ $project->id }}">{{ $project->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <input class="btn btn-primary" type="submit" value="Assegna">
                    </form>
                @else
                    <em>Questo utente non può essere assegnato ad altri progetti al momento.</em>
                @endif
            </div>
        </div>
    </div>
    <div class="p-2 bd-highlight col-md-4">
        <div class="card">
            <div class="card-header text-center">Progetti attivi</div>
            <div class="card-body">
                @if($actives->count() > 0)
                        @foreach ($actives as $project)
                            <div class="d-flex justify-content-between bd-highlight mb-12 project-card">
                                <div class="p-2 bd-highlight col-md-5">
                                    <a class="project-name" href="{{ URL::action('ProjectController@show', $project->id) }}">{{ $project->name }}</a>
                                </div>
                                @if (Auth::user()->is_admin)
                                    <div class="p-2 bd-highlight col-md-5">
                                        <a class="btn btn-sm btn-danger" href="{{ URL::action('WorkingOnController@destroy', $project->working_on_id) }}" data-id="{{ $project->working_on_id }}">Rimuovi dagli attivi</a>
                                    </div>
                                @endif
                            </div>
                        @endforeach
                @else
                    <em>Non sono presenti progetti attivi al momento.</em>
                @endif
            </div>
        </div>

        @if (session('status'))
            <div class="card">
                <div class="card-body">
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
<script>
    $('document').ready(function(){
        $('#add').bind('click', function(event) {
            event.preventDefault();
            var button = $(this);
            var id = $(button).attr('data-id');

            $.ajax({
                url: "/user/"+id+"/setAdmin",
                type: "GET",
                dataType: "json",
                success: function(data) {
                    console.log(data);
                    $(button).fadeOut();
                    $('#role').text('Utente Standard');
                },
                error: function(response, stato) {
                    console.log(stato);
                }
            });
        });

        $('#remove').bind('click', function(event) {
            event.preventDefault();
            var button = $(this);
            var id = $(button).attr('data-id');

            $.ajax({
                url: "/user/"+id+"/removeAdmin",
                type: "GET",
                dataType: "json",
                success: function(data) {
                    console.log(data);
                    $(button).fadeOut();
                    $('#role').text('Amministratore');
                },
                error: function(response, stato) {
                    console.log(stato);
                }
            });
        });
    });
</script>
@endsection
