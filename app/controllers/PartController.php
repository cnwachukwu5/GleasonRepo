<?php

class PartController extends BaseController {


    public function showAll() {
        $parts = Part::all();
        //$table = $this->createTable($customers->toArray());

        return View::make('parts', array('parts' => $parts, 'title' => "Parts"));
    }

    public function add() {

        return View::make('parts_add', array('title' => "Add Part"));
    }

    public function addPost() {

        $number = Input::get('partNum');
        $desc = Input::get('desc');
        $price = Input::get('price');
        $unit = Input::get('um');
        $stocked = Input::get('stk');
        $plc = Input::get('plc');

        $part = array(
            'number' => $number,
            'description' => $desc,
            'price' => $price,
            'unit' => $unit,
            'stocked' => $stocked,
            'plc' => $plc,
            
        );

        Part::create($part);

        return Redirect::to('/parts');
    }


}

?>