<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Configuration extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'Configuration';

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = array();

}

?>