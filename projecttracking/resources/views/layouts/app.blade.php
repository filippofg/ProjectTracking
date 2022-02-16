<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<!-- CSRF Token -->
	<meta name="csrf-token" content="{{ csrf_token() }}">

	<title>{{ config('app.name', 'Laravel') }}</title>

	<!-- Scripts -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="{{ asset('js/sidebar.js') }}" defer></script>

	<!-- Fonts -->
	<link rel="dns-prefetch" href="//fonts.gstatic.com">
	<link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

	<!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/sidebar.css') }}" rel="stylesheet">
    <link href="{{ asset('css/general.css') }}" rel="stylesheet">
</head>
<body>
	<div id="app">
		<nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
			<div class="container">
                @if (Auth::user() && Auth::user()->is_admin)
                    <div id="sidebar-btn">
                        <span></span>
                        <span></span>
                        <span></span>
                    </div>
                @endif
				<a class="navbar-brand" href="{{ url('/') }}">
					<img src="{{ URL::asset('/img/logo.png') }}" height="20" width="20">
					{{ config('app.name', 'Laravel') }}
				</a>
				<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
					<span class="navbar-toggler-icon"></span>
				</button>

				<div class="collapse navbar-collapse" id="navbarSupportedContent">
					<!-- Left Side Of Navbar -->
					<ul class="navbar-nav mr-auto">

					</ul>

					<!-- Right Side Of Navbar -->
					<ul class="navbar-nav ml-auto">
						<!-- Authentication Links -->
						@guest
							<li class="nav-item">
								<a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
							</li>
							{{-- @if (Route::has('register'))
								<li class="nav-item">
									<a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
								</li>
							@endif --}}
						@else
							<li class="nav-item dropdown">
								<a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
									{{ Auth::user()->name }} {{ Auth::user()->surname }}<span class="caret"></span>
								</a>

								<div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
									<a class="dropdown-item" href="{{ route('logout') }}"
										onclick="event.preventDefault();
										document.getElementById('logout-form').submit();">
										{{ __('Logout') }}
                                    </a>

									<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
										@csrf
									</form>
								</div>
							</li>
						@endguest
					</ul>
				</div>
			</div>
        </nav>
        @if (Auth::user() && Auth::user()->is_admin)
            <div class="bg-white shadow-lg" id="sidebar">
                <div class="wrapper">
                    <strong class="sidebar-subtitle">Amministrazione</strong>
                    <ul class="list-unstyled">
                        <li>Utenti
                            <ul class="list-unstyled">
                                {{--<li>
                                    <a href="{{ URL::action('WorkingOnController@create') }}">Assegna un progetto ad un utente</a>
                                </li>--}}
                                <li>
                                    <a href="{{ URL::action('UserController@index') }}">Lista utenti</a>
                                </li>
                                <li>
                                    <a href="{{ URL::action('UserController@create') }}">Registra nuovo utente</a>
                                </li>
                                {{--<li>
                                    <a href="{{ URL::action('UserController@delete') }}">Elimina un utente</a>
                                </li>--}}
                            </ul>
                        </li>
                        <li>Clienti
                            <ul class="list-unstyled">
                                <li>
                                    <a href="{{ URL::action('CustomerController@index') }}">Lista clienti</a>
                                </li>
                                <li>
                                    <a href="{{ URL::action('CustomerController@create') }}">Nuovo cliente</a>
                                </li>
                               {{-- <li>
                                    <a href="--}}{{-- URL::action('CustomerController@delete') --}}{{--">Elimina un cliente</a>
                                </li>--}}
                            </ul>
                        </li>

                        <li>Progetti
                            <ul class="list-unstyled">
                                <li>
                                    <a href="{{ URL::action('ProjectController@index') }}">Lista progetti</a>
                                </li>
                                <li>
                                    <a href="{{ URL::action('ProjectController@create') }}">Nuovo progetto</a>
                                </li>
                               {{-- <li>
                                    <a href="--}}{{-- URL::action('ProjectController@delete') --}}{{--">Elimina un progetto</a>
                                </li>--}}
                            </ul>
                        </li>
                    </ul>
                    <ul class="list-unstyled">
                        <li>Reports
                            <ul class="list-unstyled">
                                <li>
                                    <a href="{{ URL::action('TimesheetController@projectsReport', [date('Y-m-').'01', date('Y-m-').cal_days_in_month(CAL_GREGORIAN, date('m'), date('Y'))]) }}">Report dei progetti</a>
                                </li>
                                <li>
                                    <a href="{{ URL::action('TimesheetController@customersReport', [date('Y-m-').'01', date('Y-m-').cal_days_in_month(CAL_GREGORIAN, date('m'), date('Y'))]) }}">Report dei clienti</a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        @endif
		<main class="py-4">
			@yield('content')
		</main>
	</div>
</body>
</html>
