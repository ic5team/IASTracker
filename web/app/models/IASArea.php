<?php

class IASArea extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'IASAreas';

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = array();

	public function scopeIASByArea($query, $area)
	{

		return $query->where('areaId', '=', $area)->orderBy('orderId', 'DESC');

	}

}

?>