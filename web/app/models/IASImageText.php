<?php

class IASImageText extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'IASImagesTexts';

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = array();

	public function scopeWithIASImageAndLanguageId($query, $IASIId, $languageId)
	{

		return $query->where('IASIId', '=', $IASIId)
			->where('languageId', '=', $languageId);

	}

	public function scopeLastUpdated($query)
	{

		return $query->orderBy('updated_at', 'DESC');

	}

}

?>