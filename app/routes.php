<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('/', function() {
	return View::make('home');
});

Route::get('/notfinished', function() {
	return View::make('notfinished');
});

Route::get('/sign-in', function() {
	return View::make('signin');
});

Route::post('/sign-in', 'RepController@login');
Route::get('/sign-out', 'RepController@logout');
Route::get('/profile', 'RepController@showProfile');
Route::post('/profile', 'RepController@updateRep');

//These filters apply certain conditions to page load. Filters are found in filters.php

//these pages require login/authorization to load
Route::group(array('before' => 'auth'), function() {


    /*
     * Companues
     *
     * */

    //load companies page
    Route::get('/companies', 'CompanyController@showCompanies');

    Route::get('/companies/add', 'CompanyController@addCompanyView');

    Route::post('/companies/add', 'CompanyController@addCompany');

    /*
	 * Reps
	 */

    //routes for editing reps are located inside admin filter

    //display reps
	Route::get('/reps', 'RepController@showAll');

    //this route is triggered upon submission of the form on the edit rep page, updating the DB information and reloading the page
    //not located behind admin filter because the form that fires it is, and the function needs to be accessible for when the user is updating their own account under profile
    Route::post('/reps/update', 'RepController@updateRep');


    /*
     * Customers
     */

    //show customers
    Route::get('/customers', 'CustomerController@showAll');
    //get specific customer data. Not sure if used
	Route::get('/customers/get/{id}', function($id) {
		return Customer::where('id', '=', $id)->get();
	});
	    //edit page for customer record
	Route::get('/customers/edit/{id}','CustomerController@editCustomer');
    //this route is triggered upon submission of the form on the edit customer page, updating the DB information and reloading the page
    Route::post('/customers/update', 'CustomerController@updateCustomer');

	//makes view for add customer page
	Route::get('/customers/add', 'CustomerController@add');

	//adds new customer to database
	Route::post('/customers/add', 'CustomerController@addPost');


	Route::post('/customers/add/json', 'CustomerController@addJSON');


	Route::get('/customers/select', 'CustomerController@select');
	    //deletes customer
	Route::post('/customers/deletePost', 'CustomerController@deletePost');
	    //returns bool of whether customer has quotes associated
	Route::post('/customers/hasQuotes', 'CustomerController@hasQuotes');

	/*
	 * Parts
	 */

	Route::get('/parts', 'PartController@showAll');
	Route::get('/parts/add', 'PartController@add');
	Route::post('/parts/add', 'PartController@addPost');
	Route::get('/parts/get/{id}', function($id) {
		return Part::where('number', '=', $id)->get();
	});

	/*
	 * Quotes
	 */

    Route::get('/quotes', 'QuotesController@showAll');

    Route::get('quote/edit/{id}', 'QuotesController@editQuote');
    Route::get('quote/detail/{id}', 'QuotesController@detailView');

    Route::post('quote/update', 'QuotesController@updateQuote');


    Route::post('quotes/delete', 'QuotesController@deleteQuote');


    //with possible exception, the following functions are deprecated.
    Route::get('/manual', 'QuotesController@showManualForm');
    Route::post('/manual', 'QuotesController@postQuote');

    Route::get('/edit/{id}', 'QuotesController@showQuoteEditForm');


    Route::post('/edit/{id}', 'QuotesController@updateManual');


    Route::get('/quotes/{id}', 'QuotesController@viewQuote');
	/*
	 * Psckages
	 * */

  	Route::get('/cables', 'PackageController@showAll');
	Route::get('/cables/get/{type}/{AWG}/{conductors}', 'PackageController@getCable');
	Route::get('/cables/get/{pn}', 'PackageController@getCableWithPN');
	Route::get('/hoses/get/{insidediameter}', 'PackageController@getHose');

	Route::post('/package/add', 'PackageController@add');

	Route::post('/package/update', 'PackageController@update');
	Route::post('/package/remove', 'PackageController@remove');

	Route::get('/package/get/{packageid}', 'PackageController@getPackage');

	Route::get('/package/cable/get/{packageid}', 'PackageController@getCableInPackage');

	Route::get('/package/customer/select', 'ReelController@selectCustomer');

	Route::get('/package/customer/get/{customerid}', function($customerid) {
		return Package::where('customer_id', '=', $customerid)->get();
	});

	Route::get('/spare', 'QuotesController@showSpareForm');
	Route::post('/spare','QuotesController@postQuote');

	Route::get('/trak', 'TrakController@showAll');
	Route::get('/fest', 'FestoonController@showAll');
	Route::get('/cable/select','PackageController@cableSelect');
	Route::get('/hose/select','PackageController@hoseSelect');

	Route::post('/reel/rm/{fileName}', 'ReelController@rm');

	Route::get('/reel', 'ReelController@showAll');
	Route::post('/reel/results', 'ReelController@showResults');
    Route::get('/reel/returnResults', 'ReelController@returnSearchPage');

	Route::get('/reel/accessories', 'ReelController@accessories');
	Route::get('/reel/results', 'ReelController@showResults');

	Route::get('/reel/view', 'ReelController@viewCalcResults');
	Route::post('/reel/printQuote','ReelController@printQuote');

	Route::post('fest/results', 'FestoonController@showResults');
    
    Route::get('/checkPrice', 'ReelController@priceCheck');
    Route::get('getSpringCollector/{frameValue}/{reelType}', 'ReelController@getSpringsCollector');
    Route::get('getReelPrice/{frameValue}/{reelType}/{spring}/{geared}/{collectorVal}/{springWidth}/{hoseValue}/{reverse_rotate}/{harzard_duty}/{gearChoice}/{motorTMR}/{spoolType}/{spoolDiam}/{chainRatio}/{wireCode}', 'ReelController@lookupPrice');

    /*
     Prices & Price updates
     * */

    Route::get('/prices', 'PriceController@showPrices');
    Route::post('/prices/update', 'PriceController@updatePrice');

});

//This group blocks rep functions to be available to only the admin
Route::group(array('before' => 'admin'), function() {



        //edit page for customer record
    Route::get('/reps/edit/{id}','RepController@editRep');

    //to register new rep
    Route::get('/register', 'RepController@showRegister');
    Route::post('/register', 'RepController@addRep');

        //functions called by ajax on reps.blade

    //gets boolean of whether rep has customers or does not
    Route::post('/reps/hasCustomers', 'RepController@hasCustomers');
    //deletes the rep from the database
    Route::post('/reps/delete', 'RepController@removeRep');

    /*
  *
  * Companies
  *
  *          just a small controller and small view, easy peasy
     *       Company update and delete functions are in admin group
  */



    //updates company info
    Route::post('/companies/update', 'CompanyController@updateCompany');

    //called by json script to delete company
    Route::post('/companies/delete', 'CompanyController@deleteCompany');



});