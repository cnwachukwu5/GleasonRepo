<?php
/**
 * Created by PhpStorm.
 * User: sanningb2
 * Date: 4/24/2018
 * Time: 1:53 PM
 */

class PriceController extends BaseController{

    //display view
    public function showPrices(){

        $prices = Prices::all();

        return View::make('prices', array('prices' => $prices));

    }

    public function updatePrice(){

        //get passed vars
        $id = Input::get('id');
        $newPrice = Input::get('newPrice');

        //DB query + get result
        $priceObject = Prices::where('id', '=', $id);
        $priceObject = $priceObject->first();


        //change info in ovject to be updated
        $priceObject->price = $newPrice;


        //save it to DB
        $priceObject->save();



    }

}