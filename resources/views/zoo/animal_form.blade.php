@extends('zoo.layout')

@section('title', isset($animal) ? 'Edit Animal' : 'Create Animal')

@section('content')
	<div class="container py-3">
		<h1 class="text-center display-3 mb-4 fw-bold">
			{{ isset($animal) ? 'Edit Animal' : 'Create Animal' }}
		</h1>

		@error('enclosure_id')
		<div class="alert alert-danger text-center">
			{{ $message }}
		</div>
		@enderror

		<form action="{{ isset($animal) ? route('animals.update', $animal->id) : route('animals.store') }}"
			  method="POST"
			  class="p-4 p-lg-5 rounded-4 shadow-sm"
			  enctype="multipart/form-data">
			@csrf
			@if(isset($animal))
				@method('PUT')
			@endif

			<div class="row g-4">
				<!-- Name -->
				<div class="col-md-6">
					<label for="name" class="form-label fw-semibold">Name</label>
					<input type="text" class="form-control form-control-lg @error('name') is-invalid @enderror"
						   id="name" name="name" placeholder="Enter the animal's name"
						   value="{{ old('name', isset($animal) ? $animal->name : '') }}"/>
					@error('name')
					<span class="invalid-feedback">{{ $message }}</span>
					@enderror
				</div>

				<!-- Species -->
				<div class="col-md-6">
					<label for="species" class="form-label fw-semibold">Species</label>
					<input type="text" class="form-control form-control-lg @error('species') is-invalid @enderror"
						   id="species" name="species" placeholder="Enter the species"
						   value="{{ old('species', isset($animal) ? $animal->species : '') }}"/>
					@error('species')
					<span class="invalid-feedback">{{ $message }}</span>
					@enderror
				</div>

				<!-- Animal Type -->
				<div class="col-md-6">
					<label for="type" class="form-label fw-semibold">Animal type</label>
					<select class="form-select form-select-lg @error('type') is-invalid @enderror" id="type"
							name="type">
						<option value=""
								disabled {{ old('type', isset($animal) ? ($animal->is_predator ? 'predator' : 'herbivore') : '') == '' ? 'selected' : '' }}>
							Select animal type
						</option>
						<option value="predator"
							@selected(old('type', isset($animal) ? ($animal->is_predator ? 'predator' : 'herbivore') : '') == 'predator')>
							Predator
						</option>
						<option value="herbivore"
							@selected(old('type', isset($animal) ? ($animal->is_predator ? 'predator' : 'herbivore') : '') == 'herbivore')>
							Herbivore
						</option>
					</select>
					@error('type')
					<span class="invalid-feedback">{{ $message }}</span>
					@enderror
				</div>


				<!-- Born At -->
				<div class="col-md-6">
					<label for="born_at" class="form-label fw-semibold">Born At</label>
					<input type="datetime-local" step="1"
						   class="form-control form-control-lg @error('born_at') is-invalid @enderror"
						   id="born_at" name="born_at"
						   value="{{ old('born_at', isset($animal) ? $animal->born_at : '') }}"/>
					@error('born_at')
					<span class="invalid-feedback">{{ $message }}</span>
					@enderror
				</div>

				<!-- Image -->
				<div class="col-md-12">
					<label for="image" class="form-label fw-semibold">Image</label>
					<input type="file" class="form-control form-control-lg @error('image') is-invalid @enderror"
						   id="image" name="image" accept="image/*"/>
					@error('image')
					<span class="invalid-feedback">{{ $message }}</span>
					@enderror
				</div>
			</div>

			<!-- Modal for Enclosure Selection -->
			<div class="modal fade" id="enclosureModal" tabindex="-1" aria-labelledby="enclosureModalLabel"
				 aria-hidden="true">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title" id="enclosureModalLabel">Choose an Enclosure</h5>
							<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
						</div>
						<div class="modal-body">
							<div class="mb-3">
								<select class="form-select @error('enclosure_id') is-invalid @enderror"
										id="enclosure_id" name="enclosure_id">
									<option value="" disabled>Select an enclosure</option>
									@foreach($enclosures as $enclosure)
										<option value="{{ $enclosure->id }}"
												@selected(old('enclosure_id', isset($animal) ? $animal->enclosure_id : '') == $enclosure->id)
												class="{{ $enclosure->isPredatorEnclosure() === null ? 'bg-success text-white' : ($enclosure->isPredatorEnclosure() ? 'bg-danger text-white' : '')
 }}">
											{{ $enclosure->name }}
											@if($enclosure->isPredatorEnclosure())
												<span class="ms-2">🐯</span>
											@endif
										</option>
									@endforeach
								</select>
								@error('enclosure_id')
								<span class="invalid-feedback">{{ $message }}</span>
								@enderror
							</div>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
							<button type="button" class="btn btn-primary">Save Enclosure</button>
						</div>
					</div>
				</div>
			</div>

			<!-- Button Group -->
			<div class="text-center mt-4 d-flex justify-content-center gap-3">
				<button type="button"
						class="btn btn-success btn-lg px-lg-5 py-lg-2 px-md-4 py-md-1 fs-5 fs-md-6 fw-semibold"
						data-bs-toggle="modal"
						data-bs-target="#enclosureModal">
					Select Enclosure
				</button>
				<button type="submit"
						class="btn btn-primary btn-lg px-lg-5 py-lg-2 px-md-4 py-md-1 fs-5 fs-md-6 fw-semibold">
					{{ isset($animal) ? 'Edit Animal' : 'Create Animal' }}
				</button>
			</div>
		</form>
	</div>
@endsection
