<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class User extends Eloquent implements UserInterface, RemindableInterface {

	use UserTrait, RemindableTrait;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'Users';
	protected $softDelete = true;

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

	public function getLastObservationTS()
	{

		return Observation::withUserId($this->id)->lastCreated()->get();

	}

	public function getObservationImages()
	{

		return ObservationImage::withUserId($this->id)->get();

	}

}
