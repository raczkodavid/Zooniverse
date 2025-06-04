@extends('zoo.layout')

@section('title', 'Show Enclosure')

@section('content')
	<div class="container py-3">
		<!-- Enclosure data -->
		<h1 class="text-center display-3 fw-bold mb-4">Enclosure Details</h1>
		<div class="row mb-4">
			<div class="col-md-6">
				<p><strong>Enclosure Name: {{ $enclosure->name }}</strong></p>
				<p><strong>Animal Limit:</strong> {{ $enclosure->limit }}</p>
				<p><strong>Current Animal Count:</strong> {{ $enclosure->animals()->count() }}</p>
				<!-- Warning: Predators in enclosure -->
				@if($enclosure->isPredatorEnclosure())
					<div class="alert alert-danger" role="alert">
						Warning: Predator animals are in this enclosure!
					</div>
				@endif
			</div>
		</div>

		<!-- Animal List -->
		<h2 class="mb-3">Animals in the Enclosure</h2>
		<div class="list-group">
			@foreach($animals as $animal)
				<div
					class="list-group-item d-flex justify-content-between align-items-center"
				>
					<div class="d-flex align-items-center">
						<img
							src="{{$animal->image_name ? asset('storage/images/' . $animal->image_name_hash) : asset('images/placeholder.png')}}"
							alt="Animal Image"
							class="rounded me-3"
						/>
						<div>
							<p class="mb-0"><strong>{{ $animal->name }}</strong></p>
							<small class="text">Species: {{ $animal->species }}</small>
							<br/>
							<small class="text">Born: {{ $animal->born_at }}</small>
						</div>
					</div>
					@if($isAdmin)
						<div class="btn-group" role="group">
							<a class="btn btn-warning btn-sm" href="{{ route('animals.edit', $animal->id) }}">Edit</a>
							<form action="{{ route('animals.destroy', $animal->id) }}" method="POST"
								  style="display:inline;">
								@csrf
								@method('DELETE')
								<button type="submit" class="btn btn-danger btn-sm">Archive</button>
							</form>
						</div>
					@endif
				</div>
			@endforeach
		</div>
	</div>
@endsection
