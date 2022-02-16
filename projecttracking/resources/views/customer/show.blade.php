<title>{{ $customer->business_name }}</title>
@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between bd-highlight mb-3">
    <div class="p-2 bd-highlight col-md-2">
        <div class="row">
            <div class="col-md-12">
                <h1>{{ $customer->business_name }}</h1>
            </div>
            <div class="col-md-12">
                <table class="breathe">
                    <tr>
                        <td class="info"><b>P. IVA</b></td>
                        <td class="info">{{ $customer->vat_number }}</td>
                    </tr>
                    <tr>
                        <td class="info"><b>Ref.</b></td>
                        <td class="info">{{ $customer->referent_name}} {{ $customer->referent_surname }}</td>
                    </tr>
                    <tr>
                        <td class="info"><b>Contatti</b></td>
                        <td class="info">{{ $customer->pec }}<br>
                            {{ $customer->referent_email }}
                        </td>
                    </tr>
                    <tr>
                        <td class="info"><b>SSID</b></td>
                        <td class="info">{{ $customer->ssid }}</td>
                    </tr>
                </table>
            </div>
            @if(Auth::user()->is_admin)
                <div class="col-md-12">
                    <a class="btn btn-secondary" href="{{  URL::action('CustomerController@edit', $customer->vat_number) }}" >Modifica</a>
                </div>
            @endif
        </div>
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
            <div class="card-header text-center">Progetti attivi</div>
            <div class="card-body">
                @if (!isset($projects))
                    <h6><em>Non sembra esserci nulla qui...</em></h6>
                            @if (Auth::user()->is_admin)
                                <h6><a href="{{ URL::action('ProjectController@create', $customer->vat_number) }}"> Crea</a> un nuovo progetto!</h6>
                            @endif
                @else
                    @if ($projects->where('terminated_at', NULL)->count() > 0)
                        <table class="table-bordered text-center w-100">
                            <thead>
                            <tr>
                                <th>Nome</th>
                                <th>Descrizione</th>
                                <th>Note</th>
                                <th>Data inizio</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($projects as $project)
                                @if (!$project->terminated_at)
                                    <tr>
                                        <td><a href="{{ URL::action('ProjectController@show', $project->id) }}">{{ $project->name }}</a></td>
                                        <td>{{ $project->description }}</td>
                                        <td>{{ $project->notes ?? 'N/D' }}</td>
                                        <td>{{ $project->created_at }}</td>
                                    </tr>
                                @endif
                            @endforeach
                            </tbody>
                        </table>
                    @else
                        <h6><em>Nessun progetto in corso</em></h6>
                    @endif
                @endif
            </div>
        </div>
    </div>
    <div class="p-2 bd-highlight col-md-4">
        <div class="card">
            <div class="card-header text-center">Progetti terminati</div>
            <div class="card-body">
                @if (!isset($projects))
                    <h6><em>Non sembra esserci nulla qui...</em></h6>
                @else
                    @if ($projects->where('terminated_at')->count() > 0)
                        <table class="table-bordered text-center w-100">
                            <thead>
                                <tr>
                                    <th>Nome</th>
                                    <th>Descrizione</th>
                                    <th>Note</th>
                                    <th>Data inizio</th>
                                    <th>Data fine</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($projects as $project)
                                    @if ($project->terminated_at)
                                        <tr>
                                            <td><a href="{{ URL::action('ProjectController@show', $project->id) }}">{{ $project->name }}</a></td>
                                            <td>{{ $project->description }}</td>
                                            <td>{{ $project->notes ?? 'N/D' }}</td>
                                            <td>{{ $project->created_at }}</td>
                                            <td>{{ $project->terminated_at }}</td>
                                        </tr>
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <h6><em>Nessun progetto terminato</em></h6>
                    @endif
                @endif
            </div>
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
</div>
@endsection
