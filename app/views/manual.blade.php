@extends('layouts.master')

@section('page-title')
    @if (!isset($type) || $type == "manual")
        Manual Quote
    @else
        Spare Parts
    @endif
@stop

@section('content')
    @include('modal')
    <form method="post" action="{{ Request::url() }}" class="form-horizontal">
        <fieldset>

            <table id="parts-table" class="table table-striped table-responsive">
                <thead>
                    <tr>
                        <th>Quantity</th>
                        <th>Part Number</th>
                        <th>Description</th>
                        <th>Stocked</th>
                        <th>Price</th>
                        <th>U/M</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>

                    @if (isset($parts))
                        @foreach ($parts->toArray() as $p)
                            <tr>
                                <td><input type="text" name="qty[]" value="{{ $p['quantity'] }}" class="form-control"/></td>
                                <td><input type="text" name="part[]" value="{{ $p['number'] }}" class="form-control"/></td>
                                <td><input type="text" name="desc[]" value="{{ $p['description'] }}" class="form-control" {{ $type != "manual" ? 'disabled="disabled"' : '' }} /></td>
                                <td><select name="stk[]" class="form-control" class="form-control" {{ $type != "manual" ? 'disabled="disabled"' : '' }}>
                                        <option value="0" {{ $p['stocked']=="0"? 'selected="selected"' : '' }}>No</option>
                                        <option value="1" {{ $p['stocked']=="1"? 'selected="selected"' : '' }}>Yes</option>
                                    </select>
                                </td>
                                <td><input type="text" name="price[]" value="{{ $p['price'] }}" class="form-control" {{ $type != "manual" ? 'disabled="disabled"' : '' }} /></td>
                                <td><select name="unit[]" class="form-control" class="form-control" {{ $type != "manual" ? 'disabled="disabled"' : '' }}>
                                        <option value="EA" {{ $p['unit']=="EA"? 'selected="selected"' : '' }}>EA</option>
                                        <option value="FT" {{ $p['unit']=="FT"? 'selected="selected"' : '' }}>FT</option>
                                        <option value="IN" {{ $p['unit']=="IN"? 'selected="selected"' : '' }}>IN</option>
                                    </select>
                                </td>
                                <td>
                                    <button type="button" class="btn-delete btn btn-default btn-xs"><span class="glyphicon glyphicon-trash"></span></button>
                                    <input type="hidden" name="id[]" value="{{ $p['id'] }}"/>
                                    <input type="hidden" name="delete[]" value="false"/>
                                </td>
                            </tr>
                        @endforeach
                    @endif

                    <tr id="add-quote-controls">
                        <td><input id="qty" type="text" placeholder="Quantity" class="form-control"></td>
                        <td><input id="part" type="text" placeholder="Part Number" class="form-control"></td>
                        <td><input id="desc" type="text" placeholder="Description" class="form-control" {{ $type != "manual" ? 'disabled="disabled"' : '' }}></td>
                        <td><select id="stk" class="form-control" {{ $type != "manual" ? 'disabled="disabled"' : '' }}>
                                <option value="0">No</option>
                                <option value="1">Yes</option>
                            </select></td>
                        <td><input id="price" type="text" placeholder="Price" class="form-control" {{ $type != "manual" ? 'disabled="disabled"' : '' }}></td>
                        <td><select id="unit" class="form-control" {{ $type != "manual" ? 'disabled="disabled"' : '' }}>
                                <option value="EA">EA</option>
                                <option value="FT">FT</option>
                                <option value="IN">IN</option>
                            </select></td>
                        <td>
                            <button id="add" type="button" class="btn btn-success btn-xs">Add item</button>
                        </td>
                    </tr>
                </tbody>
            </table>
            <input type="hidden" id="cust-id" name="customer" @if (isset($quote) && $quote->customer()->first() != null) {{ 'value="'.$quote->customer()->first()->id.'"'  }} @endif />

            <div class="well">
                <div class="form-group">
                    <label class="col-sm-2 control-label">Representative</label>
                    <div class="col-sm-1">
                        <select name="rep">
                            @if (isset($rep))
                                @foreach ($rep->toArray() as $r)
                                    <option value="{{ $r['id'] }}" <?php echo $r['id'] == Auth::id() ? 'selected="selected"' : "" ?>>{{ $r['name'] }}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 control-label">Customer</label>
                    <div class="col-sm-1">
                        <span id="cust-name">@if (isset($quote) && $quote->customer()->first() != null) {{ $quote->customer()->first()->name  }} @endif</span>
                        <a class="btn btn-primary btn-xs" data-toggle="modal" data-target="#modal" href="{{ url('/customers/select') }}">Select customer</a>
                    </div>
                </div>

                <div class="form-group">
                    <label for="notes" class="col-sm-2 control-label">Notes</label>
                    <div class="col-sm-3">
                        <textarea class="form-control" name="notes">@if(isset($quote)){{$quote->notes}}@endif</textarea>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 control-label">Parts discount</label>
                    <div class="col-sm-3">
                        <div class="input-group"><input type="text" name="discount1" class="form-control" @if (isset($quote)) {{ 'value="'.$quote->discount1.'"'  }} @endif />
                            <span class="input-group-addon">%</span></div>
                            <span>with an additional</span>
                        <div class="input-group"><input type="text" name="discount2" class="form-control" @if (isset($quote)) {{ 'value="'.$quote->discount2.'"'  }} @endif />
                            <span class="input-group-addon">%</span></div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-sm-2">
                    </div>
                    <div class="col-sm-2">
                        <input type="submit" class="btn btn-success"/>
                    </div>
                </div>


                <div class="form-group">
                    <div class="col-sm-3">
                        <input class="form-control" name="type" value="{{$type}}" style="display: none;"></input>
                    </div>
                </div>
            </div>
        </fieldset>
    </form>

