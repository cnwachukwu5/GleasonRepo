<div class="container marginleft">
    <div class="col-lg-3">
        <h3>HM Reels to consider</h3>
        <div id='hm-checkboxes' class="marginleft">
            <div class="form-group">
                <div class="checkbox">
                    <label><input type="checkbox" name="hm-checkboxes[]" value="none" checked>None</label>
                </div>
            </div>
            <div class="form-group">
                <div class="checkbox">
                    <label><input type="checkbox" name="hm-checkboxes[]" value="any">Any</label>
                </div>
            </div>
            <div class="form-group">
                <div class="checkbox">
                    <label><input id="hm14" type="checkbox" name="hm-checkboxes[]" value="14">HM14</label>
                </div>
            </div>
            <div class="form-group">
                <div class="checkbox">
                    <label><input id="hm16" type="checkbox" name="hm-checkboxes[]" value="16">HM16</label>
                </div>
            </div>
            <div class="form-group">
                <div class="checkbox">
                    <label><input id="hm19" type="checkbox" name="hm-checkboxes[]" value="19">HM19</label>
                </div>
            </div>
        </div>
    </div>
    <div id='u-inputs' class="col-lg-4">
        <h3>HM Reel Model Parameters</h3>
        <div class="marginleft">
            <div class="form-group">
                <label class="col-md-5 control-label">Spring Motor</label>
                <div class="col-sm-4">
                    <select name="hm-springsize" id="hm-springsize" class="form-control">
                        <option value="all" id="opt-all">All</option>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-5 control-label">Hose Code</label>
                <div class="col-sm-3">
                    <div class="input-group"><input type="text" name="hm-collectorcode" id="hm-collectorcode" class="form-control" />
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-5 control-label">Pretension Turn Range Min.</label>
                <div class="col-sm-3">
                    <div class="input-group">
                        <input type="text" name="hm-pretensmin" class="form-control" value="1" />
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-5 control-label">Pretension Turn Range Max.</label>
                <div class="col-sm-3">
                    <div class="input-group">
                        <input type="text" id="hm-pretensmax" name="hm-pretensmax" class="form-control" value="9"/>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>

    $('#hm-checkboxes :checkbox').change(function() {

        if(this.value == 'any'){
            removeOptions();
            springMotorAll();
        }
        if(this.value == 'none'){
            removeOptions();
            $('#hm-springsize')
                .find('option')
                .end()
                .append('<option value="all" selected="selected" id ="opt-all">All</option>').val('all');
        }
        if(this.value == 'none' || this.value == 'any') {
            var value = this.value;

            $('#hm-checkboxes :checkbox').each(function() {
                if(value != this.value) {
                    $(this).attr('checked', false);
                }
            });
        }
        else {
            var highest = null;
            $('#hm-checkboxes :checkbox').each(function() {
                if(this.checked) {
                    highest = this;
                }
            });

            $("#hm-checkboxes :checkbox[value='any']").attr('checked', false);
            $("#hm-checkboxes :checkbox[value='none']").attr('checked', false);


            if(highest == null) {
            }
            else {
                switch(highest.value) {
                    case '14':
                        removeOptions();
                        springMotorHM14();
                        break;
                    case '16':
                        removeOptions();
                        springMotorHM1619();
                        break;
                    case '19':
                        removeOptions();
                        springMotorHM1619();
                        break;
                }
            }
        }
    });

    function springMotorAll(){
        removeOptions();
        $('#hm-springsize')
            .find('option')
            .end()
            .append('<option value="all" selected="selected" id ="opt-all">All</option>'
                + '<option value="1" id="opt-1">1</option>'
                + '<option value="2" id="opt-2">2</option>'
                + '<option value="3" id="opt-3">3</option>'
                + '<option value="4" id="opt-4">4</option>'
                + '<option value="5" id="opt-5">5</option>'
                + '<option value="7" id="opt-7">7</option>'
                + '<option value="8" id="opt-8">8</option>'
            )
            .val('all');
    }

    function springMotorHM14(){
        removeOptions();
        $('#hm-springsize')
            .find('option')
            .end()
            .append('<option value="all" selected="selected" id ="opt-all">All</option>'
                + '<option value="1" id="opt-1">1</option>'
                + '<option value="2" id="opt-2">2</option>'
                + '<option value="3" id="opt-3">3</option>'
            )
            .val('all');

        springMotorHM14ANDHM16ORHM19();

    }

    function springMotorHM1619(){
        removeOptions();
        $('#hm-springsize')
            .find('option')
            .end()
            .append('<option value="all" selected="selected" id ="opt-all">All</option>'
                + '<option value="4" id="opt-4">4</option>'
                + '<option value="5" id="opt-5">5</option>'
                + '<option value="7" id="opt-7">7</option>'
                + '<option value="8" id="opt-8">8</option>'
            )
            .val('all');

        springMotorHM14ANDHM16ORHM19();
    }

    function springMotorHM14ANDHM16ORHM19(){
        if(document.getElementById("hm14").checked && (document.getElementById("hm16").checked || document.getElementById("hm19").checked)){
            springMotorAll();
        }
    }

    function removeOptions(){
        $("#opt-none").remove();
        $("#opt-all").remove();
        $("#opt-1").remove();
        $("#opt-2").remove();
        $("#opt-3").remove();
        $("#opt-4").remove();
        $("#opt-5").remove();
        $("#opt-7").remove();
        $("#opt-8").remove();
    }
</script>