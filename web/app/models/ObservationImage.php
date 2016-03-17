<?php

class ObservationImage extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'ObservationImages';
	protected $fillable = array('observationId', 'URL');


	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = array();

	public function scopeWithUserId($query, $userId)
	{

		return $query->join('observations', 'ObservationImages.observationId', 
			'=', 'observations.id')->where('userId', '=', $userId)->orderBy('ObservationImages.created_at', 'DESC');

	}

	public function scopeWithObservationId($query, $obsId)
	{

		return $query->where('observationId', '=', $obsId);

	}

}

?>