@extends('layouts.app')

@section('head')
<title>ProjectTracking - Project - List</title>
@endsection

@section('content')
<h1>Lista di tutti i progetti</h1>
<form class="form-inline" action="{{ URL::action('ProjectController@search') }}" method="POST">
    {{ csrf_field() }}
    <div class="form-group">
        <input class="form-control" type="text" name="name" placeholder="Nome del progetto" maxlength="255">
    </div>

    <input class="btn btn-secondary" type="submit" value="Cerca">
</form>
<a class="btn btn-primary float-md-right" href="{{ URL::action('ProjectController@create') }}" >Crea un progetto</a>
<br>
<div class="table-body row">
    <div class="col-md-12">
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">Nome</th>
                    <th scope="col">Descrizione</th>
                    <th scope="col">Note</th>
                    <th scope="col">Creato il</th>
                    <th scope="col">Aggiornato il</th>
                    <th scope="col">Terminato il</th>
                    <th scope="col">Mandante</th>

                    <th scope="col">Azioni</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($projects as $project)
                <tr>
                    <td>{{ $project->name }}</td>
                    <td>{{ $project->description }}</td>
                    <td>{{ $project->notes }}</td>
                    <td>{{ $project->created_at }}</td>
                    <td>{{ $project->updated_at }}</td>
                    <td>{{ $project->terminated_at }}</td>
                    <td><a href="{{ URL::action('CustomerController@show', $project->customer->vat_number) }}">{{ $project->customer->business_name }}</a></td>
                    <td>
                        <a href="{{ URL::action('ProjectController@show', $project->id) }}" class="btn btn-primary btn-sm"> Dettagli </a>
                        <a href="{{ URL::action('ProjectController@destroy', $project->id) }}" class="btn btn-danger btn-sm btn-delete" data-vat="{{ $project->id }}"> Elimina </a>
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
                url: "/project/"+vat+"/delete",
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
