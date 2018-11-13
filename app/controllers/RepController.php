<?php

class RepController extends BaseController {

	/*
	|--------------------------------------------------------------------------
	| Default Home Controller
	|--------------------------------------------------------------------------
	|
	| You may wish to use controllers instead of, or in addition to, Closure
	| based routes. That's great! Here is an example controller method to
	| get you started. To route to this controller, just add the route:
	|
	|	Route::get('/', 'HomeController@showWelcome');
	|
	*/

	public function login() {

		$rules = array(
			'email'    => 'required|email', // make sure the email is an actual email
			'password' => 'required|alphaNum|min:3' // password can only be alphanumeric and has to be greater than 3 characters
		);


		$validator = Validator::make(Input::all(), $rules);


		if ($validator->fails()) {
			return Redirect::to('sign-in')
				->withErrors($validator) // send back all errors to the login form
				->withInput(Input::except('password')); // send back the input (not the password) so that we can repopulate the form
		} else {

			// create our user data for the authentication
			$userdata = array(
				'email' 	=> Input::get('email'),
				'password' 	=> Input::get('password')
			);

			// attempt to do the login
			if (Auth::attempt($userdata)) {

				// validation successful!
				// redirect them to the secure section or whatever
				// return Redirect::to('secure');
				// for now we'll just echo success (even though echoing in a controller is bad)

				return Redirect::to('/');

			} else {	 	

				$messages = new Illuminate\Support\MessageBag;
				$messages->add('Auth failed', 'Invalid username or password');

				// validation not successful, send back to form	
				return Redirect::to('sign-in')->withErrors($messages);

			}

		}


	}


	public function logout() {
		Auth::logout();
		return Redirect::to('/')->with('success_message', 'You have been successfully logged out.');
	}

    public function showRegister() {



        $companies = Company::all();

        return View::make('rep_add', array('companies'=> $companies, 'title'=> "Add Representative"));

    }


    public function addRep() {

        $address1 = Input::get('address1');
        $address2 = Input::get('address2');
        $address3 = Input::get('address3');
        $phone = Input::get('phone');
        $fax = Input::get('fax');
        $name = Input::get('name');
        $email = Input::get('email');
        $companyID = Input::get('company');
        $companyEmail = Input::get('company_email');   
        $password = Hash::make(Input::get('password'));
        $security_code = Input::get('security_code');
        $newCompany = Input::get('newcompany');

        if($companyID == -1) {
            $company = Company::create(array('name' => $newCompany));
            $companyID = $company->id;
        }

        /*
         * Note:
         *
         *          Username field is never used.
         *          Security Code usage unsure?
         *
         * */


        $user = Rep::create(array(
            "name" => $name,
            "username" => "",
            "password" => $password,
            "email" => $email,
            "company" => $companyID,
            "address1" => $address1,
            "address2" => $address2,
            "address3" => $address3,
            "phone" => $phone,
            "fax" => $fax,
            "company_email" => $companyEmail,
            "security_code" => $security_code
        ));

        return Redirect::to('/sign-in')->with('success_message', 'Representative Registered');
    }


    //function to delete rep
    public function removeRep() {

        //refer to reps.blade.php for use
            //id is sent from ajax request
        $id = Input::get('id');

        //get the rep based on ID
        $Rep = Rep::find($id);

        //get associated customers
        $associatedCustomers = Customer::where('rep', $id);

        //get associated quotes
        //$associatedQuotes = Quote::where('rep_id', $id);






        /*

        //if there are associated quotes
        if($associatedQuotes->count() > 0){

            //assign them to admin. Sets the rep id of all quotes who are connected to the rep being deleted to 1, which is the rep id of the admin account
            DB::table("quotes")
                        ->where('RepID', $id)
                        ->update(['RepID' => 1]);


        }
        */

        //if there are associated customers
        if($associatedCustomers->count() > 0){

            //assign the rep id of these customers to the admin account as well.
            DB::table("customers")
                        ->where('rep', $id)
                        ->update(['rep' => 1]);



        }



        //delete rep
        $Rep->delete();



    }

    //function to see if rep has associated customers
    public function hasCustomers(){

        //get the ID from the ajax request for this rep [this is the id for the rep]
        $id = Input::get('id');
        //create bool var, initialized to false
        $hasCustomers = false;
        //get list of linked customers
        $linkedCustomers = Customer::where('rep',$id);
        //get length of customers linked
        $hasCustInt = $linkedCustomers->count();
        //change to true if they exist
        if($hasCustInt > 0) {
            $hasCustomers = true;
        }

        echo json_encode(array("hasCustomers" => $hasCustomers));
    }

    //for editing ones own profile. Uses same view as edit rep, but only allows you to load your own profile
    public function showProfile() {

        $id = Auth::user()->id;

        $rep = Rep::where('id','=', $id)->first();

        return View::make('rep_edit',array('rep'=> $rep, 'title' => "Edit Profile"));
    }

        //function for loading view to edit rep. Admin only
    public function editRep($id){

        //gets customer
        $rep = Rep::where('id', '=', $id)->first();


        return View::make('rep_edit', array('rep' => $rep, 'title' => "Edit Rep"));
    }
        //submits on post of edit rep form, admin only
   public function updateRep(){

       $repID = Input::get('repID');
       $address1 = Input::get('address1');
       $address2 = Input::get('address2');
       $address3 = Input::get('address3');
       $phone = Input::get('phone');
       $fax = Input::get('fax');
       $name = Input::get('name');
       $email = Input::get('email');
       $companyID = Input::get('company');
       $companyEmail = Input::get('companyEmail');
       $security_code = Input::get('securityCode');
       $newCompany = Input::get('newcompany');
       $password = Hash::make( Input::get('password'));

       //when new is selected, company has value -1, triggering this script which makes a new company object and assigns this reps company ID to link to it.
       if($companyID == -1) {
           $company = Company::create(array('name' => $newCompany));
           $companyID = $company->id;
       }

        //get rep object from db
       $rep = Rep::where('id', '=', $repID)->first();

        //update info
        $rep->id = $repID;
        $rep->address1 = $address1;
        $rep->address2 = $address2;
        $rep->address3 = $address3;
        $rep->phone = $phone;
        $rep->fax = $fax;
        $rep->name = $name;
        $rep->email = $email;
        $rep->password = $password;
        $rep->company = $companyID;
        $rep->company_email = $companyEmail;
        $rep->security_code = $security_code;


       //save
        $rep->save();

       //redirect
       return Redirect::to('/reps/')->with('success_message', "Rep $name has been updated.");



    }

    //FUNCTION NOT IN USE
    //similar in functionality to the edit rep, this feeds to a form for a rep to edit their own details, as opposed to being edited by the admin.
    public function updateProfile() {
        $address1 = Input::get('address1');
        $address2 = Input::get('address2');
        $address3 = Input::get('address3');
        $phone = Input::get('phone');
        $fax = Input::get('fax');
        $email = Input::get('email');
        $company = Input::get('company');
        $password = Input::get('password');

        $user = Rep::find(Auth::id())->first();

        $user->company = $company;
        $user->address1 = $address1;
        $user->address2 = $address2;
        $user->address3 = $address3;
        $user->phone = $phone;
        $user->fax = $fax;
        $user->email = $email;
        $user->password = $password;
        $user->save();


        return Redirect::to('/profile')->with('success_message', 'Your profile has been updated.'); 

    }

    public function showAll() {
        $reps = Rep::all();
        $customers = Customer::all();
        $companies = Company::all();

        return View::make('reps', array('reps' => $reps, 'customers' => $customers, 'companies' => $companies, 'title' => "Representative"));
    }

}
