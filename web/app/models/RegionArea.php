<?php

class RegionArea extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'RegionAreas';

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = array();

	public function scopeWithRegionId($query, $regionId)
	{

		return $query->where('RegionAreas.regionId', '=', $regionId);

	}

}

?>