@extends('layouts.app')

@section('head')
<title>ProjectTracking - Utenti</title>
@endsection

@section('content')
<h1>Lista utenti</h1>
<form class="form-inline" action="{{ URL::action('UserController@search') }}" method="POST">
    {{ csrf_field() }}
    <div class="form-group">
        <input class="form-control" type="text" name="name" placeholder="Nome" maxlength="255">
        <input class="form-control" type="text" name="surname" placeholder="Cognome" maxlength="255">
    </div>

    <input class="btn btn-secondary" type="submit" value="Cerca">
</form>
<a class="btn btn-primary float-md-right" href="{{ URL::action('UserController@create') }}" >Registrazione utente</a>
<br>
<div class="table-body row">
    <div class="col-md-12">
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">Nome e Cognome</th>
                    <th scope="col">E-mail</th>
                    <th scope="col">Ruolo</th>

                    <th scope="col">Azioni</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                <tr>
                    <td>{{ $user->name }} {{ $user->surname }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->is_admin ? 'Amministratore' : 'Utente standard' }}</td>
                    <td>
                        <a href="{{ URL::action('UserController@show', $user->id) }}" class="btn btn-primary btn-sm">Dettagli</a>
                        @if(Auth::user()->id != $user->id)
                            <a href="{{ URL::action('UserController@destroy', $user->id) }}" class="btn btn-danger btn-delete btn-sm" data-id="{{ $user->id }}">Elimina</a>
                        @endif
                        @if(!$user->is_admin)
                            <a href="{{ URL::action('UserController@setAdmin', $user->id) }}" class="btn btn-success btn-sm" data-id="{{ $user->id }}">Rendi Admin</a>
                        @else
                            @if(Auth::user()->id != $user->id)
                                <a href="{{ URL::action('UserController@removeAdmin', $user->id) }}" class="btn btn-secondary btn-sm" data-id="{{ $user->id }}">Rendi Standard</a>
                            @endif
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<script type="text/javascript">
    $('document').ready(function(){
        $('.btn-delete.btn-sm').bind('click', function(event) {
            event.preventDefault();
            var button = $(this);
            var id = $(button).attr('data-id');

            $.ajax({
                url: "/user/"+id+"/delete",
                type: "GET",
                dataType: "json",
                success: function(data) {
                    console.log(data);
                    $(button).parents('tr').fadeOut();
                },
                error: function(response, stato) {
                    console.log(stato);
                }
            });

        });
        $('.btn-success.btn-sm').bind('click', function(event) {
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
                },
                error: function(response, stato) {
                    console.log(stato);
                }
            });
        });

        $('.btn-secondary.btn-sm').bind('click', function(event) {
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
                },
                error: function(response, stato) {
                    console.log(stato);
                }
            });
        });
    });
</script>
@endsection
