<?php

class Customer extends Eloquent {


	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'customers';

	public $timestamps = false;

	protected $guarded = array();

	/**
	* Customer's name
	*
	* @var string
	*/
	protected $name;

	/**
	* Address line 1
	*
	* @var string
	*/
	protected $address1;

	/**
	* Address line 2
	*
	* @var string
	*/
	protected $address2;

	/**
	* Address line 3
	*
	* @var string
	*/
	protected $address3;

	/**
	* Phone number
	*
	* @var string
	*/
	protected $phone;

	/**
	* Fax number
	*
	* @var string
	*/
	protected $fax;

	/**
	* E-mail address
	*
	* @var string
	*/
	protected $email;


	public function company() {
		return $this->belongsTo('Company');
	}

	public function quotes() {
		return $this->hasMany('Quote', 'quote_id');
	}

	public function package() {
		return $this->hasMany('Package');
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
