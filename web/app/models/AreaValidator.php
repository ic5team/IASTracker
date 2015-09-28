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

	public function scopeValidatorId($query, $id)
	{

		return $query->orderBy('validatorId', $id);

	}

}

?>