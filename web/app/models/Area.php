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
			->where('StateAreas.stateId', '=', $stateId)
			->select('Areas.*');

	}

	public function scopeRegionId($query, $regionId)
	{

		return $query->join('RegionAreas', 'areaId', '=', 'Areas.id')
			->where('RegionAreas.regionId', '=', $regionId)
			->select('Areas.*');

	}

	public function scopeOrdered($query)
	{

		return $query->orderBy('Areas.name', 'ASC');

	}

	public function scopeZOrder($query)
	{

		return $query->orderBy('Areas.zIndex', 'ASC');

	}

	public static function getAreaContains($latitude, $longitude)
	{

		return DB::select('SELECT id FROM "Areas" WHERE ST_Intersects(ST_SetSRID(ST_MakePoint(?, ?), 4326), geom) ORDER BY "zIndex" DESC', 
			array($longitude, $latitude));

	}

}

?>