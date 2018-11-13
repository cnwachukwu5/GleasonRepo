<div class="container marginleft">
    <div class="col-lg-3">
        <h3>U Reels to consider</h3>
        <div id='u-checkboxes' class="marginleft">
            <div class="form-group">
                <div class="checkbox">
                    <label><input type="checkbox" name="u-checkboxes[]" value="none" checked>None</label>
                </div>
            </div>
            <div class="form-group">
                <div class="checkbox">
                    <label><input type="checkbox" name="u-checkboxes[]" value="any">Any</label>
                </div>
            </div>
            <div class="form-group">
                <div class="checkbox">
                    <label><input type="checkbox" name="u-checkboxes[]" value="18">U18</label>
                </div>
            </div>
            <div class="form-group">
                <div class="checkbox">
                    <label><input type="checkbox" name="u-checkboxes[]" value="21">U21</label>
                </div>
            </div>
            <div class="form-group">
                <div class="checkbox">
                    <label><input type="checkbox" name="u-checkboxes[]" value="24">U24</label>
                </div>
            </div>
            <div class="form-group">
                <div class="checkbox">
                    <label><input type="checkbox" name="u-checkboxes[]" value="28">U28</label>
                </div>
            </div>
            <div class="form-group">
                <div class="checkbox">
                    <label><input type="checkbox" name="u-checkboxes[]" value="32">U32</label>
                </div>
            </div>
        </div>
    </div>
    <div id='u-inputs' class="col-lg-4">
        <h3>U Reel Model Parameters</h3>
        <div class="marginleft">
            <div class="form-group">
                <label class="col-md-5 control-label">Spring Size</label>
                <div class="col-sm-4">
                    <select name="u-springsize" class="form-control">
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
                <label class="col-md-5 control-label">Collector Code</label>
                <div class="col-sm-3">
                    <div class="input-group"><input type="text" name="u-collectorcode" id="u-collectorcode" class="form-control" />
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-5 control-label">Drum Diameter Range Min.</label>
                <div class="col-md-3">
                    <div class="input-group">
                        <input type="text" name="u-drummin" class="form-control" value="10" />
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-5 control-label">Drum Diameter Range Max.</label>
                <div class="col-sm-3">
                    <div class="input-group">
                        <input type="text" name="u-drummax" id="u-drummax" class="form-control" value="26" />
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-5 control-label">Gear Ratio</label>
                <div class="col-sm-5">
                    <select class="form-control" name="u-gearratio" id="u-gearratio">
                        <option value="none" id="opt-none" class="active">None</option>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-5 control-label">Pretension Turn Range Min.</label>
                <div class="col-sm-3">
                    <div class="input-group">
                        <input type="text" name="u-pretensmin" class="form-control" value="1" />
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-5 control-label">Pretension Turn Range Max.</label>
                <div class="col-sm-3">
                    <div class="input-group">
                        <input type="text" name="u-pretensmax" class="form-control" value="6"/>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-5 control-label">Spool Width</label>
                <div class="col-sm-5">
                    <select class="form-control" name="u-spoolwidth">
                        <option value="all" class="6">06</option>
                        <option value="all" class="8">08</option>
                        <option value="all" class="10">10</option>
                    </select>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $('#u-checkboxes :checkbox').change(function() {

        if(this.value == 'any'){
            removeOption1();
            addGearRatio1();
        }
        if(this.value == 'none'){
            allAndNone1();
        }
        if(this.value == 'none' || this.value == 'any') {
            var value = this.value;

            $("#u-drummax").val(26);

            $('#u-checkboxes :checkbox').each(function() {
                if(value != this.value) {
                    $(this).attr('checked', false);

                }
            });
        }
        else {
            var highest = null;
            $('#u-checkboxes :checkbox').each(function() {
                if(this.checked) {
                    highest = this;
                }
            });

            $("#u-checkboxes :checkbox[value='any']").attr('checked', false);
            $("#u-checkboxes :checkbox[value='none']").attr('checked', false);


            if(highest == null) {
                $("#u-drummax").val('');
            }
            else {
                switch(highest.value) {
                    case '18':
                        $("#u-drummax").val(14);
                        removeOption1();
                        allAndNone1();
                        break;
                    case '21':
                        $("#u-drummax").val(16);
                        removeOption1();
                        allAndNone1();
                        break;
                    case '24':
                        $("#u-drummax").val(18);
                        addGearRatio1();
                        break;
                    case '28':
                        $("#u-drummax").val(22);
                        addGearRatio1();
                        break;
                    case '32':
                    default:
                        $("#u-drummax").val(26);
                        addGearRatio1();
                        break;

                }
            }
        }
    });
    function removeOption1(){
        $("#opt-none").remove();
        $("#opt-all").remove();
        $("#opt-a").remove();
        $("#opt-b").remove();
        $("#opt-price").remove();
        $("#opt-d").remove();
        $("#opt-e").remove();
        $("#opt-f").remove();
    }
    function addGearRatio1(){
        removeOption1();
        $('#u-gearratio')
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
    function allAndNone1(){
        removeOption1();
        $('#u-gearratio')
            .find('option')
            .end()
            .append('<option value="all" selected="selected" id ="opt-all">All</option>'
                + '<option value="a" id="opt-none">None</option>').val('all');
    }

</script>