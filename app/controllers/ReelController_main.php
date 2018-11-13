<?php

//use Thujohn\Pdf;

class ReelController extends BaseController {
    //todo:Find a better way of constructing the globals class. and make sure the globals class doesnt get reconstructed at the wrong times and mess something up.
    //private $invalidReelArray;
    //private $validReels;

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
    //Creates a PDF from parameters and returns it
    public function printQuote() {
        //the quote parameters are pulled from the Print Options popup after cicking printQuote
        $quoteParameters = array(
            "squote" => Input::get('squote'),
            "discountReel" => Input::get('discountReel'),
            "addDiscount" => Input::get('addDiscount'),
            "firstname" => Input::get('firstname'),
            "numberOfReels" => Input::get("numberOfReels"),
            "checkboxes" => Input::get('accessories-checkboxes')
        );
       //reNotes is also pulled from Print Options
        $reNotes = Input::get('quoteNotes');
        //data comes from the main calculations, loaded from where it is encoded in the html , and must be decoded to be loaded. All other vars will pull from $data
        $data = unserialize(base64_decode(Input::get('str_var')));
        $custcomp = $data['cust-comp'];
        $custname = $data['cust-name'];
        $custaddr = $data['cust-addr'];
        $custphone = $data['cust-phone'];

        Debugbar::info($data['cust-name']);
        Debugbar::info($data['cust-comp']);
        Debugbar::info($data['cust-addr']);
        Debugbar::info($data['cust-phone']);

        $date = date("d/m/Y");
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

        //This html is what is loaded into the pdf, variables are inserted here and the output of the pdf is changed here
        $html = '<html>
        <head>

        </head>
        <body bgcolor="ffffff">
        <table align=bleedleft width=100% cellspacing=0 cellpadding=0 border=0>
        <tr>

        </tr>
        </table>
        <table width=100% cellspacing=0 cellpadding=0 border=0>
        <tr>

        </tr>
        <tr valign=top>
        <td colspan=168><font size=1>&nbsp;</font></td>
        </tr>
        <tr valign=top>
        <td colspan=71> </td>
        <td colspan=42 rowspan=5 nowrap><img alt="image" width=224 height=68 src="./public/images/defau000.jpg"></td>
        </tr>
        <tr valign=top>
        <td colspan=12> </td>
        <td colspan=44 rowspan=2><font size=4 face="times new roman"><b>QUOTATION</b></font></td>
        <td colspan=15> </td>
        <td colspan=11> </td>
        <td align=right colspan=7><font size=2 face="times new roman">Date:</font></td>
        <td colspan=2> </td>
        <td colspan=18 nowrap><font size=2 face="times new roman">' . $date . '</font></td>
        </tr>
        <tr valign=top>
        <td colspan=12> </td>
        <td colspan=15> </td>
        </tr>
        <tr valign=top>
        <td colspan=12> </td>
        <td align=right colspan=12></td>
        <td> </td>
        <td align=right colspan=6 nowrap></font></td>
        <td colspan=2> </td>
        <td></td>
        <td> </td>
        <td colspan=7 nowrap>></td>
        <td colspan=29> </td>
        <td colspan=7> </td>
        <td align=right colspan=11><font size=2 face="times new roman">Quote #:</font></td>
        <td colspan=2> </td>
        <td colspan=32><font size=2 face="times new roman">glea6027655635</font></td>
        </tr>
        <tr valign=top>
        <td colspan=71> </td>
        </tr>
        <tr valign=top>
        <td colspan=168><font size=1>&nbsp;</font></td>
        </tr>
        <tr valign=top>
        <td colspan=12> </td>
        <td colspan=36><font size=2 face="times new roman"><b><u>QUOTE FOR:</u></b></font></td>
        <td colspan=38> </td>
        <td colspan=18><font size=2 face="times new roman"><b><u>REPLY TO:*</u></b></font></td>
        </tr>
        <tr valign=top>
        <td colspan=12> </td>
        <td colspan=68><font size=2 face="times new roman">' . $custcomp . '</font></td>
        <td colspan=6> </td>
        <td colspan=49><font size=2 face="times new roman">' . $custname . '</font></td>
        </tr>
        <tr valign=top>
        <td colspan=12> </td>
        <td colspan=68><font size=2 face="times new roman">' . $custaddr . '</font></td>
        <td colspan=6> </td>
        <td><font size=2 face="times new roman">c/o</font></td>
        <td> </td>
        <td colspan=48><font size=2 face="times new roman">Gleason Test</font></td>
        </tr>
        <tr valign=top>
        <td colspan=86> </td>
        <td colspan=56><font size=2 face="times new roman">300000 Blaine\'s Lane</font></td>
        </tr>
        <tr valign=top>
        <td colspan=168><font size=1>&nbsp;</font></td>
        </tr>
        <tr valign=top>
        <td colspan=12> </td>
        <td colspan=41><font size=2 face="times new roman">Phone:  ' . $custphone . '</font></td>
        </tr>
        <tr valign=top>
        <td colspan=86> </td>
        <td colspan=26><font size=2 face="times new roman">Phone:  ' . 'num' . '</font></td>
        </tr>
        <tr valign=top>
        <td colspan=6> </td>
        <td align=right colspan=16><font size=2 face="times new roman">Attn:</font></td>
        </tr>
        <tr valign=top>
        <td colspan=86> </td>
        <td colspan=63><font size=1 face="times new roman">* Please make all P.O.\'s out to Gleason Reel - 600 S. Clark St, Mayville WI 53050</font></td>
        </tr>
        <tr valign=top>
        <td colspan=10> </td>
        <td align=right colspan=10><font size=2 face="times new roman">Re:</font></td>
        <td colspan=4> </td>
        <td colspan=141 nowrap><font size=2 face="times new roman">' . $reNotes . '</font></td>
        </tr>
        <tr valign=top>
        <td colspan=168><font size=1>&nbsp;</font></td>
        </tr>
        <tr valign=top>
        <td colspan=6> </td>
        <td colspan=156 rowspan=3><font size=3 face="times new roman">This quotation is based upon the following application parameters.  If the parameters shown below don\'t accurately reflect your application, please contact us and we will review and adjust this quote if necessary:</font></td>
        </tr>
        <tr valign=top>
        <td colspan=6> </td>
        </tr>
        <tr valign=top>
        <td colspan=6> </td>
        </tr>
        <tr valign=top>
        <td colspan=168><font size=1>&nbsp;</font></td>
        </tr>
        <tr valign=top>
        <td colspan=11> </td>
        <td colspan=32><font size=2 face="times new roman"><b>APPLICATION:</b></font></td>
        <td colspan=14> </td>
        <td colspan=20><font size=2 face="times new roman"><b>Application:</b></font></td>
        <td> </td>
        <td colspan=22><font size=2 face="times new roman">Stretch</font></td>
        <td> </td>
        <td align=right colspan=26><font size=2 face="times new roman"><b>Ambient Temp.:</b></font></td>
        <td colspan=2> </td>
        <td colspan=34><font size=2 face="times new roman">40 - 110 degrees F</font></td>
        </tr>
        <tr valign=top>
        <td colspan=59> </td>
        <td align=right colspan=17><font size=2 face="times new roman"><b>Travel:</b></font></td>
        <td colspan=2> </td>
        <td colspan=21><font size=2 face="times new roman">5.00 ft</font></td>
        <td colspan=11> </td>
        <td align=right colspan=16><font size=2 face="times new roman"><b>Speed:</b></font></td>
        <td colspan=3> </td>
        <td colspan=33><font size=2 face="times new roman">150.00 feet/min</font></td>
        </tr>
        <tr valign=top>
        <td colspan=59> </td>
        <td align=right colspan=22><font size=2 face="times new roman"><b>Percent Sag:</b></font></td>
        <td colspan=2> </td>
        <td colspan=20><font size=2 face="times new roman">Std %</font></td>
        <td colspan=8> </td>
        <td align=right colspan=20><font size=2 face="times new roman"><b>Acceleration:</b></font></td>
        <td colspan=3> </td>
        <td colspan=33><font size=2 face="times new roman">0.75 feet/sec²</font></td>
        </tr>
        <tr valign=top>
        <td colspan=168><font size=1>&nbsp;</font></td>
        </tr>
        <tr valign=top>
        <td colspan=168><font size=1>&nbsp;</font></td>
        </tr>
        <tr valign=top>
        <td colspan=11> </td>
        <td colspan=33><font size=2 face="times new roman"><b>CABLE:</b></font></td>
        <td colspan=8> </td>
        <td colspan=111><font size=2 face="times new roman">*** Note: Cable/Hose price(s) subject to change at time of order. ***</font></td>
        </tr>
        <tr valign=top>
        <td colspan=19> </td>
        <td colspan=15><font size=1 face="times new roman"><u>Type:</u></font></td>
        <td colspan=4> </td>
        <td align=center colspan=10><font size=1 face="times new roman"><u>AWG</u></font></td>
        <td colspan=3> </td>
        <td align=center colspan=13><font size=1 face="times new roman"><u>Cond:</u></font></td>
        <td colspan=5> </td>
        <td align=center colspan=10><font size=1 face="times new roman"><u>O.D. (in)</u></font></td>
        <td colspan=2> </td>
        <td align=center colspan=9><font size=1 face="times new roman"><u>Weight (lbs/ft)</u></font></td>
        <td colspan=3> </td>
        <td colspan=16><font size=1 face="times new roman"><u>Bend Radius (in)</u></font></td>
        <td> </td>
        <td align=center colspan=6><font size=1 face="times new roman"><u>Volts</u></font></td>
        </tr>
        <tr valign=top>
        <td colspan=17> </td>
        <td align=center colspan=19><font size=2 face="times new roman">' . $type . '</font></td>
        <td> </td>
        <td align=center colspan=13><font size=2 face="times new roman">' . $awg . '</font></td>
        <td> </td>
        <td align=center colspan=14><font size=2 face="times new roman">' . $cond . '</font></td>
        <td colspan=5> </td>
        <td align=center colspan=9><font size=2 face="times new roman">1.241</font></td>
        <td colspan=3> </td>
        <td align=center colspan=8><font size=2 face="times new roman">' . $c_weight . '</font></td>
        <td colspan=3> </td>
        <td align=center colspan=14><font size=2 face="times new roman">' . $bendRad . '</font></td>
        <td colspan=3> </td>
        <td align=center colspan=7><font size=2 face="times new roman">' . $volts . '</font></td>
        </tr>
        <tr valign=top>
        <td colspan=16> </td>
        <td align=right colspan=42><font size=2 face="times new roman"><b>Cable required for hookup:</b></font></td>
        <td colspan=5> </td>
        <td colspan=22><font size=2 face="times new roman">5.0 feet</font></td>
        <td colspan=9> </td>
        <td align=right colspan=48><font size=2 face="times new roman"><b>Additional cable at moving end:</b></font></td>
        <td colspan=4> </td>
        <td colspan=11><font size=2 face="times new roman">1.0 feet</font></td>
        </tr>
        <tr valign=top>
        <td colspan=168><font size=1>&nbsp;</font></td>
        </tr>
        <tr valign=top>
        <td colspan=168><font size=1>&nbsp;</font></td>
        </tr>
        <tr valign=top>
        <td colspan=168><font size=1>&nbsp;</font></td>
        </tr>
        <tr valign=top>
        <td colspan=12> </td>
        <td colspan=33><font size=2 face="times new roman"><b>REEL DATA:</b></font></td>
        </tr>
        <tr valign=top>
        <td colspan=61> </td>
        <td colspan=11><font size=2 face="times new roman"><b><u>Width</u></b></font></td>
        <td colspan=12> </td>
        <td colspan=5><font size=2 face="times new roman"><b><u>Height</u></b></font></td>
        <td colspan=7> </td>
        <td colspan=12><font size=2 face="times new roman"><b><u>Depth</u></b></font></td>
        </tr>
        <tr valign=top>
        <td colspan=16> </td>
        <td colspan=39><font size=2 face="times new roman"><B>Approx. dimensions:</b></font></td>
        <td colspan=6> </td>
        <td align=center colspan=12><font size=2 face="times new roman">' . $width . '"</font></td>
        <td colspan=5> </td>
        <td colspan=2><font size=2 face="times new roman">x</font></td>
        <td colspan=4> </td>
        <td align=center colspan=6><font size=2 face="times new roman">' . $height . '"</font></td>
        <td> </td>
        <td colspan=4><font size=2 face="times new roman">x</font></td>
        <td> </td>
        <td align=center colspan=12><font size=2 face="times new roman">' . $depth . '"</font></td>
        </tr>
        <tr valign=top>
        <td colspan=14> </td>
        <td colspan=41><font size=2 face="times new roman"><b>Estimated reel weight:</b></font></td>
        <td colspan=6> </td>
        <td colspan=41><font size=2 face="times new roman">' . $wgt . ' lbs.</font></td>
        </tr>
        <tr valign=top>
        <td colspan=14> </td>
        <td align=right colspan=41><font size=2 face="times new roman"><b>Estimated cable weight:</b></font></td>
        <td colspan=6> </td>
        <td colspan=13><font size=2 face="times new roman">13.2 lbs</font></td>
        </tr>
        <tr valign=top>
        <td colspan=168><font size=1>&nbsp;</font></td>
        </tr>
        <tr valign=top>
        <td colspan=168><font size=1>&nbsp;</font></td>
        </tr>
        <tr valign=top>
        <td colspan=18> </td>
        <td align=right colspan=5 nowrap><font size=3 face="times new roman"><b>1</b></font></td>
        <td> </td>
        <td colspan=3><font size=3 face="times new roman"><b>)</b></font></td>
        <td> </td>
        <td colspan=83><font size=3 face="times new roman"><b>Recommended Model:  ' . $modelNumber . '</b></font></td>
        <td colspan=4> </td>
        <td colspan=15><font size=2 face="times new roman"><b>Shipment:</b></font></td>
        <td> </td>
        <td colspan=26><font size=2 face="times new roman"><b>1-2 weeks ARO</b></font></td>
        </tr>
        <tr valign=top>
        <td colspan=168><font size=1>&nbsp;</font></td>
        </tr>
        <tr valign=top>
        <td colspan=168><font size=1>&nbsp;</font></td>
        </tr>
        <tr valign=top>
        <td colspan=168><font size=1>&nbsp;</font></td>
        </tr>
        <tr valign=top>
        <td colspan=168><font size=1>&nbsp;</font></td>
        </tr>
        <tr valign=top>
        <td colspan=168><font size=1>&nbsp;</font></td>
        </tr>
        <tr valign=top>
        <td colspan=168><font size=1>&nbsp;</font></td>
        </tr>
        <tr valign=top>
        <td colspan=168><font size=1>&nbsp;</font></td>
        </tr>
        <tr valign=top>
        <td colspan=168><font size=1>&nbsp;</font></td>
        </tr>
        <tr valign=top>
        <td colspan=168><font size=1>&nbsp;</font></td>
        </tr>
        <tr valign=top>
        <td colspan=168><font size=1>&nbsp;</font></td>
        </tr>
        <tr valign=top>
        <td colspan=168><font size=1>&nbsp;</font></td>
        </tr>
        <tr valign=top>
        <td colspan=17> </td>
        <td colspan=136><font size=3 face="times new roman"><b>*** Bill of Material ***</b></font></td>
        </tr>
        <tr valign=top>
        <td colspan=16> </td>
        <td align=center colspan=13><font size=2 face="times new roman"><b>Item #</b></font></td>
        <td colspan=3> </td>
        <td align=center colspan=4><font size=2 face="times new roman"><b>Qty</b></font></td>
        <td colspan=5> </td>
        <td colspan=19><font size=2 face="times new roman"><b>PN</b></font></td>
        <td colspan=8> </td>
        <td colspan=39><font size=2 face="times new roman"><b>Description</b></font></td>
        <td colspan=22> </td>
        <td align=center colspan=15><font size=2 face="times new roman"><b>Unit Price</b></font></td>
        <td colspan=3> </td>
        <td align=center colspan=11><font size=2 face="times new roman"><b>Lot Price</b></font></td>
        </tr>
        <tr valign=top>
        <td colspan=168><font size=1>&nbsp;</font></td>
        </tr>
        <tr valign=top>
        <td colspan=168><font size=1>&nbsp;</font></td>
        </tr>
        <tr valign=top>
        <td colspan=18> </td>
        <td align=center colspan=8 nowrap><font size=2 face="times new roman">1</font></td>
        <td colspan=6> </td>
        <td align=center colspan=5 nowrap><font size=2 face="times new roman">1</font></td>
        <td colspan=31> </td>
        <td colspan=54><font size=2 face="times new roman">' . $modelNumber . 'Heavy Duty Cable Reel</font></td>
        <td colspan=6> </td>
        <td align=right colspan=14 nowrap><font size=2 face="times new roman">$' . $reelPrice . '</font></td>
        <td colspan=4> </td>
        <td align=right colspan=9 nowrap><font size=2 face="times new roman">$' . $reelPrice . '</font></td>
        <td colspan=11> </td>
        <td align=right nowrap><font size=2 face="times new roman"></font></td>
        <td align=right nowrap><font size=2 face="times new roman"></font></td>
        </tr>

