<?php

class FestoonController extends BaseController {




    public function showAll() {
        return View::make('fest/fest', array("type" => "festoon"));
    }

    public function showResults(){
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
            "pn" => Input::get('identifier12'),
//            "ground" => $grnd['grndQty'],
//            "grndchck" => $grnd['grndchkQty'],
//            "hoseIDCode" => $hoseIDCode
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
        $crReel = array(
            "checkboxes" => Input::get('cr-checkboxes'),
            "springSize" => Input::get('s-springsize'),
            "collectorCode" => Input::get('s-collectorcode'),
            "gearRatio" => Input::get('s-gearratio'),
            "drumDiameter" => array("min" => Input::get('s-drummin'), "max" => Input::get('s-drummax')),
            "pretensTurn" => array("min" => Input::get('s-pretensmin'), "max" => Input::get('s-pretensmax'))
        );

        $trolleyinfo = array(
            "minWinHeight" => Input::get('minwindow-h'),
            "minWinWidth" => Input::get('minwindow-w'),
            "minWinWidth" => Input::get('minSaddleD')
        );

        print_r(Input::all());
        $this->findTheTrolley($crReel, $cable, $trolleyinfo, $application);

    }

    public function findTheTrolley($crReel, $cable, $trolleyinfo, $application){


        if($crReel["checkboxes"][0] == "any" || $crReel["checkboxes"][0] != "none") {
            $query = DB::table('alltrolley')->where('SERIES', 'C-RAIL');

            if ($crReel['checkboxes'][0] != 'any') {
                $query->whereIn('Frame', $crReel['checkboxes']);
            }

            if ($crReel['springSize'] == 'none') {
                $query->where('Springs', '');
            } else if ($crReel['springSize'] != 'all') {
                $query->where('Springs', $crReel['springSize']);
            }

            if ($crReel['gearRatio'] == 'none') {
                $query->where('Gear', '');
            }
            else if ($crReel['gearRatio'] != 'all') {
                $query->where('Gear', $crReel['gearRatio']);
            }

            $query->orderBy('Cost', 'Gear');
            $modelIndex = 1;
            $fests = array('params' => $crReel, 'rows' => $query->get());

            $this->loopThruTrolleys("C-RAIL", $crReel["checkboxes"][0], $fests, $modelIndex);

        }



    }
    public function whoFigurePkg(){
        $computerSelectTrolleyPossible = true;

        if($pkgType = 1){

        }else if($pkgType = 3 && $noCableitems > 20){ //nocableitems is how many cables searching for

        }else if($pkgType = 3 && $noCableItems >=7){

        }

    }

    private function loopThruTrolleys($festType, $modelSelected, $fests, $modelIndex)
    {
        $validPriceFound = true;

//        if($securityCode != 99){
//        }
        $invalidFestArray = array();
        $festIndex = 0;
        $recNumber = 0;
        $count= 0;
        $validFest = array();
        $festLength = count($fests['rows']);

        while($festIndex < $festLength){
            $fest = $fests['rows'][$festLength-$festIndex-1];
            $trolSysCode = $fest->MODEL;
            $trolModelNo = $fest->MODELNO;
            $trolEList = $fest->ELIST;
            $trolIList = $fest->ILIST;
            $trolTList = $fest->TLIST;
            $trolOTList = $fest->OTLIST;

            if($fest->NOTIERS > 0){
                $trolNoTiers = $fest->NOTIERS;
            }
            if($fest->MINDIA > 0){
                $trolMinDia = $fest->MINDIA;
            }
            if($fest->MAXDIA > 0){
                $trolMaxDia = $fest->MAXDIA;
            }
            if($fest->DDIM > 0){
                $trolDdim = $fest->DDIM;
            }

            if($fest->PDIM > 0){
                $trolPdim = $fest->PDIM;
            }
            if($fest->VDIM > 0){
                $trolVdim = $fest->VDIM;
            }
            if($fest->ILDIM > 0){
                $trolILdim = $fest->ILDIM;
            }
            if($fest->IWDIM > 0){
                $trolIWdim = $fest->IWDIM;
            }
            if($fest->EMDIM > 0){
                $trolEMdim = $fest->EMDIM;
            }
            if($fest->TLDIM > 0){
                $trolTLdim = $fest->TLDIM;
            }
            if($fest->TMDIM > 0){
                $trolTMdim = $fest->TMDIM;
            }
            if($fest->CMDIM > 0){
                $trolCMdim = $fest->CMDIM;
            }
            //declare const for pads



            switch($fest->CLAMPCODE){
                case 1:
                    $trolClampCode = "1";
                    break;
                case 2:
                    $trolClampCode = "2";
                    break;
                case 3:
                    $trolClampCode = "3";
                    break;
                case 4:
                    $trolClampCode = "4";
                    break;
                case 5:
                    $trolClampCode = "5";
                    break;

            }

            $festInvalid = false;
            $invalidWarning = false;
            switch($computerToFigurePkg)
            {
                case "y":
                    if($trolClampCode == "1"){
                        $this->findTrolleyClip();
                    }
                    else if($pkgType == $allRound){
                        $this->findTrolleyAllRound();
                    }
                    else if($pkgType == $allFlat){
                        $this->findTrolleyAllFlat();
                    }
                    break;
                case "N":
                    $this->findTrolleyManual();
                    break;
            }
            $loopDepthInInches = $userInputLoopDepth;
            $noFlatRows = $noFlatRowsHold;

            if($modelSelected == "all" && $qtyThisModelValid == $numberModelsToReturn)
            {
                $this->clearVariables();
                return;//return what? data?
            }

        }
        $this->clearVariables();

    }



