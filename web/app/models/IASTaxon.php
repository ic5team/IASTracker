<?php

class IASTaxon extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'IASTaxons';

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = array();

	public function scopeWithLanguageId($query, $languageId)
	{

		return $query->where('languageId', '=', $languageId);
        
	}

}

?>