@extends('zoo.layout')

@use('App\Models\Enclosure')

@section('title', 'Enclosures')

@section('content')

	<div class="container py-5">
		<h1 class="text-center display-3 fw-bold mb-4">Enclosures and Animals</h1>

		<!-- Display error messages if any -->
		@if ($errors->any())
			<div class="alert alert-danger">
				@foreach ($errors->all() as $error)
					<p>{{ $error }}</p>
				@endforeach
			</div>
		@endif

		<!-- Table for displaying enclosures -->
		<div class="table-responsive">
			<table class="table table-bordered table-sm">
				<thead>
				<tr>
					<th scope="col">Enclosure Name</th>
					<th scope="col">Animal Limit</th>
					<th scope="col">Current Animal Count</th>
					<th scope="col">Actions</th>
				</tr>
				</thead>
				<tbody>
				@foreach($enclosures as $enclosure)
					<tr>
						<td>{{ $enclosure->name }}</td>
						<td>{{ $enclosure->limit }}</td>
						<td>{{ $enclosure->animals()->count() }}</td>
						<td>
							<div class="d-none d-md-block">
								<div class="btn-group" role="group" aria-label="Actions">
									<a class="btn btn-info btn-sm"
									   href="{{ route('enclosures.show', $enclosure->id) }}">Show</a>
									@if($isAdmin)
										<a class="btn btn-warning btn-sm"
										   href="{{ route('enclosures.edit', $enclosure->id) }}">Edit</a>

										<!-- Form for Deleting -->
										<form action="{{ route('enclosures.destroy', $enclosure->id) }}" method="POST"
											  class="d-inline">
											@csrf
											@method('DELETE')
											<input type="hidden" name="enclosure_id" value="{{ $enclosure->id }}">
											<button type="submit" class="btn btn-danger btn-sm">
												Delete
											</button>
										</form>
									@endif
								</div>
							</div>

							<!-- Mobile devices -->
							<div class="d-md-none mt-2">
								<a class="btn btn-info btn-sm w-100 mb-1"
								   href="{{ route('enclosures.show', $enclosure->id) }}">Show</a>
								@if($isAdmin)
									<a class="btn btn-warning btn-sm w-100 mb-1"
									   href="{{ route('enclosures.edit', $enclosure->id) }}">Edit</a>

									<!-- Form for Deleting -->
									<form action="{{ route('enclosures.destroy', $enclosure->id) }}" method="POST">
										@csrf
										@method('DELETE')
										<input type="hidden" name="enclosure_id" value="{{ $enclosure->id }}">
										<button type="submit" class="btn btn-danger btn-sm w-100"
												onclick="return confirm('Are you sure?')">
											Delete
										</button>
									</form>
								@endif
							</div>
						</td>
					</tr>
				@endforeach
				</tbody>
			</table>
			<!-- Display the pagination links -->
			{{ $enclosures->links('pagination::bootstrap-5') }}
		</div>
	</div>

@endsection
