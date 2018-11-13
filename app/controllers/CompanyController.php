<?php
/**
 * Created by PhpStorm.
 * User: sanningb2
 * Date: 12/5/2017
 * Time: 12:30 PM
 */

class CompanyController extends BaseController{




    function showCompanies(){


        $companies = Company::all();

        return View::make('companies', array('companies' => $companies, 'title' => "Companies"));

    }

    function addCompanyView(){


        return View::make('companies_add', array('title'=> 'Add Company'));

    }

    function addCompany(){

        $name = Input::get('newCompName');

        Company::create(array('name' => $name));

        return Redirect::to('/companies/')->with('success_message', "Company $name created");

    }


    function updateCompany(){

        //get ID from ajax
        $id = Input::get('id');

        //get new name from ajax
        $newName = Input::get('newName');


        //get company by id
        $comp = Company::where('id', '=', $id);
        $comp = $comp->first();


        //update name
        $comp->__set('name', $newName );

        $comp->save();




    }

    function deleteCompany(){

        $id = Input::get('id');

        //get company by id
        $comp = Company::find($id);


        //get associated reps
        $assocReps = Rep::where('company', '=',$id);

        //get associated customers
        $assocCustomers = Customer::where('company_id','=', $id);

        //if there are associated quotes
        if($assocReps->count() > 0){

            //assign them to default ( unassigned)
            DB::table("reps")
                ->where('company', $id)
                ->update(['company' => 1]);


        }

        //if there are associated customers
        if($assocCustomers->count() > 0){

            //assign them to default (unassigned)
            DB::table("customers")
                ->where('company_id', $id)
                ->update(['company_id' => 1]);



        }


        //delete company
        $comp->delete();

        echo "Delete complete";



    }




















}


?>