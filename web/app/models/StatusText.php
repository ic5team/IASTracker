<?php

class StatusText extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'StatusTexts';

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = array();

	public function scopeWithStatusAndLanguageId($query, $statusId, $languageId)
	{

		return $query->where('statusId', '=', $statusId)
			->where('languageId', '=', $languageId);
	
	}

}

?>