    private function checkTrolleyTravel($trolSysCode){
        $ratedSpeed = 0;
        $validSpeed = false;
        switch($trolSysCode){
            case "C40":
                $ratedSpeed = 200;
                break;
            case "C50":;
                $ratedSpeed = 400;
                break;
            case "C60":
                $ratedSpeed = 500;
                break;
            case "T50":
                $ratedSpeed = 400;
                break;
            case "I110":
                $ratedSpeed = 400;
                break;
            case "I115":
                $ratedSpeed = 500;
                break;
            case "I120":
                $ratedSpeed = 500;
                break;
            case "I130":
                $ratedSpeed = 500;
                break;
            case "I132":
                $ratedSpeed = 500;
                break;
            case "I150":
                $ratedSpeed = 500;
                break;
            case "I152":
                $ratedSpeed = 500;
                break;
            case "I160":
                $ratedSpeed = 500;
                break;
            case "I162":
                $ratedSpeed = 500;
                break;
            case "PDQ300":
                $ratedSpeed = 500;
                break;
            case "PDQ450":
                $ratedSpeed = 500;
                break;
            case "PDQ700":
                $ratedSpeed = 500;
                break;
        }

        if($activeTravelInInches > $ratedTravel * 12 && $securityCode != 99){
            return;
        }
        $validTravel = true;
        return;

    }

    private function checkWindowArea(){
        $noWindows = 1;
        $validArea = false;
        if($trolClampCode = "4" || $trolClampCode = "5"){
            $noWindows = 2;
        }
        if($pkgTotalArea > $windowArea){
            return;
        }
        $validArea = true;
        return;

    }
    private function findTrolleyClip(){
        $this->checkTrolleySpeed();
        if(!$validSpeed){
            //INVALID STORE
        }
        $this->checkTrolleyTravel();
        if(!$validTravel){

        }
        $this->calcClipADim();
        $this->calcClipAtPerLoop();
        $this->checkTrolleyLoad();
        if(!$validLoad){

        }
        $this->checkMinClipDiam();
        if(!$validMinClip){

        }
        $this->checkMaxClipDiam();
        if(!$validMaxDiam){

        }

        $this->storeValidTrolley();
        return;

    }
    private function checkTrolleySpeed(){
        $ratedSpeed = 0;
        $validSpeed = false;
        switch($trolSysCode){
            case "C40":
                $ratedSpeed = 350;
                break;
            case "C50":
                $ratedSpeed = 350;
                break;
            case "C60":
                $ratedSpeed = 450;
                break;
            case "T50":
                $ratedSpeed = 350;
                break;
            case "I110":
                $ratedSpeed = 500;
                break;
            case "I115":
                $ratedSpeed = 500;
                break;
            case "I120":
                $ratedSpeed = 650;
                break;
            case "I130":
                $ratedSpeed = 650;
                break;
            case "I132":
                $ratedSpeed = 650;
                break;
            case "I150":
                $ratedSpeed = 650;
                break;
            case "I152":
                $ratedSpeed = 650;
                break;
            case "I160":
                $ratedSpeed = 650;
                break;
            case "I162":
                $ratedSpeed = 650;
                break;
            case "PDQ300":
                $ratedSpeed = 400;
                break;
            case "PDQ450":
                $ratedSpeed = 500;
                break;
            case "PDQ700":
                $ratedSpeed = 600;
                break;
        }

        if($speedInFtMin > $ratedSpeed){
            $validSpeed = true;
        }
        return;

    }

