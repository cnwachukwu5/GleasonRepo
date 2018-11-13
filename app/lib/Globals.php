<?php

class Globals {
    public static $CLIPpad = "1", $FLATpad = "2", $MIXEDpad = "3", $SINGLEpad = "4", $DUALpad = "5";
    public static $C40 = "C40", $C50 = "C50", $C60 = "C60", $I110 = "I110", $T50 = "T50";
    public static $I115 = "I115", $I120 = "I120", $I130 = "I130", $I132 = "I132", $I150 = "I150", $I152 = "I152",
        $I160 = "I160", $I162 = "I162";
    public static $PDQ300 = "PDQ300", $PDQ450 = "PDQ450", $PDQ700 = "PDQ700";

    //public $cableOrHose;
    public $reelWidthInp;
    public $srchMotor;
    public $hoseIDCode;
    public $torqueFromMotor;
    public $rmoti;
    public $tqsiz;
    public $computerToFigurePkg;
    public $pkgType;
    public $allRound;
    public $allFlat;
    public $userInputLoopDepth;
    public $noFlatRowsHold;
    public $qtyThisModelValid;
    public $numberModelsToReturn;
    public $securityCode;
    public $ratedTravel;
    public $activeTravelInInches;
    public $pkgTotalArea;
    public $windowArea;
    public $speedInFtMin;
    public $festInvalid;
    public $invalidWarning;
    public $validLAYOUT;

    public $noCableItems;
    public $cableThick;
    public $cableWidth;
    public $cableBend;
    public $startNo;
    public $stopNo;
    public $stepNo;
    public $cableROW;
    public $validBLANKROWstatus;
    //This will store the 'data' from the writeDetailSummary function and use it to store multiple calcs
    public  $calcResultData;

    //Used to invoke doInitialCMCalcs()
    public $gearRatio;
    public $maxTurnsFromSpring;
    public $turnsUsedPercent;
    public $qtyConductorLessGrndChk;
    public $grndChck;
    public $travelInFt;
    public $cableOrHose;
    public $specificInput;


    public function __construct() {
        $this->reelWidthInp = "";
        $this->srchMotor = "";
        $this->hoseIDCode = "";
        $this->torqueFromMotor = 0.0;
        $this->rmoti = 0.0;
        $this->tqsiz = 0.0;
        $this->computerToFigurePkg = "";
        $this->pkgType = "";
        $this->allRound = false;
        $this->allFlat = false;
        $this->userInputLoopDepth = 0.0;
        $this->noFlatRowsHold = 0;
        $this->qtyThisModelValid = 0;
        $this->numberModelsToReturn = 0;
        $this->securityCode = 0;
        $this->ratedTravel = 0;
        $this->activeTravelInInches = 0;
        $this->pkgTotalArea = 0;
        $this->windowArea = 0;
        $this->speedInFtMin = 0;
        $this->festInvalid = false;
        $this->invalidWarning = false;
        $this->validLAYOUT = false;
        $this->noCableItems = 0;
        $this->cableThick = array();
        $this->cableWidth = array();
        $this->cableBend = array();
        $this->startNo = range(1, 20);
        $this->stopNo = range(1, 20);
        $this->stepNo = range(1, 20);
        $this->cableROW = array();
        $this->validBLANKROWstatus = false;
        //calcResultData contructed here?
        $this->calcResultData = "";

        //Used to invoke doInitialCMCalcs()
        $this->gearRatio = 0;
        $this->maxTurnsFromSpring = 0;
        $this->turnsUsedPercent = 0;
        $this->qtyConductorLessGrndChk = 0;
        $this->grndChck = 0;
        $this->travelInFt = 0;
        $this->cableOrHose = 0;
        $this->specificInput = array();

    }
}

?>