<?php

class Observation extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'Observations';

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = array();

	public function scopeWithUserId($query, $userId)
	{

		return $query->where('Observations.userId', '=', $userId);

	}

	public function scopeWithIASId($query, $userId)
	{

		return $query->where('Observations.IASId', '=', $userId);

	}

	public function scopeValidated($query)
	{

		return $query->where('Observations.validatorId', '!=', 'null');

	}

	public function scopeLastCreated($query)
	{

		return $query->orderBy('created_at', 'desc')->take(1);

	}

	public function IAS()
	{

		return $this->hasOne('IAS','id', 'IASId');

	}

	public function user()
	{

		return $this->hasOne('User', 'id', 'userId');

	}

	public function observationImages()
	{

		return $this->hasMany('ObservationImage', 'observationId', 'id');

	}

	public function getStatus($languageId, $defaultLanguageId)
	{

		$status = Status::find($this->statusId);
		$status->text = $status->getDescription($languageId, $defaultLanguageId);
		return $status;

	}

	public function scopeFiltered($query, $taxonomyId, $fromDate, $toDate,
			$areaIds)
	{

		$newQuery = $query;
		if(-1 != $taxonomyId)
			$newQuery = $query->join('IAS', 'IASId', '=', 'IAS.id')->where('IAS.taxonId', '=', $taxonomyId);

		$newQuery = $newQuery->where('Observations.created_at', '>=', $fromDate.' 00:00:00');
		$newQuery = $newQuery->where('Observations.created_at', '<=', $toDate.' 23:59:59');

		if(0 != count($areaIds))
		{

			$newQuery = $newQuery->whereIn('areaId', $areaIds);

		}

		return $newQuery->select('Observations.*');

	}

}

?>