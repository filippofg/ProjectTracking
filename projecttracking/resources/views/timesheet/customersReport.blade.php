@extends('layouts.app')

@section('head')
<title>ProjectTracking - Timesheet - customersReport</title>
@endsection

@section('content')
    <div class="row">
        <form class="form-inline" action="{{ URL::action('TimesheetController@setCustomersDates') }}" method="POST">
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
                        <th scope="col">P. IVA</th>
                        <th scope="col">Ragione Sociale</th>
                        <th scope="col">Referente</th>
                        <th scope="col">E-mail</th>
                        <th scope="col">Indirizzo fatturazione elettronica</th>
                        <th scope="col">Tempo speso</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($customers as $customer)
                        @if (!$data->where('customer_vat_number', $customer->vat_number)->sum('time_spent') == 0)
                            <tr>
                                <td>{{ $customer->vat_number }}</td>
                                <td>{{ $customer->business_name }}</td>
                                <td>{{ $customer->referent_name }} {{ $customer->referent_surname }}</td>
                                <td>Referente: {{ $customer->referent_email }}<br>
                                    PEC: {{ $customer->pec }}</td>
                                <td>{{ $customer->ssid }}</td>
                                <td>{{ $data->where('customer_vat_number', $customer->vat_number)->sum('time_spent') }}h</td>
                            </tr>
                        @endif
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
