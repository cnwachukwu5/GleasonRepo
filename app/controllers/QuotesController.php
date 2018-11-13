<?php

class QuotesController extends BaseController {


    //for quotes page
    public function showAll() {

        $quotes = Quote::all();
        $rep = Rep::all();

        return View::make('quotes', array('quotes' => $quotes, 'rep' => $rep));
    }

    public function detailView($id){


        $quote = Quote::where('quotes_id','=', $id)->first();

        $reels = QuoteDetails::where('quoteid', '=', $quote->QuoteID)->get();

        $models = QuoteModel::where('QuoteID','=', $quote->QuoteID)->get();

        $discounts = QuoteDiscount::where('QuoteID', '=', $quote->QuoteID)->get();

        $reelInfo = QuoteReelApp::where('QuoteID', '=', $quote->QuoteID)->get();


        return View::make('quote_detail', array('quote'=>$quote, 'reels' => $reels, 'models' => $models, 'discounts' => $discounts, 'reelInfo' => $reelInfo));

    }

    //this is a view function as well
    public function editQuote($id){

        $quote = Quote::where('quotes_id','=', $id)->first();

        $reels = QuoteDetails::where('quoteid', '=', $quote->QuoteID)->get();

        $models = QuoteModel::where('QuoteID','=', $quote->QuoteID)->get();

        $discounts = QuoteDiscount::where('QuoteID', '=', $quote->QuoteID)->get();

        $reelInfo = QuoteReelApp::where('QuoteID', '=', $quote->QuoteID)->get();

        return View::make('quote_edit', array('quote'=>$quote, 'reels' => $reels, 'models' => $models, 'discounts' => $discounts, 'reelInfo' => $reelInfo));



    }
            //apparently not finished?
    public function updateQuote(){


            //gets all input
            $input = Input::all();

            //Primary key for this entry in he quotes table. Will be a single integer used to locate quote.
            $quoteIDPK = $input['quote-id'];

            //Unique ID generated for this specific quote, used to provide singular identity and to link with related tables.
            $QuoteID = $input['quote-id-two'];

            /*
             *          First, update all the vars inside of Quotes table itself
             *
             *          (except for QuoteID and quoteIDPK which shouldn't change
             * */



            //get current revision number
            $newRevision = $input['quote-revision'];
            //if blank or less tahn 1, move up to 1
            if($newRevision < 1){
                $newRevision = 1;
            }
            else{
                //add 0.1
                $newRevision = $newRevision + 0.1;
            }
            DB::update( "update quotes set Revision = '$newRevision' where quotes_id = $quoteIDPK");

            //productLine
            $newProductLine = $input['quote-productline'];
            DB::update( "update quotes set ProductLine = '$newProductLine' where quotes_id = $quoteIDPK");

            //quote date
            $newQuoteDate = $input['quote-quotedate'];
            DB::update( "update quotes set QuoteDate = '$newQuoteDate' where quotes_id = $quoteIDPK");

            //reel quantity
            $newReelQuantity = $input['quote-reelqty'];
            DB::update( "update quotes set ReelQty = '$newReelQuantity' where quotes_id = $quoteIDPK");

            //show discount?
            $newShowDiscount = $input['quote-showdisc'];
            DB::update( "update quotes set ShowDiscount = '$newShowDiscount' where quotes_id = $quoteIDPK");

            //new cable incline
            $newCableIncline = $input['quote-cableincl'];
            DB::update( "update quotes set CableIncl = '$newCableIncline' where quotes_id = $quoteIDPK");

            $newCableInstall = $input['quote-cableinstall'];
            DB::update( "update quotes set CableInstall = '$newCableInstall' where quotes_id = $quoteIDPK");

            $newExCabMoving = $input['quote-excabmoving'];
            DB::update( "update quotes set ExCabMoving = '$newExCabMoving' where quotes_id = $quoteIDPK");

            $newShowItem = $input['quote-showitem'];
            DB::update( "update quotes set ShowItem = '$newShowItem' where quotes_id = $quoteIDPK");

            $newQuoteStatus = $input['quote-status'];
            DB::update( "update quotes set Status = '$newQuoteStatus' where quotes_id = $quoteIDPK");

            $newQuoteMetric = $input['quote-metric'];
            DB::update( "update quotes set Metric = '$newQuoteMetric' where quotes_id = $quoteIDPK");

                //*note*
                    //this refers to the notes section on the form. The Collum used to store notes is the Subject row. Quote preparer name is stored under RepID, with the first 'R' Capitalized
            $newQuoteSubject = $input['quote-subject'];
            DB::update( "update quotes set Subject = '$newQuoteSubject' where quotes_id = $quoteIDPK");

                //this will refer to who actually prepares the quote, saving their full name as a string
            $newQuotePreparer = $input['quote-RepID'];
            DB::update( "update quotes set RepID = '$newQuotePreparer' where quotes_id = $quoteIDPK");


            $newCustID = $input['quote-custID'];
            DB::update( "update quotes set pkeyCust = '$newCustID' where quotes_id = $quoteIDPK");

            $newRepID = $input['quote-repID'];
            DB::update( "update quotes set pkeyRep = '$newRepID' where quotes_id = $quoteIDPK");



            /*
             * End quotes table
             *
             * */


            /*
             * Models  Table
             *
             *
             * */

            $models = $input['models'];

            foreach($models as $ModelID => $model){

                //model number
                DB::update( "update qtemodel set ModelNum = '$model[modelNum]' where ModelID = '$ModelID'");
                DB::update( "update qtemodel set Series = '$model[series]' where ModelID = '$ModelID'");
                DB::update( "update qtemodel set HazardDuty = '$model[hazardDuty]' where ModelID = '$ModelID'");
                DB::update( "update qtemodel set ReverseRotate =  '$model[reverseRotate]' where ModelID = '$ModelID'");
                DB::update( "update qtemodel set ReqdExtraCAble = '$model[reqdExtraCable]' where ModelID = '$ModelID'");
                DB::update( "update qtemodel set ReelHeight = '$model[reelHeight]' where ModelID = '$ModelID'");
                DB::update( "update qtemodel set ReelWidth = '$model[reelWidth]' where ModelID = '$ModelID'");
                DB::update( "update qtemodel set ReelDepth = '$model[reelDepth]' where ModelID = '$ModelID'");
                DB::update( "update qtemodel set ReelWeight = '$model[reelWeight]' where ModelID = '$ModelID'");
                DB::update( "update qtemodel set QuoteType = '$model[quoteType]' where ModelID = '$ModelID'");
                DB::update( "update qtemodel set Delivery = '$model[delivery]' where ModelID = '$ModelID'");

            }



            /*
             * End Models
             * */

            /*
             * Reels
             * */

            //get reels from applicatiom
            $reels = $input['reels'];

            foreach($reels as $quotedetails_id =>$reel){

                    DB::update("update quotedetails set modelnum = '$reel[modelnum]' where quotedetails_id = '$quotedetails_id'");
                    DB::update("update quotedetails set qty = '$reel[qty]' where quotedetails_id = '$quotedetails_id'");
                    DB::update("update quotedetails set pn = '$reel[pn]' where quotedetails_id = '$quotedetails_id'");
                    DB::update("update quotedetails set description = '$reel[description]' where quotedetails_id = '$quotedetails_id'");
                    DB::update("update quotedetails set price = '$reel[price]' where quotedetails_id = '$quotedetails_id'");
            }



            /*
             * end reels
             *
             * */


            /*
             * Discounts
             *
             *
             * */

            //get input from form
            $discounts = $input['discounts'];

            //process
            foreach($discounts as $qtedisc_id => $discount){

                DB::update("update qtedisc set SreelDisc1 = '$discount[sreel1]' where qtedisc_id = '$qtedisc_id'");
                DB::update("update qtedisc set SreelDisc2 = '$discount[sreel2]' where qtedisc_id = '$qtedisc_id'");

                DB::update("update qtedisc set MMDreelDisc1 = '$discount[mmdreel1]' where qtedisc_id = '$qtedisc_id'");
                DB::update("update qtedisc set MMDreelDisc2 = '$discount[mmdreel2]' where qtedisc_id = '$qtedisc_id'");

                DB::update("update qtedisc set SMreelDisc1 = '$discount[smreel1]' where qtedisc_id = '$qtedisc_id'");
                DB::update("update qtedisc set SMreelDisc2 = '$discount[smreel2]' where qtedisc_id = '$qtedisc_id'");

                DB::update("update qtedisc set SHOreelDisc1 = '$discount[shoreel1]' where qtedisc_id = '$qtedisc_id'");
                DB::update("update qtedisc set SHOreelDisc2 = '$discount[shoreel2]' where qtedisc_id = '$qtedisc_id'");

                DB::update("update qtedisc set TMRreelDisc1 = '$discount[tmrreel1]' where qtedisc_id = '$qtedisc_id'");
                DB::update("update qtedisc set TMRreelDisc2 = '$discount[tmrreel2]' where qtedisc_id = '$qtedisc_id'");

                DB::update("update qtedisc set UEreelDisc1 = '$discount[ureel1]' where qtedisc_id = '$qtedisc_id'");
                DB::update("update qtedisc set UEreelDisc2 = '$discount[ureel2]' where qtedisc_id = '$qtedisc_id'");

                DB::update("update qtedisc set CMreelDisc1 = '$discount[cmreel1]' where qtedisc_id = '$qtedisc_id'");
                DB::update("update qtedisc set CMreelDisc2 = '$discount[cmreel2]' where qtedisc_id = '$qtedisc_id'");

                DB::update("update qtedisc set PreelDisc1 = '$discount[preel1]' where qtedisc_id = '$qtedisc_id'");
                DB::update("update qtedisc set PreelDisc2 = '$discount[preel2]' where qtedisc_id = '$qtedisc_id'");

                DB::update("update qtedisc set UHreelDisc1 = '$discount[uhreel1]' where qtedisc_id = '$qtedisc_id'");
                DB::update("update qtedisc set UHreelDisc2 = '$discount[uhreel2]' where qtedisc_id = '$qtedisc_id'");

                DB::update("update qtedisc set KreelDisc1 = '$discount[kreel1]' where qtedisc_id = '$qtedisc_id'");
                DB::update("update qtedisc set KreelDisc2 = '$discount[kreel2]' where qtedisc_id = '$qtedisc_id'");

                DB::update("update qtedisc set HMreelDisc1 = '$discount[hmreel1]' where qtedisc_id = '$qtedisc_id'");
                DB::update("update qtedisc set HMreelDisc2 = '$discount[hmreel2]' where qtedisc_id = '$qtedisc_id'");

            }

            /*
             * End Discounts
             * */

            /*
             * Reel App
             * */

            $ReelApps = $input['reelapp'];

            foreach($ReelApps as $reelapp_id => $reelApp){

                DB::update("update reelapp set Application = '$reelApp[application]' where reelapp_id = '$reelapp_id'");
                DB::update("update reelapp set Sag = '$reelApp[sag]' where reelapp_id = '$reelapp_id'");
                DB::update("update reelapp set CenterlineHgt = '$reelApp[centerlinehgt]' where reelapp_id = '$reelapp_id'");
                DB::update("update reelapp set Travel = '$reelApp[travel]' where reelapp_id = '$reelapp_id'");
                DB::update("update reelapp set Speed = '$reelApp[speed]' where reelapp_id = '$reelapp_id'");
                DB::update("update reelapp set Accel = '$reelApp[accel]' where reelapp_id = '$reelapp_id'");
                DB::update("update reelapp set Duty_Cycle = '$reelApp[duty_cycle]' where reelapp_id = '$reelapp_id'");
                DB::update("update reelapp set TempMin = '$reelApp[tempmin]' where reelapp_id = '$reelapp_id'");
                DB::update("update reelapp set TempMax = '$reelApp[tempmax]' where reelapp_id = '$reelapp_id'");
                DB::update("update reelapp set SpringTurns = '$reelApp[springturns]' where reelapp_id = '$reelapp_id'");
                DB::update("update reelapp set CCF = '$reelApp[ccf]' where reelapp_id = '$reelapp_id'");
                DB::update("update reelapp set DeadWraps = '$reelApp[deadwraps]' where reelapp_id = '$reelapp_id'");
                DB::update("update reelapp set AppNote = '$reelApp[appnote]' where reelapp_id = '$reelapp_id'");

            }

            /*
             * End Reel App
             * */

        return Redirect::to("/quote/detail/" . $quoteIDPK)->with('success_message', "Quote $QuoteID has been updated.<br><br>[dev note, this does not mean it has actually been updated]");


    }

