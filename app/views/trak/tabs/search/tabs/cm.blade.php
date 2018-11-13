<div class="container marginleft">
  <div class="col-lg-3">
    <h3>CM Reels to consider</h3>
    <div id='s-checkboxes' class="marginleft">
      <div class="form-group">
        <div class="checkbox">
          <label><input id="cm-none" type="checkbox" name="cm-checkboxes[]" value="none" checked onchange="clickNone()">None</label>
        </div>
      </div>
      <div class="form-group">
        <div class="checkbox">
          <label><input id="cm-any" type="checkbox" name="cm-checkboxes[]" value="any" onchange="anyClick()">Any</label>
        </div>
      </div>
      <div class="form-group">
        <div class="checkbox">
          <label><input id="cm14" type="checkbox" name="cm-checkboxes[]" value="14" onchange="add14opts()">CM14</label>
        </div>
      </div>
      <div class="form-group">
        <div class="checkbox">
          <label><input id="cm16" type="checkbox" name="cm-checkboxes[]" value="16" onchange="add1619opts()">CM16</label>
        </div>
      </div>
      <div class="form-group">
        <div class="checkbox">
          <label><input id="cm19" type="checkbox" name="cm-checkboxes[]" value="19" onchange="add1619opts()">CM19</label>
        </div>
      </div>

    </div>
  </div>
  <div id='s-inputs' class="col-lg-4">
    <h3>CM Reel Model Parameters</h3>
    <div class="marginleft">
      <div class="form-group">
        <label class="col-md-5 control-label">Spring Motor</label>
        <div class="col-sm-4">
          <select name="cm-springmotor" id="cm-springmotor" class="form-control">
            <option value="all">Pick one</option>

          </select>
        </div>
      </div>
      <div class="form-group">
        <label class="col-md-5 control-label">Wire Size Code</label>
        <div class="col-sm-3">
          <div class="input-group"><input type="text" name="cm-wire-size-code" id="cm-wire-size-code" class="form-control" value="Z10" />
          </div>
        </div>
      </div>



      <div class="form-group">
        <label class="col-md-5 control-label">Pretension Turn Range Min.</label>
        <div class="col-sm-3">
          <div class="input-group">
            <input type="text" name="cm-pretensmin" class="form-control" value="1" />
          </div>
        </div>
      </div>
      <div class="form-group">
        <label class="col-md-5 control-label">Pretension Turn Range Max.</label>
        <div class="col-sm-3">
          <div class="input-group">
            <input type="text" name="cm-pretensmax" class="form-control" value="9"/>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
var is1619checked = false;
var is14checked = false;
var anyclicked = false;
function clickNone(){
    var is1619checked = false;
    var is14checked = false;
    var anyclicked = false;
    $('#cm14').attr('checked', false);
    $('#cm16').attr('checked', false);
    $('#cm19').attr('checked', false);
    $('#cm-any').attr('checked', false);
    $("#opt-all").remove();
    $("#opt-a").remove();
    $("#opt-b").remove();
    $("#opt-price").remove();
    $("#opt-e").remove();
    $("#opt-f").remove();
    $("#opt-g").remove();
    $("#opt-h").remove();
    $("#opt-j").remove();
    $("#opt-k").remove();
    $("#opt-d").remove();

}
function add14opts(){
  addMotorOptions();
    if(anyclicked){
        anyclicked = false;
        $("#opt-all").remove();
        $("#opt-a").remove();
        $("#opt-b").remove();
        $("#opt-price").remove();
        $("#opt-e").remove();
        $("#opt-f").remove();
        $("#opt-g").remove();
        $("#opt-h").remove();
        $("#opt-j").remove();
        $("#opt-k").remove();
        $("#opt-d").remove();
    }
    if($("#cm14").is(":checked") && is14checked){
        return;
    }
      if($("#cm14").is(":checked") && !is14checked){
                is14checked = true;
                $('#cm-springmotor')
                        .find('option')
                        .end()
                        .append('<option value="all" selected="selected" id ="opt-all">all</option>'
                                +'<option value="a" id="opt-a">A</option>'
                                +'<option value="b" id="opt-b">B</option>'
                                +'<option value="price" id="opt-price">C</option>'
                                )
                        .val('all');
      }
      else{
        is14checked = false;
        $("#opt-all").remove();
        $("#opt-a").remove();
        $("#opt-b").remove();
        $("#opt-price").remove();

      }
}

function add1619opts(){
  addMotorOptions();

    if(anyclicked){
       anyclicked = false;
        $("#opt-all").remove();
        $("#opt-a").remove();
        $("#opt-b").remove();
        $("#opt-price").remove();
        $("#opt-e").remove();
        $("#opt-f").remove();
        $("#opt-g").remove();
        $("#opt-h").remove();
        $("#opt-j").remove();
        $("#opt-k").remove();
        $("#opt-d").remove();
    }
  if(($("#cm16").is(":checked") || $("#cm19").is(":checked")) && is1619checked){
    return;
  }

  if(($("#cm16").is(":checked") || $("#cm19").is(":checked")) && !is1619checked){
    is1619checked = true;
            $('#cm-springmotor')
                    .find('option')
                    .end()
                    .append(
                            '<option value="d" id="opt-d">D</option>'
                            +'<option value="e" id="opt-e">E</option>'
                            +'<option value="f" id="opt-f">F</option>'
                            +'<option value="g" id="opt-g">G</option>'
                            +'<option value="h" id="opt-h">H</option>'
                            +'<option value="j" id="opt-j">J</option>'
                            +'<option value="k" id="opt-k">K</option>'
                            )
                    .val('d');
  }
  else{
    is1619checked = false;
    $("#opt-e").remove();
    $("#opt-f").remove();
    $("#opt-g").remove();
    $("#opt-h").remove();
    $("#opt-j").remove();
    $("#opt-k").remove();
    $("#opt-d").remove();

  }

}
function addMotorOptions(){

      $('#cm-none').attr('checked', false);
      $('#cm-any').attr('checked', false);


}
function anyClick(){
        $('#cm-none').attr('checked', false);

        if(!anyclicked) {
            anyclicked = true;
            $('#cm-none').attr('checked', false);
            $('#cm14').attr('checked', false);
            $('#cm16').attr('checked', false);
            $('#cm19').attr('checked', false);
            $('#cm-springmotor')
                    .find('option')
                    .end()
                    .append('<option value="all" selected="selected" id ="opt-all">all</option>'
                            +'<option value="a" id="opt-a">A</option>'
                            +'<option value="b" id="opt-b">B</option>'
                            +'<option value="price" id="opt-price">C</option>'
                            +'<option value="d" id="opt-d">D</option>'
                            +'<option value="e" id="opt-e">E</option>'
                            +'<option value="f" id="opt-f">F</option>'
                            +'<option value="g" id="opt-g">G</option>'
                            +'<option value="h" id="opt-h">H</option>'
                            +'<option value="j" id="opt-j">J</option>'
                            +'<option value="k" id="opt-k">K</option>'
                    )
                    .val('d');


        }else{

            anyclicked = false;
            $("#opt-all").remove();
            $("#opt-a").remove();
            $("#opt-b").remove();
            $("#opt-price").remove();
            $("#opt-e").remove();
            $("#opt-f").remove();
            $("#opt-g").remove();
            $("#opt-h").remove();
            $("#opt-j").remove();
            $("#opt-k").remove();
            $("#opt-d").remove();
        }
    }

</script>
