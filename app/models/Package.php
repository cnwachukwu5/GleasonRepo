<?php

class Package extends Eloquent {


	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'packages';

	public $timestamps = false;
	protected $guarded = array();

	/**
	* Name of Package
	*
	* @var string
	*/
	public $name;


	public function customer()
	{
		return $this->belongsTo('Customer');
	}

	public function packageContent() {
		return $this->hasMany('PackageContent');
	}


	public function __get($key)
	{
		return $this->attributes[$key];
	}

	public function __set($key, $value)
	{
		$this->attributes[$key] = $value;
	}

	public function __isset($key)
	{
		return isset($this->attributes[$key]);
	}

	public function __unset($key)
	{
		unset($this->attributes[$key]);
	}

}
