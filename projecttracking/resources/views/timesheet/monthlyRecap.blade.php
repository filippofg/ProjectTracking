@extends('layouts.app')

@section('head')
<title>ProjectTracking - Timesheet - MonthlyRecap</title>
@endsection

@section('content')
    <div class="row">
        <form class="form-inline" action="{{ URL::action('TimesheetController@setRecapMonth') }}" method="POST">
            {{ csrf_field() }}
            <div class="form-group">
                <label for="start">Mese</label>
                <select class="form-control" name="month">
                    <option name="month" value="01" {{ (date('m') == '01') ? 'selected' : '' }}>Gennaio</option>
                    <option name="month" value="02" {{ (date('m') == '02') ? 'selected' : '' }}>Febbraio</option>
                    <option name="month" value="03" {{ (date('m') == '03') ? 'selected' : '' }}>Marzo</option>
                    <option name="month" value="04" {{ (date('m') == '04') ? 'selected' : '' }}>Aprile</option>
                    <option name="month" value="05" {{ (date('m') == '05') ? 'selected' : '' }}>Maggio</option>
                    <option name="month" value="06" {{ (date('m') == '06') ? 'selected' : '' }}>Giugno</option>
                    <option name="month" value="07" {{ (date('m') == '07') ? 'selected' : '' }}>Luglio</option>
                    <option name="month" value="08" {{ (date('m') == '08') ? 'selected' : '' }}>Agosto</option>
                    <option name="month" value="09" {{ (date('m') == '09') ? 'selected' : '' }}>Settembre</option>
                    <option name="month" value="10" {{ (date('m') == '10') ? 'selected' : '' }}>Ottobre</option>
                    <option name="month" value="11" {{ (date('m') == '11') ? 'selected' : '' }}>Novembre</option>
                    <option name="month" value="12" {{ (date('m') == '12') ? 'selected' : '' }}>Dicembre</option>
                </select>
            </div>

            <input class="btn btn-primary" type="submit" value="Cerca">
        </form>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="col-md-12">
            <h3>Report</h3>
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">Nome</th>
                        <th scope="col">Descrizione</th>
                        <th scope="col">Note</th>
                        <th scope="col">Creato il</th>
                        <th scope="col">Terminato il</th>
                        <th scope="col">Cliente</th>
                        <th scope="col">Tempo speso</th>
                        <th scope="col">Costo</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($projects as $project)
                        @if($timesheets->where('project_id', $project->id)->sum('time_spent') > 0)
                            <tr>
                                <td>{{ $project->name }}</td>
                                <td>{{ $project->description }}</td>
                                <td>{{ $project->notes }}</td>
                                <td>{{ $project->created_at }}</td>
                                <td>{{ $project->terminated_at }}</td>
                                <td>{{ $project->customer->business_name }}</td>
                                <td>{{ $timesheets->where('project_id', $project->id)->sum('time_spent') }}</td>
                                <td>{{ $timesheets->where('project_id', $project->id)->sum('time_spent')*$project->cost_per_hour }} &euro;</td>
                            </tr>
                        @endif
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