        <tr valign=top>
        <td colspan=168><font size=1>&nbsp;</font></td>
        </tr>
        <tr valign=top>
        <td colspan=19> </td>
        <td colspan=73><font size=2 face="times new roman"><b>NOTE: All prices and invoicing is in U.S. dollars.</b></font></td>
        <td colspan=9> </td>
        <td align=right colspan=36><font size=2 face="times new roman"><b>TOTAL PRICE:</b></font></td>
        <td colspan=3> </td>
        <td align=right colspan=16 nowrap><font size=2 face="times new roman"><b>$' . $reelPrice . '</b></font></td>
        </tr>
        <tr valign=top>
        <td colspan=168><font size=1>&nbsp;</font></td>
        </tr>
        <tr valign=top>
        <td colspan=16> </td>
        <td colspan=142><font size=2 face="times new roman"><b>* Price shown INCLUDES cable installation on the reel.</b></font></td>
        </tr>
        <tr valign=top>
        <td colspan=168><font size=1>&nbsp;</font></td>
        </tr>
        <tr valign=top>
        <td colspan=8> </td>
        <td align=center colspan=157><font size=2 face="times new roman"><b>Terms net 30 days on approved credit.   FOB Mayville, WI   -  prepay & add.</b></font></td>
        </tr>
        <tr valign=top>
        <td colspan=8> </td>
        <td colspan=157><font size=2 face="times new roman"><b><u>Quotation valid for 60 days from quote date.  Gleason Reel\'s Standard Conditions of Sale apply.</u></b></font></td>
        </tr>
        <tr valign=top>
        <td colspan=105> </td>

        <td align=right colspan=14><font size=2 face="times new roman"><b>Quoted By:</b></font></td>
        <td colspan=2>' . $quoteParameters['firstname'] . '</td>
        <td align=center colspan=37></td>
        </tr>
        <p style="bottom:80px; position: absolute; right:50px; font-size:x-small">
        Authorized Representative
        </p>
        </table>
        </body></html>';

