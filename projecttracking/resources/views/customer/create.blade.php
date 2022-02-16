@extends('layouts.app')

@section('head')
<title>ProjectTracking - Customer</title>
@endsection

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-5">
            <h1>Inserire i dati del nuovo cliente</h1>

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ URL::action('CustomerController@store') }}" method="POST">

                {{ csrf_field() }}
                <div class="form-group">
                    <label for="business_name">Ragione Sociale*</label>
                    <input class="form-control" type="text" name="business_name" maxlength="255"/>
                </div>
                <div class="form-group">
                    <label for="vat_number">Partita IVA*</label>
                    <input class="form-control" type="number" name="vat_number" size="11"/>
                </div>
                <div class="form-group">
                    <label for="ssid">SSID*</label>
                    <input class="form-control" type="number" name="ssid" size="7"/>
                </div>
                <div class="form-group">
                    <label for="pec">Indirizzo posta certificata PEC*</label>
                    <input class="form-control" type="email" name="pec" maxlength="255"/>
                </div>
                <div class="form-group">
                    <label for="referent_name">Nome del referente*</label>
                    <input class="form-control" type="text" name="referent_name" maxlength="255"/>
                </div>
                <div class="form-group">
                    <label for="referent_surname">Cognome del referente*</label>
                    <input class="form-control" type="text" name="referent_surname" maxlength="255"/>
                </div>
                <div class="form-group">
                    <label for="referent_email">E-mail del referente*</label>
                    <input class="form-control" type="email" name="referent_email" maxlength="255"/>
                </div>

                <h6><i>*Campi obbligatori</i></h6>
                <input class="btn btn-primary" type="submit" value="Crea">
            </form>
        </div>
    </div>
@endsection
