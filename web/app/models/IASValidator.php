<?php

class IASValidator extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'IASValidators';

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = array();

	public function scopeWithValidatorId($query, $id)
	{

		return $query->where('validatorId', $id);

	}

	public function scopeWithIASId($query, $id)
	{

		return $query->where('IASId', $id);

	}

	public function scopeWithIASAndValidatorId($query, $IASId, $validatorId)
	{

		return $query->where('IASId', $IASId)->where('validatorId', $validatorId);

	}

}

?>