@stop

@section('scripts')
    <script type="text/javascript">
        /* Mark existing rows as deleted if the remove button is clicked */
        $('.btn-delete').on('click', function () {
            $(this).parent().parent().hide();
            $(this).parent().find('input[name="delete[]"]').val(true);
        });
        //////////////////////////////////////////////////
        $('#part').on('keyup paste change', function () {
            var val = $.trim($('#part').val());
        //parts/get ->> reel/get
            $.getJSON("{{ url('/parts/get').'/' }}" + val, function (data) {
                if (data.length > 0) {
                    $('#desc').val(data[0].description);
                    $('#price').val(data[0].price);
                    $('#stk').val(data[0].stocked);
                    $('#unit').val(data[0].unit);
                }
            });
        });

        $('#add').on('click', function () {
            var part = $('#part').val();
            var qty = $('#qty').val();
            var desc = $('#desc').val();
            var stk = $('#stk').val();
            var price = $('#price').val();
            var unit = $('#unit').val();

            var btn = $('<button>').addClass('btn btn-default btn-xs').attr('type', 'button')
                    .append($('<span>').addClass('glyphicon glyphicon-trash'))
                    .on('click', function () {
                        $(this).parent().parent().remove();
                    });

            var inputs = [];

            $('#add-quote-controls input, #add-quote-controls select').each(function () {

                var name = $(this).attr('id') + "[]";
                var val = $(this).val();
                var element = $(this).clone(true, true).removeAttr('id').attr('name', name).val(val);

                if ($(this).is('input')) {
                    $(this).val('');
                } else {
                    $(this)[0].selectedIndex = 0;
                }

                inputs.push(element);

            });

            var idInput = $('<input>').attr('name', 'id[]').attr('type', 'hidden').val("-1");
            var delInput = $('<input>').attr('name', 'delete[]').attr('type', 'hidden').val(false);

            $('<tr>').insertBefore('#add-quote-controls')
                    .append($('<td>').append(inputs[0]))
                    .append($('<td>').append(inputs[1]))
                    .append($('<td>').append(inputs[2]))
                    .append($('<td>').append(inputs[3]))
                    .append($('<td>').append(inputs[4]))
                    .append($('<td>').append(inputs[5]))
                    .append($('<td>').append(btn).append(idInput).append(delInput));

        });

        $('#select-customer').on('click', function () {
            $.get("{{ url('/customers/select') }}", function (data) {
                $('body').append($('<div>').attr('id', 'modal').html(data));
                var options = {"backdrop": "static"}
                $('#modal').modal(options);
            });
        });

        $('#modal').on('hidden.bs.modal', function (e) {
            var cust = $('.cust-selected:first');
            $('#cust-name').text(cust.children('td:nth-child(2)').text());
            $('#cust-id').val(cust.children('td:nth-child(1)').children(':first').val());
            //$(e.target).removeData('bs.modal');
        });
    </script>
@stop
