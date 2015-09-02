<?php

class IASRelatedDB extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'IASRelatedDBs';

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

	public function repository()
	{
		return $this->hasOne('Repository', 'id', 'repoId');
	}

}

?>