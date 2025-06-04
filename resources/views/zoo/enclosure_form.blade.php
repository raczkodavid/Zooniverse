@extends('zoo.layout')

@section('title', isset($enclosure) ? 'Edit Enclosure' : 'Create Enclosure')

@section('content')
	<div class="container py-5">
		<h1 class="text-center display-3 mb-4 fw-bold">
			{{ isset($enclosure) ? 'Edit Enclosure' : 'Create New Enclosure' }}
		</h1>

		<form
			action="{{ isset($enclosure) ? route('enclosures.update', $enclosure->id) : route('enclosures.store') }}"
			method="POST"
			class="p-4 p-lg-5 rounded-4 shadow-sm"
		>
			@csrf
			@if(isset($enclosure))
				@method('PUT')
			@endif

			<div class="row g-4">
				<!-- Enclosure Name -->
				<div class="col-md-6">
					<label for="name" class="form-label fw-semibold">Enclosure Name</label>
					<input
						type="text"
						class="form-control form-control-lg @error('name') is-invalid @enderror"
						id="name"
						name="name"
						placeholder="Enter the enclosure name"
						value="{{ old('name', isset($enclosure) ? $enclosure->name : '') }}"
					/>

					@error('name')
					<div class="invalid-feedback">{{ $message }}</div>
					@enderror

					<div class="mt-1">Give your enclosure a unique and descriptive name.</div>
				</div>

				<!-- Limit -->
				<div class="col-md-6">
					<label for="limit" class="form-label fw-semibold">Animal Limit</label>
					<input
						type="number"
						class="form-control form-control-lg @error('limit') is-invalid @enderror"
						id="limit"
						name="limit"
						placeholder="Enter the animal limit"
						value="{{ old('limit', isset($enclosure) ? $enclosure->limit : '') }}"
					/>

					@error('limit')
					<div class="invalid-feedback">{{ $message }}</div>
					@enderror

					<div class="mt-1">Set the maximum number of animals this enclosure can hold.</div>
				</div>

				<!-- Feeding Time -->
				<div class="col-md-6">
					<label for="feeding_time" class="form-label fw-semibold">Feeding Time</label>
					<input
						type="time"
						step="1"
						class="form-control form-control-lg @error('feeding_time') is-invalid @enderror"
						id="feeding_time"
						name="feeding_time"
						value="{{ old('feeding_time', isset($enclosure) ? $enclosure->feeding_time : '') }}"
					/>

					@error('feeding_time')
					<div class="invalid-feedback">{{ $message }}</div>
					@enderror

					<div class="mt-1">Set the daily feeding time for the animals.</div>
				</div>

				<!-- Caretaker Selection (Only for Edit) -->
				@if(isset($enclosure))
					<div class="col-md-6 d-flex justify-content-center align-items-center">
						<button type="button" class="btn btn-primary" data-bs-toggle="modal"
								data-bs-target="#caretakersModal">
							Select Caretakers
						</button>
					</div>

					<!-- Modal for selecting caretakers -->
					<div class="modal fade" id="caretakersModal" tabindex="-1" aria-labelledby="caretakersModalLabel"
						 aria-hidden="true">
						<div class="modal-dialog">
							<div class="modal-content">
								<div class="modal-header">
									<h5 class="modal-title" id="caretakersModalLabel">Assign Caretakers</h5>
									<button type="button" class="btn-close" data-bs-dismiss="modal"
											aria-label="Close"></button>
								</div>
								<div class="modal-body">
									@foreach($caretakers as $user)
										<div class="form-check">
											<input
												class="form-check-input"
												type="checkbox"
												name="caretakers[]"
												value="{{ $user->id }}"
												id="caretaker{{ $user->id }}"
												@if(in_array($user->id, $assignedCaretakers ?? [])) checked @endif
											/>
											<label class="form-check-label" for="caretaker{{ $user->id }}">
												{{ $user->name }}
											</label>
										</div>
									@endforeach
								</div>
								<div class="modal-footer">
									<button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
								</div>
							</div>
						</div>
					</div>
				@endif
			</div>

			<!-- Submit Button -->
			<div class="text-center mt-4">
				<button type="submit" class="btn btn-primary btn-lg px-5 py-2 fw-semibold">
					{{ isset($enclosure) ? 'Edit Enclosure' : 'Create Enclosure' }}
				</button>
			</div>
		</form>
	</div>
@endsection
