@extends('layouts.app')

@section('head')
<title>ProjectTracking - Timesheet - List</title>
@endsection

@section('content')
<h1>Riepilogo di {{ $user->name }} {{ $user->surname }} su {{ $project->name }}</h1>

<div class="row">
    <div class="col-md-12">
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Data</th>
                    <th scope="col">Tempo speso</th>
                    <th scope="col">Note</th>
                    <th scope="col">Costo</th>

                    <th scope="col">Azioni</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($timesheets as $timesheet)
                <tr>
                    <td>{{ $timesheet->id }}</td>
                    <td>{{ $timesheet->date }}</td>
                    <td>{{ $timesheet->time_spent }}</td>
                    <td>{{ $timesheet->notes }}</td>
                    <td>{{ $timesheet->project->cost_per_hour*$timesheet->time_spent }} &euro;</td>
                    <td>
                        <a href="{{ URL::action('TimesheetController@edit', $timesheet->id) }}" class="btn btn-primary btn-sm"> Modifica </a>
                        <a href="{{ URL::action('TimesheetController@destroy', $timesheet->id) }}" class="btn btn-danger btn-sm btn-delete" data-vat="{{ $timesheet->id }}"> Elimina </a>
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
                url: "/timesheet/"+vat+"/delete",
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
