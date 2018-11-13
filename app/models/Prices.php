<?php
/**
 * Created by PhpStorm.
 * User: sanningb2
 * Date: 4/24/2018
 * Time: 1:37 PM
 */

class Prices extends Eloquent {


    /*
     Points to the tale in the database. The table is access by this object (php class / model)
     * */
    protected $table = "pn_prices";

    public $timestamps = false;
    protected $guarded = array();

    protected $id;

    protected $style;

    protected $pnValue;

    protected $price;


}