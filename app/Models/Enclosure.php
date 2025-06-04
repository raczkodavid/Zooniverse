<?php

namespace App\Models;

use Database\Factories\EnclosureFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Enclosure extends Model
{
	/** @use HasFactory<EnclosureFactory> */
	use HasFactory;

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var list<string>
	 */
	protected $fillable = [
		'name',
		'limit',
		'feeding_time',
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
			'limit' => 'integer',
		];
	}

	// get all the associated animals
	public function animals(): HasMany
	{
		return $this->hasMany(Animal::class);
	}

	// get all the associated users
	public function users(): BelongsToMany
	{
		return $this->belongsToMany(User::class)->withTimestamps();
	}

	public function isPredatorEnclosure(): ?bool
	{
		if ($this->animals->isEmpty())
			return null; // indicate that both types of animals can be placed

		return $this->animals->first()->is_predator;
	}

	public function isFull(): bool
	{
		return $this->animals->count() >= $this->limit;
	}
}
