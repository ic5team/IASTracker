<?php

class StateArea extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'StateAreas';

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = array();

	public function scopeWithStateId($query, $stateId)
	{

		return $query->where('StateAreas.stateId', '=', $stateId);

	}

}

?>