    //for deleting and removing quotes
   public function deleteQuote(){


        //gets ID from json on quotes.blade
       $id = Input::get('id');

       //due to the structure of these tables (they do not posess a collumn for 'id', which laravel relies on for queries and deletes) we pull all rows of each,
       //then delete those that share the ID of the delted row

       $quotes = Quote::all();

       $reels = QuoteDetails::all();

       $models = QuoteModel::all();

       $discounts = QuoteDiscount::all();

       $reelInfo = QuoteReelApp::all();

try {
    foreach ($quotes as $quote) {

        if ($quote->quotes_id == $id) {
            DB::delete("delete from quotes where quotes_id = $id");
        }

    }

    foreach ($reels as $reel) {

        if ($reel->quotedetails_id == $id) {
            DB::delete("delete from quotedetails where quotedetails_id = $id");
        }

    }

    foreach ($models as $model) {

        if ($model->ModelID == $id) {
            DB::delete("delete from qtemodel where ModelID = $id");
        }


    }

    foreach ($discounts as $discount) {

        if ($discount->qtedisc_id == $id) {
            DB::delete("delete from qtedisc where qtedisc_id = $id");
        }


    }

    foreach ($reelInfo as $info) {

        if ($info->reelapp_id == $id) {

            DB::delete("delete from reelapp where reelapp_id = $id");
            //echo $info;
            //$info->delete();

        }

    }





}
catch(Exception $exception){
    echo "there was an exception";
    echo $exception;
}
   }





