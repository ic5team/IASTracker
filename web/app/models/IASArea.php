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

	public function scopeAreasByIAS($query, $ias)
	{

		return $query->where('IASId', '=', $ias)->orderBy('orderId', 'DESC');

	}

	public function scopeWithIASAndAreaId($query, $ias, $area)
	{

		return $query->where('IASId', '=', $ias)
			->where('areaId', '=', $area)
			->orderBy('orderId', 'DESC');

	}

	public function scopeLastUpdated($query)
	{

		return $query->orderBy('updated_at', 'DESC');

	}

}

?>