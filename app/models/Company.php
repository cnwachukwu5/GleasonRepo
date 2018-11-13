<?php

class Company extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'companies';

	public $timestamps = false;
	protected $guarded = array();

	/**
	* Company's name
	*
	* @var string
	*/
	public $name;

	public function customers() {
		return $this->hasMany('Customer');
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
