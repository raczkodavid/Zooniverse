<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8"/>
	<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
	<link
		href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
		rel="stylesheet"
		integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH"
		crossorigin="anonymous"
	/>
	<link rel="stylesheet" href="{{ asset('css/style.css') }}"/>
	<title>Zooniverse - @yield('title')</title>
	<!-- Fav Icon -->
	<link rel="icon" type="image/png" href="{{ asset('images/favico.png') }}">
</head>
<body>
<!-- Navbar -->
<nav class="navbar navbar-expand-lg py-2">
	<div class="container-fluid justify-content-between">
		<a class="navbar-brand text-center fw-bold" href="{{ route('homepage') }}">Zoo Manager</a>
		<button
			class="navbar-toggler border-0"
			type="button"
			data-bs-toggle="collapse"
			data-bs-target="#navbarNav"
		>
			<span class="navbar-toggler-icon"></span>
		</button>
		<div class="collapse navbar-collapse" id="navbarNav">
			<ul class="navbar-nav">
				<li class="nav-item">
					<a class="nav-link fw-semibold" href="{{ route('homepage') }}">HomePage</a>
				</li>
				<li class="nav-item dropdown">
					<a
						class="nav-link dropdown-toggle fw-semibold"
						href="#"
						id="enclosureDropdown"
						role="button"
						data-bs-toggle="dropdown"
					>
						Enclosures
					</a>
					<ul class="dropdown-menu">
						<li>
							<a class="dropdown-item" href="{{ route('enclosures.index')}}"
							>List Enclosures</a
							>
						</li>
						@if (Auth::user()->admin)
							<li>
								<a class="dropdown-item" href="{{ route('enclosures.create') }}"
								>Create Enclosure</a
								>
							</li>
						@endif
					</ul>
				</li>
				@if (Auth::user()->admin)
					<li class="nav-item dropdown">
						<a
							class="nav-link dropdown-toggle fw-semibold"
							href="#"
							id="animalDropdown"
							role="button"
							data-bs-toggle="dropdown"
						>
							Animals
						</a>
						<ul class="dropdown-menu">
							<li>
								<a class="dropdown-item" href="{{ route('animals.create') }}"
								>Create Animal</a
								>
							</li>
							<li>
								<a class="dropdown-item" href="{{ route('animals.archived') }}"
								>Archived Animals</a
								>
							</li>
						</ul>
					</li>
				@endif
			</ul>
			<ul class="navbar-nav ms-auto align-items-center">
				<li
					class="nav-item d-flex align-items-center gap-2 flex-wrap flex-lg-nowrap"
				>
					<button id="theme-switch" class="btn">
						<svg
							id="sun-icon"
							xmlns="http://www.w3.org/2000/svg"
							height="24px"
							viewBox="0 -960 960 960"
							width="24px"
							fill="#000000"
						>
							<path
								d="M480-280q-83 0-141.5-58.5T280-480q0-83 58.5-141.5T480-680q83 0 141.5 58.5T680-480q0 83-58.5 141.5T480-280ZM200-440H40v-80h160v80Zm720 0H760v-80h160v80ZM440-760v-160h80v160h-80Zm0 720v-160h80v160h-80ZM256-650l-101-97 57-59 96 100-52 56Zm492 496-97-101 53-55 101 97-57 59Zm-98-550 97-101 59 57-100 96-56-52ZM154-212l101-97 55 53-97 101-59-57Z"
							/>
						</svg>
						<svg
							id="moon-icon"
							xmlns="http://www.w3.org/2000/svg"
							height="24px"
							viewBox="0 -960 960 960"
							width="24px"
							fill="#FFFFFF"
						>
							<path
								d="M480-120q-150 0-255-105T120-480q0-150 105-255t255-105q14 0 27.5 1t26.5 3q-41 29-65.5 75.5T444-660q0 90 63 153t153 63q55 0 101-24.5t75-65.5q2 13 3 26.5t1 27.5q0 150-105 255T480-120Z"
							/>
						</svg>
					</button>
					<form action="{{ route('logout') }}" id="sign-out-form" method="POST">
						@csrf
						<button class="btn" id="sign-out-btn">Sign Out</button>
					</form>
				</li>
			</ul>
		</div>
	</div>
</nav>

<!-- Content -->
@yield('content')
<script src="{{ asset('js/darkmode.js') }}"></script>
<script
	src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
	integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
	crossorigin="anonymous"
>
</script>
@yield('scripts')
</body>
</html>