    public function showManualForm() {

        $rep = Rep::all();
    	return View::make('manual', array("type" => "manual", "rep" => $rep));
    }

    public function showSpareForm() {
        $rep = Rep::all();
        return View::make('manual', array("type" => "spare", "rep" => $rep));
    }

    public function showTrakForm() {

        $etrak_models = array(
            "none", "any",
            "25E", "55E/EF",
            "28E", "60E/EF",
            "35E", "80E/EF",
            "38E", "100E/EF",
            "48E, Bolted construction (EF)"
        );

        $etrak_carriers = array(
            "BC", "RN", "RR", "SS",
            "AC", "SR", "TRB", "WC",
            "A1", "R1", "TR1", "WV1",
            "A2", "R2", "TR2", "WV2",
            "A3", "R3", "TR3", "WV3",
            "A4", "R4", "TR4", "WV4"
        );

        $searchOptions = array();
        $searchOptions['etrak_models'] = $etrak_models;
        $searchOptions['etrak_carriers'] = $etrak_carriers;

        return View::make('trak', array("type" => "trak", "searchOptions" => $searchOptions));
    }





    //To test cable table, to delete soon
    public function showCables() {
        $cables = Cable::all();

        return View::make('cables', array("cables" => $cables), array("title" => "Cables"));
    }

