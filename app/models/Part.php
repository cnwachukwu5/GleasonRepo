<?php

class Part extends Eloquent {


	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'parts';

	public $timestamps = false;
	protected $guarded = array();

	/**
	* Part Number
	*
	* @var string
	*/
	public $number;

	/**
	* Description
	*
	* @var string
	*/
	public $description;


	/**
	* Currently stocked
	*
	* @var string
	*/
	public $stocked;

	/**
	* Price
	*
	* @var decimal
	*/
	public $price;

	/**
	* U/M
	* I'm not actually sure what this parameter is. 
	*
	* @var string
	*/
	public $unit;


	/**
	* plc
	*
	* @var int
	*/
	public $plc;

	/*
	Does part belong to something? 
	public function company() {
		return $this->belongsTo('Company');
	}*/


}