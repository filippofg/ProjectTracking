@extends('layouts.app')

@section('head')
<title>Clienti</title>
@endsection

@section('content')
<h1>Lista clienti</h1>

<form class="form-inline" action="{{ URL::action('CustomerController@search') }}" method="POST">
    {{ csrf_field() }}
    <div class="form-group">
        <input class="form-control" type="text" name="business_name" placeholder="Ragione sociale" maxlength="255">
    </div>

    <input class="btn btn-secondary" type="submit" value="Cerca">
</form>
<a class="btn btn-primary float-md-right" href="{{ URL::action('CustomerController@create') }}" >Nuovo cliente</a>
<br>
<div class="table-body row">
    <div class="col-md-12">
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">P. IVA</th>
                    <th scope="col">Ragione Sociale</th>
                    <th scope="col">Referente</th>
                    <th scope="col">E-mail</th>
                    <th scope="col">Indirizzo fatturazione elettronica</th>

                    <th scope="col">Azioni</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($customers as $c)
                <tr>
                    <td>{{ $c->vat_number }}</td>
                    <td>{{ $c->business_name }}</td>
                    <td>{{ $c->referent_name }} {{ $c->referent_surname }}</td>
                    <td>Referente: {{ $c->referent_email }}<br>
                        PEC: {{ $c->pec }}</td>
                    <td>{{ $c->ssid }}</td>
                    <td>
                        <a href="{{ URL::action('CustomerController@show', $c->vat_number) }}" class="btn btn-primary btn-sm"> Dettagli </a>
                        <a href="{{ URL::action('CustomerController@destroy', $c->vat_number) }}" class="btn btn-danger btn-sm btn-delete" data-vat="{{ $c->vat_number }}"> Elimina </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<script type="text/javascript">
    $('document').ready(function(){
        $('.btn-delete').bind('click', function(event) {

            event.preventDefault();
            var button = $(this);
            var vat = $(button).attr('data-vat');

            $.ajax({
                url: "/customer/"+vat+"/delete",
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
    });
</script>
@endsection
