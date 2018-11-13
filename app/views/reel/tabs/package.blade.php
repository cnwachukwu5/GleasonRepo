<div class="form-horizontal">
  <h3>Cables and Hoses</h3>
  <div>
    <strong>Select a package from the dropdown below or create another package.</strong>
    <br>
    <select id="packageSelect" name="package[]" class="form-control">
      <option value="-1">New</option>
    </select>
  </div>
  <div id="new">
    <div id="form-messages"></div>
    <!-- <form id="form-add" method="get" action="{{ url('/package/add') }}"> -->
      <br><br>
      <label for="packageName"><strong>What is the name for this package?</strong></label>
      <input type="text" name="packageName" id="packageName" value="Name" class="form-control" />
      <br><br>
      <a class="btn btn-primary btn-xs" data-toggle="modal" data-target="#modal" data-keyboard="false" data-backdrop="static" href="{{ url('/cable/select') }}" id="addCable">Add CABLE</a>
      <a class="btn btn-primary btn-xs marginleft" data-toggle="modal" data-target="#modal" data-keyboard="false" data-backdrop="static" href="{{ url('/hose/select') }}" id="addHose">Add HOSE</a>
      <table id="cables-table" class="table table-striped table-responsive">
        <thead>
          <tr>
            <th>Quantity</th>
            <th>Style</th>
            <th>Type</th>
            <th id="awg">AWG</th>
            <th>Cond</th>
            <th>Volts</th>
            <th id="psi">PSI</th>
            <th>ID/Width</th>
            <th>OD/Thickness</th>
            <th>Bend Radius</th>
            <th id="wgt">Weight</th>
            <th id="cost">$/Ft</th>
            <th>PN</th>
          </tr>
        </thead>
        <tbody id="cableContents">
        </tbody>
      </table>
      <!-- <input type="submit" class="btn btn-primary"\> -->

      <button type="button" class="btn btn-primary">Create This Package</button>

    <!-- </form> -->
  </div>
  <div id="existing" style="display: none;">
    <!-- <form method="post" id="form-save" action="{{ url('/package/update') }}"> -->
      <br>
      <!-- <a class="btn btn-primary btn-xs" id="rename">Rename Package</a> -->
      <br><br>
      <p>These are the cables/hoses in this package.</p>
      <a class="btn btn-primary btn-xs" data-toggle="modal" data-target="#modal" href="{{ url('/cable/select') }}" data-keyboard="false" data-backdrop="static" id="addCable-existing">Add CABLE</a>
      <a class="btn btn-primary btn-xs marginleft" data-toggle="modal" data-target="#modal" href="{{ url('/hose/select') }}" data-keyboard="false" data-backdrop="static" id="addHose-existing">Add HOSE</a>
      <table id="cables-table-existing" class="table table-striped table-responsive">
        <thead>
          <tr>
            <th>Quantity</th>
            <th>Style</th>
            <th>Type</th>
            <th>AWG</th>
            <th>Cond</th>
            <th>Volts</th>
            <th>PSI</th>
            <th>ID/Width</th>
            <th>OD/Thickness</th>
            <th>Bend Radius</th>
            <th>Weight</th>
            <th>$/Ft</th>
            <th>PN</th>
          </tr>
          </thead>
        {{--why is the id set to "why"--}}
        <tbody id="why">
        </tbody>
      </table>
      <input id="packageid" hidden name="packageid" />
      <!-- <input type="submit" class="btn btn-primary" value="Save"\> -->
      <button type="button" class="btn btn-primary">Save</button>
    <!-- </form> -->
    <br><br>
    <div id="remove">
    <!-- <form method="post" id="form-remove" action="{{ url('/package/remove') }}"> -->

      <input id="packageidForDelete" hidden name="packageid" />

      <button type="button" class="btn btn-primary">Delete This Package</button>
    <!-- </form> -->
    </div>
  </div>
</div>

