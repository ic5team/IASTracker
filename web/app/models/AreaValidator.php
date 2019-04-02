<?php

class AreaValidator extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'AreasValidators';

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

	public function scopeWithAreaId($query, $id)
	{

		return $query->where('areaId', $id);

	}

	public function scopeWithAreaAndValidatorId($query, $areaId, $validatorId)
	{

		return $query->where('areaId', $areaId)->where('validatorId', $validatorId);

	}

}

?>