    public function showReelForm() {
        $companies = Company::all();
        $customers = Customer::all();
        return View::make('reel/reel', array("type" => "reel"), array("companies" => $companies), array("customers" => $customers));
    }

    public function showFestoonForm() {
        return View::make('festoon', array("type" => "festoon"));
    }

    public function showQuoteEditForm($id) {
        $quote = Quote::find($id);
        $rep = Rep::all();

        if($quote != null) {
            $parts = $quote->parts()->get();
        } else {
            $parts = null;
        }
        //$parts = QuotePart::where("quote_id", "=", $id);

        return View::make('manual', array("rep" => $rep, "type" => $quote->type,"parts" => $parts, "quote" => $quote));
    }

    public function postQuote() {
        //require("app/phpDocx.php");
        //$phpdocx = new phpdocx("app/template.docx");

        $rep = Input::get('rep');//Auth::id();
        $qty = Input::get('qty');
        $number = Input::get('part');
        $desc = Input::get('desc');
        $stk = Input::get('stk');
        $price = Input::get('price');
        $unit = Input::get('unit');
        $customer = Input::get('customer');
        $notes = Input::get('notes');
        $discount1 = Input::get('discount1');
        $discount2 = Input::get('discount2');
        $type = Input::get('type');
        $items = array();
        $quote = Quote::create(array(

            "customer_id" => $customer,
            "rep_id" => $rep,
            //***removed employee column from database
            //"employee" => $rep,//this column is redundant
            "notes" => $notes,
            "discount1" => $discount1,
            "discount2" => $discount2,
            "type" => $type

        ));

        for($i = 0; $i < count($qty); $i++) {

            $qp = QuotePart::create(array(
                "quote_id" => $quote->id,
                "number" => $number[$i],
                "quantity" => $qty[$i],
                "description" => $desc[$i],
                "stocked" => $stk[$i],
                "price" => $price[$i],
                "unit" => $unit[$i],
            ));

            /*
             $items[] = array(
                "#NUM#" => ($i+1),
                "#QTY#" => $qty[$i],
                "#UNIT#" => $unit[$i],
                "#ID#" => $number[$i],
                "#DESC#" => $desc[$i],
                "#STK#" => ($stk[$i] == 0 ? "N" : "S"),
                "#PRICE#" => $price[$i]
            );
            */
        }

        //$phpdocx->assignBlock("parts", $items);
        //$phpdocx->save("app/file.docx");

        return Redirect::to('/manual')->with('success_message', "The quote has been created.");
    }

