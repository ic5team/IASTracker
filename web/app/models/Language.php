<?php

class Language extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'Languages';
	protected $softDelete = true;

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = array();

	public function scopeLocale($query, $locale)
    {

        return $query->where('locale', '=', $locale);
        
    }

    public function scopeIdAscending($query)
    {

		return $query->orderBy('id','ASC');

	}

}

?>