<?php

class PackageContent
 extends Eloquent {


	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'package_contents';

	public $timestamps = false;
	protected $guarded = array();

	public function package() {
		return $this->belongsTo('Package');
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