    public function updateManual($id) {

        $quote = Quote::find($id);
        $parts = $quote->parts()->get();

        $part_id = Input::get('id');
        $delete = Input::get('delete');
        $qty = Input::get('qty');
        $number = Input::get('part');
        $desc = Input::get('desc');
        $stk = Input::get('stk');
        $price = Input::get('price');
        $unit = Input::get('unit');
        $customer = Input::get('customer');
        $rep = Input::get('rep');
        $notes = Input::get('notes');
        $discount1 = Input::get('discount1');
        $discount2 = Input::get('discount2');
        $items = array();

        $quote->rep_id = Auth::id();
        $quote->customer_id = $customer;
        $quote->notes = $notes;
        $quote->discount1 = $discount1;
        $quote->discount2 = $discount2;
        $quote->revision++;
        $quote->save();

        for($i = 0; $i < count($part_id); $i++) {

            $pid = $part_id[$i];

            if($pid < 0) {
                QuotePart::create(array(
                    "quote_id" => $quote->id,
                    "number" => $number[$i],
                    "quantity" => $qty[$i],
                    "description" => $desc[$i],
                    "stocked" => $stk[$i],
                    "price" => $price[$i],
                    "unit" => $unit[$i],
                ));
            } else if($delete[$i] == "false") {

                $part = $parts->find($pid);
                $part->number = $number[$i];
                $part->quantity = $qty[$i];
                $part->description = $desc[$i];
                $part->stocked = $stk[$i];
                $part->price = $price[$i];
                $part->unit = $unit[$i];
                $part->save();

            } else if($delete[$i] == "true") {
                $parts->find($pid)->delete();
            }
        }

        return Redirect::to("/edit/$id")->with('success_message', "The quote has been updated.");
    }

    public function viewQuote($id) {
        $quote = Quote::find($id);
        $parts = $quote->parts()->get();
        $customer = $quote->customer()->first();
        $total = 0;
        $discount = ($quote->discount1 + $quote->discount2) / 100;

        foreach($parts as $p) {
            $total += $p->price;
        }

        $discount *= $total;
        $final = $total - $discount;
        $rep = Rep::find($quote->rep_id)->first();

        return View::make('quote_view', array(
            'quote' => $quote,
            'parts' => $parts,
            'customer' => $customer,
            'rep' => $rep,
            'total' => number_format($total, 2),
            'discount' => number_format($discount, 2),
            'final' => number_format($final, 2),
        ));
    }
}

?>
