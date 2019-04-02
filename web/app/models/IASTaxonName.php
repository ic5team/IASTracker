<?php

class IASTaxonName extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'IASTaxonNames';

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

	public function scopeLastUpdated($query)
	{

		return $query->orderBy('updated_at', 'DESC');

	}

}

?>