    private function findTrolleyAllRound(){

        $this->checkTrolleySpeed();
        if(!$validSpeed){
            //INVALID STORE
        }
        $this->checkTrolleyTravel();
        if(!$validTravel){

        }

            $this->calcNonClipADim($thickestCable);
            $this->calcNonClipAtPerLoop();
            $this->checkTrolleyLoad();


        if(!$validLoad){


        }
        $this->checkPkgMinSaddle();
        if(!$validMinSaddle){

        }
        $this->checkWindowHeight($thickestCable);
        if(!$validWinHeight){

        }
        $this->checkWindowWidth();
        if(!$validWinWidth){

        }
        $this->checkRoundStackDev();
        if(!$validStackDev){

        }


        $this->storeValidTrolley();


    }
    private function checkRoundStackDev(){
      $validStackDev = false;
      switch($trolClampCode){
        /*
        Public Const CLIPpad = "1", FLATpad = "2", MIXEDpad = "3"
        Public Const SINGLEpad = "4", DUALpad = "5"
        */

        case "2":
          if($trolSysCode>=$C40){
            if($thickestCable - $thinnestCable > .12){
              return;
            }

          }
          break;
          case "3":
          if($trolSysCode <= $I110){
            if($thickestCable - $thinnestCable > .25){
                return;
            }

          }
          if($trolSysCode > $I110){
            if($thickestCable - $thinnestCable > .63){
              return;
            }
          }
          break;
          case "4":
          case "5":
            if($thickestCable - $thinnestCable <= .63){
              $statusCheck = true;
            }else{
              $leftSide = 0; $rightSide = 0; $rightMin = 999;
              for($aa = 1; $aa < $noCableItems; $aa++){
                if($cableThick[$aa] <= $thinnestCable + .63){
                  $leftSide = $leftSide + $cableThick[$aa];
                }
                if($cableThick[$aa] > $thinnestCable + .63){
                  $rightSide = $rightSide + $cableThick[$aa];
                  if($cableThick[$aa] < $rightMin){
                    $rightMin = $cableThick[$aa];
                  }
                }
              }
              if($leftSide <= $trolVDim){
                if($rightSide <= $trolVDim){
                  if($thickestCable - $rightMin <= .63){
                    $statusCheck = true;
                    if($trolClampCode = "4"){
                      if(Abs($leftSide - $rightSide) > .63){
                        return;
                      }
                    }
                  }
                }
              }
            }
            break;

      }
      $validStackDev = true;
      return $validStackDev;

    }

    private function findTrolleyAllFlat(){
        $this->checkTrolleySpeed();
        if(!$validSpeed){
            //INVALID STORE
        }
        $this->checkTrolleyTravel();
        if(!$validTravel){

        }
        $this->checkWindowHeight();
        if(!$validWinHeight){

        }
        $this->checkWindowWidth();
        if(!$validWinWidth){

        }
        $this->checkWindowArea();
        if(!$validWindowArea){

        }


        $this->checkPkgMinSaddle();
        if(!$validMinSaddle){

        }

      switch($specificModelInput){
        case false:
        if($festInvalid){
          $festInvalid=false;
          return;
        }
        break;
        case true:
        if($festInvalid){
          $invalidWarning = true;
        }
        break;

      }
      $this->storeValidTrolley();


    }


