@extends('zoo.layout')

@section('title', 'Archived Animals')

@section('content')
	<div class="container py-5">
		<h1 class="text-center display-3 mb-4 fw-bold">Manage Archived Animals</h1>

		@if($archivedAnimals->isEmpty())
			<div class="alert alert-info" role="alert">
				No animals have been archived.
			</div>
		@else
			<table class="table table-striped table-bordered">
				<thead>
				<tr>
					<th scope="col">Animal Name</th>
					<th scope="col">Species</th>
					<th scope="col">Archived At</th>
					<th scope="col">Actions</th>
				</tr>
				</thead>
				<tbody>
				@foreach($archivedAnimals as $animal)
					<tr>
						<td>{{ $animal->name }}</td>
						<td>{{ $animal->species }}</td>
						<td>{{ $animal->deleted_at }}</td>
						<td>
							<!-- Restore Button -->
							<button
								class="btn btn-primary"
								data-bs-toggle="modal"
								data-bs-target="#restoreModal-{{ $animal->id }}">
								Restore
							</button>
							<form action="{{ route('animals.restore', $animal->id) }}" method="POST">
								@csrf
								<!-- Modal for each animal -->
								<div class="modal fade" id="restoreModal-{{ $animal->id }}" tabindex="-1"
									 aria-labelledby="restoreModalLabel-{{ $animal->id }}" aria-hidden="true">
									<div class="modal-dialog">
										<div class="modal-content">
											<div class="modal-header">
												<h5 class="modal-title display-5"
													id="restoreModalLabel-{{ $animal->id }}">
													Restore {{ $animal->name }}
												</h5>
												<button type="button" class="btn-close" data-bs-dismiss="modal"
														aria-label="Close"></button>
											</div>
											<div class="modal-body">
												<p><strong>Animal Name:</strong> {{ $animal->name }}</p>
												<p><strong>Species:</strong> {{ $animal->species }}</p>
												<p>Select the enclosure where the animal will be placed:</p>
												<select class="form-select" name="enclosure_id" required>
													@foreach($animal->getValidEnclosures() as $enclosure)
														<option
															value="{{ $enclosure->id }}">{{ $enclosure->name }}</option>
													@endforeach
												</select>

												<div class="modal-footer mt-3">
													<button type="button" class="btn btn-secondary"
															data-bs-dismiss="modal">Cancel
													</button>
													<button type="submit" class="btn btn-primary">Restore</button>
												</div>
											</div>
										</div>
									</div>
								</div>
							</form>
						</td>
					</tr>
				@endforeach
				</tbody>
			</table>
		@endif
	</div>
@endsection
