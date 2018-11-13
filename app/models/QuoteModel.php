<?php
/**
 * Created by PhpStorm.
 * User: sanningb2
 * Date: 1/31/2018
 * Time: 2:53 PM
 */

class QuoteModel extends Eloquent{


    protected $table = 'qtemodel';

    protected $guarded = array();

    protected $primaryKey = 'ModelID';

    protected $ModelID;

    protected $Series;

    protected $ModelNum;

    protected $HazardDuty;

    protected $ReverseRotate;

    protected $ReqdExtraCAble;

    protected $ReelHeight;

    protected $ReelWidth;

    protected $ReelDepth;

    protected $ReelWeight;

    protected $PictureID;

    protected $QuoteType;

    protected $Delivery;

    protected $ModNote;

}