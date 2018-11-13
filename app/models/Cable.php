<?php

class Cable extends Eloquent {


	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'cable';

	public $timestamps = false;
	protected $guarded = array();

	/**
	* id
	*
	* @var int
	*/
	public $id;

	/**
	* Part Number
	*
	* @var string
	*/
	public $pn;

	/**
	* Style of cable
	*
	* @var string
	*/
	public $style;


	/**
	* type of cable
	*
	* @var string
	*/
	public $type;

	/**
	* awg/mm2
	*
	* @var string
	*/
	public $awg;
	/**
	* number of conductors
	*
	* @var int
	*/
	public $cond;
	/**
	* volts
	*
	* @var int
	*/
	public $volts;
	/**
	* Outer Diameter
	*
	* @var decimal
	*/
	public $od;

	/**
	* width of cable
	*
	* @var decimal
	*/
	public $width;

	/**
	* inner diameter
	*
	* @var decimal
	*/
	public $ind;
	/**
	* PSI
	*
	* @var int
	*/
	public $psi;

	/**
	* wgt
	*
	* @var decimal
	*/
	public $wgt;

	/**
	* reel price
	*
	* @var decimal
	*/
	public $reel_price;

	/**
	* fest price
	*
	* @var decimal
	*/
	public $fest_price;

	/**
	* install fix
	*
	* @var decimal
	*/
	public $instl_fix;
	/**
	* Install feet?
	*
	* @var decimal
	*/
	public $instl_ft;
	/*
	Does part belong to something?
	public function company() {
		return $this->belongsTo('Company');
	}*/


}