<script type="text/javascript">

  var pnx;
  var typex;
  var vx;
  var condx;
  var awgx;
  var qtyx;
  var cableSet = false;
  var packageid;
  var existingPackage = false;
  var packageAlreadyAdded = false;

  var selValue = $('input[name=measureUnit]:checked').val();
  var metricDefault = getMetricValue(selValue);


  function addItem(array){
    console.log("Adding array");
    $("#addCable-existing").attr("disabled",true);
    $("#addHose-existing").attr("disabled",true);
    $("#addCable").attr("disabled",true);
    $("#addHose").attr("disabled",true);
    var qty = array[0];
    var pn = array[array.length-1];
    var style = array[1];
    console.log(array[array.length]);
     // console.log(array[array.length-1]);
    //if this is an existing package...

    if(existingPackage){
      if(!packageAlreadyAdded) {
        packageAlreadyAdded = true;
        for (var i = 0; i < array.length; i++) {
            console.log(array[i]);
            if(i !== 12 && i !== 13 && i !== 14 && i !== 15){
                $("#cables-table-existing").find('tbody').append($("<td/>", {id: "identifier" + i}).append(array[i]));
            }
          $("#cables-table-existing").find('tbody').append($('<input hidden name="identifier' + i + '" value="' + array[i] + '"/>'));
        }
        //If the style is cable, then add an edit button that will open the cable modal.
        if (style == "Cable") {
          $("#cables-table-existing").find('tbody').append($('<a id="removeItem" class="btn btn-primary btn-xs" onclick="removeItem()"><span class="glyphicon glyphicon-remove"></span></a><a class="btn btn-primary btn-xs" data-toggle="modal" onclick="editedItem()" data-target="#modal" href="{{ url('/cable/select') }}" id="editItem-existing" class="btn btn-primary btn-xs"><span class="glyphicon glyphicon-pencil"></span></a>'));
        }
        else {
          //Otherwise open up the hose modal.
          $("#cables-table-existing").find('tbody').append($('<a id="removeItem" class="btn btn-primary btn-xs" onclick="removeItem()"><span class="glyphicon glyphicon-remove"></span></a><a class="btn btn-primary btn-xs" data-toggle="modal" onclick="editedItem()" data-target="#modal" href="{{ url('/hose/select') }}" id="editItem-existing" class="btn btn-primary btn-xs"><span class="glyphicon glyphicon-pencil"></span></a>'));
        }
      }
       $("#cables-table-existing").find('tbody').append($('<input id="inputQuantity" hidden name="quantity" value="' + qty + '"/>')).append($('<input id="inputPN" hidden name="pn" value="' + removeGR(pn) + '"/>')).append($('<input hidden name="customerid" value="' + customerid + '"/>'));
    }
    else{
      //If not, then put it in the cables-table table.
      for(var i = 0; i < array.length; i++)
      {
          console.log(array[i]);
        $("#cables-table").find('tbody').append($("<td/>", {id:"identifier"+i}).append(array[i]));

        $("#cables-table").find('tbody').append($('<input hidden name="identifier'+ i +'" value="'+ array[i] +'""/>'));
       }
       //If the style is cable, then add an edit button that will open the cable modal.
       if(style == "Cable") {
         $("#cables-table").find('tbody').append($('<a id="removeItem" class="btn btn-primary btn-xs"><span class="glyphicon glyphicon-remove" onclick="removeItem()"></span></a><a class="btn btn-primary btn-xs" data-toggle="modal" onclick="editedItem()" data-target="#modal" href="{{ url('/cable/select#partnumber=pn') }}" id="editItem" class="btn btn-primary btn-xs"><span class="glyphicon glyphicon-pencil"></span></a>'));
       }
       else {
         //Otherwise open up the hose modal.
         $("#cables-table").find('tbody').append($('<a id="removeItem" class="btn btn-primary btn-xs"><span class="glyphicon glyphicon-remove" onclick="removeItem()"></span></a><a class="btn btn-primary btn-xs" data-toggle="modal" onclick="editedItem()" data-target="#modal" href="{{ url('/hose/select#partnumber=pn') }}" id="editItem" class="btn btn-primary btn-xs"><span class="glyphicon glyphicon-pencil"></span></a>'));
       }

       $("#cables-table").find('tbody').append($('<input hidden id="inputQuantity" name="quantity" value="' + qty + '"/>')).append($('<input id="inputPN" hidden name="pn" value="' + removeGR(pn) + '"/>')).append($('<input hidden name="customerid" value="' + customerid + '"/>'));
    }

    cableSet = true;
    showSearchCriteria();
  }
  function editedItem(){
      packageAlreadyAdded = false;
  }

  //modified the name of this function
  function removeItem(){
    $("td").remove();
    $("#removeItem").remove();
    $("#editItem").remove();
    $("#removeItem-existing").remove();
    $("#editItem-existing").remove();
    $("#inputQuantity").remove();
    $("#inputPN").remove();
    $("#addCable-existing").attr("disabled",false);
    $("#addHose-existing").attr("disabled",false);
    $("#addCable").attr("disabled",false);
    $("#addHose").attr("disabled",false);
    cableSet = false;
    hideSearchCriteria();
//    for(i=0;i<13;i++){
//      console.log("#identifier"+i);
//      $("#identifier"+i).remove();
//    }
    $("#cableContents").remove();
    $("#why").remove();

    packageAlreadyAdded = false;
    $('#cables-table').append("<tbody id=\"cableContents\"></tbody>");
    $('#cables-table-existing').append("<tbody id=\"why\"></tbody>");

  }


  $('#packageSelect').on('change', function() {
    removeItem();
    changePackage($('#packageSelect').val());
  });

  function changePackage(pid) {

    console.log("package: " + pid);

    if(pid === -1)
    {
      $("#new").show();
      $("#existing").hide();
      existingPackage = false;
    }
    else
    {
      $("#new").hide();
      $("#existing").show();
      $('#packageidForDelete').val(pid);
      existingPackage = true;
    }

    //Remove the items in the table
    packageAlreadyAdded = false;
    removeItem();


    //load the package
    //console.log($('#packageSelect').val());
    packageid = pid;
    var qty, pn, style, type;
    //If the package is not new...

    if(packageid !== -1) {
      $('#packageid').val(packageid);
      $.getJSON("{{ url('/package/get').'/' }}" + packageid, function(data) {
        console.log("Data: " + data);
        qty = data[0].quantity;
        pn = appendGR(data[0].pn);
        style = data[0].style;
        type = data[0].type;
        price = data[0].price;
        console.log("Package: " + packageid);

        console.log("--------------------------------------------");

        $.getJSON("{{ url('/package/cable/get').'/' }}" + packageid, function(data) {
          //console.log("package data" + data[0]);
            //console.log("package data below " + data[0].price);

            //console.log("Data: " + data[0].awg);
          if(pn === "Special Part" || style.indexOf("Dual Hose") !== -1) {

            var awg = data[0].awg;
            var cond = data[0].cond;
            var volts = data[0].volts;
            var psi = data[0].psi;
            var id = data[0].idiameter;
            var od = data[0].odiameter;
            var mbr = data[0].mbr;
            var weight = data[0].wgt;
            var price = data[0].reel_price;
            var installFt = data[0].INSTL_FT;
            var CableID = data[0].ID;
            var INSTL_FIX = data[0].INSTL_FIX;
            //console.log("package data below " + data[0].INSTL_FT);
            //qtyx = qty;
            pnx = removeGR(pn);
            var array = [qty, style, type, awg, cond, volts, psi, id, od, mbr, weight, price, installFt, packageid, CableID, INSTL_FIX, pn];
              //console.log("package id below " + array[13]);
              //console.log("package data below " + data[0].awg);
            addItem(array);
            changeTabs();
            changeApplication();
            //changeCollectorCode(cond);
          }
          else {

            var awg = data[0].AWG;
            var cond = data[0].COND;
            var volts = data[0].VOLTS;
            var psi = data[0].PSI;
            var id = data[0].ID;
            var od = data[0].OD;
            var mbr = calcBend(data[0].OD);
            var weight = data[0].WGT;
            var price = data[0].REEL_PRICE;
            var installFt = data[0].INSTL_FT;
              var CableID = data[0].ID;
              var INSTL_FIX = data[0].INSTL_FIX;
              console.log("package data below " + data[0].ID);
            if(price == -0.01){
            $.getJSON("{{ url('/package/get').'/'}}" + packageid, function(data){
              price = data[0].price;

              qtyx = qty;
              pnx = removeGR(pn);
              var array = [qty, style, type, awg, cond, volts, psi, id, od, mbr, weight, price, installFt, packageid, CableID, INSTL_FIX, pn];
              addItem(array);
              changeTabs();
              changeApplication();
            })}
            else{
            qtyx = qty;
            pnx = removeGR(pn);
            var array = [qty, style, type, awg, cond, volts, psi, id, od, mbr, weight, price, installFt, packageid, CableID, INSTL_FIX, pn];}
            addItem(array);
            changeTabs();
            changeApplication();

          }
          changeCollectorCode(cond, awg);
          switchShoReel();

        });



      });


    }
  }

  $(function(){
    $(document).on("click", "#submitItem", function () {
      var qty = $('#qty').val();
      var style = $('#style').val();
      var awg = $('#awg').val();

      var cond = $('#conductors').val();
      var volts = $('#volts').val();
      var psi = $('#psi').val();
      var id = $('#insidediameter').val();
      var od = $('#outsidediameter').val();
      var mbr = $('#minbendradius').val();
      var weight = $('#weight').val();
      var price = $('#price').val();
      var pn = appendGR($('#partnumber').val());
      var installFt = "";
      var packageid = "";
      var CableID = "";
      var INSTL_FIX = "";
        var type = $('#type').val();
        if(type === 'OTHER'){
            type = $('#typeDescription').val();
        }
      var array = [qty, style, type, awg, cond, volts, psi, id, od, mbr, weight, price, installFt, packageid, CableID, INSTL_FIX, pn];
      //alert("removing");
      removeItem();
      //alert("adding");
      //existingPackage = false;
      addItem(array);
    });
  });

  $(function() {
    var add = $('#new button');
    var save = $('#existing button');
    var remove = $('#remove button');

    $(add).on('click', function() { //Creating new package
      if($('input#inputPN').val() !== "") {
        //Manual serialization of data
        var formData = new Array();
        $('#new input').each(function (index) {
          formData.push(this.name + '=' + this.value);
        });

        serializedData = formData.join('&');

        var action = "{{ url('/package/add') }}";
        $.post(action, serializedData)
                .done(function (pid) {
                  changePackage(pid);
                  addOptionToPackageSelect(pid, $('#packageName').val());
                  changeTabs();
                  changeApplication();
                  $('#packageName').val("");
                  alert("Package successfully created.");
                })
        .fail(function(error) {
          handleError(error);
        });
      }
//      else if($('input#inputPN').val() == "Special Part"){
//        alert("Packages with special parts cannot be created at this time, please use existing parts");
//      }
    });


    $(save).on('click', function() {
      var formData = new Array();
      $('#existing input').each(function(index) {
        formData.push(this.name+'='+this.value);
      });
      serializedData = formData.join('&');

      var action = "{{ url('/package/update') }}";
      $.post( action, serializedData )
      .done(function(pid) {
        console.log("Sending data....");
        console.log(formData);
        console.log(serializedData);
        console.log("Ajax completed, packageid: "+pid);
        console.log("Ajax completed, packageid: "+pid);
        //alert("Package successfully saved.");
        changeTabs();
        changeApplication();
      })
      .fail(function(error) {
        handleError(error);
      });
    });

    $(remove).on('click', function() {
      var formData = new Array();
      $('#remove input').each(function(index) {
        formData.push(this.name+'='+this.value);
      });

      serializedData = formData.join('&');

      var action = "{{ url('/package/remove') }}";
      $.post(action, serializedData)
      .done(function(pid) {
        //removeOptionFromPackageSelect();
        alert("Package successfully deleted.");
        changePackage("-1");
        updatePackageSelect("{{ url() }}", customerid);
      })
      .fail(function(error) {
        handleError(error);
      });
    });
  });
</script>