    private function checkTrolleyLoad()
    {
        $ratedLoad = 0;
        $validLoad = false;
        switch($trolSysCode){
            case "C40":
                $ratedLoad = 50;
                break;
            case "C50":
                $ratedLoad = 80;
                break;
            case "C60":
                $ratedLoad = 125;
                break;
            case "T50":
                $ratedLoad = 50;
                break;
            case "I110":
                $ratedLoad = 150;
                break;
            case "I115":
                $ratedLoad = 450;
                break;
            case "I120":
                $ratedLoad = 450;
                break;
            case "I130":
                $ratedLoad = 700;
                break;
            case "I132":
                $ratedLoad = 700;
                break;
            case "I150":
                $ratedLoad = 1100;
                break;
            case "I152":
                $ratedLoad = 1100;
                break;
            case "I160":
                $ratedLoad = 1300;
                break;
            case "I162":
                $ratedLoad = 1100;
                break;
            case "PDQ300":
                $ratedLoad = 300;
                break;
            case "PDQ450":
                $ratedLoad = 450;
                break;
            case "PDQ700":
                $ratedLoad = 700;
                break;
        }
        switch($trolClampCode)
        {
            case "1":
                for($aa = 1; $aa < $noCableItems; $aa++)
                {
                    $totalCableLoad = $cableWgt[$aa] * ($clipCableLoop[$aa]/12);
                    $totalTrolleyLoad = $totalTrolleyLoad + $totalCableLoad;
                }
            default:
                for($aa = 1; $aa < $noCableItems; $aa++)
                {
                    $totalCableLoad = $cableWgt[$aa] * ($nonClipCableLoop/12);
                    $TotalTrolleyLoad = $totalTrolleyLoad + $totalCableLoad;
                }


        }


    }

    private function checkWindowHeight(){

        $validWinHeight = false;

        switch($pkgType){
            case $allRound:
                if($pkgHeight > $trolPDim){
                    return;
                }
                break;
            case $allFlat:
                switch($trolClampCode){
                    case "2":
                    case "3":
                        if($pkgHeight > $trolPDim){
                            return;
                        }
                    break;
                    case "4":
                    case "5":
                        if($pkgHeight <= 2 * $trolPDim){
                            $flatLeftHeight = 0;
                            $flatRightHeight = 0;
                            for($rowNum = 1; $rowNum<$noFlatRows; $rowNum++){
                                switch($rowNum % 2){
                                    case 1:
                                        $flatLeftHeight = $flatLeftHeight + $rowHeight[$rowNum];
                                        break;
                                    case 2:
                                        $flatRightIeght = $flatRightHeight + $rowHeight[$rowNum];
                                        break;
                                }
                            }
                            if($flatLeftHeight > $trolPDim){
                                return;
                            }
                            if($flatRightHeight > $trolPDim){
                                return;
                            }
                            if($trolClampCode == "4"){
                                if(abs($flatLeftHeight - $flatRightHeight) > .63){
                                    return;
                                }
                            }

                        }
                        else{
                            return;
                        }
                        break;


                }
                break;

        }
        $validWinHeight = true;
        return $validWinHeight;

    }
    private function checkPkgMinSaddle(){
        $validMinSaddle = false;
        switch($pkgType){
            case $allRound:
                if($pkgMinSaddle > $trolDDim){
                    return;
                }


                break;
            case $allFlat:
                if($pkgMinSaddle <= $trolDDim){
                    $maxDiam = $trolDDim + 2 * $trolPDim;

                }

        }


    }

    private function findFlatRowInfo(){
        $validStartStop = false;
        $lastThick = 0; $lastWidth = 0; $lastBend = 0; $noLast =0;

        for($currCable = 1; $currCable < 20; $currCable++){
          if($currCable > $noCableItems){
            $startNo[$currCable] = 1;
            $stopNo[$currCable] = 1;
            $stepNo[$currCable] = -1;
            goto nextCurrCable;
          }

          if($cableThick[$currCable] != $lastThick){
            $sameCable = "N";
          }
          if($cableWidth[$currCable] != $lastWidth){
            $sameCable = "N";
          }
          if($cableBend[$currCable] != $lastBend){
            $sameCable = "N";
          }


          if($sameCable = "Y"){
            $noLast = $noLast + 1;
          }else{
            $noLast = 0;
          }

          if($sameCable = "Y"){
            $startNoTemp = $startNO[$currCable - $noLast];
            $stopNoTemp = $stopNO[$currCable - $noLast];
            $totalIdenticalWidth= $cableWidth[$currCable];
            for($lastIdenticalCable = 1; $lastIdenticalCable<$noLast; $lastIdenticalCable++){
                $totalIdenticalWidth = $totalIdenticalWidth + $cableWidth[$currCable];
                if($totalIdenticalWidth > $trolVDim){
                    $startNoTemp = $startNoTemp++;
                    $totalIdenticalWidth = $currCable;
                }
            }
              $startNo[$currCable];
              $stopNo[$currCable];



          }
          else
          {
                $startNo[$currCable] = 1;
              if($cableBend[$currCable] * 2 <= $trolDDim){
                  goto startNoOk;
                  $cableStack = 0;
                  for($aa = $noCableItems; $aa == 1; $aa--){
                      if($cableBend[$aa] < $cableBend[$currCable]){
                          $cableStack = $cableStack + $cableThick[$aa];
                          $startNo[$currCable] = $startNo[$currCable] + 1;
                          if($cableBend[$currCable] * 2 <= $trolDDim+(2*$cableStack)){
                            goto startNoOk;
                          }
                      }
                  }




              }
              startNoOk:
              $totalWindowHeight = 0;
              switch($trolClampCode)
              {
                  case "2":
                  case "3":
                      break;
                  case "4":
                  case "5":
                      break;
              }
              $stopNo[$currCable] = 1;
              $cableStack = $cableThick[$currCable];

              for($aa = 1; $aa<$noCableItems; $aa++){
                  if($aa != $currCable) {
                      if ($cableStack + $cableThick[$aa] <= $totalWindowHeight) {
                          $cableStack = $cableStack + $cableThick[$aa];
                          $stopNo[$currCable] = $stopNo[$currCable] + 1;
                      } else {
                          goto stopNoDone;
                      }
                  }
              }

              stopNoDone:



          }

            $stepNo[$currCable] = 1;

            $lastThick = $cableThick[$currCable];
            $lastWidth = $cableWidth[$currCable];
            $lastBend = $cableBend[$currCable];

        nextCurrCable:
        }
        $validStartStop = true;
        for($currCable = 1; $currCable < $noCableItems; $currCable++){
            if($startNo[$currCable] > $stopNo[$currCable]){
                $validStartStop = false;
            }
        }
        return $validStartStop;

    }



