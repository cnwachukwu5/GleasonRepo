@extends('layouts.modal')

@section('modal-title')
Select Cable
@stop

@section('modal-content')
<div class="table-responsive">
    <form id="cust-form" method = "post" action = "{{ url('/customers/add') }}" class="form-horizontal">
      <fieldset>
      <h3>Please enter the HOSE information for this item.</h4>
        <div class="form-group">
            <label class="col-sm-2 control-label">Quantity</label>
            <div class="col-sm-3">
              <div class="input-group"><input type="text" name="qty" value="1"class="form-control" /></div>
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-2 control-label">Hose Contents</label>
            <div class="col-sm-3">
              <div class="input-group"><input type="text" name="brand" class="form-control" /></div>
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-2 control-label">Hose Inside Diameter</label>
            <div class="col-sm-3">
              <div class="input-group"><input type="text" name="mm2" class="form-control" />
                <span class="input-group-addon">mm</span></div>
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-2 control-label">Hose Pressure</label>
            <div class="col-sm-3">
              <div class="input-group"><input type="text" name="conductors" class="form-control" />
                <span class="input-group-addon">Bars</span></div>
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-2 control-label">Outside Diameter</label>
            <div class="col-sm-3">
              <div class="input-group"><input type="text" name="outside diameter" class="form-control" />
              <span class="input-group-addon">mm</span></div>
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-2 control-label">Bend Radius</label>
            <div class="col-sm-3">
              <div class="input-group"><input type="text" name="minbendradius" class="form-control" />
              <span class="input-group-addon">mm</span></div>
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-2 control-label">Hose Weight (w/contents)</label>
            <div class="col-sm-3">
              <div class="input-group"><input type="text" name="weight" class="form-control" />
              <span class="input-group-addon">kg/km</span></div>
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-2 control-label">Hose Price</label>
            <div class="col-sm-3">
              <div class="input-group"><input type="text" name="price" class="form-control" />
              <span class="input-group-addon">per meter</span></div>
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-2 control-label">Part Number</label>
            <div class="col-sm-3">
              <div class="input-group"><input type="text" name="partnumber" class="form-control" value="Special Part"/></div>

            </div>
        </div>
      </fieldset>
    </form>
</div>
@stop

@section('modal-footer')
  <button type="button" class="btn btn-default" data-dismiss="modal">Submit</button>
  <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
@stop
