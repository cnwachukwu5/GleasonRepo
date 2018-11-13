<?php
/**
 * Created by PhpStorm.
 * User: sanningb2
 * Date: 2/1/2018
 * Time: 4:43 PM
 */

class QuoteReelApp extends Eloquent{


    protected $table = 'reelapp';

    public $timestamps = false;

    protected $primaryKey = 'reelapp_id';

    protected $guarded = array();

    protected $reelapp_id;

    protected $QuoteID;

    protected $Application;

    protected $Sag;

    protected $PendantWgt;

    protected $CenterlineHgt;

    protected $Travel;

    protected $Speed;

    protected $Accel;

    protected $Duty_Cycle;

    protected $TempMin;

    protected $TempMax;

    protected $SpringTurns;

    protected $CCF;

    protected $DeadWraps;

    protected $AppNote;

    //test
    public function del(){

        return $this->delete();

    }


}