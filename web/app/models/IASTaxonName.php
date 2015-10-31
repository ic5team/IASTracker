<?php

class IASTaxonName extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'IASTaxonName';

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = array();

	public function scopeWithIASTaxonAndLanguageId($query, $IASTAxonId, $languageId)
	{

		return $query->where('taxonId', '=', $IASTAxonId)
			->where('languageId', '=', $languageId);

	}

}

?>