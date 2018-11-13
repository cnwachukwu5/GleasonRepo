<?php

class TrakController extends BaseController {

    public function showAll() {

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

        return View::make('trak/trak', array("type" => "trak", "searchOptions" => $searchOptions));
    }


    //To test cable table, to delete soon


}

?>
