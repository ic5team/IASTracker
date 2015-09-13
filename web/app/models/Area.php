<?php

class Area extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'Areas';

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = array();

	public function scopeStateId($query, $stateId)
	{

		return $query->join('StateAreas', 'areaId', '=', 'Areas.id')
			->where('StateAreas.stateId', '=', $stateId);

	}

	public function scopeRegionId($query, $regionId)
	{

		return $query->join('RegionAreas', 'areaId', '=', 'Areas.id')
			->where('RegionAreas.regionId', '=', $regionId);

	}

	public function scopeOrdered($query)
	{

		return $query->orderBy('Areas.name', 'ASC');

	}

}

?>