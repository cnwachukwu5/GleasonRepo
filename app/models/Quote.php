 <?php

class Quote extends Eloquent {


	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'quotes';

    public $timestamps = false;

    protected $primaryKey = 'quotes_id';

	protected $guarded = array();

	/**
	* ID of this specific quote
	*
	* @var int
	*/
	protected $quotes_id;

	/**
	* Unique ID of quote with info on preparer as well
	*
	* @var int
	*/
	protected $QuoteID;

	/***
	*
     * Revision number. Goes up when quoteis edited
     *
	* @var int
	*/
	protected $revision;

	/**
	* Application type
	*
	* @var string
	*/
	protected $ProductLine;

	/**
	* Int of unique ID of customer
	*
	* @var int
	*/
	protected $CustomerID;


	/**
	* Timestamp on create
	*
	* @var int
	*/
	protected $QuoteDate;
    
    protected $ReelQty;

    protected $Subject;

    protected $ShowDiscount;

    protected $PkgID;

    protected $CableInd;

    protected $ExCabMoving;

    protected $ShowItem;

    protected $Notes;

    protected $RepID;

    protected $Status;

    protected $Metric;

    protected $pkgNote;

    protected $pdfFilepath;

    protected $pkeyRep;

    protected $pkeyCust;



    //test
    public function del(){

        return $this->delete();

    }



	public function parts() {
		return $this->hasMany('QuotePart');
	}

	public function customer() {
		return $this->hasOne('Customer', 'id', 'customer_id');
	}

	public function rep() {
		return $this->hasOne('Rep', 'id', 'rep_id');
	}


	public function __get($key)
	{
		return $this->attributes[$key];
	}

	public function __set($key, $value)
	{
		$this->attributes[$key] = $value;
	}

	public function __isset($key)
	{
		return isset($this->attributes[$key]);
	}

	public function __unset($key)
	{
		unset($this->attributes[$key]);
	}


}
