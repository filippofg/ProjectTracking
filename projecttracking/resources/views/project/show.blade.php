<title>{{ $project->name }}</title>
@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between  bd-highlight mb-3">
    <div class="p-2 bd-highlight col-md-2">
        <div class="row">
            <div class="col-md-12">
                <h1>{{ $project->name }}</h1>
                <h5>
                    <i>Commissionato da:
                    <a href="{{  URL::action('CustomerController@show', $project->customer_vat_number) }}">
                        {{ $project->customer->business_name }}
                    </a>
                    </i>
                </h5>
            </div>
            <div class="col-md-12">
                <h5>
                    <b>Descrizione:</b> {{ $project->description }}<br>
                    @if($project->notes)
                        <b>Note:</b> {{ $project->notes }}<br>
                    @endif
                        <b>Costo:</b> {{ $project->cost_per_hour }} &euro;/h<br>
                    @if($project->created_at)
                        <b>Data inizio:</b> {{ subStr($project->created_at, 0, 10) }}<br>
                    @endif
                    @if($project->updated_at)
                        <b>Data ultima modifica:</b> {{ subStr($project->updated_at, 0, 10) }}<br>
                    @endif
                    @if($project->terminated_at)
                        <b>Data fine:</b> {{ subStr($project->terminated_at, 0, 10) }}<br>
                    @endif
                </h5>
            </div>
            @if (Auth::user()->is_admin)
            <div class="col-md-12">
                <a class="btn btn-secondary" href="{{  URL::action('ProjectController@edit', $project->id) }}">Modifica</a>
                @if (!$project->terminated_at)
                    <a class="btn btn-danger" href="{{  URL::action('ProjectController@terminate', $project->id) }}">Termina</a>
                @endif
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
    <div class="p-2 bd-highlight col-md-6">
        <div class="card">
            <div class="card-header text-center">Utenti coinvolti</div>
            <div class="card-body">
                @if ($links->count() == 0)
                    <h6><em>Al momento nessuno sta lavorando al progetto...</em></h6>
                @else
                    <table class="table-bordered text-center w-100">
                        <thead>
                        <tr>
                            <th>E-mail</th>
                            <th>Nome</th>
                            <th>Cognome</th>
                            <th>Data inizio lavorazione</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($links as $link)
                            <tr>
                                <td>
                                    {{-- Se l'utente è amministratore, allora è autorizzato a
                                         vedere nel dettaglio i singoli utenti
                                    --}}
                                    @if (Auth::user()->is_admin)
                                        <a href="{{ Auth::user()->is_admin ? URL::action('UserController@show', $link->id) : '' }}">{{ $link->email }}</a>
                                    @else
                                        {{ $link->email }}
                                    @endif
                                </td>
                                <td>{{ $link->name }}</td>
                                <td>{{ $link->surname }}</td>
                                <td>{{ $link->created_at }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>
    </div>
    <div class="p-2 col-md-1">
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