    private function checkWindowWidth(){
        $validWinWidth = false;
        switch($pkgType){
            case "allRound":
                switch($trolClampCode){
                    case "flat":
                    case "mixed":
                        if($pkgWidth > $trolVDim){
                            return;
                        }
                    break;
                    case "single":
                    case "dual":
                        if($pkgWidth > 2*$trolVDim){
                            return;
                        }
                    break;
                }
                break;
            case "allFlat":
                if($pkgWidth > $trolVDim){
                    return;
                }
                break;

        }

    }
    private function calcNonClipAdim(){
        $nonclipADimension = 0;
        switch($trolSysCode){
            case "c40":
                if($trolClampCode == "2"){
                    $nonclipADimension = 2.48;
                }
            break;
            case "c50":
            case "T50":
                if($trolClampCode == "2"){
                    $nonclipADimension = 3.59;
                }
                if($trolClampCode == "3"){
                    $nonclipADimension = 4.54;
                }
            break;
            case "C60":
                if($trolClampCode == "2"){
                    $nonclipADimension = 5.62;
                }
            break;
            case "I110":
                if($trolClampCode == "2"){
                    $nonclipADimension = 3.48;
                }
                if($trolClampCode == "3"){
                    $nonclipADimension = 5.14;
                }

                break;
            case "I115":
                if($trolClampCode == "3"){
                    $nonclipADimension = 7;
                }
            break;
            case "I120":
            case "I130":
            case "I132":
                if($trolClampCode == "4" || $trolClampCode == "5"){
                    $nonclipADimension = 6.78+$stackHgt;
                }
                break;
            case "I150":
            case "I152":
            case "I160":
            case "I162":
                if($trolClampCode == "4" || $trolClampCode == "5"){
                    $nonclipADimension = 6.23+$stackHgt;
                }
                break;
            case "PDQ300":
                $nonclipADimension = 5.65;
                break;
            case "PDQ450":
                $nonclipADimension = 7.75;
                break;


        }
        return;

    }


    private function FindTrolleyManual(){
        if($trolDDim < $userInputsadldia){
            //invalidstore
        }
        if($trolPDim < $userInputWinHgt){

        }
        if($trolVDim < $userInputWinWidth){

        }

        if($festInvalid){
            $festInvalid = false;
        }

        $this->checkTrolleySpeed();
        if(!$validSpeed){
            //INVALID STORE
        }
        $this->checkTrolleyTravel();
        if(!$validTravel){

        }
        if($pkgType == $allRound){
            $this->calcNonClipADim($thickestCable);
        }
        if($pkgType != $allRound){
            $this->calcNonClipADim($flatPkgHeight);
        }
        $this->calcNonClipAtPerLoop();
        $this->checkTrolleyLoad();
        if(!$validLoad){

        }



        $this->storeValidTrolley();




    }


}

?>
