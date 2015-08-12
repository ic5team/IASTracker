<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class ConfigurationTexts extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'ConfigurationTexts';

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = array();

	public function scopeLanguage($query, $languageId)
    {

        return $query->where('languageId', '=', $languageId);
        
    }

}

?>