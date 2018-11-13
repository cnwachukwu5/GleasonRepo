<div class="container marginleft">
    <div class="col-lg-3">
        <h3>U Reels to consider</h3>
        <div id='uh-checkboxes' class="marginleft">
            <div class="form-group">
                <div class="checkbox">
                    <label><input type="checkbox" name="uh-checkboxes[]" value="none" checked>None</label>
                </div>
            </div>
            <div class="form-group">
                <div class="checkbox">
                    <label><input type="checkbox" name="uh-checkboxes[]" value="any">Any</label>
                </div>
            </div>
            <div class="form-group">
                <div class="checkbox">
                    <label><input type="checkbox" name="uh-checkboxes[]" value="18">UH18</label>
                </div>
            </div>
            <div class="form-group">
                <div class="checkbox">
                    <label><input type="checkbox" name="uh-checkboxes[]" value="21">UH21</label>
                </div>
            </div>
            <div class="form-group">
                <div class="checkbox">
                    <label><input type="checkbox" name="uh-checkboxes[]" value="24">UH24</label>
                </div>
            </div>
            <div class="form-group">
                <div class="checkbox">
                    <label><input type="checkbox" name="uh-checkboxes[]" value="28">UH28</label>
                </div>
            </div>
            <div class="form-group">
                <div class="checkbox">
                    <label><input type="checkbox" name="uh-checkboxes[]" value="32">UH32</label>
                </div>
            </div>
        </div>
    </div>
    <div id='uh-inputs' class="col-lg-4">
        <h3>U Reel Model Parameters</h3>
        <div class="marginleft">
            <div class="form-group">
                <label class="col-md-5 control-label">Spring Size</label>
                <div class="col-sm-4">
                    <select name="uh-springsize" class="form-control">
                        <option value="all">All</option>
                        <option value="351">351</option>
                        <option value="621">621</option>
                        <option value="622">622</option>
                        <option value="62X">62X</option>
                        <option value="751">751</option>
                        <option value="752">752</option>
                        <option value="75X">75X</option>
                        <option value="801">801</option>
                        <option value="802">802</option>
                        <option value="80X">80X</option>
                        <option value="1001">1001</option>
                        <option value="1002">1002</option>
                        <option value="100X">100X</option>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-5 control-label">Hose Code</label>
                <div class="col-sm-3">
                    <div class="input-group"><input type="text" name="uh-collectorcode" id="uh-collectorcode" class="form-control" value="" />
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-5 control-label">Drum Diameter Range Min.</label>
                <div class="col-md-3">
                    <div class="input-group">
                        <input type="text" id="uh-drummin" name="uh-drummin" class="form-control" value="10" />
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-5 control-label">Drum Diameter Range Max.</label>
                <div class="col-sm-3">
                    <div class="input-group">
                        <input type="text" name="uh-drummax" id="uh-drummax" class="form-control" value="26" />
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-5 control-label">Gear Ratio</label>
                <div class="col-sm-5">
                    <select class="form-control" name="uh-gearratio" id="uh-gearratio">
                        <option value="none" id="opt-none" class="active">None</option>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-5 control-label">Pretension Turn Range Min.</label>
                <div class="col-sm-3">
                    <div class="input-group">
                        <input type="text" name="uh-pretensmin" class="form-control" value="1" />
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-5 control-label">Pretension Turn Range Max.</label>
                <div class="col-sm-3">
                    <div class="input-group">
                        <input type="text" id="uh-pretensmax" name="uh-pretensmax" class="form-control" value="6"/>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-5 control-label">Spool Width </label>
                <div class="col-sm-5">
                    <div class="input-group">
                        <select class="form-control" name="uh-spoolwidth" id="uh-spoolwidth">
                            <option value="6" class="active">06</option>
                            <option value="8">08</option>
                            <option value="10">10</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $('#uh-checkboxes :checkbox').change(function() {

        if(this.value == 'any'){
            removeOption();
            addGearRatio();
        }
        if(this.value == 'none'){
            $("#uh-drummax").val(26);
            removeOption();
            allAndNone();
        }
        if(this.value == 'none' || this.value == 'any') {
            var value = this.value;

            $("#uh-drummax").val(26);

            $('#uh-checkboxes :checkbox').each(function() {
                if(value != this.value) {
                    $(this).attr('checked', false);
                }
            });
        }
        else {
            var highest = null;
            $('#uh-checkboxes :checkbox').each(function() {
                if(this.checked) {
                    highest = this;
                }
            });

            $("#uh-checkboxes :checkbox[value='any']").attr('checked', false);
            $("#uh-checkboxes :checkbox[value='none']").attr('checked', false);


            if(highest == null) {
                $("#uh-drummax").val('');
            }
            else {
                switch(highest.value) {
                    case '18':
                        $("#uh-drummax").val(14);
                        removeOption();
                        allAndNone();
                        break;
                    case '21':
                        $("#uh-drummax").val(16);
                        removeOption();
                        allAndNone();
                        break;
                    case '24':
                        $("#uh-drummax").val(18);
                        removeOption();
                        addGearRatio();
                        break;
                    case '28':
                        $("#uh-drummax").val(22);
                        removeOption();
                        addGearRatio();
                        break;
                    case '32':
                    default:
                        $("#uh-drummax").val(26);
                        removeOption();
                        addGearRatio();
                        break;
                }
            }
        }
    });

    function removeOption(){
        $("#opt-none").remove();
        $("#opt-all").remove();
        $("#opt-a").remove();
        $("#opt-b").remove();
        $("#opt-price").remove();
        $("#opt-d").remove();
        $("#opt-e").remove();
        $("#opt-f").remove();
    }
    function addGearRatio(){
        $('#uh-gearratio')
            .find('option')
            .end()
            .append('<option value="all" selected="selected" id ="opt-all">All</option>'
                + '<option value="a" id="opt-a">A (gr: 1.50)</option>'
                + '<option value="b" id="opt-b">B (gr: 2.00)</option>'
                + '<option value="price" id="opt-price">C (gr: 2.50)</option>'
                + '<option value="d" id="opt-d">D (gr: 3.00)</option>'
                + '<option value="e" id="opt-e">E (gr: 3.33)</option>'
                + '<option value="f" id="opt-f">F (gr: 4.00)</option>'
            )
            .val('all');
    }
    function allAndNone(){
        removeOption();
        $('#uh-gearratio')
            .find('option')
            .end()
            .append('<option value="all" selected="selected" id ="opt-all">All</option>'
                + '<option value="a" id="opt-none">None</option>').val('all');
    }
</script>