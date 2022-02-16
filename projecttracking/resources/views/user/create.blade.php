@extends('layouts.app')

@section('head')
<title>Registrazione utente</title>
@endsection

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-4">
            <h1>Inserire i dati del nuovo utente</h1>

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ URL::action('UserController@store') }}" method="POST">
                {{ csrf_field() }}
                <div class="form-group">
                    <label for="name">Nome*</label>
                    <input class="form-control" type="text" name="name" maxlength="255"/>
                </div>
                <div class="form-group">
                    <label for="surname">Cognome*</label>
                    <input class="form-control" type="text" name="surname" maxlength="255"/>
                </div>
                <div class="form-group">
                    <label for="email">E-mail*</label>
                    <input class="form-control" type="email" name="email" maxlength="255"/>
                </div>
                <div class="form-group">
                    <label for="email_confirm">Conferma e-mail*</label>
                    <input class="form-control" type="email" name="email_confirmation" maxlength="255"/>
                </div>

                <h6><em>*Campi obbligatori</em></h6>
                <input class="btn btn-primary" type="submit" value="Registrazione">
            </form>
        </div>
    </div>
@endsection
