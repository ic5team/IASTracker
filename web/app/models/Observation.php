<?php

class Observation extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'Observations';

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = array();

	public function scopeWithUserId($query, $userId)
	{

		return $query->where('userId', '=', $userId);

	}

	public function scopeValidated($query)
	{

		return $query->where('validatorId', '!=', 'null');

	}

	public function scopeLastCreated($query)
	{

		return $query->orderBy('created_at', 'desc')->take(1);

	}

}

?>