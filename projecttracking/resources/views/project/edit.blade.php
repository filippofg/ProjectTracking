@extends('layouts.app')

@section('head')
<title>Modifica {{ $project->name }}</title>
@endsection

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-6">
            <h1>Modifica il progetto {{ $project->name }}</h1>

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ URL::action('ProjectController@update', $project->id) }}" method="POST">
                {{ csrf_field() }}
                {{ method_field('PATCH') }}

                <div class="form-group">
                    <label for="name">Nome*</label>
                    <input class="form-control" type="text" name="name" maxlength="255" value="{{ $project->name }}" />
                </div>
                <div class="form-group">
                    <label for="description">Descrizione*</label>
                    <input class="form-control" type="text" name="description" maxlength="255" value="{{ $project->description }}" />
                </div>
                <div class="form-group">
                    <label for="notes">Note</label>
                    <input class="form-control" type="text" name="notes" maxlength="255" value="{{ $project->notes }}" />
                </div>

                <div class="form-group">
                    <label for="customer_vat_number">Cliente*</label>
                    <select class="form-control" name="customer_vat_number">
                        @foreach ($customers as $customer)
                        <option value="{{ $customer->vat_number }}" {{ ($customer->vat_number == $project->customer_vat_number) ? 'selected' : '' }}>{{ $customer->business_name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="cost_per_hour">Costo orario* [&euro;]</label>
                    <input class="form-control" type="number" name="cost_per_hour" min="0.00" step="0.01" value="{{ $project->cost_per_hour }}"/>
                </div>

                <h6><i>*Campi obbligatori</i></h6>
                <input class="btn btn-primary" type="submit" value="Aggiorna">
            </form>
        </div>
    </div>
@endsection
