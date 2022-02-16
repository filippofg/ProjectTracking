@extends('layouts.app')

@section('head')
<title>ProjectTracking - Timesheet - projectsReport</title>
@endsection

@section('content')
    <div class="row">
        <form class="form-inline" action="{{ URL::action('TimesheetController@setProjectsDates') }}" method="POST">
            {{ csrf_field() }}
            <div class="form-group">
                <label for="start">Inizio</label>
                <input class="form-control" type="date" name="start" value="{{ date('Y-m-').'01' }}"/>

                <label for="end">Fine</label>
                <input class="form-control" type="date" name="end" value="{{ date('Y-m-').cal_days_in_month(CAL_GREGORIAN, date('m'), date('Y')) }}"/>
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
                        <th scope="col">#</th>
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
                        @if (!$data->where('project_id', $project->id)->sum('time_spent') == 0)
                            <tr>
                                <td>{{ $project->id }}</td>
                                <td>{{ $project->name }}</td>
                                <td>{{ $project->description }}</td>
                                <td>{{ $project->notes }}</td>
                                <td>{{ $project->created_at }}</td>
                                <td>{{ $project->terminated_at }}</td>
                                <td>{{ $project->customer->business_name }}</td>
                                <td>{{ $data->where('project_id', $project->id)->sum('time_spent') }}</td>
                                <td>{{ $data->where('project_id', $project->id)->sum('time_spent')*$project->cost_per_hour }} &euro;</td>
                            </tr>
                        @endif
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
