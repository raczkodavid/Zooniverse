<?php

namespace App\Http\Controllers;

use App\Models\Animal;
use App\Models\Enclosure;
use Carbon\Carbon;

class HomeController extends Controller
{
	public function index()
	{
		// number of enclosures
		$enclosureCount = count(Enclosure::all());

		// number of animals
		$animalCount = count(Animal::all());

		// Get the current time in 'Europe/Budapest' timezone
		$now = Carbon::now('Europe/Budapest');

		// Get the enclosures associated with the authenticated user, filter and sort
		$enclosures = auth()->user()->enclosures
			->filter(function ($enclosure) use ($now) {
				return Carbon::parse($enclosure->feeding_time, 'Europe/Budapest')->isAfter($now);
			})
			->sortBy(function ($enclosure) {
				return Carbon::parse($enclosure->feeding_time, 'Europe/Budapest');
			});

		// return the view with the data
		return view('zoo.homepage', compact('enclosureCount', 'animalCount', 'enclosures'));
	}
}
