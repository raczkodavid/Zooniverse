<?php

namespace App\Http\Controllers;

use App\Models\Animal;
use App\Models\Enclosure;
use Illuminate\Http\Request;
use Storage;

class AnimalController extends Controller
{
	/**
	 * Show the form for creating a new resource.
	 */
	public function create()
	{
		$enclosures = Enclosure::all();
		return view('zoo.animal_form', compact('enclosures'));
	}

	/**
	 * Store a newly created resource in storage.
	 */
	public function store(Request $request)
	{
		$validated = $request->validate([
			'name' => 'required|string',
			'species' => 'required|string',
			'type' => 'required|in:predator,herbivore',
			'born_at' => 'required|date|before:now|after:01-01-1900',
			'enclosure_id' => 'required|exists:enclosures,id',
		]);


		// validate whether the selected enclosure is predator enclosure or not
		$enclosure = Enclosure::find($request->enclosure_id);
		$isPredator = $request->type == 'predator';

		// the null value indicates that both types of animals can be in the enclosure
		if ($enclosure->isPredatorEnclosure() !== null && $isPredator !== $enclosure->isPredatorEnclosure()) {
			return redirect()
				->back()
				->withErrors(['enclosure_id' => 'The selected enclosure is not compatible with the animal type.'])
				->withInput();
		}

		// check if the enclosure is full
		if ($enclosure->isFull())
			return redirect()
				->back()
				->withErrors(['enclosure_id' => 'The selected enclosure is full.'])
				->withInput();

		// check if an image has been uploaded
		// if so store it in public storage with hashed name
		// in the database store the uploaded name and the hashed name
		$imageName = null;
		$imageHash = null;

		if ($request->hasFile('image')) {
			$image = $request->file('image');
			$imageName = $image->getClientOriginalName();
			$imageHash = $image->hashName();
			$image->storeAs('images', $imageHash, 'public');
		}

		// create the animal with factory
		Animal::create([
			'name' => $validated['name'],
			'species' => $validated['species'],
			'is_predator' => $validated['type'] === 'predator',
			'born_at' => $validated['born_at'],
			'enclosure_id' => $validated['enclosure_id'],
			'image_name' => $imageName,
			'image_name_hash' => $imageHash,
		]);

		// redirect to the enclosure page where the animal was added
		return redirect()->route('enclosures.show', $enclosure->id);
	}

	/**
	 * Show the form for editing the specified resource.
	 */
	public function edit(string $id)
	{
		$animal = Animal::findOrFail($id);
		$enclosures = Enclosure::all();

		return view('zoo.animal_form', compact('animal', 'enclosures'));
	}

	/**
	 * Update the specified resource in storage.
	 */
	public function update(Request $request, string $id)
	{
		// Validate the request
		$validated = $request->validate([
			'name' => 'required|string',
			'species' => 'required|string',
			'type' => 'required|in:predator,herbivore',
			'born_at' => 'required|date|before:now|after:01-01-1900',
			'enclosure_id' => 'required|exists:enclosures,id',
		]);

		// Find the animal by ID
		$animal = Animal::findOrFail($id);

		// Check if the selected enclosure is compatible with the animal type
		$enclosure = Enclosure::find($request->enclosure_id);

		$isPredator = $validated['type'] == 'predator';

		// check if the selected enclosure is compatible with the animal type
		if ($enclosure->isPredatorEnclosure() !== null && $isPredator != $enclosure->isPredatorEnclosure())
			return redirect()
				->back()
				->withErrors(['enclosure_id' => 'The selected enclosure is not compatible with the animal type.'])
				->withInput();

		// Check if the selected enclosure is full
		if ($enclosure->isFull())
			return redirect()
				->back()
				->withErrors(['enclosure_id' => 'The selected enclosure is full.'])
				->withInput();


		$imageName = $animal->image_name;
		$imageHash = $animal->image_name_hash;

		// Check if a new image is uploaded
		if ($request->hasFile('image')) {
			// If a new image is uploaded, delete the old image from storage
			if ($imageName && $imageHash)
				Storage::disk('public')->delete('images/' . $imageHash);

			// Handle the new image
			$image = $request->file('image');
			$imageName = $image->getClientOriginalName();
			$imageHash = $image->hashName();
			$image->storeAs('images', $imageHash, 'public');
		}

		// Update the animal with validated data
		$animal->update([
			'name' => $validated['name'],
			'species' => $validated['species'],
			'is_predator' => $validated['type'] === 'predator',
			'born_at' => $validated['born_at'],
			'enclosure_id' => $validated['enclosure_id'],
			'image_name' => $imageName,
			'image_name_hash' => $imageHash,
		]);

		// Redirect to the animal's page in the corresponding enclosure
		return redirect()->route('enclosures.show', $animal->enclosure_id);
	}

	/**
	 * Remove the specified resource from storage.
	 */
	public function destroy(string $id)
	{
		$animal = Animal::findOrFail($id);

		$animal->enclosure_id = null;
		$animal->save();

		// soft delete
		$animal->delete();

		return redirect()->back();
	}

	public function restore(Request $request, string $id)
	{
		$animal = Animal::onlyTrashed()->findOrFail($id);

		// check if the selected animal is compatible with the selected enclosure
		$enclosure = Enclosure::find($request->enclosure_id);

		if (!$animal->isCompatibleWithEnclosure($enclosure))
			return redirect()->back()->withErrors(['enclosure_id' => 'The selected enclosure is not compatible with the animal type.']);

		if ($enclosure->isFull())
			return redirect()->back()->withErrors(['enclosure_id' => 'The selected enclosure is full.']);

		$animal->enclosure_id = $request->enclosure_id;
		$animal->restore();

		return redirect()->back();
	}

	public function archived()
	{
		$archivedAnimals = Animal::onlyTrashed()->get()->sortByDesc('deleted_at');
		$enclosures = Enclosure::all();
		return view('zoo.show_archived_animals', compact('archivedAnimals', 'enclosures'));
	}
}
