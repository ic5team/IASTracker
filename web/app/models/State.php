<?php

class State extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'States';

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = array();

	public function scopeActive($query, $isActive)
	{

		return $query->where('States.isActive', '=', $isActive);

	}

	public function scopeOrdered($query)
	{

		return $query->orderBy('States.name', 'ASC');

	}

}

?>