<?php

class MapProvider extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'MapProvider';

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = array();

	public function scopeIdAscending($query)
	{

		return $query->orderBy('id','ASC');

	}
	
}

?>