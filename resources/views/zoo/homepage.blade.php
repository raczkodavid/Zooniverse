@extends('zoo.layout')

@use('App\Models\Animal')
@use('App\Models\Enclosure')

@section('title', 'Homepage')

@section('content')
	<!-- Hero Section -->
	<div class="container-lg text-center mt-3">
		<h1 class="display-4 fw-bold">Welcome to Zooniverse!</h1>
		<p class="lead">
			Complete Zoo Control - From Creating to Deleting, All at Your
			Fingertips
		</p>

		<!-- Card Section -->
		<div class="container-fluid">
			<div class="row gy-3">
				<!-- Middle Column: Big Card -->
				<div class="col-12 col-md-8 col-xl-6 order-1 order-md-2">
					<div class="card shadow-lg border-0 h-100">
						<img
							src="{{ asset('images/zooniverse2.jpg') }}"
							class="img-fluid"
							alt="Zoo Image"
						/>
						<div class="card-body">
							<h5 class="card-title fw-semibold">
								Manage Your Zoo Like Never Before
							</h5>
							<p class="card-text">
								Zooniverse offers you full control to create, edit, delete,
								and explore every aspect of your zoo. Dive in and start
								building your wildlife empire today!
							</p>
						</div>
					</div>
				</div>

				<!-- Left Column: Two Stacked Cards -->
				<div
					class="col-12 col-md-4 col-xl-3 d-flex flex-column order-2 order-md-1"
				>
					<div class="card popup-card flex-fill shadow-lg border-0 text-center">
						<div
							class="card-body d-flex flex-column justify-content-center rounded-5"
						>
							<h5 class="card-title fw-semibold">Total Enclosures</h5>
							<h1 class="display-1 fw-bold text-success countup" data-target="{{ $enclosureCount }}">
								0</h1>
						</div>
					</div>
					<div
						class="card popup-card flex-fill shadow-lg border-0 text-center mt-3 mt-lg-4"
					>
						<div class="card-body d-flex flex-column justify-content-center">
							<h5 class="card-title fw-semibold">Total Animals</h5>
							<h1 class="display-1 fw-bold text-success countup" data-target="{{ $animalCount }}">0</h1>
						</div>
					</div>
				</div>

				<!-- Right Column: Zookeeper's Task List -->
				<div class="col-12 col-lg-4 col-xl-3 order-3">
					<div class="card shadow-lg border-0 h-100">
						<div class="card-body">
							<h5 class="card-title fw-semibold">Tasks for Today</h5>
							<!-- List of Tasks, if none is present, display a message centered vertically -->
							@if($enclosures->isEmpty())
								<p class="card-text">No more tasks for today!</p>
							@else
								<ul class="list-group list-group-flush">
									@foreach($enclosures as $task)
										<a href="{{ route('enclosures.show', $task->id) }}">
											<li class="list-group-item">
												{{ $task->name }} - {{ $task->feeding_time }}
											</li>
										</a>
									@endforeach
								</ul>
							@endif
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection
@section('scripts')
	<script src="{{ asset('/js/countup.js') }}"></script>
@endsection
