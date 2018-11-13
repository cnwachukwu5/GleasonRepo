<?php
session_start();
//set_time_limit(0);
//use Thujohn\Pdf;

class ReelController extends BaseController {
    //todo:Find a better way of constructing the globals class. and make sure the globals class doesnt get reconstructed at the wrong times and mess something up.
    public $grnd;
    public $cableClearanceFactor;
    public $rmoti; public $tqsiz; public $firstLayerMomentArm; public $shaftStress; public $bearingLoad;
    public $torqueFromMotor; public $uReelWidthInp;public $rollerGuidePN; public $rollerGuidePrice; public $hoopGuidePN; public $hoopGuidePrice; public $limitSwitchPN; public $limitSwitchPrice;
    public $pivotBasePN; public $pivotBasePrice; public $dogRatchetPN; public $dogRatchetPrice; public $spoolLockPN; public $spoolLuckPrice; public $ballStopPN; public $ballStopPrice;
    public $cablegripPN; public $cablegripPrice; public $stdDelivery; public $hoseFittingQty; public $malePipePN; public $malePipePrice; public $hoseClampPN; public $hoseClampPrice;
    public $hoseFerrulePN; public $hoseFerrulePrice; public $quoteId;

//this function loads globals.
    function __construct()
    {
        include(app_path() . '\lib\Globals.php');
        $this->globals = new Globals();
    }
//this returns a view containing calc results. Only returns for the most recent calculation, working on changing that
#commented out this function soo see if it was even being called.....I guess its not?
#still trying to find where the view calcs page is pulling info from since this is apparently not used
#UPDATE: this isn't used at all, javascript is now used
public function viewCalcResults() {

    #Debugbar::info("Hey so this is that weird ass array that we're trying to look at");
    #Debugbar::info(array('customers' =>1));
    #return View::make('reel/viewcalcresults_modal', array('customers' => 1));
}

    //this is empty?
    public function rm() {

    }

    public function accessClearVariables(){
        $this->rollerGuidePN=""; $this->rollerGuidePrice=0; $this->hoopGuidePN=""; $this->hoopGuidePrice=0; $this->limitSwitchPN="";$this->limitSwitchPrice=0; $this->pivotBasePN="";
        $this->pivotBasePrice=0; $this->dogRatchetPN=""; $this->dogRatchetPrice=0; $this->spoolLockPN=""; $this->spoolLuckPrice=0; $this->ballStopPN=""; $this->ballStopPrice=0;
        $this->cablegripPN=""; $this->cablegripPrice=0;
    }

    //create and return quoteid to be associated with every quote generated.
    public function creatQuoteID($name){
        //get 2digit if current year
        $yearHold = date("y");
        $dayCount = date("z");
        $dayCount = (string)$dayCount;
        $dayOfYearHold="";
        if(strlen($dayCount) < 2){
            $dayOfYearHold = "00".$dayCount;
        }

        $hourHold = (string)(mt_rand(1, 100) + 1);
        if(strlen($hourHold) < 2){
            $hourHold = "0".$hourHold;
        }

        $minuteHold = (string)(mt_rand(1, 100) + 1);
        if(strlen($minuteHold) < 2){
            $minuteHold = "0".$minuteHold;
        }

        $secondHold = (string)(mt_rand(1, 100) + 1);
        if(strlen($secondHold) < 2){
            $secondHold = "0".$secondHold;
        }
        $firstFourChar = substr($name, 0, 3);

        $quoteIdHold = $firstFourChar . $yearHold . $dayOfYearHold . $hourHold . $minuteHold . $secondHold;

        return $quoteIdHold;
    }
    
    public function getReelPrices($reelType){
        $pn_prices_list = DB::select('select pnValue, price from pn_prices where style = ?', array($reelType));
        $resultArray = array();
        for($i = 0; $i < count($pn_prices_list); $i++){
            $resultArray[$pn_prices_list[$i]->pnValue] = $pn_prices_list[$i]->price;
        }
        
        return $resultArray;
    }

   public function accessSreel($index, $printQuotedArrays, $cableThick){
        //Pull prices from pn_prices table for S-Reel
        $sReelPrices = $this->getReelPrices('S');

        if($printQuotedArrays[$index]->rollerGuideVal == "Yes"){
            if(!($printQuotedArrays[$index]->hoopGuideVal == "Yes")){
                switch($printQuotedArrays[$index]->rollerGuideMat){
                    case "steel":
                        switch ($printQuotedArrays[$index]->rollerGuideApp){
                            case "horizontal":
                            case "vertical":
                                if(!($printQuotedArrays[$index]->revRotVal == "Yes")){
                                    switch($printQuotedArrays[$index]->frame){
                                        case "16":
                                        case "18":
                                        case "21":
                                            $this->rollerGuidePN="GR035220";
                                            $this->rollerGuidePrice=$sReelPrices["GR035220"];
                                            break;
                                        case "24":
                                            $this->rollerGuidePN="GR035221";
                                            $this->rollerGuidePrice=$sReelPrices["GR035221"];
                                            break;
                                        case "28":
                                        case "32":
                                            $this->rollerGuidePN="GR035222";
                                            $this->rollerGuidePrice=$sReelPrices["GR035222"];
                                            break;
                                    }
                                }else{
                                    switch($printQuotedArrays[$index]->frame){
                                        case "16":
                                        case "18":
                                        case "21":
                                            $this->rollerGuidePN="GR035223";
                                            $this->rollerGuidePrice=$sReelPrices["GR035223"];
                                            break;
                                        case "24":
                                            $this->rollerGuidePN="GR035224";
                                            $this->rollerGuidePrice=$sReelPrices["GR035224"];
                                            break;
                                        case "28":
                                        case "32":
                                            $this->rollerGuidePN="GR035225";
                                            $this->rollerGuidePrice=$sReelPrices["GR035225"];
                                            break;
                                    }
                                }
                                break;
                            case "verticalDown":
                                switch($printQuotedArrays[$index]->frame){
                                    case "16":
                                    case "18":
                                    case "21":
                                    case "24":
                                        $this->rollerGuidePN="GR035226";
                                        $this->rollerGuidePrice=$sReelPrices["GR035226"];
                                        break;
                                    case "28":
                                    case "32":
                                        $this->rollerGuidePN="GR035227";
                                        $this->rollerGuidePrice=$sReelPrices["GR035227"];
                                        break;
                                }
                                break;

                        }
                        break;
                    case "nylon":
                        switch ($printQuotedArrays[$index]->rollerGuideApp){
                            case "horizontal":
                            case "vertical":
                                switch($printQuotedArrays[$index]->frame){
                                    case "14":
                                        $this->rollerGuidePN="GR012079";
                                        $this->rollerGuidePrice=$sReelPrices["GR012079"];
                                        break;
                                    case "16":
                                    case "18":
                                    case "21":
                                        $this->rollerGuidePN="GR012082";
                                        $this->rollerGuidePrice=$sReelPrices["GR012082"];
                                        break;
                                    case "24":
                                        $this->rollerGuidePN="GR012085";
                                        $this->rollerGuidePrice=$sReelPrices["GR012085"];
                                        break;
                                    case "28":
                                        $this->rollerGuidePN="GR012087";
                                        $this->rollerGuidePrice=$sReelPrices["GR012087"];
                                        break;
                                    case "32":
                                        $this->rollerGuidePN="GR04045401";
                                        $this->rollerGuidePrice=$sReelPrices["GR04045401"];
                                        break;
                                }

                                break;
                            case "verticalDown":
                                switch($printQuotedArrays[$index]->frame){
                                    case "14":
                                    case "16":
                                    case "18":
                                    case "21":
                                    case "24":
                                        $this->rollerGuidePN="GR012084";
                                        $this->rollerGuidePrice=$sReelPrices["GR012084"];
                                        break;
                                    case "28":
                                        $this->rollerGuidePN="GR012089";
                                        $this->rollerGuidePrice=$sReelPrices["GR012089"];
                                        break;
                                    case "32":
                                        $this->rollerGuidePN="GR040457";
                                        $this->rollerGuidePrice=$sReelPrices["GR040457"];
                                        break;
                                }

                                break;
                        }
                        break;
                }
            }//hoopguide is No
            else{//hoopGuideVal is yes so MMD roller guide required
                switch($printQuotedArrays[$index]->rollerGuideMat){
                    case "steel":
                        switch ($printQuotedArrays[$index]->rollerGuideApp){
                            case "horizontal":
                            case "vertical":
                                switch($printQuotedArrays[$index]->frame){
                                    case "18":
                                    case "21":
                                    case "24":
                                        $this->rollerGuidePN="GR034742";
                                        $this->rollerGuidePrice=$sReelPrices["GR034742"];
                                        break;
                                    case "28":
                                    case "32":
                                        $this->rollerGuidePN="GR034743";
                                        $this->rollerGuidePrice=$sReelPrices["GR034743"];
                                        break;
                                }
                                break;
                            case "verticalDown":
                                switch($printQuotedArrays[$index]->frame){
                                    case "18":
                                    case "21":
                                    case "24":
                                        $this->rollerGuidePN="GR034744";
                                        $this->rollerGuidePrice=$sReelPrices["GR034744"];
                                        break;
                                    case "28":
                                    case "32":
                                        $this->rollerGuidePN="GR034745";
                                        $this->rollerGuidePrice=$sReelPrices["GR034745"];
                                        break;
                                }
                                break;
                        }
                        break;
                    case "nylon":
                        switch ($printQuotedArrays[$index]->rollerGuideApp){
                            case "horizontal":
                            case "vertical":
                                switch($printQuotedArrays[$index]->frame){
                                    case "18":
                                    case "21":
                                    case "24":
                                        $this->rollerGuidePN="GR015607";
                                        $this->rollerGuidePrice=$sReelPrices["GR015607"];
                                        break;
                                    case "28":
                                    case "32":
                                        $this->rollerGuidePN="GR015608";
                                        $this->rollerGuidePrice=$sReelPrices["GR015608"];
                                        break;
                                }
                                break;
                            case "verticalDown":
                                switch($printQuotedArrays[$index]->frame){
                                    case "18":
                                    case "21":
                                    case "24":
                                        $this->rollerGuidePN="GR015674";
                                        $this->rollerGuidePrice=$sReelPrices["GR015674"];
                                        break;
                                    case "28":
                                    case "32":
                                        $this->rollerGuidePN="GR015675";
                                        $this->rollerGuidePrice=$sReelPrices["GR015675"];
                                        break;
                                }
                                break;
                        }
                        break;
                }
            }
            if($printQuotedArrays[$index]->hazardVal == "Yes"){
                $this->rollerGuidePN="XXXXXX"; //'per S. schmitz, uses steel pricing, diff P/N
            }
        }

        if($printQuotedArrays[$index]->hoopGuideVal == "Yes"){
            switch($printQuotedArrays[$index]->frame){
                case "18":
                    $this->hoopGuidePN="GR012095";
                    $this->hoopGuidePrice=$sReelPrices["GR012095"];
                    break;
                case "21":
                    $this->hoopGuidePN="GR012096";
                    $this->hoopGuidePrice=$sReelPrices["GR012096"];
                    break;
                case "24":
                    $this->hoopGuidePN="GR012097";
                    $this->hoopGuidePrice=$sReelPrices["GR012097"];
                    break;
                case "28":
                    $this->hoopGuidePN="GR012098";
                    $this->hoopGuidePrice=$sReelPrices["GR012098"];
                    break;
                case "32":
                    $this->hoopGuidePN="GR039712";
                    $this->hoopGuidePrice=$sReelPrices["GR039712"];
                    break;
            }
        }

        if($printQuotedArrays[$index]->limitSwitchVal == "Yes"){
            switch($printQuotedArrays[$index]->frame){
                case "32":
                    $this->limitSwitchPN="GR040449";
                    $this->limitSwitchPrice=$sReelPrices["GR040449"];
                    break;
                default:
                    $this->limitSwitchPN="GR012092";
                    $this->limitSwitchPrice=$sReelPrices["GR012092"];
                    break;
            }

        }

        if($printQuotedArrays[$index]->pivotBase340Val == "Yes"){
            switch($printQuotedArrays[$index]->frame){
                case "14":
                    $this->pivotBasePN="GR012076";
                    $this->pivotBasePrice=$sReelPrices["GR012076"];
                    break;
                case "16":
                case "18":
                case "21":
                case "24":
                case "28":
                case "32":
                    $this->pivotBasePN="GR012077";
                    $this->pivotBasePrice=$sReelPrices["GR012077"];
                    break;
            }
            if($printQuotedArrays[$index]->hazardVal == "Yes"){
                $this->pivotBasePN="GR0120771";
                $this->pivotBasePrice=$sReelPrices["GR0120771"];//'2018 manually change make sure it matches MMD access
            }
        }

        if($printQuotedArrays[$index]->dogAndRatchetVal == "Yes"){
            switch($printQuotedArrays[$index]->hazardVal){
                case "Yes":
                    $this->dogRatchetPN="XXXXXX";
                    $this->dogRatchetPrice=$sReelPrices["XXXXXX"]; //'2018 manually change make sure it matches MMD access
                    break;
                case "No":
                    switch($printQuotedArrays[$index]->frame){
                        case "32":
                            $this->dogRatchetPN="GR039887";
                            $this->dogRatchetPrice=$sReelPrices["GR039887"];
                            break;
                        default:
                            $this->dogRatchetPN="GR012090";
                            $this->dogRatchetPrice=$sReelPrices["GR012090"];
                            break;
                    }

                    break;
            }
        }

        if($printQuotedArrays[$index]->spoolLockAssVal == "Yes"){
            $this->spoolLockPN="GR012091";
            $this->spoolLuckPrice=$sReelPrices["GR012091"];
        }

        if($printQuotedArrays[$index]->ballStopAssVal == "Yes"){
            if($cableThick < 0.62){
                $this->ballStopPN="GR037529";
                $this->ballStopPrice=$sReelPrices["GR037529"];
            }elseif ($cableThick > 1.87){
                $this->ballStopPN="GR041846";
                $this->ballStopPrice=$sReelPrices["GR041846"];
            }elseif ($cableThick > 1.55){
                $this->ballStopPN="GR041845";
                $this->ballStopPrice=$sReelPrices["GR041845"];
            }elseif ($cableThick > 1.38){
                $this->ballStopPN="GR037537";
                $this->ballStopPrice=$sReelPrices["GR037537"];
            }elseif ($cableThick > 1.3){
                $this->ballStopPN="GR037536";
                $this->ballStopPrice=$sReelPrices["GR037536"];
            }elseif ($cableThick > 1.05){
                switch ($printQuotedArrays[$index]->bdiamVar){
                    case "3":
                        $this->ballStopPN="GR037533";
                        $this->ballStopPrice=$sReelPrices["GR037533"];
                        break;
                    case "3.5":
                        $this->ballStopPN="GR037536";
                        $this->ballStopPrice=$sReelPrices["GR037536"];
                        break;
                }
            }elseif ($cableThick > 0.75){
                switch ($printQuotedArrays[$index]->bdiamVar){
                    case "3":
                        $this->ballStopPN="GR037532";
                        $this->ballStopPrice=$sReelPrices["GR037532"];
                        break;
                    case "3.5":
                        $this->ballStopPN="GR037535";
                        $this->ballStopPrice=$sReelPrices["GR037535"];
                        break;
                }
            }elseif ($cableThick == 0.75){
                switch ($printQuotedArrays[$index]->bdiamVar){
                    case "3":
                        $this->ballStopPN="GR037531";
                        $this->ballStopPrice=$sReelPrices["GR037531"];
                        break;
                    case "3.5":
                        $this->ballStopPN="GR037535";
                        $this->ballStopPrice=$sReelPrices["GR037535"];
                        break;
                }
            }elseif ($cableThick >= 0.62){
                switch ($printQuotedArrays[$index]->bdiamVar){
                    case "2.5":
                        $this->ballStopPN="GR037530";
                        $this->ballStopPrice=$sReelPrices["GR037530"];
                        break;
                    case "3":
                        $this->ballStopPN="GR037531";
                        $this->ballStopPrice=$sReelPrices["GR037531"];
                        break;
                }
            }
        }

        if($printQuotedArrays[$index]->cableGripAssVal == "Yes"){
            if($cableThick >= 1.25){
                $this->cablegripPN="GR027618";
                $this->cablegripPrice=$sReelPrices["GR027618"];
            }elseif($cableThick >= 1.0){
                $this->cablegripPN="GR027617";
                $this->cablegripPrice=$sReelPrices["GR027617"];
            }elseif ($cableThick >= 0.75){
                $this->cablegripPN="GR027616";
                $this->cablegripPrice=$sReelPrices["GR027616"];
            }elseif($cableThick >= 0.53){
                $this->cablegripPN="GR027615";
                $this->cablegripPrice=$sReelPrices["GR027615"];
            }elseif ($cableThick >= 0.41){
                $this->cablegripPN="GR027614";
                $this->cablegripPrice=$sReelPrices["GR027614"];
            }
        }
    }//End of accessSReel Method

    public function accessSMreel($index, $printQuotedArrays, $cableThick){
        //Pull prices from pn_prices table for SM-Reel
        $smReelPrices = $this->getReelPrices('SM');

        //debugbar::info($smReelPrices);
        //debugbar::info($smReelPrices["GR015988"]);

        if($printQuotedArrays[$index]->rollerGuideVal == "Yes"){
            switch ($printQuotedArrays[$index]->rollerGuideApp){
                case "horizontal":
                case "vertical":
                    switch($printQuotedArrays[$index]->frame){
                        case "21":
                        case "24":
                            $this->rollerGuidePN = "GR015988";
                            $this->rollerGuidePrice = $smReelPrices["GR015988"];
                            break;
                        case "28":
                        case "32":
                            $this->rollerGuidePN = "GR015991";
                            $this->rollerGuidePrice = $smReelPrices["GR015991"];
                            break;
                    }
                    break;
                case "verticalDown":
                    switch($printQuotedArrays[$index]->frame){
                        case "21":
                        case "24":
                            $this->rollerGuidePN = "GR015989";
                            $this->rollerGuidePrice = $smReelPrices["GR015989"];
                            break;
                        case "28":
                        case "32":
                            $this->rollerGuidePN = "GR015992";
                            $this->rollerGuidePrice = $smReelPrices["GR015992"];
                            break;
                    }
                    break;
            }
        }//End if "rollerGuideVal" = Yes

        if($printQuotedArrays[$index]->limitSwitchVal == "Yes"){
            switch($printQuotedArrays[$index]->frame){
                case "21":
                case "24":
                    $this->limitSwitchPN = "GR015990";
                    $this->limitSwitchPrice = $smReelPrices["GR015990"];
                    break;
                case "28":
                    $this->limitSwitchPN = "GR015993";
                    $this->limitSwitchPrice = $smReelPrices["GR015993"];
                    break;
                case "32":
                    $this->limitSwitchPN = "GR039373";
                    $this->limitSwitchPrice = $smReelPrices["GR039373"];
                    break;
            }

        }

        if($printQuotedArrays[$index]->pivotBase340Val == "Yes"){
            switch($printQuotedArrays[$index]->frame){
                case "21":
                case "24":
                    $this->pivotBasePN = "GR015874";
                    $this->pivotBasePrice = $smReelPrices["GR015874"];
                    break;
                case "28":
                case "32":
                    $this->pivotBasePN = "GR015873";
                    $this->pivotBasePrice = $smReelPrices["GR015873"];
                    break;
            }
        }

        if($printQuotedArrays[$index]->dogAndRatchetVal == "Yes"){
            switch($printQuotedArrays[$index]->frame){
                case "32":
                    $this->dogRatchetPN = "GR039887";
                    $this->dogRatchetPrice = $smReelPrices["GR039887"];
                    break;
                default:
                    $this->dogRatchetPN = "GR012090";
                    $this->dogRatchetPrice = $smReelPrices["GR012090"];
            }
        }

        if($printQuotedArrays[$index]->ballStopAssVal == "Yes"){
            if($cableThick < 0.62){
                $this->ballStopPN="GR037529";
                $this->ballStopPrice = $smReelPrices["GR037529"];
            }elseif ($cableThick > 1.87){
                $this->ballStopPN="GR041846";
                $this->ballStopPrice = $smReelPrices["GR041846"];
            }elseif ($cableThick > 1.55){
                $this->ballStopPN="GR041845";
                $this->ballStopPrice = $smReelPrices["GR041845"];
            }elseif ($cableThick > 1.38){
                $this->ballStopPN="GR037537";
                $this->ballStopPrice = $smReelPrices["GR037537"];
            }elseif ($cableThick > 1.3){
                $this->ballStopPN="GR037536";
                $this->ballStopPrice = $smReelPrices["GR037536"];
            }elseif ($cableThick > 1.05){
                switch ($printQuotedArrays[$index]->bdiamVar){
                    case "3":
                        $this->ballStopPN="GR037533";
                        $this->ballStopPrice = $smReelPrices["GR037533"];
                        break;
                    case "3.5":
                        $this->ballStopPN="GR037536";
                        $this->ballStopPrice = $smReelPrices["GR037536"];
                        break;
                }
            }elseif ($cableThick > 0.75){
                switch ($printQuotedArrays[$index]->bdiamVar){
                    case "3":
                        $this->ballStopPN="GR037532";
                        $this->ballStopPrice = $smReelPrices["GR037532"];
                        break;
                    case "3.5":
                        $this->ballStopPN="GR037535";
                        $this->ballStopPrice = $smReelPrices["GR037535"];
                        break;
                }
            }elseif ($cableThick == 0.75){
                switch ($printQuotedArrays[$index]->bdiamVar){
                    case "3":
                        $this->ballStopPN="GR037531";
                        $this->ballStopPrice = $smReelPrices["GR037531"];
                        break;
                    case "3.5":
                        $this->ballStopPN="GR037535";
                        $this->ballStopPrice = $smReelPrices["GR037535"];
                        break;
                }
            }elseif ($cableThick >= 0.62){
                switch ($printQuotedArrays[$index]->bdiamVar){
                    case "2.5":
                        $this->ballStopPN="GR037530";
                        $this->ballStopPrice = $smReelPrices["GR037530"];
                        break;
                    case "3":
                        $this->ballStopPN="GR037531";
                        $this->ballStopPrice = $smReelPrices["GR037531"];
                        break;
                }
            }
        }

        if($printQuotedArrays[$index]->cableGripAssVal == "Yes"){
            if($cableThick >= 1.25){
                $this->cablegripPN="GR027618";
                $this->cablegripPrice = $smReelPrices["GR027618"];
            }elseif($cableThick >= 1.0){
                $this->cablegripPN="GR027617";
                $this->cablegripPrice = $smReelPrices["GR027617"];
            }elseif ($cableThick >= 0.75){
                $this->cablegripPN="GR027616";
                $this->cablegripPrice = $smReelPrices["GR027616"];
            }elseif($cableThick >= 0.53){
                $this->cablegripPN="GR027615";
                $this->cablegripPrice = $smReelPrices["GR027615"];
            }elseif ($cableThick >= 0.41){
                $this->cablegripPN="GR027614";
                $this->cablegripPrice = $smReelPrices["GR027614"];
            }
        }

    }//End of method

    public function accessMMDreel($index, $printQuotedArrays, $cableThick){
        //Pull prices from pn_prices table for SM-Reel
        $mmdReelPrices = $this->getReelPrices('MMD');

        //debugbar::info($mmdReelPrices);
        //debugbar::info($mmdReelPrices["GR034742"]);

        if($printQuotedArrays[$index]->rollerGuideVal == "Yes"){
            switch($printQuotedArrays[$index]->rollerGuideMat){
                case "steel":
                    switch ($printQuotedArrays[$index]->rollerGuideApp){
                        case "horizontal":
                        case "vertical":
                            switch($printQuotedArrays[$index]->frame){
                                case "21":
                                case "24":
                                    $this->rollerGuidePN="GR034742";
                                    $this->rollerGuidePrice=$mmdReelPrices["GR034742"];
                                    break;
                                case "28":
                                case "32":
                                    $this->rollerGuidePN="GR034743";
                                    $this->rollerGuidePrice=$mmdReelPrices["GR034743"];
                                    break;
                            }
                            break;
                        case "verticalDown":
                            switch($printQuotedArrays[$index]->frame){
                                case "21":
                                case "24":
                                    $this->rollerGuidePN="GR034744";
                                    $this->rollerGuidePrice=$mmdReelPrices["GR034744"];
                                    break;
                                case "28":
                                case "32":
                                    $this->rollerGuidePN="GR034745";
                                    $this->rollerGuidePrice=$mmdReelPrices["GR034745"];
                                    break;
                            }
                            break;
                    }
                    break;
                case "nylon":
                    switch ($printQuotedArrays[$index]->rollerGuideApp){
                        case "horizontal":
                        case "vertical":
                            switch($printQuotedArrays[$index]->frame){
                                case "21":
                                case "24":
                                    $this->rollerGuidePN="GR015607";
                                    $this->rollerGuidePrice=$mmdReelPrices["GR015607"];
                                    break;
                                case "28":
                                case "32":
                                    $this->rollerGuidePN="GR015608";
                                    $this->rollerGuidePrice=$mmdReelPrices["GR015608"];
                                    break;
                            }
                            break;
                        case "verticalDown":
                            switch($printQuotedArrays[$index]->frame){
                                case "21":
                                case "24":
                                    $this->rollerGuidePN="GR015674";
                                    $this->rollerGuidePrice=$mmdReelPrices["GR015674"];
                                    break;
                                case "28":
                                case "32":
                                    $this->rollerGuidePN="GR015675";
                                    $this->rollerGuidePrice=$mmdReelPrices["GR015675"];
                                    break;
                            }
                            break;
                    }
                    break;
            }
        }

        if($printQuotedArrays[$index]->limitSwitchVal == "Yes"){
            $this->limitSwitchPN="GR012092"; $this->limitSwitchPrice = $mmdReelPrices["GR012092"];
        }

        if($printQuotedArrays[$index]->pivotBase340Val == "Yes"){
            switch($printQuotedArrays[$index]->frame){
                case "21":
                case "24":
                    $this->pivotBasePN="GR012077";
                    $this->pivotBasePrice=$mmdReelPrices["GR012077"];
                    break;
                case "28":
                case "32":
                    $this->pivotBasePN="GR012077";
                    $this->pivotBasePrice=$mmdReelPrices["GR012077"];
                    break;
            }

            if($printQuotedArrays[$index]->hazardVal == "Yes"){
                $this->pivotBasePN = "GR0120771"; $this->pivotBasePrice = $mmdReelPrices["GR0120771"]; //'manually bump to match S reel 2018
            }
        }

        if($printQuotedArrays[$index]->dogAndRatchetVal == "Yes"){
            switch($printQuotedArrays[$index]->hazardVal){
                case "Yes":
                    $this->dogRatchetPN="XXXXXX";
                    $this->dogRatchetPrice=$mmdReelPrices["XXXXXX"]; //'2018 manually bump to match S reel
                    break;
                case "No":
                    switch($printQuotedArrays[$index]->frame){
                        case "32":
                            $this->dogRatchetPN="GR039887"; $this->dogRatchetPrice = $mmdReelPrices["GR039887"];
                            break;
                        default:
                            $this->dogRatchetPN="GR012090"; $this->dogRatchetPrice = $mmdReelPrices["GR012090"];
                            break;
                    }
                    break;
            }
        }

        if($printQuotedArrays[$index]->ballStopAssVal == "Yes"){
            if($cableThick < 0.62){
                $this->ballStopPN="GR037529";
                $this->ballStopPrice=$mmdReelPrices["GR037529"];
            }elseif ($cableThick > 1.87){
                $this->ballStopPN="GR041846";
                $this->ballStopPrice=$mmdReelPrices["GR041846"];
            }elseif ($cableThick > 1.55){
                $this->ballStopPN="GR041845";
                $this->ballStopPrice=$mmdReelPrices["GR041845"];
            }elseif ($cableThick > 1.38){
                $this->ballStopPN="GR037537";
                $this->ballStopPrice=$mmdReelPrices["GR037537"];
            }elseif ($cableThick > 1.3){
                $this->ballStopPN="GR037536";
                $this->ballStopPrice=$mmdReelPrices["GR037536"];
            }elseif ($cableThick > 1.05){
                switch ($printQuotedArrays[$index]->bdiamVar){
                    case "3":
                        $this->ballStopPN="GR037533";
                        $this->ballStopPrice=$mmdReelPrices["GR037533"];
                        break;
                    case "3.5":
                        $this->ballStopPN="GR037536";
                        $this->ballStopPrice=$mmdReelPrices["GR037536"];
                        break;
                }
            }elseif ($cableThick > 0.75){
                switch ($printQuotedArrays[$index]->bdiamVar){
                    case "3":
                        $this->ballStopPN="GR037532";
                        $this->ballStopPrice=$mmdReelPrices["GR037532"];
                        break;
                    case "3.5":
                        $this->ballStopPN="GR037535";
                        $this->ballStopPrice=$mmdReelPrices["GR037535"];
                        break;
                }
            }elseif ($cableThick == 0.75){
                switch ($printQuotedArrays[$index]->bdiamVar){
                    case "3":
                        $this->ballStopPN="GR037531";
                        $this->ballStopPrice=$mmdReelPrices["GR037531"];
                        break;
                    case "3.5":
                        $this->ballStopPN="GR037535";
                        $this->ballStopPrice=$mmdReelPrices["GR037535"];
                        break;
                }
            }elseif ($cableThick >= 0.62){
                switch ($printQuotedArrays[$index]->bdiamVar){
                    case "2.5":
                        $this->ballStopPN="GR037530";
                        $this->ballStopPrice=$mmdReelPrices["GR037530"];
                        break;
                    case "3":
                        $this->ballStopPN="GR037531";
                        $this->ballStopPrice=$mmdReelPrices["GR037531"];
                        break;
                }
            }
        }

        if($printQuotedArrays[$index]->cableGripAssVal == "Yes"){
            if($cableThick >= 1.25){
                $this->cablegripPN="GR027618";
                $this->cablegripPrice=$mmdReelPrices["GR027618"];
            }elseif($cableThick >= 1.0){
                $this->cablegripPN="GR027617";
                $this->cablegripPrice=$mmdReelPrices["GR027617"];
            }elseif ($cableThick >= 0.75){
                $this->cablegripPN="GR027616";
                $this->cablegripPrice=$mmdReelPrices["GR027616"];
            }elseif($cableThick >= 0.53){
                $this->cablegripPN="GR027615";
                $this->cablegripPrice=$mmdReelPrices["GR027615"];
            }elseif ($cableThick >= 0.41){
                $this->cablegripPN="GR027614";
                $this->cablegripPrice=$mmdReelPrices["GR027614"];
            }
        }
    }//End of method accessMMDReel

    public function accessUreel($index, $printQuotedArrays, $cableThick, $reelWidthInp, $cableOrHose, $hoseIDcode){
        $uReelPrices = $this->getReelPrices('U');

        $testSTR = "";
        if($printQuotedArrays[$index]->rollerGuideVal == "Yes"){
            $testSTR = $printQuotedArrays[$index]->frame . $reelWidthInp;
            switch ($printQuotedArrays[$index]->rollerGuideApp){
                case "horizontal":
                    switch($testSTR){
                        case "1806":
                        case "2106":
                            $this->rollerGuidePN = "GR042195";
                            $this->rollerGuidePrice = $uReelPrices['GR042195'];
                            break;
                        case "1808":
                        case "2108":
                            $this->rollerGuidePN = "GR042196";
                            $this->rollerGuidePrice = $uReelPrices['GR042196'];
                            break;
                        case "1810":
                        case "2110":
                            $this->rollerGuidePN = "GR042197";
                            $this->rollerGuidePrice = $uReelPrices['GR042197'];
                            break;
                        case "1812":
                        case "2112":
                            $this->rollerGuidePN = "GR042198";
                            $this->rollerGuidePrice = $uReelPrices['GR042198'];
                            break;
                        case "1814":
                        case "2114":
                            $this->rollerGuidePN = "GR042199";
                            $this->rollerGuidePrice = $uReelPrices['GR042199'];
                            break;
                        case "2406":
                            $this->rollerGuidePN = "GR042200";
                            $this->rollerGuidePrice = $uReelPrices['GR042200'];
                            break;
                        case "2408":
                            $this->rollerGuidePN = "GR042201";
                            $this->rollerGuidePrice = $uReelPrices['GR042201'];
                            break;
                        case "2410":
                            $this->rollerGuidePN = "GR042202";
                            $this->rollerGuidePrice = $uReelPrices['GR042202'];
                            break;
                        case "2412":
                            $this->rollerGuidePN = "GR042203";
                            $this->rollerGuidePrice = $uReelPrices['GR042203'];
                            break;
                        case "2414":
                            $this->rollerGuidePN = "GR042204";
                            $this->rollerGuidePrice = $uReelPrices['GR042204'];
                            break;
                        case "2806":
                            $this->rollerGuidePN = "GR042205";
                            $this->rollerGuidePrice = $uReelPrices['GR042205'];
                            break;
                        case "2808":
                            $this->rollerGuidePN = "GR042206";
                            $this->rollerGuidePrice = $uReelPrices['GR042206'];
                            break;
                        case "2810":
                            $this->rollerGuidePN = "GR042207";
                            $this->rollerGuidePrice = $uReelPrices['GR042207'];
                            break;
                        case "2812":
                            $this->rollerGuidePN = "GR042208";
                            $this->rollerGuidePrice = $uReelPrices['GR042208'];
                            break;
                        case "2814":
                            $this->rollerGuidePN = "GR042209";
                            $this->rollerGuidePrice = $uReelPrices['GR042209'];
                            break;
                        case "3206":
                            $this->rollerGuidePN = "GR042210";
                            $this->rollerGuidePrice = $uReelPrices['GR042210'];
                            break;
                        case "3208":
                            $this->rollerGuidePN = "GR042211";
                            $this->rollerGuidePrice = $uReelPrices['GR042211'];
                            break;
                        case "3210":
                            $this->rollerGuidePN = "GR042212";
                            $this->rollerGuidePrice = $uReelPrices['GR042212'];
                            break;
                        case "3212":
                            $this->rollerGuidePN = "GR042213";
                            $this->rollerGuidePrice = $uReelPrices['GR042213'];
                            break;
                        case "3214":
                            $this->rollerGuidePN = "GR042214";
                            $this->rollerGuidePrice = $uReelPrices['GR042214'];
                            break;
                        default:
                            $this->rollerGuidePN = "XXXXXX";
                            $this->rollerGuidePrice = $uReelPrices['XXXXXX'];
                    }
                    break;
                case "vertical":
                    switch ($testSTR){
                        case "1806":
                        case "2106":
                        case "2406":
                            $this->rollerGuidePN = "GR042270";
                            $this->rollerGuidePrice = $uReelPrices['GR042270'];
                            break;
                        case "1808":
                        case "2108":
                        case "2408":
                            $this->rollerGuidePN = "GR042271";
                            $this->rollerGuidePrice = $uReelPrices['GR042271'];
                            break;
                        case "1810":
                        case "2110":
                        case "2410":
                            $this->rollerGuidePN = "GR042272";
                            $this->rollerGuidePrice = $uReelPrices['GR042272'];
                            break;
                        case "1812":
                        case "2112":
                        case "2412":
                            $this->rollerGuidePN = "GR042273";
                            $this->rollerGuidePrice = $uReelPrices['GR042273'];
                            break;
                        case "1814":
                        case "2114":
                        case "2414":
                            $this->rollerGuidePN = "GR042274";
                            $this->rollerGuidePrice = $uReelPrices['GR042274'];
                            break;
                        case "2806":
                        case "3206":
                            $this->rollerGuidePN = "GR042275";
                            $this->rollerGuidePrice = $uReelPrices['GR042275'];
                            break;
                        case "2808":
                        case "3208":
                            $this->rollerGuidePN = "GR042276";
                            $this->rollerGuidePrice = $uReelPrices['GR042276'];
                            break;
                        case "2810":
                        case "3210":
                            $this->rollerGuidePN = "GR042277";
                            $this->rollerGuidePrice = $uReelPrices['GR042277'];
                            break;
                        case "2812":
                        case "3212":
                            $this->rollerGuidePN = "GR042278";
                            $this->rollerGuidePrice = $uReelPrices['GR042278'];
                            break;
                        case "2814":
                        case "3214":
                            $this->rollerGuidePN = "GR042279";
                            $this->rollerGuidePrice = $uReelPrices['GR042279'];
                            break;
                        default:
                            $this->rollerGuidePN = "XXXXXX";
                            $this->rollerGuidePrice = $uReelPrices['XXXXXX'];
                    }
                    break;
            }


        }

        if($printQuotedArrays[$index]->limitSwitchVal == "Yes"){
            switch($printQuotedArrays[$index]->frame){
                case "32":
                    $this->limitSwitchPN = "XXXXXX";
                    $this->limitSwitchPrice = $uReelPrices['XXXXXXL'];
                    break;
                default:
                    $this->limitSwitchPN = "XXXXXX";
                    $this->limitSwitchPrice = $uReelPrices['XXXXXXL'];
                    break;
            }

        }

        if($printQuotedArrays[$index]->hoopGuideVal == "Yes"){
            switch($printQuotedArrays[$index]->frame){
                case "18":
                    $this->hoopGuidePN = "GR057199";
                    $this->hoopGuidePrice = $uReelPrices['GR057199'];
                    break;
                case "21":
                    $this->hoopGuidePN = "GR057200";
                    $this->hoopGuidePrice = $uReelPrices['GR057200'];
                    break;
                case "24":
                    $this->hoopGuidePN = "GR057201";
                    $this->hoopGuidePrice = $uReelPrices['GR057201'];
                    break;
                case "28":
                    $this->hoopGuidePN = "GR057202";
                    $this->hoopGuidePrice = $uReelPrices['GR057202'];
                    break;
                case "32":
                    $this->hoopGuidePN = "GR057203";
                    $this->hoopGuidePrice = $uReelPrices['GR057203'];
                    break;
            }

        }

        if($printQuotedArrays[$index]->pivotBase340Val == "Yes"){
            $printQuotedArrays[$index]->modelWgt = $printQuotedArrays[$index]->modelWgt + 64;
            switch ($reelWidthInp){
                case "GR04":
                case "06":
                    $this->pivotBasePN = "GR042284";
                    $this->pivotBasePrice = $uReelPrices['GR042284'];
                    break;
                case "08":
                case "10":
                    $this->pivotBasePN = "GR042285";
                    $this->pivotBasePrice = $uReelPrices['GR042285'];
                    break;
                case "12":
                case "14":
                    $this->pivotBasePN = "GR042286";
                    $this->pivotBasePrice = $uReelPrices['GR042286'];
                    break;
            }


        }

        if($printQuotedArrays[$index]->dogAndRatchetVal == "Yes"){
            if($printQuotedArrays[$index]->revRotVal == "Yes"){
                $this->dogRatchetPN = "GR042231";
                $this->dogRatchetPrice = $uReelPrices['GR042231'];
            }else{
                $this->dogRatchetPN = "GR042230";
                $this->dogRatchetPrice = $uReelPrices['GR042230'];
            }

        }

        if($printQuotedArrays[$index]->spoolLockAssVal == "Yes"){
            $this->spoolLockPN = "GR042227";
            $this->spoolLuckPrice = $uReelPrices['GR042227'];
        }

        if($printQuotedArrays[$index]->ballStopAssVal == "Yes"){
            if($cableThick < 0.62){
                $this->ballStopPN="GR037529";
                $this->ballStopPrice = $uReelPrices['GR037529'];
            }elseif ($cableThick > 1.87){
                $this->ballStopPN="GR041846";
                $this->ballStopPrice = $uReelPrices['GR041846'];
            }elseif ($cableThick > 1.55){
                $this->ballStopPN="GR041845";
                $this->ballStopPrice = $uReelPrices['GR041845'];
            }elseif ($cableThick > 1.38){
                $this->ballStopPN="GR037537";
                $this->ballStopPrice = $uReelPrices['GR037537'];
            }elseif ($cableThick > 1.3){
                $this->ballStopPN="GR037536";
                $this->ballStopPrice = $uReelPrices['GR037536'];
            }elseif ($cableThick > 1.05){
                switch ($printQuotedArrays[$index]->bdiamVar){
                    case "3":
                        $this->ballStopPN="GR037533";
                        $this->ballStopPrice = $uReelPrices['GR037533'];
                        break;
                    case "3.5":
                        $this->ballStopPN="GR037536";
                        $this->ballStopPrice = $uReelPrices['GR037536'];
                        break;
                }
            }elseif ($cableThick > 0.75){
                switch ($printQuotedArrays[$index]->bdiamVar){
                    case "3":
                        $this->ballStopPN="GR037532";
                        $this->ballStopPrice = $uReelPrices['GR037532'];
                        break;
                    case "3.5":
                        $this->ballStopPN="GR037535";
                        $this->ballStopPrice = $uReelPrices['GR037535'];
                        break;
                }
            }elseif ($cableThick == 0.75){
                switch ($printQuotedArrays[$index]->bdiamVar){
                    case "3":
                        $this->ballStopPN="GR037531";
                        $this->ballStopPrice = $uReelPrices['GR037531'];
                        break;
                    case "3.5":
                        $this->ballStopPN="GR037535";
                        $this->ballStopPrice = $uReelPrices['GR037535'];
                        break;
                }
            }elseif ($cableThick >= 0.62){
                switch ($printQuotedArrays[$index]->bdiamVar){
                    case "2.5":
                        $this->ballStopPN="GR037530";
                        $this->ballStopPrice = $uReelPrices['GR037530'];
                        break;
                    case "3":
                        $this->ballStopPN="GR037531";
                        $this->ballStopPrice = $uReelPrices['GR037531'];
                        break;
                }
            }
        }

        //'hose clamps required for all UH & HM reels
        if($cableOrHose == "HS"){
            $this->getHosefittings($hoseIDcode);
        }

    }//End of accessUreel

    public function getHosefittings($hoseIDcode){
        $hoseFittingPrices = $this->getReelPrices('getHoseFittings');
        //debugbar::info($hoseFittingPrices);

        //hose clamps required for all UH and HM reels
        switch ($hoseIDcode){
            case "4":
                $this->malePipePN = "GR625241"; $this->malePipePrice = $hoseFittingPrices['GR625241'];
                $this->hoseFerrulePN = "GR029073"; $this->hoseClampPN = "GR101478"; //'use ferrules
                break;
            case "6":
                $this->malePipePN = "GR625233"; $this->malePipePrice = $hoseFittingPrices['GR625233'];
                $this->hoseFerrulePN = "GR029074"; $this->hoseClampPN = "GR101479"; //'use ferrules
                break;
            case "8":
                $this->malePipePN = "GR101539"; $this->malePipePrice = $hoseFittingPrices['GR101539'];
                $this->hoseFerrulePN = "GR029075"; $this->hoseClampPN = "GR101480"; //'use ferrules
                break;
            case "12":
                $this->malePipePN = "GR101540"; $this->malePipePrice = $hoseFittingPrices['GR101540'];
                $this->hoseFerrulePN = ""; $this->hoseClampPN = "GR101481"; //'use ferrules
                break;
            case "16":
                $this->malePipePN = "GR101541"; $this->malePipePrice = $hoseFittingPrices['GR101541'];
                $this->hoseFerrulePN = ""; $this->hoseClampPN = "GR101482"; //'use ferrules
                break;
            case "20":
                $this->malePipePN = "GR101535"; $this->malePipePrice = $hoseFittingPrices['GR101535'];
                $this->hoseFerrulePN = ""; $this->hoseClampPN = "GR107705"; //'use ferrules
                break;
            case "24":
                $this->malePipePN = "GR101536"; $this->malePipePrice = $hoseFittingPrices['GR101536'];
                $this->hoseFerrulePN = ""; $this->hoseClampPN = "GR107705"; //'use ferrules
                break;
        }

        $this->hoseClampPrice = $hoseFittingPrices['hoseclampPRICE'];
        $this->hoseFerrulePrice = $hoseFittingPrices['hoseferrulePRICE'];
    }

    public function accessCMreel($index, $printQuotedArrays, $cableThick, $cableOrHose, $hoseIDcode){

        //Pull prices from DB into array $pReelPrices
        $cmReelPrices = $this->getReelPrices('C');
        //debugbar::info($cmReelPrices['GR022217']);

        if($printQuotedArrays[$index]->pivotBase340Val == "Yes"){
            switch($printQuotedArrays[$index]->frame){
                case "14":
                    $this->pivotBasePN = "GR022217";
                    $this->pivotBasePrice = $cmReelPrices['GR022217'];
                    break;
                case "16":
                    $this->pivotBasePN = "GR028056";
                    $this->pivotBasePrice = $cmReelPrices['GR028056'];
                    break;
                case "19":
                    $this->pivotBasePN = "GR022220";
                    $this->pivotBasePrice = $cmReelPrices['GR022220'];
                    break;
            }
        }

        if($printQuotedArrays[$index]->ballStopAssVal == "Yes"){
            if($cableThick >= 0.7){
                $this->ballStopPN = "GR022452";
                $this->ballStopPrice = $cmReelPrices['GR022452'];
            }elseif($cableThick >= 0.57){
                $this->ballStopPN = "GR022451";
                $this->ballStopPrice = $cmReelPrices['GR022451'];
            }elseif ($cableThick >= 0.47){
                $this->ballStopPN = "GR022450";
                $this->ballStopPrice = $cmReelPrices['GR022450'];
            }elseif($cableThick >= 0.25){
                $this->ballStopPN = "GR033030";
                $this->ballStopPrice = $cmReelPrices['GR033030'];
            }
             //'2018 price
        }

        if($printQuotedArrays[$index]->cableGripAssVal == "Yes"){
            if($cableThick >= 1.0){
                $this->cablegripPN = "GR602063";
                $this->cablegripPrice = $cmReelPrices['GR602063']; //'2018 prices
            }elseif($cableThick >= 0.75){
                $this->cablegripPN = "GR602062";
                $this->cablegripPrice = $cmReelPrices['GR602062'];
            }elseif($cableThick >= 0.63){
                $this->cablegripPN = "GR602061";
                $this->cablegripPrice = $cmReelPrices['GR602061'];
            }elseif($cableThick >= 0.5){
                $this->cablegripPN = "GR602060";
                $this->cablegripPrice = $cmReelPrices['GR602060'];
            }
        }

        //'hose clamps required for all UH & HM reels
        if($cableOrHose == "HS"){
            $this->getHosefittings($hoseIDcode);
        }
    }//End of method accessCMreel

    public function accessPreel($index, $printQuotedArrays, $cableThick){
        //Pull prices from DB into array $pReelPrices
        $pReelPrices = $this->getReelPrices('P');

        if($printQuotedArrays[$index]->cableGripAssVal == "Yes"){
            if($cableThick >= 1.25){
                $this->cablegripPN="GR027618";
                $this->cablegripPrice=$pReelPrices['GR027618'];
            }elseif($cableThick >= 1.0){
                $this->cablegripPN="GR027617";
                $this->cablegripPrice=$pReelPrices['GR027617'];
            }elseif ($cableThick >= 0.75){
                $this->cablegripPN="GR027616";
                $this->cablegripPrice=$pReelPrices['GR027616'];
            }elseif($cableThick >= 0.53){
                $this->cablegripPN="GR027615";
                $this->cablegripPrice=$pReelPrices['GR027615'];
            }elseif ($cableThick >= 0.41){
                $this->cablegripPN="GR027614";
                $this->cablegripPrice=$pReelPrices['GR027614'];
            }
        }
    }

    public function accessSHOTMRreel($index, $printQuotedArrays, $cableThick){
        //Pull prices from DB into array $shoReelPrices
        $shoReelPrices = $this->getReelPrices('SHO');

        if($printQuotedArrays[$index]->limitSwitchVal == "Yes"){
            switch ($printQuotedArrays[$index]->series){
                case "SHO":
                    $this->limitSwitchPN = "GR020831";
                    $this->limitSwitchPrice = $shoReelPrices['GR020831'];
                    break;
                case "TMR":
                    $this->limitSwitchPN = "GR020831";
                    $this->limitSwitchPrice = $shoReelPrices['GR020831'];
                    break;
            }
        }

        if($printQuotedArrays[$index]->cableGripAssVal == "Yes"){
            if($cableThick >= 1.25){
                $this->cablegripPN="GR027618";
                $this->cablegripPrice=$shoReelPrices['GR027618'];
            }elseif($cableThick >= 1.0){
                $this->cablegripPN="GR027617";
                $this->cablegripPrice=$shoReelPrices['GR027617'];
            }elseif ($cableThick >= 0.75){
                $this->cablegripPN="GR027616";
                $this->cablegripPrice=$shoReelPrices['GR027616'];
            }elseif($cableThick >= 0.53){
                $this->cablegripPN="GR027615";
                $this->cablegripPrice=$shoReelPrices['GR027615'];
            }elseif ($cableThick >= 0.41){
                $this->cablegripPN="GR027614";
                $this->cablegripPrice=$shoReelPrices['GR027614'];
            }
        }
    }//End method accessSHOTMRreel

     public function accessKreel($index, $printQuotedArrays, $cableThick){
        $kReelPrices = $this->getReelPrices('K');
        //debugbar::info($kReelPrices);

        if($printQuotedArrays[$index]->dogAndRatchetVal == "Yes"){
            $this->dogRatchetPN = "GR014209";
            $this->dogRatchetPrice = $kReelPrices['GR014209'];
        }
    }

    public function calcDelivery($printQuotedArrays, $index){

        $series = $printQuotedArrays[$index]->series;
        if($printQuotedArrays[$index]->quoteFlag == 1) {
            switch ($series) {
                case "S":
                case "MMD":
                    if ($printQuotedArrays[$index]->hazardVal == "Yes") {
                        $this->stdDelivery = "4-5 weeks ARO";
                    } else {
                        if ($printQuotedArrays[$index]->frame == "32") {
                            $this->stdDelivery = "3-4 weeks ARO";
                        } else {
                            $this->stdDelivery = "1-2 weeks ARO";
                        }
                    }
                    break;
                case "SM":
                    if ($printQuotedArrays[$index]->frame != "32") {
                        if ($printQuotedArrays[$index]->hazardVal == "Yes") {
                            $this->stdDelivery = "4-5 weeks ARO";
                        } else {
                            $this->stdDelivery = "3 weeks ARO";
                        }
                    } else {
                        $this->stdDelivery = "5 weeks ARO";
                    }
                    break;
                case "SHO":
                    $this->stdDelivery = "4-5 weeks ARO";
                    break;
                case "TMR":
                    $this->stdDelivery = "10-12 weeks ARO";
                    break;
                case "C":
                case "HM":
                    $this->stdDelivery = "1-2 weeks ARO";
                    break;
                case "K":
                case "UE":
                case "UH":
                    $this->stdDelivery = "2-3 weeks ARO";
                    break;
                case "P":
                    $this->stdDelivery = "4-5 weeks ARO";
                    break;
            }
        }
    }//End of calcDelivery method

    //WriteQuoteToDB
    public function writeQuoteToDB($data, $name, $quoteParameters, $printQuotedArrays){
        $ftOrM = "";
        $metricDefault = $data['metricDefault'];
        $quoteIdHold = $this->creatQuoteID($name);
        $this->quoteId = $quoteIdHold;
        $customer_name = $data['cust-name'];
        date_default_timezone_set('America/New_York');
        $quoteDate = date("Y-m-d H:i:s");
        $productLine = "Reel";
        $revision = "";
        $reelQty = $quoteParameters["numberOfReel"];
        $subject = $quoteParameters["quoteNotes"];
        $showDiscount = $quoteParameters["showDiscount"];
        $pkgID = $data['cable']['packageID'];
        $cableInclude = $quoteParameters["includeCableQuote"]; $cableInstall = $quoteParameters["includeCableInstall"]; $excabMoving = $quoteParameters["extraCableValue"];
        $showPrice = $quoteParameters["showItemPrice"]; $notes = $quoteParameters['notes']; $repID = $quoteParameters["preparedBy"]; $status = "Open"; $metric = $data["metricDefault"]; $pkgNote = $quoteParameters['pkgNote'];
        $cableThick = $data["cable"]["thickness"]; $cablePN = $data['cable']['pn']; $hoseIdCode = $data['cable']['hoseIDCode']; $cableOrHose = $data['cableOrHose'];
        $pdfFilepath = $quoteParameters['pdfFilepath'];
        $pkeyRep = $quoteParameters['pkeyRep'];
        $pkeyCust = $quoteParameters['pkeyCust'];


        //Debugbar::info("Troublesome vars");
        //Debugbar::info("PkgNote " . $pkgNote);
        //Debugbar::info("notes" . $notes);



        //Debugbar::info($quoteIdHold);
        switch($metricDefault){
            case false:
                $ftOrM = " m";
                break;
            case true:
                $ftOrM = " ft";
                break;
        }
        //Start a DB transaction to insert data to DB
        DB::beginTransaction();
                    DB::insert("insert into quotes values(NULL, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?,?,?,?,?,?,?,?,?,? )",
                array($quoteIdHold,$revision,$productLine,$customer_name,$quoteDate,$reelQty,$subject,$showDiscount,$pkgID,$cableInclude,$cableInstall,$excabMoving,$showPrice,$notes,$repID,$status,$metric,$pkgNote, $pdfFilepath, $pkeyRep, $pkeyCust));


            //Get the number of elements in the arrany of quoted models
        $arraySize = count($printQuotedArrays);
        for($modelTypeToStore=1; $modelTypeToStore <= 2; ++$modelTypeToStore){
            for($i=0; $i < $arraySize; $i++){
                if($printQuotedArrays[$i]->quoteFlag == $modelTypeToStore) {
                    $cableLength = $data["application"]["activeTravel"] + $quoteParameters["extraCableValue"] + $printQuotedArrays[$i]->extraCable;
                    if (($cableLength - (int)$cableLength) > 0) {
                        $cableLength = (int)$cableLength + 1;
                    }

                    //Reset all access variables
                    $this->accessClearVariables();

                    //Calculate accessory PN/Prices
                    $series = $printQuotedArrays[$i]->series;
                    $reelWidthInp = $data["initialCalcs"]["reelWidthInp"];
                    //if($printQuotedArrays[$i]->quoteFlag == 1) {

                        switch ($series) {
                            case "S":
                                $this->accessSreel($i, $printQuotedArrays, $cableThick);
                                break;
                            case "SM":
                                $this->accessSMreel($i, $printQuotedArrays, $cableThick);
                                break;
                            case "MMD":
                                $this->accessMMDreel($i, $printQuotedArrays, $cableThick);
                                break;
                            case "UE":
                            case "UH":
                                $this->accessUreel($i, $printQuotedArrays, $cableThick, $reelWidthInp, $cableOrHose, $hoseIdCode);
                                break;
                            case "C":
                                $this->accessCMreel($i, $printQuotedArrays, $cableThick, $cableOrHose, $hoseIdCode);
                                break;
                            case "P":
                                $this->accessPreel($i, $printQuotedArrays, $cableThick);
                                break;
                            case "SHO":
                            case "TMR":
                                $this->accessSHOTMRreel($i, $printQuotedArrays, $cableThick);
                                break;
                            case "HM":
                                $this->accessCMreel($i, $printQuotedArrays, $cableThick, $cableOrHose, $hoseIdCode);
                                break;
                            case "K":
                                $this->accessKreel($i, $printQuotedArrays, $cableThick);
                                break;
                        }
                   // }

                    $widthDimension = $printQuotedArrays[$i]->dimWidth;
                    $totalReelWeight = $printQuotedArrays[$i]->modelWgt;
                    $totalReelPrice = $printQuotedArrays[$i]->totalReelPrice;

                    //'check for hazard duty or rev rotate
                   // if($printQuotedArrays[$i]->quoteFlag == 1) {
                        $writeQuoteToDBPrices = $this->getReelPrices('writeQuoteToDB');
                        //debugbar::info($writeQuoteToDBPrices);

                        if ($printQuotedArrays[$i]->hazardVal == "Yes") { //'increase weight/dimension for hazard duty per S. Schmitz
                            $widthDimension = $widthDimension + 6;
                            $totalReelWeight = $totalReelWeight + 50;
                            switch ($series) {
                                case "S":
                                    $totalReelPrice = $totalReelPrice + $writeQuoteToDBPrices['totalREELprice_S'];
                                    break;
                                case "MMD":
                                    $totalReelPrice = $totalReelPrice + $writeQuoteToDBPrices['totalREELprice_MMD'];
                                    break;
                            }
                        }
                   // }

                    //if($printQuotedArrays[$i]->quoteFlag == 1) {
                        if ($printQuotedArrays[$i]->revRotVal == "Yes") {
                            switch ($series) {
                                case "SHO":
                                case "TMR":
                                    //Do nothing
                                    break;
                                case "K":
                                    $totalReelPrice = $totalReelPrice + $writeQuoteToDBPrices['totalREELprice_K'];
                                    break;
                                default: //'S, SM, MMD
                                    $totalReelPrice = $totalReelPrice + $writeQuoteToDBPrices['totalREELprice_Others'];
                            }
                        }
                    //}

                    $this->calcDelivery($printQuotedArrays, $i);

                    $harzardDuty = ""; $reverseRotate = ""; $modelNumber = $printQuotedArrays[$i]->modelNum; $reelHeight = $printQuotedArrays[$i]->dimHeight; $reelWidth = $widthDimension;
                    $reelDepth = $printQuotedArrays[$i]->dimDepth; $reelWeight = $totalReelWeight; $reqdExtraCable = $printQuotedArrays[$i]->extraCable; $stdDelivery = $this->stdDelivery;
                    $modelNote = "";
                    //if($printQuotedArrays[$i]->quoteFlag == 1){
                        $harzardDuty = $printQuotedArrays[$i]->hazardVal;
                        $reverseRotate = $printQuotedArrays[$i]->revRotVal;
                    //}

                    $quoteType = 0;
                    if($printQuotedArrays[$i]->quoteFlag > 0){
                        $quoteType = $printQuotedArrays[$i]->quoteFlag;
                    }

                    DB::insert("insert into qtemodel values(NULL, ?,?,?,?,?,?,?,?,?,?,?,?,?,?)",
                        array($quoteIdHold, $series, $modelNumber, $harzardDuty, $reverseRotate, $reqdExtraCable,$reelHeight, $reelWidth, $reelDepth, $reelWeight, "", $quoteType, $stdDelivery, $modelNote));
                    $this->stdDelivery = "";
                    $pdo = DB::connection()->getPdo(); //Returns the pdo instance
                    $modIDhold = $pdo->lastInsertId();

                    $qty = 1; //qty calculated in report
                    $descrip = "";
                    switch ($series){
                        case "S":
                            $descrip = " Heavy Duty Cable Reel";
                            break;
                        case "SM":
                            $descrip = " Extra Heavy Duty Cable Reel";
                            break;
                        case "MMD":
                            $descrip = " Mill Duty Cable Reel";
                            break;
                        case "SHO":
                            $descrip = " Spring-driven Cable Reel";
                            break;
                        case "TMR":
                            $descrip = " Motor-driven Cable Reel";
                            break;
                        case "UE":
                            $descrip = " Electric Cable Reel";
                            break;
                        case "UH":
                        case "HM":
                            $descrip = " Hose Reel";
                            break;
                        case "C":
                            $descrip = " Electric Cable Reel";
                            break;
                        case "P":
                            $descrip = " Pendant Station Cable Reel";
                            break;
                        case "K":
                            $descrip = " Dual Hose Reel";
                            break;
                    }
                    $description = $modelNumber . $descrip;

                    $price = 0;
                    if($totalReelPrice > 0){
                        $price = $totalReelPrice;
                    }
                    DB::insert("insert into quotedetails values(null, ?, ?, ?, ?, ?, ?, ?)",
                        array($modIDhold, $qty, "", $description, $price, $quoteIdHold, $modelNumber));

                    //add rollerguide to quote
                    if($this->rollerGuidePN != ""){
                        $description = $printQuotedArrays[$i]->rollerGuideMat . " " . $printQuotedArrays[$i]->rollerGuideApp . " Roller guides";
                        $pn = $this->rollerGuidePN;
                        if($this->rollerGuidePrice > 0){
                            $price = $this->rollerGuidePrice;
                        }
                        DB::insert("insert into quotedetails values(null, ?, ?, ?, ?, ?, ?, ?)",
                            array($modIDhold, $qty, $pn, $description, $price, $quoteIdHold, $modelNumber));
                    }

                    //add hoopguide to qote
                    if($this->hoopGuidePN != ""){
                        $pn = $this->hoopGuidePN;
                        $description = "Hoop Guide Assembly";
                        if($this->hoopGuidePrice > 0){
                            $price = $this->hoopGuidePrice;
                        }
                        DB::insert("insert into quotedetails values(null, ?, ?, ?, ?, ?, ?, ?)",
                            array($modIDhold, $qty, $pn, $description, $price, $quoteIdHold, $modelNumber));
                    }

                    //add limitswitch
                    if($this->limitSwitchPN != ""){
                        $pn = $this->limitSwitchPN;
                        $description = "Limit Switch Assembly";
                        if($this->limitSwitchPrice > 0){
                            $price = $this->limitSwitchPrice;
                        }
                        DB::insert("insert into quotedetails values(null, ?, ?, ?, ?, ?, ?, ?)",
                            array($modIDhold, $qty, $pn, $description, $price, $quoteIdHold, $modelNumber));
                    }

                    //add pivotbase to quote
                    if ($this->pivotBasePN != ""){
                        $pn = $this->pivotBasePN;
                        $description = "340 Degree Pivot";
                        if($this->pivotBasePrice > 0){
                            $price = $this->pivotBasePrice;
                        }

                        DB::insert("insert into quotedetails values(null, ?, ?, ?, ?, ?, ?, ?)",
                            array($modIDhold, $qty, $pn, $description, $price, $quoteIdHold, $modelNumber));
                    }

                    //add dogratchet to quote
                    if($this->dogRatchetPN != ""){
                        $pn = $this->dogRatchetPN;
                        $description = "Dog & Ratchet Assembly";
                        if($this->dogRatchetPrice > 0){
                            $price = $this->dogRatchetPrice;
                        }
                        DB::insert("insert into quotedetails values(null, ?, ?, ?, ?, ?, ?, ?)",
                            array($modIDhold, $qty, $pn, $description, $price, $quoteIdHold, $modelNumber));
                    }

                    //add spool lock to quote
                    if($this->spoolLockPN != ""){
                        $pn = $this->spoolLockPN;
                        $description = "Spool Lock Assembly";
                        if($this->spoolLuckPrice > 0){
                            $price = $this->spoolLuckPrice;
                        }
                        DB::insert("insert into quotedetails values(null, ?, ?, ?, ?, ?, ?, ?)",
                            array($modIDhold, $qty, $pn, $description, $price, $quoteIdHold, $modelNumber));
                    }

                    //add ballstop to quote
                    if($this->ballStopPN != ""){
                        $pn = $this->ballStopPN;
                        $description = "Ball stop Assembly";
                        if($this->ballStopPrice > 0){
                            $price = $this->ballStopPrice;
                        }
                        DB::insert("insert into quotedetails values(null, ?, ?, ?, ?, ?, ?, ?)",
                            array($modIDhold, $qty, $pn, $description, $price, $quoteIdHold, $modelNumber));
                    }

                    //add cable grip to quote
                    if($this->cablegripPN != ""){
                        $pn = $this->cablegripPN;
                        $description = "Cable Grip Assembly";
                        if($this->cablegripPrice > 0){
                            $price = $this->cablegripPrice;
                        }
                        DB::insert("insert into quotedetails values(null, ?, ?, ?, ?, ?, ?, ?)",
                            array($modIDhold, $qty, $pn, $description, $price, $quoteIdHold, $modelNumber));
                    }

                    //add cable if requested
                    if($pkgID != 0){
                        if ($quoteParameters["includeCableQuote"] == "Yes"){
                            if($series == "UH" || $series == "HM"){
                                if($series == "UH"){
                                    $this->hoseFittingQty = 2;
                                }else{
                                    $this->hoseFittingQty = 1;
                                }
                                $qty = $this->hoseFittingQty;
                                $pn = $this->malePipePN;
                                $description = "Male Pipe Fittings";
                                if($this->malePipePrice > 0){
                                    $price = $this->malePipePrice;
                                }
                                DB::insert("insert into quotedetails values(null, ?, ?, ?, ?, ?, ?, ?)",
                                    array($modIDhold, $qty, $pn, $description, $price, $quoteIdHold, $modelNumber));

                                //add clamps
                                if($hoseIdCode < 9){ //We need 1 if 1/2" or less, otherwise 2
                                    $qty = 1;
                                }else{
                                    $qty = 2;
                                }
                                $pn = $this->hoseClampPN;
                                $description = "Clamp for Male Pipe Fitting";

                                if($this->hoseClampPrice > 0){
                                    $price = $this->hoseClampPrice;
                                }
                                DB::insert("insert into quotedetails values(null, ?, ?, ?, ?, ?, ?, ?)",
                                    array($modIDhold, $qty, $pn, $description, $price, $quoteIdHold, $modelNumber));

                                if($hoseIdCode < 9){
                                    $qty = 1;
                                    $pn = $this->hoseFerrulePN;
                                    $description = "Hose Ferrules (1 per hose reqd)";
                                     if($this->hoseFerrulePrice > 0){
                                         $price = $this->hoseFerrulePrice;
                                     }
                                    DB::insert("insert into quotedetails values(null, ?, ?, ?, ?, ?, ?, ?)",
                                        array($modIDhold, $qty, $pn, $description, $price, $quoteIdHold, $modelNumber));
                                }

                            }

                           $qty = 1;
                            $pn = $cablePN;
                            $pkgDescription = "Cable/Hose: " . $cableLength;
                            switch($metricDefault){
                                case true:
                                    $pkgDescription = $pkgDescription . " m ";
                                    break;
                                case false:
                                    $pkgDescription = $pkgDescription . " ft ";
                                    break;
                            }
                            switch($cableOrHose){
                                case "HD":
                                case "HS":
                                    switch($metricDefault){
                                        case true:
                                            $pkgDescription = $pkgDescription . $data['cable']['style'] . ", " . $data['cable']['cableID'] . " mm" . " I.D ";
                                            break;
                                        case false:
                                            $pkgDescription = $pkgDescription . $data['cable']['style'] . ", " . $data['cable']['cableID'] . "" . " I.D ";
                                            break;
                                    }
                                    if($cableOrHose == "HD"){
                                        $pkgDescription = $pkgDescription . " w/fittings";
                                    }
                                    break;
                                default:
                                    $pkgDescription = $pkgDescription . "Round ";
                                    if($data['cable']['type'] == "O" || $data['cable']['type'] == "HV"){
                                        switch(Number($data['cable']['volts'])){
                                            case 600:
                                                $pkgDescription = $pkgDescription . "600V ";
                                                break;
                                            case 5000:
                                                $pkgDescription = $pkgDescription . "5 KV ";
                                                break;
                                            case 8000:
                                                $pkgDescription = $pkgDescription . "8 KV ";
                                                break;
                                            case 15000:
                                                $pkgDescription = $pkgDescription . "15 KV ";
                                                break;
                                        }
                                    }else{
                                        $pkgDescription = $pkgDescription . $data['cable']['type'] . " ";
                                    }

                                    $pkgDescription = $pkgDescription  . $data['cable']['cond'] . "C-";
                                    switch($metricDefault){
                                        case true:
                                            $pkgDescription = $pkgDescription . $data['cable']['awg'] . "mm2";
                                            break;
                                        case false:
                                            $pkgDescription = $pkgDescription . $data['cable']['awg'] . "AWG";
                                    }
                                    $pkgDescription = $pkgDescription . " Cable";
                            }//Switch($cableOrHose)
                            $description = $pkgDescription . "*";
                            if($cableOrHose == "C" && $data['cable']['INSTL_FIX'] > 0 && $quoteParameters["includeCableInstall"] == "Yes"){
                                $roundedInstallPrice = $data['cable']['INSTL_FIX'] + ($data['cable']['installFoot'] * $cableLength);
                                $price = $roundedInstallPrice;
                            }else{
                                $price = $cableLength * $data['cable']['price'];
                            }
                            DB::insert("insert into quotedetails values(null, ?, ?, ?, ?, ?, ?, ?)",
                                array($modIDhold, $qty, $pn, $description, $price, $quoteIdHold, $modelNumber));
                        }
                    }
                }//Condition: checking quoteFlag==modelTypeToStore
                    //TODO: Get the value of securityCode from user profile
                $securityCode = 99;

                if($securityCode == 5){
                    DB::update('update quotedetails set price = 0 where modelID = ?', array($modIDhold));
                }

            }//End of for: checking quoted-models
        }//End of for loop modelTypeToStore

        //Add application parameters
        $travel = $data["application"]["activeTravel"];
        $speed = $data["application"]["travelSpeed"];
        $accel = $data["application"]["accel"];
        $application = $data["application"]["appl"]; $pendantWeight=""; $percentSAGstr=""; $centerlineHeight="";
        switch($application){
            case "lift":
            case "magnet":
                $pendantWeight = $data["application"]["pendantWeight"];
                break;
            case "stretch":
                $percentSAGstr = $data["application"]["cableSag"];
                break;
            case "retrieve":
            case "hand":
                $centerlineHeight = $data["application"]["centerline"];
                break;
        }
        $dutyCycle = ""; $appNote = "";
        $ambTempMin = $data["application"]["ambientTemp"]["min"];
        $ambTempMax = $data["application"]["ambientTemp"]["max"];
        $springTurns = $data["application"]["springTurns"];
        $deadWraps = $data["application"]["deadWraps"];
        $ccf = $data["application"]["ccf"];

        DB::insert("insert into reelapp values(null, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)",
            array($quoteIdHold, $application, $percentSAGstr, $pendantWeight, $centerlineHeight, $travel, $speed, $accel, $dutyCycle, $ambTempMin, $ambTempMax, $springTurns, $ccf, $deadWraps, $appNote));

        //Add quote discounts
        $sReelDisc1 = $quoteParameters["discountSReel"]; $sReelDisc2 = $quoteParameters["addDiscountSReel"]; $mmdReelDisc1 = $quoteParameters["discountMMDReel"]; $mmdReelDisc2 = $quoteParameters["addDiscountMMDReel"];
        $smReelDisc1= $quoteParameters["discountSMReel"]; $smReelDisc2= $quoteParameters["addDiscountSMReel"]; $shoReelDisc1=$quoteParameters["discountSHOReel"]; $shoReelDisc2=$quoteParameters["addDiscountSHOReel"];
        $tmrReelDisc1 = $quoteParameters["discountTMRReel"]; $tmrReelDisc2 =$quoteParameters["addDiscountTMRReel"]; $ueReelDisc1=$quoteParameters["discountUReel"]; $ueReelDisc2=$quoteParameters["addDiscountUReel"];
        $cmReelDisc1=$quoteParameters["discountCMReel"]; $cmReelDisc2=$quoteParameters["addDiscountCMReel"]; $pReelDisc1=$quoteParameters["discountPendantReel"]; $pReelDisc2=$quoteParameters["addDiscountPendantReel"];
        $uhReelDisc1=$quoteParameters["discountUHReel"]; $uhReelDisc2=$quoteParameters["addDiscountUHReel"]; $kReelDisc1=$quoteParameters["discountKReel"]; $kReelDisc2=$quoteParameters["addDiscountKReel"];
        $hmReelDisc1=$quoteParameters["discountHMReel"]; $hmReelDisc2=$quoteParameters["addDiscountHMReel"];

        DB::insert("insert into qtedisc values(null, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)",
            array($quoteIdHold, $sReelDisc1, $sReelDisc2, $mmdReelDisc1, $mmdReelDisc2, $smReelDisc1, $smReelDisc2, $shoReelDisc1, $shoReelDisc2, $tmrReelDisc1, $tmrReelDisc2, $ueReelDisc1, $ueReelDisc2, $cmReelDisc1, $cmReelDisc2, $pReelDisc1, $pReelDisc2, $uhReelDisc1, $uhReelDisc2, $kReelDisc1, $kReelDisc2, $hmReelDisc1, $hmReelDisc2));

        DB::commit();
    }//End of writeQuoteToDB

    public function readQuoteFromDB($quoteID){

    }

    public function updateQuotedArray($printQuotedArrays, $quoteParameters){
        $numPrintQuote = count($printQuotedArrays);
        for($i=0; $i < $numPrintQuote; $i++){
            if($printQuotedArrays[$i]->series == "S"){
                $printQuotedArrays[$i]->discount = $quoteParameters["discountSReel"];
                $printQuotedArrays[$i]->addDiscount = $quoteParameters["addDiscountSReel"];
            }
            if($printQuotedArrays[$i]->series == "MMD"){
                $printQuotedArrays[$i]->discount = $quoteParameters["discountMMDReel"];
                $printQuotedArrays[$i]->addDiscount = $quoteParameters["addDiscountMMDReel"];
            }
            if($printQuotedArrays[$i]->series == "SM"){
                $printQuotedArrays[$i]->discount = $quoteParameters["discountSMReel"];
                $printQuotedArrays[$i]->addDiscount = $quoteParameters["addDiscountSMReel"];
            }
            if($printQuotedArrays[$i]->series == "SHO"){
                $printQuotedArrays[$i]->discount = $quoteParameters["discountSHOReel"];
                $printQuotedArrays[$i]->addDiscount = $quoteParameters["addDiscountSHOReel"];
            }
            if($printQuotedArrays[$i]->series == "TMR"){
                $printQuotedArrays[$i]->discount = $quoteParameters["discountTMRReel"];
                $printQuotedArrays[$i]->addDiscount = $quoteParameters["addDiscountTMRReel"];
            }
            if($printQuotedArrays[$i]->series == "C"){
                $printQuotedArrays[$i]->discount = $quoteParameters["discountCMReel"];
                $printQuotedArrays[$i]->addDiscount = $quoteParameters["addDiscountCMReel"];
            }
            if($printQuotedArrays[$i]->series == "UE"){
                $printQuotedArrays[$i]->discount = $quoteParameters["discountUReel"];
                $printQuotedArrays[$i]->addDiscount = $quoteParameters["addDiscountUReel"];
            }
            if($printQuotedArrays[$i]->series == "UH"){
                $printQuotedArrays[$i]->discount = $quoteParameters["discountUHReel"];
                $printQuotedArrays[$i]->addDiscount = $quoteParameters["addDiscountUHReel"];
            }
            if($printQuotedArrays[$i]->series == "HM"){
                $printQuotedArrays[$i]->discount = $quoteParameters["discountHMReel"];
                $printQuotedArrays[$i]->addDiscount = $quoteParameters["addDiscountHMReel"];
            }
            if($printQuotedArrays[$i]->series == "P"){
                $printQuotedArrays[$i]->discount = $quoteParameters["discountPendantReel"];
                $printQuotedArrays[$i]->addDiscount = $quoteParameters["addDiscountPendantReel"];
            }
            if($printQuotedArrays[$i]->series == "K"){
                $printQuotedArrays[$i]->discount = $quoteParameters["discountKReel"];
                $printQuotedArrays[$i]->addDiscount = $quoteParameters["addDiscountKReel"];
            }
        }//End of for-statement
    }
    
    //Creates a PDF from parameters and returns it
    public function printQuote() {
        //the quote parameters are pulled from the Print Options popup after cicking printQuote

        $quoteParameters = array(
            "numberOfReel" => Input::get('numberOfReels'), "preparedBy" => Input::get('preparedBy'), "quoteNotes" => Input::get('quoteNotes'),
            "printQuotedArrays" => Input::get('printQuotedArrays'),
            "discountSReel" => Input::get('discountSReel'), "addDiscountSReel" => Input::get('addDiscountSReel'),
            "discountMMDReel" => Input::get('discountMMDReel'), "addDiscountMMDReel" => Input::get('addDiscountMMDReel'),
            "discountSMReel" => Input::get('discountSMReel'), "addDiscountSMReel" => Input::get('addDiscountSMReel'),
            "discountSHOReel" => Input::get('discountSHOReel'), "addDiscountSHOReel" => Input::get('addDiscountSHOReel'),
            "discountTMRReel" => Input::get('discountTMRReel'), "addDiscountTMRReel" => Input::get('addDiscountTMRReel'),
            "discountCMReel" => Input::get('discountCMReel'), "addDiscountCMReel" => Input::get('addDiscountCMReel'),
            "discountUReel" => Input::get('discountUReel'), "addDiscountUReel" => Input::get('addDiscountUReel'),
            "discountPendantReel" => Input::get('discountPendantReel'), "addDiscountPendantReel" => Input::get('addDiscountPendantReel'),
            "discountKReel" => Input::get('discountKReel'), "addDiscountKReel" => Input::get('addDiscountKReel'),
            "discountUHReel" => Input::get('discountUHReel'), "addDiscountUHReel" => Input::get('addDiscountUHReel'),
            "discountHMReel" => Input::get('discountHMReel'), "addDiscountHMReel" => Input::get('addDiscountHMReel'),
            "showDiscount" => Input::get('showDiscount'),  "showItemPrice" => Input::get('showItemPrice'),
            "includeCableQuote" => Input::get('includeCableQuote'), "includeCableInstall" => Input::get('includeCableInstall'),
            "showReelDesc" => Input::get('showReelDesc'), "includeDimDrwaings" => Input::get('includeDimDrwaings'),
            "extraCableValue" => Input::get('extraCableValue'), "quoteFormat" => Input::get('quoteFormat'), "appNote" => Input::get('appNote'),
            "pkgNote" => Input::get('pkgNote'), "notes" => Input::get('notes')
        );
       //reNotes is also pulled from Print Options
        $reNotes = Input::get('quoteNotes');

        //data comes from the main calculations, loaded from where it is encoded in the html , and must be decoded to be loaded. All other vars will pull from $data
        $data = unserialize(base64_decode(Input::get('str_var')));
        $preparedBy = $quoteParameters["preparedBy"]; //$array=json_decode($_POST['jsondata']);
        $printQuotedArrays = $quoteParameters["printQuotedArrays"];
        $printQuotedArrays = json_decode($printQuotedArrays);
        $numPrintQuote = count($printQuotedArrays);

        //filepath info, done here so that it may be written to DB
        $outputName = str_random(10) . "QUOTE"; // str_random is a [Laravel helper](http://laravel.com/docs/helpers#strings)


        //switch for pdf / word
        if($quoteParameters["quoteFormat"] == "pdf") {

            //filepath for this quote
            $pdfPath = "./public/images/tempQuote/" . $outputName . '.pdf';
            //get customer ID
        }
        elseif($quoteParameters["quoteFormat"] == "word"){

           //start phpword library (converts html to docx files)
            $pw = new \PhpOffice\PhpWord\PhpWord();

            //still saves to the same spot in the database, leaving only the option for either/or pdf quotes or docx quotes
            $pdfPath = "./public/images/tempQuote/" . $outputName .'.docx';

        }





        $custName = $data['cust-name'];
        $currentCust = Customer::where('name', '=', $custName)->first();
        $currentCustID = $currentCust->id;

        $userID = Auth::user()->id;

        //add userID, CustID, and filepath to quote params
        $quoteParameters['pdfFilepath'] = $pdfPath;
        $quoteParameters['pkeyCust'] = $currentCustID;
        $quoteParameters['pkeyRep'] = $userID;


        $this->updateQuotedArray($printQuotedArrays, $quoteParameters);//update $printQuotedArrays with discount values
        Debugbar::info($printQuotedArrays);
        Debugbar::info($quoteParameters["preparedBy"]);
        Debugbar::info($data);

        $this->writeQuoteToDB($data, $preparedBy, $quoteParameters, $printQuotedArrays);

        $custcomp = $data['cust-comp'];
        $custname = $data['cust-name'];
        $custaddr = $data['cust-addr'];
        $custphone = $data['cust-phone'];

        Debugbar::info($data['cust-name']);
        Debugbar::info($data['cust-comp']);
        Debugbar::info($data['cust-addr']);
        Debugbar::info($data['cust-phone']);

        $date = date("m/d/Y");
        $modelNumber = $data['vr']['modelNum'];
        $width = $data['vr']['dimWidth'];
        $height = $data['vr']['dimHeight'];
        $depth = $data['vr']['dimDepth'];
        $wgt = $data['vr']['modelWgt'];
        $type = $data['cable']['type'];
        $awg = $data['cable']['awg'];
        $cond = $data['cable']['cond'];
        $c_weight = $data['cable']['weight'];
        $bendRad = $data['cable']['bendRadius'];
        $volts = $data['cable']['volts'];
        $pn = $data['cable']['pn'];
        $reelPrice = $data['vr']['totalReelPrice'];

        $cableWeight = $data["cable"]["weight"];
        $exCabMoving = $quoteParameters["extraCableValue"];
        $travel = $data["application"]["activeTravel"];

        //Build new report template
        $htmlToPDF = ""; $tableHeader = "";
        for($i = 0; $i < $numPrintQuote; $i ++) {
            $quoteflag = $printQuotedArrays[$i]->quoteFlag;
            if($quoteflag == 1){
                $tableHeader = "Recommended Model: " . $printQuotedArrays[$i]->modelNum;
            }else if($quoteflag == 2){
                $tableHeader = "Alternative Model: " . $printQuotedArrays[$i]->modelNum;
            }
            $getDelivery = DB::select('select * from qtemodel where QuoteID = ? and ModelNum = ?', array($this->quoteId, $printQuotedArrays[$i]->modelNum));
            $getQuoteDetails = DB::select('select * from quotedetails where quoteid = ? and modelnum = ?', array($this->quoteId, $printQuotedArrays[$i]->modelNum));

            $total = 0;

            $count = $i + 1;
            for($e = 0; $e < count($getQuoteDetails); $e++){
                $total = $total + $getQuoteDetails[$e]->price;
            }

            //Apply discounts if available
            $discount = $printQuotedArrays[$i]->discount;
            $addDiscount = $printQuotedArrays[$i]->addDiscount;
            $discountedAmt = 0; $addDiscountedValue = 0; $totalFinal = 0; $displayDiscount = ""; $totalDiscountedValue = 0;
            if($discount > 0){
                $discountedAmt = $total * ($discount/100 );
                $totalFinal = $total - $discountedAmt;
                $totalDiscountedValue = $discountedAmt;
                $displayDiscount = "Less ".$discount."%";
                if($addDiscount > 0){
                    $addDiscountedValue = $totalFinal * ($addDiscount / 100);
                    $totalFinal = $totalFinal - $addDiscountedValue;
                    $totalDiscountedValue = $totalDiscountedValue + $addDiscountedValue;
                    $displayDiscount = $displayDiscount . " + ".$addDiscount."%";
                }
            }
            $total = number_format($total, 2);
            $displayDiscount = $displayDiscount . ':';
            $totalFinal = number_format($totalFinal, 2);
            $totalDiscountedValue = number_format($totalDiscountedValue, 2);

            $reqdExtraCable = $printQuotedArrays[$i]->extraCable;
            $estimatedCableWeight = ($cableWeight * ($exCabMoving + $travel + $reqdExtraCable));
            $estimatedCableWeight = round($estimatedCableWeight, 1);

            //Add Notes to quote
            $appNote = $quoteParameters["appNote"]; $pkgNote = $quoteParameters['pkgNote']; $modNote = $printQuotedArrays[$i]->modNote; $notes = $quoteParameters['notes'];

            $html2 = '
          <!DOCTYPE html>
             <html>
                <head>
                    
                </head>   
                <body>
                    <div class="content" style="margin-top: 0; font-size: 12px">
                        <div class="row">
                            <table style="width: 100%; border: 0; margin-top: 0">                               
                                <tr>
                                    <td><h1>Quotation</h1></td><td><img alt="image" width=224 height=68 src="./public/images/defau000.jpg"></td><td>Date:' . $date . '<br /> <br />Quote #: ' . $this->quoteId . ' </td>
                                </tr>
                            </table>
                            <table style="width: 80%; border: 0; margin-top: 0">
                                <tr>
                                    <td><u>QUOTE FOR:</u> <br/>
                                       ' . $custcomp . ' <br/>
                                       ' . $custaddr . ' <br />
                                       Phone:  ' . $custphone . '
                                    </td>
                                    <td>
                                        <u>REPLY TO:</u> <br/>
                                        Gleason Reel Corporation<br/>
                                        c/o Gleason Reel <br/>
                                        600 South Clark Street <br/>
                                        MayVille WI <br/>
                                        Phone: 920-387-7308 <br/>
                                        Fax: 920-387-4189 <br/>
                                        E-Mail: sschmitz@hubbell.com
                                  
                                    </td>
                                </tr>
                                <tr><td colspan="2">&nbsp;</td></tr>
                                <tr>
                                    <td>Attn: ' . $custname . '</td> <td>&nbsp;</td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td> <td style="font-size: 10px">&nbsp;&nbsp;&nbsp;Please make all P.O\'s out to Gleason Reel - 600S. Clark St. MayVille WI  </td>
                                </tr>
                            </table>
                            <br/>
                            <span style="font-size: 14px; font-weight: bold">Re: </span>'. $quoteParameters["quoteNotes"].' <br/>
                            <hr/>
                            <p style="font-size: 14px">This quotation is based upon the following application parameters.  If the parameters shown below don\'t accurately reflect your application, please contact us and we will review and adjust this quote if necessary:</p>
                            
                            
                            <table style="width: 100%; border: 0; margin-top: 0;font-size: 14px;" cellpadding="0px"> 
                                <tr>
                                    <td ><span style=" border: 1px solid; box-shadow: 5px 10px; padding: 10px; margin-top: 0px"> APPLICATION: </span></td>
                                    <td>
                                        <span style="font-weight: bold">Application: </span> ' . $data['application']['appl'] . ' <br/><br/>
                                        <span style="font-weight: bold">Travel: </span> ' . $data['application']['activeTravel'] . ' ft<br/><br/>';
										
										if($data['application']['appl'] == "retrieve"){
                                            $html2 = $html2 . '<span style="font-weight: bold">Centerline Height: </span> ' . $data['application']['centerline'] . ' feet';
                                        }else{
                                            $html2 = $html2 . '<span style="font-weight: bold">Pendant Weight: </span> ' . $data['application']['pendantWeight'] . ' lbs';
                                        }
										
										$html2 = $html2 . ' 
                                    </td>
                                    <td>
                                        <span style="font-weight: bold">Ambient Temp: </span> ' . $data['application']['ambientTemp']['min'] . ' - ' . $data['application']['ambientTemp']['max'] . ' degrees F <br/><br/>
                                        <span style="font-weight: bold">Speed: </span> ' . $data['application']['travelSpeed'] . ' feet/min <br/><br/>
                                        <span style="font-weight: bold">Acceleration: </span> ' . $data['application']['accel'] . ' feet/sec<span style="vertical-align: super; font-size: smaller">2</span>
                                    </td></tr>';
                                        if($appNote != ""){
                                            $html2 = $html2 . '<tr><td colspan="3"> '.$appNote. ' </td></tr>';
                                        }
                        $html2 = $html2 . '
                            </table>
                          
                            <table style="width: 100%; border: 0; margin-top: 0;font-size: 14px;" cellpadding="0px"> 
                                <tr>
                                    <td colspan="7"><span style=" border: 1px solid; box-shadow: 5px 10px; padding: 10px; margin-top: 0px"> CABLE: </span> <span style="font-size: 12px">&nbsp;&nbsp;&nbsp;&nbsp;*** Note: Cable/Hose price(s) subject to change at time of order. ***</span></td>
                                </tr>
                                <tr>
                                    <td> <u>Type</u><br/>
                                            ' . $data["cable"]["type"] . '
                                    </td>
                                    <td> <u>AWG</u><br/>
                                            ' . $data["cable"]["awg"] . '
                                    </td>
                                    <td> <u>Cond</u><br/>
                                            ' . $data["cable"]["cond"] . '
                                    </td>
                                    <td> <u>O.D (in)</u><br/>
                                            ' . $data["cable"]["thickness"] . '
                                    </td>
                                    <td> <u>Weight (lbs/ft)</u><br/>
                                            ' . $data["cable"]["weight"] . '
                                    </td>
                                    <td> <u>Bend Radius (in)</u><br/>
                                            ' . $data["cable"]["bendRadius"] . '
                                    </td>
                                    <td> <u>Volts</u><br/>
                                            ' . $data["cable"]["volts"] . '
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="7">&nbsp;</td>
                                </tr>
                                <tr>
                                    <td colspan="3"> <span style="font-weight: bold">Cable required for hookup: </span>' . number_format($printQuotedArrays[$i]->extraCable, 1). ' feet</td>
                                    <td colspan="4"> <span style="font-weight: bold; padding:0% 14%">Additional cable at moving end: </span> '. number_format($quoteParameters["extraCableValue"], 1).' feet </td>
                                </tr>';
                                        if($pkgNote != ""){
                                            $html2 = $html2 . '<tr><td colspan="7"> '.$pkgNote.' </td></tr>';
                                        }
                                        $html2 = $html2 . '
                            </table>
                            <br/>
                            <table style="width: 100%; border: 0; margin-top: 0;font-size: 14px;" cellpadding="0px"> 
                                <tr>
                                    <td colspan="4"><span style=" border: 1px solid; box-shadow: 5px 10px; padding: 10px; margin-top: 0px"> REEL DATA: </span> <span style="font-size: 12px">&nbsp;&nbsp;&nbsp;&nbsp;</span></td>
                                </tr>
                                <tr>
                                    <td><span style="font-weight: bold;">&nbsp;&nbsp;&nbsp;&nbsp;  Appox. dimension:</span></td>
                                    <td><span style="font-weight: bold;">&nbsp;&nbsp;&nbsp;&nbsp; <u>Width</u> </span><br />
                                       &nbsp; &nbsp;&nbsp; &nbsp;' .$printQuotedArrays[$i]->dimWidth . '
                                     </td>
                                     <td>   <span style="font-weight: bold;">&nbsp;&nbsp;&nbsp;&nbsp; <u>Height</u> </span><br />
                                      &nbsp; &nbsp;&nbsp; &nbsp;   ' . $printQuotedArrays[$i]->dimHeight. '
                                     </td> 
                                     <td> <span style="font-weight: bold;">&nbsp;&nbsp;&nbsp;&nbsp; <u>Depth</u> </span><br />
                                        &nbsp; &nbsp;   ' .$printQuotedArrays[$i]->dimDepth . '                              
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="4">
                                        <span style="font-weight: bold;">&nbsp;&nbsp;&nbsp;&nbsp; Estimated reel weight:  &nbsp;&nbsp;&nbsp;&nbsp;</span>  ' .$printQuotedArrays[$i]->modelWgt . ' lbs
                                     </td>
                                </tr>
                                <tr>
                                    <td colspan="4"><br/>
                                        <span style="font-weight: bold;">&nbsp;&nbsp;&nbsp;&nbsp; Estimated cable weight:  &nbsp;&nbsp;&nbsp;&nbsp;</span> ' . $estimatedCableWeight . ' lbs
                                     </td>
                                </tr>
                            </table>
                            <br/>
                            <table style=" width: 100%" border="1px">
                                <tr>
                                    <td colspan="6"> <span style="font-weight: bold"> ' .$count . ') &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;' . $tableHeader. '   </span> <span style="font-weight: bold; display:inline-block; width:30%; margin-left: 35%">&emsp;&ensp;Shipment:&nbsp;&nbsp;&nbsp;&nbsp;' . $getDelivery[0]->Delivery. ' </span></td>
                                </tr>';
                                        if($modNote != ""){
                                            $html2 = $html2 . '<tr><td colspan="5">' .$modNote. '</td></tr>';
                                        }

                                 $html2 = $html2 . '       
                                 
                                  <tr>
                                    <td colspan="6" align="center"> <span style="font-weight: bold;" >*** Bill of Material *** </span></td>
                                  </tr>
                                  <tr style="font-weight: bold; text-align: center">
                                    <td>Item#</td><td>Qty</td> <td>PN</td><td align="left">Description</td><td>Unit Price</td><td>Lot Price</td>
                                  </tr>';
                                        for($x = 0; $x < count($getQuoteDetails); $x++){
                                            $html2 = $html2 . '
                                                <tr>
                                                    <td>' .($x + 1). '</td>
                                                    <td align="center">' .$getQuoteDetails[$x]->qty .'</td>
                                                    <td>' .$getQuoteDetails[$x]->pn .'</td>
                                                    <td>' .$getQuoteDetails[$x]->description .'</td>
                                                    <td align="right">$' .number_format(floatval($getQuoteDetails[$x]->price ), 2).'</td>
                                                    <td align="right">$' .number_format(floatval($getQuoteDetails[$x]->price ), 2) .'</td>
                                                </tr>
                                            ';
                                        }

                               $html2 = $html2 . '         
                            </table>
                            <span style="font-weight: bold; font-size: 14px">Note: All prices and invoicing is in U.S dollars</span> <span style="font-size: 14px;border: 3px solid;font-weight: bold; display:inline-block; width:32.0%; margin-left: 25.5%; padding: 0% 0% 0% 2%"> Total Price: <span style="padding: 0% 0% 0% 35%; font-size: 12px">$'.$total . '</span></span><br/>';
                                 if($totalDiscountedValue > 0){
                                     if($addDiscount == 0){
                                         $html2 = $html2 . '<div style="font-size: 12px;border: 3px solid;font-weight: bold; display:inline-block; width:32.0%; margin-left: 65%;padding: 0% 0% 0% 2%">'. $displayDiscount .'<span style="padding: 0% 0% 0% 45%">-$'.$totalDiscountedValue. '</span></div><br/>';
                                     }else{
                                          $html2 = $html2 . '<span style="font-size: 12px;border: 3px solid;font-weight: bold; display:inline-block; width:32.0%; margin-left: 65%; padding: 0% 0% 0% 2%">'. $displayDiscount .'<span style="padding: 0% 0% 0% 30%"> -$'.$totalDiscountedValue . '</span></span><br/>';
                                     }

                                     $html2 = $html2 . '<span style="font-size: 14px;border: 3px solid;font-weight: bold; display:inline-block; width:32.0%; margin-left: 65%;padding: 0% 0% 0% 2%"> Final Price: <span style="padding: 0% 0% 0% 35%">$'.$totalFinal . '</span></span>';
                                 }
                            $html2 = $html2 . '
                                
                                
                                <p style="font-weight: bold; text-align: center; font-size: 12px">
                                    Terms net 30days on approved credit. FOB Mayville, WI - prepay & add. <br />
                                    <u>Quotation valid for 60 days from quote date. Gleason Reel\'s Standard Conditions of Sale apply. </u>
                                </p>
                                
                                <br/>
                                <div style="font-size: 12px;font-weight: bold; display:inline-block; width:40%; margin-left: 60%">
                                    Quoted By:      -------------------------------------- <br/>
                                                          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span style="font-size: 12px">  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Authorized Representative</span>
                                </div>';
                                 if($notes != ""){
                                     $html2 = $html2 . '<div>Notes: ' .$notes. '</div>';
                                 }

                                $html2 = $html2 . '
                        </div>
                    
                    </div>
                    
                </body>     
           
        ';
            $htmlToPDF = $htmlToPDF .  $html2;
        }






        $docxHtml ='
        
        <html>
                <body>
                        <table style="width: 100%; border: 0; margin-top: 0">
                                <tr>
                                    <td><thead>Quotation</thead></td>
                                    <td><p>placeholder text for image</p></td>
                                    <td>Date:' . $date . '<br /> <br />Quote #: ' . $this->quoteId . ' </td>
                                </tr>
                        </table>
                        <table style="width: 80%; border: 0; margin-top: 0">
                                <tr>
                                    <td><u>QUOTE FOR:</u> <br/>
                                       ' . $custcomp . ' <br/>
                                       ' . $custaddr . ' <br />
                                       Phone:  ' . $custphone . '
                                    </td>
                                    <td>
                                        <u>REPLY TO:</u> <br/>
                                        Gleason Reel Corporation<br/>
                                        c/o Gleason Reel <br/>
                                        600 South Clark Street <br/>
                                        MayVille WI <br/>
                                        Phone: 920-387-7308 <br/>
                                        Fax: 920-387-4189 <br/>
                                        E-Mail: sschmitz@hubbell.com
                                    </td>
                                </tr>
                                 <tr>
                                        <td colspan="2">&nbsp;</td>
                                 </tr>
                                <tr>
                                        <td>Attn: ' . $custname . '</td> 
                                        <td>&nbsp;</td>
                                </tr>
                                <tr>
                                        <td>&nbsp;</td> 
                                        <td style="font-size: 10px">&nbsp;&nbsp;&nbsp;Please make all P.O\'s out to Gleason Reel - 600S. Clark St. MayVille WI  </td>
                                </tr>
                        </table>
                
                </body>
        </html>
  
        ';


        //This creates the pdf, stores it, and returns a view displaying iit in the browser

        if($quoteParameters["quoteFormat"] == "pdf") {
            File::put($pdfPath, PDF::load($htmlToPDF, 'A4', 'portrait')->output());
        }

        if($quoteParameters["quoteFormat"] == "word"){

            //php word docx writing shenanigans
            $section = $pw->addSection();

            //add html to section
            \PhpOffice\PhpWord\Shared\Html::addHtml($section, $docxHtml, false, false);

            /* [SAVE FILE ON THE SERVER] */
            $pw->save($pdfPath, "Word2007");

        }

        $out = array('outputName' => $outputName, 'pdfPath' => $pdfPath);
        debugbar::info($out);
        return View::make('reel/showQuote', array('out' => $out));
    }

    public function showAll() {
        // Retrieve all companies from database
        $companies = Company::all();
        $customers = Customer::all();
        $packages = Package::all();
        $packageContents = PackageContent::all();
        return View::make('reel/reel', array("type" => "reel", 'customers' => $customers, 'companies' => $companies, 'packages' => $packages, 'packagesContents' => $packageContents));
    }
    
    public function priceCheck(){
        return View::make('priceCheck');
    }
    
    public function getSpringsCollector($frameValue, $reelType){
        $sql = ""; $sql2 = ""; $param = array(); $result2 = ""; $result1 = ""; $sql3 = "";
        Debugbar::info("Frame: " . $frameValue . " Reel Type: " . $reelType);
        Debugbar::info("I got here ... Get SpringCollector");

        switch($reelType){
            case "S":
                $sql = "select distinct Springs from ssmmmd where Style = ? and Frame = ?";
                $sql2 = "select distinct Collector from collector where Sprc > 0";
                $param = array($reelType, $frameValue);
                break;
            case "SM":
                $sql = "select distinct Springs from ssmmmd where Style = ? and Frame = ?";
                $sql2 = "select distinct Collector from collector where SMprc > 0";
                $param = array($reelType, $frameValue);
                break;
            case "MMD":
                $sql = "select distinct Springs from ssmmmd where Style = ? and Frame = ?";
                $sql2 = "select distinct Collector from collector where MMDprc > 0";
                $param = array($reelType, $frameValue);
                break;
            case "UE":
            case "UH":
                $sql = "select distinct Springs from u where Frame = ?";
                $param = array($frameValue);
                if($reelType == "UE"){
                    $sql2 = "select distinct Collector from collector where Uprc > 0";
                }else{
                    $sql2 = "";
                }
                break;
            case "K":
                $sql = "select distinct Springs from k where Frame = ?";
                $sql3 = "select distinct HoseID from k where Frame = ?";
                $param = array($frameValue);
                break;
            case "P":
                $sql = "select distinct Motor from p where Frame = ?";
                $sql2 = "select distinct Collector from collector where Penprc > 0";
                $param = array($frameValue);
                break;
            case "C":
                $sql = "select distinct Springs from cmreel where Frame = ? order by Springs";
                $sql3 = "select distinct Wire from cmreel where Frame = ? order by Wire";
                $param = array($frameValue);
                break;
            case "HM":
                $sql = "select distinct Springs from hm where Frame = ?";
                $sql3 = "select distinct Hose from hm where Frame = ?";
                $param = array($frameValue);
                break;
            case "SHO":
                $sql = "select distinct Springs from sho where Stype = ?";
                $sql2 = "select distinct Collector from collector where SHOprc > 0";
                $param = array($frameValue);
                break;
            case "TMR":
                $sql = "select distinct Motor from tmr where Stype = ?";
                $sql2 = "select distinct Collector from collector where TMRprc > 0";
                $param = array($frameValue);
                break;
        }

        Debugbar::info("About to execute query1 ... Out of SpringCollector");

        $result1 = DB::select($sql, $param);

        Debugbar::info("About to execute query2 ... Out of SpringCollector");
        if($sql2 != ""){
            $result2 = DB::select($sql2);
        }

        if($sql3 != ""){
            $result2 = DB::select($sql3, $param);
        }

        $springAndCollector = array("springs" => $result1, "collectr" => $result2);
        //array_values($springAndCollector);

        return $springAndCollector;
    }
    
    public function lookupPrice($frame, $style, $spring, $geared, $collectorVal, $springWidth, $hoseValue, $reverseRotate, $harzardDuty, $gearChoice, $motorTMR, $spoolType, $spoolDiam, $chainRatio, $wireCode){
        $sql = ""; $sql2 = ""; $param = array(); $basePrice = ""; $collPrice = ""; $reelPrice = 0; $totalPrice = 0;

        switch($style){
            case "S":
            case "MMD":
                if($geared == "Yes"){
                    $sql = "select * from ssmmmd where Style = ? and Frame = ? and Springs = ? and Gear != '' ";
                    $param = array($style, $frame, $spring);
                }else{
                    $sql = "select * from ssmmmd where Style = ? and Frame = ? and Springs = ? and Gear = ''";
                    $param = array($style, $frame, $spring);
                }
                break;
            case "SM":
                $sql = "select * from ssmmmd where Style = ? and Frame = ? and Springs = ?";
                $param = array($style, $frame, $spring);
                break;
            case "UE":
            case "UH":
                $sql = "select * from U where Frame = ? and Springs = ? and Gear = ?";
                if($gearChoice == 0){
                    $gearChoice = "";
                }
                $param = array($frame, $spring, $gearChoice);
                break;
            case "K":
                $sql = "select * from K where Frame = ? and Springs = ? and HoseID = ?";
                $param = array($frame, $spring, $hoseValue);
                break;
            case "P":
                $sql = "select * from P where Frame = ? and Motor = ?";
                $param = array($frame, $motorTMR);
                break;
            case "SHO":
                if($springWidth == "MX"){
                    $sql = "select * from sho where Stype = ? and Springs = ? and Sdiam = ? and Swidth is NULL ";
                    $param = array($spoolType, $spring, $spoolDiam);
                }else{
                    $sql = "select * from sho where Stype = ? and Springs = ? and Swidth = ? and Sdiam = ?";
                    $param = array($spoolType, $spring, $springWidth, $spoolDiam);
                }
                break;
            case "TMR":
                if($springWidth == "MX"){
                    Debugbar::info("Got to query ...");
                    $sql = "select * from tmr where Stype = ? and Motor = ? and Swidth is NULL and Sdiam = ? and Gear = ?";
                    $param = array($spoolType, $motorTMR, $spoolDiam, $chainRatio);
                }else{
                    $sql = "select * from tmr where Stype = ? and Motor = ? and Swidth = ? and Sdiam = ? and Gear = ?";
                    $param = array($spoolType, $motorTMR, $springWidth, $spoolDiam, $chainRatio);
                }
                break;
            case "C":
                $sql = "select * from cmreel where Frame = ? and Springs = ? and Wire = ?";
                $param = array($frame, $spring, $wireCode);
                break;
            case "HM":
                $sql = "select * from hm where Frame = ? and Springs = ? and Hose = ?";
                $param = array($frame, $spring, $hoseValue);
                break;
        }//End of switch statement

        $priceRS = DB::select($sql, $param);
        $recordCount = count($priceRS);

        Debugbar::info("Number of rows = " . $recordCount);

        if($recordCount > 0){
            $basePrice = $priceRS[0]->Cost;
            Debugbar::info("Price = " . $basePrice);

            if($collectorVal != "empty"){
                $sql2 = "select * from collector where Collector = ?";
                $param = array($collectorVal);
                $collectorRS = DB::select($sql2, $param);
                $recordCount = count($collectorRS);
                if($recordCount > 0){
                    switch ($style){
                        case "S":
                            $collPrice = $collectorRS[0]->Sprc;
                            break;
                        case "SM":
                            $collPrice = $collectorRS[0]->Smprc;
                            break;
                        case "MMD":
                            $collPrice = $collectorRS[0]->MMDprc;
                            break;
                        case "UE":
                            $collPrice = $collectorRS[0]->Uprc;
                            break;
                        case "P":
                            $collPrice = $collectorRS[0]->Penprc;
                            break;
                        case "SHO":
                            $collPrice = $collectorRS[0]->SHOprc;
                            break;
                        case "TMR":
                            $collPrice = $collectorRS[0]->TMRprc;
                            break;
                        case "K":
                            $collPrice = 0;
                            break;
                    }
                }
            }


            //Pull prices from pn_prices table for lookupPrices
            $lookUpPrices = $this->getReelPrices('lookupPrice');
            Debugbar::info($lookUpPrices);

            if ($basePrice > 0) {

                if ($springWidth != 0 || $hoseValue != 0) {

                if ($style == "UE" || $style == "UH") {
                    switch ((int)$springWidth) {
                        case 6:
                            $basePrice = $basePrice + $lookUpPrices['basePRICE_6'];
                            break;
                        case 8:
                            $basePrice = $basePrice + $lookUpPrices['basePRICE_8'];
                            break;
                        case 10:
                            $basePrice = $basePrice + $lookUpPrices['basePRICE_10'];
                            break;
                        case 12:
                            $basePrice = $basePrice + $lookUpPrices['basePRICE_12'];
                            break;
                        case 14:
                            $basePrice = $basePrice + $lookUpPrices['basePRICE_14'];
                            break;
                    }
                    switch ((int)$hoseValue) {
                        case 6:
                            $basePrice = $basePrice + $lookUpPrices['basePRICE_Swivel_6'];
                            break;
                        case 8:
                            $basePrice = $basePrice + $lookUpPrices['basePRICE_Swivel_8'];
                            break;
                        case 12:
                            $basePrice = $basePrice + $lookUpPrices['basePRICE_Swivel_12'];
                            break;
                        case 16:
                            $basePrice = $basePrice + $lookUpPrices['basePRICE_Swivel_16'];
                            break;
                        case 20:
                            $basePrice = $basePrice + $lookUpPrices['basePRICE_Swivel_20'];
                            break;
                        case 24:
                            $basePrice = $basePrice + $lookUpPrices['basePRICE_Swivel_24'];
                            break;
                    }
                }
            }

                Debugbar::info("Price 3rd = " . $basePrice);
                //Check for harzard duty or rev rotate
                if($reverseRotate == "Yes"){
                    switch($style){
                        case "SM":
                            $basePrice = $basePrice + $lookUpPrices['basePRICE_RevRotate_SM'];
                            break;
                        case "S":
                            $basePrice = $basePrice + $lookUpPrices['basePRICE_RevRotate_S'];
                            break;
                        case "MMD":
                            $basePrice = $basePrice + $lookUpPrices['basePRICE_RevRotate_MMD'];
                            break;
                        case "K":
                            $basePrice = $basePrice + $lookUpPrices['basePRICE_RevRotate_K'];
                            break;
                        default:
                            $basePrice = $basePrice + $lookUpPrices['basePRICE_RevRotate_Others']; //'just for budgetary, may not be available
                            break;
                    }
                }

                if($harzardDuty == "Yes"){
                    $basePrice = $basePrice + $lookUpPrices['basePRICE_HarzardDuty']; //'hazard duty 2018 price add
                }
                $totalPrice = $basePrice + $collPrice;
            }else{
                $basePrice = 0.00;
            }
        }

        Debugbar::info("Price 4th = " . $basePrice);

        Debugbar::info("BasePrice = " . $basePrice. " CollectPrice = " . $collPrice . " totalPrice = " . $totalPrice);

        $reelPrice = array("price" => $totalPrice);

        return $reelPrice;

    }//End of method
    
    

    public function selectCustomer() {
        $customers = Customer::all();
        $companies = Company::all();

        return View::make('reel/customerinfo_modal', array('customers' => $customers, 'companies' => $companies));
    }

    //TODO: postQuote needed(?)
    public function postQuote() {

    }

    // Given input of all of the previous forms (application, cables and hoses, ect) generate a list of reels that are valid.
    public function showResults() {
        Debugbar::info(Input::all());

        $grnd = $this->getGrndQty(Input::get('identifier2')); // this is a value that I don't fully understand. Either way, it's needed for calculations in functions later.
        $hoseID = Input::get('identifier7'); // retrieve hose inner diameter

        // Calculate the hose ID code based on the ID. Copied from REELMOD.BAS.
        if ($hoseID < 0.3) {
            $hoseIDCode = '4';
        } else {
            if ($hoseID < 0.4) {
                $hoseIDCode = '6';
            } else {
                if ($hoseID < 0.6) {
                    $hoseIDCode = '8';
                } else {
                    if ($hoseID < 0.8) {
                        $hoseIDCode = '12';
                    } else {
                        if ($hoseID < 1.1) {
                            $hoseIDCode = '16';
                        } else {
                            if ($hoseID < 1.3) {
                                $hoseIDCode = '20';
                            } else {
                                if ($hoseID < 1.6) {
                                    $hoseIDCode = '24';
                                } else {
                                    $hoseIDCode = 'ER';
                                }
                            }
                        }
                    }
                }
            }
        }

        // retrieve all cable/hose values
        $metricDefault = Input::get('metricMeasure');
        Debugbar::info("metric Value: " . $metricDefault);
        $cable = array(
            "style" => Input::get('identifier1'),
            "type" => Input::get('identifier2'),
            "awg" => Input::get('identifier3'),
            "cond" => Input::get('identifier4'),
            "volts" => Input::get('identifier5'),
            "psi" => Input::get('identifier6'),
            "width" => Input::get('identifier7'),
            "thickness" => Input::get('identifier8'),
            "bendRadius" => Input::get('identifier9'),
            "weight" => Input::get('identifier10'),
            "price" => Input::get('identifier11'),
            "installFoot" => Input::get('identifier12'),
            "packageID" => Input::get('identifier13'),
            "cableID" => Input::get('identifier14'),
            "INSTL_FIX" => Input::get('identifier15'),
            "pn" => Input::get('identifier16'),
            "ground" => $grnd['grndQty'],
            "grndchck" => $grnd['grndchkQty'],
            "hoseIDCode" => $hoseIDCode
        );

        // retrieve application values
        $application = array(
            "appl" => Input::get('appl'),
            "activeTravel" => Input::get('activetravel'),
            "pendantWeight" => Input::get('pendantweight'),
            "cableSag" => Input::get('cablesag'),
            "centerline" => Input::get('centerline'),
            "travelSpeed" => Input::get('travelspeed'),
            "accel" => Input::get('accel'),
            "ambientTemp" => array("min" => Input::get('mintemp'), "max" => Input::get('maxtemp')),
            "springTurns" => Input::get('springturns'),
            "deadWraps" => Input::get('deadwraps'),
            "ccf" => Input::get('ccf')
        );

        // retrieve REEL values, only ones for the sReel matter at this point.
        $sReel = array(
            "checkboxes" => Input::get('s-checkboxes'),
            "springSize" => Input::get('s-springsize'),
            "collectorCode" => Input::get('s-collectorcode'),
            "gearRatio" => Input::get('s-gearratio'),
            "drumDiameter" => array("min" => Input::get('s-drummin'), "max" => Input::get('s-drummax')),
            "pretensTurn" => array("min" => Input::get('s-pretensmin'), "max" => Input::get('s-pretensmax'))
        );

        $mmdReel = array(
            "checkboxes" => Input::get('mmd-checkboxes'),
            "springSize" => Input::get('mmd-springsize'),
            "collectorCode" => Input::get('mmd-collectorcode'),
            "gearRatio" => Input::get('mmd-gearratio'),
            "drumDiameter" => array("min" => Input::get('mmd-drummin'), "max" => Input::get('mmd-drummax')),
            "pretensTurn" => array("min" => Input::get('mmd-pretensmin'), "max" => Input::get('mmd-pretensmax'))
        );

        $smReel = array(
            "checkboxes" => Input::get('sm-checkboxes'),
            "springSize" => Input::get('sm-springsize'),
            "collectorCode" => Input::get('sm-collectorcode'),
            "gearRatio" => Input::get('sm-gearratio'),
            "drumDiameter" => array("min" => Input::get('sm-drummin'), "max" => Input::get('sm-drummax')),
            "pretensTurn" => array("min" => Input::get('sm-pretensmin'), "max" => Input::get('sm-pretensmax'))
        );

        $tmrReel = array(
            "checkboxes" => Input::get('tmr-checkboxes'),
            "spoolingMethod" => Input::get('tmr-reels-spooling'),
            "springSize" => Input::get('tmr-reels-spring-size'),
            "spoolWidth" => Input::get('tmr-reels-spool-width'),
            "spoolDiameter" => Input::get('tmr-reels-spool-diameter'),
            "collectorCode" => Input::get('tmr-reels-code'),
            "gearRatio" => Input::get('tmr-gearratio'),
            "drumDiameter" => array("min" => Input::get('tmr-reels-min-range'), "max" => Input::get('tmr-reels-max-range')),
            "chainRatioCode" => Input::get('tmr-reels-chain'),
            "torqueMotor" => Input::get('tmr-torque-motor')
        );

        $shoReel = array(
            "checkboxes" => Input::get('sho-checkboxes'),
            "spoolingMethod" => Input::get('sho-reels-spooling'),
            "springSize" => Input::get('sho-reels-spring-size'),
            "spoolWidth" => Input::get('sho-reels-spool-width'),
            "spoolDiameter" => Input::get('sho-reels-spool-diameter'),
            "collectorCode" => Input::get('sho-reels-code'),
            "gearRatio" => Input::get('sho-gearratio'),
            "drumDiameter" => array("min" => Input::get('sho-reels-min-range'), "max" => Input::get('sho-reels-max-range')),
            "chainRatioCode" => Input::get('sho-reels-chain'),
            "pretensTurn" => array("min" => Input::get('sho-reels-min-turn'), "max" => Input::get('sho-reels-max-turn'))
        );

        $cmReel = array(
            "checkboxes" => Input::get('cm-checkboxes'),
            "springMotor" => Input::get('cm-springmotor'),
            "wireSizeCode" => Input::get('cm-wire-size-code'),
            "pretensTurn" => array("min" => Input::get('cm-pretensmin'), "max" => Input::get('cm-pretensmax'))
        );

        $khReel = array(
            "checkboxes" => Input::get('k-checkboxes'),
            "springSize" => Input::get('k-springsize'),
            "hoseIdCode" => Input::get('k-collectorcode'),
            "pretensTurn" => array("min" => Input::get('k-pretensmin'), "max" => Input::get('k-pretensmax'))
        );

        $pReel = array(
            "checkboxes" => Input::get('p-checkboxes'),
            "motorSize" => Input::get('p-motorsize'),
            "collectorCode" => Input::get('p-collectorcode'),
            "drumDiameter" => array("min" => Input::get('p-drummin'), "max" => Input::get('p-drummax'))
        );

        $uReel = array(
            "checkboxes" => Input::get('u-checkboxes'),
            "springSize" => Input::get('u-springsize'),
            "collectorCode" => Input::get('u-collectorcode'),
            "drumDiameter" => array("min" => Input::get('u-drummin'), "max" => Input::get('u-drummax')),
            "gearRatio" => Input::get('u-gearratio'),
            "pretensTurn" => array("min" => Input::get('u-pretensmin'), "max" => Input::get('u-pretensmax'))
        );

        $uhReel = array(
            "checkboxes" => Input::get('uh-checkboxes'),
            "springSize" => Input::get('uh-springsize'),
            "collectorCode" => Input::get('uh-collectorcode'),
            "drumDiameter" => array("min" => Input::get('uh-drummin'), "max" => Input::get('uh-drummax')),
            "gearRatio" => Input::get('uh-gearratio'),
            "pretensTurn" => array("min" => Input::get('uh-pretensmin'), "max" => Input::get('uh-pretensmax')),
            "spoolWidth" => Input::get('uh-spoolwidth')
        );

        $hmReel = array(
            "checkboxes" => Input::get('hm-checkboxes'),
            "springSize" => Input::get('hm-springsize'),
            "collectorCode" => Input::get('hm-collectorcode'),
            "pretensTurn" => array("min" => Input::get('hm-pretensmin'), "max" => Input::get('hm-pretensmax'))
        );


        Debugbar::info($cable);
        if ($cable["style"] == "Cable") {
            $collector = $this->calcCollectorCode($cable, $application['appl']);

        } else {

            $collector = 0;
        }


        //todo: make sure findTheReel works on more than just sReel
        // run findTheReel on just sReel for now.
        $data = $this->findTheReel($hmReel, $uhReel, $uReel, $pReel, $khReel, $tmrReel, $cmReel, $shoReel, $smReel, $mmdReel, $sReel, $application, $cable, $collector, $metricDefault);
        $data['cust-name'] = Input::get('cust-name');
        $data['cust-addr'] = Input::get('cust-addr');
        $data['cust-comp'] = Input::get('cust-comp');
        $data['cust-phone'] = Input::get('cust-phone');
        $_SESSION['data'] = $data;
        
        return View::make('results', array('data' => $data));
    }
    
    public function returnSearchPage(){
        $data = $_SESSION['data'];
        return View::make('results', array('data' => $data));
    }

private function findTheReel($hmReel, $uhReel, $uReel, $pReel, $khReel, $tmrReel, $cmReel, $shoReel, $smReel, $mmdReel, $sReel, $application, $cable, $collector, $metricDefault) {
        // Calculates spring data, copied from source
        $springData = $this->getSpringData();
        //Debugbar::info("metric Value - public: findTheReel()" . $this->metricDefault);

        $reels = null;


        // Take the checkboxes and drop downs and generate a SQL query out of it.
        if ($sReel["checkboxes"][0] == "any" || $sReel["checkboxes"][0] != "none") {
            $query = DB::table('ssmmmd')->where('Style', 'S');

            if ($sReel['checkboxes'][0] != 'any') {
                $query->whereIn('Frame', $sReel['checkboxes']);
            }

            if ($sReel['springSize'] == 'none') {
                $query->where('Springs', '');
            } else {
                if ($sReel['springSize'] != 'all') {
                    $query->where('Springs', $sReel['springSize']);
                }
            }

            if ($sReel['gearRatio'] == 'none') {
                $query->where('Gear', '');
            } else {
                if ($sReel['gearRatio'] != 'all') {
                    $query->where('Gear', $sReel['gearRatio']);
                }
            }

            $query->orderBy('Cost', 'Gear');
            $modelIndex = 1;
            $reels = array('params' => $sReel, 'rows' => $query->get());

            $data = $this->loopThruReels($reels, $application, $cable, $springData, $collector, $modelIndex, $metricDefault);

        }

        if ($khReel["checkboxes"][0] == "any" || $khReel["checkboxes"][0] != "none") {
            //$hose = true;
            $query = DB::table('k')->where('Style', 'K');

               if ($khReel['checkboxes'][0] != 'any') {
                     $query->whereIn('Frame', $khReel['checkboxes']);
            }

            if(substr($khReel["springSize"], -1, 1) == 'X'){
                $query->orWhere('Springs', 'like', substr($khReel["springSize"], 0, strlen($khReel["springSize"]) -1 ));
            }else{
                if($khReel["springSize"] == "all"){

                }else{
                    $query->where('Springs', $khReel["springSize"]);
                }
            }

            $query->orderBy('Cost');
            $modelIndex = 7;
            $reels = array('params' => $khReel, 'rows' => $query->get());
            //dump($reels);
            $data = $this->loopThruReels($reels, $application, $cable, $springData, $collector, $modelIndex, $metricDefault);

        }

        if ($mmdReel["checkboxes"][0] == "any" || $mmdReel["checkboxes"][0] != "none") {
            $query = DB::table('ssmmmd')->where('Style', 'MMD');

            if ($mmdReel['checkboxes'][0] != 'any') {
                $query->whereIn('Frame', $mmdReel['checkboxes']);
            }
            if ($mmdReel['springSize'] == 'none') {
                $query->where('Springs', '');
            } else {
                if ($mmdReel['springSize'] != 'all') {
                    $query->where('Springs', $mmdReel['springSize']);
                }
            }

            if ($mmdReel['gearRatio'] == 'none') {
                $query->where('Gear', '');
            } else {
                if ($mmdReel['gearRatio'] != 'all') {
                    $query->where('Gear', $mmdReel['gearRatio']);
                }
            }

            //$query->orderBy('Cost','Gear');
            $query->orderBy('Cost', 'DSC');
            $query->orderBy('Gear', 'DSC');
            $modelIndex = 2;


            $reels = array('params' => $mmdReel, 'rows' => $query->get());
            //dump($reels);
            $data = $this->loopThruReels($reels, $application, $cable, $springData, $collector, $modelIndex, $metricDefault);

//<==3
        }
        /*
       * SM Calculation
       */
        if ($smReel["checkboxes"][0] == "any" || $smReel["checkboxes"][0] != "none") {
            $query = DB::table('ssmmmd')->where('Style', 'SM');

            if ($smReel['checkboxes'][0] != 'any') {
                $query->whereIn('Frame', $smReel['checkboxes']);
            }

            if ($smReel['springSize'] == 'none') {
                $query->where('Springs', '');
            } else {
                if ($smReel['springSize'] != 'all') {
                    $query->where('Springs', $smReel['springSize']);
                }
            }

            if ($smReel['gearRatio'] == 'none') {
                $query->where('Gear', '');
            } else {
                if ($smReel['gearRatio'] != 'all') {
                    $query->where('Gear', $smReel['gearRatio']);
                }
            }
            $query->orderBy('Cost', 'DSC');
            $query->orderBy('Gear', 'DSC');


            $modelIndex = 3;
            $reels = array('params' => $smReel, 'rows' => $query->get());
            //dump($reels);
            $data = $this->loopThruReels($reels, $application, $cable, $springData, $collector, $modelIndex, $metricDefault);
        }
        /*
        * SHO Calculation
        */
        if ($shoReel["checkboxes"][0] == "any") {
            $query = DB::table('sho')->where('Style', 'SHO')->where('Stype', strtoupper(substr($shoReel["spoolingMethod"], 0, 1)));//Firstmost character uppercase R or M

            if ($shoReel['springSize'] == 'none') {
                $query->where('Springs', '');
            } else {
                if ($shoReel['springSize'] != 'all') {
                    $query->where('Springs', $shoReel['springSize']);
                }
            }

            if ($shoReel['spoolingMethod'] == "random") {

                switch ($shoReel['spoolWidth']) {
                    case 'all':
                        break;
                    default:
                        $query->where('Swidth', $shoReel['spoolWidth']);

                }

            }
            switch ($shoReel['spoolDiameter']) {
                case 'all':
                    break;
                default:
                    $query->where('Sdiam', $shoReel['spoolDiameter']);
            }
            switch ($shoReel['chainRatioCode']) {
                case 'all':
                    break;
                default:
                    $query->where('Gear', $shoReel['chainRatioCode']);

            }


            $query->orderBy('Cost', 'DSC');
            $query->orderBy('Gear', 'ASC');
            $modelIndex = 0;

            $reels = array('params' => $shoReel, 'rows' => $query->get());
            //dump($reels);
            $data = $this->loopThruReels($reels, $application, $cable, $springData, $collector, $modelIndex, $metricDefault);
        }
        /*
         * TMR calculation
         */
        if ($tmrReel["checkboxes"][0] == "any") {
            $query = DB::table('tmr')->where('Style', 'TMR');

            if ($tmrReel['spoolingMethod'] == "random") {
                switch ($tmrReel['spoolWidth']) {
                    case 'all':
                        break;
                    default:
                        $query->where('Swidth', $tmrReel['spoolWidth']);

                }

            }
            switch ($tmrReel['spoolDiameter']) {
                case 'all':
                    break;
                default:
                    $query->where('Sdiam', $tmrReel['spoolDiameter']);
            }
            switch ($tmrReel['chainRatioCode']) {
                case 'all':
                    break;
                default:
                    $query->where('Gear', $tmrReel['chainRatioCode']);

            }


            $query->orderBy('Cost', 'DSC');
            $query->orderBy('Gear', 'ASC');
            $modelIndex = 0;

            $reels = array('params' => $tmrReel, 'rows' => $query->get());
            //dump($reels);
            $data = $this->loopThruReels($reels, $application, $cable, $springData, $collector, $modelIndex, $metricDefault);
        }
        /*
         * CM Query builder
         */

        if ($cmReel["checkboxes"][0] == "any" || $cmReel["checkboxes"][0] != "none") {
            //          "checkboxes" => Input::get('sho-checkboxes'),
            //          "springMotor"=> Input::get('cm-springmotor'),
            //          "wireSizeCode" => Input::get('cm-wire-size-code'),
            //          "pretensTurn" => array("min" => Input::get('cm-pretensmin'), "max" => Input::get('cm-pretensmax'))
            $query = DB::table('cmreel')->where('Style', 'C');

            if ($cmReel['checkboxes'][0] != 'any') {
                $query->whereIn('Frame', $cmReel['checkboxes']);
            }

            if($cmReel['wireSizeCode'] != ''){
                $query->where("Wire", $cmReel['wireSizeCode']);
            }

            if($cmReel['springMotor'] == 'all'){
                //$query->where("Springs", '');
            }else{
                $query->where("Springs", $cmReel['springMotor']);
            }

            $query->orderBy('Cost');
            //$modelIndex = 1;
            $modelIndex = 4;
            $reels = array('params' => $cmReel, 'rows' => $query->get());
            //dump($reels);
            //dump($cmReel['checkboxes']);
            $data = $this->loopThruReels($reels, $application, $cable, $springData, $collector, $modelIndex, $metricDefault);

        }

        /*
         * Pendant Reel Query Builder
         */
        if($pReel["checkboxes"][0] == "any" || $pReel["checkboxes"][0] != "none"){
            $query = DB::table('p')->where('Style', 'P');
            if($pReel["checkboxes"][0] != "any"){
                $query->whereIn('Frame', $pReel['checkboxes']);
            }

            if ($pReel['motorSize'] == "all") {

            } else {
                if ($pReel['motorSize'] != 'all') {
                    $query->where('Motor', $pReel['motorSize']);
                }
            }

            $query->orderBy('Cost');

            $modelIndex = 6;

            $reels = array('params' => $pReel, 'rows' => $query->get());
            //dump($reels);
            $data = $this->loopThruReels($reels, $application, $cable, $springData, $collector, $modelIndex, $metricDefault);
        }//End of pReel query

        /*
         * U Reel Query Builder
         */
         if($uReel["checkboxes"][0] == "any" || $uReel["checkboxes"][0] != "none"){
             $query = DB::table('u') ->where('Style', 'U');

             if($uReel["checkboxes"][0] != "any"){
                 $query->whereIn('Frame', $uReel['checkboxes']);
             }

             if(substr($uReel["springSize"], -1, 1) == 'X'){
                 $query->orWhere('Springs', 'like', substr($uReel["springSize"], 0, strlen($uReel["springSize"]) -1 ));
             }else{
                 if($uReel["springSize"] == "all"){

                 }else{
                     $query->where('Springs', $uReel["springSize"]);
                 }
             }

             if($uReel["gearRatio"] == 'none'){
                 $query->where("Gear", '');
             }else{
                 if($uReel["gearRatio"] == "all"){

                 }else{
                     $query->where("Gear", $uReel["gearRatio"]);
                 }
             }

             $query->orderBy('Cost', 'Gear');

             $modelIndex = 5;

             $reels = array('params' => $uReel, 'rows' => $query->get());
            //dump($reels);
             $data = $this->loopThruReels($reels, $application, $cable, $springData, $collector, $modelIndex, $metricDefault);
         }

         /* UH - Reel Query  */
        if($uhReel["checkboxes"][0] == "any" || $uhReel["checkboxes"][0] != "none"){
            $query = DB::table('u') ->where('Style', 'U');

            if($uhReel["checkboxes"][0] != "any"){
                $query->whereIn('Frame', $uhReel['checkboxes']);
            }

            if(substr($uhReel["springSize"], -1, 1) == 'X'){
                $query->orWhere('Springs', 'like', substr($uhReel["springSize"], 0, strlen($uhReel["springSize"]) -1 ));
            }else{
                if($uhReel["springSize"] == "all"){

                }else{
                    $query->where('Springs', $uhReel["springSize"]);
                }
            }

            if($uhReel["gearRatio"] == 'none'){
                $query->where("Gear", '');
            }else{
                if($uhReel["gearRatio"] == "all"){

                }else{
                    $query->where("Gear", $uhReel["gearRatio"]);
                }
            }

            $query->orderBy('Cost', 'Gear');

            $modelIndex = 5;

            $reels = array('params' => $uhReel, 'rows' => $query->get());
            //dump($reels);
            $data = $this->loopThruReels($reels, $application, $cable, $springData, $collector, $modelIndex, $metricDefault);
        }

        /* HM - Reel Query  */
        if($hmReel["checkboxes"][0] == "any" || $hmReel["checkboxes"][0] != "none"){
            $query = DB::table('hm') ->where('Style', 'HM');

            if($hmReel["checkboxes"][0] != "any"){
                $query->whereIn('Frame', $hmReel['checkboxes']);
            }

            if($hmReel["springSize"] == "all"){

            }else{
                $query->where('Springs', $hmReel["springSize"]);
            }

            $query->orderBy('Cost');

            $modelIndex = 8;

            $reels = array('params' => $hmReel, 'rows' => $query->get());
            //dump($reels);
            $data = $this->loopThruReels($reels, $application, $cable, $springData, $collector, $modelIndex, $metricDefault);
        }

        $data["cable"] = $cable;
        //dump($reels);
        return $data;

    }

    // This is the main part of the program. This goes through all the reels returned by findTheReel and determines whether the reel would be a good fit given the parameters available.
    //line 4298 on REELMOD.BAS
    private function clearSearchCriteria(){
        $srchFrame = ""; $srchCost = ""; $srchStyle = ""; $srchSpring = ""; $srchColl = ""; $srchDrummin = "";
        $srchDrummax = ""; $srchPremin = ""; $srchPremax = ""; $srchSpoolMethod = ""; $srchSpoolWidth = "";
        $srchGear = ""; $srchChainRatio = ""; $srchMotor = "";
    }
    
    
    private function loopThruReels($reels, $application, $cable, $springData, $collector, $modelIndex, $metricDefault) {
        Debugbar::info("LoopThruReels called");
        $srchFrame = 0; $srchSpring = 0; $srchColl = 0; $srchDrummin = 0; $srchDrummax = 0; $srchPremax = 0;
        $srchPremin = 0; $srchSpoolMethod = 0; $srchSpoolWidth = 0; $srchGear = 0; $srchChainRatio = 0; $srchMotor = 0;
        $validDrumMax = 0; $drumIncrement = 0; $data = array(); $initialCalcs = array(); $initialCMCalcs = array();
        $vR = 0; $wrapperWidthR = 0; $reelWithInp = 0; $hoseIdCode = 0; $modelNo = ""; $stretchApplCMCalcs = array();
        $liftApplCMCalcs = array(); $retrieveApplCMCalcs = array(); $stretchApplCalcs = array(); $liftApplCalcs = array();
        $retrieveApplCalcs = array(); $srchStyle = ""; $cableClearanceFactor = 0;

        //$debugFile = fopen("C:\\Users\\nwachukwuc1\\Desktop\\loopThruReels.txt", "a");

        $srchSpring = ""; //initialized for TMR searches
        Debugbar::info("LoopThruReels called");
        //todo: currently Invalid reel array and valid reels reset them selves when a new type is searched.
        // Find out a way so they don't do this. See if you can check for if they are empty or null. Or see if you can append their results where appropriate. Consider adding them to the globals class
        //great the global solution works, however not all valid reels are being listed. They are correctly stored in the array though.
        global $invalidReelArray;
        global $validReel;
        global $recNumber;
        global $cableOrHose; $reason = 0;

        if ($invalidReelArray == null)
            $invalidReelArray = array();
        $reelIndex = 0;
        if($recNumber == null)
            $recNumber = 0;
        $count = 0;

        $reelLength = count($reels['rows']);
        Debugbar::info("reelLength: " . $reelLength);

        if($validReel == null)
            $validReel = array(); // set up array to put the valid reels into
        $collectorCode = $collector['collectorCode'];

        // if the cable style contains the string dual hose,
        if (strpos($cable['style'], "Dual Hose") !== false) {
            $cableOrHose = 'HD';
        } else {
            if (strpos($cable['style'], "Single Hose") !== false) {
                $cableOrHose = 'HS';
            } else {
                $cableOrHose = 'C';
            }
        }
        //debugbar::info("cableOrHose: " . $cableOrHose);
        // returns an array for all of the models with boolean values
        // if the parameters are specifying a specific sreel, $specificInput[0] will be true
        $specificInput = false;// $this->checkForSpecificInput($cableOrHose, $reels['params']['checkboxes'], $reels['params']['drumDiameter'], $reels['params']['pretensTurn']);

        $hoseIDCode = $cable['hoseIDCode'];

        $uReelWidthArray = $this->calcUreelWidth($cableOrHose, $hoseIDCode, $cable["thickness"]);
        $uReelWidth = $uReelWidthArray["uReelWidth"];
        $this->uReelWidthInp = $uReelWidthArray["uReelWidthInp"];
        //Debugbar::info("uReelWidth: " . $uReelWidth);


        //loop through all reels returned by our sql query
        //Debugbar::info("$reelIndex < $reelLength");
        $this->cableClearanceFactor = $application['ccf'];
        while ($reelIndex < $reelLength) {

            $this->clearSearchCriteria(); //Added to clear search values for every iteration

            $getStyle = $reels["rows"][$reelIndex]->Style;


            if($getStyle == "C" || $getStyle == "P" || $getStyle == "HM" || $getStyle == "K"){
                $reel = $reels["rows"][$reelIndex];
            }else{
                $reel = $reels['rows'][$reelLength - $reelIndex - 1];
            }

            //Debugbar::info("Search Style: " . $reel->Style );

            $srchStyle = $reel->Style;
            $srchCost = $reel->Cost;

            //if (count($reels['rows']) != 0) { -- Commented out. Does not seem to make any meaning
                switch ($srchStyle) {
                    case 'S':
                    case 'SM':
                    case 'MMD':
                    case 'U':
                        $srchFrame = $reel->Frame;
                        $srchSpring = $reel->Springs;
                        $drumIncrement = 1;
                        if ($reel->Gear != "") {
                            $srchGear = $reel->Gear;
                        }else{
                            $srchGear = '';
                        }

                        switch ($srchStyle) {
                            case 'S':
                                $srchColl = $reels['params']['collectorCode'];
                                $srchDrummin = $reels['params']['drumDiameter']['min'];
                                $srchDrummax = $reels['params']['drumDiameter']['max'];
                                $srchPremin = $reels['params']['pretensTurn']['min'];
                                $srchPremax = $reels['params']['pretensTurn']['max'];
                                break;

                            case "SM":
                                $srchColl = $reels['params']['collectorCode'];
                                $srchDrummin = $reels['params']['drumDiameter']['min'];
                                $srchDrummax = $reels['params']['drumDiameter']['max'];
                                $srchPremin = $reels['params']['pretensTurn']['min'];
                                $srchPremax = $reels['params']['pretensTurn']['max'];
                                break;

                            case "MMD":
                                $srchColl = $reels['params']['collectorCode'];
                                $srchDrummin = $reels['params']['drumDiameter']['min'];
                                $srchDrummax = $reels['params']['drumDiameter']['max'];
                                $srchPremin = $reels['params']['pretensTurn']['min'];
                                $srchPremax = $reels['params']['pretensTurn']['max'];
                                break;

                            case "U":
                                $drumIncrement = 2;
                                $srchColl = $reels['params']['collectorCode'];
                                $srchDrummin = $reels['params']['drumDiameter']['min'];
                                $srchDrummax = $reels['params']['drumDiameter']['max'];
                                $srchPremin = $reels['params']['pretensTurn']['min'];
                                $srchPremax = $reels['params']['pretensTurn']['max'];
                                break;
                        }

                        $srchSpoolWidth = 0;
                        $srchSpoolMethod = "";
                        $srchMotor = "";
                        break;

                    case "SHO":
                        $drumIncrement = 2;
                        $srchSpoolMethod = $reel->Stype;//$reels['params']['spoolingMethod'];       srchSPOOLMETHOD = searchRS!stype
                        $srchSpoolMethod = strtoupper(substr($srchSpoolMethod, 0, 1));//            srchSPOOLMETHOD = searchRS!stype
                        $srchSpring = $reel->Springs;

                        if ($srchSpoolMethod == "M") {
                            $srchSpoolWidth = $reels['params']['spoolWidth'];

                        } else {
                            if (strlen($reel->Swidth) > 0) {
                                $srchSpoolWidth = $reel->Swidth;

                            }
                        }

                        $srchFrame = $reel->Sdiam;
                        $srchGear = $reel->Gear;
                        $srchColl = $reels['params']['collectorCode'];

                        if ($srchFrame == 54 && $srchSpoolMethod == "R" && $reels['params']['drumDiameter']['min'] < 18) {
                            $srchDrummin = 18;
                        } else {
                            $srchDrummin = $reels['params']['drumDiameter']['min'];
                        }

                        //$srchDrummin = $reels['params']['drumDiameter']['min'];
                        $srchDrummax = $reels['params']['drumDiameter']['max'];
                        $srchPremin = $reels['params']['pretensTurn']['min'];
                        $srchPremax = $reels['params']['pretensTurn']['max'];
                        $srchChainRatio = $reels['params']["chainRatioCode"];
                        $srchMotor = "";
                        break;
                    case 'TMR':
                        //srchSpring does not get defined, it causes errors when searching for a TMR reel. Find out how Reelmod.bas handles this. see line 4419 of Reelmod.bas
                        $drumIncrement = 2;
                        $srchSpoolMethod = $reel->Stype;//$reels['params']['spoolingMethod'];
                        $srchMotor = $reel->Motor;
                        if ($srchSpoolMethod == 'M') {
                            $srchSpoolWidth = $reels['params']['spoolWidth'];
                        } else {
                            if (strlen($reel->Swidth) > 0) {
                                $srchSpoolWidth = $reel->Swidth;
                            }
                        }
                        $srchFrame = $reel->Sdiam;
                        $srchGear = $reel->Gear;
                        $srchColl = $reels['params']['collectorCode'];
                        if ($srchFrame == 54 && $srchSpoolMethod == 'R' && $reels['params']['drumDiameter']['min'] < 18) {
                            $srchDrummin = 18;
                        } else {
                            $srchDrummin = $reels['params']['drumDiameter']['min'];
                        }
                        $srchDrummax = $reels['params']['drumDiameter']['max'];
                        $srchPremin = "";
                        $srchPremax = "";
                        break;
                    case 'C':
                        $srchFrame = $reel->Frame;
                        $srchColl = $reel->Wire;
                        $srchSpring = $reel->Springs;
                        $srchPremin = $reels['params']['pretensTurn']['min'];
                        $srchPremax = $reels['params']['pretensTurn']['max'];
                        $srchGear = "";
                        $srchDrummin = "";
                        $srchDrummax = "";
                        $srchMotor = "";
                        break;
                    case "P":
                        $drumIncrement = 1;
                        $srchFrame = $reel->Frame;
                        $srchMotor = $reel->Motor;
                        $srchColl = $reels['params']['collectorCode'];
                        $srchDrummin = $reels['params']['drumDiameter']['min'];
                        $srchDrummax = $reels['params']['drumDiameter']['max'];
                        $srchPremin = "";
                        $srchPremax = "";
                        break;
                    case "K":
                        $srchColl = 0;//line not in reelmod.bas
                        $srchFrame = $reel->Frame;
                        $srchSpring = $reel->Springs;
                        $srchPremin = $reels['params']['pretensTurn']['min'];
                        $srchPremax = $reels['params']['pretensTurn']['max'];
                        $srchMotor = ""; //line not in reelmod.bas
                        break;
                    case "HM":
                        $srchFrame = $reel->Frame;
                        $srchSpring = $reel->Springs;
                        $srchDrummax = "";
                        $srchDrummin = "";
                        $srchPremin = $reels['params']['pretensTurn']['min'];
                        $srchPremax = $reels['params']['pretensTurn']['max'];
                        $srchMotor = "";
                        break;//end
                }
            //}

            //todo: the following line uses not equals for each check, if you look at line 4472 of reelmod.bas the equivlent line uses equals as in:
            // If srchSTYLE <> "C" And srchSTYLE <> "K" And srchSTYLE <> "HM" Then
            if ($srchStyle != 'C' && $srchStyle != 'K' && $srchStyle != 'HM') {
                $validDrumMax = $this->checkDrumSize($srchStyle, $srchFrame, $this->cableClearanceFactor, $cable['thickness'], $srchDrummax, $srchColl, $srchSpring);

                //fwrite($debugFile, "srchDrumMin: " . $srchDrummin. PHP_EOL);
                //fwrite($debugFile, "srchDrummax: " . $srchDrummax. PHP_EOL);
                //fwrite($debugFile, "validDrumMax: " . $validDrumMax. PHP_EOL);

                if ($validDrumMax < $srchDrummin) {
                    goto NextReel;

                }
            }

            if ($application['appl'] == 'hand') {

                if (substr($srchSpring, 0, 3) == '100') {
                    goto NextReel;
                }

                //todo: compare the following line with its reelmod.bas equivalent on line 4485
                //   If (srchSTYLE = "C" Or srchSTYLE = "HM") And (srchSPRING <> "U" And srchSPRING <> "V") Then GoTo nextREEL
                if (($srchStyle == 'C' || $srchStyle == 'HM') && ($srchSpring != 'U' && $srchSpring != 'V')) {
                    goto NextReel;
                }
            }
            // This returns validPretensMax, which is one of checks that need to be done to see whether a reel is valid or not.

            $pretensTurnData = $this->checkPretensTurns($application['springTurns'], $srchStyle, $srchSpring, $srchPremax);
            //fwrite($debugFile, "srchPremax: " . $srchPremax. PHP_EOL);
            //fwrite($debugFile, "srchPremin: " . $srchPremin. PHP_EOL);
            //fwrite($debugFile, "srchSpring: " . $srchSpring. PHP_EOL);
            //fwrite($debugFile, "pretensTurnData: dumped". PHP_EOL);
            //dump($pretensTurnData);

            if ($srchStyle == "TMR" || $srchStyle == "P") {
                $srchPremin = 0;
            }

            if ($srchStyle == "C" || $srchStyle == "HM") {
                $validDrumMax = 0; //0
                $srchDrummin = 1; //"1"
                $drumIncrement = -1; //-1
            }

            if ($srchStyle == "K") {
                switch ($hoseIDCode) {
                    case "4":
                    case "6":
                    case "8":
                        $validDrumMax = 9;
                        $srchDrummin = "9";
                        $drumIncrement = 1;
                        break;
                    case "12":
                        $validDrumMax = 14;
                        $srchDrummin = "14";
                        $drumIncrement = 1;
                        break;
                }
            }
            //todo line 4515 reelmod.bas
            $frameSize = $srchFrame;
            $springSize = $srchSpring;

            $gearRatio = $this->assignGearRatio($srchStyle, $srchGear);//line 4520
            //fwrite($debugFile, "gearRatio: " . $gearRatio. PHP_EOL);

            if($srchStyle == "TMR"){
                $gearRatio = $gearRatio * 5.8;
            }


            $turnsUsedPercent = $pretensTurnData['turnsUsedPercent'];
            $validPretensMax = $pretensTurnData['validPretensMax'];
            //fwrite($debugFile, "turnsUsedPercent: " . $turnsUsedPercent. PHP_EOL);
            //fwrite($debugFile, "validPretensMax: " . $validPretensMax. PHP_EOL);

            if ($srchStyle == "K") {
                $srchGear = 0;
            }

            $calcTorqueParams = array('springSize' => $srchSpring,
                'springData' => $springData,
                'turnsUsedPercent' => $turnsUsedPercent,
                'gearRatio' => $gearRatio
            );


            $swOpt = false; //I believe this is for initialization. in original application, it is set in a form that bases the bool on user input. Line 3678 on MODEL1.FRM

            $specificInput = false;
            $validTurns = 0;
            $validCompartment = 0;
            if ($srchStyle == "C" || $srchStyle == "HM"){
                for ($drumSize = intval($validDrumMax); $drumSize <= intval($srchDrummin); $drumSize -= intval($drumIncrement)) { //line 4520
                    //Debugbar::info("outerloop value: i is " . $drumSize );
                    for ($pretensionTurns = intval($srchPremin); $pretensionTurns <= intval($validPretensMax); $pretensionTurns++) {
                            $initialCMCalcs = $this->doInitialCMCalcs($srchStyle, $srchFrame, $cable, $pretensionTurns, $application, $modelIndex, $specificInput, $pretensTurnData['maxTurnsFromSpring'], $turnsUsedPercent, $cableOrHose, $srchColl, $srchSpring);
                            $validCompartment = $initialCMCalcs['validCompartment'];
                            $validTurns = $initialCMCalcs['validTurns'];

                        if (!$validCompartment) {
                            break;//goto PRETENSSKIP;
                        }

                        if ($validTurns) {

                            $validTorque = false;
                                switch ($application['appl']) {
                                    case "stretch":
                                        $stretchApplCMCalcs = $this->calcStretchApplCM($application, $initialCMCalcs, $cable, $pretensionTurns, $srchSpring, $specificInput, $srchStyle, $srchFrame, $srchColl);
                                        $validTorque = $stretchApplCMCalcs['validTorque'];
                                        $reason = $stretchApplCMCalcs['reason'];
                                        $wrapperWidthR = $initialCMCalcs["wrapperWidthR"];
                                        break;
                                    case 'lift':
                                    case 'magnet':
                                        $liftApplCMCalcs = $this->calcLiftApplCM($pretensionTurns, $application, $initialCMCalcs, $cable, $srchSpring, $specificInput, $srchStyle, $srchFrame, $srchColl);
                                        $validTorque = $liftApplCMCalcs['validTorque'];
                                        $reason = $liftApplCMCalcs['reason'];
                                        $wrapperWidthR = $initialCMCalcs["wrapperWidthR"];
                                        break;
                                    case 'retrieve':
                                    case 'hand':
                                        $retrieveApplCMCalcs = $this->calcRetrieveApplCM( $modelIndex, $pretensionTurns, $application, $initialCMCalcs, $cable, $gearRatio, $specificInput, $srchSpring, $srchStyle, $srchFrame, $srchColl);
                                        $reason = $retrieveApplCMCalcs['reason'];
                                        $wrapperWidthR = $initialCMCalcs['wrapperWidthR'];
                                        $validTorque = $retrieveApplCMCalcs['validTorque'];
                                        break;
                                }

                            if ($validTorque == true) {
                                $modelNo = $this->modelNO(0, 0, $srchStyle, $srchFrame, 0, $srchSpring, $srchColl, 0, 0, $pretensionTurns, 0, 0, 0, 0, $hoseIDCode);
                                //debugbar::info("modelNo = " . $modelNo);
                                goto MODELFOUND;
                            }

                        }//add to invalid reels

                            $spoolWidthCode = 0;
                            $invalidReel = $this->modelNO(0, 0, $srchStyle, $srchFrame, $swOpt, $srchSpring, $srchColl, $drumSize, $srchGear, $pretensionTurns, $spoolWidthCode, $cable, $cableOrHose, $srchMotor, $hoseIDCode);
                            $invR = array('invalidReel' => $invalidReel, 'reason' => $reason);
                            array_push($invalidReelArray, $invR);
                    }
                    //PRETENSSKIP:
                    //debugbar::info("Just out of the inner for-loop");
                }//End of for-loop for C and HM
            }else{

                for ($drumSize = $validDrumMax; $drumSize >= $srchDrummin; $drumSize -= $drumIncrement) { //line 4520

                    //fwrite($debugFile, "drumSize: " . $drumSize. PHP_EOL);

                    for ($pretensionTurns = $srchPremin; $pretensionTurns <= $validPretensMax; $pretensionTurns++) {

                        //fwrite($debugFile, "pretensionTurns: " . $pretensionTurns. PHP_EOL);

                            if ($srchStyle == "K") {
                                //these are likely initializations to prevent errors, have search style of k likely does not assign them.
                                $srchSpoolWidth = 0;
                                $srchSpoolMethod = 0;
                            }

                            $initialCalcs = $this->doInitialCalcs($srchSpoolWidth, $srchSpoolMethod, $srchStyle, $srchFrame, $swOpt, $cable, $drumSize, $pretensionTurns, $application['ccf'], $application['activeTravel'], $application['deadWraps'], $calcTorqueParams, $collector, $srchSpring, $srchGear, $modelIndex, $specificInput, $cableOrHose, $srchMotor, $application, $srchColl, $uReelWidth, $this->uReelWidthInp);
                            $validCompartment = $initialCalcs['validCompartment'];
                            $validTurns = $initialCalcs['validTurns'];

                        //fwrite($debugFile, "validCompartment: " . $validCompartment. PHP_EOL);

                        if (!$validCompartment) {
                            goto PRETENSSKIP;
                        }

                        //fwrite($debugFile, "validTurns: " . $validTurns. PHP_EOL);
                        //fwrite($debugFile,  PHP_EOL);

                        if ($validTurns) {

                            $validTorque = false;
                                $turnsActiveCableLength = $initialCalcs['turnsActiveCableLength'];
                                //fwrite($debugFile, "turnsActiveCableLength: " . $turnsActiveCableLength. PHP_EOL);

                                switch ($application['appl']) {
                                    case 'stretch':
                                        $stretchApplCalcs = $this->calcStretchAppl($srchStyle, $modelIndex, $pretensionTurns, $application, $initialCalcs, $cable, $drumSize, $gearRatio, $validTorque, $specificInput, $srchSpring, $srchGear);
                                        $validTorque = $stretchApplCalcs['validTorque'];
                                        $reason = $stretchApplCalcs['reason'];
                                        $wrapperWidthR = $initialCalcs['wrapperWidthR'];
                                        break;
                                    case 'lift': //todo get lift calcs here
                                    case 'magnet':
                                        $liftApplCalcs = $this->calcLiftAppl($srchStyle, $modelIndex, $pretensionTurns, $application, $initialCalcs, $cable, $drumSize, $gearRatio, $validTorque, $specificInput, $srchColl, $srchSpring);
                                        $validTorque = $liftApplCalcs['validTorque'];
                                        $wrapperWidthR = $initialCalcs['wrapperWidthR'];
                                        $reason = $liftApplCalcs['reason'];
                                        break;
                                    case 'retrieve':
                                    case 'hand':
                                        $retrieveApplCalcs = $this->calcRetrieveAppl($srchStyle, $modelIndex, $pretensionTurns, $application, $initialCalcs, $cable, $drumSize, $gearRatio, $validTorque, $specificInput);
                                        $reason = $retrieveApplCalcs['reason'];
                                        $wrapperWidthR = $initialCalcs['wrapperWidthR'];
                                        $validTorque = $retrieveApplCalcs['validTorque'];
                                        break;
                                }

                            if (($srchStyle == "SHO" || $srchStyle == "TMR") && $validTorque && $application['appl'] == 'stretch') {
                                $adjTrq = $initialCalcs['adjustedTorque'];
                                $maxStretchCapacityOfReel = $stretchApplCalcs['maxStretchCapacityOfReel'];
                                $stressApplCalcs = $this->calcStressBearing($srchSpoolMethod, $srchFrame, $wrapperWidthR, $application, $cable, $maxStretchCapacityOfReel, $initialCalcs["TWLC"], $srchGear, $srchChainRatio, $specificInput, $adjTrq);
                                $shaftStress = $stressApplCalcs['shaftStress'];
                                $bearingLoad = $stressApplCalcs['bearingLoad'];

                                if ($stressApplCalcs['validStress'] && $validTorque) {
                                    //valid stress and torque
                                    goto MODELFOUND;
                                } else {
                                    goto NextReel;
                                }
                            } else {
                                if (($srchStyle == "SHO" || $srchStyle == "TMR") && $validTorque && $application['appl'] == 'lift') {
                                    $adjTrq = $initialCalcs['adjustedTorque'];
                                    $maxLiftCapacityOfReel = $liftApplCalcs['maxLiftCapacityOfReel'];
                                    $stressApplCalcs = $this->calcStressBearing($srchSpoolMethod, $srchFrame, $wrapperWidthR, $application, $cable, $maxLiftCapacityOfReel, $initialCalcs["TWLC"], $srchGear, $srchChainRatio, $specificInput, $adjTrq);
                                    $this->shaftStress = $stressApplCalcs['shaftStress'];
                                    $this->bearingLoad = $stressApplCalcs['bearingLoad'];
                                    if ($stressApplCalcs['validStress'] && $validTorque) {
                                        //valid stress and torque
                                        goto MODELFOUND;
                                    } else {
                                        goto NextReel;
                                    }
                                } else {
                                    if ($validTorque == true) {
                                        //$validTorque == true
                                        goto MODELFOUND;
                                    }
                                }
                            }
                        }//add to invalid reels

                            if ($srchStyle == "SHO") {
                                $invalidReel = $this->modelNO($srchSpoolWidth, $srchSpoolMethod, $srchStyle, $srchFrame, $swOpt, $srchSpring, $srchColl, $drumSize, $srchGear, $pretensionTurns, 0, $cable, $cableOrHose, $srchMotor, $hoseIDCode);
                                $invR = array('invalidReel' => $invalidReel, 'reason' => $reason);
                                array_push($invalidReelArray, $invR);
                            } else {
                                $invalidReel = $this->modelNO(0, 0, $srchStyle, $srchFrame, $swOpt, $srchSpring, $srchColl, $drumSize, $srchGear, $pretensionTurns, 0, $cable, $cableOrHose, $srchMotor, $hoseIDCode);
                                $invR = array('invalidReel' => $invalidReel, 'reason' => $reason);
                                array_push($invalidReelArray, $invR);
                            }
                            $spoolWidthCode = 0;
                            $invalidReel = $this->modelNO(0, 0, $srchStyle, $srchFrame, $swOpt, $srchSpring, $srchColl, $drumSize, $srchGear, $pretensionTurns, $spoolWidthCode, $cable, $cableOrHose, $srchMotor, $hoseIDCode);
                            $invR = array('invalidReel' => $invalidReel, 'reason' => $reason);
                            array_push($invalidReelArray, $invR);
                    }//End of for-loop : pretensionTurns
                    PRETENSSKIP:
                }//End of for-loop for other reel types : drumSize
            }

            goto NextReel;

            MODELFOUND:
            ++$recNumber;


            if ($srchStyle != "C" && $srchStyle != "HM") {
                $spoolWidthCode = $initialCalcs['SWC'];
                $modelWeightCalcs = $this->calcModelWeight($srchStyle, $srchSpring, $srchFrame, $gearRatio, $cable, $cableOrHose, $srchMotor);
                $modelWeight = $modelWeightCalcs["modelWeight"];
                $dimensions = $this->calcModelDimensions($srchStyle, $srchFrame, $swOpt, $gearRatio, $srchSpring, $wrapperWidthR, $srchSpoolMethod, $srchSpoolWidth, $srchColl, $modelWeightCalcs, $this->uReelWidthInp, $cableOrHose, $srchMotor, $hoseIDCode);
                $reelPriceCalcs = $this->calcReelPrice($cableOrHose, $srchStyle, $hoseIDCode, $srchCost, $srchFrame, $swOpt, $srchColl, $this->uReelWidthInp);
                $extraCableAtReel = $this->calcExtraCable($srchColl, $srchStyle, $drumSize, $application['deadWraps'], $cable['thickness'], $initialCalcs["deadWrapLength"]);
                //Debugbar::info("dimensWidth = ".$dimensions['dimensWidth']);
                //Debugbar::info("recNumber = ".$recNumber);
                $validReel[$recNumber] = array();
                $vR = $validReel[$recNumber];
                $vR['modelNum'] = $this->modelNO($srchSpoolWidth, $srchSpoolMethod, $srchStyle, $srchFrame, $swOpt, $srchSpring, $srchColl, $drumSize, $srchGear, $pretensionTurns, $spoolWidthCode, $cable, $cableOrHose, $srchMotor, $hoseIDCode);
                $vR['turnsLimit'] = $initialCalcs['availSpringTurns'];
                $vR['compartmentCapacity'] = $initialCalcs['compartmentActiveCableLength'];
                $vR['turnsCapacity'] = $initialCalcs['turnsActiveCableLength'];

            } else {
                //$availableSpringTurnsForStretch = $stretchApplCMCalcs['availableSpringTurnsForStretch'];
                $modelWeightCalcs = $this->calcModelWeight($srchStyle, $srchSpring, $srchFrame, $gearRatio, $cable, $cableOrHose, $srchMotor);
                $modelWeight = $modelWeightCalcs["modelWeight"];
                $dimensions = $this->calcModelDimensions($srchStyle, $srchFrame, $swOpt, $gearRatio, $srchSpring, $wrapperWidthR, $srchSpoolMethod, $srchSpoolWidth, $srchColl, $modelWeightCalcs, $reelWithInp, $cableOrHose, $srchMotor, $hoseIDCode);
                $reelPriceCalcs = $this->calcReelPrice($cableOrHose, $srchStyle, $hoseIDCode, $srchCost, $srchFrame, $swOpt, $srchColl, $this->uReelWidthInp);
                $extraCableAtReel = $this->calcExtraCable($srchColl, $srchStyle, $drumSize, $application['deadWraps'], $cable['thickness'], 0);
                //Debugbar::info("recNumber = ".$recNumber);
                $validReel[$recNumber] = array();
                $vR = $validReel[$recNumber];
                $vR['turnsLimit'] = $initialCMCalcs['availSpringTurns'];
                $vR['modelNum'] = $this->modelNO(0, 0, $srchStyle, $srchFrame, $swOpt, $srchSpring, $srchColl, $drumSize, $srchGear, $pretensionTurns, 0, $cable, $cableOrHose, $srchMotor, $hoseIDCode);
                $vR['compartmentCapacity'] = floatval(number_format($initialCMCalcs['compartmentActiveCableLength'], 2));
                $vR['turnsCapacity'] = floatval(number_format($initialCMCalcs['turnsActiveCableLength'], 2));
            }

            if ($srchStyle == 'U') {
                switch ($cableOrHose) {
                    case 'C':
                        $vR['series'] = 'UE';
                        break;
                    default:
                        $vR['series'] = 'UH';
                }
            } else {
                $vR['series'] = $srchStyle;
            }
            $vR['frame'] = $srchFrame;
            $vR['spring'] = $srchSpring;
            $vR['coll'] = $srchColl;
            $vR['collectorCost'] = $reelPriceCalcs['collectorPrice'];
            if ($vR['collectorCost'] < 0) {
                $vR['collectorCost'] = 0;
            }
            $vR['pretension'] = $pretensionTurns;
            $vR['drum'] = $drumSize;
            $vR['motor'] = $srchMotor;
            $vR['spoolWidth'] = $srchSpoolWidth;
            $vR['spoolDiam'] = $srchFrame;
            $metricDefault = false;
            switch ($metricDefault) {
                case true:
                    $vR['modelWgt'] = floatval(number_format($modelWeight * 0.45359, 1));
                    $vR['dimWidth'] = floatval(number_format($dimensions['dimensWidth'] * 25.4, 0));
                    $vR['dimHeight'] = floatval(number_format($dimensions['dimensHeight'] * 25.4, 0));
                    $vR['dimDepth'] = floatval(number_format($dimensions['dimensDepth'] * 25.4, 0));
                    $vR['extraCable'] = floatval(number_format($extraCableAtReel * 0.3048, 1));
                    break;
                case false:
                    $vR['modelWgt'] = floatval(number_format($modelWeight, 2));
                    $vR['dimWidth'] = floatval(number_format($dimensions['dimensWidth'], 2));
                    $vR['dimHeight'] = floatval(number_format($dimensions['dimensHeight'], 2));
                    $vR['dimDepth'] = floatval(number_format($dimensions['dimensDepth'], 2));
                    $vR['extraCable'] = floatval(number_format($extraCableAtReel, 2));
                    break;
            }


            switch ($application['appl']) {
                // in this program the values aren't single letters like L and M, they're written out
                case 'lift':
                case 'magnet':
                    if ($srchStyle == "C" || $srchStyle == "HM") {
                        $vR['torqWFullReel'] = floatval(number_format($liftApplCMCalcs['netTorqueWithReelFullLift'], 2));
                        $vR['torqueCapacity'] = floatval(number_format($liftApplCMCalcs['maxActiveLengthOfCableFromTorqueLift'], 2));
                        $vR['maxCapacity'] = floatval(number_format($liftApplCMCalcs['maxLiftCapacityOfReel'], 2));
                    } else {
                        $vR['torqWFullReel'] = floatval(number_format($liftApplCalcs['netTorqueWithReelFullLift'], 2)); // format
                        $vR['torqueCapacity'] = floatval(number_format($liftApplCalcs['maxActiveLengthOfCableFromTorqueLift'], 2)); // format
                        $vR['maxCapacity'] = floatval(number_format($liftApplCalcs['maxLiftCapacityOfReel'], 2)); // format
                    }

                    break;
                case 'stretch':
                    if ($srchStyle != "C" && $srchStyle != "HM") {
                        $vR['torqWFullReel'] = floatval(number_format($stretchApplCalcs['netTorqueWithReelFullStretch'], 2)); // format
                        $vR['torqueCapacity'] = floatval(number_format($stretchApplCalcs['maxActiveLengthOfCableFromTorqueStretch'], 2)); // format
                        $vR['maxCapacity'] = floatval(number_format($stretchApplCalcs['maxStretchCapacityOfReel'], 2)); // format
                    } else {
                        $vR['torqWFullReel'] = floatval(number_format($stretchApplCMCalcs['netTorqueWithReelFullStretch'], 2));
                        $vR['torqueCapacity'] = floatval(number_format($stretchApplCMCalcs['maxActiveLengthOfCableFromTorqueStretch'], 2)); // format
                        $vR['maxCapacity'] = floatval(number_format($stretchApplCMCalcs['maxStretchCapacityOfReel'], 2)); // format

                    }
                    break;
                case 'retrieve':
                case 'hand':
                    if ($srchStyle != "C" && $srchStyle != "HM") {
                        $vR['torqWFullReel'] = floatval(number_format($retrieveApplCalcs['netTorqueWithReelFullRetrieve'], 2)); // format
                        $vR['torqueCapacity'] = floatval(number_format($retrieveApplCalcs['maxCenterLineHeight'], 2)); // format
                        $vR['maxCapacity'] = floatval(number_format($retrieveApplCalcs['maxCapacity'], 2)); // format
                    } else {
                        $vR['torqWFullReel'] = floatval(number_format($retrieveApplCMCalcs['netTorqueWithReelFullRetrieve'], 2)); // format
                        $vR['torqueCapacity'] = floatval(number_format($retrieveApplCMCalcs['maxCenterLineHeight'], 2)); // format
                        $vR['maxCapacity'] = floatval(number_format($retrieveApplCMCalcs['maximumRetrieveCapacityOfReel'], 2)); // format
                    }
                    break;
            }
            $vR['quoteFlag'] = 3;
            $vR['totalReelPrice'] = $reelPriceCalcs['reelTotalListPrice'];
            // $vR['invalidWarn'] = $invalidWarning;
            $vR['locationPointer'] = $recNumber;
            $validReel[$recNumber] = $vR;


            if ($srchStyle != "C" && $srchStyle != "HM") {

                switch ($application['appl']) {

                    //Testing concacts on data
                    case 'stretch':
                        $data = $this->WriteDetailsSummary($vR, $application, $srchStyle, $application['deadWraps'], $initialCalcs, $stretchApplCalcs, $extraCableAtReel, $specificInput, $modelIndex, $turnsActiveCableLength, $cable, 0, 0);
                        if ($srchStyle == "SHO") {
                            $data = $this->WriteDetailsSummary($vR, $application, $srchStyle, $application['deadWraps'], $initialCalcs, $stretchApplCalcs, $extraCableAtReel, $specificInput, $modelIndex, $turnsActiveCableLength, $cable, $bearingLoad, $shaftStress);
                        }
                        break;
                    case 'lift':
                    case 'magnet':
                        $data = $this->WriteDetailsSummary($vR, $application, $srchStyle, $application['deadWraps'], $initialCalcs, $liftApplCalcs, $extraCableAtReel, $specificInput, $modelIndex, $turnsActiveCableLength, $cable, 0, 0);
                        break;
                    case "retrieve":
                    case 'hand':
                        $data = $this->WriteDetailsSummary($vR, $application, $srchStyle, $application['deadWraps'], $initialCalcs, $retrieveApplCalcs, $extraCableAtReel, $specificInput, $modelIndex, $turnsActiveCableLength, $cable, 0, 0);
                        break;
                }
            } else {
                switch ($application['appl']) {
                    case "stretch":
                        $data = $this->WriteDetailsSummary($vR, $application, $srchStyle, $application['deadWraps'], $initialCMCalcs, $stretchApplCMCalcs, $extraCableAtReel, $specificInput, $modelIndex, $initialCMCalcs['turnsActiveCableLength'], $cable, 0, 0);
                        break;
                    case "lift":
                    case 'magnet':
                        $data = $this->WriteDetailsSummary($vR, $application, $srchStyle, $application['deadWraps'], $initialCMCalcs, $liftApplCMCalcs, $extraCableAtReel, $specificInput, $modelIndex, $initialCMCalcs['turnsActiveCableLength'], $cable, 0, 0);
                        break;
                    case 'retrieve':
                    case 'hand':
                        $data = $this->WriteDetailsSummary($vR, $application, $srchStyle, $application['deadWraps'], $initialCMCalcs, $retrieveApplCMCalcs, $extraCableAtReel, $specificInput, $modelIndex, $initialCMCalcs['turnsActiveCableLength'], $cable, 0, 0);
                        break;
                }
            }

            break;

            NextReel:
            ++$reelIndex;
            //debugbar::info(" At the end of while loop. reelIndex value: " . $reelIndex);

        }//End of while loop
        if ($srchStyle == "C" || $srchStyle == "HM") {
            $initialCalcs = $initialCMCalcs;
        }

        //todo:find a way to return data for multiple valid reels.
        /*old code
        *$dataArr = array('data' => $data, 'vr' => $vR, 'application' => $application, 'initialCalcs' => $initialCalcs, 'invalidArray' => $invalidReelArray);
        */
        //new code that adds valid reels to the dataArr array
        //attempt to load globals containing calc data into the data array
        $dataArr = array('calcResultData' => $this->globals->calcResultData,'data' => $data, 'vr' => $vR, 'application' => $application, 'initialCalcs' => $initialCalcs, 'invalidArray' => $invalidReelArray, 'validArray' => $validReel, 'cable' => $cable, 'cableOrHose' => $cableOrHose, 'metricDefault' => $metricDefault);

        //Debugbar::info($dataArr);
        //dump($dataArr);
        //fclose($debugFile);

        return $dataArr;
    }//End of loopThuReels()

    private function writeLiftSummary($srchStyle, $availSpringTurns, $specificInput, $modelIndex, $applCalcs, $initialCalcs, $application) {
        $netTorqueWithReelFullLift = $applCalcs['netTorqueWithReelFullLift'];
        $unusedSpringTurnsForLift = $applCalcs['unusedSpringTurnsForLift'];
        $availableSpringTurnsForLift = $applCalcs['availableSpringTurnsForLift'];
        $compartmentActiveCableLength = $initialCalcs['compartmentActiveCableLength'];
        $turnsActiveCableLength = $initialCalcs['turnsActiveCableLength'];
        $maxActiveLengthOfCableFromTorqueLift = $applCalcs['maxActiveLengthOfCableFromTorqueLift'];
        $travelInFt = $application["activeTravel"];
        $maxLiftCapacityOfReel = $applCalcs['maxLiftCapacityOfReel'];
        if ($srchStyle == "TMR") {
            $shaftStress = $this->shaftStress;
            $bearingLoad = $this->bearingLoad;
            $tqoute = $applCalcs['tqoute'];
            $rnme = $applCalcs['rnme'];
        } else {
            $shaftStress = 0;
            $bearingLoad = 0;
            $rnme = 0;
            $tqoute = 0;
        }


        $data = "<br>************LIFT ANALYSIS SUMMARY**************<br>";

        if ($srchStyle != "TMR" && $srchStyle != "P") {
            $data .= "<br>Turns Limit = $availSpringTurns";
            if ($specificInput == true) {
                $data .= "<br> Unused Turns = $unusedSpringTurnsForLift avail. Turns = $availableSpringTurnsForLift";
                if ($unusedSpringTurnsForLift != 0 || $availableSpringTurnsForLift != 0) {
                    $data .= "<br> Add Another Pretension Turn";
                }

            }
            $data .= "<br>Net Torque With Reel Full = $netTorqueWithReelFullLift";
        }

        $data .= "<br> Compartment Capacity = $compartmentActiveCableLength";

        if ($srchStyle != "TMR" && $srchStyle != "P") {
            $data .= "<br>Spring Turns Capacity = $turnsActiveCableLength";
            $data .= "<br>Spring Torque Capacity = $maxActiveLengthOfCableFromTorqueLift";
        } else {
            $data .= "<br>Motor Torque Capacity = $maxActiveLengthOfCableFromTorqueLift";
        }
        switch ($srchStyle) {
            case "SHO":
            case "TMR":
                if ($maxLiftCapacityOfReel < $travelInFt || $netTorqueWithReelFullLift < 0 || $shaftStress > 8000 || $bearingLoad > 2300 || $rnme > 450) {
                    $data .= "<br>The Maximum lift capacity of this reel = ***.*";

                } else {
                    $data .= "<br>The Maximum lift capacity of this reel = $maxLiftCapacityOfReel";
                }
                $data .= "<br>Shaft Stress = $shaftStress PSI  (8000 MAX)";
                $data .= "<br>Bearing Load = $bearingLoad LBS  (2300 MAX)";
                if ($srchStyle == "TMR") {
                    $data .= "<br>Max RPM (EMPTY) = $rnme";
                    $data .= "<br>Motor torque = $tqoute";
                }
                break;
            default:
                $data .= "<br>The Maximum lift capacity of this reel = $maxLiftCapacityOfReel";


        }

        if ($maxLiftCapacityOfReel < $travelInFt || $netTorqueWithReelFullLift < 0 || $shaftStress > 8000 || $bearingLoad > 2300 || $rnme > 450) {
            $data .= "<br>WARNING-- SPECIFIED CABLE NOT VALID";
        }

        return $data;

    } 

    private function writeDetailsSummary($vR, $application, $srchStyle, $deadWraps, $initialCalcs, $applCalcs, $extraCableAtReel, $specificInput, $modelIndex, $turnsActiveCableLength, $cable, $bearingLoad, $shaftStress) {


        if ($srchStyle != "C" && $srchStyle != "HM") {
            if ($application['appl'] == "stretch") {
                $availableSpringTurnsForStretch = $applCalcs['availableSpringTurnsForStretch'];
                $maxFullLayersFromTorqueStretchR = $applCalcs['maxFullLayersFromTorqueStretchR'];
                $extraWrapsAfterFullLayersTorqueStretchR = $applCalcs['extraWrapsAfterFullLayersTorqueStretchR'];
                $torqueActiveStretchLength = $applCalcs['torqueActiveStretchLength'];
                $maxLengthCableFromTorqueStretch = $applCalcs['maxLengthCableFromTorqueStretch'];
                $maxActiveLengthOfCableFromTorqueStretch = $applCalcs['maxActiveLengthOfCableFromTorqueStretch'];
            }
            //todo: finish lift and retrieve app calculations
            if ($application['appl'] == "lift") {

                $torqueActiveLiftLength = $applCalcs['torqueActiveLiftLength'];
                $maxFullLayersSfromTorqueliftR = $applCalcs['maxFullLayersFromTorqueLiftR'];
                $extraWrapsAfterFullLayersTorqueLiftR = $applCalcs['extraWrapsAfterFullLayersTorqueLiftR'];
                $maxLengthCableFromTorqueLift = $applCalcs["maxLengthCableFromTorqueLift"];
                $maxActiveLengthOfCableFromTorqueLift = $applCalcs["maxActiveLengthOfCableFromTorqueLift"];
                //Andy's code end
            }
            if ($application['appl'] == "retrieve") {

            }


            $wrapperWidthR = $initialCalcs['wrapperWidthR'];
            $compartmentHeight = $initialCalcs['compartmentHeight'];
            $maxWrapsPerLayerRStored = $initialCalcs['maxWrapsPerLayerRStored'];
            $maxCableLayersR = $initialCalcs['maxCableLayersR'];
            $compartmentMaximumCableLength = $initialCalcs['compartmentMaximumCableLength'];
            $maxWrapsPerLayerI = $initialCalcs['maxWrapsPerLayerI'];
            $maxUsableLayersI = $initialCalcs['maxUsableLayersI'];
            $cableCapacityLostFirstClearanceWrap = $initialCalcs['cableCapacityLostFirstClearanceWrap'];
            $cableCapacityLostSecondClearanceWrap = $initialCalcs['cableCapacityLostSecondClearanceWrap'];
            $cableCapacityLostThirdClearanceWrap = $initialCalcs['cableCapacityLostThirdClearanceWrap'];
            $compartmentCableCapacity = $initialCalcs['compartmentCableCapacity'];
            $deadWrapLength = $initialCalcs['deadWrapLength'];
            $compartmentActiveCableLength = $initialCalcs['compartmentActiveCableLength'];
            $cableClearanceInInches = $initialCalcs['cableClearanceInInches'];
            $cableClearanceInInchesLess1Layers = $initialCalcs['cableClearanceInInchesLess1Layers'];
            $cableClearanceInInchesLess2Layers = $initialCalcs['cableClearanceInInchesLess2Layers'];
            $cableClearanceInInchesLess3Layers = $initialCalcs['cableClearanceInInchesLess3Layers'];
            $cableClearanceFactor = $initialCalcs['cableClearanceFactor'];
            $maxFullLayersFromTurnsR = $initialCalcs['maxFullLayersFromTurnsR'];
            $extraWrapsAfterFullLayersTurnsI = $initialCalcs['extraWrapsAfterFullLayersTurnsI'];
            $turnsMaximumCableLength = $initialCalcs['turnsMaximumCableLength'];
            $turnsActiveCableLength = $initialCalcs['turnsActiveCableLength'];
            $travelInFt = $application["activeTravel"];

        } else {
            if ($application['appl'] == "stretch") {
                $availableSpringTurnsForStretch = $applCalcs['availableSpringTurnsForStretch'];
                $maxActiveLengthOfCableFromTorqueStretch = $applCalcs['maxActiveLengthOfCableFromTorqueStretch'];
                $maxWrapsFromTorqueStretch = $applCalcs["maxWrapsFromTorqueStretch"];
            }
            if ($application['appl'] == "lift") {
                $maxActiveLengthOfCableFromTorqueLift = $applCalcs['maxActiveLengthOfCableFromTorqueLift'];
                $maxWrapsFromTorqueLift = $applCalcs["maxWrapsFromTorqueLift"];
                $maxLengthCableFromTorqueLift = $applCalcs['maxLengthCableFromTorqueLift'];
            }
            $maxUsableWrapsR = $initialCalcs["maxUsableWrapsR"];
            $springTurnsAvailAfterPretensionR = $initialCalcs["springTurnsAvailAfterPretensionR"];
            $ec = $initialCalcs["ec"];
            $drumSize = $initialCalcs["drumSize"];
            $wrap = $initialCalcs["wraparr"];
            $ccf = $initialCalcs['cableClearenceFactor'];
            $maxUsableLayersR = $initialCalcs["maxUsableLayersR"];
            $cableThick = $cable['thickness'];
            $frameSize = $initialCalcs["frameSize"];
            $compartmentActiveCableLength = $initialCalcs['compartmentActiveCableLength'];
            $maxLengthCableFromTorqueStretch = 0;
            $row = $initialCalcs["row"];
            $ixarr = $initialCalcs["ixarr"];
        }

        $data = '';
        $data .= '<br>DATA';
        $data .= "<br>***********************************************************<br>";
        //$modelNO = $vR['modelNO'];
        //$reelTotalListPrice = ; // format
        $data .= "\n<br>Reel Model: {$vR['modelNum']}";
        $data .= "\n<br>REEL price: {$vR['totalReelPrice']}<br>";
        $data .= "\nDimensions (inches): {$vR['dimWidth']} x {$vR['dimHeight']} x {$vR['dimDepth']}         Weight: {$vR['modelWgt']}<br>";

        switch ($application['appl']) {
            case 'stretch':
                if ($srchStyle != "C" && $srchStyle != "HM") {
                    if ($srchStyle == "SHO") {
                        $data .= $this->writeStretchSummary($srchStyle, $vR['turnsLimit'], $specificInput, $modelIndex, $applCalcs['unusedSpringTurnsForStretch'], $applCalcs['netTorqueWithReelFullStretch'], $compartmentActiveCableLength, $maxActiveLengthOfCableFromTorqueStretch, $applCalcs['maxStretchCapacityOfReel'], $travelInFt, $availableSpringTurnsForStretch, $turnsActiveCableLength);
                    } else {
                        $data .= $this->writeStretchSummary($srchStyle, $vR['turnsLimit'], $specificInput, $modelIndex, $applCalcs['unusedSpringTurnsForStretch'], $applCalcs['netTorqueWithReelFullStretch'], $compartmentActiveCableLength, $maxActiveLengthOfCableFromTorqueStretch, $applCalcs['maxStretchCapacityOfReel'], $travelInFt, $availableSpringTurnsForStretch, $turnsActiveCableLength);
                    }
                } else {
                    $data .= $this->writeStretchSummary($srchStyle, 0, $specificInput, $modelIndex, $applCalcs['unusedSpringTurnsForStretch'], $applCalcs['netTorqueWithReelFullStretch'], $compartmentActiveCableLength, $maxActiveLengthOfCableFromTorqueStretch, $applCalcs['maxStretchCapacityOfReel'], $application["activeTravel"], $availableSpringTurnsForStretch, $turnsActiveCableLength);
                }
                break;
            case 'lift':
                if ($srchStyle != "C" && $srchStyle != "HM") {
                    $data .= $this->writeLiftSummary($srchStyle, $vR['turnsLimit'], $specificInput, $modelIndex, $applCalcs, $initialCalcs, $application);
                } else {
                    $data .= $this->writeLiftSummary($srchStyle, $vR['turnsLimit'], $specificInput, $modelIndex, $applCalcs, $initialCalcs, $application);
                }
                break;
            case 'retrieve':
                if ($srchStyle != "C" && $srchStyle != "HM") {
                    $data .= $this->writeRetrieveSummary($srchStyle, $vR['turnsLimit'], $specificInput, $modelIndex, $compartmentActiveCableLength, $travelInFt, $applCalcs, $initialCalcs, $application, $bearingLoad, $shaftStress);
                }
                break;
        }

        if ($srchStyle == 'C' || $srchStyle == 'HM') { //SEE LINE 7430 of line
            $data .= "<br>";
            $data .= "\nCable Clearance Factor: $ccf Dead Wraps: $deadWraps<br>"; //$ccf = cableCLEARANCEfactor
            $data .= "\nCable Compartment: $maxUsableWrapsR wraps $compartmentActiveCableLength feet max<br>";
            $data .= "Spring turns: $springTurnsAvailAfterPretensionR wraps $turnsActiveCableLength feet max<br>";
            switch ($application['appl']) {
                case "stretch":
                    $data .= "Spring Torque: $maxWrapsFromTorqueStretch wraps, $maxLengthCableFromTorqueStretch feet max<br><br>";
                    break;
                case "lift": //todo add cade "magnet"
                    $data .= "Spring Torque= $maxWrapsFromTorqueLift wraps, $maxLengthCableFromTorqueLift ft max";
                    break;
                case "retrieve":
                    $data .= "Max retrieve height: " . $vR['torqueCapacity'] . " feet";//todo: CAI I believe this needs to be $maxCenterLine
                    break;
            }
            //todo: match this with line 7441 in ReelMod.bas
            $data .= "Row&emsp;Wrap&emsp;Per Wrap&emsp;&emsp;&emsp;&emsp;&emsp;Per Row&emsp;&emsp;&emsp;&emsp;&emsp;Total&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;Clearance<br>";
            $data .= "-----------------------------------------------------------------------------------------------------------<br>";

            $total = 0;

            if ($ec != 0 && $ccf >= 1) {
                $ixarr[$maxUsableLayersR] = $ec;
                $row[$maxUsableLayersR] = $ixarr[$maxUsableLayersR] * $wrap[$maxUsableLayersR];

            }
            for ($iyind = 1; $iyind <= $maxUsableLayersR; $iyind++) {
                $clearance = (($frameSize - $drumSize) / 2) - ($iyind * $cableThick);
                $total += $row[$iyind];
                $data .= "$iyind &#09;&emsp;&emsp; $ixarr[$iyind] &#09;&emsp;&emsp; " . number_format($wrap[$iyind], 2) . " &#09;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp; &emsp; " . number_format($row[$iyind], 2) . " &#09;&emsp;&emsp;&emsp;&emsp;&emsp; " . number_format($total, 2) . " &#09;&emsp; " . number_format($clearance, 2) . "<br>";
            }

            //add the information to the calcResultData global, so it can be printed to the page later
            $this ->globals->calcResultData .= $data;
            return $data;

        }

        $data .= "\nCompartment size is $wrapperWidthR wide by $compartmentHeight high<br>";


        $data .= "\nMaximum cable stacking is " . round($maxWrapsPerLayerRStored, 7, PHP_ROUND_HALF_UP) . " wide by " . round($maxCableLayersR, 6, PHP_ROUND_HALF_UP) . " high<br>";
        $data .= "\nMaximum length of cable that will fit in compartment (ft) = " . round($compartmentMaximumCableLength, 5) . "<br>";
        $data .= "\nRecommended factor of safety (cable diameters) = $cableClearanceFactor<br>";
        $data .= "\nRecommended cable stacking is " . round($maxWrapsPerLayerI) . " wide by " . round($maxUsableLayersI) . " high<br>";
        //todo: implement the following lines
        // If (srchSPOOLMETHOD = "R" And (srchSTYLE = "SHO" Or srchSTYLE = "TMR")) Or srchSTYLE = "U" Then
        //   Print #1, "**** Calculations based alternating rows of "; maxWRAPSperLAYERi; " and "; maxWRAPSperLAYERi - 1; " wraps."
        // End If

        $data .= "\nLength of cable lost due to 1st clearance wrap (ft) = " . round($cableCapacityLostFirstClearanceWrap, 5) . "<br>";
        $data .= "\nLength of cable lost due to 2nd clearance wrap (ft) = " . round($cableCapacityLostSecondClearanceWrap, 5) . "<br>";
        $data .= "\nLength of cable lost due to 3rd clearance wrap (ft) = " . round($cableCapacityLostThirdClearanceWrap, 5) . "<br>";


        $data .= "\nRecommended length of cable to be placed in the compartment (ft) = " . round($compartmentCableCapacity, 5) . "<br>";
        $data .= "\nLength of cable lost due to $deadWraps dead wrap(s) = " . round($deadWrapLength, 5) . "<br>";
        $data .= "\nMaximum length of active cable handled by compartment (ft) = " . round($compartmentActiveCableLength, 5) . "<br>";

        $data .= "\nCable clearance with safety margin (inches) = $cableClearanceInInches<br>";


        $data .= "\nCable clearance without 1st wrap of safety margin (inches) = $cableClearanceInInchesLess1Layers<br>";
        $data .= "\nCable clearance without 2nd wrap of safety margin (inches) = $cableClearanceInInchesLess2Layers<br>";
        $data .= "\nCable clearance without 3rd wrap of safety margin (inches) = $cableClearanceInInchesLess3Layers<br>";


        $data .= "\n<br>Cable compartment limit summary:<br>";
        $data .= "\n\t&nbsp;maximum cable stacking is $maxUsableLayersI Rows of $maxWrapsPerLayerI<br>";
        //todo: impliment the following lines
        // If srchSPOOLMETHOD = "R" And (srchSTYLE = "SHO" Or srchSTYLE = "TMR") Then
        //      Print #1, "**** Calculations based alternating rows of "; maxWRAPSperLAYERi; " and "; maxWRAPSperLAYERi - 1; " wraps."
        // End If
        // $data.= "<br>*** Caclulations based alternating rows of $maxWrapsPerLayerI and $maxWrapsPerLayerI<br>";
        $data .= "\n\t&nbsp;maximum length of cable (ft) = " . round($compartmentMaximumCableLength, 5) . "<br>";
        $data .= "\n\t&nbsp;maximum active length of cable (ft) = " . round($compartmentActiveCableLength, 5) . "<br>";
        if ($srchStyle != 'TMR' && $srchStyle != 'P') {
            $driveType = 'Spring';
            $data .= "Spring turns limit summary:<br>";
            $data .= "\n\t&nbsp;maximum cable stacking is $maxFullLayersFromTurnsR rows of $maxWrapsPerLayerI and 1 row of $extraWrapsAfterFullLayersTurnsI<br>";
            $data .= "\n\t&nbsp;maximum length of cable (ft) =" . round($turnsMaximumCableLength, 5) . "<br>"; //this value is not an exact match with the original program
            $data .= "\n\t&nbsp;maximum active length of cable (ft) = " . round($turnsActiveCableLength, 5) . "<br>"; //this value is not an exact match with the original program
        } else {
            $driveType = 'Motor';
        }

        //todo: Complete these calculations and test them to confirm accurate values see line 7494 of REELMOD.BAS lift/magnet section complete
        switch ($application['appl']) {
            case 'lift':
            case 'magnet'://Complete
                $maxFullLayersFromTorqueLiftI = $maxFullLayersSfromTorqueliftR; //not necessary, Im just keeping syntax from vb6 code, where they assigned I variables to Int(R) variables my guess is that vb6 required that they have Integers to exclude decimal places
                $extraWrapsAfterFullLayersTorqueLiftI = $extraWrapsAfterFullLayersTorqueLiftR;

                $data .= "$driveType torque limit (on lift) summary:<br>";
                $data .= "&nbsp;maximum lift length (ft) = $torqueActiveLiftLength<br>";
                $data .= "&nbsp;maximum cable stacking is $maxFullLayersFromTorqueLiftI rows of $maxWrapsPerLayerI and 1 row of $extraWrapsAfterFullLayersTorqueLiftI<br>";
                $data .= "&nbsp;maximum length of cable (ft) = $maxLengthCableFromTorqueLift<br>";
                $data .= "&nbsp;maximum active length of cable (ft) = $maxActiveLengthOfCableFromTorqueLift <br>";
                break;
            case 'stretch':
                $maxFullLayersFromTorqueStretchI = $maxFullLayersFromTorqueStretchR;
                $extraWrapsAfterFullLayersTorqueStretchI = $extraWrapsAfterFullLayersTorqueStretchR;
                $data .= "$driveType torque limit (on stretch) summary:<br>";
                $data .= "\n\t&nbsp;maximum stretch length (ft) = " . round($torqueActiveStretchLength, 5) . "<br>";
                $data .= "\n\t&nbsp;maximum cable stacking is $maxFullLayersFromTorqueStretchI rows of $maxWrapsPerLayerI and 1 row of $extraWrapsAfterFullLayersTorqueStretchI<br>";
                $data .= "\n\t&nbsp;maximum length of cable (ft) = " . round($maxLengthCableFromTorqueStretch, 5) . "<br>";
                $data .= "\n\t&nbsp;maximum active legnth of cable (ft) = " . round($maxActiveLengthOfCableFromTorqueStretch, 5) . "<br>";
                break;
            //todo: add case 'retrieve'
            case 'retrieve':
                $data .= "$driveType torque limit (on retrieve) summary:<br>";
                //$data .= "maximum lift height (ft) = $applCalcs['maxCenterLineHeight']";
                break;
        }

        $data .= "Cable required for hook-up/safety wrap(s): $extraCableAtReel feet<br>";
        $data .= "<br>";
        $data .= "<br>";

        //attempt to load into global
        $this -> globals ->calcResultData .= $data;
        return $data;
        //    fwrite($handle, $data);
        //    fclose($handle);
    }

    // This function creates the model number based a bunch of factors. This is displayed in the writeDetailsSummary function.
    private function modelNO($srchSpoolWidth, $srchSpoolMethod, $srchStyle, $srchFrame, $swOpt, $srchSpring, $srchColl, $drumSize, $srchGear, $pretensionTurns, $spoolWidthCode, $cable, $cableORhose, $srchMotor, $hoseIDCode) {
        $modelSTR = "";
        switch ($srchStyle) {
            case 'S':
            case 'SM':
            case 'MMD':
                if ($srchStyle == 'S' && $srchFrame > 15 && $srchFrame < 25 && $swOpt) {
                    $modelSTR = 'SW' . $srchFrame . $srchSpring . '-' . $srchColl . '-' . $drumSize . '-';
                } else {
                    $modelSTR = $srchStyle . $srchFrame . $srchSpring . '-' . $srchColl . '-' . $drumSize . '-';
                }


                if ($srchGear != '') {
                    $modelSTR .= $srchGear . '-';
                }

                $modelSTR .= $pretensionTurns;
                break;
            case 'K':
                $modelSTR = $srchStyle . $srchFrame . $srchSpring . '-' . $cable["hoseIDCode"] . "-" . $pretensionTurns;
                break;
            case 'U'://HOSE - U
                switch ($cableORhose) {
                    case 'HS':
                    case 'HD':
                        $uModelSuffix = "H";
                        break;
                    default:
                        $uModelSuffix = "E";
                }
                $drumStr = $drumSize;
                if (strlen($drumSize) == 1) {
                    $drumStr = "0" . $drumStr;
                }
                    $modelSTR = $srchStyle . $uModelSuffix . $srchFrame . $srchSpring . '-' . $srchColl . '-' . $drumStr . $this->uReelWidthInp . '-';//704
                    if (strlen($srchGear) > 0) {
                        $modelSTR = $modelSTR . $srchGear . '-';
                    }

                $modelSTR = $modelSTR . $pretensionTurns;
                debugbar::info("Length of drumSize: " . strlen($drumSize));
                break;
            case "SHO":

                $modelSTR = $srchStyle . $srchSpring . '-' . $srchColl . '-' . $drumSize;
                if ($srchSpoolMethod == "M") {
                    $modelSTR = $modelSTR . $spoolWidthCode . $srchFrame . '-' . $srchGear . '-' . $pretensionTurns;
                } else {
                    $modelSTR = $modelSTR . $srchSpoolWidth . $srchFrame . '-' . $srchGear . '-' . $pretensionTurns;
                }

                break;
            case "TMR":
                $modelSTR = $srchStyle . $srchColl . '-' . $drumSize;
                if ($srchSpoolMethod == "M") {
                    $modelSTR = $modelSTR . $spoolWidthCode . $srchFrame . '-' . $srchGear . '-' . $srchMotor;
                } else {
                    $modelSTR = $modelSTR . $srchSpoolWidth . $srchFrame . '-' . $srchGear . '-' . $srchMotor;
                }
                break;
            case "C":
                $modelSTR = $srchStyle . $srchFrame . '-' . $srchColl . '-' . $srchSpring . "11" . "0" . $pretensionTurns;
                break;
            case "HM":
                $modelSTR = $srchStyle . $srchFrame . $srchSpring . '-' . $hoseIDCode . "-P" . $pretensionTurns;
                break;
            case "P":
                $modelSTR = $srchStyle . $srchFrame . '-' . $srchColl . '-' . $drumSize . '-' . $srchMotor;
                break;

        }

        return $modelSTR;
    }
//todo: complete writeRetrieveSummary and compare with test cases(Andy status- this function was near empty when I got the project
    private function writeRetrieveSummary($srchStyle, $availSpringTurns, $specificInput, $modelIndex, $compartmentActiveCableLength, $travelInFt, $applCalcs, $initialCalcs, $application, $bearingLoad, $shaftStress) {
        //todo: variables needed for writeRetrieveSummary(see following comments)
        /*
         * #$availSpringTurns
         * #$maxCenterLineHeight or maybe $maxCenterlineHeight
         * #$compartmentActiveCableLength
         * #$srchStyle
         * $turnsActiveCableLength
         * #$maximumRetrieveCapacityOfReel
         * #$travelInFt\
         * #$centerLineInFt
         * #$shaftStress
         * #$bearingLoad
         * #$rnme ????????????
         * $rete ????????????
         * $retf ????????????
         * $rnmf ????????????
         * $tQOutE
         * $tQOutF
         */
        //lets initialize rnme to 0 to prevent undefined errors
        $rnme = 0;

        $maxCenterLineHeight = $applCalcs['maxCenterLineHeight'];
        $maximumRetrieveCapacityOfReel = $applCalcs['maxCapacity'];

        $centerLineInFt = $applCalcs['centerLineInFt'];
        /*todo: consider including metric system
         * Relevant VB6 code on APPLIC.FRM Line 1453
         * If metricDEFAULT Then
         *     centerlineINft = centerlineHEIGHT / 0.3048006
         * Else
         *     centerlineINft = centerlineHEIGHT
         * End If
         *
         * Comments: Ok... what the heck... So at some point we need to worry about whether or not users are using the metric system or not.
         * That random number(0.3048006) is the conversion of meters into feet
         */



        //why all this white space?
        //        ...check for any missing functions in reelmod.bas at this position
        





        //See Line 7586
        $data = "***** Retrieve Analysis Summary *****<br>";

        $data .= "Turns limit = $availSpringTurns<br>";
        $data .= "Maximum lift height = $maxCenterLineHeight<br>";
        $data .= "Compartment capacity = $compartmentActiveCableLength<br>";

        //todo:convert this to php
        /*If srchSTYLE <> "TMR" And srchSTYLE <> "P" Then
            Print #1, "Spring turns capacity = "; turnsACTIVEcableLENGTH
        End If*/

        switch ($srchStyle) {
            Case "SHO":
            Case "TMR":
                $rnme = $applCalcs['rnme'];
                If ($maximumRetrieveCapacityOfReel < $travelInFt || $maxCenterLineHeight < $centerLineInFt || $shaftStress > 8000 || $bearingLoad > 2300 || $rnme > 450){
                    $data .= "The maximum retrieve capacity of this reel = ***.**<br>";
                }
                else{
                    $data .= "The maximum retrieve capacity of this reel = $maximumRetrieveCapacityOfReel<br>";
                }
                $data .= "Shaft stress = $shaftStress PSI (8000 PSI max)";
                $data .= "Bearing load = $bearingLoad lbs (2300 lbs max)";
                if ($srchStyle = "TMR"){
                    $data .= "Max lift hgt (empty) = (SEE LINE 1896 OF REELS CONTROLLER AND LINE 7606 OF REELMOD.BAS)";
                }
                break; //break statement may need to be removed
            default :
                $data .= "The maximum retrieve capacity of this reel = $maximumRetrieveCapacityOfReel";
        }

        //$rnme has been initialized to 0
        if ($maximumRetrieveCapacityOfReel < $travelInFt || $maxCenterLineHeight < $centerLineInFt || $shaftStress > 8000 || $bearingLoad > 2300 || $rnme > 450){
            $data .= "* WARNING - the specified reel does not meet the application requirements *";
        }

        return $data;

    }

    private function writeStretchSummary($srchStyle, $availSpringTurns, $specificInput, $modelIndex, $unusedSpringTurnsForStretch, $netTorqueWithReelFullStretch, $compartmentActiveCableLength, $maxActiveLengthOfCableFromTorqueStretch, $maxStretchCapacityOfReel, $travelInFt, $availableSpringTurnsForStretch, $turnsActiveCableLength) {
        $data = "***** Stretch Analysis Summary *****<br>";
        if ($srchStyle != 'TMR' && $srchStyle != 'P') {
            $data .= "Turns limit = $availSpringTurns<br>";
            if ($specificInput[$modelIndex] == true) {
                $data .= "Unused turns = $unusedSpringTurnsForStretch   avail. turns = $availableSpringTurnsForStretch<br>";
                if ($unusedSpringTurnsForStretch != 0 || $availSpringTurns != 0) {

                }
            }
            $data .= "Net torque with reel full:  $netTorqueWithReelFullStretch<br>";

        }

        $data .= "Compartment capacity = $compartmentActiveCableLength<br>";

        if ($srchStyle == 'SHO') {
            $data .= "Spring turns capacity = $turnsActiveCableLength<br>";
            $data .= "Spring torque capacity = $maxActiveLengthOfCableFromTorqueStretch<br>";
        } else {
            $data .= "Motor torque capacity = $maxActiveLengthOfCableFromTorqueStretch<br>";
        }

        //todo
        if ($maxStretchCapacityOfReel < $travelInFt || $netTorqueWithReelFullStretch < 0) {
            $data .= "The maximum stretch capacity of this reel = ***.**<br>";
        } else {
            $data .= "The maximum stretch capacity of this reel = $maxStretchCapacityOfReel<br>";
        }

        if ($srchStyle == "SHO" || $srchStyle == "TMR") {
            //          $data .= "Shaft Stress = $shaftStress<br>";
            //          $data .= "Shaft Stress = $bearingLoad<br>";
        }

        //     If srchSTYLE = "SHO" Or srchSTYLE = "TMR" Then
        //     if($maxStretchCapacityOfReel < $travelInFt || $netTorqueWithReelFullStretch < 0 || $shaftStress > 8000 || $bearingLoad > 2300 || $RNME > 450) {
        //       echo "Warning - the specified reel does not meet the application requirements *<br>";
        //     }
        return $data;
    }

    private function calcModelWeight($srchStyle, $srchSpring, $srchFrame, $gearRatio, $cable, $cableOrHose, $srchMotor) {
        $kDimensA = 0;
        $modelWeight = 0;
        $testStr = "";

        switch ($srchStyle) {
            case 'S':
            case 'MMD':
                if ($srchStyle == 'S') {
                    $modelWeight = 85;
                } else {
                    $modelWeight = 115;
                }

                switch ($srchSpring) {
                    case '351':
                        $modelWeight += 0;
                        break;
                    case '601':
                        $modelWeight += 5;
                        break;
                    case '621':
                        $modelWeight += 25;
                        break;
                    case '622':
                        $modelWeight += 75;
                        break;
                    case '623':
                        $modelWeight += 125;
                        break;
                    case '624':
                        $modelWeight += 175;
                        break;
                    case '751':
                        $modelWeight += 10;
                        break;
                    case '752':
                        $modelWeight += 60;
                        break;
                    case '753':
                        $modelWeight += 110;
                        break;
                    case '754':
                        $modelWeight += 160;
                        break;
                    case '801':
                        $modelWeight += 40;
                        break;
                    case '802':
                        $modelWeight += 95;
                        break;
                    case '803':
                        $modelWeight += 150;
                        break;
                    case '804':
                        $modelWeight += 205;
                        break;
                    case '1001':
                        $modelWeight += 50;
                        break;
                    case '1002':
                        $modelWeight += 110;
                        break;
                    case '1003':
                        $modelWeight += 170;
                        break;
                    case '1004':
                        $modelWeight += 230;
                        break;
                }

                switch ($srchFrame) {
                    case '14':
                        $modelWeight += 0;
                        break;
                    case '16':
                        $modelWeight += 10;
                        break;
                    case '18':
                        $modelWeight += 20;
                        break;
                    case '21':
                        $modelWeight += 30;
                        break;
                    case '24':
                        $modelWeight += 40;
                        break;
                    case '28':
                        $modelWeight += 55;
                        break;
                    case '32':
                        switch ($srchSpring) {
                            case '801':
                                $modelWeight = 200;
                                break;
                            case '802':
                                $modelWeight = 260;
                                break;
                            case '803':
                                $modelWeight = 320;
                                break;
                            case '804':
                                $modelWeight = 380;
                                break;
                            case '1001':
                                $modelWeight = 210;
                                break;
                            case '1002':
                                $modelWeight = 275;
                                break;
                            case '1003':
                                $modelWeight = 340;
                                break;
                            case '1004':
                                $modelWeight = 410;
                                break;
                        }
                        break;
                }

                // take into account geared reel weight
                if ($srchStyle == 'S' && $gearRatio != 1) {
                    $modelWeight += 25;
                }

                if ($srchStyle == 'MMD' && $gearRatio != 1) {
                    switch ($srchFrame) {
                        case '21':
                            $modelWeight += 25;
                            break;
                        case '24':
                            $modelWeight += 25;
                            break;
                        case '28':
                            $modelWeight += 30;
                            break;
                        case '32':
                            $modelWeight += 30;
                            break;
                    }
                }
                break;

            case 'SM':
                $modelWeight = 395;
                switch ($srchSpring) {
                    case "1001":
                        $modelWeight = $modelWeight + 0;
                        break;
                    case "1002":
                        $modelWeight = $modelWeight + 65;
                        break;
                    case "1003":
                        $modelWeight = $modelWeight + 130;
                        break;
                    case "1004":
                        $modelWeight = $modelWeight + 195;
                        break;
                }

                switch ($srchFrame) {
                    case "21":
                        $modelWeight = $modelWeight + 0;
                        break;
                    case "24":
                        $modelWeight = $modelWeight + 10;
                        break;
                    case "28":
                        $modelWeight = $modelWeight + 85;
                        break;
                    case "32":
                        switch ($srchSpring) {
                            case "1001":
                                $modelWeight = 550;
                                break;
                            case "1002":
                                $modelWeight = 600;
                                break;
                            case "1003":
                                $modelWeight = 650;
                                break;
                            case "1004":
                                $modelWeight = 700;
                                break;
                            case "1005":
                                $modelWeight = 800;
                                break;
                            case "1006":
                                $modelWeight = 850;
                                break;
                            case "1007":
                                $modelWeight = 930;
                                break;
                            case "1008":
                                $modelWeight = 980;
                                break;
                        }
                }
                break;
            case "U":
                $modelWeight = 0;
                if($gearRatio != 1){
                    switch ($cableOrHose){
                        case "HD":
                        case "HS":
                            switch($srchFrame){
                                case "24":
                                    $modelWeight += 155;
                                    break;
                                case "28":
                                    $modelWeight += 170;
                                    break;
                                case "32":
                                    $modelWeight += 195;
                                    break;
                            }
                            break;
                        default:
                            switch($srchFrame){
                                case "24":
                                    $modelWeight += 160;
                                    break;
                                case "28":
                                    $modelWeight += 175;
                                    break;
                                case "32":
                                    $modelWeight += 200;
                                    break;
                            }
                    }
                }else{
                    switch ($cableOrHose){
                        case "HD":
                        case "HS":
                            switch($srchFrame){
                                case "18":
                                    $modelWeight += 84;
                                    break;
                                case "21":
                                    $modelWeight += 91;
                                    break;
                                case "24":
                                    $modelWeight += 100;
                                    break;
                                case "28":
                                    $modelWeight += 115;
                                    break;
                                case "32":
                                    $modelWeight += 140;
                                    break;
                            }
                            break;
                        default:
                            switch($srchFrame){
                                case "18":
                                    $modelWeight += 91;
                                    break;
                                case "21":
                                    $modelWeight += 95;
                                    break;
                                case "24":
                                    $modelWeight += 105;
                                    break;
                                case "28":
                                    $modelWeight += 120;
                                    break;
                                case "32":
                                    $modelWeight += 145;
                                    break;
                            }
                    }
                }
                switch($srchSpring){
                    case "351":
                        $modelWeight += 20;
                        break;
                    case "621":
                        $modelWeight += 40;
                        break;
                    case "622":
                        $modelWeight += 80;
                        break;
                    case "751":
                        $modelWeight += 33;
                        break;
                    case "752":
                        $modelWeight += 66;
                        break;
                    case "801":
                        $modelWeight += 44;
                        break;
                    case "802":
                        $modelWeight += 88;
                        break;
                    case "1001":
                        $modelWeight += 64;
                        break;
                    case "1002":
                        $modelWeight += 129;
                        break;
                }
                break;

            case "HM":
                switch($srchFrame){
                    case "14":
                        switch($srchSpring){
                            case "1":
                                $modelWeight = 30;
                                break;
                            case "2":
                                $modelWeight = 32;
                                break;
                            case "3":
                                $modelWeight = 42;
                                break;
                            case "U":
                                $modelWeight = 42;
                                break;
                        }
                        break;
                    case "16":
                        switch ($srchSpring){
                            case "4":
                                $modelWeight = 63;
                                break;
                            case "5":
                                $modelWeight = 51;
                                break;
                            case "7":
                                $modelWeight = 53;
                                break;
                            case "8":
                                $modelWeight = 56;
                                break;
                            case "10":
                                $modelWeight = 62;
                                break;
                            case "11":
                                $modelWeight = 62;
                                break;
                            case "V":
                                $modelWeight = 62;
                                break;
                        }
                       break;
                    case "19":
                        switch ($srchSpring) {
                            case "4":
                                $modelWeight = 75;
                                break;
                            case "5":
                                $modelWeight = 58;
                                break;
                            case "7":
                                $modelWeight = 60;
                                break;
                            case "8":
                                $modelWeight = 65;
                                break;
                            case "10":
                                $modelWeight = 74;
                                break;
                            case "11":
                                $modelWeight = 74;
                                break;
                            case "V":
                                $modelWeight = 74;
                                break;
                        }
                        break;
                }
                break;

            case "SHO":
                switch ($srchSpring) {
                    case "801":
                        $modelWeight = 485;
                        break;
                    case "802":
                        $modelWeight = 530;
                        break;
                    case "803":
                        $modelWeight = 580;
                        break;
                    case "804":
                        $modelWeight = 625;
                        break;
                    case "1001":
                        $modelWeight = 595;
                        break;
                    case "1002":
                        $modelWeight = 655;
                        break;
                    case "1003":
                        $modelWeight = 715;
                        break;
                    case "1004":
                        $modelWeight = 775;
                        break;
                    case "1005":
                        $modelWeight = 1035;
                        break;
                    case "1006":
                        $modelWeight = 1095;
                        break;
                    case "1007":
                        $modelWeight = 1155;
                        break;
                    case "1008":
                        $modelWeight = 1215;
                        break;
                }
                break;
            case "TMR":
                switch($srchMotor){
                    case "2":
                        $modelWeight = 585;
                        break;
                    case "3":
                        $modelWeight = 600;
                        break;
                    case "5":
                        $modelWeight = 615;
                        break;
                    case "7":
                        $modelWeight = 630;
                        break;
                    case "9":
                        $modelWeight = 645;
                        break;
                    case "14":
                        $modelWeight = 660;
                        break;
                }
                break;
            case "C":
                switch ($srchFrame) {
                    case "14":
                        switch ($srchSpring) {
                            case "A":
                                $modelWeight = 40;
                                break;
                            case "B":
                                $modelWeight = 42;
                                break;
                            case "C":
                                $modelWeight = 47;
                                break;
                            case "U":
                                $modelWeight = 47;
                                break;
                        }
                        break;
                    case "16":
                        switch ($srchSpring) {
                            case "D":
                                $modelWeight = 78;
                                break;
                            case "E":
                                $modelWeight = 59;
                                break;
                            case "G":
                                $modelWeight = 65;
                                break;
                            case "H":
                                $modelWeight = 68;
                                break;
                            case "J":
                                $modelWeight = 75;
                                break;
                            case "K":
                                $modelWeight = 75;
                                break;
                            case "V":
                                $modelWeight = 75;
                                break;
                        }
                        break;
                    case "19":
                        switch ($srchSpring) {
                            case "D":
                                $modelWeight = 89;
                                break;
                            case "E":
                                $modelWeight = 70;
                                break;
                            case "G":
                                $modelWeight = 73;
                                break;
                            case "H":
                                $modelWeight = 78;
                                break;
                            case "J":
                                $modelWeight = 86;
                                break;
                            case "K":
                                $modelWeight = 76;
                                break;
                            case "V":
                                $modelWeight = 86;
                                break;
                        }
                        break;

                }
                break;
            case "P":
                $modelWeight = 129;
                switch($srchMotor){
                    case "25":
                        $modelWeight += 0;
                        break;
                    case "50":
                        $modelWeight += 16;
                        break;
                    case "75":
                        $modelWeight += 50;
                        break;
                    case "150":
                        $modelWeight += 62;
                        break;
                }

                switch ($srchFrame){
                    case "14":
                        $modelWeight += 0;
                        break;
                    case "16":
                        $modelWeight += 5;
                        break;
                    case "18":
                        $modelWeight += 15;
                        break;
                    case "21":
                        $modelWeight += 25;
                        break;
                    case "24":
                        $modelWeight += 50;
                        break;
                    case "28":
                        $modelWeight += 65;
                        break;
                    case "32":
                        $modelWeight += 90;
                        break;
                }
                break;
            case "K":
                $testStr = $srchFrame . $srchSpring . $cable["hoseIDCode"];

                switch ($testStr) {
                    Case "183514":
                        $modelWeight = 115;
                        $kDimensA = 12.12;
                        break;
                    Case "187514":
                        $modelWeight = 120;
                        $kDimensA = 12.62;
                        break;
                    Case "217514":
                        $modelWeight = 130;
                        $kDimensA = 12.62;
                        break;
                        break;
                    Case "247514":
                        $modelWeight = 140;
                        $kDimensA = 12.62;
                        break;
                    Case "287514":
                        $modelWeight = 150;
                        $kDimensA = 12.62;
                        break;
                    Case "2810014":
                        $modelWeight = 160;
                        $kDimensA = 13.62;
                        break;
                    Case "328024":
                        $modelWeight = 235;
                        $kDimensA = 15;
                        break;
                    Case "3210014":
                        $modelWeight = 180;
                        $kDimensA = 13.62;
                        break;
                    Case "187516":
                        $modelWeight = 120;
                        $kDimensA = 13.12;
                        break;
                    Case "213516":
                        $modelWeight = 115;
                        $kDimensA = 12.62;
                        break;
                    Case "217516":
                        $modelWeight = 130;
                        $kDimensA = 13.12;
                        break;
                    Case "247516":
                        $modelWeight = 140;
                        $kDimensA = 13.12;
                        break;
                    Case "287516":
                        $modelWeight = 155;
                        $kDimensA = 13.12;
                        break;
                    Case "2810016":
                        $modelWeight = 165;
                        $kDimensA = 14.12;
                        break;
                    Case "327526":
                        $modelWeight = 225;
                        $kDimensA = 15.5;
                        break;
                    Case "327536":
                        $modelWeight = 280;
                        $kDimensA = 17.88;
                        break;
                    Case "3210016":
                        $modelWeight = 180;
                        $kDimensA = 14.12;
                        break;
                    Case "187518":
                        $modelWeight = 120;
                        $kDimensA = 13.5;
                        break;
                    Case "217518":
                        $modelWeight = 130;
                        $kDimensA = 13.5;
                        break;
                    Case "247518":
                        $modelWeight = 140;
                        $kDimensA = 13.5;
                        break;
                    Case "2410018":
                        $modelWeight = 150;
                        $kDimensA = 14.5;
                        break;
                    Case "287518":
                        $modelWeight = 155;
                        $kDimensA = 13.5;
                        break;
                    Case "2810018":
                        $modelWeight = 165;
                        $kDimensA = 14.5;
                        break;
                    Case "327528":
                        $modelWeight = 225;
                        $kDimensA = 15.88;
                        break;
                    Case "327538":
                        $modelWeight = 280;
                        $kDimensA = 18.25;
                        break;
                    Case "3210018":
                        $modelWeight = 180;
                        $kDimensA = 14.5;
                        break;
                    Case "24100112":
                        $modelWeight = 160;
                        $kDimensA = 16.77;
                        break;
                    Case "2875312":
                        $modelWeight = 275;
                        $kDimensA = 20.56;
                        break;
                    Case "28100112":
                        $modelWeight = 175;
                        $kDimensA = 16.77;
                        break;
                    Case "3275312":
                        $modelWeight = 290;
                        $kDimensA = 20.56;
                        break;
                    Case "3275412":
                        $modelWeight = 350;
                        $kDimensA = 22.88;
                        break;
                    default:
                        $modelWeight = 0;
                        $kDimensA = 0;
                        break;

                }

        }

        return $modelWeight = array("modelWeight" => $modelWeight, "kDimensA" => $kDimensA);
    }

    private function calcModelDimensions($srchStyle, $srchFrame, $swOpt, $gearRatio, $srchSpring, $wrapperWidthR, $srchSpoolMethod, $srchSpoolWidth, $srchColl, $modelWeightCalcs, $reelWithInp, $cableOrHose, $srchMotor, $hoseIDCode) {

        $dimensDepth = 0;
        $dimensWidth = 0;
        $dimensHeight = 0;

        $dimensA = 0;
        $dimensB = 0;
        $dimensC = 0;
        $dimensD = 0;
        $dimensE = 0;
        $dimensZ = 0;


        switch ($srchStyle) {
            case 'S':
            case 'MMD':

                switch ($srchColl) {
                    case '23':
                    case '33':
                    case '43':
                        $dimensA = 15.0;
                        break;
                    case '63':
                    case '83':
                    case '27':
                    case '37':
                    case '47':
                    case '212':
                    case '220':
                    case '320':
                    case '420':
                        $dimensA = 17.5;
                        break;
                    case '67':
                    case '103':
                    case '123':
                    case '312':
                        $dimensA = 20.0;
                        break;
                    case '87':
                    case '143':
                    case '163':
                    case '412':
                        $dimensA = 22.5;
                        break;
                    case '203':
                    case '243':
                        $dimensA = 27.5;
                        break;
                    case '303':
                    case '363':
                        $dimensA = 35.5;
                        break;
                }

                if ($srchFrame == "14") {
                    $dimensA = $dimensA - 0.5;
                }

                if ($srchFrame == '28' || $srchFrame == '32') {
                    $dimensA = $dimensA + 1;
                }
                if ($srchStyle == 'S' && intval($srchFrame) > 15 && intval($srchFrame) < 25 && $swOpt) {
                    $dimensA = $dimensA + 2;
                } // two extra inches added to spool width

                switch (strval($srchSpring)) {
                    case '351':
                    case '601':
                        $dimensB = 7.1;
                        break;
                    case '621':
                    case '751':
                    case '801':
                        $dimensB = 7.62;
                        break;
                    case '622':
                    case '752':
                    case '802':
                        $dimensB = 10.25;
                        break;
                    case '623':
                    case '753':
                    case '803':
                        $dimensB = 12.88;
                        break;
                    case '624':
                    case '754':
                    case '804':
                        $dimensB = 15.5;
                        break;
                    case '1001':
                        $dimensB = 8.5;
                        break;
                    case '1002':
                        $dimensB = 11.88;
                        break;
                    case '1003':
                        $dimensB = 15.25;
                        break;
                    case '1004':
                        $dimensB = 18.62;
                        break;
                }

                if ($srchFrame == '14') {
                    $dimensB = $dimensB - 0.5;
                }
                if ($srchFrame == '28') {
                    ++$dimensB;
                }

                if ($gearRatio != '1') {
                    if ($srchFrame != '32') {
                        $dimensB += 5;
                    } else {
                        switch ($srchSpring) { //special s32 frame dimensions added 6/97
                            case '801':
                                $dimensB = 14.38;
                                break;
                            case '802':
                                $dimensB = 17.88;
                                break;
                            case '803':
                                $dimensB = 21.38;
                                break;
                            case '804':
                                $dimensB = 24.88;
                                break;
                            case '1001':
                                $dimensB = 15.25;
                                break;
                            case '1002':
                                $dimensB = 18.75;
                                break;
                            case '1003':
                                $dimensB = 22.25;
                                break;
                            case '1004':
                                $dimensB = 25.75;
                                break;
                        }
                    }
                }
                $dimensWidth = $dimensA + $dimensB;

                switch ($srchStyle) { // determine height and width
                    case 'S':
                        switch ($srchFrame) {
                            case '14':
                                $dimensHeight = 16.5;
                                $dimensDepth = 13.5;
                                break;
                            case '16':
                                $dimensHeight = 18.5;
                                $dimensDepth = 16;
                                break;
                            case '18':
                                $dimensHeight = 20;
                                $dimensDepth = 18;
                                break;
                            case '21':
                                $dimensHeight = 23;
                                $dimensDepth = 21;
                                break;
                            case '24':
                                $dimensHeight = 26;
                                $dimensDepth = 24;
                                break;
                            case '28':
                                $dimensHeight = 30;
                                $dimensDepth = 28;
                                break;
                            case '32':
                                $dimensHeight = 34;
                                $dimensDepth = 32;
                                break;
                        }
                        break;
                    case "MMD":
                        switch ($srchFrame) {
                            case '21':
                                $dimensHeight = 24.34;
                                $dimensDepth = 23.68;
                                break;
                            case '24':
                                $dimensHeight = 27.34;
                                $dimensDepth = 26.68;
                                break;
                            case '28':
                                $dimensHeight = 31.34;
                                $dimensDepth = 30.68;
                                break;
                            case '32':
                                $dimensHeight = 35.34;
                                $dimensDepth = 34.68;
                                break;
                        }
                        break;

                }
                break;
            case "SM":
                switch ($srchColl) {
                    case "23":
                    case "33":
                    case "43":
                    case "63":
                    case "83":
                    case "27":
                    case "37":
                    case "47":
                    case "212":
                        $dimensA = 20.75;
                        break;
                    case "67":
                    case "87":
                    case "103":
                    case "123":
                    case "312":
                    case "412":
                        $dimensA = 23.75;
                        break;
                    case "143":
                    case "163":
                    case "220":
                        $dimensA = 25.75;
                        break; //cai added nov 2016
                    case "320":
                    case "420":
                        $dimensA = 30.25;
                }
                if ($srchFrame > 24) {
                    $dimensA += 1;
                }
                switch ($srchSpring) {
                    case "1001":
                        $dimensB = 14.88;
                        break;
                    case "1002":
                        $dimensB = 18.25;
                        break;
                    case "1003":
                        $dimensB = 21.62;
                        break;
                    case "1004":
                        $dimensB = 25;
                        break;
                    case "1005":
                        $dimensB = 22.62;
                        break;
                    case "1006":
                        $dimensB = 22.62;
                        break;
                    case "1007":
                        $dimensB = 26.0;
                        break;
                    case "1008":
                        $dimensB = 26.0;
                        break;
                }
                if ($srchFrame > 24 && $srchSpring <= 1004) {
                    $dimensB += 1;
                }
                switch ($srchFrame) {
                    case "21":
                        $dimensHeight = 27.88;
                        $dimensDepth = 25.0;
                        break;
                    case "24":
                        $dimensHeight = 29.38;
                        $dimensDepth = 28.0;
                        break;
                    case "28":
                        $dimensHeight = 32;
                        $dimensDepth = 32;
                        break;
                    case "32":
                        $dimensHeight = 36;
                        $dimensDepth = 36;
                        break;

                }
                $dimensWidth = $dimensA + $dimensB;
                break;
            case "U":
                switch (intval($reelWithInp)){
                    case 4:
                        $dimensA = 8.5;
                        break;
                    case 6:
                        $dimensA = 10.5;
                        break;
                    case 8:
                        $dimensA = 12.5;
                        break;
                    case 10:
                        $dimensA = 14.5;
                        break;
                    case 12:
                        $dimensA = 16.5;
                        break;
                    case 14:
                        $dimensA = 18.5;
                        break;
                }
                switch ($srchSpring){
                    case "351":
                        $dimensE = 2.5;
                        break;
                    case "621":
                        $dimensE = 3;
                        break;
                    case "622":
                        $dimensE = 5.63;
                        break;
                    case "751":
                        $dimensE = 3;
                        break;
                    case "752":
                        $dimensE = 5.63;
                        break;
                    case "801":
                        $dimensE = 3;
                        break;
                    case "802":
                        $dimensE = 5.63;
                        break;
                    case "1001":
                        $dimensE = 4;
                        break;
                    case "1002":
                        $dimensE = 7.62;
                        break;
                }
                switch ($cableOrHose){
                    case "HD":
                    case "HS":
                        switch($hoseIDCode) {
                            case "4":
                                $dimensC = 3;
                                break;
                            case "6":
                                $dimensC = 3.0;
                                break;
                            case "8":
                                $dimensC = 3.12;
                                break;
                            case "12":
                                $dimensC = 3.25;
                                break;
                            case "16":
                                $dimensC = 4.12;
                                break;
                            case "20":
                                $dimensC = 4.36;
                                break;
                            case "24":
                                $dimensC = 6.5;
                                break;
                        }
                        break;
                    default:
                        switch($srchColl){
                           case "363":
                               $dimensC = 31.5;
                               break;
                           case "303":
                               $dimensC = 31.5;
                               break;
                           case "243":
                               $dimensC = 23.5;
                               break;
                           case "203":
                               $dimensC = 23.5;
                               break;
                           case "163":
                               $dimensC = 18.5;
                               break;
                           case "143":
                               $dimensC = 18.5;
                               break;
                           case "123":
                               $dimensC = 16;
                               break;
                           case "103":
                               $dimensC = 16;
                               break;
                           case "83":
                               $dimensC = 13.5;
                               break;
                           case "63":
                               $dimensC = 13.5;
                               break;
                           case "43":
                               $dimensC = 11;
                               break;
                           case "33":
                               $dimensC = 11;
                               break;
                           case "23":
                               $dimensC = 11;
                               break;
                           case "87":
                               $dimensC = 18.5;
                               break;
                           case "67":
                               $dimensC = 16;
                               break;
                           case "47":
                               $dimensC = 13.5;
                               break;
                           case "37":
                               $dimensC = 13.5;
                               break;
                           case "27":
                               $dimensC = 13.5;
                               break;
                           case "412":
                               $dimensC = 18.5;
                               break;
                           case "312":
                               $dimensC = 16.0;
                               break;
                           case "212":
                               $dimensC = 13.5;
                               break;
                           case "420":
                               $dimensC = 13.5;
                               break;
                           case "320":
                               $dimensC = 13.5;
                               break;
                           case "220":
                               $dimensC = 13.5;
                               break;
                           case "440":
                               $dimensC = 0;
                               break;
                           case "340":
                               $dimensC = 0;
                               break;
                           case "240":
                               $dimensC = 0;
                               break;
                           case "47-13":
                               $dimensC = 13.5;
                               break;
                           case "37-13":
                               $dimensC = 13.5;
                               break;
                           case "412-13":
                               $dimensC = 18.5;
                               break;
                           case "312-13":
                               $dimensC = 16;
                               break;
                           case "420-13":
                               $dimensC = 13.5;
                               break;
                           case "320-13":
                               $dimensC = 13.5;
                               break;
                           case "440-13":
                               $dimensC = 0;
                               break;
                           case "340-13":
                               $dimensC = 0;
                               break;
                        }
                     break;
                }
                switch($srchFrame){
                    case "18":
                        $dimensHeight = 24.25;
                        $dimensDepth = 19.0;
                        break;
                    case "21":
                        $dimensHeight = 25.75;
                        $dimensDepth = 21.0;
                        break;
                    case "24":
                        $dimensHeight = 28.0;
                        $dimensDepth = 24.0;
                        break;
                    case "28":
                        $dimensHeight = 32.0;
                        $dimensDepth = 28.0;
                        break;
                    case "32":
                        $dimensHeight = 36.0;
                        $dimensDepth = 32.0;
                        break;
                }
                $dimensWidth = $dimensA + $dimensC + $dimensE;
                break;
            case "SHO":
            case "TMR":
                switch ($srchColl) {
                    case "23":
                    case "33":
                    case "43":
                        $dimensA = 10.69;
                        break;
                    case "63":
                    case "83":
                    case "27":
                    case "37":
                    case "47":
                    case "212":
                    case "220":
                    case "320":
                    case "420":
                        $dimensA = 13.19;
                        break;
                    case "67":
                    case "103":
                    case "123":
                    case "312":
                        $dimensA = 15.69;
                        break;
                    case "87":
                    case "143":
                    case "163":
                    case "412":
                        $dimensA = 18.19;
                        break;
                    case "203":
                    case "243":
                        $dimensA = 23.19;
                        break;
                    case "303":
                    case "363":
                        $dimensA = 30.19;
                        break;
                }
                switch ($srchStyle) {
                    case "SHO":
                        switch ($srchSpring) {
                            case "801":
                                $dimensB = 1.19;
                                break;
                            case "802":
                                $dimensB = 3.56;
                                break;
                            case "803":
                                $dimensB = 5.94;
                                break;
                            case "804":
                                $dimensB = 8.31;
                                break;
                            case "1001":
                                $dimensB = 2.19;
                                break;
                            case "1002":
                                $dimensB = 5.56;
                                break;
                            case "1003":
                                $dimensB = 8.94;
                                break;
                            case "1004":
                                $dimensB = 12.31;
                                break;
                            case "1005":
                                $dimensB = 8.94;
                                break;
                            case "1006":
                                $dimensB = 8.94;
                                break;
                            case "1007":
                                $dimensB = 12.31;
                                break;
                            case "1008":
                                $dimensB = 12.31;
                                break;
                        }
                        break;
                    case "TMR":
                        switch($srchMotor){
                            case "2":
                                $dimensB = 26.69;
                                break;
                            case "3":
                                $dimensB = 39.12;
                                break;
                            case "5":
                                $dimensB = 35.25;
                                break;
                            case "7":
                                $dimensB = 37.25;
                                break;
                            case "9":
                                $dimensB = 39.88;
                                break;
                            case "14":
                                $dimensB = 42.50;
                                break;
                        }
                        break;
                }

                if ($dimensA > $dimensB) {
                    $dimensZ = $dimensA;
                } else {
                    $dimensZ = $dimensB;
                }

                switch ($srchSpoolMethod) {
                    case "M":
                        $dimensWidth = $wrapperWidthR + 1.0 + 2.38 + 12 + $dimensZ;
                        break;
                    case "R":
                        $dimensWidth = $srchSpoolWidth + 0.96 + 2.38 + 12 + $dimensZ;
                }

                $dimensHeight = $srchFrame;

                if ($srchStyle == "TMR" || $srchSpring < 1005) {
                    $dimensDepth = (intval($srchFrame) / 2) + 24;
                } else {
                    $dimensDepth = 48;
                }

                if ($dimensDepth < $dimensHeight) {
                    $dimensDepth = $dimensHeight;
                }

                break;
            case "C":
                switch ($srchFrame) {
                    case "14":
                        switch (substr($srchColl, 0, 1)) {
                            case "A":
                            case "B":
                            case "C":
                            case "D":
                            case "Z":
                                switch (substr($srchColl, -2)) {
                                    case "02":
                                    case "03":
                                    case "04":
                                        $dimensWidth = 12.19;
                                        break;
                                    case "05":
                                    case "06":
                                    case "07":
                                    case "08":
                                        $dimensWidth = 13.69;
                                        break;
                                    case "09":
                                    case "10":
                                    case "11":
                                    case "12":
                                        $dimensWidth = 15.19;
                                        break;
                                    default:
                                        $dimensWidth = 0;
                                }
                                break;
                            case "E":
                            case "F":
                                switch (substr($srchColl, -2)) {
                                    case "02":
                                    case "03":
                                    case "04":
                                        $dimensWidth = 13.69;
                                        break;
                                    default:
                                        $dimensWidth = 0;
                                        break;
                                }
                                break;

                        }
                        break;
                    case "16":
                        switch (substr($srchColl, 0, 1)) {
                            case "A":
                            case "B":
                            case "C":
                            case "D":
                            case "Z":
                                switch (substr($srchColl, -2)) {
                                    case "02":
                                    case "03":
                                    case "04":
                                        $dimensWidth = 14.19;
                                        break;
                                    case "05":
                                    case "06":
                                    case "07":
                                    case "08":
                                        $dimensWidth = 15.69;
                                        break;
                                    case "09":
                                    case "10":
                                    case "11":
                                    case "12":
                                        $dimensWidth = 17.19;
                                        break;
                                    default:
                                        $dimensWidth = 0;
                                }
                                break;
                            case "E":
                            case "F":
                                switch (substr($srchColl, -2)) {
                                    case "02":
                                    case "03":
                                    case "04":
                                        $dimensWidth = 15.69;
                                        break;
                                    default:
                                        $dimensWidth = 0;
                                        break;
                                }
                                break;
                        }
                        break;
                    case "19":
                        switch (substr($srchColl, 0, 1)) {
                            case "A":
                            case "B":
                            case "C":
                            case "D":
                            case "Z":
                                switch (substr($srchColl, -2)) {
                                    case "02":
                                    case "03":
                                    case "04":
                                        $dimensWidth = 13.94;
                                        break;
                                    case "05":
                                    case "06":
                                    case "07":
                                    case "08":
                                        $dimensWidth = 15.19;
                                        break;
                                    case "09":
                                    case "10":
                                    case "11":
                                    case "12":
                                        $dimensWidth = 16.69;
                                        break;
                                    default:
                                        $dimensWidth = 0;
                                }
                                break;
                            case "E":
                            case "F":
                                switch (substr($srchColl, -2)) {
                                    case "02":
                                    case "03":
                                    case "04":
                                        $dimensWidth = 15.19;
                                        break;
                                    default:
                                        $dimensWidth = 0;
                                        break;
                            }
                            break;
                        }
                        break;
                    }
                switch ($srchFrame) {
                    case "14":
                        $dimensHeight = 16.25;
                        $dimensDepth = 15.125;
                        break;
                    case "16":
                        $dimensHeight = 18.25;
                        $dimensDepth = 17.2;
                        break;
                    case "19":
                        $dimensHeight = 20.5;
                        $dimensDepth = 19.5;
                        break;
                }
                break;
            case "HM": //'estimated per SS
                switch($srchFrame){
                    case "14":
                        $dimensWidth = 7;
                        $dimensHeight = 16.25;
                        $dimensDepth = 15.125;
                        break;
                    case "16":
                        $dimensWidth = 9;
                        $dimensHeight = 18.25;
                        $dimensDepth = 17.2;
                        break;
                    case "19":
                        $dimensWidth = 9.5;
                        $dimensHeight = 20.5;
                        $dimensDepth = 19.5;
                        break;
                }
                break;

            case "K":
                $dimensWidth = $modelWeightCalcs["kDimensA"];
                switch ($srchFrame) {
                    case "18":
                        $dimensHeight = 19.75;
                        $dimensDepth = 18.0;
                        break;
                    case "21":
                        $dimensHeight = 23.0;
                        $dimensDepth = 21.0;
                        break;
                    case "24":
                        $dimensHeight = 26.0;
                        $dimensDepth = 24.0;
                        break;
                    case "28":
                        $dimensHeight = 30.0;
                        $dimensDepth = 28.0;
                        break;
                    case "32":
                        $dimensHeight = 34.0;
                        $dimensDepth = 32.0;
                        break;
                }
                break;
            case "P":
                switch($srchColl){
                    case "23":
                    case "33":
                    case "43":
                        $dimensA = 15.0;
                        break;
                    case "63":
                    case "83":
                        $dimensA = 17.5;
                        break;
                    case "67":
                    case "103":
                    case "123":
                    case "312":
                        $dimensA = 20.0;
                        break;
                    case "87":
                    case "143":
                    case "163":
                    case "412":
                        $dimensA = 22.5;
                        break;
                    case "203":
                    case "243":
                        $dimensA = 27.5;
                        break;
                    case "303":
                    case "363":
                        $dimensA = 35.5;
                }//End of switch for switch($srchColl)

                if($srchFrame == "14"){
                    $dimensA = $dimensA - 0.5;
                }

                if($srchFrame == "28" || $srchFrame == "32"){
                    $dimensA = $dimensA + 1.0;
                }

                switch($srchMotor){
                    case "25":
                       $dimensC = 9.25;
                       $dimensD = 17.5;
                        break;
                    case "50":
                        $dimensC = 9.38;
                        $dimensD = 17.0;
                        break;
                    case "75":
                       $dimensC = 9.81;
                       $dimensD = 20.0;
                       break;
                    case "150": //Case "150":  dimensC = 9.75: dimensD = 24!
                        $dimensC = 9.75;
                        $dimensD = 24.0;
                        break;
                }//End of switch($srchMotor)

                switch ($srchFrame){
                    case "14":
                        $dimensHeight = 16.5;
                        $dimensDepth = (14 / 2) + $dimensD;
                        $dimensB = 4.12;
                        break;
                    case "16":
                        $dimensHeight = 18.5;
                        $dimensDepth = (16 / 2) + $dimensD;
                        $dimensB = 4.62;
                        break;
                    case "18":
                        $dimensHeight = 20.0;
                        $dimensDepth = (18 / 2) + $dimensD;
                        $dimensB = 4.62;
                        break;
                    case "21":
                       $dimensHeight = 23.0;
                       $dimensDepth = (21 / 2) + $dimensD;
                       $dimensB = 4.62;
                       break;
                    case "24":
                        $dimensHeight = 26.0;
                        $dimensDepth = (24 / 2) + $dimensD;
                        $dimensB = 4.62;
                        break;
                    case "28":
                        $dimensHeight = 30.0;
                        $dimensDepth = (28 / 2) + $dimensD;
                        $dimensB = 5.62;
                        break;
                    case "32":
                        $dimensHeight = 34.0;
                        $dimensDepth = (32 / 2) + $dimensD;
                        $dimensB = 5.62;
                        break;
                }
                $dimensWidth = $dimensA + $dimensB + $dimensC;
                break;
        }//End of switch($srchStyle)


        $dimensions = array(
            'dimensA' => $dimensA,
            'dimensB' => $dimensB,
            'dimensWidth' => $dimensWidth,
            'dimensHeight' => $dimensHeight,
            'dimensDepth' => $dimensDepth
        );

        return $dimensions;
    }

    private function calcShaftStress($SID, $SOD, $adjustedTorque, $RMOM) {
        $FAC = 1 / (1 - pow(($SID / $SOD), 4));

        $STTOR = (5.1 * $adjustedTorque * 12 / pow($SOD, 3)) * $FAC;
        $STBND = (10 * $RMOM * $SOD) / (pow($SOD, 4) - pow($SID, 4));
        $shaftSTRESS = sqrt(pow($STBND, 2) + 3 * pow($STTOR, 2));


        return $shaftSTRESS;
    }

    private function calcReelPrice($cableOrHose, $srchStyle, $hoseIDCode, $srchCost, $srchFrame, $swOpt, $srchColl, $reelWidthHinp) {
        //Pull prices from DB into array $shoReelPrices
        $calcPricesArray = $this->getReelPrices('calcReelPrice');

        DebugBar::info($calcPricesArray);

        $reelTotalListPrice = 0;

        if ($cableOrHose == 'HS') { //either U or HM
            $swivelJointPrice = 0;

            if ($srchStyle == 'U') {
                switch ($hoseIDCode) {
                    case '4':
                        $swivelJointPrice = $calcPricesArray['swivelJtPrice_hoseIDCode_4'];
                        break;
                    case '6':
                        $swivelJointPrice = $calcPricesArray['swivelJtPrice_hoseIDCode_6'];
                        break;
                    case '8':
                        $swivelJointPrice = $calcPricesArray['swivelJtPrice_hoseIDCode_8'];
                        break;
                    case '12':
                        $swivelJointPrice = $calcPricesArray['swivelJtPrice_hoseIDCode_12'];
                        break;
                    case '16':
                        $swivelJointPrice = $calcPricesArray['swivelJtPrice_hoseIDCode_16'];
                        break;
                    case '20':
                        $swivelJointPrice = $calcPricesArray['swivelJtPrice_hoseIDCode_20'];
                        break;
                    case '24':
                        $swivelJointPrice = $calcPricesArray['swivelJtPrice_hoseIDCode_24'];
                        break;
                }
            }
            $collectorPrice = -2;
        } else {
            $collectorPrice = $this->lookupCollectorPrice($srchStyle, $srchColl); //will return -2 for C, K and HM
            $swivelJointPrice = 0;
        }
        $insideSales = true;
        if ($collectorPrice > 0) {
            $reelTotalListPrice = $srchCost + $collectorPrice;
        } else {
            if ($collectorPrice == -2) {
                $reelTotalListPrice = $srchCost + $swivelJointPrice;
            } else {
                if ($collectorPrice == 0 || $collectorPrice == -1) {
                    if ($insideSales) {

                    } else {
                        $reelTotalListPrice = 0;
                        $reelPriceCalcs = array(
                            'reelTotalListPrice' => $reelTotalListPrice,
                            'collectorPrice' => $collectorPrice
                        );
                        return $reelPriceCalcs; // exit sub, will need to return values here

                    }
                }
            }
        }

        if ($srchStyle == 'S' && $srchFrame > 15 && $srchFrame < 25 && $swOpt) {
            $reelTotalListPrice += $calcPricesArray['reelTotalListPrice_SWOption'];
        }

        if($srchStyle == "U"){
            switch(intval($reelWidthHinp)){ //2018 Price
                case 6:
                    $reelTotalListPrice = $reelTotalListPrice + $calcPricesArray['reelTotalListPrice_ReelWidth_6'];
                    break;
                case 8:
                    $reelTotalListPrice = $reelTotalListPrice + $calcPricesArray['reelTotalListPrice_ReelWidth_8'];
                    break;
                case 10:
                    $reelTotalListPrice = $reelTotalListPrice + $calcPricesArray['reelTotalListPrice_ReelWidth_10'];
                    break;
                case 12:
                    $reelTotalListPrice = $reelTotalListPrice + $calcPricesArray['reelTotalListPrice_ReelWidth_12'];
                    break;
                case 14:
                    $reelTotalListPrice = $reelTotalListPrice + $calcPricesArray['reelTotalListPrice_ReelWidth_14'];
                    break;
                default:
                    $reelTotalListPrice = 0;
            }
        }
        $reelPriceCalcs = array(
            'reelTotalListPrice' => $reelTotalListPrice,
            'collectorPrice' => $collectorPrice
        );

        return $reelPriceCalcs;
    }

    private function lookupCollectorPrice($srchStyle, $srchColl) {
        $collectorPrice = 0;
        $rows = DB::table('collector')->where('Collector', $srchColl)->get();
        if (count($rows) != 0) { // if rows were returned
            $row = $rows[0]; // could cause problems

            switch ($srchStyle) {
                case 'S':
                    $collectorPrice = $row->Sprc;
                    break;
                case 'SM':
                    $collectorPrice = $row->Smprc;
                    break;
                case 'MMD':
                    $collectorPrice = $row->MMDprc;
                    break;
                case 'SHO':
                    $collectorPrice = $row->SHOprc;
                    break;
                case 'TMR':
                    $collectorPrice = $row->TMRprc;
                    break;
                case 'P':
                    $collectorPrice = $row->Penprc;
                    break;
                case 'U':
                    $collectorPrice = $row->Uprc;
                    break;
                case 'C':
                case 'HM':
                case 'K':
                    $collectorPrice = -2;
                    break;
            }
        } else {
            switch ($srchStyle) {
                case 'C':
                case 'HM':
                case 'K':
                    $collectorPrice = -2;
                    break;
                default:
                    $collectorPrice = -1;
            }
        }
        $reelPriceMultiplier = 1;
        if ($reelPriceMultiplier > 0 && $collectorPrice > 0) {
            $collectorPrice = $collectorPrice * $reelPriceMultiplier;
        }

        return $collectorPrice;
    }

    private function calcExtraCable($srchColl, $srchStyle, $drumSize, $deadWraps, $cableThick, $deadWrapLength) {

        $extraCableAtReel = 0;
        $cableAtReel = 0;
        $subscrpt2 = 0;
        $subscrpt1 = 0;

        switch ($srchColl) {
            case '23':
            case '33':
            case '43':
                $subscrpt2 = '1';
                break;
            case '63':
            case '83':
                $subscrpt2 = '2';
                break;
            case '103':
            case '123':
            case '143':
            case '163':
            case '312':
                $subscrpt2 = '3';
                break;
            case '203':
                $subscrpt2 = '4';
                break;
            case '243':
                $subscrpt2 = '5';
                break;
            case '303':
                $subscrpt2 = '6';
                break;
            case '363':
                $subscrpt2 = '7';
                break;
            case '27':
            case '37':
            case '47':
            case '212':
            case '412':
            case '220':
            case '320':
            case '420':
                $subscrpt2 = '8';
                break;
            default:
                $subscrpt2 = '7';
                break;
        }

        switch ($srchStyle) {
            case 'U':
            case 'S':
            case 'SM':
            case 'MMD':
            case 'P':
                $subscrpt1 = strval($drumSize - 7);
                switch ($srchColl) {
                    case '23':
                    case '33':
                    case '43':
                        $subscrpt2 = '1';
                        break;
                    case '63':
                    case '83':
                        $subscrpt2 = '2';
                        break;
                    case '103':
                    case '123':
                    case '143':
                    case '163':
                    case '312':
                        $subscrpt2 = '3';
                        break;
                    case '203':
                        $subscrpt2 = '4';
                        break;
                    case '243':
                        $subscrpt2 = '5';
                        break;
                    case '303':
                        $subscrpt2 = '6';
                        break;
                    case '363':
                        $subscrpt2 = '7';
                        break;
                    case '27':
                    case '37':
                    case '47':
                    case '212':
                    case '412':
                    case '220':
                    case '320':
                    case '420':
                        $subscrpt2 = '8';
                        break;
                    default:
                        $subscrpt2 = '7';
                }
                $subscrpt = $subscrpt2 . $subscrpt1;

                switch ($subscrpt) {
                    case '11':
                        $cableAtReel = 4;
                        break;
                    case '12':
                    case '13':
                    case '14':
                    case '21':
                    case '22':
                    case '23':
                    case '31':
                    case '32':
                    case '41':
                    case '81':
                    case '82':
                    case '83':
                        $cableAtReel = 5;
                        break;
                    case '15':
                    case '16':
                    case '17':
                    case '24':
                    case '25':
                    case '26':
                    case '33':
                    case '34':
                    case '35':
                    case '42':
                    case '43':
                    case '44':
                    case '51':
                    case '52':
                    case '53':
                    case '61':
                    case '62':
                    case '71':
                    case '84':
                    case '85':
                    case '86':
                        $cableAtReel = 6;
                        break;
                    case '18':
                    case '19':
                    case '110':
                    case '27':
                    case '28':
                    case '29':
                    case '36':
                    case '37':
                    case '38':
                    case '45':
                    case '46':
                    case '47':
                    case '54':
                    case '55':
                    case '56':
                    case '63':
                    case '64':
                    case '65':
                    case '72':
                    case '73':
                    case '74':
                    case '87':
                    case '88':
                    case '89':
                        $cableAtReel = 7;
                        break;
                    case '111':
                    case '112':
                    case '113':
                    case '210':
                    case '211':
                    case '212':
                    case '39':
                    case '310':
                    case '311':
                    case '48':
                    case '49':
                    case '410':
                    case '57':
                    case '58':
                    case '59':
                    case '66':
                    case '67':
                    case '68':
                    case '75':
                    case '76':
                    case '77':
                    case '810':
                    case '811':
                    case '812':
                        $cableAtReel = 8;
                        break;
                    case '114':
                    case '115':
                    case '116':
                    case '213':
                    case '214':
                    case '215':
                    case '312':
                    case '313':
                    case '314':
                    case '411':
                    case '412':
                    case '413':
                    case '510':
                    case '511':
                    case '512':
                    case '69':
                    case '610':
                    case '611':
                    case '78':
                    case '79':
                    case '710':
                    case '813':
                    case '814':
                    case '815':
                        $cableAtReel = 9;
                        break;
                    case '117':
                    case '118':
                    case '119':
                    case '216':
                    case '217':
                    case '218':
                    case '315':
                    case '316':
                    case '317':
                    case '414':
                    case '415':
                    case '416':
                    case '513':
                    case '514':
                    case '515':
                    case '612':
                    case '613':
                    case '614':
                    case '711':
                    case '712':
                    case '713':
                    case '816':
                    case '817':
                    case '818':
                        $cableAtReel = 10;
                        break;
                    case '120':
                    case '121':
                    case '219':
                    case '220':
                    case '221':
                    case '318':
                    case '319':
                    case '320':
                    case '417':
                    case '418':
                    case '419':
                    case '516':
                    case '517':
                    case '518':
                    case '615':
                    case '616':
                    case '617':
                    case '714':
                    case '715':
                    case '716':
                    case '819':
                    case '820':
                    case '821':
                        $cableAtReel = 11;
                        break;
                    case '321':
                    case '420':
                    case '421':
                    case '519':
                    case '520':
                    case '521':
                    case '618':
                    case '619':
                    case '620':
                    case '717':
                    case '718':
                    case '719':
                        $cableAtReel = 12;
                        break;
                    case '621':
                    case '720':
                    case '721':
                        $cableAtReel = 13;
                        break;
                }

                if ($deadWraps >= 1) {

                    $extraCableAtReel = $cableAtReel + (($deadWraps - 1) * ($drumSize + $cableThick) * pi() / 12.0);
                } else {
                    $extraCableAtReel = $cableAtReel;
                }

                if ($srchStyle == 'SM') {
                    switch ($srchColl) {
                        case '220':
                        case '320':
                        case '420':
                            $extraCableAtReel = $extraCableAtReel + 1;
                            break;
                    }
                }
                break;

            case "SHO":
            case "TMR":
                switch ($srchColl){
                    case "23":
                    case "33":
                    case "43":
                        $subscrpt2 = "1";
                        break;
                    case "63":
                    case "83":
                    case "27":
                    case "37":
                    case "47":
                    case "212":
                    case "220":
                    case "320":
                        $subscrpt2 = "2";
                        break;
                    case "103":
                    case "123":
                    case "312":
                    case "412":
                    case "420":
                        $subscrpt2 = "3";
                        break;
                    case "143":
                    case "163":
                        $subscrpt2 = "4";
                        break;
                    case "203":
                        $subscrpt2 = "5";
                        break;
                    case "243":
                        $subscrpt2 = "6";
                        break;
                    case "303":
                        $subscrpt2 = "7";
                        break;
                    case "363":
                        $subscrpt2 = "8";
                        break; //$subscrpt2 = "7";
                    default:
                        $subscrpt2 = "8";
                }

                switch(strval($drumSize)){
                    case "14":
                        $subscrpt1 = "1";
                        break;
                    case "16":
                        $subscrpt1 = "2";
                        break;
                    case "18":
                        $subscrpt1 = "3";
                        break;
                    case "20":
                        $subscrpt1 = "4";
                        break;
                    case "22":
                        $subscrpt1 = "5";
                        break;
                    case "24":
                        $subscrpt1 = "6";
                        break;
                    case "26":
                        $subscrpt1 = "7";
                        break;
                    case "28":
                        $subscrpt1 = "8";
                        break;
                    case "30":
                        $subscrpt1 = "9";
                        break;
                    case "32":
                        $subscrpt1 = "10";
                        break;
                    case "34":
                        $subscrpt1 = "11";
                        break;
                    case "36":
                        $subscrpt1 = "12";
                        break;
                    case "38":
                        $subscrpt1 = "13";
                        break;
                    case "40":
                        $subscrpt1 = "14";
                        break;
                    case "42":
                        $subscrpt1 = "15";
                        break;
                    case "44":
                        $subscrpt1 = "16";
                        break;
                    case "46":
                        $subscrpt1 = "17";
                        break;
                    case "48":
                        $subscrpt1 = "18";
                        break;
                }

                $subscrpt = $subscrpt2 . $subscrpt1;
                switch ($subscrpt){
                    case "11":
                    case "12":
                    case "21":
                    case "31":
                    case "41":
                        $cableAtReel = 9;
                        break;
                    case "13":
                    case "22":
                    case "23":
                    case "32":
                    case "42":
                    case "52":
                    case "51":
                    case "61":
                    case "71":
                    case "81":
                        $cableAtReel = 10;
                        break;
                    case "62":
                    case "72":
                    case "82":
                    case "33":
                    case "43":
                    case "53":
                    case "63":
                    case "14":
                    case "24":
                    case "34":
                    case "44":
                    case "15":
                        $cableAtReel = 11;
                        break;
                    case "73":
                    case "83":
                    case "54":
                    case "64":
                    case "74":
                    case "84":
                    case "25":
                    case "35":
                    case "45":
                    case "55":
                    case "16":
                    case "26":
                        $cableAtReel = 12;
                        break;
                    case "65":
                    case "75":
                    case "85":
                    case "36":
                    case "46":
                    case "56":
                    case "66":
                    case "17":
                    case "27":
                    case "37":
                    case "47":
                    case "18":
                        $cableAtReel = 13;
                        break;
                    case "76":
                    case "86":
                    case "57":
                    case "67":
                    case "77":
                    case "87":
                    case "28":
                    case "38":
                    case "48":
                    case "58":
                    case "29":
                    case "39":
                        $cableAtReel = 14;
                        break;
                    case "68":
                    case "78":
                    case "88":
                    //case "39":
                    case "49":
                    case "59":
                    case "69":
                    case "79":
                    case "110":
                    case "210":
                    case "310":
                    case "410":
                    case "111":
                        $cableAtReel = 15;
                        break;
                    case "89":
                    case "510":
                    case "610":
                    case "710":
                    case "810":
                    case "211":
                    case "311":
                    case "411":
                    case "511":
                    case "611":
                    case "112":
                    case "212":
                    case "312":
                        $cableAtReel = 16;
                        break;
                    case "711":
                    case "811":
                    case "412":
                    case "512":
                    case "612":
                    case "712":
                    case "113":
                    case "213":
                    case "313":
                    case "413":
                    case "114":
                        $cableAtReel = 17;
                        break;
                    case "812":
                    case "513":
                    case "613":
                    case "713":
                    case "813":
                    case "214":
                    case "314":
                    case "414":
                    case "514":
                    case "614":
                    case "115":
                    case "215":
                    case "315":
                        $cableAtReel = 18;
                        break; //Case "714", "814", "415", "515", "615", "715", "116", "216", "316", "416", "117": cableATreel = 19
                    case "714":
                    case "814":
                    case "415":
                    case "515":
                    case "615":
                    case "715":
                    case "116":
                    case "216":
                    case "316":
                    case "416":
                    case "117":
                        $cableAtReel = 19;
                        break; //Case "815", "516", "616", "716", "816", "217", "317", "417", "517", "617", "118", "218", "318": cableATreel = 20
                    case "815":
                    case "516":
                    case "616":
                    case "716":
                    case "816":
                    case "217":
                    case "317":
                    case "417":
                    case "517":
                    case "617":
                    case "118":
                    case "218":
                    case "318":
                        $cableAtReel = 20;
                        break; //Case "717", "817", "418", "518", "618", "718": cableATreel = 21
                    case "717":
                    case "817":
                    case "418":
                    case "518":
                    case "618":
                    case "718":
                        $cableAtReel = 21;
                        break; // Case "818": cableATreel = 22
                    case "818":
                        $cableAtReel = 22;
                        break;
                }
                if ($deadWraps >= 1){
                    $extraCableAtReel = $cableAtReel + (($deadWraps - 1) * ($drumSize + $cableThick) * pi() / 12.0);
                }else{
                    $extraCableAtReel = $cableAtReel;
                }
                break;
            case "K":
                $extraCableAtReel = intval($deadWrapLength) + 1;
                break;
            case "C":
            case "HM":
                if($deadWraps >= 1){
                    $extraCableAtReel = 5 + (($deadWraps - 1) * ($drumSize + $cableThick) * pi() / 12.0);
                }else{
                    $extraCableAtReel = 5;
                }
        }
        return $extraCableAtReel;
    }

        private function doInitialCalcs($srchSpoolWidth, $srchSpoolMethod, $srchStyle, $frameSize, $swOpt, $cable, $drumSize, $pretensionTurns, $ccf, $travelInFt, $deadWraps, $calcTorqueParams, $collector, $srchSpring, $srchGear, $modelIndex, $specificInput, $cableOrHose, $srchMotor, $application, $srchColl, $uReelWidth, $uReelWidthInp) {

        //Sanning: Cable thickness. Used in: mostly non-case specific cals, also used in torqueCalcs params.
        $cableThick = $cable['thickness'];
        $cableType = $cable['type'];
        //Sanning: honeWgtBoth, used in multiple places
       $hoseWgtboth = 0;

        //$magnetCalcs = fopen("C:\\Users\\nwachukwuc1\\Desktop\\initialCalsForMagnet.txt", "a");

        //fwrite($magnetCalcs, $srchStyle. $frameSize . $srchSpring . "-". $srchColl. "-" . $drumSize . "-" . $pretensionTurns . PHP_EOL);

        //Sanning: Variable Initialization block, catches all variables used in scope of function initialized to 0
        $wrapperWidthR = 0;
        $compartmentHeight = 0;
        $cableClearanceFactor = 0;
        $compartmentMaximumCableLength = 0;
        $cableCapacityLostFirstClearanceWrap = 0;
        $cableCapacityLostSecondClearanceWrap = 0;
        $cableCapacityLostThirdClearanceWrap = 0;
        $compartmentCableCapacity = 0;
        $cableClearanceInInchesLess1Layers = 0;
        $cableClearanceInInchesLess2Layers = 0;
        $cableClearanceInInchesLess3Layers = 0;
        $cableClearanceInInches = 0;
        $firstLayerMomentArm = 0;
        $reelInertia = 0;
        $torqueToOvercomeCollectorFriction = 0;
        $adjustedTorque = 0;
        $deadWrapLength = 0;
        $maxWrapsPerLayerRStored = 0;
        $maxWrapsPerLayerR = 0;
        $maxWrapsPerLayerI = 0;
        $springTurnsAvailAfterPretensionR = 0;
        $maxUsableWrapsR = 0;
        $compartmentActiveCableLength = 0;
        $maxUsableLayersR = 0;
        $maxUsableLayersI = 0;
        $maxCableLayersR = 0;
        $AdjSlopeFirstPartOfCurve = 0;
        $AdjyInterceptFirstPartOfCurve = 0;
        $AdjMaxTurnsForFirstPartOfCurve = 0;
        $torqueSafetyFactor = 0;
        $AdjSlopeSecondPartOfCurve = 0;
        $AdjyInterceptSecondPartOfCurve = 0;
        $AdjMaxTurnsForSecondPartOfCurve = 0;
        $turnsActiveCableLength = 0;
        $maxFullLayersFromTurnsR = 0;
        $extraWrapsAfterFullLayersTurnsR = 0;
        $extraWrapsAfterFullLayersTurnsI = 0;

        $validTurns = 0;
        $validCompartment = 0;
        $AdjMaxTurnsForThirdPartOfCurve = 0;
        $AdjyInterceptThirdPartOfCurve = 0;
        $AdjSlopeThirdPartOfCurve = 0;

        $spoolWidthCode = 0;
        $springFamilyIndex = 0;
        $reelInertiaCalcs = 0; $wrapperWidthI = 0; $reelWidthInp = "";

        switch ($srchStyle) {
            case 'S':
            case 'SM':
            case 'MMD':
            case 'P':
                switch ($frameSize) {
                    case 14:
                        $wrapperWidthI = 4;
                        break;
                    case 16:
                        $wrapperWidthI = 5;
                        break;
                    case 18:
                        $wrapperWidthI = 5;
                        break;
                    case 21:
                        $wrapperWidthI = 5;
                        break;
                    case 24:
                        $wrapperWidthI = 5;
                        break;
                    case 28:
                        $wrapperWidthI = 7;
                        break;
                    case 32:
                        $wrapperWidthI = 7;
                        break;
                }
            //fwrite($magnetCalcs, "wrapperWidthI: " . $wrapperWidthI . PHP_EOL);

                if ($srchStyle == 'S' && $frameSize > 15 && $frameSize < 25 && $swOpt) {
                    $wrapperWidthI = 7;
                }

                $wrapperWidthR = $wrapperWidthI;
            //fwrite($magnetCalcs, "wrapperWidthR: " . $wrapperWidthR . PHP_EOL);

                $spoolWidthCode = 0;
                break;
            case 'SHO':
            case 'TMR':
                if ($srchSpoolMethod == "M") {
                    switch ($srchSpoolWidth) {
                        case 'ma':
                            $spoolWidth = .75;
                            break;
                        case 'mb':
                            $spoolWidth = 1;
                            break;
                        case 'mc':
                            $spoolWidth = 1.25;
                            break;
                        case 'md':
                            $spoolWidth = 1.5;
                            break;
                        case 'me':
                            $spoolWidth = 1.75;
                            break;
                        case 'mf':
                            $spoolWidth = 2;
                            break;
                        case 'mx':
                            $spoolWidth = 1.1 * $cableThick;
                            break;
                        //Sanning: Default case needed as spoolWidth needs to be initialized
                        default:
                            $spoolWidth = 0;
                            break;
                    }
                    $wrapperWidthR = $spoolWidth;
                    $wrapperWidthR = 1.1 * $cableThick;
                    $spoolWidthCode = $srchSpoolWidth;
                    //fwrite($magnetCalcs, "srchSpoolMethod: " . $srchSpoolMethod . PHP_EOL);
                    //fwrite($magnetCalcs, "spoolWidth: " . $spoolWidth . PHP_EOL);
                    //fwrite($magnetCalcs, "wrapperWidthR: " . $wrapperWidthR . PHP_EOL);
                    //fwrite($magnetCalcs, "spoolWidthCode: " . $spoolWidthCode . PHP_EOL);

                } else {
                    $spoolWidthCode = 0;
                    $wrapperWidthR = $srchSpoolWidth;
                    //fwrite($magnetCalcs, "wrapperWidthR: " . $wrapperWidthR . PHP_EOL);
                    //fwrite($magnetCalcs, "srchSpoolWidth: " . $srchSpoolWidth . PHP_EOL);
                }

                break;
            case "K":

                switch ($cable['hoseIDCode']) {
                    case "4":
                        $wrapperWidthR = 1.25;
                        $hoseWgtboth = 2 * ($cable["weight"] + 0.02);
                        break;
                    case "6":
                        $wrapperWidthR = 1.75;
                        $hoseWgtboth = 2 * ($cable["weight"] + 0.05);
                        break;
                    case "8":
                        $wrapperWidthR = 2.125;
                        $hoseWgtboth = 2 * ($cable["weight"] + 0.09);
                        break;
                    case "12":
                        $wrapperWidthR = 2.75;
                        $hoseWgtboth = 2 * ($cable["weight"] + 0.19);
                        break;
                }
                if($cableType == "Air"){
                    $hoseWgtboth = 2 * $cable["weight"];
                }
                break;
            case "U":
                $wrapperWidthR = $uReelWidth;
                $reelWidthInp = $uReelWidthInp;
                break;
        }


        $grndchkQty = $cable['grndchck'];
        //fwrite($magnetCalcs, "grndchkQty: " . $grndchkQty . PHP_EOL);


        if ($srchStyle == 'K') {
            $maxWrapsPerLayerR = 1;
        } else {
            $maxWrapsPerLayerR = $wrapperWidthR / $cableThick;
            //fwrite($magnetCalcs, "maxWrapsPerLayerR: " . $maxWrapsPerLayerR . PHP_EOL);
            //fwrite($magnetCalcs, "wrapperWidthR: " . $wrapperWidthR . PHP_EOL);
            //fwrite($magnetCalcs, "cableThick: " . $cableThick . PHP_EOL);
        }

        $maxWrapsPerLayerRStored = $maxWrapsPerLayerR;
        $maxWrapsPerLayerR = floor($maxWrapsPerLayerR); //Dropping fractional part for testing ---
        $maxWrapsPerLayerRStored = round($maxWrapsPerLayerRStored, 6);

        //fwrite($magnetCalcs, "maxWrapsPerLayerR: " . $maxWrapsPerLayerR . PHP_EOL);
        //fwrite($magnetCalcs, "maxWrapsPerLayerRStored: " . $maxWrapsPerLayerRStored . PHP_EOL);

        $maxWrapsPerLayerI = intval($maxWrapsPerLayerR);
        //fwrite($magnetCalcs, "maxWrapsPerLayerI: " . $maxWrapsPerLayerI . PHP_EOL);

        $maxWrapsPerLayerR = $maxWrapsPerLayerI;
        //fwrite($magnetCalcs, "maxWrapsPerLayerR: " . $maxWrapsPerLayerR . PHP_EOL);

        $maxCableLayersR = ($frameSize - $drumSize) / (2.0 * $cableThick);
        $maxCableLayersR = round($maxCableLayersR, 6);
        //fwrite($magnetCalcs, "maxCableLayersR: " . $maxCableLayersR . PHP_EOL);
        //fwrite($magnetCalcs, "frameSize: " . $frameSize . PHP_EOL);
        //fwrite($magnetCalcs, "drumSize: " . $drumSize . PHP_EOL);
        //fwrite($magnetCalcs, "cableThick: " . $cableThick . PHP_EOL);


        $maxCableLayersI = intval($maxCableLayersR);
        //fwrite($magnetCalcs, "maxCableLayersI: " . $maxCableLayersI . PHP_EOL);
        //fwrite($magnetCalcs, "maxCableLayersR: " . $maxCableLayersR . PHP_EOL);

        $maxCableWrapsI = $maxWrapsPerLayerI * $maxCableLayersI;
        //fwrite($magnetCalcs, "maxCableWrapsI: " . $maxCableWrapsI . PHP_EOL);
        //fwrite($magnetCalcs, "maxWrapsPerLayerI: " . $maxWrapsPerLayerI . PHP_EOL);
        //fwrite($magnetCalcs, "maxCableLayersI: " . $maxCableLayersI . PHP_EOL);

        if ($ccf == 0) {//called CableCF in ReelMod.bas
            $this->cableClearanceFactor = $this->assignCCF($srchStyle, $maxCableWrapsI);
            //fwrite($magnetCalcs, "cableClearanceFactor: " . $this->cableClearanceFactor . PHP_EOL);
        } else {
            $this->cableClearanceFactor = $ccf;
            //fwrite($magnetCalcs, "cableClearanceFactor: " . $this->cableClearanceFactor . PHP_EOL);
        }
        //fwrite($magnetCalcs, "maxCableLayersR: " . $maxCableLayersR . PHP_EOL);


        $maxUsableLayersR = $maxCableLayersR - $this->cableClearanceFactor;
        //fwrite($magnetCalcs, "maxUsableLayersR: " . $maxUsableLayersR . PHP_EOL);
        //fwrite($magnetCalcs, "maxCableLayersR: " . $maxCableLayersR . PHP_EOL);
        //fwrite($magnetCalcs, "cableClearanceFactor: " . $this->cableClearanceFactor . PHP_EOL);


        $maxUsableLayersI = (int) ($maxUsableLayersR);
        $maxUsableLayersR = $maxUsableLayersI;
        //fwrite($magnetCalcs, "maxUsableLayersI: " . $maxUsableLayersI . PHP_EOL);
        //fwrite($magnetCalcs, "maxUsableLayersR: " . $maxUsableLayersR . PHP_EOL);

        $maxUsableWrapsR = $maxWrapsPerLayerR * $maxUsableLayersR;
        //fwrite($magnetCalcs, "maxUsableWrapsR: " . $maxUsableWrapsR . PHP_EOL);

        $compartmentHeight = ($frameSize - $drumSize) / 2.0;
        //fwrite($magnetCalcs, "compartmentHeight: " . $compartmentHeight . PHP_EOL);
        //fwrite($magnetCalcs, "frameSize: " . $frameSize . PHP_EOL);
        //fwrite($magnetCalcs, "drumSize: " . $drumSize . PHP_EOL);


        $fileStr = '';

        //todo: Need to add cases for SHO TMR P and K see line 2760 in ReelMod.bas
        switch ($srchStyle) {
            case 'S':
            case 'SM':
            case 'MMD':
            case 'U':
                $fileStr = $srchStyle . $frameSize . $srchSpring . '-' . $srchGear;
                break;
            case 'SHO':
                //$fileStr = $srchStyle . "-" .
                break;
        }

        $fileStr .= $fileStr . '-' . $pretensionTurns;
        // this is the part that doesn't make sense. The string is built and then reset and never used.


        $pi = 3.14159;//pi(); // figure out what value of pi the original program uses

        $deadWrapLength = $deadWraps * ($drumSize + $cableThick) * $pi / 12.0; // pi needs to replaced with actual value in program
        $deadWrapLength = round($deadWrapLength, 6);
        //fwrite($magnetCalcs, "deadWrapLength: " . $deadWrapLength . PHP_EOL);
        //fwrite($magnetCalcs, "deadWraps: " . $deadWraps . PHP_EOL);

        $cableLayerIndexR = 0;
        $compartmentCableCapacity = 0;
        while (true) {
            $cableLayerIndexR = $cableLayerIndexR + 1.0;

            if ($cableLayerIndexR > $maxUsableLayersR) {

                break;
            }
            //fwrite($magnetCalcs, "cableLayerIndexR: " . $cableLayerIndexR . PHP_EOL);

            switch ($srchStyle) {
                case 'SHO':
                case 'TMR':

                    switch ($srchSpoolMethod) {
                        case 'R':
                            if ($cableLayerIndexR / 2 == (int)($cableLayerIndexR / 2)) {
                                $layerCableCapacity = ($maxWrapsPerLayerR - 1) * ($drumSize + (2.0 * $cableLayerIndexR - 1.0) * $cableThick) * $pi / 12.0;
                                //fwrite($magnetCalcs, "layerCableCapacity: " . $layerCableCapacity . PHP_EOL);
                            } else {
                                $layerCableCapacity = $maxWrapsPerLayerR * ($drumSize + (2.0 * $cableLayerIndexR - 1.0) * $cableThick) * $pi / 12.0;
                                //fwrite($magnetCalcs, "layerCableCapacity: " . $layerCableCapacity . PHP_EOL);
                            }
                            break;
                        default:
                            $layerCableCapacity = $maxWrapsPerLayerR * ($drumSize + (2.0 * $cableLayerIndexR - 1.0) * $cableThick) * $pi / 12.0;
                            //fwrite($magnetCalcs, "layerCableCapacity: " . $layerCableCapacity . PHP_EOL);
                            break;
                    }
                    break;
                case "U":
                    if ($cableLayerIndexR / 2 == intval($cableLayerIndexR / 2)) {
                        $layerCableCapacity = ($maxWrapsPerLayerR - 1) * ($drumSize + (2.0 * $cableLayerIndexR - 1.0) * $cableThick) * $pi / 12.0;
                        //fwrite($magnetCalcs, "layerCableCapacity: " . $layerCableCapacity . PHP_EOL);
                    } else {
                        $layerCableCapacity = ($maxWrapsPerLayerR) * ($drumSize + (2.0 * $cableLayerIndexR - 1) * $cableThick) * $pi / 12.0;
                        //fwrite($magnetCalcs, "layerCableCapacity: " . $layerCableCapacity . PHP_EOL);
                    }
                    break;
                default:
                    $layerCableCapacity = $maxWrapsPerLayerR * ($drumSize + (2.0 * $cableLayerIndexR - 1) * $cableThick) * $pi / 12.0;
                    $layerCableCapacity = round($layerCableCapacity, 5);

                    //fwrite($magnetCalcs, "layerCableCapacity In Switch: " . $layerCableCapacity . PHP_EOL);
                    break;
            }
            //fwrite($magnetCalcs, "layerCableCapacity Outside Switch: " . $layerCableCapacity . PHP_EOL);

            $compartmentCableCapacity = $compartmentCableCapacity + $layerCableCapacity;
            //fwrite($magnetCalcs, "compartmentCableCapacity: " . $compartmentCableCapacity . PHP_EOL);
        }//End of Loop

        $compartmentActiveCableLength = $compartmentCableCapacity - $deadWrapLength;
        $compartmentActiveCableLength = round($compartmentActiveCableLength, 5);
        //fwrite($magnetCalcs, "compartmentActiveCableLength: " . $compartmentActiveCableLength . PHP_EOL);

        if ($compartmentActiveCableLength < $travelInFt) {

            switch ($specificInput) {
                case false:
                    $initialCalcs = array(
                        "validTurns" => false,
                        "validCompartment" => false,
                        "SWC" => $spoolWidthCode,
                        "invalidReason" => 1
                    );
                    //fclose($magnetCalcs);
                    return $initialCalcs;
                    break;
                case true:
                    $invalidWarning = true;
                    break;
            }

        }
        $validCompartment = true;
        switch ($srchStyle) {
            case 'S':
            case 'SM':
            case 'MMD':
            case 'SHO':
            case 'U':
            case 'K':
                //debugbar::info("CalcTorque - Params");
                //debugbar::info($calcTorqueParams);
            //fwrite($magnetCalcs,  PHP_EOL);
            //fwrite($magnetCalcs, "pretensionTurns: " . $pretensionTurns . PHP_EOL);
            //fwrite($magnetCalcs, "springSize: " . $calcTorqueParams['springSize'] . PHP_EOL);
            //fwrite($magnetCalcs, "turnsUsedPercent: " . $calcTorqueParams['turnsUsedPercent'] . PHP_EOL);
            //fwrite($magnetCalcs, "gearRatio: " . $calcTorqueParams['gearRatio'] . PHP_EOL);
            //fwrite($magnetCalcs, "maxWrapsPerLayerR: " . $maxWrapsPerLayerR . PHP_EOL);
            //fwrite($magnetCalcs, "drumSize: " . $drumSize . PHP_EOL);
            //fwrite($magnetCalcs, "deadWrapLength: " . $deadWrapLength . PHP_EOL);
            //fwrite($magnetCalcs, "compartmentActiveCableLength: " . $compartmentActiveCableLength . PHP_EOL);
            //fwrite($magnetCalcs, "maxUsableWrapsR: " . $maxUsableWrapsR . PHP_EOL);
            //fwrite($magnetCalcs,  PHP_EOL);

                $torqueCalcs = $this->calcTorque($calcTorqueParams['springSize'], $calcTorqueParams['springData'], $calcTorqueParams['turnsUsedPercent'], $calcTorqueParams['gearRatio'], $pretensionTurns, $maxWrapsPerLayerR, $cableThick, $drumSize, $deadWrapLength, $compartmentActiveCableLength, $maxUsableWrapsR);
                $turnsActiveCableLength = $torqueCalcs['turnsActiveCableLength'];
                $turnsActiveCableLength = round($turnsActiveCableLength, 5);
            //fwrite($magnetCalcs, "torqueCalcs: " . $torqueCalcs . PHP_EOL);
            //fwrite($magnetCalcs, "turnsActiveCableLength: " . $turnsActiveCableLength . PHP_EOL);

                if ($turnsActiveCableLength < $travelInFt) {
                    switch ($specificInput) {
                        case false:
                            $initialCalcs = array(
                                "validTurns" => false,
                                "validCompartment" => false,
                                "SWC" => $spoolWidthCode,
                                "reason" => 2
                            );
                            //fclose($magnetCalcs);
                            return $initialCalcs;
                            break;
                        case true:
                            $invalidWarning = true;
                            break;
                    }
                }
                break;
            case 'TMR': // see line 2841 in ReelMod.bas
                switch ($srchMotor) {
                    case "2":
                        $this->tqsiz = 2.4;
                        $this->rmoti = 0.093;
                        break;
                    case "3":
                        $this->tqsiz = 3.7;
                        $this->rmoti = 0.164;
                        break;
                    case "5":
                        $this->tqsiz = 5.1;
                        $this->rmoti = 0.29;
                        break;
                    case "7":
                        $this->tqsiz = 7.8;
                        $this->rmoti = 0.486;
                        break;
                    case "9":
                        $this->tqsiz = 9.8;
                        $this->rmoti = 0.923;
                        break;
                    case "14":
                        $this->tqsiz = 14;
                        $this->rmoti = 1.478;
                        break;
                }
                break;
            case 'P':
                switch ($srchMotor) {
                    case "25":
                        $this->torqueFromMotor = 21.9;
                        break;
                    case "50":
                        $this->torqueFromMotor = 43.8;
                        break;
                    case "75":
                        $this->torqueFromMotor = 65.7;
                        break;
                    case "150":
                        $this->torqueFromMotor = 131.4;
                        break;
                }
                break;
        }
        //fwrite($magnetCalcs, "this->tqsiz: " . $this->tqsiz . PHP_EOL);
        //fwrite($magnetCalcs, "this->rmoti: " . $this->rmoti . PHP_EOL);
        //fwrite($magnetCalcs, "this->torqueFromMotor: " . $this->torqueFromMotor . PHP_EOL);

        if(isset($torqueCalcs)) {
            $AdjSlopeFirstPartOfCurve = $torqueCalcs['adjSlopeFirstPartOfCurve'];
            $AdjyInterceptFirstPartOfCurve = $torqueCalcs['AdjyInterceptFirstPartOfCurve'];
            $AdjMaxTurnsForFirstPartOfCurve = $torqueCalcs['AdjMaxTurnsForFirstPartOfCurve'];
            //fwrite($magnetCalcs, "AdjSlopeFirstPartOfCurve: " . $AdjSlopeFirstPartOfCurve . PHP_EOL);
            //fwrite($magnetCalcs, "AdjyInterceptFirstPartOfCurve: " . $AdjyInterceptFirstPartOfCurve . PHP_EOL);
            //fwrite($magnetCalcs, "AdjMaxTurnsForFirstPartOfCurve: " . $AdjMaxTurnsForFirstPartOfCurve . PHP_EOL);

            $AdjSlopeSecondPartOfCurve = $torqueCalcs['AdjSlopeSecondPartOfCurve'];
            $AdjyInterceptSecondPartOfCurve = $torqueCalcs['AdjyInterceptSecondPartOfCurve'];
            $AdjMaxTurnsForSecondPartOfCurve = $torqueCalcs['AdjMaxTurnsForSecondPartOfCurve'];
            //fwrite($magnetCalcs, "AdjSlopeSecondPartOfCurve: " . $AdjSlopeSecondPartOfCurve . PHP_EOL);
            //fwrite($magnetCalcs, "AdjyInterceptSecondPartOfCurve: " . $AdjyInterceptSecondPartOfCurve . PHP_EOL);
            //fwrite($magnetCalcs, "AdjMaxTurnsForSecondPartOfCurve: " . $AdjMaxTurnsForSecondPartOfCurve . PHP_EOL);

            $AdjMaxTurnsForThirdPartOfCurve = $torqueCalcs['AdjMaxTurnsForThirdPartOfCurve'];
            $AdjyInterceptThirdPartOfCurve = $torqueCalcs['AdjyInterceptThirdPartOfCurve'];
            $AdjSlopeThirdPartOfCurve = $torqueCalcs['AdjSlopeThirdPartOfCurve'];
            //fwrite($magnetCalcs, "AdjMaxTurnsForThirdPartOfCurve: " . $AdjMaxTurnsForThirdPartOfCurve . PHP_EOL);
            //fwrite($magnetCalcs, "AdjyInterceptThirdPartOfCurve: " . $AdjyInterceptThirdPartOfCurve . PHP_EOL);
            //fwrite($magnetCalcs, "AdjSlopeThirdPartOfCurve: " . $AdjSlopeThirdPartOfCurve . PHP_EOL);


            $maxFullLayersFromTurnsR = $torqueCalcs['maxFullLayersFromTurnsR'];
            $extraWrapsAfterFullLayersTurnsI = $torqueCalcs['extraWrapsAfterFullLayersTurnsI'];
            $extraWrapsAfterFullLayersTurnsR = $torqueCalcs['extraWrapsAfterFullLayersTurnsR'];
            //fwrite($magnetCalcs, "maxFullLayersFromTurnsR: " . $maxFullLayersFromTurnsR . PHP_EOL);
            //fwrite($magnetCalcs, "extraWrapsAfterFullLayersTurnsI: " . $extraWrapsAfterFullLayersTurnsI . PHP_EOL);
            //fwrite($magnetCalcs, "extraWrapsAfterFullLayersTurnsR: " . $extraWrapsAfterFullLayersTurnsR . PHP_EOL);


            $springFamilyIndex = $torqueCalcs["springFamilyIndex"];
            $adjustedTorque = $torqueCalcs["adjustedTorque"];
            $springTurnsAvailAfterPretensionR = $torqueCalcs["springTurnsAvailAfterPretensionR"];
            //fwrite($magnetCalcs, "springFamilyIndex: " . $springFamilyIndex . PHP_EOL);
            //fwrite($magnetCalcs, "adjustedTorque: " . $adjustedTorque . PHP_EOL);
            //fwrite($magnetCalcs, "springTurnsAvailAfterPretensionR: " . $springTurnsAvailAfterPretensionR . PHP_EOL);
        }
        else{
            //Sanning: These are specific segments of torqueCalcs that need to be set to 0 so that they are initialized
            $torqueCalcs= array(
                'availSpringTurns' => 0,
                'turnsMaximumCableLength' => 0,
            );
        }

        $cableClearanceInInchesLess1Layers = 0;
        $cableClearanceInInchesLess2Layers = 0;
        $cableClearanceInInchesLess3Layers = 0;
        $cableCapacityLostSecondClearanceWrap = 0.0;
        $cableCapacityLostFirstClearanceWrap = 0.0;
        $cableCapacityLostThirdClearanceWrap = 0.0;

        $cableClearanceInInches = (($frameSize - $drumSize) / 2.0) - ($maxUsableLayersR * $cableThick);
        //fwrite($magnetCalcs, "cableClearanceInInches: " . $cableClearanceInInches . PHP_EOL);

        $cableLayerIndexI = intval($cableLayerIndexR);
        //fwrite($magnetCalcs, "cableLayerIndexI: " . $cableLayerIndexI . PHP_EOL);

        if ($cableLayerIndexI > $maxCableLayersI) {
            goto LINE417;
        }

        $cableCapacityLostFirstClearanceWrap = $maxWrapsPerLayerR * ($drumSize + (2.0 * $cableLayerIndexR - 1) * $cableThick) * $pi / 12.0;
        $cableCapacityLostFirstClearanceWrap = round($cableCapacityLostFirstClearanceWrap, 5);

        $cableClearanceInInchesLess1Layers = (($frameSize - $drumSize) / 2.0) - (($maxUsableLayersR + 1) * $cableThick);
        $cableClearanceInInchesLess1Layers = round($cableClearanceInInchesLess1Layers, 5);

        //fwrite($magnetCalcs, "cableCapacityLostFirstClearanceWrap: " . $cableCapacityLostFirstClearanceWrap . PHP_EOL);
        //fwrite($magnetCalcs, "cableClearanceInInchesLess1Layers: " . $cableClearanceInInchesLess1Layers . PHP_EOL);

        $cableLayerIndexR = $cableLayerIndexR + 1.0;
        $cableLayerIndexI = intval($cableLayerIndexR);
        //fwrite($magnetCalcs, "cableLayerIndexR: " . $cableLayerIndexR . PHP_EOL);
        //fwrite($magnetCalcs, "cableLayerIndexI: " . $cableLayerIndexI . PHP_EOL);

        if ($cableLayerIndexI > $maxCableLayersI) {
            goto LINE417;
        }

        $cableCapacityLostSecondClearanceWrap = $maxWrapsPerLayerR * ($drumSize + (2.0 * $cableLayerIndexR - 1.0) * $cableThick) * $pi / 12.0;
        //fwrite($magnetCalcs, "cableCapacityLostSecondClearanceWrap: " . $cableCapacityLostSecondClearanceWrap . PHP_EOL);

        $cableClearanceInInchesLess2Layers = (($frameSize - $drumSize) / 2.0) - (($maxUsableLayersR + 2) * $cableThick);
        //fwrite($magnetCalcs, "cableClearanceInInchesLess2Layers: " . $cableClearanceInInchesLess2Layers . PHP_EOL);

        $cableLayerIndexR = $cableLayerIndexR + 1.0;
        $cableLayerIndexI = intval($cableLayerIndexR);
        //fwrite($magnetCalcs, "cableLayerIndexR: " . $cableLayerIndexR . PHP_EOL);
        //fwrite($magnetCalcs, "cableLayerIndexI: " . $cableLayerIndexI . PHP_EOL);

        if ($cableLayerIndexI > $maxCableLayersI) {
            goto LINE417;
        }

        $cableCapacityLostThirdClearanceWrap = $maxWrapsPerLayerR * ($drumSize + (2.0 * $cableLayerIndexR - 1.0) * $cableThick) * $pi / 12.0;
        //fwrite($magnetCalcs, "cableCapacityLostThirdClearanceWrap: " . $cableCapacityLostThirdClearanceWrap . PHP_EOL);

        $cableClearanceInInchesLess3Layers = (($frameSize - $drumSize) / 2.0) - (($maxUsableLayersR + 3) * $cableThick);
        //fwrite($magnetCalcs, "cableClearanceInInchesLess3Layers: " . $cableClearanceInInchesLess3Layers . PHP_EOL);

        LINE417:
        $compartmentMaximumCableLength = $compartmentCableCapacity + $cableCapacityLostFirstClearanceWrap + $cableCapacityLostSecondClearanceWrap + $cableCapacityLostThirdClearanceWrap;
        $compartmentMaximumCableLength = round($compartmentMaximumCableLength, 5);
        //fwrite($magnetCalcs, "compartmentMaximumCableLength: " . $compartmentMaximumCableLength . PHP_EOL);


        $collectorAmp = $collector['collectorAmp'];
        //fwrite($magnetCalcs, "collectorAmp: " . $collectorAmp . PHP_EOL);

        $numCollectorConductors = $collector['numCollectorConductors'];
        //fwrite($magnetCalcs, "numCollectorConductors: " . $numCollectorConductors . PHP_EOL);

        if ($srchStyle != 'P') {

            switch ($cableOrHose) {
                case "HD":
                case "HS":
                    switch ($srchStyle) {
                        case "K":
                            $torqueToOvercomeCollectorFriction = 1;
                            break;
                        case "U":
                        case "HM":
                            switch ($cable["hoseIDCode"]) {
                                case "4":
                                    $torqueToOvercomeCollectorFriction = 2.5 / 12;
                                    break;
                                case "6":
                                    $torqueToOvercomeCollectorFriction = 5 / 12;
                                    break;
                                case "8":
                                    $torqueToOvercomeCollectorFriction = 7.5 / 12;
                                    break;
                                case "12":
                                    $torqueToOvercomeCollectorFriction = 12.5 / 12;
                                    break;
                                case "16":
                                    $torqueToOvercomeCollectorFriction = 20 / 12;
                                    break;
                                case "20":
                                    $torqueToOvercomeCollectorFriction = 50 / 12;
                                    break;
                                case "24":
                                    $torqueToOvercomeCollectorFriction = 56 / 12;
                                    break;
                            }
                        //fwrite($magnetCalcs, "torqueToOvercomeCollectorFriction: " . $torqueToOvercomeCollectorFriction . PHP_EOL);
                            break;
                    }
                    break;
                default:
                    switch ($collectorAmp) {
                        case 35:
                            $torqueToOvercomeCollectorFriction = 0.5 + 0.2 * $numCollectorConductors + $grndchkQty;
                            break;
                        case 75:
                            $torqueToOvercomeCollectorFriction = 0.5 + 0.4 * $numCollectorConductors + ($grndchkQty * 0.7);
                            break;
                        case 125:
                            switch ($srchStyle) {
                                case "U":
                                    $torqueToOvercomeCollectorFriction = 0.5 + 1.2 * $numCollectorConductors + ($grndchkQty * 0.7);
                                    break;
                                default:
                                    $torqueToOvercomeCollectorFriction = 0.5 + 1.2 * $numCollectorConductors + ($grndchkQty * 0.7);

                                    break;
                            }
                            //fwrite($magnetCalcs, "torqueToOvercomeCollectorFriction: " . $torqueToOvercomeCollectorFriction . PHP_EOL);
                            break;
                        case 200:
                            $torqueToOvercomeCollectorFriction = 0.5 + 1.2 * $numCollectorConductors + ($grndchkQty * 0.7);
                            //fwrite($magnetCalcs, "torqueToOvercomeCollectorFriction: " . $torqueToOvercomeCollectorFriction . PHP_EOL);
                            break;
                        case 400:
                            $torqueToOvercomeCollectorFriction = 0.5 + 2.0 * $numCollectorConductors + ($grndchkQty * 0.7);
                            //fwrite($magnetCalcs, "torqueToOvercomeCollectorFriction: " . $torqueToOvercomeCollectorFriction . PHP_EOL);
                            break;
                    }
            }

            //Sanning: These only run correctly in case 'K' so far, as otherwise adjustedTorque, springFamilyIndex, and wrapperWidhR are all 0
            $reelInertiaCalcs = $this->calcInertia($srchStyle, $frameSize, $drumSize, $adjustedTorque, $springFamilyIndex, $wrapperWidthR, $srchSpoolMethod, $cable);
            $reelInertia = $reelInertiaCalcs['reelInertia'];
            //fwrite($magnetCalcs, "reelInertiaCalcs: " . $reelInertiaCalcs . PHP_EOL);
            //fwrite($magnetCalcs, "reelInertia: " . $reelInertia . PHP_EOL);

            // switch ($srchStyle) { //todo:figure out why this is here... it shouldnt matter. see line 2930 of ReelMod.bas
            // }
            //line 2930 ReelMod.Bas
            //Adjusted torque is never used in the calcInertia function, so I will set it to a default value for TMR searches for now

            switch ($srchStyle) {
                case "S":
                case "MMD":
                case "SM":
                case 'SHO':
                case 'U':
                case 'K':
                    //$spoolWidthCode = 0;
                    if ($cableThick <= 0.5) {
                        $torqueSafetyFactor = 1.2;
                    } else {
                        if ($cableThick <= 0.75) {
                            if ($drumSize <= 9.0) {
                                $torqueSafetyFactor = 1.3;
                            }
                            if ($drumSize > 9.0) {
                                $torqueSafetyFactor = 1.2;
                            }

                        } else {
                            if ($cableThick <= 1.0) {
                                if ($drumSize <= 12.0) {
                                    $torqueSafetyFactor = 1.4;
                                }
                                if ($drumSize > 12.0) {
                                    $torqueSafetyFactor = 1.3;
                                }

                            } else {
                                if ($cableThick <= 1.25) {
                                    if ($drumSize <= 15.0) {
                                        $torqueSafetyFactor = 1.5;
                                    }
                                    if ($drumSize > 15.0) {
                                        $torqueSafetyFactor = 1.4;
                                    }

                                } else {
                                    if ($cableThick <= 1.5) {
                                        if ($drumSize <= 18.0) {
                                            $torqueSafetyFactor = 1.6;
                                        }
                                        if ($drumSize > 18.0) {
                                            $torqueSafetyFactor = 1.5;
                                        }

                                    } else {
                                        if ($drumSize <= 21.0) {
                                            $torqueSafetyFactor = 1.7;
                                        }
                                        if ($drumSize > 21.0) {
                                            $torqueSafetyFactor = 1.6;
                                        }

                                    }
                                }
                            }
                        }
                    }
                    break;

                case "TMR":
                    $torqueSafetyFactor = 1.25;
                    break;
            }
            //fwrite($magnetCalcs, "torqueSafetyFactor: " . $torqueSafetyFactor . PHP_EOL);
        }
            $this->firstLayerMomentArm = ($drumSize + $cableThick) / (2.0 * 12.0);
            //fwrite($magnetCalcs, "this->firstLayerMomentArm: " . $this->firstLayerMomentArm . PHP_EOL);
        //fwrite($magnetCalcs, "=============================================================================================" . PHP_EOL);

            $validTurns = true;
        //fclose($magnetCalcs);
           //initialCalcs Assigned here CAI

           $initialCalcs = array(
               "wrapperWidthR" => $wrapperWidthR,
               "compartmentHeight" => $compartmentHeight,
               "cableClearanceFactor" => $this->cableClearanceFactor,
               "compartmentMaximumCableLength" => $compartmentMaximumCableLength,
               "cableCapacityLostFirstClearanceWrap" => $cableCapacityLostFirstClearanceWrap,
               "cableCapacityLostSecondClearanceWrap" => $cableCapacityLostSecondClearanceWrap,
               "cableCapacityLostThirdClearanceWrap" => $cableCapacityLostThirdClearanceWrap,
               "compartmentCableCapacity" => $compartmentCableCapacity,
               "cableClearanceInInchesLess1Layers" => $cableClearanceInInchesLess1Layers,
               "cableClearanceInInchesLess2Layers" => $cableClearanceInInchesLess2Layers,
               "cableClearanceInInchesLess3Layers" => $cableClearanceInInchesLess3Layers,
               "cableClearanceInInches" => $cableClearanceInInches,
               "firstLayerMomentArm" => $this->firstLayerMomentArm,
               "reelInertia" => $reelInertia,
               "torqueToOvercomeCollectorFriction" => $torqueToOvercomeCollectorFriction,
               "adjustedTorque" => $adjustedTorque,
               "deadWrapLength" => $deadWrapLength,
               "maxWrapsPerLayerRStored" => $maxWrapsPerLayerRStored,
               "maxWrapsPerLayerR" => $maxWrapsPerLayerR,
               "maxWrapsPerLayerI" => $maxWrapsPerLayerI,
               "springTurnsAvailAfterPretensionR" => $springTurnsAvailAfterPretensionR,
               "maxUsableWrapsR" => $maxUsableWrapsR,
               "compartmentActiveCableLength" => $compartmentActiveCableLength,
               "maxUsableLayersR" => $maxUsableLayersR,
               "maxUsableLayersI" => $maxUsableLayersI,
               "maxCableLayersR" => $maxCableLayersR,
               "AdjSlopeFirstPartOfCurve" => $AdjSlopeFirstPartOfCurve,
               "AdjyInterceptFirstPartOfCurve" => $AdjyInterceptFirstPartOfCurve,
               "AdjMaxTurnsForFirstPartOfCurve" => $AdjMaxTurnsForFirstPartOfCurve,
               "torqueSafetyFactor" => $torqueSafetyFactor,
               "AdjSlopeSecondPartOfCurve" => $AdjSlopeSecondPartOfCurve,
               "AdjyInterceptSecondPartOfCurve" => $AdjyInterceptSecondPartOfCurve,
               "AdjMaxTurnsForSecondPartOfCurve" => $AdjMaxTurnsForSecondPartOfCurve,
               "turnsActiveCableLength" => $turnsActiveCableLength,
               "maxFullLayersFromTurnsR" => $maxFullLayersFromTurnsR,
               "extraWrapsAfterFullLayersTurnsR" => $extraWrapsAfterFullLayersTurnsR,
               "extraWrapsAfterFullLayersTurnsI" => $extraWrapsAfterFullLayersTurnsI,
               "availSpringTurns" => $torqueCalcs['availSpringTurns'],
               "turnsMaximumCableLength" => $torqueCalcs['turnsMaximumCableLength'],
               "validTurns" => $validTurns,
               "validCompartment" => $validCompartment,
               "AdjMaxTurnsForThirdPartOfCurve" => $AdjMaxTurnsForThirdPartOfCurve,
               "AdjyInterceptThirdPartOfCurve" => $AdjyInterceptThirdPartOfCurve,
               "AdjSlopeThirdPartOfCurve" => $AdjSlopeThirdPartOfCurve,
               "TWLC" => $reelInertiaCalcs['totalWeightLessCable'],
               "SWC" => $spoolWidthCode,
               "invalidReason" => 0,
               "hosewgtboth" => $hoseWgtboth,
               "rmoti" => $this->rmoti,
               "tqsiz" => $this->tqsiz,
               "torqueFromMotor" => $this->torqueFromMotor,
               "reelWidthInp" => $reelWidthInp
           );
            //dump($initialCalcs);
            //Debugbar::info("Ran through initialCalcs");
            return $initialCalcs;
        }
    
    private function calcInertia($srchStyle, $frameSize, $drumSize, $adjustedTorque, $springFamilyIndex, $wrapperWidthR, $srchSpoolMethod, $c) {

        Debugbar::info($c["hoseIDCode"]);
        $diskInertia = 0; $wrapperInertia = 0; $reelWidth = 0;
        switch ($srchStyle) {
            case 'S':
            case 'SM':
            case 'MMD':
                switch ($frameSize) {
                    case 14:
                        $diskInertia = 1.82;
                        $wrapperInertia = 0.41 * pow($drumSize / 24, 2) * 4;
                        break;
                    case 16:
                        $diskInertia = 3.09;
                        $wrapperInertia = 0.5 * pow($drumSize / 24, 2) * 4;
                        break;
                    case 18:
                        $diskInertia = 4.98;
                        if ($drumSize <= 14) {
                            $wrapperInertia = 0.5 * pow($drumSize / 24, 2) * 4;
                        } else {
                            $wrapperInertia = 0.5 * pow($drumSize / 24, 2) * 8;
                        }
                        break;
                    case 21:
                        $diskInertia = 9.19;
                        if ($drumSize <= 14) {
                            $wrapperInertia = 0.5 * pow($drumSize / 24, 2) * 4;
                        } else {
                            $wrapperInertia = 0.5 * pow($drumSize / 24, 2) * 8;
                        }
                        break;
                    case 24:
                        $diskInertia = 15.75;
                        if ($drumSize <= 14) {
                            $wrapperInertia = 0.5 * pow($drumSize / 24, 2) * 4;
                        } else {
                            $wrapperInertia = 0.5 * pow($drumSize / 24, 2) * 8;
                        }
                        break;
                    case 28:
                        $diskInertia = 29.13;
                        if ($drumSize <= 14) {
                            $wrapperInertia = 0.67 * pow($drumSize / 24, 2) * 4;
                        } else {
                            $wrapperInertia = 0.67 * pow($drumSize / 24, 2) * 8;
                        }
                        break;
                    case 32:
                        $diskInertia = 49.6;
                        if ($drumSize <= 14) {
                            $wrapperInertia = 0.67 * pow($drumSize / 24, 2) * 4;
                        } else {
                            $wrapperInertia = 0.67 * pow($drumSize / 24, 2) * 8;
                        }
                        break;
                }
                $shaftInertia = 0.1;
                $reelInertia = $diskInertia + $wrapperInertia + $shaftInertia;
                $reelInertiaCalcs = array(
                    'reelInertia' => $reelInertia,
                    'totalWeightLessCable' => 0
                );

                break;
            case 'SHO':
            case 'TMR':
                $shaftInertia = 5.95;
                $shaftWeight = 7.62;
                $flangeInertia = 910.4;
                $flangeWeight = 28.45;
                $wrapperWeight = 2 * pi() * ($drumSize / 2) * $wrapperWidthR * .1196 * .283;
                $wrapperInertia = $wrapperWeight * pow(($drumSize / 2), 2);
                if ($srchSpoolMethod == "random" && $frameSize == 54) {
                    goto LINE257;
                }
                if ($srchSpoolMethod == "monospiral") {
                    goto LINE257;
                }
                $diskWeight = pi() * (pow(($frameSize / 2), 2) - pow((12 / 2), 2)) * .1196 * .283;
                $diskInertia = 2 * .5 * $diskWeight * (pow(($frameSize / 2), 2) + pow((12 / 2), 2));
                $reinforceWeight = 2 * pi() * ($frameSize / 2) * .07;
                $reinforceInertia = 2 * ($reinforceWeight * pow(($frameSize / 2), 2));

                $totalWeightLessCable = $shaftWeight + $flangeWeight + 2 * $diskWeight + 2 * $reinforceWeight + $wrapperWeight;
                $totalInertia = $diskInertia + $wrapperInertia + $shaftInertia + $flangeInertia + $reinforceInertia;
                $reelInertia = $totalInertia / 144;
                $reelInertiaCalcs = array(
                    'reelInertia' => $reelInertia,
                    'totalWeightLessCable' => $totalWeightLessCable
                );


                return $reelInertiaCalcs;
                LINE257:
                $spokeWeightPerInch = .12;
                $rimWeightPerInch = .12;
                $rimHeight = 1;
                $spokeWeight = ($frameSize - 2 * $rimHeight) * $spokeWeightPerInch;
                $spokeInertia = 2 * 4 * .083 * $spokeWeight * pow(($frameSize - 2 * $rimHeight), 2);

                $rimWeight = 2 * pi() * ($frameSize / 2 - $rimHeight) * $rimWeightPerInch;
                $rimInertia = 2 * $rimHeight * pow(($frameSize / 2 - $rimHeight), 2);

                $totalWeightLessCable = $shaftWeight + $flangeWeight + 8 * $spokeWeight + 2 * $rimWeight + $wrapperWeight;
                $totalInertia = 2 * $rimWeight * pow(($frameSize / 2 - $rimHeight), 2);
                $reelInertia = $totalInertia / 144;
                $reelInertiaCalcs = array(
                    'reelInertia' => $reelInertia,
                    'totalWeightLessCable' => $totalWeightLessCable
                );
                break;
            case "K":
                switch ($frameSize) {
                    case "14":
                        $diskInertia = 1.82;
                        break;
                    case "16":
                        $diskInertia = 3.09;
                        break;
                    case "18":
                        $diskInertia = 4.98;
                        break;
                    case "21":
                        $diskInertia = 9.19;
                        break;
                    case "24":
                        $diskInertia = 15.75;
                        break;
                    case "28":
                        $diskInertia = 29.13;
                        break;
                    case "32":
                        $diskInertia = 49.6;
                        break;
                }

                switch ($c["hoseIDCode"]) {
                    case "4":
                        $wrapperInertia = .06;
                        break;
                    case "6":
                        $wrapperInertia = .09;
                        break;
                    case "8":
                        $wrapperInertia = .11;
                        break;
                    case "12":
                        $wrapperInertia = .58;
                        break;

                }
                $shaftInertia = 0.1;
                $reelInertia = $diskInertia + $wrapperInertia + $shaftInertia;
                $reelInertiaCalcs = array(
                    'reelInertia' => $reelInertia,
                    'totalWeightLessCable' => 0
                );
                break;
            case "U":
                $wrapperInertia = (($reelWidth / 12) * 1.478) * pow(($drumSize / 24), 2);
                switch ($drumSize){
                    case ($drumSize < 14):
                        $wrapperInertia = $wrapperInertia * 4;
                        break;
                    case ($drumSize < 20):
                        $wrapperInertia = $wrapperInertia * 8;
                        break;
                    default:
                        $wrapperInertia = $wrapperInertia * 12;
                        break;
                }

                switch ($frameSize){
                    case 14:
                        $diskInertia = 1.82;
                        break;
                    case 16:
                        $diskInertia = 3.09;
                        break;
                    case 18:
                        $diskInertia = 4.98;
                        break;
                    case 21:
                        $diskInertia = 9.19;
                        break;
                    case 24:
                        $diskInertia = 15.75;
                        break;
                    case 28:
                        $diskInertia = 29.13;
                        break;
                    case 32:
                        $diskInertia = 49.6;
                        break;
                }
                $shaftInertia = 0.1;
                $reelInertia = $diskInertia + $wrapperInertia + $shaftInertia;

                $reelInertiaCalcs = array(
                    'reelInertia' => $reelInertia,
                    'totalWeightLessCable' => 0,
                    'diskInertia' => $diskInertia,
                    'wrapperInertia' => $wrapperInertia
                );
                break;
        }

        //      $shaftInertia = 0.1;
        //      $reelInertia = $diskInertia + $wrapperInertia + $shaftInertia;


        return $reelInertiaCalcs;
    }

    private function calcTorque($springSize, $springData, $turnsUsedPercent, $gearRatio, $pretensionTurns, $maxWrapsPerLayerR, $cableThick, $drumSize, $deadWrapLength, $compartmentActiveCableLength, $maxUsableWrapsR) {

        $maxSpringTurns = $springData['maxSpringTurns'];
        $maxTurnsForFirstPartOfCurve = $springData['maxTurnsForFirstPartOfCurve'];
        $slopeFirstPartOfCurve = $springData['slopeFirstPartOfCurve'];
        $yInterceptFirstPartOfCurve = $springData['yInterceptFirstPartOfCurve'];

        $maxTurnsForSecondPartOfCurve = $springData['maxTurnsForSecondPartOfCurve'];
        $slopeSecondPartOfCurve = $springData['slopeSecondPartOfCurve'];
        $yInterceptSecondPartOfCurve = $springData['yInterceptSecondPartOfCurve'];

        $maxTurnsForThirdPartOfCurve = $springData['maxTurnsForThirdPartOfCurve'];
        $slopeThirdPartOfCurve = $springData['slopeThirdPartOfCurve'];
        $yInterceptThirdPartOfCurve = $springData['yInterceptThirdPartOfCurve'];


        if ($springSize >= 351 && $springSize <= 354) {
            $numberOfSpringsI = $springSize - 350;
            $springFamilyIndex = 1;
        } else {
            if ($springSize >= 601 && $springSize <= 604) {
                $numberOfSpringsI = $springSize - 600;
                $springFamilyIndex = 2;
            } else {
                if ($springSize >= 621 && $springSize <= 624) {
                    $numberOfSpringsI = $springSize - 620;
                    $springFamilyIndex = 3;
                } else {
                    if ($springSize >= 751 && $springSize <= 754) {
                        $numberOfSpringsI = $springSize - 750;
                        $springFamilyIndex = 4;
                    } else {
                        if ($springSize >= 801 && $springSize <= 804) {
                            $numberOfSpringsI = $springSize - 800;
                            $springFamilyIndex = 5;
                        } else {
                            if ($springSize >= 1001 && $springSize <= 1008) {
                                $numberOfSpringsI = $springSize - 1000;
                                $springFamilyIndex = 6;
                            }
                        }
                    }
                }
            }
        }


        // calculate torque based on first part of spring torque curve
        $availSpringTurns = $maxSpringTurns[$springFamilyIndex] * ($turnsUsedPercent / 100);

        $numberOfSpringsR = $numberOfSpringsI;

        $tempTorqueCalc = $slopeFirstPartOfCurve[$springFamilyIndex] * $availSpringTurns + $yInterceptFirstPartOfCurve[$springFamilyIndex];

        // Calculate torque based on third part of spring torque curve
        if (($availSpringTurns <= $maxTurnsForFirstPartOfCurve[$springFamilyIndex])) {
            goto LINE50;
        }


        $tempTorqueCalc = $slopeSecondPartOfCurve[$springFamilyIndex] * $availSpringTurns + $yInterceptSecondPartOfCurve[$springFamilyIndex];


        if (($availSpringTurns <= $maxTurnsForSecondPartOfCurve[$springFamilyIndex])) {
            goto LINE50;
        }

        $tempTorqueCalc = $slopeThirdPartOfCurve[$springFamilyIndex] * $availSpringTurns + $yInterceptThirdPartOfCurve[$springFamilyIndex];


        LINE50:

        $springTurnsAvailForReeling = $availSpringTurns * $gearRatio;
        $springTorqueAvailForReeling = $tempTorqueCalc * $numberOfSpringsR / $gearRatio;


        //$springTorqueAvailAfterPretensionR = $tempTorqueCalc * $springTurnsAvailPretensionR / $gearRatio;

        /*
    The following code calculates how much cable can be handled by
    the number available turns of a given spring configuration...
    */
        //    $gearRatio = $gearRatio;


        $springTurnsAvailAfterPretensionR = $springTurnsAvailForReeling + 1 - ($gearRatio * $pretensionTurns);
        $springTurnsAvailAfterPretensionI = intval($springTurnsAvailAfterPretensionR);

        $springTurnsAvailAfterPretensionR = $springTurnsAvailAfterPretensionI;


        $maxFullLayersFromTurnsR = $springTurnsAvailAfterPretensionR / $maxWrapsPerLayerR;

        $maxFullLayersFromTurnsI = intval($maxFullLayersFromTurnsR);

        $maxFullLayersFromTurnsR = $maxFullLayersFromTurnsI;

        $extraWrapsAfterFullLayersTurnsR = $springTurnsAvailAfterPretensionR - ($maxWrapsPerLayerR * $maxFullLayersFromTurnsR);
        $extraWrapsAfterFullLayersTurnsI = intval($extraWrapsAfterFullLayersTurnsR);

        $pi = 3.14159;//pi();

        $turnsMaximumCableLength = (($drumSize + $maxFullLayersFromTurnsR * $cableThick) * $pi / 12 * $maxWrapsPerLayerR * $maxFullLayersFromTurnsR) + (($drumSize + ((2 * $maxFullLayersFromTurnsR + 1) * $cableThick)) * $pi / 12 * $extraWrapsAfterFullLayersTurnsR);
        $turnsActiveCableLength = $turnsMaximumCableLength - $deadWrapLength;

        // Calculates new torque curve based on gear ratio and number of springs

        $ADJMaxTurnsForFirstPartOfCurve = $maxTurnsForFirstPartOfCurve[$springFamilyIndex] * $gearRatio;
        $ADJslopeFirstPartOfCurve = $slopeFirstPartOfCurve[$springFamilyIndex] * $numberOfSpringsR / ($gearRatio * $gearRatio);

        $ADJYInterceptFirstPartOfCurve = $yInterceptFirstPartOfCurve[$springFamilyIndex] * $numberOfSpringsR / $gearRatio;


        $ADJMaxTurnsForSecondPartOfCurve = $maxTurnsForSecondPartOfCurve[$springFamilyIndex] * $gearRatio;
        $ADJSlopeSecondPartOfCurve = $slopeSecondPartOfCurve[$springFamilyIndex] * $numberOfSpringsR / ($gearRatio * $gearRatio);
        $ADJYInterceptSecondPartOfCurve = $yInterceptSecondPartOfCurve[$springFamilyIndex] * $numberOfSpringsR / $gearRatio;

        $AdjMaxTurnsForThirdPartOfCurve = $maxTurnsForThirdPartOfCurve[$springFamilyIndex] * $gearRatio;
        $AdjSlopeThirdPartOfCurve = $slopeThirdPartOfCurve[$springFamilyIndex] * $numberOfSpringsR / ($gearRatio * $gearRatio);
        $AdjyInterceptThirdPartOfCurve = $yInterceptThirdPartOfCurve[$springFamilyIndex] * $numberOfSpringsR / $gearRatio;
        $adjustedTorque = $springTorqueAvailForReeling;


        if ($compartmentActiveCableLength < $turnsActiveCableLength) {
            $tempTurns = ($gearRatio * $pretensionTurns) + $maxUsableWrapsR - 1;
            $adjustedTorque = $ADJslopeFirstPartOfCurve * $tempTurns + $ADJYInterceptFirstPartOfCurve;

            if ($tempTurns > $ADJMaxTurnsForFirstPartOfCurve) {
                $adjustedTorque = $ADJSlopeSecondPartOfCurve * $tempTurns + $ADJYInterceptSecondPartOfCurve;
                if ($tempTurns > $ADJMaxTurnsForSecondPartOfCurve) {
                    $adjustedTorque = $AdjSlopeThirdPartOfCurve * $tempTurns + $AdjyInterceptThirdPartOfCurve;
                }

            }
        }


        $torqueCalcs = array(
            'turnsActiveCableLength' => $turnsActiveCableLength,
            'availSpringTurns' => $availSpringTurns,
            'springFamilyIndex' => $springFamilyIndex,
            'adjustedTorque' => $adjustedTorque,
            'springTurnsAvailAfterPretensionR' => $springTurnsAvailAfterPretensionR,
            'adjSlopeFirstPartOfCurve' => $ADJslopeFirstPartOfCurve,
            'AdjyInterceptFirstPartOfCurve' => $ADJYInterceptFirstPartOfCurve,
            'AdjMaxTurnsForFirstPartOfCurve' => $ADJMaxTurnsForFirstPartOfCurve,
            'AdjSlopeSecondPartOfCurve' => $ADJSlopeSecondPartOfCurve,
            'AdjyInterceptSecondPartOfCurve' => $ADJYInterceptSecondPartOfCurve,
            'AdjMaxTurnsForSecondPartOfCurve' => $ADJMaxTurnsForSecondPartOfCurve,
            'maxFullLayersFromTurnsR' => $maxFullLayersFromTurnsR,
            'extraWrapsAfterFullLayersTurnsI' => $extraWrapsAfterFullLayersTurnsI,
            'extraWrapsAfterFullLayersTurnsR' => $extraWrapsAfterFullLayersTurnsR,
            'turnsMaximumCableLength' => $turnsMaximumCableLength,
            'AdjSlopeThirdPartOfCurve' => $AdjSlopeThirdPartOfCurve,
            'AdjMaxTurnsForThirdPartOfCurve' => $AdjMaxTurnsForThirdPartOfCurve,
            'AdjyInterceptThirdPartOfCurve' => $AdjyInterceptThirdPartOfCurve
        );


        return $torqueCalcs;

    }

     private function calcCollectorCode($cable, $appType) {

        $qtyConductorsLessGrndchk = intval($cable['cond']) + intval($cable['ground']);
        $collectorCode = null;


        if ($appType == 'magnet') {
            $collectorAmp = 200;
            $collectorCode = '220';
            $numCollectorConductors = 2;

            $collector = array(
                'collectorCode' => $collectorCode,
                'collectorAmp' => $collectorAmp,
                'numCollectorConductors' => $numCollectorConductors,
                'qtyConductorsLessGrndchk' => $qtyConductorsLessGrndchk
            );

            return $collector;
        }

        //$metricDefault = $this->metricDefault;
        $metricDefault = false;
        Debugbar::info("metricDefault: " . $metricDefault);

        switch ($metricDefault) {
            case false:
                switch ($cable['awg']) {
                    case '18':
                    case '16':
                    case '14':
                    case '12':
                    case '10':
                        $collectorAmp = 35;
                        break;
                    case '8':
                    case '6':
                        $collectorAmp = 75;
                        break;
                    case '4':
                    case '3':
                    case '2':
                        $collectorAmp = 125;
                        break;
                    case '1':
                    case '1/0':
                        $collectorAmp = 200;
                        break;
                    case '2/0':
                        $collectorAmp = 400;
                        break;
                    case '3/0':
                    case '4/0':
                    case '250':
                    case '300':
                    case '400':
                    case '450':
                    case '500':
                        $collectorCode = 'Bad';
                        return;
                        break;
                }
                break;
            case true:
                $awg = intval($cable['awg']);
                if($awg < 8){
                    $collectorAmp = 35;
                }else if($awg < 17){
                    $collectorAmp = 75;
                }else if($awg < 35){
                    $collectorAmp = 125;
                }else if($awg < 55){
                    $collectorAmp = 200;
                }else if($awg < 70){
                    $collectorAmp = 400;
                }else{
                    $collectorCode = 'Bad';
                    return;
                }
                break;
        }
       $cableTypeProperty = $this->getGRNDqty($cable['type']);
        Debugbar::info("collectorAmp: " . $collectorAmp);

        switch ($collectorAmp) {
            case 35:
                $g = intval($qtyConductorsLessGrndchk) + intval($cableTypeProperty['grndchkQty']);//TODO $grndchkQty -- import
                if ($g > 36) {
                    $collectorCode = 'Bad';
                    break;
                }
                if ($g > 30 && $g <= 36) {
                    $collectorCode = '363';
                    $numCollectorConductors = 36;
                    break;
                }
                if ($g > 24 && $g <= 30) {
                    $collectorCode = '303';
                    $numCollectorConductors = 30;
                    break;
                }
                if ($g > 20 && $g <= 24) {
                    $collectorCode = '243';
                    $numCollectorConductors = 24;
                    break;
                }
                if ($g > 16 && $g <= 20) {
                    $collectorCode = '203';
                    $numCollectorConductors = 20;
                    break;
                }
                if ($g > 14 && $g <= 16) {
                    $collectorCode = '163';
                    $numCollectorConductors = 16;
                    break;
                }
                if ($g > 12 && $g <= 14) {
                    $collectorCode = '143';
                    $numCollectorConductors = 14;
                    break;
                }
                if ($g > 10 && $g <= 12) {
                    $collectorCode = '123';
                    $numCollectorConductors = 12;
                    break;
                }
                if ($g > 8 && $g <= 10) {
                    $collectorCode = '103';
                    $numCollectorConductors = 10;
                    break;
                }
                if ($g > 6 && $g <= 8) {
                    $collectorCode = '83';
                    $numCollectorConductors = 8;
                    break;
                }
                if ($g > 4 && $g <= 6) {
                    $collectorCode = '63';
                    $numCollectorConductors = 6;
                    break;
                }
                if ($g > 3 && $g <= 4) {
                    $collectorCode = '43';
                    $numCollectorConductors = 4;
                    break;
                }
                if ($g > 2 && $g <= 3) {
                    $collectorCode = '33';
                    $numCollectorConductors = 3;
                    break;
                }
                if ($g > 0 && $g <= 2) {
                    $collectorCode = '23';
                    $numCollectorConductors = 2;
                    break;
                }
                break;
            case 75:
                $g = $qtyConductorsLessGrndchk;
                if ($g > 8) {
                    $collectorCode = 'Bad';
                    break;
                }

                if ($g > 6 && $g <= 8) {
                    $collectorCode = '87';
                    $numCollectorConductors = 8;
                    break;
                }
                if ($g > 4 && $g <= 6) {
                    $collectorCode = '67';
                    $numCollectorConductors = 6;
                    break;
                }
                if ($g > 3 && $g <= 4) {
                    $collectorCode = '47';
                    $numCollectorConductors = 4;
                    break;
                }
                if ($g > 2 && $g <= 3) {
                    $collectorCode = '37';
                    $numCollectorConductors = 3;
                    break;
                }
                if ($g > 0 && $g <= 2) {
                    $collectorCode = '27';
                    $numCollectorConductors = 2;
                    break;
                }
                break;
            case 125:
                $g = $qtyConductorsLessGrndchk;
                if ($g > 4) {
                    $collectorCode = 'Bad';
                    break;
                }
                if ($g > 3 && $g <= 4) {
                    $collectorCode = '412';
                    $numCollectorConductors = 4;
                    break;
                }
                if ($g > 2 && $g <= 3) {
                    $collectorCode = '312';
                    $numCollectorConductors = 3;
                    break;
                }
                if ($g > 0 && $g <= 2) {
                    $collectorCode = '212';
                    $numCollectorConductors = 2;
                    break;
                }
                break;
            case 200:
                $g = $qtyConductorsLessGrndchk;
                if ($g > 4) {
                    $collectorCode = 'Bad';
                    break;
                }
                if ($g > 3 && $g <= 4) {
                    $collectorCode = '420';
                    $numCollectorConductors = 4;
                    break;
                }
                if ($g > 2 && $g <= 3) {
                    $collectorCode = '320';
                    $numCollectorConductors = 3;
                    break;
                }
                if ($g > 0 && $g <= 2) {
                    $collectorCode = '220';
                    $numCollectorConductors = 2;
                    break;
                }
                break;
            case 400:
                $g = $qtyConductorsLessGrndchk;
                if ($g > 2) {
                    $collectorCode = 'Bad';
                    break;
                }
                if ($g > 0 && $g <= 2) {
                    $collectorCode = '240';
                    $numCollectorConductors = 2;
                    break;
                }
                break;
        }

        if ($cable['grndchck'] == 1 && $collectorAmp > 35 && $collectorCode != 'Bad') {
            $collectorCode .= '-13';
        }

        $collector = array(
            'collectorCode' => $collectorCode,
            'collectorAmp' => $collectorAmp,
            'numCollectorConductors' => $numCollectorConductors,
            'qtyConductorsLessGrndchk' => $qtyConductorsLessGrndchk
        );

        return $collector;
    }

    private function getGrndQty($cableType) {
        switch ($cableType) {
            case 'G':
                $grndQty = 1;
                $grndchkQty = 0;
                break;
            case 'HV':
            case 'GGC':
                $grndQty = 1;
                $grndchkQty = 1;
                break;
            default:
                $grndQty = 0;
                $grndchkQty = 0;
        }

        $grnd = array(
            'grndQty' => $grndQty,
            'grndchkQty' => $grndchkQty
        );

        return $grnd;
    }


    private function doInitialCMCalcs($srchStyle, $srchFrame, $cable, $pretensionTurns, $application, $modelIndex, $specificInput, $maxTurnsFromSpring, $turnsUsedPercent, $cableOrHose, $srchColl, $srchSpring) {

        $cableThick = $cable["thickness"];

        $cableCF = intval($application['ccf']);
        $travelInFt = intval($application['activeTravel']);
        $deadWraps = intval($application['deadWraps']);

        $drumSize = 0;
        $metricDefault = false; // false for now.

        $torqueToOvercomeCollectorFriction = 0; $WrapperWidthR = 0; $frameSize = 0; $index = 0; $iyfin = 0; $circ = 0;
        $torqueSafetyFactor = 0; $spoolWeight = 0; $coefficient = 0; $reelInertia = 0;

        $validTurns = false;
        $validCompartment = false;

        if ($cableCF == 0) {
            $cableClearenceFactor = 1;
        } else {
            $cableClearenceFactor = $cableCF;
        }

        $gearRatio = 1.0;


        switch ($srchFrame) {
            case "14":
                $frameSize = 13.75;
                $drumSize = 7;
                $WrapperWidthR = 3;
                $spoolWeight = 27.3;
                $coefficient = 0.16;
                break;
            case "16":
                $frameSize = 15.75;
                $drumSize = 7;
                $WrapperWidthR = 3.5;
                $spoolWeight = 52.8;
                $coefficient = 0.16;
                break;
            case "19":
                $frameSize = 19.0;
                $drumSize = 10.5;
                $WrapperWidthR = 4;
                $spoolWeight = 59.6;
                $coefficient = 0.025;
                break;
        }
        $maxWrapsPerLayerR = $WrapperWidthR / $cableThick;
        $maxWrapsPerLayerR = floatval(number_format($maxWrapsPerLayerR, 6));

        $maxWrapsPerLayerI = intval($maxWrapsPerLayerR);
        $maxWrapsPerLayerR = $maxWrapsPerLayerI;

        $maxCableLayersR = ($frameSize - $drumSize) / (2.0 * $cableThick);

        $maxCableLayersI = intval($maxCableLayersR);

        $maxUsableLayersR = $maxCableLayersR - $cableClearenceFactor;

        $maxUsableLayersI = intval($maxUsableLayersR);

        $maxUsableLayersR = $maxUsableLayersI;

        $clrmin = (($frameSize - $drumSize) / 2.0) - ($maxCableLayersI * $cableThick);


        $ec = $maxWrapsPerLayerR * ($clrmin / $cableThick);
        if ($cableThick > 1) {
            $ec = 0;
        }
        $iec = intval($ec);
        $ec = $iec;


        /*
         * Calculates cable that can be physically placed in compartment
         */
        $compartmentHeight = ($frameSize - $drumSize) / 2.0;


        $ixarr = array();
        $wrap = array();
        $row = array();

        for ($a = 1; $a <= 50; $a++) {
            $ixarr[$a] = $maxWrapsPerLayerI;
            $wrap[$a] = 0;
            $row[$a] = 0;

        }


        $ixarr[1] = $ixarr[1] - $deadWraps;

        $ratio = ($WrapperWidthR - $maxWrapsPerLayerR * $cableThick) / $cableThick;



        if ($ratio < 0.52) {
            goto LINE350;
        }

        if ($ratio >= 0.52 && $ratio < 0.64) {
            $index = 1;
        }
        if ($ratio >= 0.64 && $ratio < 0.76) {
            $index = 2;
        }
        if ($ratio >= 0.76 && $ratio < 0.88) {
            $index = 3;
        }
        if ($ratio >= 0.88) {
            $index = 4;
        }


        $iquot = intval($maxUsableLayersI / 5);


        $irem = $maxUsableLayersI - $iquot * 5;


        if ($irem <= 1) {
            $irem = 1;
        }
        $x = $this->jxcorr($irem, $index);
        $z = $this->jxcorr(5, $index);
        $ixcorr = $this->jxcorr($irem, $index) + $iquot * $this->jxcorr(5, $index);


        $ixst = $maxUsableLayersI / 2 - $ixcorr / 2 + 1;
        $ixst = number_format($ixst, 0);


        if ($ixst < 1) {
            $ixst = 1;
        }

        $ixfin = $ixst + $ixcorr - 1;


        if ($cableThick > 1) {
            goto LINE350;
        }

        for ($a = $ixst; $a <= $ixfin; $a++) {

            $ixarr[$a] = $ixarr[$a] + 1;

        }

        LINE350:
        $itmax = 0;
        $rlen = 0;
        for ($a = 1; $a <= 50; $a++) {
            $xact = $ixarr[$a];
            $yind = $a;
            $wrap[$a] = ($drumSize + (2.0 * $yind - 1) * $cableThick) * 3.14159 / 12; //Replace pi()
            $wrap[$a] = floatval(number_format($wrap[$a], 6));
            $row[$a] = $xact * $wrap[$a];

        }
        for ($a = 1; $a <= $maxUsableLayersI; $a++) {
            $itmax = $itmax + $ixarr[$a];
            $rlen = $rlen + $row[$a];

        }
        LINE400:
        if ($cableClearenceFactor >= 1) {
            goto LINE410;
        }
        $a = $maxUsableLayersI + 1;
        $itmax = $itmax + $ixarr[$a];
        $rlen = $rlen + $row[$a];

        goto LINE415;

        LINE410:
        $a = $maxUsableLayersI + 1;
        $yind = $a;
        $wrapec = ($drumSize + (2.0 * $yind - 1.0) * $cableThick) * 3.14159 / 12;
        $wrapec = floatval(number_format($wrapec, 6));


        $rowec = $ec * $wrapec;
        $rowec = floatval(number_format($rowec, 6));

        $itmax = $itmax + $ec;

        $rlen = $rlen + $rowec;
        $rlen = floatval(number_format($rlen, 4));

        LINE415:
        if ($ec > 0 || $cableClearenceFactor >= 1) {
            $maxUsableLayersR = $maxUsableLayersR + 1;
        }
        $maxUsableLayersI = $maxUsableLayersR;

        $compartmentActiveCableLength = $rlen;
        $maxUsableWrapsR = $itmax;


        if ($compartmentActiveCableLength < $travelInFt) {
            //todo: find out if [$modelIndex] portion is required, if so go through and add it to the relevant switch statements
            $specificInput = false;
            switch ($specificInput) {
                case false://todo: Implement a class InvalidReels with properties modelNo and reason. Instantiate it for every invalid reel
                    $initialCMCalcs = array(
                        "validTurns" => false,
                        "validCompartment" => false,
                        "invalidReason" => 1
                    );
                    return $initialCMCalcs;
                    break;
                case true:
                    $invalidWarning = true;
                    break;
            }
        }
        if ($compartmentActiveCableLength < $travelInFt) {
            $invalidWarning = true;
        }

        $validCompartment = true;

        /*
        * The following code calculates how much cable can be handled by
        * the number available turns of a given spring configuration...
        */

        $springTurnsAvailForReeling = intval($maxTurnsFromSpring) * ($turnsUsedPercent / 100);
        $springTurnsAvailAfterPretensionR = $springTurnsAvailForReeling - $pretensionTurns;
        $springTurnsAvailAfterPretensionI = intval($springTurnsAvailAfterPretensionR);
        $springTurnsAvailAfterPretensionR = $springTurnsAvailAfterPretensionI;


        $itemp = $springTurnsAvailAfterPretensionI;

        $turnsMaximumCableLength = 0;

        for ($a = 1; $a <= 50; $a++) {
            $iyfin = $a;
            if ($itemp < $ixarr[$a]) {
                goto LINE422;
            }

            $itemp = $itemp - $ixarr[$a];

            $turnsMaximumCableLength = $turnsMaximumCableLength + $row[$a];
        }

        LINE422:
        $a = $iyfin;
        $et = $itemp;
        $turnsMaximumCableLength = $turnsMaximumCableLength + $et * $wrap[$a];

        $turnsActiveCableLength = $turnsMaximumCableLength;

        $maxFullLayersFromTurnsR = $iyfin;

        if ($et == 0) {
            $maxFullLayersFromTurnsR = $iyfin - 1;
        }

        if ($turnsActiveCableLength < $travelInFt) {
            $specificInput = false;
            switch ($specificInput) {
                case false://todo: create invalidStore() to store invalid reels
                    $initialCMCalcs = array(
                        "validTurns" => false,
                        "validCompartment" => false,
                        "invalidReason" => 2
                    );
                    return $initialCMCalcs;
                    break;
                case true:
                    $invalidWarning = true;
                    break;
            }

        }
        if ($turnsActiveCableLength < $travelInFt) {
            $invalidWarning = true;
        }

        /*
         * The following code calculates the collector friction (ft/lbs)
         */

        switch ($cableOrHose) {
            case "HD":
            case "HS":
                switch ($cable['hoseIDCode']) {
                    case "4":
                        $torqueToOvercomeCollectorFriction = 2.5 / 12;
                        break;
                    case "6":
                        $torqueToOvercomeCollectorFriction = 5 / 12;
                        break;
                    case "8":
                        $torqueToOvercomeCollectorFriction = 7.5 / 12;
                        break;
                    case "12":
                        $torqueToOvercomeCollectorFriction = 12.5 / 12;
                        break;
                    case "16":
                        $torqueToOvercomeCollectorFriction = 20 / 12;
                        break;
                    case "20":
                        $torqueToOvercomeCollectorFriction = 50 / 12;
                        break;
                    case "24":
                        $torqueToOvercomeCollectorFriction = 56 / 12;
                        break;
                }
                break;
            default:
                $sCollComp = intval(substr($srchColl, -1));

                switch (substr($srchColl, 0, -2)/*Left Most 1 Character*/) {
                    case "Z":
                    case "A":
                    case "B":
                    case "C":
                    case "D":
                        switch ($sCollComp) {
                            case($sCollComp < 5):
                                $torqueToOvercomeCollectorFriction = 0.42;
                                break;
                            case($sCollComp < 9):
                                $torqueToOvercomeCollectorFriction = 0.67;
                                break;
                            case ($sCollComp >= 9):
                                $torqueToOvercomeCollectorFriction = 0.83;
                                break;
                        }
                        break;
                    case "E":
                    case "F":
                        $torqueToOvercomeCollectorFriction = 0.67;
                        break;
                    case "G":
                    case "H":
                        $torqueToOvercomeCollectorFriction = 0.9;
                        break;
                }
        }
        /*
         * The following code calculates wrapper INERTIA
         */

        switch ($srchFrame) {
            case "14":
                $reelInertia = 3.2;
                break;
            case "16":
                $reelInertia = 10.9;
                break;
            case "19":
                $reelInertia = 13.64;
                break;
        }

        /*
         * The following code assigns a torque safety factor based on cable diameter
         */
        switch ($srchStyle) {
            case "HM":
                switch ($cableThick) {
                    case ($cableThick <= 0.5):
                        $torqueSafetyFactor = 1.2;
                        break;
                    case ($cableThick <= 0.75):
                        if ($drumSize <= 9) {
                            $torqueSafetyFactor = 1.3;
                        }
                        if ($drumSize > 9) {
                            $torqueSafetyFactor = 1.2;
                        }
                        break;
                    case ($cableThick <= 1):
                        if ($drumSize <= 12) {
                            $torqueSafetyFactor = 1.4;
                        }
                        if ($drumSize > 12) {
                            $torqueSafetyFactor = 1.3;
                        }
                        break;
                    case ($cableThick <= 1.25):
                        if ($drumSize <= 15) {
                            $torqueSafetyFactor = 1.5;
                        }
                        if ($drumSize > 15) {
                            $torqueSafetyFactor = 1.4;
                        }
                        break;
                    case ($cableThick <= 1.5):
                        if ($drumSize <= 18) {
                            $torqueSafetyFactor = 1.6;
                        }
                        if ($drumSize > 18) {
                            $torqueSafetyFactor = 1.5;
                        }
                        break;
                    default:
                        if ($drumSize <= 21) {
                            $torqueSafetyFactor = 1.7;
                        }
                        if ($drumSize > 21) {
                            $torqueSafetyFactor = 1.6;
                        }
                        break;
                }
                break;

            default:
                switch ($metricDefault) {
                    case true:
                        $c = intval($cable['awg']);
                        switch ($c) {//select by AWG of cable.
                            case ($c < 0.9):
                                $circ = 1620;
                                break;
                            case ($c < 1.5):
                                $circ = 2580;
                                break;
                            case ($c < 2.5):
                                $circ = 4110;
                                break;
                            case ($c < 3.5):
                                $circ = 6530;
                                break;
                            case ($c < 5.5):
                                $circ = 10400;
                                break;
                            case ($c < 9.0):
                                $circ = 16500;
                                break;
                            default:
                                $circ = 26300;
                                break;
                        }
                        break;
                    case false:
                        $c = intval($cable['awg']);
                        switch ($c) {//select by AWG of cable.
                            case "18":
                                $circ = 1620;
                                break;
                            case "16":
                                $circ = 2580;
                                break;
                            case "14":
                                $circ = 4110;
                                break;
                            case "12":
                                $circ = 6530;
                                break;
                            case "10":
                                $circ = 10400;
                                break;
                            case "8":
                                $circ = 16500;
                                break;
                            default:
                                $circ = 26300;
                                break;
                        }
                }


                $conductorQty = (intval($cable['cond']) + intval($cable['ground'])) + intval($cable['grndchck']);

                //Old VB has this (If Cable(1).style = "C" Or Cable(1).style = "G") but Cable style does not value those values
               if($cable['type'] == "C" || $cable['type'] == "G"){
                   $conductorQty = $conductorQty + 1;
               }

                /*if ($cable['type'] == "GGC" || $cable['type'] == "G") {
                    $conductorQty = $conductorQty + 1;
                }*/

                $testCalc = ($conductorQty * $circ);

                switch ($testCalc) {
                    case ($testCalc <= 10000):
                        $torqueSafetyFactor = 0.25;
                        break;
                    case ($testCalc <= 15000):
                        $torqueSafetyFactor = 0.5;
                        break;
                    case ($testCalc <= 20000):
                        $torqueSafetyFactor = 0.75;
                        break;
                    case ($testCalc <= 30000):
                        $torqueSafetyFactor = 1.0;
                        break;
                    case ($testCalc <= 45000):
                        $torqueSafetyFactor = 1.25;
                        break;
                    case ($testCalc <= 60000):
                        $torqueSafetyFactor = 1.5;
                        break;
                    case ($testCalc <= 75000):
                        $torqueSafetyFactor = 1.75;
                        break;
                    case ($testCalc <= 90000):
                        $torqueSafetyFactor = 2.0;
                        break;
                    default:
                        $torqueSafetyFactor = 2.5;
                }
                break;

        }

        $cbend = 2.0 * $torqueSafetyFactor * $drumSize / 24;
        $cbend = floatval(number_format($cbend, 6));

        $ra = $drumSize / 24;
        $ra = floatval(number_format($ra, 7));

        $momentArm = ($drumSize + 5.0 * $cableThick) / (2.0 * 12.0);
        //$momentArm = floatval(number_format($momentArm, 6));


        /*
         * Calculates torque available from spring
         */
        $springTorqueAvailForReeling = $this->getCMSpringData($springTurnsAvailForReeling, $srchSpring);
        $springTorqueAvailForReeling = floatval(number_format($springTorqueAvailForReeling, 3));


        if ($compartmentActiveCableLength < $turnsActiveCableLength) {
            $tempTurns = ($gearRatio * $pretensionTurns) + $maxUsableWrapsR;

            $springTorqueAvailForReeling = $this->getCMSpringData(intval($tempTurns), $srchSpring);
            $springTorqueAvailForReeling = floatval(number_format($springTorqueAvailForReeling, 3));

        }

        $adjustedTorque = $springTorqueAvailForReeling;

        $validTurns = true;

        $initialCMCalcs = array(
            "compartmentHeight" => $compartmentHeight,
            "reelInertia" => $reelInertia,
            "adjustedTorque" => $adjustedTorque,
            "momentArm" => $momentArm,
            "ra" => $ra,
            "wraparr" => $wrap,
            "ixarr" => $ixarr,
            "cbend" => $cbend,
            "spoolWeight" => $spoolWeight,
            "coefficient" => $coefficient,
            "maxWrapsPerLayerR" => $maxWrapsPerLayerR,
            "maxWrapsPerLayerI" => $maxWrapsPerLayerI,
            "torqueToOvercomeCollectorFriction" => $torqueToOvercomeCollectorFriction,
            "springTurnsAvailAfterPretensionR" => $springTurnsAvailAfterPretensionR,
            "maxUsableWrapsR" => $maxUsableWrapsR,
            "compartmentActiveCableLength" => $compartmentActiveCableLength,
            "maxUsableLayersR" => $maxUsableLayersR,
            "maxUsableLayersI" => $maxUsableLayersI,
            "maxCableLayersR" => $maxCableLayersR,
            "torqueSafetyFactor" => $torqueSafetyFactor,
            "turnsActiveCableLength" => $turnsActiveCableLength,
            "maxFullLayersFromTurnsR" => $maxFullLayersFromTurnsR,
            "validTurns" => $validTurns,
            "validCompartment" => $validCompartment,
            "row" => $row,
            "drumSize" => $drumSize,
            "ec" => $ec,
            "frameSize" => $frameSize,
            "cableClearenceFactor" => $cableClearenceFactor,
            "availSpringTurns" => 0,
            "wrapperWidthR" => $WrapperWidthR,
            "deadWrapLength" => 0,
            "gearRatio" => $gearRatio
        );
        return $initialCMCalcs;
    }

    private function getCMspringData($availableTurns, $srchSpring) {
        $springs = DB::table('cmspring')->where('turncount', '=', $availableTurns)->get();

        $springTorqueAvailForReeling = "";
        if (count($springs) != 0) {
            switch ($srchSpring) {
                case "A":
                case "1":
                    $springTorqueAvailForReeling = $springs[0]->A;
                    break;
                case "B":
                case "2":
                    $springTorqueAvailForReeling = $springs[0]->B;
                    break;
                case "C":
                case "3":
                    $springTorqueAvailForReeling = $springs[0]->C;
                    break;
                case "D":
                case "4":
                    $springTorqueAvailForReeling = $springs[0]->D;
                    break;
                case "E":
                case "5":
                    $springTorqueAvailForReeling = $springs[0]->E;
                    break;
                case "G":
                case "7":
                    $springTorqueAvailForReeling = $springs[0]->G;
                    break;
                case "H":
                case "8":
                    $springTorqueAvailForReeling = $springs[0]->H;
                    break;
                case "J":
                case "10":
                    $springTorqueAvailForReeling = $springs[0]->J;
                    break;
                case "K":
                case "11":
                    $springTorqueAvailForReeling = $springs[0]->K;
                    break;
                case "U":
                    $springTorqueAvailForReeling = $springs[0]->U;
                    break;
                case "V":
                    $springTorqueAvailForReeling = $springs[0]->V;
                    break;

            }
        }

        return $springTorqueAvailForReeling;
    }

    public function jxcorr($a, $b) {
        switch ($a) {
            case 1:
                switch ($b) {
                    case 1:
                        $jxcorr = 0;
                        break;
                    case 2:
                        $jxcorr = 0;
                        break;
                    case 3:
                        $jxcorr = 0;
                        break;
                    case 4:
                        $jxcorr = 0;
                        break;
                }
                break;
            case 2:
                switch ($b) {
                    case 1:
                        $jxcorr = 0;
                        break;
                    case 2:
                        $jxcorr = 0;
                        break;
                    case 3:
                        $jxcorr = 1;
                        break;
                    case 4:
                        $jxcorr = 1;
                        break;
                }
                break;
            case 3:
                switch ($b) {
                    case 1:
                        $jxcorr = 0;
                        break;
                    case 2:
                        $jxcorr = 1;
                        break;
                    case 3:
                        $jxcorr = 1;
                        break;
                    case 4:
                        $jxcorr = 2;
                        break;
                }
                break;
            case 4:
                switch ($b) {
                    case 1:
                        $jxcorr = 0;
                        break;
                    case 2:
                        $jxcorr = 1;
                        break;
                    case 3:
                        $jxcorr = 2;
                        break;
                    case 4:
                        $jxcorr = 3;
                        break;
                }
                break;
            case 5:
                switch ($b) {
                    case 1:
                        $jxcorr = 1;
                        break;
                    case 2:
                        $jxcorr = 2;
                        break;
                    case 3:
                        $jxcorr = 3;
                        break;
                    case 4:
                        $jxcorr = 4;
                        break;
                }
                break;
        }
        return $jxcorr;
    }

    private function checkDrumSize($srchStyle, $srchFrame, $ccf, $cableThick, $srchDrummax, $srchColl, $srchSpring) { // this should work.
        $validDrumMax = 0;

        switch ($srchStyle) {
            case 'SHO':
            case 'TMR':
                $validDrumMax = $srchFrame - ((1 + $ccf) * 2 * $cableThick);

                $validDrumMax = round($validDrumMax, 0);

                if ($validDrumMax % 2 != 0) {
                    $validDrumMax = $validDrumMax - 1;
                }

                switch ($srchFrame) {
                    case "30":
                        if ($validDrumMax > 24) {
                            $validDrumMax = 24;
                        }
                        break;
                    case "36":
                        if ($validDrumMax > 30) {
                            $validDrumMax = 30;
                        }
                        break;
                    case "42":
                        if ($validDrumMax > 36) {
                            $validDrumMax = 36;
                        }
                        break;
                    case "48":
                        if ($validDrumMax > 42) {
                            $validDrumMax = 42;
                        }
                        break;
                    default:
                        if ($validDrumMax > 48) {
                            $validDrumMax = 48;
                        }
                }

                break;
            case 'S':
            case 'SM':
            case 'MMD':
            case 'P':
                // cableClearanceFactor and cableThick need to be looked up
                $validDrumMax = $srchFrame - ((1 + $ccf) * 2 * $cableThick);
                $validDrumMax = round($validDrumMax);


            switch ($srchFrame) {
                    case '14':
                        if ($validDrumMax > 10) {
                            $validDrumMax = 10;
                        }
                        break;
                    case '16':
                        if ($validDrumMax > 12) {
                            $validDrumMax = 12;
                        }
                        break;
                    case '18':
                        if ($validDrumMax > 14) {
                            $validDrumMax = 14;
                        }
                        break;
                    case '21':
                        if ($validDrumMax > 17) {
                            $validDrumMax = 17;
                        }
                        break;
                    case '24':
                        if ($validDrumMax > 20) {
                            $validDrumMax = 20;
                        }
                        break;
                    case '28':
                        if ($validDrumMax > 24) {
                            $validDrumMax = 24;
                        }
                        break;
                    case '32':
                        if ($validDrumMax > 28) {
                            $validDrumMax = 28;
                        }
                        break;
                }
                break;
            case 'U':
                $validDrumMax = $srchFrame - ((1 + $ccf) * 2 * $cableThick);

                $validDrumMax = round($validDrumMax);

                if(($validDrumMax/2) != intval($validDrumMax/2)){
                    $validDrumMax = $validDrumMax + 1;
                }

                switch ($srchFrame) {
                    case '18':
                        if($validDrumMax > 14){
                            $validDrumMax = 14;
                        }
                        break;
                    case '21':
                        if($validDrumMax > 17){
                            $validDrumMax = 16;
                        }
                        break;
                    case '24':
                        if($validDrumMax > 20){
                            $validDrumMax = 18;
                        }
                        break;
                    case '28':
                        if($validDrumMax > 24){
                            $validDrumMax = 22;
                        }
                        break;
                    case '32':
                        if($validDrumMax > 28){
                            $validDrumMax = 26;
                        }
                        break;
                }
                break;
        }

        if ($srchDrummax < $validDrumMax) {
            $validDrumMax = $srchDrummax;
        }

        return $validDrumMax;
    }

    private function checkPretensTurns($springTurns, $srchStyle, $srchSpring, $srchPremax) {
        //todo make sure all reels accounted for.
        $maxTurnsFromSpring = 0;
        $turnsUsedPercent = 0;
        if ($springTurns == 0) {
            switch ($srchStyle) {
                case "S":
                case "SHO":
                case "C":
                case "U":
                case "K":
                case "HM":
                    $turnsUsedPercent = 100;
                    break;
                case "SM":
                    $turnsUsedPercent = 66;
                    break;
                case "MMD":
                    $turnsUsedPercent = 80;
                    break;
            }//End of switch statement
        } else {
            $turnsUsedPercent = $springTurns;
        }

        switch ($srchStyle) {
            case 'C':
            case 'HM':
                switch ($srchSpring) {
                    case "A":
                    case "1":
                        $validPretensMax = 16 * ($turnsUsedPercent / 100);
                        break;
                    case "B":
                    case "2":
                        $validPretensMax = 19 * ($turnsUsedPercent / 100);
                        break;
                    case "C":
                    case "3":
                        $validPretensMax = 24 * ($turnsUsedPercent / 100);
                        break;
                    case "D":
                    case "4":
                        $validPretensMax = 26 * ($turnsUsedPercent / 100);
                        break;
                    case "E":
                    case "5":
                        $validPretensMax = 16 * ($turnsUsedPercent / 100);
                        break;
                    case "F":
                    case "6":
                        $validPretensMax = 0 * ($turnsUsedPercent / 100);
                        break;
                    case "G":
                    case "7":
                        $validPretensMax = 25 * ($turnsUsedPercent / 100);
                        break;
                    case "H":
                    case "8":
                        $validPretensMax = 22 * ($turnsUsedPercent / 100);
                        break;
                    case "J":
                    case "10":
                        $validPretensMax = 33 * ($turnsUsedPercent / 100);
                        break;
                    case "K":
                    case "11":
                        $validPretensMax = 27 * ($turnsUsedPercent / 100);
                        break;
                    case "U":
                        $validPretensMax = 33 * ($turnsUsedPercent / 100);
                        break;
                    case "V":
                        $validPretensMax = 34 * ($turnsUsedPercent / 100);
                        break;
                    default:
                        $validPretensMax = 33 * ($turnsUsedPercent / 100);
                }
                $maxTurnsFromSpring = $validPretensMax;
                break;
            default:
                if ($srchSpring >= 1001) {
                    $validPretensMax = 15 * ($turnsUsedPercent / 100);
                } elseif ($srchSpring >= 801) {
                            $validPretensMax = 23 * ($turnsUsedPercent / 100);
                } elseif ($srchSpring >= 751) {
                            $validPretensMax = 13 * ($turnsUsedPercent / 100);
                } elseif ($srchSpring >= 621) {
                            $validPretensMax = 29 * ($turnsUsedPercent / 100);
                } elseif ($srchSpring >= 601) {
                            $validPretensMax = 20 * ($turnsUsedPercent / 100);
                } elseif ($srchSpring >= 351) {
                            $validPretensMax = 16 * ($turnsUsedPercent / 100);
                } else{
                            $validPretensMax = 33 * ($turnsUsedPercent / 100);
                }
                //$maxTurnsFromSpring = 0;
        }//End of switch($srchStyle)

        if ($srchPremax < $validPretensMax) {
            $validPretensMax = $srchPremax;
        }
        $pretensTurnData = array(
            'turnsUsedPercent' => $turnsUsedPercent,
            'validPretensMax' => $validPretensMax,
            'maxTurnsFromSpring' => $maxTurnsFromSpring
        );
        return $pretensTurnData;
    }

    private function assignGearRatio($srchStyle, $srchGear) {

        $gearRatio = 0;
        switch ($srchStyle) {
            case 'S':
            case 'SM':
            case 'MMD':
                switch ($srchGear) {
                    case 'none':
                        $gearRatioStr = '1.00';
                        $gearRatio = 1;
                        break;
                    case 'A':
                        $gearRatioStr = '1.22';
                        $gearRatio = 1.22;
                        break;
                    case 'B':
                        $gearRatioStr = '1.50';
                        $gearRatio = 1.5;
                        break;
                    case 'C':
                        $gearRatioStr = '1.86';
                        $gearRatio = 1.86;
                        break;
                    case 'D':
                        $gearRatioStr = '2.07';
                        $gearRatio = 2.07;
                        break;
                    case 'E':
                        $gearRatioStr = '2.33';
                        $gearRatio = 2.33;
                        break;
                    case 'F':
                        $gearRatioStr = '3.00';
                        $gearRatio = 3;
                        break;
                    case 'G':
                        $gearRatioStr = '4.00';
                        break;
                    case 'J':
                        $gearRatioStr = '2.00';
                        $gearRatio = 2;
                        break;
                    case 'K':
                        $gearRatioStr = '2.33';
                        $gearRatio = 2.33;
                        break;
                    case 'M':
                        $gearRatioStr = '1.50';
                        $gearRatio = 1.5;
                        break;
                    case 'N':
                        $gearRatioStr = '1.72';
                        $gearRatio = 1.72;
                        break;
                    case 'P':
                        $gearRatioStr = '2.00';
                        $gearRatio = 2;
                        break;
                    case 'Q':
                        $gearRatioStr = '2.33';
                        $gearRatio = 2.33;
                        break;
                    case 'R':
                        $gearRatioStr = '2.75';
                        $gearRatio = 2.75;
                        break;
                    case 'S':
                        $gearRatioStr = '4.00';
                        $gearRatio = 4;
                        break;
                    case 'T':
                        $gearRatioStr = '1.50';
                        $gearRatio = 1.5;
                        break;
                    case 'V':
                        $gearRatioStr = '2.00';
                        $gearRatio = 2;
                        break;
                    case 'W':
                        $gearRatioStr = '2.75';
                        $gearRatio = 2.75;
                        break;
                    case 'Y':
                        $gearRatioStr = '4.00';
                        $gearRatio = 4;
                        break;
                    case 'all':
                        $gearRatioStr = 'all';
                        break;
                    default:
                        $gearRatioStr = '1.00';
                        $gearRatio = 1;
                }

                break;
            case 'U':
                switch(trim(strval($srchGear))){
                    case '':
                        $gearRatioStr = '1.00';
                        $gearRatio = 1;
                        break;
                    case 'A':
                        $gearRatioStr = '1.50';
                        $gearRatio = 1.5;
                        break;
                    case 'B':
                        $gearRatioStr = '2.00';
                        $gearRatio = 2;
                        break;
                    case 'C':
                        $gearRatioStr = '2.50';
                        $gearRatio = 2.5;
                        break;
                    case 'D':
                        $gearRatioStr = '3.00';
                        $gearRatio = 3.00;
                        break;
                    case 'E':
                        $gearRatioStr = '3.33';
                        $gearRatio = 3.33;
                        break;
                    case 'F':
                        $gearRatioStr = '4.00';
                        $gearRatio = 4;
                        break;
                    case 'all':
                        $gearRatioStr = 'all';
                        break;
                    default:
                        $gearRatioStr = '1.00';
                        $gearRatio = 1;
                }
                break;
            case 'SHO':
            case 'TMR':

                switch (substr($srchGear, -1, 1)) {
                    case "A":
                        $gearRatioStr = '3.00';
                        $gearRatio = 3;
                        break;
                    case "B":
                        $gearRatioStr = '2.50';
                        $gearRatio = 2.5;
                        break;
                    case "C":
                        $gearRatioStr = '2.00';
                        $gearRatio = 2;
                        break;
                    case "D":
                        $gearRatioStr = '1.50';
                        $gearRatio = 1.5;
                        break;
                    case "E":
                        $gearRatioStr = '1.00';
                        $gearRatio = 1;
                        break;
                    case "L":
                        $gearRatioStr = 'all';
                        break;
                    default:
                        $gearRatioStr = '1.00';
                        $gearRatio = 1;
                }

                break;
            default:
                $gearRatioStr = '1.00';
                $gearRatio = 1;

        }

        return $gearRatio;
    }

    private function calcStressBearing($srchSpoolMethod, $frameSize, $wrapperWidthR, $application, $cable, $maxStretchCapacityOfReel, $totalWeightLessCable, $srchGear, $chainRatioSel, $specificInput, $adjustedTorque) {
        $validStress = false;
        $cableWgt = $cable["weight"];
        if ($srchSpoolMethod == "R" && $frameSize < 54) {
            $X1DIST = 3.94 + .1197;
        }
        if ($srchSpoolMethod == "R" && $frameSize == 54) {
            $X1DIST = 3.94 + 1;
        }
        if ($srchSpoolMethod == "M") {
            $X1DIST = 3.94 + 1;
        }

        $YDIST = 8.75;
        $XDIST = $X1DIST + $wrapperWidthR / 2;

        switch ($application['appl']) {
            case 'stretch':
                $totalCableWeight = $maxStretchCapacityOfReel * $cableWgt;
                break;
            case 'lift':
                $totalCableWeight = $maxStretchCapacityOfReel * $cableWgt;
                break;
        }
        $totalWeight = $totalWeightLessCable + $totalCableWeight;

        $RMOM = $XDIST * $totalWeight;

        switch ($srchGear) {
            case "AA":
            case "AB":
            case "AC":
            case "AD":
            case "AE":
            case "all":
                $SOD = 1.998;
                $SID = 1.5;
                break;
            case "BA":
            case "BB":
            case "BC":
            case "BD":
            case "BE":
                $SOD = 2.188;
                $SID = 1.5;
                break;
        }
        $shaftStress = $this->calcShaftStress($SID, $SOD, $adjustedTorque, $RMOM);
        if ($shaftStress > 8000 && $chainRatioSel == 'all') {
            $srchGear = "B" + substr($srchGear, -1);//rightmost character
            $SOD = 2.188;
            $SID = 1.5;
            $shaftStress = $this->calcShaftStress($SID, $SOD, $adjustedTorque, $RMOM);
        }


        if ($shaftStress > 8000 /*&& $specificInput == false*/) {
            $stress = array(
                "validStress" => false,
                "shaftStress" => $shaftStress,
            );
            return $stress;
        }
        $bearingLoad = $totalWeight * ($XDIST + $YDIST) / $YDIST;
        if ($bearingLoad > 2300 && $specificInput == false) {
            $stress = array(
                "validStress" => false,
                "shaftStress" => $shaftStress,
                "bearingLoad" => $bearingLoad
            );
            return $stress;
        }

        $validStress = true;
        $stress = array(
            "validStress" => true,
            "shaftStress" => $shaftStress,
            "bearingLoad" => $bearingLoad
        );
        return $stress;

    }

    private function assignCCF($srchStyle, $maxCableWrapsI) {
        $cableClearanceFactor = null;

        if ($srchStyle) {
            if ($srchStyle == 'K') {
                $cableClearanceFactor = 0;
            } else {
                if ($maxCableWrapsI <= 16) {
                    $cableClearanceFactor = 0.6;
                } else {
                    if ($maxCableWrapsI <= 24) {
                        $cableClearanceFactor = 0.8;
                    } else {
                        if ($maxCableWrapsI <= 32) {
                            $cableClearanceFactor = 1;
                        } else {
                            if ($maxCableWrapsI <= 40) {
                                $cableClearanceFactor = 1.2;
                            } else {
                                if ($maxCableWrapsI <= 48) {
                                    $cableClearanceFactor = 1.4;
                                } else {
                                    if ($maxCableWrapsI <= 56) {
                                        $cableClearanceFactor = 1.6;
                                    } else {
                                        if ($maxCableWrapsI <= 64) {
                                            $cableClearanceFactor = 1.8;
                                        } else {
                                            if ($maxCableWrapsI <= 72) {
                                                $cableClearanceFactor = 2;
                                            } else {
                                                if ($maxCableWrapsI <= 80) {
                                                    $cableClearanceFactor = 2.2;
                                                } else {
                                                    $cableClearanceFactor = 2.4;
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
        return $cableClearanceFactor;
    }

    private function checkForSpecificInput($cableOrHose, $sCheckboxes, $drumDiameter, $pretensionTurn) {
        //$specificInput = array();
        $specificInput = false;
        //    switch($cableOrHose) {
        //      case 'HS':
        //      case 'HD':
        //        break;
        //      default:
        //var_dump($sCheckboxes);
        if ($sCheckboxes[0] != 'all' || $sCheckboxes[0] != 'none') {

            if ($drumDiameter['min'] == $drumDiameter['max'] && $pretensionTurn['min'] == $pretensionTurn['max']) {
                $specificInput = true;
            }
        }
        //    }

        return $specificInput;
    }

    private function getSpringData() {
        $maxSpringTurns[1] = 16;
        $maxSpringTurns[2] = 20;
        $maxSpringTurns[3] = 29;
        $maxSpringTurns[4] = 13;
        $maxSpringTurns[5] = 23;
        $maxSpringTurns[6] = 15;

        $maxTurnsForFirstPartOfCurve[1] = 16;
        $maxTurnsForFirstPartOfCurve[2] = 5;
        $maxTurnsForFirstPartOfCurve[3] = 2;
        $maxTurnsForFirstPartOfCurve[4] = 2;
        $maxTurnsForFirstPartOfCurve[5] = 3;
        $maxTurnsForFirstPartOfCurve[6] = 2;

        $slopeFirstPartOfCurve[1] = 0.55;
        $slopeFirstPartOfCurve[2] = 0.63;
        $slopeFirstPartOfCurve[3] = 1.14;
        $slopeFirstPartOfCurve[4] = 5.33;
        $slopeFirstPartOfCurve[5] = 3;
        $slopeFirstPartOfCurve[6] = 11.2;

        $yInterceptFirstPartOfCurve[1] = 0;
        $yInterceptFirstPartOfCurve[2] = 0;
        $yInterceptFirstPartOfCurve[3] = 0;
        $yInterceptFirstPartOfCurve[4] = 0;
        $yInterceptFirstPartOfCurve[5] = 0;
        $yInterceptFirstPartOfCurve[6] = 0;

        $maxTurnsForSecondPartOfCurve[1] = 0;
        $maxTurnsForSecondPartOfCurve[2] = 20;
        $maxTurnsForSecondPartOfCurve[3] = 17;
        $maxTurnsForSecondPartOfCurve[4] = 9;
        $maxTurnsForSecondPartOfCurve[5] = 9;
        $maxTurnsForSecondPartOfCurve[6] = 8;

        $slopeSecondPartOfCurve[1] = 0;
        $slopeSecondPartOfCurve[2] = 0.22;
        $slopeSecondPartOfCurve[3] = 0.47;
        $slopeSecondPartOfCurve[4] = 2;
        $slopeSecondPartOfCurve[5] = 0.57;
        $slopeSecondPartOfCurve[6] = 3.43;

        $yInterceptSecondPartOfCurve[1] = 0;
        $yInterceptSecondPartOfCurve[2] = 2;
        $yInterceptSecondPartOfCurve[3] = 1.8;
        $yInterceptSecondPartOfCurve[4] = 6.5;
        $yInterceptSecondPartOfCurve[5] = 7.5;
        $yInterceptSecondPartOfCurve[6] = 16;

        $maxTurnsForThirdPartOfCurve[1] = 0;
        $maxTurnsForThirdPartOfCurve[2] = 0;
        $maxTurnsForThirdPartOfCurve[3] = 29;
        $maxTurnsForThirdPartOfCurve[4] = 13;
        $maxTurnsForThirdPartOfCurve[5] = 23;
        $maxTurnsForThirdPartOfCurve[6] = 15;

        $slopeThirdPartOfCurve[1] = 0;
        $slopeThirdPartOfCurve[2] = 0;
        $slopeThirdPartOfCurve[3] = .22;
        $slopeThirdPartOfCurve[4] = 1;
        $slopeThirdPartOfCurve[5] = .84;
        $slopeThirdPartOfCurve[6] = .73;

        $yInterceptThirdPartOfCurve[1] = 0;
        $yInterceptThirdPartOfCurve[2] = 0;
        $yInterceptThirdPartOfCurve[3] = 6;
        $yInterceptThirdPartOfCurve[4] = 15.5;
        $yInterceptThirdPartOfCurve[5] = 3.5;
        $yInterceptThirdPartOfCurve[6] = 38;

        $springData = array(
            'maxSpringTurns' => $maxSpringTurns,
            'maxTurnsForFirstPartOfCurve' => $maxTurnsForFirstPartOfCurve,
            'slopeFirstPartOfCurve' => $slopeFirstPartOfCurve,
            'yInterceptFirstPartOfCurve' => $yInterceptFirstPartOfCurve,
            'maxTurnsForSecondPartOfCurve' => $maxTurnsForSecondPartOfCurve,
            'slopeSecondPartOfCurve' => $slopeSecondPartOfCurve,
            'yInterceptSecondPartOfCurve' => $yInterceptSecondPartOfCurve,
            'maxTurnsForThirdPartOfCurve' => $maxTurnsForThirdPartOfCurve,
            'slopeThirdPartOfCurve' => $slopeThirdPartOfCurve,
            'yInterceptThirdPartOfCurve' => $yInterceptThirdPartOfCurve
        );

        return $springData;
    }

    public function calcStretchApplCM($application, $initialCMCalcs, $cable, $pretensionTurns, $srchSpring, $specificInput, $srchStyle, $srchFrame, $srchColl) {

        $pi = 3.14159;
        $accelInFtSecSec = floatval($application["accel"]);
        $percentSagStr = floatval($application["cableSag"]);
        $travelInFt = $application["activeTravel"];
        $speedInFtSec = $application["travelSpeed"];

        $cableWgt = $cable["weight"];
        $cableThick = $cable['thickness'];

        $adjustedTorque = $initialCMCalcs["adjustedTorque"];
        $torqueToOvercomeCollectorFriction = $initialCMCalcs["torqueToOvercomeCollectorFriction"];
        $ra = $initialCMCalcs["ra"];
        $cbend = $initialCMCalcs["cbend"];
        $momentArm = $initialCMCalcs["momentArm"];
        $coefficient = $initialCMCalcs["coefficient"];
        $spoolWeight = $initialCMCalcs["spoolWeight"];
        $reelInertia = $initialCMCalcs["reelInertia"];
        $ixarr = $initialCMCalcs["ixarr"];
        $wrap = $initialCMCalcs["wraparr"];
        $row = $initialCMCalcs["row"];
        $maxUsableWrapsR = intval($initialCMCalcs["maxUsableWrapsR"]);
        $springTurnsAvailAfterPretensionR = $initialCMCalcs["springTurnsAvailAfterPretensionR"];
        $turnsActiveCableLength = $initialCMCalcs["turnsActiveCableLength"];
        $turnsActiveCableLength = floatval(number_format($turnsActiveCableLength, 5));
        $maxFullLayersFromTurnsR = $initialCMCalcs['maxFullLayersFromTurnsR'];
        $compartmentActiveCableLength = $initialCMCalcs["compartmentActiveCableLength"];
        $drumSize = $initialCMCalcs["drumSize"];
        $gearRatio = $initialCMCalcs["gearRatio"];
        $maxUsableLayersR = $initialCMCalcs["maxUsableLayersR"];

        $percentSag = 0;
        if ($percentSagStr != "0" && $percentSagStr != "")//std or null
        {
            $percentSag = intval($percentSagStr) / 100;
        } else {
            $percentSag = 10 / 100;
        }
        $sagFactor = 1 / ($percentSag * 8);

        $torqueActiveStretchLength = $adjustedTorque - $torqueToOvercomeCollectorFriction - $cbend;

        $tcabes = ((0.6366 * $momentArm) * ($cableWgt * $pi * $momentArm) * $gearRatio) * (1.0 + ($accelInFtSecSec * $gearRatio / 32.16));

        $tbrges = ((($adjustedTorque * 24.0 / $drumSize) + $spoolWeight) * $coefficient * 2.0 / $drumSize) * $drumSize / 24.0 * $gearRatio;

        $tsples = ($reelInertia * pow($gearRatio, 2.0) * $accelInFtSecSec) / ($ra * 32.16);

        $stretch = ($torqueActiveStretchLength - ($tsples + $tbrges + $tcabes)) / $sagFactor / ($cableWgt * $momentArm * $gearRatio * (1.0 + ($accelInFtSecSec * $gearRatio / 32.16)));

        $smax = $stretch;
        $iyind = 1;
        $extraWrapsAfterFullLayersTorqueStretchR = 0;
        $tempCircumferenceTotal = 0;
        LINE460:
        $extraWrapsAfterFullLayersTorqueStretchR = $extraWrapsAfterFullLayersTorqueStretchR + 1.0;

        if ($extraWrapsAfterFullLayersTorqueStretchR > $ixarr[$iyind]) {
            goto LINE462;
        }
        $tempCircumferenceTotal = $tempCircumferenceTotal + $wrap[$iyind];

        if ($tempCircumferenceTotal <= $smax) {
            goto LINE460;
        }
        goto LINE465;

        LINE462:
        $extraWrapsAfterFullLayersTorqueStretchR = 0.0;

        $iyind = $iyind + 1;

        goto LINE460;
        LINE465:
        $extraWrapsAfterFullLayersTorqueStretchR = $extraWrapsAfterFullLayersTorqueStretchR - 1.0;

        $iyfin = $iyind - 1;

        $maxWrapsFromTorqueStretch = 0;
        $strMax = 0;

        if ($iyfin == 0) {
            goto LINE469;
        }
        for ($iyind = 1; $iyind <= $iyfin; $iyind++) {
            $maxWrapsFromTorqueStretch = $maxWrapsFromTorqueStretch + $ixarr[$iyind];

            $strMax = $strMax + $row[$iyind];

        }
        LINE469:
        $iyind = $iyfin + 1;

        $maxWrapsFromTorqueStretch = $maxWrapsFromTorqueStretch + $extraWrapsAfterFullLayersTorqueStretchR;

        $es = $extraWrapsAfterFullLayersTorqueStretchR;

        $strMax = $strMax + $es * $wrap[$iyind];

        $maxActiveLengthOfCableFromTorqueStretch = $strMax;

        $ys = $iyfin;

        if ($es == 0) {
            $ys = $iyfin - 1;
        }

        $unusedSpringTurnsForStretch = 0.0;
        $availableSpringTurnsForStretch = 0.0;

        if ($maxUsableWrapsR < $springTurnsAvailAfterPretensionR) {
            goto LINE470;
        }
        $maxStretchCapacityOfReel = $turnsActiveCableLength;

        $unusedSpringTurnsForStretch = 0.0;
        $maxFullLayersAtStretchCapacity = $maxFullLayersFromTurnsR;

        if ($maxWrapsFromTorqueStretch >= $springTurnsAvailAfterPretensionR) {

            goto LINE468;
        }
        $maxStretchCapacityOfReel = $maxActiveLengthOfCableFromTorqueStretch;

        $unusedSpringTurnsForStretch = ($springTurnsAvailAfterPretensionR - $maxWrapsFromTorqueStretch) / $gearRatio;

        $maxFullLayersAtStretchCapacity = $ys;

        LINE468:
        goto LINE472;
        LINE470:
        $maxStretchCapacityOfReel = $compartmentActiveCableLength;

        $unusedSpringTurnsForStretch = 0;
        $availableSpringTurnsForStretch = 0;
        $maxFullLayersAtStretchCapacity =  $maxUsableLayersR;//$maxUsableWrapsR;

        if ($maxWrapsFromTorqueStretch >= $maxUsableWrapsR) {
            goto LINE471;
        }
        $maxStretchCapacityOfReel = $maxActiveLengthOfCableFromTorqueStretch;

        $availableSpringTurnsForStretch = ($springTurnsAvailAfterPretensionR - $maxUsableWrapsR) / $gearRatio;
        $maxFullLayersAtStretchCapacity = $ys;

        LINE471:
        LINE472://6583
        $spooledCableInertiaInsideRadius = $drumSize / 24.0;
        $spooledCableInertiaOutsideRadiusStretch = ($drumSize + 2.0 * $maxFullLayersAtStretchCapacity * $cableThick) / 24.0;

        $spooledCableInertiaStretch = ($cableWgt * $maxStretchCapacityOfReel / 2.0) * (pow($spooledCableInertiaInsideRadius, 2) + pow($spooledCableInertiaOutsideRadiusStretch, 2));

        $totalStretchInertia = $reelInertia + $spooledCableInertiaStretch;

        $spoolFullMomentArmStretch = ($drumSize + (2 * $maxFullLayersAtStretchCapacity - 1) * $cableThick) / 24;
        $torqueToAccelerateReelStretch = ($totalStretchInertia * pow($gearRatio, 2) * $accelInFtSecSec) / ($spoolFullMomentArmStretch * 32.16);

        $adjPretensionTurns = $pretensionTurns * $gearRatio;

        $itempb = intval($adjPretensionTurns);

        $springTorqueAvailForReeling = $this->getCMspringData($itempb, $srchSpring);
        $torqueFromPretensionTurnsStretch = $springTorqueAvailForReeling;

        LINE474:
        $tbrgfs = ((($torqueFromPretensionTurnsStretch * 24 / $drumSize) + $spoolWeight + ($cableWgt * $torqueActiveStretchLength)) * $coefficient * 2.0 / $drumSize) * $drumSize / 24.0 * $gearRatio;
        $tcabfs = ((0.6366 * $spoolFullMomentArmStretch) * (pi() * $spoolFullMomentArmStretch * $cableWgt) * $gearRatio) * (1 + ($accelInFtSecSec * $gearRatio / 32.16));

        $netTorqueWithReelFullStretch = $torqueFromPretensionTurnsStretch - ($torqueToAccelerateReelStretch + $torqueToOvercomeCollectorFriction + $cbend + $tbrgfs + $tcabfs);

        $specificInput = false;

        if ($specificInput == false) {
            if ($netTorqueWithReelFullStretch < 0) {
                $stretchApplCalcs = array(
                    'validTorque' => false,
                    'reason' => 3
                );

                return $stretchApplCalcs;
            }
            if ($availableSpringTurnsForStretch != 0 || $unusedSpringTurnsForStretch != 0) {

                $stretchApplCalcs = array(
                    'validTorque' => false,
                    'reason' => 4
                );
                return $stretchApplCalcs;
            }
        }

        if ($netTorqueWithReelFullStretch < 0 || $availableSpringTurnsForStretch != 0 || $unusedSpringTurnsForStretch != 0) {
            $invalidWarning = true;
        }

        $validTorque = true;
        $stretchApplCalcs = array(
            'validTorque' => $validTorque,
            'unusedSpringTurnsForStretch' => $unusedSpringTurnsForStretch,
            'availableSpringTurnsForStretch' => $availableSpringTurnsForStretch,
            'torqueActiveStretchLength' => $torqueActiveStretchLength,
            'maxActiveLengthOfCableFromTorqueStretch' => $maxActiveLengthOfCableFromTorqueStretch,
            'maxStretchCapacityOfReel' => $maxStretchCapacityOfReel,
            'extraWrapsAfterFullLayersTorqueStretchR' => $extraWrapsAfterFullLayersTorqueStretchR,
            'netTorqueWithReelFullStretch' => $netTorqueWithReelFullStretch,
            "maxWrapsFromTorqueStretch" => $maxWrapsFromTorqueStretch,
            "reason" => 0
        );

        return $stretchApplCalcs;
    }

    public function calcStretchAppl($srchStyle, $modelIndex, $pretensionTurns, $application, $initialCalcs, $cable, $drumSize, $gearRatioStr, $validTorque, $specificInput, $srchSpring, $srchGear) {

        $gearRatio = floatval($gearRatioStr);
        $cableThick = $cable["thickness"];
        $cableWgt = $cable["weight"];

        $pi = 3.14159;

        $travelInFt = $application["activeTravel"];
        $speedInFtSec = $application["travelSpeed"];
        $percentSagStr = floatval($application["cableSag"]);
        $accelInFtSecSec = floatval($application["accel"]);

        $adjustedTorque = $initialCalcs["adjustedTorque"];
        $torqueToOvercomeCollectorFriction = $initialCalcs["torqueToOvercomeCollectorFriction"];
        $reelInertia = $initialCalcs["reelInertia"];
        $firstLayerMomentArm = $initialCalcs["firstLayerMomentArm"];
        $deadWrapLength = $initialCalcs["deadWrapLength"];
        $maxWrapsPerLayerR = $initialCalcs["maxWrapsPerLayerR"];
        $maxUsableLayersR = $initialCalcs["maxUsableLayersR"];
        $AdjSlopeFirstPartOfCurve = $initialCalcs["AdjSlopeFirstPartOfCurve"];
        $AdjyInterceptFirstPartOfCurve = $initialCalcs["AdjyInterceptFirstPartOfCurve"];
        $AdjMaxTurnsForFirstPartOfCurve = $initialCalcs["AdjMaxTurnsForFirstPartOfCurve"];
        $torqueSafetyFactor = $initialCalcs["torqueSafetyFactor"];
        $maxFullLayersFromTurnsR = $initialCalcs["maxFullLayersFromTurnsR"];
        $extraWrapsAfterFullLayersTurnsR = $initialCalcs["extraWrapsAfterFullLayersTurnsR"];
        $AdjyInterceptThirdPartOfCurve = $initialCalcs["AdjyInterceptThirdPartOfCurve"];
        $AdjSlopeThirdPartOfCurve = $initialCalcs["AdjSlopeThirdPartOfCurve"];
        $turnsActiveCableLength = $initialCalcs["turnsActiveCableLength"];
        $AdjMaxTurnsForSecondPartOfCurve = $initialCalcs["AdjMaxTurnsForSecondPartOfCurve"];
        $AdjyInterceptSecondPartOfCurve = $initialCalcs["AdjyInterceptSecondPartOfCurve"];
        $AdjSlopeSecondPartOfCurve = $initialCalcs["AdjSlopeSecondPartOfCurve"];
        $compartmentActiveCableLength = $initialCalcs["compartmentActiveCableLength"];
        $maxUsableWrapsR = $initialCalcs["maxUsableWrapsR"];
        $springTurnsAvailAfterPretensionR = $initialCalcs["springTurnsAvailAfterPretensionR"];
        $rmoti = $initialCalcs["rmoti"];
        $tqsiz = $initialCalcs["tqsiz"];

        $torqueActiveStretchLength = 0; $unusedSpringTurnsForStretch = 0; $availableSpringTurnsForStretch = 0;
        $maxStretchCapacityOfReel = 0; $netTorqueWithReelFullStretch = 0;

        if ($percentSagStr != 0 && $percentSagStr != null) {
            $percentSag = floatval($percentSagStr) / 100;
        } else {
            switch ($srchStyle) {
                case "U":
                    $percentSag = 10 / 100;
                    break;
                default:
                    $percentSag = 6 / 100;
            }
        }

        $sagFactor = 1 / ($percentSag * 8);

        switch ($srchStyle) {
            case "S":
            case "SM":
            case "MMD":
            case "SHO":
            case "U":
                $torqueActiveStretchLength = ($adjustedTorque - $torqueToOvercomeCollectorFriction - ($reelInertia * $accelInFtSecSec / (32.2516 * $firstLayerMomentArm))) / ($sagFactor * $cableWgt * $firstLayerMomentArm * (1 + ((1 / $sagFactor) * $accelInFtSecSec / 32.2516)));

                break;
            case "K":
                $torqueActiveStretchLength = ($adjustedTorque - $torqueToOvercomeCollectorFriction - ($reelInertia * $accelInFtSecSec / (32.2516 * $firstLayerMomentArm))) / ($sagFactor * $cableWgt * $firstLayerMomentArm * (1 + ((1 / $sagFactor) * $accelInFtSecSec / 32.2516)));
                break;
            case "TMR":
                $facmi = ($rmoti * pow($gearRatio, 2) * $accelInFtSecSec) / (32.2516 * $firstLayerMomentArm);
                $rnme = ($speedInFtSec * $gearRatio) / (2 * $pi * $firstLayerMomentArm);
                if ($rnme > 450) {
                    switch ($specificInput) {
                        case false:
                            $liftApplCalcs = array(
                                'validTorque' => false,
                                'reason' => 3
                            );
                            return $liftApplCalcs;
                        case true:
                            $invalidWarning = true;
                    }
                }
                if ($rnme > 600) {
                    $tqoute = 0;
                } else {
                    $tqoute = sqrt(pow($tqsiz, 2) * (1 - (pow($rnme, 2) / pow(600, 2))));
                }
                $adjustedTorque = $gearRatio * $tqoute;
                $ttes = $adjustedTorque - $torqueToOvercomeCollectorFriction;
                $torqueActiveStretchLength = ($ttes - ($reelInertia * $accelInFtSecSec / (32.2516 * $firstLayerMomentArm)) - $facmi) / ($sagFactor * $cableWgt * $firstLayerMomentArm * (1 + ((1 / $sagFactor) * $accelInFtSecSec / 32.2516)));
                break;
        }

        if ($torqueActiveStretchLength < $travelInFt) {

            switch ($specificInput) {
                case false:
                    $stretchApplCalcs = array(
                        'validTorque' => false,
                        'reason' => 3
                    );

                    return $stretchApplCalcs;

                case true:
                    $invalidWarning = true;
                    break;
            }
        }

        $maxFullLayersFromTorqueStretchR = 1;
        $extraWrapsAfterFullLayersTorqueStretchR = 1;
        $tempCircumferenceTotal = $deadWrapLength;

        LINE460:
        $extraWrapsAfterFullLayersTorqueStretchR = $extraWrapsAfterFullLayersTorqueStretchR + 1;
        if ($extraWrapsAfterFullLayersTorqueStretchR > $maxWrapsPerLayerR) {
            goto LINE462;
        }
        $circumferenceAtCenterOfMaxFullLayerStre = ($drumSize + (2 * $maxFullLayersFromTorqueStretchR - 1) * $cableThick) * $pi / 12;
        $tempCircumferenceTotal = $tempCircumferenceTotal + $circumferenceAtCenterOfMaxFullLayerStre;

        if ($tempCircumferenceTotal <= $torqueActiveStretchLength + $deadWrapLength) {
            goto LINE460;
        }
        goto LINE465;
        LINE462:
        $extraWrapsAfterFullLayersTorqueStretchR = 0;
        $maxFullLayersFromTorqueStretchR = $maxFullLayersFromTorqueStretchR + 1;
        goto LINE460;
        LINE465:
        $extraWrapsAfterFullLayersTorqueStretchR = $extraWrapsAfterFullLayersTorqueStretchR - 1;
        $maxFullLayersFromTorqueStretchR = $maxFullLayersFromTorqueStretchR - 1;
        $maxWrapsFromTorqueStretch = ($maxWrapsPerLayerR * $maxFullLayersFromTorqueStretchR + $extraWrapsAfterFullLayersTorqueStretchR);

        $maxLengthCableFromTorqueStretch = (($drumSize + $maxFullLayersFromTorqueStretchR * $cableThick) * pi() / 12 * $maxWrapsPerLayerR * $maxFullLayersFromTorqueStretchR) + (($drumSize + ((2 * $maxFullLayersFromTorqueStretchR + 1) * $cableThick)) * pi() / 12 * $extraWrapsAfterFullLayersTorqueStretchR);

        $maxActiveLengthOfCableFromTorqueStretch = $maxLengthCableFromTorqueStretch - $deadWrapLength;

        if ($maxActiveLengthOfCableFromTorqueStretch < $travelInFt) {

            switch ($specificInput) {
                case false:
                    $stretchApplCalcs = array(
                        'validTorque' => false,
                        'reason' => 3
                    );
                    return $stretchApplCalcs;
                case true:
                    $invalidWarning = true;
                    break;
            }
        }

        switch ($srchStyle) {
            case "S":
            case "SM":
            case "MMD":
            case "SHO":
            case "U":

                $unusedSpringTurnsForStretch = 0;
                $availableSpringTurnsForStretch = 0;

                if ($maxUsableWrapsR < $springTurnsAvailAfterPretensionR) {
                    goto LINE470;
                }
                $maxStretchCapacityOfReel = $turnsActiveCableLength;
                $unusedSpringTurnsForStretch = 0;
                $maxFullLayersAtStretchCapacity = $maxFullLayersFromTurnsR;
                $extraWrapsAtStretchCapacity = $extraWrapsAfterFullLayersTurnsR;
                if ($maxWrapsFromTorqueStretch >= $springTurnsAvailAfterPretensionR) {
                    goto LINE468;
                }
                $maxStretchCapacityOfReel = $maxActiveLengthOfCableFromTorqueStretch;
                $unusedSpringTurnsForStretch = ($springTurnsAvailAfterPretensionR - $maxWrapsFromTorqueStretch) / $gearRatio;
                $maxFullLayersAtStretchCapacity = $maxFullLayersFromTorqueStretchR;
                $extraWrapsAtStretchCapacity = $extraWrapsAfterFullLayersTorqueStretchR;


                LINE468:
                if ($extraWrapsAtStretchCapacity != 0) {
                    $maxFullLayersAtStretchCapacity = $maxFullLayersAtStretchCapacity + 1;
                }
                goto LINE472;
                LINE470:
                $maxStretchCapacityOfReel = $compartmentActiveCableLength;
                $unusedSpringTurnsForStretch = 0;

                $availableSpringTurnsForStretch = 0;
                $maxFullLayersAtStretchCapacity = $maxUsableLayersR;
                $extraWrapsAtStretchCapacity = 0;
                if ($maxWrapsFromTorqueStretch >= $maxUsableWrapsR) {
                    goto LINE471;
                }
                $maxStretchCapacityOfReel = $maxActiveLengthOfCableFromTorqueStretch;
                $availableSpringTurnsForStretch = ($springTurnsAvailAfterPretensionR - $maxUsableWrapsR) / $gearRatio; // something here?

                $maxFullLayersAtStretchCapacity = $maxFullLayersFromTorqueStretchR;
                $extraWrapsAtStretchCapacity = $extraWrapsAfterFullLayersTorqueStretchR;
                LINE471:
                if ($extraWrapsAtStretchCapacity != 0) {
                    $maxFullLayersAtStretchCapacity = $maxFullLayersAtStretchCapacity + 1;
                }
                LINE472:
                $spooledCableInertiaInsideRadius = $drumSize / 24;
                $spooledCableInertiaOutsideRadiusStretch = ($drumSize + 2 * $maxFullLayersAtStretchCapacity * $cableThick) / 24;
                if ($srchStyle == "K") {
                    // $spooledCableInertiaStretch = ($hoseWgtBoth * $maxStretchCapacityOfReel / 2) * ($spooledCableInertiaInsideRadius ^ 2 + $spooledCableInertiaOutsideRadiusStretch ^ 2);
                } else {
                    $spooledCableInertiaStretch = ($cableWgt * $maxStretchCapacityOfReel / 2) * (pow($spooledCableInertiaInsideRadius, 2) + pow($spooledCableInertiaOutsideRadiusStretch, 2));
                }

                $totalStretchInertia = $reelInertia + $spooledCableInertiaStretch;
                $spoolFullMomentArmStretch = ($drumSize + (2 * $maxFullLayersAtStretchCapacity - 1) * $cableThick) / 24;
                $rpmSpoolFullStretch = $speedInFtSec / (2 * $pi * $spoolFullMomentArmStretch * $gearRatio);
                $torqueToAccelerateReelStretch = ($totalStretchInertia * pow($gearRatio, 2) * $rpmSpoolFullStretch) / (5.133 * $speedInFtSec / $accelInFtSecSec);
                $AdjPretensionTurns = $pretensionTurns * $gearRatio;

                $torqueFromPretensionTurnsStretch = $AdjSlopeFirstPartOfCurve * $AdjPretensionTurns + $AdjyInterceptFirstPartOfCurve;

                if ($AdjPretensionTurns <= $AdjMaxTurnsForFirstPartOfCurve) {
                    goto LINE474;
                }
                $torqueFromPretensionTurnsStretch = $AdjSlopeSecondPartOfCurve * $AdjPretensionTurns + $AdjyInterceptSecondPartOfCurve;

                if ($AdjPretensionTurns <= $AdjMaxTurnsForSecondPartOfCurve) {
                    goto LINE474;
                }
                $torqueFromPretensionTurnsStretch = $AdjSlopeThirdPartOfCurve * $AdjPretensionTurns + $AdjyInterceptThirdPartOfCurve;

                LINE474:

                $netTorqueWithReelFullStretch = ($torqueFromPretensionTurnsStretch - $torqueToAccelerateReelStretch - $torqueToOvercomeCollectorFriction) / $torqueSafetyFactor;

                if (!$specificInput) {
                    if ($netTorqueWithReelFullStretch < 0) {

                        switch ($specificInput) {
                            case false:
                                //todo: does invalidStore(3) need to be implimented, this is also found in the retrievecalcs
                                //invalidSTORE(3);
                                $stretchApplCalcs = array(
                                    'validTorque' => false,
                                    'netTorqueWithReelFullStretch' => $netTorqueWithReelFullStretch,
                                    'maxActiveLengthOfCableFromTorqueStretch' => $maxActiveLengthOfCableFromTorqueStretch,
                                    'maxStretchCapacityOfReel' => $maxStretchCapacityOfReel,
                                    'reason' => 3
                                );

                                return $stretchApplCalcs;
                                break;
                            case true:
                                $invalidWarning = true;
                                break;
                        }
                    }


                    if ($availableSpringTurnsForStretch != 0 || $unusedSpringTurnsForStretch != 0) {
                        switch ($specificInput) {
                            case false:
                                $stretchApplCalcs = array(
                                    'validTorque' => false,
                                    'torqueActiveStretchLength' => $torqueActiveStretchLength,
                                    'netTorqueWithReelFullStretch' => $netTorqueWithReelFullStretch,
                                    'maxActiveLengthOfCableFromTorqueStretch' => $maxActiveLengthOfCableFromTorqueStretch,
                                    'maxStretchCapacityOfReel' => $maxStretchCapacityOfReel,
                                    'reason' => 4
                                );


                                return $stretchApplCalcs;
                                break;
                            case true:
                                $invalidWarning = true;
                                break;
                        }

                    }

                }
                break;
            case "TMR":
                $maxStretchCapacityOfReel = $compartmentActiveCableLength;
                if($maxWrapsFromTorqueStretch < $maxUsableWrapsR){
                    $maxStretchCapacityOfReel = $maxActiveLengthOfCableFromTorqueStretch;
                }
                break;
        }


        $validTorque = true;
        $stretchApplCalcs = array(
            'validTorque' => $validTorque,
            'maxLengthCableFromTorqueStretch' => $maxLengthCableFromTorqueStretch,
            'maxFullLayersFromTorqueStretchR' => $maxFullLayersFromTorqueStretchR,
            'unusedSpringTurnsForStretch' => $unusedSpringTurnsForStretch,
            'availableSpringTurnsForStretch' => $availableSpringTurnsForStretch,
            'torqueActiveStretchLength' => $torqueActiveStretchLength,
            'maxActiveLengthOfCableFromTorqueStretch' => $maxActiveLengthOfCableFromTorqueStretch,
            'maxStretchCapacityOfReel' => $maxStretchCapacityOfReel,
            'extraWrapsAfterFullLayersTorqueStretchR' => $extraWrapsAfterFullLayersTorqueStretchR,
            'netTorqueWithReelFullStretch' => $netTorqueWithReelFullStretch,
            'reason' => 0
        );


        return $stretchApplCalcs;


    }

    public function calcLiftAppl($srchStyle, $modelIndex, $pretensionTurns, $application, $initialCalcs, $cable, $drumSize, $gearRatio, $validTorque, $specificInput, $srchColl, $srchSpring) {
        $pendantInLbs = $application["pendantWeight"];
        $travelInFt = $application["activeTravel"];
        $speedInFtSec = $application["travelSpeed"];
        $accelInFtSecSec = floatval($application["accel"]);
        $percentSagStr = floatval($application["cableSag"]);

        $cableThick = $cable["thickness"];
        $cableWgt = $cable["weight"];

        $turnsActiveCableLength = $initialCalcs["turnsActiveCableLength"];
        $adjMaxTurnsForSecondPartOfCurve = $initialCalcs["AdjMaxTurnsForSecondPartOfCurve"];
        $adjYInterceptSecondPartOfCurve = $initialCalcs["AdjyInterceptSecondPartOfCurve"];
        $adjSlopeSecondPartOfCurve = $initialCalcs["AdjSlopeSecondPartOfCurve"];
        $compartmentActiveCableLength = $initialCalcs["compartmentActiveCableLength"];
        $maxUsableWrapsR = $initialCalcs["maxUsableWrapsR"];
        $springTurnsAvailAfterPretensionR = $initialCalcs["springTurnsAvailAfterPretensionR"];
        $adjustedTorque = $initialCalcs["adjustedTorque"];
        $torqueToOvercomeCollectorFriction = $initialCalcs["torqueToOvercomeCollectorFriction"];
        $reelInertia = $initialCalcs["reelInertia"];
        $firstLayerMomentArm = $initialCalcs["firstLayerMomentArm"];
        $deadWrapLength = $initialCalcs["deadWrapLength"];
        $maxWrapsPerLayerR = $initialCalcs["maxWrapsPerLayerR"];
        $maxUsableLayersR = $initialCalcs["maxUsableLayersR"];
        $adjSlopeFirstPartOfCurve = $initialCalcs["AdjSlopeFirstPartOfCurve"];
        $adjYInterceptFirstPartOfCurve = $initialCalcs["AdjyInterceptFirstPartOfCurve"];
        $adjMaxTurnsForFirstPartOfCurve = $initialCalcs["AdjMaxTurnsForFirstPartOfCurve"];
        $torqueSafetyFactor = $initialCalcs["torqueSafetyFactor"];
        $maxFullLayersFromTurnsR = $initialCalcs["maxFullLayersFromTurnsR"];
        $extraWrapsAfterFullLayersTurnsR = $initialCalcs["extraWrapsAfterFullLayersTurnsR"];
        $adjYInterceptThirdPartOfCurve = $initialCalcs["AdjyInterceptThirdPartOfCurve"];
        $adjSlopeThirdPartOfCurve = $initialCalcs["AdjSlopeThirdPartOfCurve"];
        $hoseWgtBoth = $initialCalcs["hosewgtboth"];
        $rmoti = $initialCalcs["rmoti"];
        $tqsiz = $initialCalcs["tqsiz"];
        $torqueFromMotor = $initialCalcs["torqueFromMotor"];

        $extraWrapsAtLiftCapacity = 0;
        $torqueActiveLiftLength = 0; $unusedSpringTurnsForLift = 0; $maxLiftCapacityOfReel = 0; $availableSpringTurnsForlift = 0;
        $netTorqueWithReelFullLift = 0; $rnme = 0; $tqoute = 0; $torqueActiveLiftLength = 0;

        $pi = 3.14159;

        //$resultFile = "C:\\Users\\nwachukwuc1\\Desktop\\calcLiftPendant.txt";
        //$handle = fopen($resultFile, 'a') or die('Cannot open file:  '.$resultFile);

        //fwrite($handle, $srchStyle . "-" . $srchColl . "-"  . $drumSize  . PHP_EOL);

        $pendantTorqueFtLb = $pendantInLbs * $firstLayerMomentArm * (1 + ($accelInFtSecSec / 32.2516));
        //fwrite($handle, "pendantTorqueFtLb: "  . $pendantTorqueFtLb . PHP_EOL);

        switch ($srchStyle) {
            case "S":
            case "SM":
            case "MMD":
            case "SHO":
            case "U":
                $liftTorqueFtLb = ($adjustedTorque - $torqueToOvercomeCollectorFriction) / $torqueSafetyFactor;
                $torqueActiveLiftLength = ($liftTorqueFtLb - ($reelInertia * $accelInFtSecSec / (32.2516 * $firstLayerMomentArm)) - $pendantTorqueFtLb) / ($cableWgt * $firstLayerMomentArm * (1 + ($accelInFtSecSec / 32.2516)));
                //fwrite($handle, "liftTorqueFtLb: "  . $liftTorqueFtLb . PHP_EOL);
                //fwrite($handle, "torqueActiveLiftLength: "  . $torqueActiveLiftLength . PHP_EOL);
                break;
            case "P":
                $torqueActiveLiftLength = ($torqueFromMotor - ($pendantInLbs * $firstLayerMomentArm)) / ($cableWgt * $firstLayerMomentArm);
                break;
            case "K":
                $liftTorqueFtLb = ($adjustedTorque - $torqueToOvercomeCollectorFriction) / ($torqueSafetyFactor);
                $torqueActiveLiftLength = ($liftTorqueFtLb - ($reelInertia * $accelInFtSecSec / (32.2516 * $firstLayerMomentArm))) / ($cable["weight"] * $firstLayerMomentArm * (1 + ($accelInFtSecSec / 32.2516)));
                break;
            case "TMR":
                $facmi = ($rmoti * pow($gearRatio, 2) * $accelInFtSecSec) / (32.2516 * $firstLayerMomentArm);
                $rnme = ($speedInFtSec * $gearRatio) / (2 * $pi * $firstLayerMomentArm);
                if ($rnme > 450) {
                    switch ($specificInput) {
                        case false:
                            $liftApplCalcs = array(
                                'validTorque' => false,
                                'reason' => 3
                            );
                            return $liftApplCalcs;
                        case true:
                            $invalidWarning = true;
                            return;
                    }
                }
                if ($rnme > 600) {
                    $tqoute = 0;
                } else {
                    $tqoute = sqrt(pow($tqsiz, 2) * (1 - (pow($rnme, 2) / pow(600, 2))));
                }
                $adjustedTorque = $gearRatio * $tqoute;
                $ttel = ($adjustedTorque - $torqueToOvercomeCollectorFriction) / $torqueSafetyFactor;
                $torqueActiveLiftLength = ($ttel - ($reelInertia * $accelInFtSecSec / (32.2516 * $firstLayerMomentArm)) - $pendantTorqueFtLb - $facmi) / ($cableWgt * $firstLayerMomentArm * (1 + ($accelInFtSecSec / 32.2516)));
                break;
        }

        $torqueMaximumLiftLength = $torqueActiveLiftLength + $deadWrapLength;
        //fwrite($handle, "torqueMaximumLiftLength: "  . $torqueMaximumLiftLength . PHP_EOL);

        if ($torqueActiveLiftLength < $travelInFt) {
            switch ($specificInput) {
                case false:
                    $liftApplCalcs = array(
                        'validTorque' => false,
                        'reason' => 3
                    );
                    //fwrite($handle, "------------------------------------------------- "  . PHP_EOL);
                    //fwrite($handle, " "  . PHP_EOL);
                    //fclose($handle);
                    return $liftApplCalcs;
                case true:
                    break;
            }
        }

        $maxFullLayersFromTorqueLiftR = 1;
        $extraWrapsAfterFullLayersTorqueLiftR = 1;
        $tempCircumferenceTotal = $deadWrapLength;
        //fwrite($handle, "tempCircumferenceTotal: "  . $tempCircumferenceTotal . PHP_EOL);

        LINE440:
        $extraWrapsAfterFullLayersTorqueLiftR = $extraWrapsAfterFullLayersTorqueLiftR + 1;
        //fwrite($handle, "extraWrapsAfterFullLayersTorqueLiftR: "  . $extraWrapsAfterFullLayersTorqueLiftR . PHP_EOL);

        if ($extraWrapsAfterFullLayersTorqueLiftR > $maxWrapsPerLayerR) {
            goto LINE442;
        }
        $circumferenceAtCenterOfMaxFullLayerLift = ($drumSize + (2 * $maxFullLayersFromTorqueLiftR - 1) * $cableThick) * $pi / 12;
        //fwrite($handle, "circumferenceAtCenterOfMaxFullLayerLift: "  . $circumferenceAtCenterOfMaxFullLayerLift . PHP_EOL);

        $tempCircumferenceTotal = $tempCircumferenceTotal + $circumferenceAtCenterOfMaxFullLayerLift;
        //fwrite($handle, "tempCircumferenceTotal: "  . $tempCircumferenceTotal . PHP_EOL);

        if ($tempCircumferenceTotal <= $torqueMaximumLiftLength) {
            goto LINE440;
        }
        goto LINE445;
        LINE442:
        $extraWrapsAfterFullLayersTorqueLiftR = 0;
        $maxFullLayersFromTorqueLiftR = $maxFullLayersFromTorqueLiftR + 1;
        //fwrite($handle, "maxFullLayersFromTorqueLiftR: "  . $maxFullLayersFromTorqueLiftR . PHP_EOL);
        goto LINE440;
        LINE445:
        $extraWrapsAfterFullLayersTorqueLiftR = $extraWrapsAfterFullLayersTorqueLiftR - 1;
        $maxFullLayersFromTorqueLiftR = $maxFullLayersFromTorqueLiftR - 1;
        //fwrite($handle, "extraWrapsAfterFullLayersTorqueLiftR: "  . $extraWrapsAfterFullLayersTorqueLiftR . PHP_EOL);
        //fwrite($handle, "maxFullLayersFromTorqueLiftR: "  . $maxFullLayersFromTorqueLiftR . PHP_EOL);

        $maxWrapsFromTorqueLift = ($maxWrapsPerLayerR * $maxFullLayersFromTorqueLiftR + $extraWrapsAfterFullLayersTorqueLiftR);
        //fwrite($handle, "maxWrapsFromTorqueLift: "  . $maxWrapsFromTorqueLift . PHP_EOL);
        //fwrite($handle, "maxFullLayersFromTorqueLiftR: "  . $maxFullLayersFromTorqueLiftR . PHP_EOL);
        //fwrite($handle, "maxWrapsPerLayerR: "  . $maxWrapsPerLayerR . PHP_EOL);

        $maxLengthCableFromTorqueLift = (($drumSize + $maxFullLayersFromTorqueLiftR * $cableThick) * $pi / 12 * $maxWrapsPerLayerR * $maxFullLayersFromTorqueLiftR) + (($drumSize + ((2 * $maxFullLayersFromTorqueLiftR + 1) * $cableThick)) * $pi / 12 * $extraWrapsAfterFullLayersTorqueLiftR);
        //fwrite($handle, "maxLengthCableFromTorqueLift: "  . $maxLengthCableFromTorqueLift . PHP_EOL);

        $maxActiveLengthOfcableFromTorqueLift = $maxLengthCableFromTorqueLift - $deadWrapLength;
        //fwrite($handle, "maxActiveLengthOfcableFromTorqueLift: "  . $maxActiveLengthOfcableFromTorqueLift . PHP_EOL);

        if ($maxActiveLengthOfcableFromTorqueLift < $travelInFt) {
            switch ($specificInput) {
                case false:
                    $liftApplCalcs = array(
                        'validTorque' => false,
                        'reason' => 3
                    );
                    //fwrite($handle, "------------------------------------------------- "  . PHP_EOL);
                    //fwrite($handle, " "  . PHP_EOL);
                    //fclose($handle);
                    return $liftApplCalcs;
                    break;
                case true:
                    break;
            }
        }
        switch ($srchStyle) {
            case "S":
            case "SM":
            case "MMD":
            case "SHO":
            case "U":
            case "K":
                $unusedSpringTurnsForLift = 0;
                $availableSpringTurnsForlift = 0;

                if ($maxUsableWrapsR < $springTurnsAvailAfterPretensionR) {
                    goto LINE450;
                }
                $maxLiftCapacityOfReel = $turnsActiveCableLength;
                //fwrite($handle, "maxLiftCapacityOfReel: "  . $maxLiftCapacityOfReel . PHP_EOL);

                $unusedSpringTurnsForLift = 0;
                $maxFullLayersAtLiftCapacity = $maxFullLayersFromTurnsR;
                //fwrite($handle, "maxFullLayersAtLiftCapacity: "  . $maxFullLayersAtLiftCapacity . PHP_EOL);

                $extraWrapsAtLiftCapacity = $extraWrapsAfterFullLayersTurnsR;
                //fwrite($handle, "extraWrapsAtLiftCapacity: "  . $extraWrapsAtLiftCapacity . PHP_EOL);

                if ($maxWrapsFromTorqueLift >= $springTurnsAvailAfterPretensionR) {
                    goto LINE448;
                }
                $maxLiftCapacityOfReel = $maxActiveLengthOfcableFromTorqueLift;
                $unusedSpringTurnsForLift = ($springTurnsAvailAfterPretensionR - $maxWrapsFromTorqueLift) / $gearRatio;
                //fwrite($handle, "maxLiftCapacityOfReel: "  . $maxLiftCapacityOfReel . PHP_EOL);
                //fwrite($handle, "unusedSpringTurnsForLift: "  . $unusedSpringTurnsForLift . PHP_EOL);

                $maxFullLayersAtLiftCapacity = $maxFullLayersFromTorqueLiftR;
                $extraWrapsAtLiftCapacity = $extraWrapsAfterFullLayersTorqueLiftR;
                //fwrite($handle, "maxFullLayersAtLiftCapacity: "  . $maxFullLayersAtLiftCapacity . PHP_EOL);
                //fwrite($handle, "extraWrapsAtLiftCapacity: "  . $extraWrapsAtLiftCapacity . PHP_EOL);

                LINE448:
                if ($extraWrapsAtLiftCapacity != 0) {
                    $maxFullLayersAtLiftCapacity = $maxFullLayersAtLiftCapacity + 1;
                }
                goto LINE452;
                LINE450:
                $maxLiftCapacityOfReel = $compartmentActiveCableLength;
                //fwrite($handle, "maxLiftCapacityOfReel: "  . $maxLiftCapacityOfReel . PHP_EOL);

                $unusedSpringTurnsForLift = 0;
                $availableSpringTurnsForlift = 0;

                $maxFullLayersAtLiftCapacity = $maxUsableLayersR;
                //fwrite($handle, "maxFullLayersAtLiftCapacity: "  . $maxFullLayersAtLiftCapacity . PHP_EOL);

                $extraWrapsAtLiftCapacity = 0;
                if ($maxWrapsFromTorqueLift >= $maxUsableWrapsR) {
                    goto LINE451;
                }
                $maxLiftCapacityOfReel = $maxActiveLengthOfcableFromTorqueLift;
                //fwrite($handle, "maxLiftCapacityOfReel: "  . $maxLiftCapacityOfReel . PHP_EOL);
                //fwrite($handle, "maxActiveLengthOfcableFromTorqueLift: "  . $maxActiveLengthOfcableFromTorqueLift . PHP_EOL);

                $availableSpringTurnsForlift = ($springTurnsAvailAfterPretensionR - $maxUsableWrapsR) / $gearRatio;
                $maxFullLayersAtLiftCapacity = $maxFullLayersFromTorqueLiftR;
                $extraWrapsAtLiftCapacity = $extraWrapsAfterFullLayersTorqueLiftR;
                //fwrite($handle, "availableSpringTurnsForlift: "  . $availableSpringTurnsForlift . PHP_EOL);
                //fwrite($handle, "maxFullLayersAtLiftCapacity: "  . $maxFullLayersAtLiftCapacity . PHP_EOL);
                //fwrite($handle, "extraWrapsAtLiftCapacity: "  . $extraWrapsAtLiftCapacity . PHP_EOL);

                LINE451:
                if ($extraWrapsAtLiftCapacity != 0) {
                    $maxFullLayersAtLiftCapacity = $maxFullLayersAtLiftCapacity + 1;
                    //fwrite($handle, "maxFullLayersAtLiftCapacity: "  . $maxFullLayersAtLiftCapacity . PHP_EOL);
                }
                LINE452:
                $spooledCableInertiaInsideRadius = $drumSize / 24;
                $spooledCableInertiaOutsideRadiusLift = ($drumSize + 2 * $maxFullLayersAtLiftCapacity * $cableThick) / 24;
                //fwrite($handle, "spooledCableInertiaInsideRadius: "  . $spooledCableInertiaInsideRadius . PHP_EOL);
                //fwrite($handle, "spooledCableInertiaOutsideRadiusLift: "  . $spooledCableInertiaOutsideRadiusLift . PHP_EOL);

                if ($srchStyle == "K") {
                    $spooledCableInertiaLift = ($hoseWgtBoth * $maxLiftCapacityOfReel / 2) * (pow($spooledCableInertiaInsideRadius, 2) + pow($spooledCableInertiaOutsideRadiusLift, 2));
                } else {
                    $spooledCableInertiaLift = ($cableWgt * $maxLiftCapacityOfReel / 2) * (pow($spooledCableInertiaInsideRadius, 2) + pow($spooledCableInertiaOutsideRadiusLift, 2));
                }
                //fwrite($handle, "spooledCableInertiaLift: "  . $spooledCableInertiaLift . PHP_EOL);

                $spoolFullMomentArmLift = ($drumSize + (2 * $maxFullLayersAtLiftCapacity - 1) * $cableThick) / 24;
                //fwrite($handle, "spoolFullMomentArmLift: "  . $spoolFullMomentArmLift . PHP_EOL);

                $torqueToLiftPendant = $pendantInLbs * $spoolFullMomentArmLift * $gearRatio;
                //fwrite($handle, "torqueToLiftPendant: "  . $torqueToLiftPendant . PHP_EOL);

                $pendantInertiaLift = $pendantInLbs * pow($spoolFullMomentArmLift, 2);
                //fwrite($handle, "pendantInertiaLift: "  . $pendantInertiaLift . PHP_EOL);

                $totalLiftInertia = $reelInertia + $spooledCableInertiaLift + $pendantInertiaLift;
                //fwrite($handle, "totalLiftInertia: "  . $totalLiftInertia . PHP_EOL);

                $rmpSpoolFullLift = $speedInFtSec / (2 * $pi * $spoolFullMomentArmLift * $gearRatio);
                //fwrite($handle, "rmpSpoolFullLift: "  . $rmpSpoolFullLift . PHP_EOL);

                $torqueToAccelerateReelLift = ($totalLiftInertia * pow($gearRatio, 2) * $rmpSpoolFullLift) / (5.133 * $speedInFtSec / $accelInFtSecSec);
                //fwrite($handle, "torqueToAccelerateReelLift: "  . $torqueToAccelerateReelLift . PHP_EOL);

                $adjPretensionTurns = $pretensionTurns * $gearRatio;
                //fwrite($handle, "adjPretensionTurns: "  . $adjPretensionTurns . PHP_EOL);

                $torqueFromPretensionTurnsLift = $adjSlopeFirstPartOfCurve * $adjPretensionTurns + $adjYInterceptFirstPartOfCurve;
                //fwrite($handle, "torqueFromPretensionTurnsLift: "  . $torqueFromPretensionTurnsLift . PHP_EOL);

                if ($adjPretensionTurns <= $adjMaxTurnsForFirstPartOfCurve) {
                    goto LINE454;
                }
                $torqueFromPretensionTurnsLift = $adjSlopeSecondPartOfCurve * $adjPretensionTurns + $adjYInterceptSecondPartOfCurve;
                //fwrite($handle, "torqueFromPretensionTurnsLift: "  . $torqueFromPretensionTurnsLift . PHP_EOL);

                if ($adjPretensionTurns <= $adjMaxTurnsForSecondPartOfCurve) {
                    goto LINE454;
                }
                $torqueFromPretensionTurnsLift = $adjSlopeThirdPartOfCurve * $adjPretensionTurns + $adjYInterceptThirdPartOfCurve;
                //fwrite($handle, "torqueFromPretensionTurnsLift: "  . $torqueFromPretensionTurnsLift . PHP_EOL);

                LINE454:
                $netTorqueWithReelFullLift = ($torqueFromPretensionTurnsLift - $torqueToAccelerateReelLift - $torqueToLiftPendant - $torqueToOvercomeCollectorFriction) / $torqueSafetyFactor;
                //fwrite($handle, "netTorqueWithReelFullLift: "  . $netTorqueWithReelFullLift . PHP_EOL);
                //fwrite($handle, "availableSpringTurnsForlift: "  . $availableSpringTurnsForlift . PHP_EOL);
                //fwrite($handle, "unusedSpringTurnsForLift: "  . $unusedSpringTurnsForLift . PHP_EOL);

                if ($netTorqueWithReelFullLift < 0) {
                    switch ($specificInput) {
                        case false:
                            $liftApplCalcs = array(
                                'validTorque' => false,
                                'reason' => 3
                            );
                            //fwrite($handle, "------------------------------------------------- "  . PHP_EOL);
                            //fwrite($handle, " "  . PHP_EOL);
                            //fclose($handle);
                            return $liftApplCalcs;
                            break;
                        case true:
                            break;
                    }
                }
                if ($availableSpringTurnsForlift != 0 || $unusedSpringTurnsForLift != 0) {
                    switch ($specificInput) {
                        case false:
                            $liftApplCalcs = array(
                                'validTorque' => false,
                                'reason' => 3
                            );
                            //fwrite($handle, "------------------------------------------------- "  . PHP_EOL);
                            //fwrite($handle, " "  . PHP_EOL);
                            //fclose($handle);
                            return $liftApplCalcs;
                            break;
                        case true:
                            break;
                    }
                }
                $rnme = 0;
                $tqoute = 0;
                break;
            case "P":
                $maxLiftCapacityOfReel = $compartmentActiveCableLength;
                //fwrite($handle, "maxLiftCapacityOfReel: "  . $maxLiftCapacityOfReel . PHP_EOL);

                $maxFullLayersAtLiftCapacity = $maxUsableLayersR;
                //fwrite($handle, "maxFullLayersAtLiftCapacity: "  . $maxFullLayersAtLiftCapacity . PHP_EOL);

                $extraWrapsAtLiftCapacity = 0;
                if ($compartmentActiveCableLength < $maxActiveLengthOfcableFromTorqueLift) {
                    goto LINE600;
                }
                $maxLiftCapacityOfReel = $maxActiveLengthOfcableFromTorqueLift;
                //fwrite($handle, "maxLiftCapacityOfReel: "  . $maxLiftCapacityOfReel . PHP_EOL);

                $maxFullLayersAtLiftCapacity = $maxFullLayersFromTorqueLiftR;
                //fwrite($handle, "maxFullLayersAtLiftCapacity: "  . $maxFullLayersAtLiftCapacity . PHP_EOL);

                $extraWrapsAtLiftCapacity = $extraWrapsAfterFullLayersTorqueLiftR;
                //fwrite($handle, "extraWrapsAtLiftCapacity: "  . $extraWrapsAtLiftCapacity . PHP_EOL);
                break;
            case "TMR":
                $maxLiftCapacityOfReel = $compartmentActiveCableLength;
                if ($maxWrapsFromTorqueLift < $maxUsableWrapsR) {
                    $maxLiftCapacityOfReel = $maxActiveLengthOfcableFromTorqueLift;
                }
                break;

        }
        // $availableSpringTurnsForlift = 0;
        LINE600:
        $validTorque = true;
        //fwrite($handle, "validTorque: "  . $validTorque . PHP_EOL);
        //fwrite($handle, "------------------------------------------------- "  . PHP_EOL);
        //fwrite($handle, " "  . PHP_EOL);
        //fclose($handle);

        $liftApplCalcs = array(
            'validTorque' => $validTorque,
            'maxLengthCableFromTorqueLift' => $maxLengthCableFromTorqueLift,
            'maxFullLayersFromTorqueLiftR' => $maxFullLayersFromTorqueLiftR,
            'unusedSpringTurnsForLift' => $unusedSpringTurnsForLift,
            'torqueActiveLiftLength' => $torqueActiveLiftLength,
            'maxLiftCapacityOfReel' => $maxLiftCapacityOfReel,
            'availableSpringTurnsForLift' => $availableSpringTurnsForlift,
            'extraWrapsAfterFullLayersTorqueLiftR' => $extraWrapsAfterFullLayersTorqueLiftR,
            'netTorqueWithReelFullLift' => $netTorqueWithReelFullLift,
            'maxActiveLengthOfCableFromTorqueLift' => $maxActiveLengthOfcableFromTorqueLift,
            'rnme' => $rnme,
            'tqoute' => $tqoute,
            'reason' => 0
        );
        return $liftApplCalcs;
    }

    public function calcRetrieveApplCM( $modelIndex, $pretensionTurns, $application, $initialCMCalcs, $cable, $gearRatio, $specificInput, $srchSpring, $srchStyle, $srchFrame, $srchColl) {

        $pi = 3.14159;
        //$pendantInLbs = $application["pendantWeight"];
        $centerLineInFt = $application["centerline"];
        $accelInFtSecSec = floatval($application["accel"]);

        $cableThick = $cable["thickness"];
        $cableWgt = $cable["weight"];

        $cbend = $initialCMCalcs['cbend'];
        $spoolWeight = $initialCMCalcs['spoolWeight'];
        $coefficient = $initialCMCalcs['coefficient'];
        $turnsActiveCableLength = $initialCMCalcs["turnsActiveCableLength"];
        $compartmentActiveCableLength = $initialCMCalcs["compartmentActiveCableLength"];
        $torqueToOvercomeCollectorFriction = $initialCMCalcs["torqueToOvercomeCollectorFriction"];
        $reelInertia = $initialCMCalcs["reelInertia"];
        $maxUsableLayersR = $initialCMCalcs["maxUsableLayersR"];
        $maxFullLayersFromTurnsR = $initialCMCalcs["maxFullLayersFromTurnsR"];
        $drumSize = $initialCMCalcs["drumSize"];

        //$resultFile = "C:\\Users\\nwachukwuc1\\Desktop\\calcRetrieveApplCMResult.txt";
        //$handle = fopen($resultFile, 'a') or die('Cannot open file:  '.$resultFile);

        //fwrite($handle, $srchStyle . $srchFrame . "-" . $srchColl . "-" . $srchSpring . "11" . "0" . $pretensionTurns . PHP_EOL);
        //fwrite($handle, "Values from calcRetrieveCMCalcs" . PHP_EOL.PHP_EOL);
        //fwrite($handle, "cableThick: " . $cableThick . PHP_EOL);
        //fwrite($handle, "cableWgt: " . $cableWgt . PHP_EOL);
        //fwrite($handle, "torqueToOvercomeCollectorFriction: " . $torqueToOvercomeCollectorFriction . PHP_EOL);
        //fwrite($handle, "cbend: " . $cbend . PHP_EOL);
        //fwrite($handle, "coefficient: " . $coefficient . PHP_EOL);
        //fwrite($handle, "spoolWeight: " . $spoolWeight . PHP_EOL);
        //fwrite($handle, "reelInertia: " . $reelInertia . PHP_EOL);
        //fwrite($handle, "turnsActiveCableLength: " . $turnsActiveCableLength . PHP_EOL);
        //fwrite($handle, "maxFullLayersFromTurnsR: " . $maxFullLayersFromTurnsR . PHP_EOL);
        //fwrite($handle, "compartmentActiveCableLength: " . $compartmentActiveCableLength . PHP_EOL);
        //fwrite($handle, "drumSize: " . $drumSize . PHP_EOL);
        //fwrite($handle, "maxUsableLayersR: " . $maxUsableLayersR . PHP_EOL);
        //fwrite($handle, "gearRatio: " . $gearRatio . PHP_EOL);

        $maximumRetrieveCapacityOfReel = $compartmentActiveCableLength;
        $maxFullLayersAtRetrieveCapacity = $maxUsableLayersR;
        //fwrite($handle, "maximumRetrieveCapacityOfReel: " . $maximumRetrieveCapacityOfReel . PHP_EOL);
        //fwrite($handle, "maxFullLayersAtRetrieveCapacity: " . $maxFullLayersAtRetrieveCapacity . PHP_EOL);

        if ($turnsActiveCableLength >= $maximumRetrieveCapacityOfReel) {
            goto LINE485;
        }
        $maximumRetrieveCapacityOfReel = $turnsActiveCableLength;
        $maxFullLayersAtRetrieveCapacity = $maxFullLayersFromTurnsR;
        //fwrite($handle, "maximumRetrieveCapacityOfReel: " . $maximumRetrieveCapacityOfReel . PHP_EOL);
        //fwrite($handle, "turnsActiveCableLength: " . $turnsActiveCableLength . PHP_EOL);
        //fwrite($handle, "maxFullLayersAtRetrieveCapacity: " . $maxFullLayersAtRetrieveCapacity . PHP_EOL);
        //fwrite($handle, "maxFullLayersFromTurnsR: " . $maxFullLayersFromTurnsR . PHP_EOL);
        LINE485:
        $spooledCableInertiaInsideRadius = $drumSize / 24.0;
        //fwrite($handle, "spooledCableInertiaInsideRadius: " . $spooledCableInertiaInsideRadius . PHP_EOL);

        $spooledCableInertiaOutsideRadiusRetrieve = ($drumSize + 2.0 * $maxFullLayersAtRetrieveCapacity * $cableThick) / 24.0;
        //fwrite($handle, "spooledCableInertiaOutsideRadiusRetrieve: " . $spooledCableInertiaOutsideRadiusRetrieve . PHP_EOL);
        //fwrite($handle, "maxFullLayersAtRetrieveCapacity: " . $maxFullLayersAtRetrieveCapacity . PHP_EOL);

        $spooledCableInertiaRetrieve = ($cableWgt * $maximumRetrieveCapacityOfReel / 2.0) * (pow($spooledCableInertiaInsideRadius, 2) + pow($spooledCableInertiaOutsideRadiusRetrieve, 2));
        //fwrite($handle, "spooledCableInertiaRetrieve: " . $spooledCableInertiaRetrieve . PHP_EOL);

        $totalRetrieveInertia = $reelInertia + $spooledCableInertiaRetrieve;
        //fwrite($handle, "totalRetrieveInertia: " . $totalRetrieveInertia . PHP_EOL);
        //fwrite($handle, "reelInertia: " . $reelInertia . PHP_EOL);
        //fwrite($handle, "spooledCableInertiaRetrieve: " . $spooledCableInertiaRetrieve . PHP_EOL);

        $spoolFullMomentArmRetrieve = ($drumSize + (2 * $maxFullLayersAtRetrieveCapacity - 1) * $cableThick) / 24;
        //fwrite($handle, "spoolFullMomentArmRetrieve: " . $spoolFullMomentArmRetrieve . PHP_EOL);

        $torqueToAccelerateReelRetrieve = ($totalRetrieveInertia * pow($gearRatio, 2) * $accelInFtSecSec) / ($spoolFullMomentArmRetrieve * 32.16);
        //fwrite($handle, "torqueToAccelerateReelRetrieve: " . $torqueToAccelerateReelRetrieve . PHP_EOL);
        //fwrite($handle, "totalRetrieveInertia: " . $totalRetrieveInertia . PHP_EOL);
        //fwrite($handle, "gearRatio: " . $gearRatio . PHP_EOL);
        //fwrite($handle, "accelInFtSecSec: " . $accelInFtSecSec . PHP_EOL);
        //fwrite($handle, "spoolFullMomentArmRetrieve: " . $spoolFullMomentArmRetrieve . PHP_EOL);

        $adjPretensionTurns = $pretensionTurns * $gearRatio;
        //fwrite($handle, "adjPretensionTurns: " . $adjPretensionTurns . PHP_EOL);

        $itempb = intval($adjPretensionTurns);
        //fwrite($handle, "itempb: " . $itempb . PHP_EOL);

        $springTorqueAvailForReeling = $this->getCMspringData($itempb, $srchSpring);
        //fwrite($handle, "springTorqueAvailForReeling: " . $springTorqueAvailForReeling . PHP_EOL);

        $torqueFromPretensionTurnsRetrieve = $springTorqueAvailForReeling;
        //fwrite($handle, "torqueFromPretensionTurnsRetrieve: " . $torqueFromPretensionTurnsRetrieve . PHP_EOL);

        LINE490:
        $tcabfr = ((0.9003 * $spoolFullMomentArmRetrieve) * ($pi * $spoolFullMomentArmRetrieve /2.0 * $cableWgt) * $gearRatio) * (1.0 + ($accelInFtSecSec * $gearRatio / 32.16));
        //fwrite($handle, "tcabfr: " . $tcabfr . PHP_EOL);

        $tbrgfr = ((($torqueFromPretensionTurnsRetrieve * 24 / $drumSize) + $spoolWeight + ($cableWgt * $maximumRetrieveCapacityOfReel)) * $coefficient * 2.0 / $drumSize) * $drumSize / 24.0 * $gearRatio;
        //fwrite($handle, "tbrgfr: " . $tbrgfr . PHP_EOL);

        $netTorqueWithReelFullRetrieve = $torqueFromPretensionTurnsRetrieve - ($torqueToAccelerateReelRetrieve + $torqueToOvercomeCollectorFriction + $cbend + $tcabfr + $tbrgfr);
        //fwrite($handle, "netTorqueWithReelFullRetrieve: " . $netTorqueWithReelFullRetrieve . PHP_EOL);

        $maxCenterLineHeight = $netTorqueWithReelFullRetrieve / (($spoolFullMomentArmRetrieve * $cableWgt * $gearRatio) * (1 + ($accelInFtSecSec * $gearRatio / 32.16)));
        //fwrite($handle, "maxCenterLineHeight: " . $maxCenterLineHeight . PHP_EOL);

        //fwrite($handle, "----------------------------------------------------------------------------" . PHP_EOL);
        //fwrite($handle, " " . PHP_EOL);

        if ($maxCenterLineHeight < 0) {
            $maxCenterLineHeight = 0;
        }
        if ($maxCenterLineHeight < $centerLineInFt) {
            $specificInput = false;
            switch ($specificInput) {
                case false:
                    $retrieveApplCalcs = array(
                        'validTorque' => false,
                        'reason' => 3
                    );
                    return $retrieveApplCalcs;
                    break;
                case true:
                    $invalidWarning = true;
                    break;
            }
        }

        $validTorque = true;
        $retrieveApplCalcs = array(
            'validTorque' => $validTorque,
            'reason' => 0,
            'netTorqueWithReelFullRetrieve' => $netTorqueWithReelFullRetrieve,
            'maxCenterLineHeight' => $maxCenterLineHeight,
            'maximumRetrieveCapacityOfReel' => $maximumRetrieveCapacityOfReel
        );
        return $retrieveApplCalcs;
    }

    public function calcRetrieveAppl($srchStyle, $modelIndex, $pretensionTurns, $application, $initialCalcs, $cable, $drumSize, $gearRatio, $validTorque, $specificInput) {


        $turnsActiveCableLength = $initialCalcs["turnsActiveCableLength"];
        $adjMaxTurnsForSecondPartOfCurve = $initialCalcs["AdjMaxTurnsForSecondPartOfCurve"];
        $adjYInterceptSecondPartOfCurve = $initialCalcs["AdjyInterceptSecondPartOfCurve"];
        $adjSlopeSecondPartOfCurve = $initialCalcs["AdjSlopeSecondPartOfCurve"];
        $compartmentActiveCableLength = $initialCalcs["compartmentActiveCableLength"];
        $deadWrapLength = $initialCalcs['deadWrapLength'];
        $torqueToOvercomeCollectorFriction = $initialCalcs["torqueToOvercomeCollectorFriction"];
        $reelInertia = $initialCalcs["reelInertia"];
        $maxUsableLayersR = $initialCalcs["maxUsableLayersR"];
        $adjSlopeFirstPartOfCurve = $initialCalcs["AdjSlopeFirstPartOfCurve"];
        $adjYInterceptFirstPartOfCurve = $initialCalcs["AdjyInterceptFirstPartOfCurve"];
        $adjMaxTurnsForFirstPartOfCurve = $initialCalcs["AdjMaxTurnsForFirstPartOfCurve"];
        $torqueSafetyFactor = $initialCalcs["torqueSafetyFactor"];
        $maxFullLayersFromTurnsR = $initialCalcs["maxFullLayersFromTurnsR"];
        $extraWrapsAfterFullLayersTurnsR = $initialCalcs["extraWrapsAfterFullLayersTurnsR"];
        $adjYInterceptThirdPartOfCurve = $initialCalcs["AdjyInterceptThirdPartOfCurve"];
        $adjSlopeThirdPartOfCurve = $initialCalcs["AdjSlopeThirdPartOfCurve"];
        $firstLayerMomentArm = $initialCalcs["firstLayerMomentArm"];
        $rmoti = $initialCalcs["rmoti"];
        $tqsiz = $initialCalcs["tqsiz"];

        $speedInFtSec = $application["travelSpeed"];
        $accelInFtSecSec = floatval($application["accel"]);
        $centerLineInFt = $application['centerline'];

        $cableThick = $cable["thickness"];
        $cableWgt = $cable["weight"];

        //initialize some variables to 0 to prevent errors.
        $rnme = 0; $pi = 3.14159; $netTorqueWithReelFullRetrieve = 0; $maxCenterLineHeight = 0;
        $maximumRetrieveCapacityOfReel = 0;

        switch ($srchStyle) {
            case "S":
            case "SM":
            case "MMD":
            case "SHO":
            case "U":
                Debugbar::info("Hit retrieve calculations for type S SM MMD SHO U");
                $maximumRetrieveCapacityOfReel = $compartmentActiveCableLength;
                $maxFullLayersAtRetrieveCapacity = $maxUsableLayersR;
                $extraWrapsAtRetrieveCapacity = 0;
                if ($turnsActiveCableLength >= $maximumRetrieveCapacityOfReel) {
                    goto LINE485;
                }
                $maximumRetrieveCapacityOfReel = $turnsActiveCableLength;
                $maxFullLayersAtRetrieveCapacity = $maxFullLayersFromTurnsR;
                $extraWrapsAtRetrieveCapacity = $extraWrapsAfterFullLayersTurnsR;
                LINE485:
                if ($extraWrapsAtRetrieveCapacity != 0) {
                    $maxFullLayersAtRetrieveCapacity = $maxFullLayersAtRetrieveCapacity + 1;
                }
                $spooledCableInertiaInsideRadius = $drumSize / 24;
                $spooledCableInertiaOutsideRadiusRetrieve = ($drumSize + 2 * $maxFullLayersAtRetrieveCapacity * $cableThick) / 24;
                $spooledCableInertiaRetrieve = ($cableWgt * $maximumRetrieveCapacityOfReel / 2) * (pow($spooledCableInertiaInsideRadius, 2) + pow($spooledCableInertiaOutsideRadiusRetrieve, 2));
                $totalRetrieveInertia = $reelInertia + $spooledCableInertiaRetrieve;
                $spoolFullMomentArmRetrieve = ($drumSize + (2 * $maxFullLayersAtRetrieveCapacity - 1) * $cableThick) / 24;
                $rpmSpoolFullRetrieve = $speedInFtSec / (2 * pi() * $spoolFullMomentArmRetrieve * $gearRatio);// changed on Nov 7, 16- from: $rpmSpoolFullRetrieve = $speedInFtSec / (2 / pi() * $spoolFullMomentArmRetrieve * $gearRatio)

                $torqueToAccelerateReelRetrieve = ($totalRetrieveInertia * pow($gearRatio, 2) * $rpmSpoolFullRetrieve) / (5.133 * $speedInFtSec / $accelInFtSecSec);

                $adjPretensionTurns = $pretensionTurns * $gearRatio;
                $torqueFromPretensionTurnsRetrieve = $adjSlopeFirstPartOfCurve * $adjPretensionTurns + $adjYInterceptFirstPartOfCurve;
                if ($adjPretensionTurns <= $adjMaxTurnsForFirstPartOfCurve) {
                    goto LINE490;
                }
                $torqueFromPretensionTurnsRetrieve = $adjSlopeSecondPartOfCurve * $adjPretensionTurns + $adjYInterceptSecondPartOfCurve;
                if ($adjPretensionTurns <= $adjMaxTurnsForSecondPartOfCurve) {
                    goto LINE490;
                }
                $torqueFromPretensionTurnsRetrieve = $adjSlopeThirdPartOfCurve * $adjPretensionTurns + $adjYInterceptThirdPartOfCurve;
                LINE490:
                $netTorqueWithReelFullRetrieve = ($torqueFromPretensionTurnsRetrieve - $torqueToAccelerateReelRetrieve - $torqueToOvercomeCollectorFriction) / $torqueSafetyFactor;
                $maxCenterLineHeight = ($netTorqueWithReelFullRetrieve / $spoolFullMomentArmRetrieve) / $cableWgt;
                if ($maxCenterLineHeight < $centerLineInFt) {
                    Debugbar::info($specificInput . "fsda");
                    switch ($specificInput) {
                        case false:

                            $retrieveApplCalcs = array(
                                'validTorque' => false,
                                'reason' => 3
                            );
                            return $retrieveApplCalcs;
                            break;//break statement not needed after return statement
                        case true:
                            $invalidWarning = true;
                            break;
                    }

                }

                break;
            case "TMR":
                $maximumRetrieveCapacityOfReel = $compartmentActiveCableLength;
                $maxFullLayersAtRetrieveCapacity = $maxUsableLayersR;
                $spooledCableInertiaInsideRadius = $drumSize/24;

                $facmie = ($rmoti * pow($gearRatio,2) * $accelInFtSecSec) / (32.2516 * $firstLayerMomentArm);
                $rnme = ($speedInFtSec * $gearRatio) / (2 * $pi * $firstLayerMomentArm);
                if ($rnme > 450){
                    switch ($specificInput){
                        case false:
                            $retrieveApplCalcs = array(
                                'validTorque' => false,
                                'reason' => 3
                            );
                            return $retrieveApplCalcs; //equivelent to exit sub
                        case true:
                            $invalidWarning = true;
                            break;
                    }
                }
                if ($rnme > 600){
                    $tqoute = 0;
                }
                else {
                    $tqoute = sqrt(pow($tqsiz, 2) * (1 - (pow($rnme, 2) / pow(600, 2))));
                }
                $torke = $gearRatio * $tqoute;
                $ttere = ($torke - $torqueToOvercomeCollectorFriction) / $torqueSafetyFactor;

                $r2re = ($drumSize + 2 * $cableThick) / 24;
                $wrcber = ($cableWgt * $deadWrapLength / 2) * (pow($spooledCableInertiaInsideRadius, 2) + pow($r2re, 2));
                $wrtote = $reelInertia + $wrcber;
                $rete = ($ttere - ($wrtote * $accelInFtSecSec / (32.2516 * $firstLayerMomentArm)) - $facmie) / ($cableWgt * $firstLayerMomentArm);

                //spool full
                $rf = ($drumSize + (2 * $maxUsableLayersR - 1) * $cableThick) / 24;

                $facmif  = ($rmoti * pow($gearRatio, 2) * $accelInFtSecSec) / (32.2516 * $rf);
                $rnmf = ($speedInFtSec * $gearRatio) / (2 * $pi * $rf);
                if ($rnmf > 600){
                    switch ($specificInput){
                        case false:
                            $retrieveApplCalcs = array(
                                'validTorque' => false,
                                'reason' => 3
                            );
                            return $retrieveApplCalcs; //equivelent to exit sub
                        case true:
                            $invalidWarning = true;
                            break;
                    }
                }
                if ($rnmf > 600){
                    $tqoutf = 0;
                }
                else{
                    $tqoutf = sqrt(pow($tqsiz, 2) * (1 - (pow($rnmf, 2) / pow(600, 2))));
                }
                $torkf = $gearRatio * $tqoutf;
                $tterf = ($torkf - $torqueToOvercomeCollectorFriction) / $torqueSafetyFactor;

                $r2rf = ($drumSize + 2 * $maxFullLayersAtRetrieveCapacity * $cableThick) /24; //line 2532
                $wrcbfr = ($cableWgt * $maximumRetrieveCapacityOfReel /2) * (pow($spooledCableInertiaInsideRadius,2) + pow($r2rf, 2));
                $wrtotf = $reelInertia + $wrcbfr;
                $retf = ($tterf - ($wrtotf * $accelInFtSecSec / (32.2516 * $rf)) - $facmif) / ($cableWgt * $rf);

                $retr = $retf;

                if ($rete < $retf){
                    $retr = $rete;
                }

                if ($retr < $centerLineInFt){
                    switch ($specificInput){
                        case false:
                            $retrieveApplCalcs = array(
                                'validTorque' => false,
                                'reason' => 3
                            );
                            return $retrieveApplCalcs; //equivelent to exit sub
                        case true:
                            $invalidWarning = true;
                            break;
                    }
                }
                $maxCenterLineHeight = $retr;

                $adjustedTorque = $torke;

                if ($torkf > $torke){
                    $adjustedTorque = $torkf;
                }
                break;
        }

        $validTorque = true;

        Debugbar::info($specificInput . "fsda");
        $retrieveApplCalcs = array(
            'validTorque' => $validTorque,
            'reason' => 0,
            'netTorqueWithReelFullRetrieve' => $netTorqueWithReelFullRetrieve,
            'maxCenterLineHeight' => $maxCenterLineHeight,
            'maxCapacity' => $maximumRetrieveCapacityOfReel,
            'centerLineInFt' => $centerLineInFt, //added this for debug, it may work but the vb6 code will need to be examined to confirm that this is propper
            'rnme' => $rnme

        );
        return $retrieveApplCalcs;


    }

    public function calcLiftApplCM($pretensionTurns, $application, $initialCMCalcs, $cable, $srchSpring, $specificInput, $srchStyle, $srchFrame, $srchColl) {

        $calcLiftApplCM = array(); $invalidWarning = 0;
        $pi = 3.14159;

        //Get the global vars in the $initialCMCalcs array (This array is populated in doInitialCMCalcs())
        $springTurnsAvailAfterPretensionR = $initialCMCalcs['springTurnsAvailAfterPretensionR'];
        $maxFullLayersFromTurnsR = $initialCMCalcs['maxFullLayersFromTurnsR'];
        $turnsActiveCableLength = $initialCMCalcs['turnsActiveCableLength'];
        $maxUsableWrapsR = $initialCMCalcs['maxUsableWrapsR'];
        $wrap = $initialCMCalcs['wraparr'];
        $ixarr = $initialCMCalcs['ixarr'];
        $reelInertia = $initialCMCalcs['reelInertia'];
        $coefficient = $initialCMCalcs['coefficient'];
        $spoolWeight = $initialCMCalcs['spoolWeight'];
        $drumSize = $initialCMCalcs['drumSize'];
        $torqueSafetyFactor = $initialCMCalcs['torqueSafetyFactor'];
        $cbend = $initialCMCalcs['cbend'];
        $torqueToOvercomeCollectorFriction = $initialCMCalcs['torqueToOvercomeCollectorFriction'];
        $adjustedTorque = $initialCMCalcs['adjustedTorque'];
        $momentArm = $initialCMCalcs['momentArm'];
        $maxUsableLayersR = $initialCMCalcs['maxUsableLayersR'];
        $compartmentActiveCableLength = $initialCMCalcs['compartmentActiveCableLength'];
        $ra = $initialCMCalcs['ra'];
        $row = $initialCMCalcs['row'];
        $gearRatio = $initialCMCalcs['gearRatio'];

        //Get the aoolication properties
        $pendantInLbs = $application["pendantWeight"];
        $accelInFtSecSec = floatval($application["accel"]);

        //Get the cable properties
        $cableWgt = $cable["weight"];
        $cableThick = $cable['thickness'];

        //File to hold variable values for comparison
        //$resultFile = "C:\\Users\\nwachukwuc1\\Desktop\\calcLiftApplCMResult.txt";
        //$handle = fopen($resultFile, 'a') or die('Cannot open file:  '.$resultFile);

        //fwrite($handle, $srchStyle . $srchFrame . "-" . $srchColl . "-" . $srchSpring . "11" . "0" . $pretensionTurns . PHP_EOL);
        //fwrite($handle, "Values from doInitialCMCalcs" . PHP_EOL.PHP_EOL);
        //fwrite($handle, "adjustedTorque: " . $adjustedTorque . PHP_EOL);
        //fwrite($handle, "torqueToOvercomeCollectorFriction: " . $torqueToOvercomeCollectorFriction . PHP_EOL);
        //fwrite($handle, "ra: " . $ra . PHP_EOL);
        //fwrite($handle, "cbend: " . $cbend . PHP_EOL);
        //fwrite($handle, "momentArm: " . $momentArm . PHP_EOL);
        //fwrite($handle, "coefficient: " . $coefficient . PHP_EOL);
        //fwrite($handle, "spoolWeight: " . $spoolWeight . PHP_EOL);
        //fwrite($handle, "reelInertia: " . $reelInertia . PHP_EOL);
        //fwrite($handle, "maxUsableWrapsR: " . $maxUsableWrapsR . PHP_EOL);
        //fwrite($handle, "springTurnsAvailAfterPretensionR: " . $springTurnsAvailAfterPretensionR . PHP_EOL);
        //fwrite($handle, "turnsActiveCableLength: " . $turnsActiveCableLength . PHP_EOL);
        //fwrite($handle, "maxFullLayersFromTurnsR: " . $maxFullLayersFromTurnsR . PHP_EOL);
        //fwrite($handle, "compartmentActiveCableLength: " . $compartmentActiveCableLength . PHP_EOL);
        //fwrite($handle, "drumSize: " . $drumSize . PHP_EOL);
        //fwrite($handle, "maxUsableLayersR: " . $maxUsableLayersR . PHP_EOL);
        //fwrite($handle, "gearRatio: " . $gearRatio . PHP_EOL);

        $pendantTORQUEftlb = ($pendantInLbs * $momentArm * $gearRatio) * (1.0 + ($accelInFtSecSec * $gearRatio / 32.16));
        //fwrite($handle, "pendantTORQUEftlb: " . $pendantTORQUEftlb . PHP_EOL);

        $Tcabel = ((0.9003 * $momentArm) * ($pi * $momentArm / 2.0 * $cableWgt) * $gearRatio) * (1 + ($accelInFtSecSec * $gearRatio / 32.16));
        //$Tcabel = floatval(number_format($Tcabel, 7));
        //fwrite($handle, "Tcabel: " . $Tcabel . PHP_EOL);

        $liftTORQUEftlb = $adjustedTorque - $torqueToOvercomeCollectorFriction - $cbend;
        //$liftTORQUEftlb = floatval(number_format($liftTORQUEftlb, 7));
        //fwrite($handle, "liftTORQUEftlb: " . $liftTORQUEftlb . PHP_EOL);
        //fwrite($handle, "adjustedTorque: " . $adjustedTorque . PHP_EOL);
        //fwrite($handle, "torqueToOvercomeCollectorFriction: " . $torqueToOvercomeCollectorFriction . PHP_EOL);
        //fwrite($handle, "cbend: " . $cbend . PHP_EOL);

        $TBRGEL = ((($adjustedTorque * 24 / $drumSize) + $spoolWeight) * $coefficient * 2.0 / $drumSize) * $drumSize / 24 * $gearRatio;
        //$TBRGEL = floatval(number_format($TBRGEL, 7));
        //fwrite($handle, "TBRGEL: " . $TBRGEL . PHP_EOL);
        //fwrite($handle, "spoolWeight: " . $spoolWeight . PHP_EOL);
        //fwrite($handle, "coefficient: " . $coefficient . PHP_EOL);

        $TSPLEL = ($reelInertia * pow($gearRatio, 2) * $accelInFtSecSec) / ($ra * 32.16);
        //$TSPLEL = floatval(number_format($TSPLEL, 7));
        //fwrite($handle, "TSPLEL: " . $TSPLEL . PHP_EOL);
        //fwrite($handle, "reelInertia: " . $reelInertia . PHP_EOL);
        //fwrite($handle, "accelInFtSecSec: " . $accelInFtSecSec . PHP_EOL);

        $VLIFT = ($liftTORQUEftlb - ($TSPLEL + $TBRGEL + $Tcabel + $pendantTORQUEftlb)) / ($cableWgt * $momentArm * $gearRatio * (1.0 + ($accelInFtSecSec * $gearRatio / 32.16)));
        //$VLIFT = floatval(number_format($VLIFT, 7));
        //fwrite($handle, "VLIFT: " . $VLIFT . PHP_EOL);
        //fwrite($handle, "liftTORQUEftlb: " . $liftTORQUEftlb . PHP_EOL);
        //fwrite($handle, "TSPLEL: " . $TSPLEL . PHP_EOL);
        //fwrite($handle, "TBRGEL: " . $TBRGEL . PHP_EOL);
        //fwrite($handle, "Tcabel: " . $Tcabel . PHP_EOL);
        //fwrite($handle, "pendantTORQUEftlb: " . $pendantTORQUEftlb . PHP_EOL);
        //fwrite($handle, "cableWgt: " . $cableWgt . PHP_EOL);
        //fwrite($handle, "momentArm: " . $momentArm . PHP_EOL);
        //fwrite($handle, "gearRatio: " . $gearRatio . PHP_EOL);
        //fwrite($handle, "accelInFtSecSec: " . $accelInFtSecSec . PHP_EOL);


        $RLMAX = $VLIFT;
        $IYIND = 1;
        $extraWRAPSafterFULLLAYERStorqueLIFTr = 0;
        $TEMPcircumferenceTOTAL = 0;
        $maxWrapsFromTorqueLift = 0; //public Var assigned value in this function
        $maxLengthCableFromTorqueLift = 0;//public Var assigned value in this function

        LINE440:
        $extraWRAPSafterFULLLAYERStorqueLIFTr = $extraWRAPSafterFULLLAYERStorqueLIFTr + 1.0;
        //fwrite($handle, "extraWRAPSafterFULLLAYERStorqueLIFTr: " . $extraWRAPSafterFULLLAYERStorqueLIFTr . PHP_EOL);

        //fwrite($handle, "ixarr[IYIND]: " . $ixarr[$IYIND] . PHP_EOL);
        if ($extraWRAPSafterFULLLAYERStorqueLIFTr > $ixarr[$IYIND]) {
            goto LINE442;
        }
        $TEMPcircumferenceTOTAL = $TEMPcircumferenceTOTAL + $wrap[$IYIND];
        //fwrite($handle, "TEMPcircumferenceTOTAL: " . $TEMPcircumferenceTOTAL . PHP_EOL);
        //fwrite($handle, "wrap[IYIND]: " . $wrap[$IYIND] . PHP_EOL);

        if ($TEMPcircumferenceTOTAL <= $RLMAX) {
            goto LINE440;
        }
        goto LINE445;

        LINE442:
        $extraWRAPSafterFULLLAYERStorqueLIFTr = 0;
        $IYIND = $IYIND + 1;
        //fwrite($handle, "IYIND: " . $IYIND . PHP_EOL);
        goto LINE440;
        LINE445:
        $extraWRAPSafterFULLLAYERStorqueLIFTr = $extraWRAPSafterFULLLAYERStorqueLIFTr - 1;
        //fwrite($handle, "extraWRAPSafterFULLLAYERStorqueLIFTr: " . $extraWRAPSafterFULLLAYERStorqueLIFTr . PHP_EOL);
        $IYFIN = $IYIND - 1;
        //fwrite($handle, "IYFIN: " . $IYFIN . PHP_EOL);

        if ($IYFIN == 0) {
            goto LINE449;
        }
        for ($IYIND = 1; $IYIND <= $IYFIN; $IYIND++) {
            $maxWrapsFromTorqueLift = $maxWrapsFromTorqueLift + $ixarr[$IYIND];
            $maxLengthCableFromTorqueLift = $maxLengthCableFromTorqueLift + $row[$IYIND];
            //fwrite($handle, "maxWrapsFromTorqueLift: " . $maxWrapsFromTorqueLift . PHP_EOL);
            //fwrite($handle, "ixarr[IYIND]: " . $ixarr[$IYIND] . PHP_EOL);
            //fwrite($handle, "maxLengthCableFromTorqueLift: " . $maxLengthCableFromTorqueLift . PHP_EOL);
            //fwrite($handle, "row[IYIND]: " . $row[$IYIND] . PHP_EOL);
        }
        LINE449:
        $IYIND = $IYFIN + 1;
        $maxWrapsFromTorqueLift = $maxWrapsFromTorqueLift + $extraWRAPSafterFULLLAYERStorqueLIFTr;
        //fwrite($handle, "IYIND: " . $IYIND . PHP_EOL);
        //fwrite($handle, "maxWrapsFromTorqueLift: " . $maxWrapsFromTorqueLift . PHP_EOL);

        $EL = $extraWRAPSafterFULLLAYERStorqueLIFTr;
        $maxLengthCableFromTorqueLift = $maxLengthCableFromTorqueLift + $EL * $wrap[$IYIND];
        $maxActiveLengthOfCableFromTorqueLift = $maxLengthCableFromTorqueLift;
        $maxFULLLAYERSfromTORQUEliftR = $IYFIN;
        //fwrite($handle, "EL: " . $EL . PHP_EOL);
        //fwrite($handle, "maxLengthCableFromTorqueLift: " . $maxLengthCableFromTorqueLift . PHP_EOL);
        //fwrite($handle, "maxActiveLengthOfCableFromTorqueLift: " . $maxActiveLengthOfCableFromTorqueLift . PHP_EOL);
        //fwrite($handle, "maxFULLLAYERSfromTORQUEliftR: " . $maxFULLLAYERSfromTORQUEliftR . PHP_EOL);
        //fwrite($handle, "wrap[IYIND]: " . $wrap[$IYIND] . PHP_EOL);

        if ($EL == 0) {
            $maxFULLLAYERSfromTORQUEliftR = $IYFIN - 1;
        }

        $unusedSPRINGturnsFORlift = 0.0;
        $availableSPRINGturnsFORlift = 0.0;

        if ($maxUsableWrapsR < $springTurnsAvailAfterPretensionR) {
            goto LINE450;
        }

        $maxLiftCapacityOfReel = $turnsActiveCableLength;
        $maxFULLlayersatLIFTcapacity = $maxFullLayersFromTurnsR;
        //fwrite($handle, "maxLiftCapacityOfReel: " . $maxLiftCapacityOfReel . PHP_EOL);
        //fwrite($handle, "maxFULLlayersatLIFTcapacity: " . $maxFULLlayersatLIFTcapacity . PHP_EOL);

        $unusedSPRINGturnsFORlift = 0;
        if ($maxWrapsFromTorqueLift >= $springTurnsAvailAfterPretensionR) {
            goto LINE448;
        }
        $maxLiftCapacityOfReel = $maxActiveLengthOfCableFromTorqueLift;
        $maxFULLlayersatLIFTcapacity = $maxFULLLAYERSfromTORQUEliftR;
        $unusedSPRINGturnsFORlift = ($springTurnsAvailAfterPretensionR - $maxWrapsFromTorqueLift) / $gearRatio;
        //fwrite($handle, "maxLiftCapacityOfReel: " . $maxLiftCapacityOfReel . PHP_EOL);
        //fwrite($handle, "maxFULLlayersatLIFTcapacity: " . $maxFULLlayersatLIFTcapacity . PHP_EOL);
        //fwrite($handle, "unusedSPRINGturnsFORlift: " . $unusedSPRINGturnsFORlift . PHP_EOL);


        LINE448:
        goto LINE452;

        LINE450:
        $maxLiftCapacityOfReel = $compartmentActiveCableLength;
        //fwrite($handle, "compartmentActiveCableLength: " . $compartmentActiveCableLength . PHP_EOL);
        //fwrite($handle, "maxLiftCapacityOfReel: " . $maxLiftCapacityOfReel . PHP_EOL);
        $unusedSPRINGturnsFORlift = 0;
        $availableSPRINGturnsFORlift = 0;
        $maxFULLlayersatLIFTcapacity = $maxUsableLayersR;
        //fwrite($handle, "maxFULLlayersatLIFTcapacity: " . $maxFULLlayersatLIFTcapacity . PHP_EOL);
        //fwrite($handle, "maxUsableLayersR: " . $maxUsableLayersR . PHP_EOL);
        if ($maxWrapsFromTorqueLift >= $maxUsableWrapsR) {
            goto LINE451;
        }
        $maxLiftCapacityOfReel = $maxActiveLengthOfCableFromTorqueLift;
        //fwrite($handle, "maxActiveLengthOfCableFromTorqueLift: " . $maxActiveLengthOfCableFromTorqueLift . PHP_EOL);
        //fwrite($handle, "maxLiftCapacityOfReel: " . $maxLiftCapacityOfReel . PHP_EOL);
        $availableSPRINGturnsFORlift = ($springTurnsAvailAfterPretensionR - $maxUsableWrapsR) / $gearRatio;
        //fwrite($handle, "availableSPRINGturnsFORlift: " . $availableSPRINGturnsFORlift . PHP_EOL);
        //fwrite($handle, "springTurnsAvailAfterPretensionR: " . $springTurnsAvailAfterPretensionR . PHP_EOL);
        //fwrite($handle, "maxUsableWrapsR: " . $maxUsableWrapsR . PHP_EOL);
        //fwrite($handle, "gearRatio: " . $gearRatio . PHP_EOL);
        $maxFULLlayersatLIFTcapacity = $maxFULLLAYERSfromTORQUEliftR;
        //fwrite($handle, "maxFULLlayersatLIFTcapacity: " . $maxFULLlayersatLIFTcapacity . PHP_EOL);
        LINE451:
        LINE452:
        $spooledcableINERTIAinsideRADIUS = $drumSize / 24;
        //fwrite($handle, "spooledcableINERTIAinsideRADIUS: " . $spooledcableINERTIAinsideRADIUS . PHP_EOL);

        $spooledcableINERTIAoutsideRADIUSlift = ($drumSize + 2.0 * $maxFULLlayersatLIFTcapacity * $cableThick) / 24;
        //fwrite($handle, "spooledcableINERTIAoutsideRADIUSlift: " . $spooledcableINERTIAoutsideRADIUSlift . PHP_EOL);

        $spooledcableINERTIAlift = ($cableWgt * $maxLiftCapacityOfReel / 2) * (pow($spooledcableINERTIAinsideRADIUS, 2) + pow($spooledcableINERTIAoutsideRADIUSlift, 2.0));
        //fwrite($handle, "spooledcableINERTIAlift: " . $spooledcableINERTIAlift . PHP_EOL);

        $spoolFULLmomentARMlift = ($drumSize + (2 * $maxFULLlayersatLIFTcapacity - 1) * $cableThick) / 24;
        //fwrite($handle, "spoolFULLmomentARMlift: " . $spoolFULLmomentARMlift . PHP_EOL);

        $totalLIFTinertia = $reelInertia + $spooledcableINERTIAlift;
        //fwrite($handle, "totalLIFTinertia: " . $totalLIFTinertia . PHP_EOL);

        $TSPLFL = ($totalLIFTinertia * pow($gearRatio, 2.0) * $accelInFtSecSec) / ($spoolFULLmomentARMlift * 32.16);
        //fwrite($handle, "TSPLFL: " . $TSPLFL . PHP_EOL);

        $TEMPB = $pretensionTurns * $gearRatio;
        //fwrite($handle, "TEMPB: " . $TEMPB . PHP_EOL);

        $ITEMPB = $TEMPB;
        $springTorqueAvailForReeling = $this->getCMspringData($ITEMPB, $srchSpring);
        //fwrite($handle, "springTorqueAvailForReeling: " . $springTorqueAvailForReeling . PHP_EOL);

        $torqueTOaccelerateREELlift = $springTorqueAvailForReeling;
        //fwrite($handle, "torqueTOaccelerateREELlift: " . $torqueTOaccelerateREELlift . PHP_EOL);

        $TCABFL = ((0.9003 * $spoolFULLmomentARMlift) * ($cableWgt * $pi * $spoolFULLmomentARMlift / 2) * $gearRatio) * (1 + ($accelInFtSecSec * $gearRatio / 32.16));
        //fwrite($handle, "TCABFL: " . $TCABFL . PHP_EOL);

        $TPENFL = ($pendantInLbs * $spoolFULLmomentARMlift * $gearRatio) * (1 + ($accelInFtSecSec * $gearRatio / 32.16));
        //fwrite($handle, "TPENFL: " . $TPENFL . PHP_EOL);

        $TBGRFL = ((($totalLIFTinertia * 24 / $drumSize) + $spoolWeight + ($cableWgt * $maxLiftCapacityOfReel)) * $coefficient * 2 / $drumSize) * $drumSize / 24 * $gearRatio;
        //fwrite($handle, "TBGRFL: " . $TBGRFL . PHP_EOL);
        //fwrite($handle, "TSPLFL: " . $TSPLFL . PHP_EOL);
        //fwrite($handle, "torqueToOvercomeCollectorFriction: " . $torqueToOvercomeCollectorFriction . PHP_EOL);
        //fwrite($handle, "cbend: " . $cbend . PHP_EOL);

        //Not sure why, but TBRGFL doesnt exist in the code. TBGRFL does, but there's two characters switched. This somehow yeilds the correct result. WHAT.
        $TBRGFL=0;
        //$netTorqueWithReelFullLift = $torqueTOaccelerateREELlift - ($TSPLFL + $torqueToOvercomeCollectorFriction + $cbend + $TBRGFL + $TCABFL + $TPENFL);
         $netTorqueWithReelFullLift = $torqueTOaccelerateREELlift - ($TSPLFL + $torqueToOvercomeCollectorFriction + $cbend + $TBGRFL + $TCABFL + $TPENFL);
        //fwrite($handle, "------------------------------------------------------------------------------------" . PHP_EOL);
        //fwrite($handle, "netTorqueWithReelFullLift: " . $netTorqueWithReelFullLift . PHP_EOL);
        //fwrite($handle, "torqueTOaccelerateREELlift: " . $torqueTOaccelerateREELlift . PHP_EOL);
        //fwrite($handle, "TSPLFL: " . $TSPLFL . PHP_EOL);
        //fwrite($handle, "torqueToOvercomeCollectorFriction: " . $torqueToOvercomeCollectorFriction . PHP_EOL);
        //fwrite($handle, "cbend: " . $cbend . PHP_EOL);
        //fwrite($handle, "TBRGFL: " . $TBRGFL . PHP_EOL);
        //fwrite($handle, "TCABFL: " . $TCABFL . PHP_EOL);
        //fwrite($handle, "TPENFL: " . $TPENFL . PHP_EOL);
        //fwrite($handle, "------------------------------------------------------------------------------------" . PHP_EOL);

        //fwrite($handle, "availableSPRINGturnsFORlift: " . $availableSPRINGturnsFORlift . PHP_EOL);
        //fwrite($handle, "unusedSPRINGturnsFORlift: " . $unusedSPRINGturnsFORlift . PHP_EOL);


        //Close the file
        //fclose($handle);

        $specificInput = false; //$specificInput - This is an array populated in checkSpecificInput function
        if (!$specificInput) {
            if ($netTorqueWithReelFullLift < 0) { //$stretchApplCalcs
                $calcLiftApplCM  = array(
                    'validTorque' => false,
                    'reason' => 3
                );
                return $calcLiftApplCM;
            }
            if ($availableSPRINGturnsFORlift != 0 || $unusedSPRINGturnsFORlift != 0) {
                $calcLiftApplCM = array(
                    'validTorque' => false,
                    'reason' => 4
                );
                return $calcLiftApplCM;
            }
        }
        if ($netTorqueWithReelFullLift < 0 || $availableSPRINGturnsFORlift != 0 || $unusedSPRINGturnsFORlift != 0) {
            $invalidWarning = true;
        }
            $validTorque = true;
        $calcLiftApplCM = array(
            'validTorque' => $validTorque,
            'maxLengthCableFromTorqueLift' => $maxLengthCableFromTorqueLift,
            'maxFullLayersFromTorqueLiftR' => $maxFULLLAYERSfromTORQUEliftR,
            'unusedSpringTurnsForLift' => $unusedSPRINGturnsFORlift,
            'netTorqueWithReelFullLift' => $netTorqueWithReelFullLift, //1,
            'maxLiftCapacityOfReel' => $maxLiftCapacityOfReel,
            'extraWrapsAfterFullLayersTorqueLiftR' => $extraWRAPSafterFULLLAYERStorqueLIFTr,
            "availableSpringTurnsForLift" => $availableSPRINGturnsFORlift,
            "maxActiveLengthOfCableFromTorqueLift" => $maxActiveLengthOfCableFromTorqueLift,
            "maxWrapsFromTorqueLift" => $maxWrapsFromTorqueLift,
            'reason' => 0,
        );
        return $calcLiftApplCM;
    }//End of calcLiftApplCM

    public function calcUreelWidth($cableOrHose, $hoseIdCode, $cableThick){

        $uReelWidth = 0; $uReelWidthInp = "";
        switch($cableOrHose){
            case "HD":
            case "HS":
                switch($hoseIdCode){
                    case "4":
                        $uReelWidth = 6;
                        $uReelWidthInp = "06";
                        break;
                    case "6":
                        $uReelWidth = 6;
                        $uReelWidthInp = "06";
                        break;
                    case "8":
                        $uReelWidth = 6;
                        $uReelWidthInp = "06";
                        break;
                    case "12":
                        $uReelWidth = 8;
                        $uReelWidthInp = "08";
                        break;
                    case "16":
                        $uReelWidth = 8;
                        $uReelWidthInp = "08";
                        break;
                    case "20":
                        $uReelWidth = 10;
                        $uReelWidthInp = "10";
                        break;
                    case "24":
                        $uReelWidth = 10;
                        $uReelWidthInp = "10";
                        break;
                }//End of switch select for hoseIdCode
                break;
            default:
                switch ($cableThick){
                    case ($cableThick < 1):
                        $uReelWidth = 7 * $cableThick;
                        break;
                    default:
                        $uReelWidth = 5 * $cableThick;
                        break;
                }
                if($uReelWidth != intval($uReelWidth)){
                    $uReelWidth = intval($uReelWidth + 1);
                }
                if($uReelWidth / 2 != intval($uReelWidth / 2)){
                    $uReelWidth = $uReelWidth + 1;
                }
                if($uReelWidth < 6){
                    $uReelWidth = 6;
                }
                $uReelWidthInp = trim(strval($uReelWidth));
                if(strlen($uReelWidthInp) == 1){
                    $uReelWidthInp = "0" . $uReelWidthInp;
                }
                break;
        }

        $calcUreelWidthResult = array(
            "uReelWidth" => $uReelWidth,
            "uReelWidthInp" => $uReelWidthInp
        );

        return $calcUreelWidthResult;
    }//End of method
}//End of class.

?>