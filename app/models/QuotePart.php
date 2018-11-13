<?php

class QuotePart extends Eloquent {


	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'quote_parts';

	public $timestamps = false;
	protected $guarded = array();

	/**
	* ID of the quote associated with this part
	*
	* @var int
	*/
	protected $quote_id;

	/**
	* Part Number
	*
	* @var string
	*/
	protected $number;

	/**
	* Part Quantity
	*
	* @var string
	*/
	protected $quantity;

	/**
	* Description
	*
	* @var string
	*/
	protected $description;

	/**
	* Currently stocked
	*
	* @var string
	*/
	protected $stocked;

	/**
	* Price
	*
	* @var decimal
	*/
	protected $price;

	/**
	* U/M
 	*
	* @var string
	*/
	protected $unit;

	public function quote() {
		return $this->hasOne('quote');
	}

	public function company() {
		return $this->belongsTo('Company');
	}

	public function quotes() {
		return $this->hasMany('Quote', 'quote_id');
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