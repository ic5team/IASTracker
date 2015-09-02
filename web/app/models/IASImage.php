<?php

class IASImage extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'IASImages';

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = array();

	public function scopeWithIASId($query, $IASId)
	{

		return $query->where('IASId', '=', $IASId);

	}

}

?>