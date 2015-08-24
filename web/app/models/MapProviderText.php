<?php

class MapProviderText extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'MapProviderTexts';

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = array();

	public function scopeWithMapAndLanguageId($query, $mapId, $languageId)
	{

		return $query->where('mapProviderId', '=', $mapId)
			->where('languageId', '=', $languageId);

	}

}

?>