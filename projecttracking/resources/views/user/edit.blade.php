@extends('layouts.app')

@section('head')
<title>Modifica utente</title>
@endsection

@section('content')
	<div class="row justify-content-center">
		<div class="col-md-4">
			<h1>Modifica utente {{ $user->name }} {{ $user->surname }}</h1>

			@if ($errors->any())
				<div class="alert alert-danger">
					<ul>
						@foreach ($errors->all() as $error)
							<li>{{ $error }}</li>
						@endforeach
					</ul>
				</div>
			@endif

			<form action="{{ URL::action('UserController@update', $user->id) }}" method="POST">
				{{ csrf_field() }}
				{{ method_field('PATCH') }}

				<div class="form-group">
					<label for="email">E-mail*</label>
					<input class="form-control" type="email" name="email" maxlength="255" value="{{ $user->email }}" />
				</div>
				<div class="form-group">
					<label for="name">Nome*</label>
					<input class="form-control" type="text" name="name" maxlength="255" value="{{ $user->name }}" />
				</div>
				<div class="form-group">
                    <label for="surname">Cognome*</label>
                    <input class="form-control" type="text" name="surname" maxlength="=255" value="{{ $user->surname }}" />
				</div>

				<h6><i>*Campi obbligatori</i></h6>
				<input class="btn btn-primary" type="submit" value="Aggiorna">
			</form>
		</div>
	</div>
@endsection
