<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class IAS extends Eloquent {

	use SoftDeletingTrait;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'IAS';

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = array('creatorId', 'created_at', 'updated_at');

}

?>