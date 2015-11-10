<?php

class Observation extends Eloquent {

	use SoftDeletingTrait;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'observations';
	protected $softDelete = true;
	protected $fillable = array('IASId','userId', 'languageId',
				'statusId', 'notes', 'latitude', 'longitude',
				'elevation', 'accuracy', 'howMany');

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = array();

	public function scopeWithUserId($query, $userId)
	{

		return $query->where('observations.userId', '=', $userId);

	}

	public function scopeWithIASId($query, $userId)
	{

		return $query->where('observations.IASId', '=', $userId);

	}

	public function scopeValidated($query)
	{

		return $query->whereNotNull('observations.validatorId');

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

	public function scopeFiltered($query, $taxonsId, $fromDate, $toDate,
			$areaIds)
	{

		$newQuery = $query;
		if(0 != count($taxonsId))
			$newQuery = $query->join('IAS', 'IASId', '=', 'IAS.id')->whereIn('IAS.taxonId', $taxonsId);

		$newQuery = $newQuery->where('observations.created_at', '>=', $fromDate.' 00:00:00');
		$newQuery = $newQuery->where('observations.created_at', '<=', $toDate.' 23:59:59');

		if(0 != count($areaIds))
		{

			$newQuery = $newQuery->join('ObservationAreas', 'observations.id', '=', 'ObservationAreas.observationId')
				->whereIn('ObservationAreas.areaId', $areaIds);

		}

		return $newQuery->select('observations.*')->distinct();

	}

	public function scopeStatus($query, $status)
	{

		return $query->where('statusId', '=', $status);

	}

	public function scopeAreas($query, $areas)
	{

		return $query->join('ObservationAreas', 'observations.id', '=', 'ObservationAreas.observationId')
			->whereIn('ObservationAreas.areaId', $areas);

	}

	public function scopeWithDataTableRequest($query, $search, $orders, $columns)
	{

		return $query->join('IAS', 'IASId', '=', 'IAS.id')			
			->join('Status', 'statusId', '=', 'Status.id')
			->leftJoin('Users', 'userId', '=', 'Users.id')
			->whereRaw('((lower("latinName") LIKE lower(\'%'.$search['value'].'%\')) OR (lower("fullName") LIKE lower(\'%'.$search['value'].'%\')))')
			->orderBy($columns[$orders[0]['column']]['data'], $orders[0]['dir'])->select('observations.*', 'Users.fullName', 'IAS.latinName', 'Status.icon', 'Status.id AS statusIdd');

	}

	public function scopeStatuses($query, $viewValidated, $viewDiscarded, $viewDeleted, $viewPending)
	{

		$status = array();
		if($viewValidated)
			$status[] = 1;

		if($viewDiscarded)
			$status[] = 3;

		if($viewPending)
			$status[] = 2;

		$query = $query->whereIn('statusId', $status);

		if($viewDeleted)
			$query = $query->withTrashed();

		return $query;


	}

}

?>