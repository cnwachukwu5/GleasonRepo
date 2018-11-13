<?php

class Reeldata extends Eloquent {
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'reeldata';
	public $timestamps = false;
	protected $guarded = array();
	/**
	* Style of reel
	*
	* @var string
	*/
	public $style;
	/**
	* frame
	*
	* @var int
	*/
	public $frame;

	/**
	* springs
	*
	* @var int
	*/
	public $springs;
	/**
	* gear
	*
	* @var string
	*/
	public $gear;
	/**
	* cost of reel
	*
	* @var int
	*/
	public $cost;
	/**
	 * id
	 *
	 * @var int
	 */
	public $id;
}
