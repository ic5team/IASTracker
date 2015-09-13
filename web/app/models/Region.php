<?php

class Region extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'regions';

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = array();

	public function scopeActive($query, $isActive)
	{

		return $query->where('regions.isActive', '=', $isActive);

	}

	public function scopeStateId($query, $stateId)
	{

		return $query->where('regions.stateId', '=', $stateId);

	}

	public function scopeOrdered($query)
	{

		return $query->orderBy('regions.name', 'ASC');

	}

}

?>