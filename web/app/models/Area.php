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

	public function scopeWithDataTableRequest($query, $search, $orders, $columns)
	{

		return $query->whereRaw('lower("name") LIKE lower(\'%'.$search['value'].'%\')')->orderBy($columns[$orders[0]['column']]['data'], $orders[0]['dir']);

	}

	public static function recomputeIntersections()
	{

		DB::statement('DELETE FROM "RegionAreas";');
		DB::statement('DELETE FROM "StateAreas";');
		DB::statement('INSERT INTO "RegionAreas"("areaId", "regionId", "created_at", "updated_at") SELECT a.id, r.id, NOW()::timestamp(0), NOW()::timestamp(0) FROM "Areas" a, "regions" r WHERE ST_Intersects(a.geom, r.geom) AND a.id != 100;');
		DB::statement('INSERT INTO "StateAreas"("areaId", "stateId", "created_at", "updated_at") SELECT a.id, s.id, NOW()::timestamp(0), NOW()::timestamp(0) FROM "Areas" a, "States" s WHERE ST_Intersects(a.geom, s.geom) AND a.id != 100;');

	}

}

?>