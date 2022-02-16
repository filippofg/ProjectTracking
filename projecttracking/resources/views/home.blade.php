@extends('layouts.app')

@section('head')
<title>Dashboard di {{ Auth::user()->name }} </title>
@endsection

@section('content')
<div class="d-flex justify-content-between bd-highlight mb-3">
    <div class="p-2 bd-highlight col-md-2">
        <h1>Bentornato</h1>
        <h3>{{ Auth::user()->name }} {{ Auth::user()->surname }}</h3>
        @if (Auth::user()->is_admin)
            <h6><em>Amministratore</em></h6>
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
            <div class="card-header">Crea una nuova scheda ore</div>
            <div class="card-body">

                @if ( $links->count() > 0)
                    <form id="new-ts" action="{{ URL::action('TimesheetController@store') }}" method="POST">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label for="date">Data*</label>
                            <input class="form-control" type="date" name="date" value="{{ date('Y-m-d') }}"/>
                        </div>
                        <div class="form-group">
                            <label for="time_spent">Tempo speso*</label>
                            <input class="form-control" type="number" name="time_spent" min="1" max="12" step="1" value="1"/>
                        </div>
                        <div class="form-group">
                            <label for="notes">Note</label>
                            <input class="form-control" type="text" name="notes" maxlength="255"/>
                        </div>
                        <div class="form-group">
                            <label for="project_id">Progetto*</label>
                            <select class="form-control" name="project_id">
                                @foreach ($links as $link)
                                        <option name="project_id" value="{{ $link->project->id }}">{{ $link->project->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <h6><i>*Campi obbligatori</i></h6>
                        <input id="submit-button" class="btn btn-primary" type="submit" value="Crea">
                    </form>
                @else
                    <em>
                        Non stai lavorando su nessun progetto.<br>
                        Non puoi creare nessuna scheda ore.
                    </em>
                @endif
            </div>
        </div>
    </div>
    <div class="p-2 bd-highlight col-md-3">
        <div id="calendario-mensile" class="card">
            <div class="card-header">
                Calendario mese corrente
                <a class="btn btn-sm btn-success btn-right" href="{{ URL::action('TimesheetController@monthlyRecap', date('m')) }}">Cambia mese</a>
            </div>
            <div class="card-body scrollable">
                @foreach ($projects as $project)
                    @if(($time = $timesheets->where('project_id', $project->id)->sum('time_spent')) > 0)
                        <a href="{{ URL::action('ProjectController@show', $project->id) }}">{{ $project->name }}</a>
                        (ore spese:
                        {{ $time }}, ammontare: {{ $time*$project->cost_per_hour }} &euro;,
                        <a href="{{ URL::action('TimesheetController@showWorkOn', [Auth::user()->id, $project->id]) }}">riepilogo</a>)
                        <br>
                    @endif
                @endforeach
            </div>
        </div>
        @if ($projects)
            <div class="card mt-xl-3">
                <div class="card-header">Progetti attivi</div>
                <div class="card-body scrollable">
                    @if($links->where('terminated_at', '')->count() > 0)
                        <table class="table-bordered text-center w-100">
                            <thead>
                                <th>Nome</th>
                                <th>Descrizione</th>
                                <th>Note</th>
                                <th>Costo</th>
                            </thead>
                            <tbody>
                            @foreach ($links as $link)
                                @if (!$link->project->terminated_at)
                                <tr>
                                    <td><a href="{{ URL::action('ProjectController@show', $link->project->id) }}">{{ $link->project->name }}</a></td>
                                    <td>{{ $link->project->description }}</td>
                                    <td>{{ $link->project->notes ?? 'N/D' }}</td>
                                    <td>{{ $link->project->cost_per_hour }} &euro;/h</td>
                                </tr>
                                @endif
                            @endforeach
                            </tbody>
                        </table>
                    @else
                        <h6><em>Nessun progetto attivo</em></h6>
                    @endif
                </div>
            </div>
        @endif
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
<script type="text/javascript">
    $('document').ready(function(){
        $('input#submit-button').bind('click', function(event) {
            event.preventDefault();

            var dataTimesheet = $('form#new-ts').find('input[name=date]').val();
            var tempoTimesheet = $('form#new-ts').find('input[name=time_spent]').val();
            var noteTimesheet = $('form#new-ts').find('input[name=notes]').val();
            var progettoTimesheet = $('form#new-ts').find('option[name=project_id]').val();

            $.ajax({
                url:         '/timesheet',
                type:        'POST',
                dataType:    'json',
                data:        { "_token": "{{ csrf_token() }}", date: dataTimesheet, time_spent: tempoTimesheet, notes: noteTimesheet, project_id: progettoTimesheet },
                success:     function(data) {   // in caso di successo...
                   console.log("Successo: "+data);
                   $('form#new-ts')[0].reset();        // ...toglie l'input inserito dal form
                   $('div#calendario-mensile').load(location.href + " #calendario-mensile");
                },
                error:       function(response, stato, data) {
                    console.log("Errore: "+stato);
                    console.log(response);
               }
           });
        });
    });
</script>

@endsection
