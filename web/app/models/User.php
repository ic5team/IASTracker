<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;


class User extends Eloquent implements UserInterface, RemindableInterface {

    use UserTrait, RemindableTrait, SoftDeletingTrait;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'Users';
	protected $softDelete = true;
	protected $fillable = array('languageId', 'mail', 'isActive', 'activationKey', 
		'amIExpert', 'isExpert', 'isAdmin', 'lastConnection');
	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = array('password', 'remember_token');

	public function getObservationsNumber()
	{

		return Observation::withUserId($this->id)->count();

	}

	public function getValidatedNumber()
	{

		return Observation::withUserId($this->id)->validated()->count();

	}

	public function getLastObservation()
	{

		return Observation::withUserId($this->id)->lastCreated()->get();

	}

	public function getObservationImages()
	{

		return ObservationImage::withUserId($this->id)->get();

	}

	public function getObservedIAS($languageId, $defaultLanguageId)
	{

		$data = array();
		$ias = IAS::withUserId($this->id)->get();
		for($i=0; $i<count($ias); ++$i)
		{

			$current = $ias[$i];
			$obj = new stdClass();

			$obj->image = $current->getDefaultImageData($languageId, $defaultLanguageId);
			$obj->name = $current->getDescriptionData($languageId, $defaultLanguageId)->name;
			$obj->id = $current->id;


			$data[] = $obj;

		}

		unset($ias);

		return $data;

	}

	function scopeActivationKey($query, $token)
	{

		return $query->where('Users.activationKey', '=', $token);

	}

	function scopeNickname($query, $nick)
	{

		return $query->where('Users.username', '=', $nick);

	}

	function scopeEmail($query, $email)
	{

		return $query->where('Users.mail', '=', $email);

	}

	function scopeResetKey($query, $reset)
	{

		return $query->where('Users.resetKey', '=', $reset);

	}

	function scopeUserToken($query, $token)
	{

		return $query->where('Users.appKey', '=', $token);

	}

	function scopeIdDESC($query)
	{

		return $query->orderBy('id', 'DESC');

	}

	function scopeWithDataTableRequest($query, $search, $orders, $columns)
	{

		return $query->whereRaw('lower("fullName") LIKE lower(\'%'.$search['value'].'%\')')->orderBy($columns[$orders[0]['column']]['data'], $orders[0]['dir']);

	}

}