        //This creates the pdf, stores it, and returns a view displaying iit in the browser
        $outputName = str_random(10) . "QUOTE"; // str_random is a [Laravel helper](http://laravel.com/docs/helpers#strings)
        $pdfPath = "./public/images/tempQuote/" . $outputName . '.pdf';
        File::put($pdfPath, PDF::load($html, 'A4', 'portrait')->output());
        $out = array('outputName' => $outputName, 'pdfPath' => $pdfPath);
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
            "springSize" => Input::get('k-reels-spring-size'),
            "hoseIdCode" => Input::get('k-code'),
            "pretensTurn" => array("min" => Input::get('k-pretensmin'), "max" => Input::get('k-pretensmax'))
        );


        Debugbar::info($cable);
        if ($cable["style"] == "Cable") {
            $collector = $this->calcCollectorCode($cable, $application['appl']);

        } else {

            $collector = 0;
        }


        //todo: make sure findTheReel works on more than just sReel
        // run findTheReel on just sReel for now.
        $data = $this->findTheReel($khReel, $tmrReel, $cmReel, $shoReel, $smReel, $mmdReel, $sReel, $application, $cable, $collector);
        $data['cust-name'] = Input::get('cust-name');
        $data['cust-addr'] = Input::get('cust-addr');
        $data['cust-comp'] = Input::get('cust-comp');
        $data['cust-phone'] = Input::get('cust-phone');
        return View::make('results', array('data' => $data));
    }

    private function findTheReel($khReel, $tmrReel, $cmReel, $shoReel, $smReel, $mmdReel, $sReel, $application, $cable, $collector) {
        // Calculates spring data, copied from source
        $springData = $this->getSpringData();

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

            $data = $this->loopThruReels($reels, $application, $cable, $springData, $collector, $modelIndex);

        }

        if ($khReel["checkboxes"][0] == "any" || $khReel["checkboxes"][0] != "none") {
            $hose = true;
            $query = DB::table('k')->where('Style', 'K');

            //          if ($khReel['checkboxes'][0] != 'any') {
            //              $query->whereIn('Frame', $khReel['checkboxes']);
            //          }

            //          if ($khReel['springSize'] == 'none') {
            //              $query->where('Springs', '');
            //          } else if ($khReel['springSize'] != 'all') {
            //              $query->where('Springs', $khReel['springSize']);
            //          }


            $query->orderBy('Cost', 'Gear');
            $modelIndex = 1;
            $reels = array('params' => $khReel, 'rows' => $query->get());
            $data = $this->loopThruReels($reels, $application, $cable, $springData, $collector, $modelIndex);

        }

        if ($mmdReel["checkboxes"][0] == "any") {
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
            $modelIndex = 1;


            $reels = array('params' => $mmdReel, 'rows' => $query->get());
            $data = $this->loopThruReels($reels, $application, $cable, $springData, $collector, $modelIndex);

//<==3
        }
        /*
       * ScM Calculation
       */
        if ($smReel["checkboxes"][0] == "any") {
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


            $modelIndex = 1;
            $reels = array('params' => $smReel, 'rows' => $query->get());

            $data = $this->loopThruReels($reels, $application, $cable, $springData, $collector, $modelIndex);
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
            $modelIndex = 1;

            $reels = array('params' => $shoReel, 'rows' => $query->get());

            $data = $this->loopThruReels($reels, $application, $cable, $springData, $collector, $modelIndex);
        }
        /*
         * TMR calculation
         */
        if ($tmrReel["checkboxes"][0] == "any") {
            $query = DB::table('tmr')->where('Style', 'TMR');

            /*if ($tmrReel['springSize'] == 'none') {
                $query->where('Springs', '');
            } else {
                if ($tmrReel['springSize'] != 'all') {
                    $query->where('Springs', $tmrReel['springSize']);
                }
            }*/

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
            $modelIndex = 1;

            $reels = array('params' => $tmrReel, 'rows' => $query->get());

            $data = $this->loopThruReels($reels, $application, $cable, $springData, $collector, $modelIndex);
        }


        if ($cmReel["checkboxes"][0] == "any") {
            //          "checkboxes" => Input::get('sho-checkboxes'),
            //          "springMotor"=> Input::get('cm-springmotor'),
            //          "wireSizeCode" => Input::get('cm-wire-size-code'),
            //          "pretensTurn" => array("min" => Input::get('cm-pretensmin'), "max" => Input::get('cm-pretensmax'))
            $query = DB::table('cmreel')->where('STYLE', 'C');
            switch ($cmReel['wireSizeCode']) {
                case 'all':

                    break;

                default:
                    $query->where("WIRE", $cmReel['wireSizeCode']);
            }
            switch ($cmReel['springMotor']) {
                case 'all':
                    break;
                default:
                    $query->where("SPRINGS", $cmReel['springMotor']);
            }
            $query->orderBy('COST');
            $modelIndex = 1;
            $reels = array('params' => $cmReel, 'rows' => $query->get());
            $data = $this->loopThruReels($reels, $application, $cable, $springData, $collector, $modelIndex);
        }
        $data["cable"] = $cable;

        return $data;

    }

    // This is the main part of the program. This goes through all the reels returned by findTheReel and determines whether the reel would be a good fit given the parameters available.
    //line 4298 on REELMOD.BAS

    private function clearSearchCriteria(){
        $srchFrame = ""; $srchCost = ""; $srchStyle = ""; $srchSpring = ""; $srchColl = ""; $srchDrummin = "";
        $srchDrummax = ""; $srchPremin = ""; $srchPremax = ""; $srchSpoolMethod = ""; $srchSpoolWidth = "";
        $srchGear = ""; $srchChainRatio = ""; $srchMotor = "";
    }

    private function loopThruReels($reels, $application, $cable, $springData, $collector, $modelIndex) {
        $srchSpring = ""; //initialized for TMR searches
        Debugbar::info("LoopThruReels called");

        //todo: currently Invalid reel array and valid reels reset them selves when a new type is searched. Find out a way so they don't do this. See if you can check for if they are empty or null. Or see if you can append their results where appropriate. Consider adding them to the globals class
        //great the global solution works, however not all valid reels are being listed. They are correctly stored in the array though.
        global $invalidReelArray;
        global $validReel;
        global $recNumber;
        global $cableOrHose;

        if ($invalidReelArray == null)
            $invalidReelArray = array();
        $reelIndex = 0;
        if($recNumber == null)
            $recNumber = 0;
        $count = 0;
        $reelLength = count($reels['rows']);
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

        // returns an array for all of the models with boolean values
        // if the parameters are specifying a specific sreel, $specificInput[0] will be true
        $specificInput = false;// $this->checkForSpecificInput($cableOrHose, $reels['params']['checkboxes'], $reels['params']['drumDiameter'], $reels['params']['pretensTurn']);

        $hoseIDCode = $cable['hoseIDCode'];

        //loop through all reels returned by our sql query
        Debugbar::info("$reelIndex < $reelLength");

        while ($reelIndex < $reelLength) {

            $this->clearSearchCriteria();
            $reel = $reels['rows'][$reelLength - $reelIndex - 1];

            Debugbar::info("Search Style: " . $reel->Style );
            //$all_vars = implode(', $', array_keys(get_defined_vars()));
            //unset($all_vars);

            $srchStyle = $reel->Style;
            $srchCost = $reel->Cost;

            //if($srchStyle=='SM'){
            //    $reel = $reels['rows'][$reelIndex];
            //}


            if (count($reels['rows']) != 0) {
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
                                    //andy is a big nerd
                            case "MMD":
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
                            Debugbar::info($reels['params']['spoolWidth'] . " spoolwidth SHO method M");
                        } else {
                            if (strlen($reel->Swidth) > 0) {
                                $srchSpoolWidth = $reel->Swidth;
                                Debugbar::info($reel->Swidth  . " spoolwidth SHO method else");
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

                        $srchDrummin = $reels['params']['drumDiameter']['min'];
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
                            //todo:Fix this section, it may be a key factor for why we can not search TMR reels. OK there was a mistake made a at a higherlever. The spool width is not being assigned because the field on our application is wrong. for TMR it has spool width NA instead of spring size being NA.
                            //$srchSpoolMethod = $srchDrummax = $reels['params']['spoolWidth']; //what on earth does this line mean?, spoolwidth is not being assigned. in the ReelMod.bas this is line 4424 and it says srchSPOOLWIDTH = TMRspoolwidthSEL
                            $srchSpoolWidth = $srchDrummax = $reels['params']['spoolWidth'];
                            Debugbar::info("spoolwidth in TMR search: " . $reels['params']['spoolWidth']);
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
            }

            //todo: the following line uses not equals for each check, if you look at line 4472 of reelmod.bas the equivlent line uses equals as in:
            // If srchSTYLE <> "C" And srchSTYLE <> "K" And srchSTYLE <> "HM" Then
            if ($srchStyle != 'C' && $srchStyle != 'K' && $srchStyle != 'HM') {

                $validDrumMax = $this->checkDrumSize($srchStyle, $srchFrame, $application['ccf'], $cable['thickness'], $srchDrummax);

                //Debugbar::info("ValidDrumMax: " . $validDrumMax);
                if ($validDrumMax < $srchDrummin) {
                    goto NextReel;

                }
            }

            if ($application['appl'] == 'hand') {
                if (substr($reels['params']['springSize'], 0, 3) == '100') {
                    goto NextReel;
                }
                //todo: compare the following line with its reelmod.bas equivlent on line 4485
                //   If (srchSTYLE = "C" Or srchSTYLE = "HM") And (srchSPRING <> "U" And srchSPRING <> "V") Then GoTo nextREEL
                if (($srchStyle == 'C' || $srchStyle == 'HM') && ($srchSpring != 'U' || $srchSpring != 'V')) {
                    goto NextReel;
                }
            }
            // This returns validPretensMax, which is one of checks that need to be done to see whether a reel is valid or not.
            //Debugbar::info("application['springTurns']: " . $application['springTurns'] . " srchStyle: " . $srchStyle . " srchSpring: " . $srchSpring . "srchPremax: ".$srchPremax );
            $pretensTurnData = $this->checkPretensTurns($application['springTurns'], $srchStyle, $srchSpring, $srchPremax);

            if ($srchStyle == "TMR" || $srchStyle == "P") {
                $srchPremin = 0;
            }

            if ($srchStyle == "C" || $srchStyle == "HM") {
                $validDrumMax = 0;
                $srchDrummin = "1";
                $drumIncrement = -1;
            }
            //Debugbar::info("hoseIDCode: " . $hoseIDCode);
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



            $turnsUsedPercent = $pretensTurnData['turnsUsedPercent'];
            $validPretensMax = $pretensTurnData['validPretensMax'];
            if ($srchStyle == "K") {
                $srchGear = 0;
            }
            $gearRatio = $this->assignGearRatio($srchStyle, $srchGear);//line 4520



            $calcTorqueParams = array('springSize' => $srchSpring,
                'springData' => $springData,
                'turnsUsedPercent' => $turnsUsedPercent,
                'gearRatio' => $gearRatio
            );


            $swOpt = false; //I believe this is for initialization. in original application, it is set in a form that bases the bool on user input. Line 3678 on MODEL1.FRM
            $swOpt = false; //I believe this is for initialization. in original application, it is set in a form that bases the bool on user input. Line 3678 on MODEL1.FRM

            $specificInput = false;
            for ($drumSize = $validDrumMax; $drumSize >= $srchDrummin; $drumSize -= $drumIncrement) { //line 4520

                for ($pretensionTurns = intval($srchPremin); $pretensionTurns <= intval($validPretensMax); $pretensionTurns++) {

                    if ($srchStyle == 'C' || $srchStyle == 'HM') {
                        $initialCMCalcs = $this->doInitialCMCalcs($srchStyle, $srchFrame, $cable, $drumSize, $pretensionTurns, $application['ccf'], $application['activeTravel'], $application['deadWraps'], $modelIndex, $specificInput, $pretensTurnData['maxTurnsFromSpring'], $turnsUsedPercent, $cableOrHose, $srchColl, $srchSpring, $srchMotor);
                        $validCompartment = $initialCMCalcs['validCompartment'];
                        $validTurns = $initialCMCalcs['validTurns'];
                        $drumSize = $initialCMCalcs['drumSize'];
                    } else {
                        if ($srchStyle == "K") {
                            //these are likely initializations to prevent errors, have search style of k likely does not assign them.
                            $srchSpoolWidth = 0;
                            $srchSpoolMethod = 0;
                        }

                        $initialCalcs = $this->doInitialCalcs($srchSpoolWidth, $srchSpoolMethod, $srchStyle, $srchFrame, $swOpt, $cable, $drumSize, $pretensionTurns, $application['ccf'], $application['activeTravel'], $application['deadWraps'], $calcTorqueParams, $collector, $srchSpring, $srchGear, $modelIndex, $specificInput, $cableOrHose, $srchMotor, $application);
                        $validCompartment = $initialCalcs['validCompartment'];
                        $validTurns = $initialCalcs['validTurns'];
                    }


                    if (!$validCompartment) {
                        goto PRETENSSKIP;
                    }

                    if ($validTurns) {

                        $validTorque = false;
                        if ($srchStyle == 'C' || $srchStyle == 'HM') {
                            switch ($application['appl']) {
                                case "stretch":
                                    $stretchApplCMCalcs = $this->calcStretchApplCM($application, $initialCMCalcs, $cable, $drumSize, $gearRatio, $pretensionTurns, $srchSpring, $specificInput);
                                    $validTorque = $stretchApplCMCalcs['validTorque'];
                                    $reason = $stretchApplCMCalcs['reason'];
                                    break;
                                case 'lift':
                                    $liftApplCMCalcs = $this->calcLiftApplCM($srchStyle, $modelIndex, $pretensionTurns, $application, $initialCMCalcs, $cable, $drumSize, $gearRatio, $validTorque, $specificInput, $srchSpring);
                                    $validTorque = $liftApplCMCalcs['validTorque'];
                                    $reason = $liftApplCMCalcs['reason'];
                                    break;
                                case 'retrieve':
                                case 'hand':
                                    $retrieveApplCalcs = $this->calcRetrieveApplCM($srchStyle, $modelIndex, $pretensionTurns, $application, $initialCalcs, $cable, $drumSize, $gearRatio, $validTorque, $specificInput, $srchSpring);
                                    $reason = $retrieveApplCalcs['reason'];
                                    $wrapperWidthR = $initialCalcs['wrapperWidthR'];
                                    $validTorque = $retrieveApplCalcs['validTorque'];
                                    break;
                            }
                        } else {
                            $turnsActiveCableLength = $initialCalcs['turnsActiveCableLength'];

                            switch ($application['appl']) {
                                case 'stretch':
                                    $stretchApplCalcs = $this->calcStretchAppl($srchStyle, $modelIndex, $pretensionTurns, $application, $initialCalcs, $cable, $drumSize, $gearRatio, $validTorque, $specificInput, $srchSpring, $srchGear);
                                    $validTorque = $stretchApplCalcs['validTorque'];
                                    $reason = $stretchApplCalcs['reason'];
                                    $wrapperWidthR = $initialCalcs['wrapperWidthR'];
                                    break;
                                case 'lift': //todo get lift calcs here
                                    $liftApplCalcs = $this->calcLiftAppl($srchStyle, $modelIndex, $pretensionTurns, $application, $initialCalcs, $cable, $drumSize, $gearRatio, $validTorque, $specificInput);
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
                                $shaftStress = $stressApplCalcs['shaftStress'];
                                $bearingLoad = $stressApplCalcs['bearingLoad'];
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

                    if ($srchStyle != "C") {
                        if ($srchStyle == "SHO") {
                            $invalidReel = $this->modelNO($srchSpoolWidth, $srchSpoolMethod, $srchStyle, $srchFrame, $swOpt, $srchSpring, $srchColl, $drumSize, $srchGear, $pretensionTurns, 0, $cable, $cableOrHose);
                            $invR = array('invalidReel' => $invalidReel, 'reason' => $reason);
                            array_push($invalidReelArray, $invR);
                        } else {
                            $invalidReel = $this->modelNO(0, 0, $srchStyle, $srchFrame, $swOpt, $srchSpring, $srchColl, $drumSize, $srchGear, $pretensionTurns, 0, $cable, $cableOrHose);
                            Debugbar::info($reason . "fsda");
                            $invR = array('invalidReel' => $invalidReel, 'reason' => $reason);
                            array_push($invalidReelArray, $invR);
                        }
                    } else {
                        $spoolWidthCode = 0;
                        $invalidReel = $this->modelNO(0, 0, $srchStyle, $srchFrame, $swOpt, $srchSpring, $srchColl, $drumSize, $srchGear, $pretensionTurns, $spoolWidthCode, $cable, $cableOrHose);
                        $invR = array('invalidReel' => $invalidReel, 'reason' => $reason);
                        array_push($invalidReelArray, $invR);
                    }
                }
                PRETENSSKIP:
            }

            goto NextReel;

            MODELFOUND:
            $recNumber++;


            if ($srchStyle != "C") {
                $spoolWidthCode = $initialCalcs['SWC'];
                $modelWeightCalcs = $this->calcModelWeight($srchStyle, $srchSpring, $srchFrame, $gearRatio, $cable);
                $modelWeight = $modelWeightCalcs["modelWeight"];
                $dimensions = $this->calcModelDimensions($srchStyle, $collectorCode, $srchFrame, $swOpt, $gearRatio, $srchSpring, $wrapperWidthR, $srchSpoolMethod, $srchSpoolWidth, $srchColl, $modelWeightCalcs);
                $reelPriceCalcs = $this->calcReelPrice($cableOrHose, $srchStyle, $hoseIDCode, $srchCost, $srchFrame, $swOpt, $srchColl);
                $extraCableAtReel = $this->calcExtraCable($srchColl, $srchStyle, $drumSize, $application['deadWraps'], $cable['thickness']);
                Debugbar::info("recNumber = ".$recNumber);
                $validReel[$recNumber] = array();
                $vR = $validReel[$recNumber];
                $vR['modelNum'] = $this->modelNO($srchSpoolWidth, $srchSpoolMethod, $srchStyle, $srchFrame, $swOpt, $srchSpring, $srchColl, $drumSize, $srchGear, $pretensionTurns, $spoolWidthCode, $cable, $cableOrHose);
                $vR['turnsLimit'] = $initialCalcs['availSpringTurns'];
                $vR['compartmentCapacity'] = $initialCalcs['compartmentActiveCableLength'];
                $vR['turnsCapacity'] = $initialCalcs['turnsActiveCableLength'];

            } else {
                //$availableSpringTurnsForStretch = $stretchApplCMCalcs['availableSpringTurnsForStretch'];
                $modelWeightCalcs = $this->calcModelWeight($srchStyle, $srchSpring, $srchFrame, $gearRatio, $cable);
                $modelWeight = $modelWeightCalcs["modelWeight"];
                $dimensions = $this->calcModelDimensions($srchStyle, $collectorCode, $srchFrame, $swOpt, $gearRatio, $srchSpring, 0, 0, 0, $srchColl, $modelWeightCalcs);
                $reelPriceCalcs = $this->calcReelPrice($cableOrHose, $srchStyle, $hoseIDCode, $srchCost, $srchFrame, $swOpt, $srchColl);
                $extraCableAtReel = $this->calcExtraCable($srchColl, $srchStyle, $drumSize, $application['deadWraps'], $cable['thickness']);
                Debugbar::info("recNumber = ".$recNumber);
                $validReel[$recNumber] = array();
                $vR = $validReel[$recNumber];
                $vR['turnsLimit'] = $initialCMCalcs['availSpringTurns'];
                $vR['modelNum'] = $this->modelNO(0, 0, $srchStyle, $srchFrame, $swOpt, $srchSpring, $srchColl, $drumSize, $srchGear, $pretensionTurns, 0, $cable, $cableOrHose);
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
            // $vR['motor'] = $srchMotor;
            // $vR['spoolWidth'] = $srchSpoolWidth;
            $vR['spoolDiam'] = $srchFrame;
            $metricDefault = false;
            switch ($metricDefault) {
                case true:
                    // METRIC
                case false:
                    $vR['modelWgt'] = $modelWeight;
                    $vR['dimWidth'] = $dimensions['dimensWidth'];
                    $vR['dimHeight'] = $dimensions['dimensHeight'];
                    $vR['dimDepth'] = $dimensions['dimensDepth'];
                    $vR['extraCable'] = $extraCableAtReel;
            }


            switch ($application['appl']) {
                // in this program the values aren't single letters like L and M, they're written out
                case 'lift':
                case 'magnet':
                    if ($srchStyle == "C") {

                    } else {
                        $vR['torqWFullReel'] = $liftApplCalcs['netTorqueWithReelFullLift']; // format
                        // $vR['torqueCapacity'] = $liftApplCalcs['maxActiveLengthOfCableFromTorqueLift']; // format
                        $vR['maxCapacity'] = $liftApplCalcs['maxLiftCapacityOfReel']; // format
                    }

                    break;
                case 'stretch':
                    if ($srchStyle != "C") {

                        $vR['torqWFullReel'] = $stretchApplCalcs['netTorqueWithReelFullStretch']; // format
                        $vR['torqueCapacity'] = $stretchApplCalcs['maxActiveLengthOfCableFromTorqueStretch']; // format
                        $vR['maxCapacity'] = $stretchApplCalcs['maxStretchCapacityOfReel']; // format
                    } else {

                        $vR['torqWFullReel'] = $stretchApplCMCalcs['netTorqueWithReelFullStretch']; // format
                        $vR['torqueCapacity'] = $stretchApplCMCalcs['maxActiveLengthOfCableFromTorqueStretch']; // format
                        $vR['maxCapacity'] = $stretchApplCMCalcs['maxStretchCapacityOfReel']; // format

                    }
                    break;
                case 'retrieve':
                    if ($srchStyle != "C") {
                        $vR['torqWFullReel'] = $retrieveApplCalcs['netTorqueWithReelFullRetrieve']; // format
                        $vR['torqueCapacity'] = $retrieveApplCalcs['maxCenterLineHeight']; // format
                        $vR['maxCapacity'] = $retrieveApplCalcs['maxCapacity']; // format
                    } else {
                    }
                    break;
                // case 'hand':
                // case 'retrieve':
                //   $vR['torqWFullReel'] = $netTorquewithReelFullRetrieve; // format
                //   $vR['torqueCapacity'] = $maxCenterlineHeight; // format
                //   $vR['maxCapacity'] = $maximumRetrieveCapacityOfReel; // format
            }
            $vR['quoteFlag'] = 3;
            $vR['totalReelPrice'] = $reelPriceCalcs['reelTotalListPrice'];
            // $vR['invalidWarn'] = $invalidWarning;
            $vR['locationPointer'] = $recNumber;
            $validReel[$recNumber] = $vR;
            Debugbar::info("recNumber = ".$recNumber."// this should be the second call with the same recNumber");
            Debugbar::info("begin valid reel array");
            Debugbar::info($validReel);
            Debugbar::info($invalidReelArray);
            Debugbar::info("end valid reel array");


            if ($srchStyle != "C") {

                switch ($application['appl']) {

                    //Testing concacts on data
                    case 'stretch':
                        $data = $this->WriteDetailsSummary($vR, $application, $srchStyle, $application['deadWraps'], $initialCalcs, $stretchApplCalcs, $extraCableAtReel, $specificInput, $modelIndex, $turnsActiveCableLength, $cable, 0, 0);
                        if ($srchStyle == "SHO") {
                            $data = $this->WriteDetailsSummary($vR, $application, $srchStyle, $application['deadWraps'], $initialCalcs, $stretchApplCalcs, $extraCableAtReel, $specificInput, $modelIndex, $turnsActiveCableLength, $cable, $bearingLoad, $shaftStress);
                        }
                        break;
                    case 'lift':
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
                        $data = $this->WriteDetailsSummary($vR, $application, $srchStyle, $application['deadWraps'], $initialCMCalcs, $liftApplCMCalcs, $extraCableAtReel, $specificInput, $modelIndex, $initialCMCalcs['turnsActiveCableLength'], $cable, 0, 0);
                        break;
                    case 'retrieve':
                    case 'hand':
                        $data = $this->WriteDetailsSummary($vR, $application, $srchStyle, $application['deadWraps'], $initialCMCalcs, $liftApplCalcs, $extraCableAtReel, $specificInput, $modelIndex, $turnsActiveCableLength, $cable, 0, 0);
                        break;
                }
            }

            break;

            NextReel:
            $reelIndex++;

        }
        if ($srchStyle == "C") {
            $initialCalcs = $initialCMCalcs;
        }

        //todo:find a way to return data for multiple valid reels.
        /*old code
        *$dataArr = array('data' => $data, 'vr' => $vR, 'application' => $application, 'initialCalcs' => $initialCalcs, 'invalidArray' => $invalidReelArray);
        */
        //new code that adds valid reels to the dataArr array
            //attempt to load globals containing calc data into the data array
        $dataArr = array('calcResultData' => $this->globals->calcResultData,'data' => $data, 'vr' => $vR, 'application' => $application, 'initialCalcs' => $initialCalcs, 'invalidArray' => $invalidReelArray, 'validArray' => $validReel);

        Debugbar::info($dataArr);


        return $dataArr;
    }

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
            $shaftStress = $applCalcs['shaftStress'];
            $bearingLoad = $applCalcs['bearingLoad'];
            $tqoute = $initialCalcs['tqoute'];
            $rnme = $initialCalcs['rnme'];
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


        if ($srchStyle != "C") {
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
                //old code begin these seam to have incorrect variable names, I am unsure if this is needed or not yet
                $maxFullLayersFromTorqueStretchR = $applCalcs['maxFullLayersFromTorqueLiftR'];
                $torqueActiveStretchLength = $applCalcs['torqueActiveLiftLength'];
                $maxLengthCableFromTorqueStretch = $applCalcs['maxLengthCableFromTorqueLift'];
                $maxActiveLengthOfCableFromTorqueStretch = $applCalcs['maxActiveLengthOfCableFromTorqueLift'];
                //old code end
                //Andy's code begin
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
                if ($srchStyle != "C") {
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
                if ($srchStyle != "C") {
                    $data .= $this->writeLiftSummary($srchStyle, $vR['turnsLimit'], $specificInput, $modelIndex, $applCalcs, $initialCalcs, $application);
                } else {
                    $data .= $this->writeLiftSummary($srchStyle, $vR['turnsLimit'], $specificInput, $modelIndex, $applCalcs, $initialCalcs, $application);
                }
                break;
            case 'retrieve':
                if ($srchStyle != "C") {

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
    private function modelNO($srchSpoolWidth, $srchSpoolMethod, $srchStyle, $srchFrame, $swOpt, $srchSpring, $srchColl, $drumSize, $srchGear, $pretensionTurns, $spoolWidthCode, $cable, $cableORhose) {
        switch ($srchStyle) {
            case 'S':
            case 'SM':
            case 'MMD':
                if ($srchStyle == 'S' && $srchFrame > 15 && $srchFrame < 25 && $swOpt) {
                    $modelSTR = 'SW' . $srchFrame . $srchSpring . '-' . $srchColl . '-' . $drumSize . '-';
                } else {
                    $modelSTR = $srchStyle . $srchFrame . $srchSpring . '-' . $srchColl . '-' . $drumSize . '-';
                }


                if ($srchGear != ' ') {
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
                    default:
                        $uModelSuffix = "E";
                }
                $drumStr = $drumSize;
                if (strlen($drumSize) == 1) {
                    $drumStr = "0" . $drumStr;
                    $modelSTR = $srchStyle . $uModelSuffix . $srchFrame . $srchSpring . '-' . $srchColl . '-' . $drumStr . $this->globals->reelWidthInp . '-';//704
                    if (strlen($srchGear) > 0) {
                        $modelSTR = $modelSTR . $srchGear . '-';
                    }
                }
                $modelSTR = $modelSTR . $pretensionTurns;
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
                    $modelSTR = $modelSTR . $spoolWidthCode . $srchFrame . '-' . $srchGear . '-' . $this->globals->srchMotor;
                } else {
                    $modelSTR = $modelSTR . $srchSpoolWidth . $srchFrame . '-' . $srchGear . '-' . $this->globals->srchMotor;
                }
                break;
            case "C":
                $modelSTR = $srchStyle . $srchFrame . '-' . $srchColl . '-' . $srchSpring . "11" . "0" . $pretensionTurns;
                break;
            case "HM":
                $modelSTR = $srchStyle . $srchFrame . '-' . $srchSpring . '-' . $this->globals->hoseIDCode . "-P" . $pretensionTurns;
                break;
            case "P":
                $modelSTR = $srchStyle . $srchFrame . '-' . $srchColl . '-' . $drumSize . '-' . $this->globals->srchMotor;
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

    private function calcModelWeight($srchStyle, $srchSpring, $srchFrame, $gearRatio, $cable) {
        $kDimensA = 0;
        $modelWeight = 0;

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
            case "K":
                $testStr = $srchFrame + $srchSpring + $cable["hoseIDCode"];
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

    private function calcModelDimensions($srchStyle, $collectorCode, $srchFrame, $swOpt, $gearRatio, $srchSpring, $wrapperWidthR, $srchSpoolMethod, $srchSpoolWidth, $srchColl, $modelWeightCalcs) {
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

                switch ($collectorCode) {
                    case '23':
                    case '33':
                    case '43':
                        $dimensA = 15;
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
                        $dimensA = 20;
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
                    $dimensA -= 0.5;
                }

                if ($srchFrame == '28' || $srchFrame == '32') {
                    $dimensA++;
                }
                if ($srchStyle == 'S' && intval($srchFrame) > 15 && intval($srchFrame) < 25 && $swOpt) {
                    $dimensA += 2;
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
                    $dimensB -= 0.5;
                }
                if ($srchFrame == '28') {
                    $dimensB++;
                }


                if ($gearRatio != '1') {

                    if ($srchFrame != '32') {
                        $dimensB += 5;
                    } else {
                        switch ($srchSpring) {
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

                switch ($srchStyle) {
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
                switch ($collectorCode) {
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
                        $dimensB = 26;
                        break;
                    case "1008":
                        $dimensB = 26;
                        break;
                }
                if ($srchFrame > 24 && $srchSpring <= 1004) {
                    $dimensB += 1;
                }
                switch ($srchFrame) {
                    case "21":
                        $dimensHeight = 27.88;
                        $dimensDepth = 25;
                        break;
                    case "24":
                        $dimensHeight = 29.38;
                        $dimensDepth = 28;
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
            case "SHO":
            case "TMR":
                switch ($collectorCode) {
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
//                    switch(srchMotor){
//
//                    }
                        break;


                }
                if ($dimensA > $dimensB) {
                    $dimensZ = $dimensA;
                } else {
                    $dimensZ = $dimensB;
                }
                switch ($srchSpoolMethod) {
                    case "M":
                        $dimensWidth = $wrapperWidthR + 1 + 2.38 + 12 + $dimensZ;
                        break;
                    case "R":
                        $dimensWidth = $srchSpoolWidth + 0.96 + 2.38 + 12 + $dimensZ;
                }
                $dimensHeight = $srchFrame;
                if ($srchStyle == "TMR" || $srchSpring < 1005) {
                    $dimensDepth = ($srchFrame / 2) + 24;
                } else {
                    $dimensDepth = 48;
                }

                if ($dimensDepth < $dimensHeight) {
                    $dimensDepth = $dimensHeight;
                }
                break;
                break;
            case "C":
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

                        break;


                }

            case "K":
                $dimensWidth = $modelWeightCalcs["kDimensA"];
                switch ($srchFrame) {
                    case "18":
                        $dimensHeight = 19.75;
                        $dimensDepth = 18;
                        break;
                    case "21":
                        $dimensHeight = 23;
                        $dimensDepth = 21;
                        break;
                    case "24":
                        $dimensHeight = 26;
                        $dimensDepth = 24;
                        break;
                    case "28":
                        $dimensHeight = 30;
                        $dimensDepth = 28;
                        break;
                    case "32":
                        $dimensHeight = 34;
                        $dimensDepth = 32;
                        break;
                }
                break;
            //todo add U

        }


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

    private function calcReelPrice($cableOrHose, $srchStyle, $hoseIDCode, $srchCost, $srchFrame, $swOpt, $srchColl) {
        $reelTotalListPrice = 0;

        if ($cableOrHose == 'HS') { // cable value incorrect
            $swivelJointPrice = 0;

            if ($srchStyle == 'U') {
                switch ($hoseIDCode) {
                    case '4':
                        $swivelJointPrice = 101; //2013 prices
                        break;
                    case '6':
                        $swivelJointPrice = 101;
                        break;
                    case '8':
                        $swivelJointPrice = 101;
                        break;
                    case '12':
                        $swivelJointPrice = 139;
                        break;
                    case '16':
                        $swivelJointPrice = 173;
                        break;
                    case '20':
                        $swivelJointPrice = 283;
                        break;
                    case '24':
                        $swivelJointPrice = 662;
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
            $reelTotalListPrice += 173.2; // 2013 added for SW option manually bump
        }

        $reelPriceCalcs = array(
            'reelTotalListPrice' => $reelTotalListPrice,
            'collectorPrice' => $collectorPrice
        );

        return $reelPriceCalcs;
    }

    private function lookupCollectorPrice($srchStyle, $srchColl) {
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
                    $collectorPrice = $row->Pprc;
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
            $collectorPrice *= $reelPriceMultiplier;
        }

        return $collectorPrice;
    }

    private function calcExtraCable($srchColl, $srchStyle, $drumSize, $deadWraps, $cableThick) {
        $extraCableAtReel = 0;
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
                $subscrpt1 = $drumSize - 7;
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
                // -- TODO --
                $pi = pi(); //change this to php pi function

                if ($deadWraps >= 1) {

                    $extraCableAtReel = $cableAtReel + (($deadWraps - 1) * ($drumSize + $cableThick) * $pi / 12);
                } else {
                    $extraCableAtReel = $cableAtReel;
                }

                if ($srchStyle == 'SM') {
                    switch ($srchColl) {
                        case '220':
                        case '320':
                        case '420':
                            $extraCableAtReel++;
                            break;
                    }
                }
                break;
        }
        return $extraCableAtReel;
    }

    private function doInitialCalcs($srchSpoolWidth, $srchSpoolMethod, $srchStyle, $frameSize, $swOpt, $cable, $drumSize, $pretensionTurns, $ccf, $travelInFt, $deadWraps, $calcTorqueParams, $collector, $srchSpring, $srchGear, $modelIndex, $specificInput, $cableOrHose, $srchMotor, $application) {

        //Sanning: Cable thickness. Used in: mostly non-case specific cals, also used in torqueCalcs params.
        $cableThick = $cable['thickness'];
        //Sanning: honeWgtBoth, used in multiple places
       $hoseWgtboth = 0;


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
                if ($srchStyle == 'S' && $frameSize > 15 && $frameSize < 25 && $swOpt) {
                    $wrapperWidthI = 7;
                }
                $wrapperWidthR = $wrapperWidthI;
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

                } else {
                    $spoolWidthCode = 0;
                    $wrapperWidthR = $srchSpoolWidth;

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
                break;
            case "U":
                //todo: fill this in with lines 2719-2720 in ReelMod.bas
                break;
        }


        $grndchkQty = $cable['grndchck'];


        if ($srchStyle == 'K') {
            $maxWrapsPerLayerR = 1;
        } else {
            $maxWrapsPerLayerR = $wrapperWidthR / $cableThick;

        }


        $maxWrapsPerLayerRStored = $maxWrapsPerLayerR;
        $maxWrapsPerLayerI = (int)$maxWrapsPerLayerR;
        $maxWrapsPerLayerR = $maxWrapsPerLayerI;


        $maxCableLayersR = ($frameSize - $drumSize) / (2 * $cableThick);


        $maxCableLayersI = (int)($maxCableLayersR);

        $maxCableWrapsI = $maxWrapsPerLayerI * $maxCableLayersI;

        if ($ccf == 0) {//called CableCF in ReelMod.bas
            $cableClearanceFactor = $this->assignCCF($srchStyle, $maxCableWrapsI);
        } else {
            $cableClearanceFactor = $ccf;
        }


        $maxUsableLayersR = $maxCableLayersR - $cableClearanceFactor;


        $maxUsableLayersI = (int)($maxUsableLayersR);
        $maxUsableLayersR = $maxUsableLayersI;

        $maxUsableWrapsR = $maxWrapsPerLayerR * $maxUsableLayersR;


        $compartmentHeight = ($frameSize - $drumSize) / 2;

        $fileStr = '';

        //todo: Need to add cases for SHO TMR P and K see line 2760 in ReelMod.bas
        switch ($srchStyle) {
            case 'S':
            case 'SM':
            case 'MMD':
            case 'U':
                $fileStr = $srchStyle . $frameSize . $srchSpring . '-' . $srchGear;
        }

        $fileStr .= $fileStr . '-' . $pretensionTurns;
        // this is the part that doesn't make sense. The string is built and then reset and never used.


        $pi = pi(); // figure out what value of pi the original program uses
        //$deadWraps = doubleval($deadWraps);

        $deadWrapLength = $deadWraps * ($drumSize + $cableThick) * $pi / 12; // pi needs to replaced with actual value in program

        $cableLayerIndexR = 0;
        $compartmentCableCapacity = 0;
        while (true) {
            $cableLayerIndexR++;
            if ($cableLayerIndexR > $maxUsableLayersR) {
                break;
            }

            switch ($srchStyle) {
                case 'SHO':
                case 'TMR':

                    switch ($srchSpoolMethod) {
                        case 'R':
                            if ($cableLayerIndexR / 2 == (int)($cableLayerIndexR / 2)) {
                                $layerCableCapacity = ($maxWrapsPerLayerR - 1) * ($drumSize + (2 * $cableLayerIndexR - 1) * $cableThick) * $pi / 12;
                            } else {
                                $layerCableCapacity = $maxWrapsPerLayerR * ($drumSize + (2 * $cableLayerIndexR - 1) * $cableThick) * $pi / 12;
                            }
                            break;
                        default:
                            $layerCableCapacity = $maxWrapsPerLayerR * ($drumSize + (2 * $cableLayerIndexR - 1) * $cableThick) * $pi / 12;
                            break;
                    }
                    break;
                case "U":
                    if ($cableLayerIndexR / 2 == (int)$cableLayerIndexR / 2) {
                        $layerCableCapacity = ($maxWrapsPerLayerR - 1) * ($drumSize + (2 * $cableLayerIndexR - 1) * $cableThick) * pi() / 12;
                    } else {
                        $layerCableCapacity = ($maxWrapsPerLayerR) * ($drumSize + (2 * $cableLayerIndexR - 1) * $cableThick) * pi() / 12;
                    }
                    break;
                default:
                    $layerCableCapacity = $maxWrapsPerLayerR * ($drumSize + (2 * $cableLayerIndexR - 1) * $cableThick) * $pi / 12;
                    break;
            }
            $compartmentCableCapacity = $compartmentCableCapacity + $layerCableCapacity;
        }
        $compartmentActiveCableLength = $compartmentCableCapacity - $deadWrapLength;
        if ($compartmentActiveCableLength < $travelInFt) {

            switch ($specificInput) {
                case false:
                    $initialCalcs = array(
                        "validTurns" => false,
                        "validCompartment" => false,
                        "SWC" => $spoolWidthCode,
                        "invalidReason" => 1
                    );
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

                $torqueCalcs = $this->calcTorque($calcTorqueParams['springSize'], $calcTorqueParams['springData'], $calcTorqueParams['turnsUsedPercent'], $calcTorqueParams['gearRatio'], $pretensionTurns, $maxWrapsPerLayerR, $cableThick, $drumSize, $deadWrapLength, $compartmentActiveCableLength, $maxUsableWrapsR);
                $turnsActiveCableLength = $torqueCalcs['turnsActiveCableLength'];

                if ($turnsActiveCableLength < $travelInFt) {
                    switch ($specificInput) {
                        case false:
                            $initialCalcs = array(
                                "validTurns" => false,
                                "validCompartment" => false,
                                "SWC" => $spoolWidthCode,
                                "reason" => 2
                            );

                            return $initialCalcs;
                            break;
                        case true:
                            $invalidWarning = true;
                            break;
                    }
                }
                break;
            case 'TMR': // see line 2841 in ReelMod.bas
                //todo: test changes to rmoti, CAI added it to a globals class and assigned it to that global value.
                switch ($srchMotor) {
                    case "2":
                        $tqsiz = 2.4;
                        //$rmoti = .093; <----old CAI code, see similar commented out lines bellow
                        $this->globals->rmoti = .093;
                        break;
                    case "3":
                        $tqsiz = 3.7;
                        //$rmoti = .164;
                        $this->globals->rmoti = .164;
                        break;
                    case "5":
                        $tqsiz = 5.1;
                        //$rmoti = .29;
                        $this->globals->rmoti = .29;
                        break;
                    case "7":
                        $tqsiz = 7.8;
                        //$rmoti = .486;
                        $this->globals->rmoti = .486;
                        break;
                    case "9":
                        $tqsiz = 9.8;
                        //$rmoti = .923;
                        $this->globals->rmoti = .923;
                        break;
                    case "14":
                        $tqsiz = 14;
                        //$rmoti = 1.478;
                        $this->globals->rmoti = 1.478;
                        break;

                }
                break;
            case 'P':
                switch ($srchMotor) {
                    case "25":
                        $torqueFromMotor = 21.9;
                        break;
                    case "50":
                        $torqueFromMotor = 43.8;
                        break;
                    case "75":
                        $torqueFromMotor = 65.7;
                        break;
                    case "150":
                        $torqueFromMotor = 131.4;
                        break;
                }
                break;
        }
        if(isset($torqueCalcs)) {//needed for TMR and P searches
            $AdjSlopeFirstPartOfCurve = $torqueCalcs['adjSlopeFirstPartOfCurve'];
            $AdjyInterceptFirstPartOfCurve = $torqueCalcs['AdjyInterceptFirstPartOfCurve'];
            $AdjMaxTurnsForFirstPartOfCurve = $torqueCalcs['AdjMaxTurnsForFirstPartOfCurve'];

            $AdjSlopeSecondPartOfCurve = $torqueCalcs['AdjSlopeSecondPartOfCurve'];
            $AdjyInterceptSecondPartOfCurve = $torqueCalcs['AdjyInterceptSecondPartOfCurve'];
            $AdjMaxTurnsForSecondPartOfCurve = $torqueCalcs['AdjMaxTurnsForSecondPartOfCurve'];

            $AdjMaxTurnsForThirdPartOfCurve = $torqueCalcs['AdjMaxTurnsForThirdPartOfCurve'];
            $AdjyInterceptThirdPartOfCurve = $torqueCalcs['AdjyInterceptThirdPartOfCurve'];
            $AdjSlopeThirdPartOfCurve = $torqueCalcs['AdjSlopeThirdPartOfCurve'];


            $maxFullLayersFromTurnsR = $torqueCalcs['maxFullLayersFromTurnsR'];
            $extraWrapsAfterFullLayersTurnsI = $torqueCalcs['extraWrapsAfterFullLayersTurnsI'];
            $extraWrapsAfterFullLayersTurnsR = $torqueCalcs['extraWrapsAfterFullLayersTurnsR'];


            $springFamilyIndex = $torqueCalcs["springFamilyIndex"];
            $adjustedTorque = $torqueCalcs["adjustedTorque"];
            $springTurnsAvailAfterPretensionR = $torqueCalcs["springTurnsAvailAfterPretensionR"];
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
        $cableCapacityLostSecondClearanceWrap = 0;
        $cableCapacityLostFirstClearanceWrap = 0;
        $cableCapacityLostThirdClearanceWrap = 0;
        $cableClearanceInInches = (($frameSize - $drumSize) / 2) - ($maxUsableLayersR * $cableThick);

        $cableLayerIndexI = (int)($cableLayerIndexR);
        //    if(!($cableLayerIndexI > $maxCableLayersI)) {
        //      $cableCapacityLostFirstClearanceWrap = $maxWrapsPerLayerR * ($drumSize + (2 * $cableLayerIndexR - 1) * $cableThick) * $pi / 12;
        //      $cableClearanceInInchesLess1Layers = (($frameSize - $drumSize) / 2) - (($maxUsableLayersR + 2) * $cableThick);
        //
        //      $cableLayerIndexR++;
        //      $cableLayerIndexI = $cableLayerIndexR;
        //      if(!($cableLayerIndexI > $maxCableLayersI)) {
        //        $cableCapacityLostSecondClearanceWrap = $maxWrapsPerLayerR * ($drumSize + (2 * $cableLayerIndexR - 2) * $cableThick) * $pi / 12;
        //        $cableClearanceInInchesLess2Layers = (($frameSize - $drumSize) / 2) - (($maxUsableLayersR) * $cableThick);
        //
        //        $cableLayerIndexR++;
        //        $cableLayerIndexI = $cableLayerIndexR;
        //        if(!($cableLayerIndexI > $maxCableLayersI)) {
        //          $cableCapacityLostThirdClearanceWrap = $maxWrapsPerLayerR * ($drumSize + (2 * $cableLayerIndexR - 1) * $cableThick) * $pi / 12;
        //          $cableClearanceInInchesLess3Layers = (($frameSize - $drumSize) / 2) - (($maxUsableLayersR + 3) * $cableThick);
        //        }
        //      }
        //    }

        if ($cableLayerIndexI > $maxCableLayersI) {

            goto LINE417;
        }

        $cableCapacityLostFirstClearanceWrap = $maxWrapsPerLayerR * ($drumSize + (2 * $cableLayerIndexR - 1) * $cableThick) * $pi / 12;
        $cableClearanceInInchesLess1Layers = (($frameSize - $drumSize) / 2) - (($maxUsableLayersR + 1) * $cableThick);


        $cableLayerIndexR++;
        $cableLayerIndexI = (int)($cableLayerIndexR);


        if ($cableLayerIndexI > $maxCableLayersI) {

            goto LINE417;
        }


        $cableCapacityLostSecondClearanceWrap = $maxWrapsPerLayerR * ($drumSize + (2 * $cableLayerIndexR - 1) * $cableThick) * $pi / 12;
        $cableClearanceInInchesLess2Layers = (($frameSize - $drumSize) / 2) - (($maxUsableLayersR + 2) * $cableThick);
        $cableLayerIndexR++;
        $cableLayerIndexI = (int)($cableLayerIndexR);

        if ($cableLayerIndexI > $maxCableLayersI) {
            goto LINE417;
        }

        $cableCapacityLostThirdClearanceWrap = $maxWrapsPerLayerR * ($drumSize + (2 * $cableLayerIndexR - 1) * $cableThick) * $pi / 12;
        $cableClearanceInInchesLess3Layers = (($frameSize - $drumSize) / 2) - (($maxUsableLayersR + 3) * $cableThick);


        LINE417:
        $compartmentMaximumCableLength = $compartmentCableCapacity + $cableCapacityLostFirstClearanceWrap + $cableCapacityLostSecondClearanceWrap + $cableCapacityLostThirdClearanceWrap;
        $collectorAmp = $collector['collectorAmp'];
        Debugbar::info($collector);
        $numCollectorConductors = $collector['numCollectorConductors'];

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
                            break;
                        case 200:
                            $torqueToOvercomeCollectorFriction = 0.5 + 1.2 * $numCollectorConductors + ($grndchkQty * 0.7);
                            break;
                        case 400:
                            $torqueToOvercomeCollectorFriction = 0.5 + 2 * $numCollectorConductors + ($grndchkQty * 0.7);
                            break;
                    }
            }


           // switch ($srchStyle) { //todo:figure out why this is here... it shouldnt matter. see line 2930 of ReelMod.bas
          // }
            //line 2930 ReelMod.Bas
            //Adjusted torque is never used in the calcInertia function, so I will set it to a default value for TMR searches for now


            $firstLayerMomentArm = ($drumSize + $cableThick) / (2 * 12);
            $validTurns = true;

            switch ($srchStyle) {
                case "S":
                case "MMD":
                case "SM":
                case 'SHO':
                case 'U':
                case 'K':
                    $spoolWidthCode = 0;
                    if ($cableThick <= 0.5) {
                        $torqueSafetyFactor = 1.2;
                    } else {
                        if ($cableThick <= 0.75) {
                            if ($drumSize <= 9) {
                                $torqueSafetyFactor = 1.3;
                            }
                            if ($drumSize > 9) {
                                $torqueSafetyFactor = 1.2;
                            }

                        } else {
                            if ($cableThick <= 1) {
                                if ($drumSize <= 12) {
                                    $torqueSafetyFactor = 1.4;
                                }
                                if ($drumSize > 12) {
                                    $torqueSafetyFactor = 1.3;
                                }

                            } else {
                                if ($cableThick <= 1.25) {
                                    if ($drumSize <= 15) {
                                        $torqueSafetyFactor = 1.5;
                                    }
                                    if ($drumSize > 15) {
                                        $torqueSafetyFactor = 1.4;
                                    }

                                } else {
                                    if ($cableThick <= 1.5) {
                                        if ($drumSize <= 18) {
                                            $torqueSafetyFactor = 1.6;
                                        }
                                        if ($drumSize > 18) {
                                            $torqueSafetyFactor = 1.5;
                                        }

                                    } else {
                                        if ($drumSize <= 21) {
                                            $torqueSafetyFactor = 1.7;
                                        }
                                        if ($drumSize > 21) {
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



            //Sanning: These only run correctly in case 'K' so far, as otherwise adjustedTorque, springFamilyIndex, and wrapperWidhR are all 0
            $reelInertiaCalcs = $this->calcInertia($srchStyle, $frameSize, $drumSize, $adjustedTorque, $springFamilyIndex, $wrapperWidthR, $srchSpoolMethod, $cable);
            $reelInertia = $reelInertiaCalcs['reelInertia'];


           //initialCalcs Assigned here CAI

           $initialCalcs = array(
               "wrapperWidthR" => $wrapperWidthR,
               "compartmentHeight" => $compartmentHeight,
               "cableClearanceFactor" => $cableClearanceFactor,
               "compartmentMaximumCableLength" => $compartmentMaximumCableLength,
               "cableCapacityLostFirstClearanceWrap" => $cableCapacityLostFirstClearanceWrap,
               "cableCapacityLostSecondClearanceWrap" => $cableCapacityLostSecondClearanceWrap,
               "cableCapacityLostThirdClearanceWrap" => $cableCapacityLostThirdClearanceWrap,
               "compartmentCableCapacity" => $compartmentCableCapacity,
               "cableClearanceInInchesLess1Layers" => $cableClearanceInInchesLess1Layers,
               "cableClearanceInInchesLess2Layers" => $cableClearanceInInchesLess2Layers,
               "cableClearanceInInchesLess3Layers" => $cableClearanceInInchesLess3Layers,
               "cableClearanceInInches" => $cableClearanceInInches,
               "firstLayerMomentArm" => $firstLayerMomentArm,
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
               "hosewgtboth" => $hoseWgtboth

           );

            Debugbar::info("Ran through initialCalcs");
            return $initialCalcs;

        }
    }

    private function calcInertia($srchStyle, $frameSize, $drumSize, $adjustedTorque, $springFamilyIndex, $wrapperWidthR, $srchSpoolMethod, $c) {

        Debugbar::info($c["hoseIDCode"]);
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
                $shaftInertia = .1;
                $reelInertia = $diskInertia + $wrapperInertia + $shaftInertia;
                $reelInertiaCalcs = array(
                    'reelInertia' => $reelInertia,
                    'totalWeightLessCable' => 0
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

        //
        //    if(!($availSpringTurns <= $maxTurnsForSecondPartOfCurve[$springFamilyIndex])) {
        //
        //
        //      if(!($availSpringTurns <= $maxTurnsForSecondPartOfCurve[$springFamilyIndex])) {
        //
        //      }
        //
        //    }

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

        $pi = pi();

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

        $qtyConductorsLessGrndchk = $cable['cond'] + $cable['ground'];


        if ($appType == 'Magnet') {
            $collectorAmp = 200;
            $collectorCode = '220';
            $numCollectorConductors = 2;
        }

        $metricDefault = false;
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
                        break;
                }
                break;
        }

        switch ($collectorAmp) {
            case 35:
                $g = $qtyConductorsLessGrndchk + 0;//TODO $grndchkQty -- import
                if ($g > 36) {
                    $collectorCode = 'Bad';
                    break;
                }
                if ($g > 30) {
                    $collectorCode = '363';
                    $numCollectorConductors = 36;
                    break;
                }
                if ($g > 24) {
                    $collectorCode = '303';
                    $numCollectorConductors = 30;
                    break;
                }
                if ($g > 20) {
                    $collectorCode = '243';
                    $numCollectorConductors = 24;
                    break;
                }
                if ($g > 16) {
                    $collectorCode = '203';
                    $numCollectorConductors = 20;
                    break;
                }
                if ($g > 14) {
                    $collectorCode = '163';
                    $numCollectorConductors = 16;
                    break;
                }
                if ($g > 12) {
                    $collectorCode = '143';
                    $numCollectorConductors = 14;
                    break;
                }
                if ($g > 10) {
                    $collectorCode = '123';
                    $numCollectorConductors = 12;
                    break;
                }
                if ($g > 8) {
                    $collectorCode = '103';
                    $numCollectorConductors = 10;
                    break;
                }
                if ($g > 6) {
                    $collectorCode = '83';
                    $numCollectorConductors = 8;
                    break;
                }
                if ($g > 4) {
                    $collectorCode = '63';
                    $numCollectorConductors = 6;
                    break;
                }
                if ($g > 3) {
                    $collectorCode = '43';
                    $numCollectorConductors = 4;
                    break;
                }
                if ($g > 2) {
                    $collectorCode = '33';
                    $numCollectorConductors = 3;
                    break;
                }
                if ($g > 0) {
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

                if ($g > 6) {
                    $collectorCode = '87';
                    $numCollectorConductors = 8;
                    break;
                }
                if ($g > 4) {
                    $collectorCode = '67';
                    $numCollectorConductors = 6;
                    break;
                }
                if ($g > 3) {
                    $collectorCode = '47';
                    $numCollectorConductors = 4;
                    break;
                }
                if ($g > 2) {
                    $collectorCode = '37';
                    $numCollectorConductors = 3;
                    break;
                }
                if ($g > 0) {
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
                if ($g > 3) {
                    $collectorCode = '412';
                    $numCollectorConductors = 4;
                    break;
                }
                if ($g > 2) {
                    $collectorCode = '312';
                    $numCollectorConductors = 3;
                    break;
                }
                if ($g > 0) {
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
                if ($g > 3) {
                    $collectorCode = '420';
                    $numCollectorConductors = 4;
                    break;
                }
                if ($g > 2) {
                    $collectorCode = '320';
                    $numCollectorConductors = 3;
                    break;
                }
                if ($g > 0) {
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
                if ($g > 0) {
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
            'numCollectorConductors' => $numCollectorConductors
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

    private function doInitialCMCalcs($srchStyle, $srchFrame, $cable, $drumSize, $pretensionTurns, $cableCF, $travelInFt, $deadWraps, $modelIndex, $specificInput, $maxTurnsFromSpring, $turnsUsedPercent, $cableOrHose, $srchColl, $srchSpring, $srchMotor) {
        $cableThick = $cable["thickness"];
        //in progress.
        $metricDefault = false; // false for now.
        $validTurns = false;
        $validCompartment = false;
        $torqueToOvercomeCollectorFriction = 0; $WrapperWidthR = 0; $frameSize = 0; $index = 0; $iyfin = 0; $circ = 0;
        $torqueSafetyFactor = 0; $spoolWeight = 0; $coefficient = 0; $reelInertia = 0;

        if ($cableCF == 0) {
            $cableClearenceFactor = 1;
        } else {
            $cableClearenceFactor = $cableCF;
        }

        $gearRatio = 1;
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
                $frameSize = 19;
                $drumSize = 10.5;
                $WrapperWidthR = 4;
                $spoolWeight = 59.6;
                $coefficient = 0.025;
                break;
        }
        $maxWrapsPerLayerR = $WrapperWidthR / $cableThick;

        $maxWrapsPerLayerI = (int)$maxWrapsPerLayerR;
        $maxWrapsPerLayerR = $maxWrapsPerLayerI;

        $maxCableLayersR = ($frameSize - $drumSize) / (2 * $cableThick);

        $maxCableLayersI = (int)$maxCableLayersR;

        $maxUsableLayersR = $maxCableLayersR - $cableClearenceFactor;

        $maxUsableLayersI = (int)$maxUsableLayersR;

        $maxUsableLayersR = $maxUsableLayersI;

        $clrmin = (($frameSize - $drumSize) / 2) - ($maxCableLayersI * $cableThick);
        $ec = $maxWrapsPerLayerR * ($clrmin / $cableThick);
        if ($cableThick > 1) {
            $ec = 0;
        }
        $iec = (int)$ec;
        $ec = $iec;


        $compartmentHeight = ($frameSize - $drumSize) / 2;

        $ixarr = array();
        $wrap = array();
        $row = array();

        for ($a = 1; $a <= 50; $a++) {
            $ixarr[$a] = $maxWrapsPerLayerI;
            $wrap[$a] = 0;
            $row[$a] = 0;
//          array_push($ixarr, $maxWrapsPerLayerI);
//          array_push($wrap, 0);
//          array_push($row, 0);

        }


        $ixarr[1] = $ixarr[1] - $deadWraps;

        $ratio = ($WrapperWidthR - $maxWrapsPerLayerR * $cableThick) / $cableThick;

        if ($ratio < 0.52) {
            goto LINE350;
        } // todo check logic..
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


        $iquot = (int)($maxUsableLayersI / 5);


        $irem = $maxUsableLayersI - $iquot * 5;
        if ($irem <= 1) {
            $irem = 1;
        }
        $x = $this->jxcorr($irem, $index);
        $z = $this->jxcorr(5, $index);
        $ixcorr = $this->jxcorr($irem, $index) + $iquot * $this->jxcorr(5, $index);


        $ixst = $maxUsableLayersI / 2 - $ixcorr / 2 + 1;


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
            $wrap[$a] = ($drumSize + (2 * $yind - 1) * $cableThick) * pi() / 12;
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
        $wrapec = ($drumSize + (2 * $yind - 1) * $cableThick) * pi() / 12;
        $rowec = $ec * $wrapec;
        $itmax = $itmax + $ec;
        $rlen = $rlen + $rowec;
        LINE415:
        if ($ec > 0 || $cableClearenceFactor >= 1) {
            $maxUsableLayersR = $maxUsableLayersR + 1;
        }
        $compartmentActiveCableLength = $rlen;
        $maxUsableWrapsR = $itmax;


        if ($compartmentActiveCableLength < $travelInFt) {
            //todo: find out if [$modelIndex] portion is required, if so go through and add it to the relevant switch statements
            switch ($specificInput[$modelIndex]) {
                case false:
                    $initialCMCalcs = array(
                        "validTurns" => false,
                        "validCompartment" => false,
                        "invalidReason" => 1
                    );
                    return $initialCMCalcs;
                case true:
                    $invalidWarning = true;
                    break;
            }
        }
        if ($compartmentActiveCableLength < $travelInFt) {
            $invalidWarning = true;
        }

        $validCompartment = true;

        $springTurnsAvailForReeling = (int)$maxTurnsFromSpring * ($turnsUsedPercent / 100);
        $springTurnsAvailAfterPretensionR = $springTurnsAvailForReeling - $pretensionTurns;
        $springTurnsAvailAfterPretensionI = (int)$springTurnsAvailAfterPretensionR;
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
            switch ($specificInput[$modelIndex]) {
                case false:
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
                $sCollComp = substr($srchColl, -2);

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
                        $c = $cable['awg'];
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
                        $c = $cable['awg'];
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
                $conductorQty = ($cable['cond'] + $cable['ground']) + $cable['grndchck'];


                if ($cable['style'] == "Cable" || $cable['style'] == "G") {
                    $conductorQty = $conductorQty + 1;

                }
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
                        $torqueSafetyFactor = 1;
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
                        $torqueSafetyFactor = 2;
                        break;
                    default:
                        $torqueSafetyFactor = 2.5;
                }
                break;

        }

        $cbend = 2 * $torqueSafetyFactor * $drumSize / 24;


        $ra = $drumSize / 24;

        $momentArm = ($drumSize + 5 * $cableThick) / (2 * 12);
        $springTorqueAvailForReeling = $this->getCMSpringData((int)$springTurnsAvailForReeling, $srchSpring);

        if ($compartmentActiveCableLength < $turnsActiveCableLength) {
            $tempTurns = ($gearRatio * $pretensionTurns) + $maxUsableWrapsR;
            $springTorqueAvailForReeling = $this->getCMSpringData((int)$tempTurns, $srchSpring);

        }

        $adjustedTorque = $springTorqueAvailForReeling;

        $validTurns = true;
        $initialCMCalcs = array(
            "compartmentHeight" => $compartmentHeight,
            "adjustedTorque" => $adjustedTorque,
            "momentArm" => $momentArm,
            "ra" => $ra,
            "wraparr" => $wrap,
            "ixarr" => $ixarr,
            "cbend" => $cbend,
            "spoolWeight" => $spoolWeight,
            "coefficient" => $coefficient,
            "reelInertia" => $reelInertia,
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
            "availSpringTurns" => 0

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

    private function jxcorr($a, $b) {
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

    private function checkDrumSize($srchStyle, $srchFrame, $ccf, $cableThick, $srchDrummax) { // this should work.

        switch ($srchStyle) {
            case 'SHO':
            case 'TMR':
                $validDrumMax = $srchFrame - ((1 + $ccf) * 2 * $cableThick);
                $validDrumMax = (int)$validDrumMax;

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
                $validDrumMax = intval($validDrumMax);
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

    private function assignGearRatio($srchStyle, $gearRatio) {


        switch ($srchStyle) {
            case 'S':
            case 'SM':
            case 'MMD':
                switch ($gearRatio) {
                    case 'none':
                        $gearRatioStr = '1.00';
                        break;
                    case 'A':
                        $gearRatioStr = '1.22';
                        break;
                    case 'B':
                        $gearRatioStr = '1.50';
                        break;
                    case 'C':
                        $gearRatioStr = '1.86';
                        break;
                    case 'D':
                        $gearRatioStr = '2.07';
                        break;
                    case 'E':
                        $gearRatioStr = '2.33';
                        break;
                    case 'F':
                        $gearRatioStr = '3.00';
                        break;
                    case 'G':
                        $gearRatioStr = '4.00';
                        break;
                    case 'J':
                        $gearRatioStr = '2.00';
                        break;
                    case 'K':
                        $gearRatioStr = '2.33';
                        break;
                    case 'M':
                        $gearRatioStr = '1.50';
                        break;
                    case 'N':
                        $gearRatioStr = '1.72';
                        break;
                    case 'P':
                        $gearRatioStr = '2.00';
                        break;
                    case 'Q':
                        $gearRatioStr = '2.33';
                        break;
                    case 'R':
                        $gearRatioStr = '2.75';
                        break;
                    case 'S':
                        $gearRatioStr = '4.00';
                        break;
                    case 'T':
                        $gearRatioStr = '1.50';
                        break;
                    case 'V':
                        $gearRatioStr = '2.00';
                        break;
                    case 'W':
                        $gearRatioStr = '2.75';
                        break;
                    case 'Y':
                        $gearRatioStr = '4.00';
                        break;
                    case 'all':
                        $gearRatioStr = 'all';
                        break;
                    default:
                        $gearRatioStr = '1.00';
                }

                break;
            case 'U':
                break;
            case 'SHO':
            case 'TMR':

                switch (substr($gearRatio, -1)) {
                    case "A":
                        $gearRatioStr = '3';
                        break;
                    case "B":
                        $gearRatioStr = '2.5';
                        break;
                    case "C":
                        $gearRatioStr = '2.0';
                        break;
                    case "D":
                        $gearRatioStr = '1.5';
                        break;
                    case "E":
                        $gearRatioStr = '1';
                        break;
                    case "L":
                        $gearRatioStr = 'all';
                        break;
                    default:
                        $gearRatioStr = '1';

                }

                break;
            default:
                $gearRatioStr = '1.00';

        }

        return $gearRatioStr;
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

    public function calcStretchApplCM($application, $initialCMCalcs, $cable, $drumSize, $gearRatioStr, $pretensionTurns, $srchSpring, $specificInput) {

        $accelInFtSecSec = floatval($application["accel"]);
        $cableWgt = $cable["weight"];
        $percentSagStr = floatval($application["cableSag"]);
        $travelInFt = $application["activeTravel"];
        $speedInFtSec = $application["travelSpeed"];
        $adjustedTorque = $initialCMCalcs["adjustedTorque"];
        $torqueToOvercomeCollectorFriction = $initialCMCalcs["torqueToOvercomeCollectorFriction"];
        $gearRatio = $gearRatioStr;
        $ra = $initialCMCalcs["ra"];
        $cbend = $initialCMCalcs["cbend"];
        $momentArm = $initialCMCalcs["momentArm"];
        $coefficient = $initialCMCalcs["coefficient"];
        $spoolWeight = $initialCMCalcs["spoolWeight"];
        $reelInertia = $initialCMCalcs["reelInertia"];
        $ixarr = $initialCMCalcs["ixarr"];
        $wrap = $initialCMCalcs["wraparr"];
        $row = $initialCMCalcs["row"];
        $maxUsableWrapsR = (int)$initialCMCalcs["maxUsableWrapsR"];
        $springTurnsAvailAfterPretensionR = $initialCMCalcs["springTurnsAvailAfterPretensionR"];
        $cableThick = $cable['thickness'];
        $turnsActiveCableLength = $initialCMCalcs["turnsActiveCableLength"];
        $maxFullLayersFromTurnsR = $initialCMCalcs['maxFullLayersFromTurnsR'];
        $compartmentActiveCableLength = $initialCMCalcs["compartmentActiveCableLength"];

        if ($percentSagStr != "0" && $percentSagStr != "")//std or null
        {
            $percentSag = $percentSagStr / 100;
        } else {
            $percentSag = 10 / 100;
        }
        $sagFactor = 1 / ($percentSag * 8);
        $torqueActiveStretchLength = $adjustedTorque - $torqueToOvercomeCollectorFriction - $cbend;
        $tcabes = ((.6366 * $momentArm) * ($cableWgt * pi() * $momentArm) * $gearRatio) * (1 + ($accelInFtSecSec * $gearRatio / 32.16));
        $tbrges = ((($adjustedTorque * 24 / $drumSize) + $spoolWeight) * $coefficient * 2 / $drumSize) * $drumSize / 24 * $gearRatio;
        $tsples = ($reelInertia * pow($gearRatio, 2) * $accelInFtSecSec) / ($ra * 32.16);

        $stretch = ($torqueActiveStretchLength - ($tsples + $tbrges + $tcabes)) / $sagFactor / ($cableWgt * $momentArm * $gearRatio * (1 + ($accelInFtSecSec * $gearRatio / 32.16)));
        $smax = $stretch;
        $iyind = 1;
        $extraWrapsAfterFullLayersTorqueStretchR = 0;
        $tempCircumferenceTotal = 0;
        LINE460:
        $extraWrapsAfterFullLayersTorqueStretchR = $extraWrapsAfterFullLayersTorqueStretchR + 1;
        if ($extraWrapsAfterFullLayersTorqueStretchR > $ixarr[$iyind]) {
            goto LINE462;
        }
        $tempCircumferenceTotal = $tempCircumferenceTotal + $wrap[$iyind];
        if ($tempCircumferenceTotal <= $smax) {
            goto LINE460;
        }
        goto LINE465;
        LINE462:
        $extraWrapsAfterFullLayersTorqueStretchR = 0;
        $iyind = $iyind + 1;
        goto LINE460;
        LINE465:
        $extraWrapsAfterFullLayersTorqueStretchR = $extraWrapsAfterFullLayersTorqueStretchR - 1;
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

        $unusedSpringTurnsForStretch = 0;
        $availableSpringTurnsForStretch = 0;
        if ($maxUsableWrapsR < $springTurnsAvailAfterPretensionR) {
            goto LINE470;
        }

        $maxStretchCapacityOfReel = $turnsActiveCableLength;
        $unusedSpringTurnsForStretch = 0;
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
        $maxFullLayersAtStretchCapacity = $maxUsableWrapsR;

        if ($maxWrapsFromTorqueStretch >= $maxUsableWrapsR) {
            goto LINE471;
        }

        $maxStretchCapacityOfReel = $maxActiveLengthOfCableFromTorqueStretch;
        $availableSpringTurnsForStretch = ($springTurnsAvailAfterPretensionR - $maxUsableWrapsR) / $gearRatio;
        $maxFullLayersAtStretchCapacity = $ys;

        LINE471:
        LINE472://6583

        $spooledCableInertiaInsideRadius = $drumSize / 24;
        $spooledCableInertiaOutsideRadiusStretch = ($drumSize + 2 * $maxFullLayersAtStretchCapacity * $cableThick) / 24;
        $spooledCableInertiaStretch = ($cableWgt * $maxStretchCapacityOfReel / 2) * (pow($spooledCableInertiaInsideRadius, 2) + pow($spooledCableInertiaOutsideRadiusStretch, 2));
        $totalStretchInertia = $reelInertia + $spooledCableInertiaStretch;

        $spoolFullMomentArmStretch = ($drumSize + (2 * $maxFullLayersAtStretchCapacity - 1) * $cableThick) / 24;


        $torqueToAccelerateReelStretch = ($totalStretchInertia * pow($gearRatio, 2) * $accelInFtSecSec) / ($spoolFullMomentArmStretch * 32.16);

        $adjPretensionTurns = $pretensionTurns * $gearRatio;

        $itempb = (int)$adjPretensionTurns;

        $springTorqueAvailForReeling = $this->getCMspringData($itempb, $srchSpring);
        $torqueFromPretensionTurnsStretch = $springTorqueAvailForReeling;

        LINE474:
        $tbrgfs = ((($torqueFromPretensionTurnsStretch * 24 / $drumSize) + $spoolWeight + ($cableWgt * $torqueActiveStretchLength)) * $coefficient * 2 / $drumSize) * $drumSize / 24 * $gearRatio;
        $tcabfs = ((.6366 * $spoolFullMomentArmStretch) * (pi() * $spoolFullMomentArmStretch * $cableWgt) * $gearRatio) * (1 + ($accelInFtSecSec * $gearRatio / 32.16));

        $netTorqueWithReelFullStretch = $torqueFromPretensionTurnsStretch - ($torqueToAccelerateReelStretch + $torqueToOvercomeCollectorFriction + $cbend + $tbrgfs + $tcabfs);


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
        $turnsActiveCableLength = $initialCalcs["turnsActiveCableLength"];
        $AdjMaxTurnsForSecondPartOfCurve = $initialCalcs["AdjMaxTurnsForSecondPartOfCurve"];
        $AdjyInterceptSecondPartOfCurve = $initialCalcs["AdjyInterceptSecondPartOfCurve"];
        $AdjSlopeSecondPartOfCurve = $initialCalcs["AdjSlopeSecondPartOfCurve"];
        $gearRatio = floatval($gearRatioStr);

        $compartmentActiveCableLength = $initialCalcs["compartmentActiveCableLength"];
        $maxUsableWrapsR = $initialCalcs["maxUsableWrapsR"];
        $springTurnsAvailAfterPretensionR = $initialCalcs["springTurnsAvailAfterPretensionR"];
        $pi = pi();
        $travelInFt = $application["activeTravel"];
        $speedInFtSec = $application["travelSpeed"];
        $adjustedTorque = $initialCalcs["adjustedTorque"];
        $torqueToOvercomeCollectorFriction = $initialCalcs["torqueToOvercomeCollectorFriction"];
        $reelInertia = $initialCalcs["reelInertia"];
        $firstLayerMomentArm = $initialCalcs["firstLayerMomentArm"];
        $deadWrapLength = $initialCalcs["deadWrapLength"];
        $maxWrapsPerLayerR = $initialCalcs["maxWrapsPerLayerR"];
        $cableThick = $cable["thickness"];
        $maxUsableLayersR = $initialCalcs["maxUsableLayersR"];
        $AdjSlopeFirstPartOfCurve = $initialCalcs["AdjSlopeFirstPartOfCurve"];
        $AdjyInterceptFirstPartOfCurve = $initialCalcs["AdjyInterceptFirstPartOfCurve"];
        $AdjMaxTurnsForFirstPartOfCurve = $initialCalcs["AdjMaxTurnsForFirstPartOfCurve"];
        $torqueSafetyFactor = $initialCalcs["torqueSafetyFactor"];
        $maxFullLayersFromTurnsR = $initialCalcs["maxFullLayersFromTurnsR"];
        $extraWrapsAfterFullLayersTurnsR = $initialCalcs["extraWrapsAfterFullLayersTurnsR"];
        $accelInFtSecSec = floatval($application["accel"]);
        $cableWgt = $cable["weight"];
        $percentSagStr = floatval($application["cableSag"]);
        $AdjyInterceptThirdPartOfCurve = $initialCalcs["AdjyInterceptThirdPartOfCurve"];
        $AdjSlopeThirdPartOfCurve = $initialCalcs["AdjSlopeThirdPartOfCurve"];

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
                break;
            case "TMR":
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

    public function calcLiftAppl($srchStyle, $modelIndex, $pretensionTurns, $application, $initialCalcs, $cable, $drumSize, $gearRatio, $validTorque, $specificInput) {
        $pendantInLbs = $application["pendantWeight"];
        $turnsActiveCableLength = $initialCalcs["turnsActiveCableLength"];
        $adjMaxTurnsForSecondPartOfCurve = $initialCalcs["AdjMaxTurnsForSecondPartOfCurve"];
        $adjYInterceptSecondPartOfCurve = $initialCalcs["AdjyInterceptSecondPartOfCurve"];
        $adjSlopeSecondPartOfCurve = $initialCalcs["AdjSlopeSecondPartOfCurve"];
        $compartmentActiveCableLength = $initialCalcs["compartmentActiveCableLength"];
        $maxUsableWrapsR = $initialCalcs["maxUsableWrapsR"];
        $springTurnsAvailAfterPretensionR = $initialCalcs["springTurnsAvailAfterPretensionR"];
        $travelInFt = $application["activeTravel"];
        $speedInFtSec = $application["travelSpeed"];
        $adjustedTorque = $initialCalcs["adjustedTorque"];
        $torqueToOvercomeCollectorFriction = $initialCalcs["torqueToOvercomeCollectorFriction"];
        $reelInertia = $initialCalcs["reelInertia"];
        $firstLayerMomentArm = $initialCalcs["firstLayerMomentArm"];
        $deadWrapLength = $initialCalcs["deadWrapLength"];
        $maxWrapsPerLayerR = $initialCalcs["maxWrapsPerLayerR"];
        $cableThick = $cable["thickness"];
        $maxUsableLayersR = $initialCalcs["maxUsableLayersR"];
        $adjSlopeFirstPartOfCurve = $initialCalcs["AdjSlopeFirstPartOfCurve"];
        $adjYInterceptFirstPartOfCurve = $initialCalcs["AdjyInterceptFirstPartOfCurve"];
        $adjMaxTurnsForFirstPartOfCurve = $initialCalcs["AdjMaxTurnsForFirstPartOfCurve"];
        $torqueSafetyFactor = $initialCalcs["torqueSafetyFactor"];
        $maxFullLayersFromTurnsR = $initialCalcs["maxFullLayersFromTurnsR"];
        $extraWrapsAfterFullLayersTurnsR = $initialCalcs["extraWrapsAfterFullLayersTurnsR"];
        $accelInFtSecSec = floatval($application["accel"]);
        $cableWgt = $cable["weight"];
        $percentSagStr = floatval($application["cableSag"]);
        $adjYInterceptThirdPartOfCurve = $initialCalcs["AdjyInterceptThirdPartOfCurve"];
        $adjSlopeThirdPartOfCurve = $initialCalcs["AdjSlopeThirdPartOfCurve"];
        $hoseWgtBoth = $initialCalcs["hosewgtboth"];
        $extraWrapsAtLiftCapacity = 0;

        $pendantTorqueFtLb = $pendantInLbs * $firstLayerMomentArm * (1 + ($accelInFtSecSec / 32.2516));

        switch ($srchStyle) {
            case "S":
            case "SM":
            case "MMD":
            case "SHO":
            case "U":
                $liftTorqueFtLb = ($adjustedTorque - $torqueToOvercomeCollectorFriction) / $torqueSafetyFactor;
                $torqueActiveLiftLength = ($liftTorqueFtLb - ($reelInertia * $accelInFtSecSec / (32.2516 * $firstLayerMomentArm)) - $pendantTorqueFtLb) / ($cableWgt * $firstLayerMomentArm * (1 + ($accelInFtSecSec / 32.2516)));
                break;
            case "P":
                $torqueActiveLiftLength = ($this->globals->torqueFromMotor - ($pendantInLbs * $firstLayerMomentArm)) / ($cableWgt * $firstLayerMomentArm);
                break;
            case "K":
                $liftTorqueFtLb = ($adjustedTorque - $torqueToOvercomeCollectorFriction) / ($torqueSafetyFactor);
                $torqueActiveLiftLength = ($liftTorqueFtLb - ($reelInertia * $accelInFtSecSec / (32.2516 * $firstLayerMomentArm))) / ($cable["weight"] * $firstLayerMomentArm * (1 + ($accelInFtSecSec / 32.2516)));
                break;
            case "TMR":
                $facmi = ($this->globals->rmoti * pow($gearRatio, 2) * $accelInFtSecSec) / (32.2516 * $firstLayerMomentArm);
                $rnme = ($speedInFtSec * $gearRatio) / (2 * pi() * $firstLayerMomentArm);
                if ($rnme > 450) {
                    switch ($specificInput) {
                        case false:
                            $liftApplCalcs = array(
                                'validTorque' => false,
                                'reason' => 3
                            );
                            return $liftApplCalcs;
                        case true:
                            return;
                    }
                }
                if ($rnme > 600) {
                    $tqoute = 0;

                } else {
                    $tqoute = sqrt(pow($this->wriglobals->tqsiz, 2) * (1 - (pow($rnme, 2) / pow(600, 2))));
                }
                $adjustedTorque = $gearRatio * $tqoute;
                $ttel = ($adjustedTorque - $torqueToOvercomeCollectorFriction) / $torqueSafetyFactor;
                $torqueActiveLiftLength = ($ttel - ($reelInertia * $accelInFtSecSec / (32.2516 * $firstLayerMomentArm)) - $pendantTorqueFtLb - $facmi) / ($cableWgt * $firstLayerMomentArm * (1 + ($accelInFtSecSec / 32.2516)));
                break;
        }

        $torqueMaximumLiftLength = $torqueActiveLiftLength + $deadWrapLength;
        if ($torqueActiveLiftLength < $travelInFt) {
            switch ($specificInput) {
                case false:
                    $liftApplCalcs = array(
                        'validTorque' => false,
                        'reason' => 3
                    );
                    return $liftApplCalcs;
                case true:
                    break;
            }
        }

        $maxFullLayersFromTorqueLiftR = 1;
        $extraWrapsAfterFullLayersTorqueLiftR = 1;
        $tempCircumferenceTotal = $deadWrapLength;

        LINE440:
        $extraWrapsAfterFullLayersTorqueLiftR = $extraWrapsAfterFullLayersTorqueLiftR + 1;
        if ($extraWrapsAfterFullLayersTorqueLiftR > $maxWrapsPerLayerR) {
            goto LINE442;
        }
        $circumferenceAtCenterOfMaxFullLayerLift = ($drumSize + (2 * $maxFullLayersFromTorqueLiftR - 1) * $cableThick) * pi() / 12;
        $tempCircumferenceTotal = $tempCircumferenceTotal + $circumferenceAtCenterOfMaxFullLayerLift;


        if ($tempCircumferenceTotal <= $torqueMaximumLiftLength) {
            goto LINE440;
        }
        goto LINE445;
        LINE442:
        $extraWrapsAfterFullLayersTorqueLiftR = 0;
        $maxFullLayersFromTorqueLiftR = $maxFullLayersFromTorqueLiftR + 1;
        goto LINE440;
        LINE445:
        $extraWrapsAfterFullLayersTorqueLiftR = $extraWrapsAfterFullLayersTorqueLiftR - 1;
        $maxFullLayersFromTorqueLiftR = $maxFullLayersFromTorqueLiftR - 1;

        $maxWrapsFromTorqueLift = ($maxWrapsPerLayerR * $maxFullLayersFromTorqueLiftR + $extraWrapsAfterFullLayersTorqueLiftR);


        $maxLengthCableFromTorqueLift = (($drumSize + $maxFullLayersFromTorqueLiftR * $cableThick) * pi() / 12 * $maxWrapsPerLayerR * $maxFullLayersFromTorqueLiftR) + (($drumSize + ((2 * $maxFullLayersFromTorqueLiftR + 1) * $cableThick)) * pi() / 12 * $extraWrapsAfterFullLayersTorqueLiftR);
        $maxActiveLengthOfcableFromTorqueLift = $maxLengthCableFromTorqueLift - $deadWrapLength;
        if ($maxActiveLengthOfcableFromTorqueLift < $travelInFt) {
            switch ($specificInput) {
                case false:
                    $liftApplCalcs = array(
                        'validTorque' => false,
                        'reason' => 3
                    );
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
                $unusedSpringTurnsForLift = 0;
                $maxFullLayersAtLiftCapacity = $maxFullLayersFromTurnsR;
                if ($maxWrapsFromTorqueLift >= $springTurnsAvailAfterPretensionR) {
                    goto LINE448;
                }
                $maxLiftCapacityOfReel = $maxActiveLengthOfcableFromTorqueLift;
                $unusedSpringTurnsForLift = ($springTurnsAvailAfterPretensionR - $maxWrapsFromTorqueLift) / $gearRatio;
                $maxFullLayersAtLiftCapacity = $maxFullLayersFromTorqueLiftR;
                $extraWrapsAtLiftCapacity = $extraWrapsAfterFullLayersTorqueLiftR;

                LINE448:
                if ($extraWrapsAtLiftCapacity != 0) {
                    $maxFullLayersAtLiftCapacity = $maxFullLayersAtLiftCapacity + 1;
                }
                goto LINE452;
                LINE450:
                $maxLiftCapacityOfReel = $compartmentActiveCableLength;
                $unusedSpringTurnsForLift = 0;
                $availableSpringTurnsForlift = 0;
                $maxFullLayersAtLiftCapacity = $maxUsableLayersR;
                $extraWrapsAtLiftCapacity = 0;
                if ($maxWrapsFromTorqueLift >= $maxUsableWrapsR) {
                    goto LINE451;
                }
                $maxLiftCapacityOfReel = $maxActiveLengthOfcableFromTorqueLift;
                $availableSpringTurnsForlift = ($springTurnsAvailAfterPretensionR - $maxUsableWrapsR) / $gearRatio;
                $maxFullLayersAtLiftCapacity = $maxFullLayersFromTorqueLiftR;
                $extraWrapsAtLiftCapacity = $extraWrapsAfterFullLayersTorqueLiftR;
                LINE451:
                if ($extraWrapsAtLiftCapacity != 0) {
                    $maxFullLayersAtLiftCapacity = $maxFullLayersAtLiftCapacity + 1;
                }
                LINE452:
                $spooledCableInertiaInsideRadius = $drumSize / 24;
                $spooledCableInertiaOutsideRadiusLift = ($drumSize + 2 * $maxFullLayersAtLiftCapacity * $cableThick) / 24;
                if ($srchStyle == "K") {
                    $spooledCableInertiaLift = ($hoseWgtBoth * $maxLiftCapacityOfReel / 2) * (pow($spooledCableInertiaInsideRadius, 2) + pow($spooledCableInertiaOutsideRadiusLift, 2));
                } else {
                    $spooledCableInertiaLift = ($cableWgt * $maxLiftCapacityOfReel / 2) * (pow($spooledCableInertiaInsideRadius, 2) + pow($spooledCableInertiaOutsideRadiusLift, 2));
                }
                $spoolFullMomentArmLift = ($drumSize + (2 * $maxFullLayersAtLiftCapacity - 1) * $cableThick) / 24;
                $torqueToLiftPendant = $pendantInLbs * $spoolFullMomentArmLift * $gearRatio;
                $pendantInertiaLift = $pendantInLbs * pow($spoolFullMomentArmLift, 2);

                $totalLiftInertia = $reelInertia + $spooledCableInertiaLift + $pendantInertiaLift;
                $rmpSpoolFullLift = $speedInFtSec / (2 * pi() * $spoolFullMomentArmLift * $gearRatio);
                $torqueToAccelerateReelLift = ($totalLiftInertia * pow($gearRatio, 2) * $rmpSpoolFullLift) / (5.133 * $speedInFtSec / $accelInFtSecSec);
                $adjPretensionTurns = $pretensionTurns * $gearRatio;
                $torqueFromPretensionTurnsLift = $adjSlopeFirstPartOfCurve * $adjPretensionTurns + $adjYInterceptFirstPartOfCurve;
                if ($adjPretensionTurns <= $adjMaxTurnsForFirstPartOfCurve) {
                    goto LINE454;
                }
                $torqueFromPretensionTurnsLift = $adjSlopeSecondPartOfCurve * $adjPretensionTurns + $adjYInterceptSecondPartOfCurve;
                if ($adjPretensionTurns <= $adjMaxTurnsForSecondPartOfCurve) {
                    goto LINE454;
                }
                $torqueFromPretensionTurnsLift = $adjSlopeThirdPartOfCurve * $adjPretensionTurns + $adjYInterceptThirdPartOfCurve;
                LINE454:
                $netTorqueWithReelFullLift = ($torqueFromPretensionTurnsLift - $torqueToAccelerateReelLift - $torqueToLiftPendant - $torqueToOvercomeCollectorFriction) / $torqueSafetyFactor;

                if ($netTorqueWithReelFullLift < 0) {
                    switch ($specificInput) {
                        case false:
                            $liftApplCalcs = array(
                                'validTorque' => false,
                                'reason' => 3
                            );
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
                $maxFullLayersAtLiftCapacity = $maxUsableLayersR;
                $extraWrapsAtLiftCapacity = 0;
                if ($compartmentActiveCableLength < $maxActiveLengthOfcableFromTorqueLift) {
                    goto LINE600;
                }
                $maxLiftCapacityOfReel = $maxActiveLengthOfcableFromTorqueLift;
                $maxFullLayersAtLiftCapacity = $maxFullLayersFromTorqueLiftR;
                $extraWrapsAtLiftCapacity = $extraWrapsAfterFullLayersTorqueLiftR;
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
        $liftApplCalcs = array(
            'validTorque' => $validTorque,
            'maxLengthCableFromTorqueLift' => $maxLengthCableFromTorqueLift,
            'maxFullLayersFromTorqueLiftR' => $maxFullLayersFromTorqueLiftR,
            'unusedSpringTurnsForLift' => $unusedSpringTurnsForLift,
            'torqueActiveLiftLength' => $torqueActiveLiftLength,
            'netTorqueWithReelFullLift' => 1,
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

    public function calcRetrieveApplCM($srchStyle, $modelIndex, $pretensionTurns, $application, $initialCalcs, $cable, $drumSize, $gearRatio, $validTorque, $specificInput, $srchSpring) {

        $pendantInLbs = $application["pendantWeight"];
        $centerLineInFt = $application["centerline"];
        $cbend = $initialCalcs['cbend'];
        $spoolWeight = $initialCalcs['spoolWeight'];
        $coefficient = $initialCalcs['coefficient'];
        $turnsActiveCableLength = $initialCalcs["turnsActiveCableLength"];
        $compartmentActiveCableLength = $initialCalcs["compartmentActiveCableLength"];
        $torqueToOvercomeCollectorFriction = $initialCalcs["torqueToOvercomeCollectorFriction"];
        $reelInertia = $initialCalcs["reelInertia"];
        $cableThick = $cable["thickness"];
        $maxUsableLayersR = $initialCalcs["maxUsableLayersR"];
        $maxFullLayersFromTurnsR = $initialCalcs["maxFullLayersFromTurnsR"];
        $accelInFtSecSec = floatval($application["accel"]);
        $cableWgt = $cable["weight"];
        $maximumRetrieveCapacityOfReel = $compartmentActiveCableLength;
        $maxFullLayersAtRetrieveCapacity = $maxUsableLayersR;

        if ($turnsActiveCableLength >= $maximumRetrieveCapacityOfReel) {
            goto LINE485;
        }
        $maximumRetrieveCapacityOfReel = $turnsActiveCableLength;
        $maxFullLayersAtRetrieveCapacity = $maxFullLayersFromTurnsR;
        LINE485:
        $spooledCableInertiaInsideRadius = $drumSize / 25;
        $spooledCableInertiaOutsideRadiusRetrieve = ($drumSize + 2 * $maxFullLayersAtRetrieveCapacity * $cableThick) / 24;
        $spooledCableInertiaRetrieve = ($cableWgt * $maximumRetrieveCapacityOfReel / 2) * (pow($spooledCableInertiaInsideRadius, 2) + pow($spooledCableInertiaOutsideRadiusRetrieve, 2));
        $totalRetrieveInertia = $reelInertia + $spooledCableInertiaRetrieve;

        $spoolFullMomentArmRetrieve = ($drumSize + (2 * $maxFullLayersAtRetrieveCapacity - 1) * $cableThick) / 24;

        $torqueToAccelerateReelRetrieve = ($totalRetrieveInertia * pow($gearRatio, 2) * $accelInFtSecSec) / ($spoolFullMomentArmRetrieve * 32.16);

        $adjPretensionTurns = $pretensionTurns * $gearRatio;
        $itempb = (int)$adjPretensionTurns;
        $springTorqueAvailForReeling = $this->getCMspringData($itempb, $srchSpring);
        $torqueFromPretensionTurnsRetrieve = $springTorqueAvailForReeling;
        LINE490:


        $tcabfl = ((.9003 * $spoolFullMomentArmRetrieve) * ($cableWgt * pi() * $spoolFullMomentArmRetrieve / 2) * $gearRatio) * (1 + ($accelInFtSecSec * $gearRatio / 32.16));
        $tpenfl = ($pendantInLbs * $spoolFullMomentArmRetrieve * $gearRatio) * (1 + ($accelInFtSecSec * $gearRatio / 32.16));

        $tbgrfl = ((($totalRetrieveInertia * 24 / $drumSize) + $spoolWeight + ($cableWgt * $maximumRetrieveCapacityOfReel)) * $coefficient * 2 / $drumSize) * $drumSize / 24 * $gearRatio;


        //Not sure why, but TBRGFL doesnt exist in the code. TBGRFL does, but there's two characters switched. This somehow yeilds the correct result. WHAT.

        $netTorqueWithReelFullRetrieve = $torqueToAccelerateReelRetrieve - ($torqueToAccelerateReelRetrieve + $torqueToOvercomeCollectorFriction + $cbend + 0 + $tcabfl + $tpenfl);

        $maxCenterLineHeight = $netTorqueWithReelFullRetrieve / (($spoolFullMomentArmRetrieve * $cableWgt * $gearRatio) * (1 + ($accelInFtSecSec * $gearRatio / 32.16)));

        if ($maxCenterLineHeight < 0) {
            $maxCenterLineHeight = 0;
        }
        if ($maxCenterLineHeight < $centerLineInFt) {
            switch ($specificInput) {
                case false:
                    $retrieveApplCalcs = array(
                        'validTorque' => false,
                        'reason' => 3
                    );
                    return $retrieveApplCalcs;
                    break;
                case true:
                    break;
            }

        }


        $validTorque = true;
        $retrieveApplCalcs = array(
            'validTorque' => $validTorque,
            'reason' => 0,
            'netTorqueWithReelFullRetrieve' => $netTorqueWithReelFullRetrieve,
            'maxCenterLineHeight' => $maxCenterLineHeight,
            'maxCapacity' => $maximumRetrieveCapacityOfReel
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

        $speedInFtSec = $application["travelSpeed"];


        $torqueToOvercomeCollectorFriction = $initialCalcs["torqueToOvercomeCollectorFriction"];
        $reelInertia = $initialCalcs["reelInertia"];

        $cableThick = $cable["thickness"];
        $maxUsableLayersR = $initialCalcs["maxUsableLayersR"];
        $adjSlopeFirstPartOfCurve = $initialCalcs["AdjSlopeFirstPartOfCurve"];
        $adjYInterceptFirstPartOfCurve = $initialCalcs["AdjyInterceptFirstPartOfCurve"];
        $adjMaxTurnsForFirstPartOfCurve = $initialCalcs["AdjMaxTurnsForFirstPartOfCurve"];
        $torqueSafetyFactor = $initialCalcs["torqueSafetyFactor"];
        $maxFullLayersFromTurnsR = $initialCalcs["maxFullLayersFromTurnsR"];
        $extraWrapsAfterFullLayersTurnsR = $initialCalcs["extraWrapsAfterFullLayersTurnsR"];
        $accelInFtSecSec = floatval($application["accel"]);
        $cableWgt = $cable["weight"];

        $adjYInterceptThirdPartOfCurve = $initialCalcs["AdjyInterceptThirdPartOfCurve"];
        $adjSlopeThirdPartOfCurve = $initialCalcs["AdjSlopeThirdPartOfCurve"];
        $centerLineInFt = $application['centerline'];

        $firstLayerMomentArm = $initialCalcs["firstLayerMomentArm"];//not direct copy from vb6 code, I got this line by looking at the calcliftappl function

        //initialize some variables to 0 to prevent errors.
        $rnme = 0;

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
                Debugbar::info("Hit retrieve calculations for type TMR");
                //TODO Complete these calculations, see line 2478 of REELMOD.BAS
                $maximumRetrieveCapacityOfReel = $compartmentActiveCableLength;
                $maxFullLayersAtRetrieveCapacity = $maxUsableLayersR;
                $spooledCableInertiaInsideRadius = $drumSize/24; //24 may need to be specified as a float

                $facmie = ($this->globals->rmoti * pow($gearRatio,2) * $accelInFtSecSec) / (32.2516 * $firstLayerMomentArm);
                $rnme = ($speedInFtSec + $gearRatio) / (2 * Math.pi() * $firstLayerMomentArm);
                if ($rnme > 450){
                    //todo: does this need to be $modelIndex or $specificInput instead or $specificInput->$modelIndex?
                    switch ($specificInput[$modelIndex]){
                        case false:
                            $retrieveApplCalcs = array(
                                'validTorque' => false,
                                'reason' => 3
                            );
                            return; //equivelent to exit sub
                        case true:
                            $invalidWarning = true;
                            break;
                    }
                }
                if ($rnme > 600){ //line 2495
                    //todo: assign tqoute
                    $tqoute = 0; //TQOUTE maybe stands for tq out e? I thought it was tquote but its spelled differently...
                    //its definitely tq out e, because we have tq out f later on. actually there a lot of variables ending with f that have similar structure to the ones ending in e. It is difficult to keep place when reading the code because of this.
                }
                else {
                    $tqoute = Math . sqrt(Math . pow(tqsiz, 2) * (1 - (Math . pow(rnme, 2) / Math . pow(600, 2))));
                }
                $torke = $gearRatio * $tqoute;
                $ttere = ($torke - $torqueToOvercomeCollectorFriction) / $torqueSafetyFactor;

                $r2re = ($drumSize + 2 * $cableThick)/24;
                $wrcber = ($cableWgt * $deadWrapLength / 2) * (Math.pow($spooledCableInertiaInsideRadius, 2) + Math.pow($r2re, 2));
                $wrtote = $reelInertia + $wrcber;
                $rete = ($ttere - ($wrtote * $accelInFtSecSec / (32.2516 * $firstLayerMomentArm)) - $facmie) / ($cableWgt * $firstLayerMomentArm);

                //spool full
                $rf = ($drumSize + (2 * $maxUsableLayersR - 1) * $cableThick) / 24;

                $facmie  = ($this->globals->rmoti * Math.pow($gearRatio, 2) * $accelInFtSecSec) / (32.2516 * $rf);
                $rnmf = ($speedInFtSec * $gearRatio) / (2 * Math.pi() * $rf);
                if ($rnmf > 600){
                    //todo: does this need to be $modelIndex or $specificInput instead or $specificInput->$modelIndex?
                    switch ($specificInput[$modelIndex]){
                        case false:
                            $retrieveApplCalcs = array(
                                'validTorque' => false,
                                'reason' => 3
                            );
                            return; //equivelent to exit sub
                        case true:
                            $invalidWarning = true;
                            break;
                    }
                }
                if ($rnmf > 600){
                    $tqoutf = 0;
                }
                else{
                    $tqoutf = Math . sqrt(Math . pow(tqsiz, 2) * (1 - (Math . pow(rnmf, 2) / Math . pow(600, 2))));
                }
                $torkf = $gearRatio * $tqoutf;
                $tterf = ($torkf - $torqueToOvercomeCollectorFriction) / $torqueSafetyFactor;

                $r2rf = ($drumSize + 2 * $maxFullLayersAtRetrieveCapacity * $cableThick) /24; //line 2532
                $wrcbfr = ($cableWgt * $maximumRetrieveCapacityOfReel /2) * (Math.pow($spooledCableInertiaInsideRadius,2) + Math.pow($r2rf, 2));
                $wrtotf = $reelInertia + $wrcbfr;
                $retf = ($tterf - ($wrtotf * $accelInFtSecSec / (32.2516 * $rf)) -$facmie) / ($cableWgt *rf);

                $retr = $retf;
                if ($rete < $retf){
                    $retr = $rete;
                }
                if ($retr < $centerLineInFt){ //Nov 7, 2016- changed from: if ($rete < $centerLineInFt){
                    switch ($specificInput[$modelIndex]){
                        case false:
                            $retrieveApplCalcs = array(
                                'validTorque' => false,
                                'reason' => 3
                            );
                            return; //equivelent to exit sub
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

    public function calcLiftApplCM($srchStyle, $modelIndex, $pretensionTurns, $application, $initialCalcs, $cable, $drumSize, $gearRatio, $validTorque, $specificInput, $srchSpring) {
        $springTurnsAvailAfterPretensionR = $initialCalcs['springTurnsAvailAfterPretensionR'];
        $pendantInLbs = $application["pendantWeight"];
        $accelInFtSecSec = floatval($application["accel"]);
        $cableWgt = $cable["weight"];
        $momentArm = $initialCalcs['momentArm'];
        $torqueToOvercomeCollectorFriction = $initialCalcs['torqueToOvercomeCollectorFriction'];
        $adjustedTorque = $initialCalcs['adjustedTorque'];
        $cbend = $initialCalcs['cbend'];
        $spoolWeight = $initialCalcs['spoolWeight'];
        $coefficient = $initialCalcs['coefficient'];
        $reelInertia = $initialCalcs['reelInertia'];
        $ra = $initialCalcs['ra'];
        $ixarr = $initialCalcs['ixarr'];
        $wrap = $initialCalcs['wraparr'];
        $maxUsableWrapsR = $initialCalcs['maxUsableWrapsR'];
        $turnsActiveCableLength = $initialCalcs['turnsActiveCableLength'];
        $maxFullLayersFromTurnsR = $initialCalcs['maxFullLayersFromTurnsR'];
        $row = $initialCalcs['row'];
        $compartmentActiveCableLength = $initialCalcs['compartmentActiveCableLength'];
        $maxUsableLayersR = $initialCalcs['maxUsableLayersR'];
        $cableThick = $cable['thickness'];


        $pendantTorqueFtLb = ($pendantInLbs * $momentArm * $gearRatio) * (1 + ($accelInFtSecSec * $gearRatio / 32.16));
        $tcabel = ((.9003 * $momentArm) * (pi() * $momentArm / 2 * $cableWgt) * $gearRatio) * (1 + ($accelInFtSecSec * $gearRatio / 32.16));

        $liftTorqueFtLb = $adjustedTorque - $torqueToOvercomeCollectorFriction - $cbend;


        $tbrgel = ((($adjustedTorque * 24 / $drumSize) + $spoolWeight) * $coefficient * 2 / $drumSize) * $drumSize / 24 * $gearRatio;


        $tsplel = ($reelInertia * pow($gearRatio, 2) * $accelInFtSecSec) / ($ra * 32.16);

        $vlift = ($liftTorqueFtLb - ($tsplel + $tbrgel + $tcabel + $pendantTorqueFtLb)) / ($cableWgt * $momentArm * $gearRatio * (1 + ($accelInFtSecSec * $gearRatio / 32.16)));

        $rlmax = $vlift;
        $iyind = 1;
        $extraWrapsAfterFullLayersTorqueLiftR = 0;
        $tempCircumferenceTotal = 0;
        $maxWrapsFromTorqueLift = 0;
        $maxLengthCableFromTorqueLift = 0;

        LINE440:
        $extraWrapsAfterFullLayersTorqueLiftR = $extraWrapsAfterFullLayersTorqueLiftR + 1;
        if ($extraWrapsAfterFullLayersTorqueLiftR > $ixarr[$iyind]) {
            goto LINE442;
        }
        $tempCircumferenceTotal = $tempCircumferenceTotal + $wrap[$iyind];

        if ($tempCircumferenceTotal <= $rlmax) {
            goto LINE440;
        }
        goto LINE445;
        LINE442:
        $extraWrapsAfterFullLayersTorqueLiftR = 0;
        $iyind = $iyind + 1;
        goto LINE440;
        LINE445:

        $extraWrapsAfterFullLayersTorqueLiftR = $extraWrapsAfterFullLayersTorqueLiftR - 1;

        $iyfin = $iyind - 1;

        if ($iyfin == 0) {
            goto LINE449;
        }
        for ($iyind = 1; $iyind <= $iyfin; $iyind++) {
            $maxWrapsFromTorqueLift = $maxWrapsFromTorqueLift + $ixarr[$iyind];
            $maxLengthCableFromTorqueLift = $maxLengthCableFromTorqueLift + $row[$iyind];
        }
        LINE449:
        $iyind = $iyfin + 1;
        $maxWrapsFromTorqueLift = $maxWrapsFromTorqueLift + $extraWrapsAfterFullLayersTorqueLiftR;


        $el = $extraWrapsAfterFullLayersTorqueLiftR;

        $maxLengthCableFromTorqueLift = $maxLengthCableFromTorqueLift + $el * $wrap[$iyind];


        $maxActiveLengthOfCableFromTorqueLift = $maxLengthCableFromTorqueLift;


        $maxFullLayersFromTorqueLiftR = $iyfin;
        if ($el == 0) {
            $maxFullLayersFromTorqueLiftR = $iyfin - 1;
        }
        $unusedSpringTurnsForLift = 0;
        $availableSpringTurnsForLift = 0;

        if ($maxUsableWrapsR < $springTurnsAvailAfterPretensionR) {
            goto LINE450;
        }
        $maxLiftCapacityOfReel = $turnsActiveCableLength;

        $maxFullLayersAtLiftCapacity = $maxFullLayersFromTurnsR;
        $unusedSpringTurnsForLift = 0;

        if ($maxWrapsFromTorqueLift >= $springTurnsAvailAfterPretensionR) {
            goto LINE448;
        }
        $maxLiftCapacityOfReel = $maxActiveLengthOfCableFromTorqueLift;

        $maxFullLayersAtLiftCapacity = $maxFullLayersFromTorqueLiftR;
        $unusedSpringTurnsForLift = ($springTurnsAvailAfterPretensionR - $maxWrapsFromTorqueLift) / $gearRatio;

        LINE448:
        goto LINE452;

        LINE450:
        $maxLiftCapacityOfReel = $compartmentActiveCableLength;

        $unusedSpringTurnsForLift = 0;
        $availableSpringTurnsForLift = 0;
        $maxFullLayersAtLiftCapacity = $maxUsableLayersR;
        if ($maxWrapsFromTorqueLift >= $maxUsableWrapsR) {
            goto LINE451;
        }
        $maxLiftCapacityOfReel = $maxActiveLengthOfCableFromTorqueLift;

        $availableSpringTurnsForLift = ($springTurnsAvailAfterPretensionR - $maxUsableWrapsR) / $gearRatio;
        $maxFullLayersAtLiftCapacity = $maxFullLayersFromTorqueLiftR;

        LINE451:
        LINE452:
        $spooledCableInertiaInsideRadius = $drumSize / 24;

        $spooledCableInertiaOutsideRadiusLift = ($drumSize + 2 * $maxFullLayersAtLiftCapacity * $cableThick) / 24;

        $spooledCableInertiaLift = ($cableWgt * $maxLiftCapacityOfReel / 2) * (pow($spooledCableInertiaInsideRadius, 2) + pow($spooledCableInertiaOutsideRadiusLift, 2));

        $spoolFullMomentArmLift = ($drumSize + (2 * $maxFullLayersAtLiftCapacity - 1) * $cableThick) / 24;

        $totalLiftInertia = $reelInertia + $spooledCableInertiaLift;

        $tsplfl = ($totalLiftInertia * pow($gearRatio, 2) * $accelInFtSecSec) / ($spoolFullMomentArmLift * 32.16);

        $tempb = $pretensionTurns * $gearRatio;

        $itempb = $tempb;


        $springTorqueAvailForReeling = $this->getCMspringData($itempb, $srchSpring);


        $torqueToAccelerateReelLift = $springTorqueAvailForReeling;

        $tcabfl = ((.9003 * $spoolFullMomentArmLift) * ($cableWgt * pi() * $spoolFullMomentArmLift / 2) * $gearRatio) * (1 + ($accelInFtSecSec * $gearRatio / 32.16));
        $tpenfl = ($pendantInLbs * $spoolFullMomentArmLift * $gearRatio) * (1 + ($accelInFtSecSec * $gearRatio / 32.16));

        $tbgrfl = ((($totalLiftInertia * 24 / $drumSize) + $spoolWeight + ($cableWgt * $maxLiftCapacityOfReel)) * $coefficient * 2 / $drumSize) * $drumSize / 24 * $gearRatio;


        //Not sure why, but TBRGFL doesnt exist in the code. TBGRFL does, but there's two characters switched. This somehow yeilds the correct result. WHAT.
        $netTorqueWithReelFullLift = $torqueToAccelerateReelLift - ($tsplfl + $torqueToOvercomeCollectorFriction + $cbend + 0 + $tcabfl + $tpenfl);


        if (!$specificInput) {


            if ($netTorqueWithReelFullLift < 0) {


                $stretchApplCalcs = array(
                    'validTorque' => false,
                    'reason' => 3
                );
                return $stretchApplCalcs;
            }
            if ($availableSpringTurnsForLift != 0 || $unusedSpringTurnsForLift != 0) {

                $stretchApplCalcs = array(
                    'validTorque' => false,
                    'reason' => 4

                );
                return $stretchApplCalcs;
            }
        }
        if ($netTorqueWithReelFullLift < 0 || $availableSpringTurnsForLift != 0 || $unusedSpringTurnsForLift != 0) {
            $invalidWarning = true;
        }
        $validTorque = true;
        $stretchApplCalcs = array(
            'validTorque' => $validTorque,
            'maxLengthCableFromTorqueLift' => $maxLengthCableFromTorqueLift,
            'maxFullLayersFromTorqueLiftR' => $maxFullLayersFromTorqueLiftR,
            'unusedSpringTurnsForLift' => $unusedSpringTurnsForLift,
            'netTorqueWithReelFullLift' => 1,
            'maxLiftCapacityOfReel' => $maxLiftCapacityOfReel,
            'extraWrapsAfterFullLayersTorqueLiftR' => $extraWrapsAfterFullLayersTorqueLiftR,
            'netTorqueWithReelFullLift' => $netTorqueWithReelFullLift,
            "availableSpringTurnsForLift" => $availableSpringTurnsForLift,
            "maxActiveLengthOfCableFromTorqueLift" => $maxActiveLengthOfCableFromTorqueLift,
            "maxWrapsFromTorqueLift" => $maxWrapsFromTorqueLift,
            'reason' => 0,
            "maxLengthCableFromTorqueLift" => $maxLengthCableFromTorqueLift
        );
        return $stretchApplCalcs;

    }
}

?>
