<?php

class Status extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'Status';

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = array();

	public function getDescription($languageId, $defaultLanguageId)
	{

		$iasDesc = StatusText::withStatusAndLanguageId(
			$this->id, $languageId)->first();
		if(null == $iasDesc)
		{

			$iasDesc = StatusText::withStatusAndLanguageId(
				$this->id, $defaultLanguageId)->first();

		}

	}

}

?>