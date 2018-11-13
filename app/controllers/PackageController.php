<?php

class PackageController extends BaseController {


    public function showAll() {
        $cables = Cable::all();
        //$table = $this->createTable($customers->toArray());

        return View::make('cables', array('cables' => $cables, 'title' => "Cables"));
    }

    public function cableSelect() {
        return View::make('reel/cable_modal');
    }


    public function hoseSelect() {
        return View::make('reel/hose_modal');
    }

    public function getCable($type, $AWG, $conductors) {

      $query = Cable::where('STYLE','=','R')->where('TYPE','=',$type)->where('AWG','=',$AWG)->where('COND','=', $conductors)->get();

      return $query;
    }

    public function getCableWithPN($pn) {
      $query = Cable::where('pn', $pn)->get();
      return $query;
    }

    public function getHose($insidediameter) {

      $query = Cable::where('ID', '=', $insidediameter)->get();

      return $query;
    }

    public function rename() {

    }

    public function remove() {

        $packageid = Input::get('packageid');


            // delete package content before package to ensure normality

        $idToDelete = PackageContent::where('package_id', '=', $packageid)->pluck('id');

        SpecialContent::where('content_id', $idToDelete)->delete();

        PackageContent::where('package_id', $packageid)->delete();

        Package::where('id', $packageid)->delete();


      return $packageid;
    }



    public function add() {
      $name = Input::get('packageName');
      $quantity = Input::get('quantity');
      $pn = Input::get('pn');
      $style = Input::get('identifier1');
      $type = Input::get('identifier2');
      $customerid = Input::get('customerid');
      $price = Input::get('identifier11');
      $package = array(
        'customer_id' => $customerid,
        'name' => $name
      );
      $package = Package::create($package);

      $contents = array(
        'package_id' => $package->id,
        'pn' => $pn,
        'quantity' => $quantity,
        'style' => $style,
        'type' => $type,
          'price'=>$price
      );
      $contents = PackageContent::create($contents);

      if($pn == "Special Part" || strpos($style, "Dual Hose") !== false ) {

        if($style == "Cable") {
          $special = array(
            'content_id' => $contents->id,
			'style' => $style, 
			'type' => $type, 
            'awg' => Input::get('identifier3'),
            'cond' => Input::get('identifier4'),
            'volts' => Input::get('identifier5'),
            'odiameter' => Input::get('identifier8'),
            'mbr' => Input::get('identifier9'),
            'wgt' => Input::get('identifier10'),
            'reel_price' => Input::get('identifier11')
          );
        }
        else {
          $special = array(
            'content_id' => $contents->id,
            'psi' => Input::get('identifier6'),
              'style' => $style,
            'idiameter' => Input::get('identifier7'),
            'odiameter' => Input::get('identifier8'),
              'mbr' => Input::get('identifier9'),
            'wgt' => Input::get('identifier10'),
            'reel_price' => Input::get('identifier11'),
              'pn' => $pn,
              'type' => $type
          );
        }
        SpecialContent::create($special);
      }

      return $package->id;

    }

    public function update() {
      $quantity = Input::get('quantity');
      $pn = Input::get('pn');
      $packageid = Input::get('packageid');
      $style = Input::get('identifier1');
      $type = Input::get('identifier2');
        $price = Input::get('identifier11');
      $special = null;
      $oldPackageContent = PackageContent::where('package_id', '=', $packageid)->first();
      $isOldStyleDualHose = strpos($oldPackageContent->style, "Dual Hose") !== false;
      $isNewStyleDualHose = strpos($style, "Dual Hose") !== false;
      PackageContent::where('package_id', '=', $packageid)->update(array('quantity' => $quantity, 'pn' => $pn, 'style' => $style, 'type' => $type, 'price'=>$price));
      /*Bugs exist with dual hoses, for some reason they delete the row in special contents*/
      //If the existing package content's pn is special part or the style of it is dual hose (thus it has a row in special_contents),
      if($oldPackageContent->pn == "Special Part" || $isOldStyleDualHose) {
        //and the updated cable/hose isn't a special part or a dual hose
        if($pn != "Special Part" && !$isNewStyleDualHose) {
          //then remove the row in the table special_contents
          SpecialContent::where('content_id', $oldPackageContent->id)->delete();
          $action = "Delete row";
        }
        else {
          //otherwise, update special_contents
          $action = "Update row";
          if($style == "Cable") {
            $special = array(
              'awg' => Input::get('identifier3'),
              'cond' => Input::get('identifier4'),
              'volts' => Input::get('identifier5'),
              'odiameter' => Input::get('identifier8'),
              'wgt' => Input::get('identifier10'),
              'reel_price' => Input::get('identifier11')
            );
          }
          else {
            $special = array(
              'psi' => Input::get('identifier6'),
              'idiameter' => Input::get('identifier7'),
              'odiameter' => Input::get('identifier8'),
              'wgt' => Input::get('identifier10'),
              'reel_price' => Input::get('identifier11')
            );
          }
          SpecialContent::where('content_id', $oldPackageContent->id)->update($special);
        }
      }
      else {
        if($pn == "Special Part" || $isNewStyleDualHose) {
          //Then create a special_contents row for the package contents
          $action = "Create row";
          if($style == "Cable") {
            $special = array(
              //'content_id' => $oldPackageContent->id,
              'awg' => Input::get('identifier3'),
              'cond' => Input::get('identifier4'),
              'volts' => Input::get('identifier5'),
              'odiameter' => Input::get('identifier8'),
              'wgt' => Input::get('identifier10'),
              'reel_price' => Input::get('identifier11')
            );
          }
          else {
              Debugbar::info($pn);
            $special = array(
             //'content_id' => $oldPackageContent->id,
              'style'=> $style,
              'psi' => Input::get('identifier6'),
              'idiameter' => Input::get('identifier7'),
              'odiameter' => Input::get('identifier8'),
              'wgt' => Input::get('identifier10'),
              'reel_price' => Input::get('identifier11'),
                'type'=>$type
            );
          }

          SpecialContent::create($special);
        }
      }

      //var_dump($action, $special, $oldPackageContent, $oldPackageContent->pn, $oldPackageContent->style, $isOldStyleDualHose, $pn, $style, $isNewStyleDualHose);

      return $packageid;
    }

    public function getPackage($packageid) {
      $queryPackageContent = PackageContent::where('package_id', '=', $packageid)->get();
      //var_dump($queryPackageContent);
      return $queryPackageContent;
    }

    public function getCableInPackage($packageid) { //TODO: Start here
      $queryPackageContent = PackageContent::where('package_id', '=', $packageid)->get();
      $packageContent = json_decode($queryPackageContent[0], true);

      if($packageContent['pn'] == "Special Part" || strpos($packageContent['style'], "Dual Hose") !== false) {

        $queryCable = SpecialContent::where('content_id', '=', $packageContent['id'])->get();

      }
      else {

        $queryCable = Cable::where('PN', '=', $packageContent['pn'])->get();


     }
        //Debugbar::info($queryCable);
      return $queryCable;
    }
}

?>
