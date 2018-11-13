<?php

class SpecialContent
 extends Eloquent {


	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'special_contents';

	public $timestamps = false;
	protected $guarded = array();

	// /**
	// * Style
	// *
	// * @var string
	// */
	// public $style;
  //
	// /**
	// * Type
	// *
	// * @var string
	// */
	// public $type;
  //
  // /**
  // * AWG
  // *
  // * @var string
  // */
  // public $awg;
  //
  // /**
  // * Conductors
  // *
  // * @var string
  // */
  // public $cond;
  //
  // /**
  // * Volts
  // *
  // * @var string
  // */
  // public $volts;
  //
  // /**
  // * Outer Diameter
  // *
  // * @var string
  // */
  // public $odiameter;
  //
  // /**
  // * Width
  // *
  // * @var string
  // */
  // public $width;
  //
  // /**
  // * Inner Diameter
  // *
  // * @var string
  // */
  // public $idiameter;
  //
  // /**
  // * PSI
  // *
  // * @var string
  // */
  // public $psi;
  //
  // /**
  // * Weight
  // *
  // * @var string
  // */
  // public $wgt;
  //
  // /**
  // * Reel Price
  // *
  // * @var string
  // */
  // public $reel_price;
  //
  // /**
  // * Install Fix
  // *
  // * @var string
  // */
  // public $instl_fix;
  //
  // /**
  // * Install Feet
  // *
  // * @var string
  // */
  // public $instl_ft;

	public function packageContent() {
		return $this->belongsTo('PackageContent');
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
