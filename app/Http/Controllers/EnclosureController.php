<?php

namespace App\Http\Controllers;

use App\Models\Enclosure;
use App\Models\User;
use Illuminate\Http\Request;

class EnclosureController extends Controller
{
	/**
	 * Display a listing of the resource.
	 */
	public function index()
	{
		// for admins, list all enclosures, for caretakers, only their own
		$isAdmin = auth()->user()->admin;
		$enclosures = $isAdmin
			? Enclosure::orderBy('name')->paginate(5)
			: auth()->user()->enclosures()->orderBy('name')->paginate(5);

		// pass the paginated result to the view
		return view('zoo.list_enclosures', compact('enclosures', 'isAdmin'));
	}

	/**
	 * Show the form for creating a new resource.
	 */
	public function create()
	{
		return view('zoo.enclosure_form');
	}

	/**
	 * Store a newly created resource in storage.
	 */
	public function store(Request $request)
	{
		// validate the request
		$request->validate([
			'name' => 'required',
			'limit' => 'required|integer|min:1',
			'feeding_time' => 'required|date_format:H:i:s',
		]);

		// create the enclosure
		Enclosure::create([
			'name' => $request->name,
			'limit' => $request->limit,
			'feeding_time' => $request->feeding_time,
		]);

		return redirect()->route('enclosures.index');
	}

	/**
	 * Display the specified resource.
	 */
	public function show(string $id)
	{
		$enclosure = Enclosure::findOrFail($id);
		$animals = $enclosure->animals;

		// sort the animals by species then born_at
		$animals = $animals->sortBy([
			['species', 'asc'],
			['born_at', 'asc'],
		]);

		$isAdmin = auth()->user()->admin;
		return view('zoo.show_enclosure', compact('enclosure', 'animals', 'isAdmin'));
	}

	/**
	 * Show the form for editing the specified resource.
	 */
	public function edit($id)
	{
		$enclosure = Enclosure::findOrFail($id);
		$caretakers = User::all();
		// pluck: get the values of a given key
		$assignedCaretakers = $enclosure->users->pluck('id')->toArray();

		return view('zoo.enclosure_form', compact('enclosure', 'caretakers', 'assignedCaretakers'));
	}

	/**
	 * Update the specified resource in storage.
	 */
	public function update(Request $request, string $id)
	{
		$enclosure = Enclosure::findOrFail($id);

		// validate the request
		$request->validate([
			'name' => 'required|string',
			'limit' => 'required|integer|min:' . max(1, $enclosure->animals->count()),
			'feeding_time' => 'required',
		]);

		// update the enclosure
		$enclosure->update([
			'name' => $request->name,
			'limit' => $request->limit,
			'feeding_time' => $request->feeding_time,
		]);

		// sync the caretakers
		$enclosure->users()->sync($request->caretakers);

		return redirect()->route('enclosures.index');
	}

	/**
	 * Remove the specified resource from storage.
	 */
	public function destroy(string $id)
	{
		$enclosure = Enclosure::findOrFail($id);
		// check if the enclosure is empty
		if ($enclosure->animals->count() > 0) {
			return redirect()->back()->withErrors(
				['enclosure_id' => 'The selected enclosure is not empty.
                Please remove all animals before deleting the enclosure.
                Enclosure Name: ' . $enclosure->name . ', Animal Count: ' . $enclosure->animals->count()]
			);
		}

		// delete stuff from pivot table
		$enclosure->users()->detach();

		$enclosure->delete();

		return redirect()->route('enclosures.index');
	}
}
