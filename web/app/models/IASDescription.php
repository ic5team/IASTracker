<?php

class IASDescription extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'IASDescriptions';

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = array();

	public function scopeWithIASAndLanguageId($query, $IASId, $languageId)
	{

		return $query->where('IASId', '=', $IASId)
			->where('languageId', '=', $languageId);
	
	}

	public function scopeLastUpdated($query)
	{

		return $query->orderBy('updated_at', 'DESC');

	}

}

?>