<?php
/**
 * Created by PhpStorm.
 * User: sanningb2
 * Date: 1/31/2018
 * Time: 2:41 PM
 */

class QuoteDetails extends Eloquent{


    protected $table = 'quotedetails';

    protected $guarded = array();

    protected $primaryKey = 'quotedetails_id';

    protected $quotedetails_id;

    protected $modelID;

    protected $qty;

    protected $description;

    protected $price;

    protected $quoteid;

    protected $modelnum;

}