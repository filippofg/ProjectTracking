@extends('layouts.app')

@section('head')
<title>ProjectTracking - link - List</title>
@endsection

@section('content')
<h1>Lista di tutti i link</h1>

<div class="row">
    <div class="col-md-12">
        <a class="btn btn-primary float-md-right" href="{{ URL::action('WorkingOnController@create') }}" >Crea un link</a>
    </div>
</div>
<br />
<div class="row">
    <div class="col-md-12">
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">User</th>
                    <th scope="col">Working On</th>

                    <th scope="col">Azioni</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($links as $link)
                <tr>
                    <td>{{ $link->id }}</td>
                    <td>{{ $link->user->name }} {{ $link->user->surname }}</td>
                    <td>{{ $link->project->name }}</td>
                    <td>
                        <a href="{{ URL::action('WorkingOnController@show', $link->id) }}" class="btn btn-primary btn-sm"> Dettagli </a>
                        <a href="{{ URL::action('WorkingOnController@destroy', $link->id) }}" class="btn btn-danger btn-sm btn-delete" data-vat="{{ $link->id }}"> Elimina </a>
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
                url: "/working_on/"+vat+"/delete",
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
