<?php

namespace App\Models;

use Database\Factories\AnimalFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Animal extends Model
{
	/** @use HasFactory<AnimalFactory> */
	use HasFactory, SoftDeletes;

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var list<string>
	 */
	protected $fillable = [
		'name',
		'species',
		'is_predator',
		'born_at',
		'image_name',
		'image_name_hash',
		'enclosure_id'
	];

	/**
	 * The attributes that should be hidden for serialization.
	 *
	 * @var list<string>
	 */
	protected $hidden = [];

	/**
	 * Get the attributes that should be cast.
	 *
	 * @return array<string, string>
	 */
	protected function casts(): array
	{
		return [
			'is_predator' => 'boolean',
			'born_at' => 'datetime',
		];
	}

	// get the associated enclosure
	public function enclosure(): BelongsTo
	{
		return $this->belongsTo(Enclosure::class);
	}

	public function getValidEnclosures()
	{
		return Enclosure::all()->filter(function ($enclosure) {
			return ($this->is_predator == $enclosure->isPredatorEnclosure() || $enclosure->isPredatorEnclosure() === null)
				&& !$enclosure->isFull();
		});
	}


	public function isCompatibleWithEnclosure(Enclosure $enclosure): bool
	{
		return $this->is_predator == $enclosure->isPredatorEnclosure() || $enclosure->isPredatorEnclosure() === null;
	}
}
