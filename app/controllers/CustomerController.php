<?php

class CustomerController extends BaseController {


    public function showAll() {
    	$customers = Customer::all();
        $companies = Company::all();

    	return View::make('customers', array('customers' => $customers, 'companies' => $companies, 'title' => "Customers"));
    }

    public function add() {

        $companies = Company::all();
        //$companies = $companies->toArray();

    	return View::make('customers_add', array('companies' => $companies, 'title' => "Add Customer"));
    }

    public function select() {
        $customers = Customer::all();
        $companies = Company::all();

        return View::make('customers_modal', array('customers' => $customers, 'companies' => $companies));
    }

    //this populates the edit page
    public function editCustomer($id){

        //gets customer
        $customer = Customer::where('id', '=', $id)->first();


        return View::make('customers_edit',array('customer'=> $customer, 'title' => "Edit Customer"));

    }

    //this function updates the db information for the customer
    public function updateCustomer(){

        //get info from form
        $customerID = Input::get('customerID');
        $companyID = Input::get('company');
        $name = Input::get('name');
        $address1 = Input::get('address1');
        $address2 = Input::get('address2');
        $address3 = Input::get('address3');
        $phone = Input::get('phone');
        $fax = Input::get('fax');
        $email = Input::get('email');
        $rep = Input::get('rep');
        //this is the hidden nput field that appears if new is selected
        $newCompany = Input::get('newcompany');
        //when new is selected, company has value -1, triggering this script which makes a new company object and assigns this customers ID to link to it.
        if($companyID == -1) {
            $company = Company::create(array('name' => $newCompany));
            $companyID = $company->id;
        }

       //create customer object
        $customer = Customer::where('id', '=', $customerID)->first();

        //update
        $customer->company_id = $companyID;
        $customer->name = $name;
        $customer->address1 = $address1;
        $customer->address2 = $address2;
        $customer->address3 = $address3;
        $customer->phone = $phone;
        $customer->fax = $fax;
        $customer->email = $email;

        //Because rep field only displays if admin is viewing customer. this check is required to prevent rep from being set to 0 or null upon update.
                //further clarification, admin can update the rep for a customer.
                //if admin is not logged in, then the field will not be loaded and the input will get 0. This will break things.
        if($rep !=0) {
            $customer->rep = $rep;
        }

        //save
        $customer->save();

        //redirect
        return Redirect::to('/customers/')->with('success_message', "Customer $name has been updated.");
    }



    public function deletePost() {


        //refer to customer.blade.php for use
        $id = Input::get('id');
        $cus = Customer::find($id);
        $companyId= $cus->company_id;
        $companyCustomers = Customer::where('company_id',$companyId);//does not evaluate until something like get or count is called
        $quotesAssociated = Quote::where('pkeyCust', $id);
        $packagesAssociated = Package::where('customer_id',$id);



        //user was prompted before to confirm deletion of quotes via hasQuotes()
        if ($quotesAssociated->count() > 0){

            $quotesAssociated = Quote::where('pkeyCust', $id)->get();


            foreach ($quotesAssociated as $quote) {
                echo $quote;
                QuotePart::where('quote_id', $quote->id)->delete();
            }
            $quotesAssociated = Quote::where('pkeyCust', $id);
            $quotesAssociated->delete();

        }

        if ($packagesAssociated->count() > 0){
            $packagesAssociated = Package::where('customer_id',$id)->get();
            foreach ($packagesAssociated as $package){
                PackageContent::where('package_id', $package->id)->delete();
            }
            $packagesAssociated = Package::where('customer_id',$id);
            $packagesAssociated->delete();
        }

        //echo $cus;
        $cus->delete();

        //once there a company has no more customers- remove it
                //disabled for now, companies can be deleted in the company page

        /*

        if ($companyCustomers->count() == 0) {
            $companyToDelete = Company::find($companyId);
            $companyToDelete->delete();
        }

        */

    }

    //check if customer has quotes when trying to delete
    public function hasQuotes() {
        $id = Input::get('id');
        $linkedQuotes = Quote::where('pkeyCust',$id);
        if ($linkedQuotes->count() == 0){
            $results = false;
        }
        else {
            $results = true;
        }
        echo json_encode(array("hasQuotes" => $results));
    }

    //function to add customer to database after submission of form
    public function addPost() {
    	$name = Input::get('name');
    	$address1 = Input::get('address1');
    	$address2 = Input::get('address2');
    	$address3 = Input::get('address3');
    	$phone = Input::get('phone');
    	$fax = Input::get('fax');
    	$email = Input::get('email');
        $companyId = Input::get('company');
        $newCompany = Input::get('newcompany');

        //This data field was added later. This is for the Representative associated with the creation of this customer
        //this is used for determining which customers are viewable by which reps.
        $currentRep = Auth::user()->id;

        if($companyId == -1) {
            $company = Company::create(array('name' => $newCompany));
            $companyId = $company->id;
        }

        $customer = array(
            'company_id' => $companyId,
            'name' => $name,
            'address1' => $address1,
            'address2' => $address2,
            'address3' => $address3,
            'phone' => $phone,
            'fax' => $fax,
            'email' => $email,
            'rep' => $currentRep
        );

    	Customer::create($customer);
        
    	return Redirect::to('/customers');
    }

    //usage unsure, possibly used at the start of reel inside of modal, but that was removed. May remove this function later.
    public function addJSON() {
        $name = Input::get('name');
        $address1 = Input::get('address1');
        $address2 = Input::get('address2');
        $address3 = Input::get('address3');
        $phone = Input::get('phone');
        $fax = Input::get('fax');
        $email = Input::get('email');
        $companyId = Input::get('company');
        $newCompany = Input::get('newcompany');

        if($companyId == -1) {
            $company = Company::create(array('name' => $newCompany));
            $companyId = $company->id;
        }

        $customer = array(
            'company_id' => $companyId,
            'name' => $name,
            'address1' => $address1,
            'address2' => $address2,
            'address3' => $address3,
            'phone' => $phone,
            'fax' => $fax,
            'email' => $email,
        );

        $cust = Customer::create($customer);

        $companyName = $cust->company()->first();
        $companyName = $companyName['attributes']['name'];

        $json = array(
            'id' => $cust->id,
            'company' => $companyName,
            'name' => $cust->name,
            'address1' => $cust->address1,
            'address2' => $cust->address2,
            'address3' => $cust->address3,
            'phone' => $cust->phone,
            'fax' => $cust->fax,
            'email' => $cust->email,
        );

        return json_encode($json);


    }


}

?>
