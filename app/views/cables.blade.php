@extends('layouts.master')

@section('page-title')
{{ $title }}
@stop

@section('content')

    @include('modal')
    <!--

    INFO FOR CABLE.....


combo1 ROUND/FLAT
combo2 itemType ->IF "OTHER" DISPLAY DESCRIPTION (text12)
combo3 AWG
combo4 Voltage
text10 COND
text4 OD
text5 WIDTH
text7 WGT
text6 BEND
text8 PRICE
////////////////////////////////////////////////////
    Combo1
    *********************************
    //F and R = flat or round

    //cabtype = S/W/G/C/H/P/N

    //combo 3 = AWG (See combo3)

    //text 10 = Conductors
        Select Case Combo1
      Case RoundCable, AnyCable:
        Set myRS = myDB.OpenRecordset("SELECT * FROM Cable WHERE [STYLE] = '" & "R" & "' And [TYPE]= '" & cabtype & "' And Trim([AWG]) = '" & Combo3 & "' AND Trim([COND]) = '" & Text10 & "'")
      Case FlatCable:
        Set myRS = myDB.OpenRecordset("SELECT * FROM Cable WHERE [STYLE] = '" & "F" & "' And [TYPE]= '" & cabtype & "' And Trim([AWG]) = '" & Combo3 & "' AND Trim([COND]) = '" & Text10 & "'"


        All possible matches are held in myRS...


        AFTER DOING SQL:
        If myRS.RecordCount > 0 Then  'in database, pull into form
          //IF RP DOES NOT EQUAL "", SET PN..
          If myRS!PN <> "" Then Text11 = Trim(myRS!PN) ////PULL PN
          If myRS!volts <> "" Then Combo4 = Trim(myRS!volts) ////PULL VOLTS
          If myRS!OD <> "" Then Text4 = Trim(myRS!OD) ////Etc
          If myRS!WIDTH <> "" Then Text5 = Trim(myRS!WIDTH)
          If myRS!WGT <> "" Then Text7 = Trim(myRS!WGT)
          Select Case programNAME


    *********************************
    Combo2 = Cable(cabTOedit).itemTYPE
    Combo3 = Cable(cabTOedit).AWG
        ****ITEMS****
          Combo3.AddItem "1"
          Combo3.AddItem "2"
          Combo3.AddItem "3"
          Combo3.AddItem "4"
          Combo3.AddItem "6"
          Combo3.AddItem "8"
          Combo3.AddItem "10"
          Combo3.AddItem "12"
          Combo3.AddItem "14"
          Combo3.AddItem "16"
          Combo3.AddItem "18"
          Combo3.AddItem "1/0"
          Combo3.AddItem "2/0"
        If metricDEFAULT = False Then
          Combo3.AddItem "18"
          Combo3.AddItem "16"
          Combo3.AddItem "14"
          Combo3.AddItem "12"
          Combo3.AddItem "10"
          Combo3.AddItem "8"
          Combo3.AddItem "6"
          Combo3.AddItem "4"
          Combo3.AddItem "3"
          Combo3.AddItem "2"
          Combo3.AddItem "1"
          Combo3.AddItem "1/0"
          Combo3.AddItem "2/0"
          Combo3.AddItem "3/0"
          Combo3.AddItem "4/0"
          Combo3.AddItem "250"
          Combo3.AddItem "350"
          Combo3.AddItem "500"
    Combo4 = Cable(cabTOedit).VOLTAGE
        Case "HV":
          Combo4.AddItem "5000"
          Combo4.AddItem "8000"
          Combo4.AddItem "15000"
        Case Else
          Combo4.AddItem "600"
          Combo4.AddItem "5000"
          Combo4.AddItem "8000"
          Combo4.AddItem "15000"
    Text10 = Cable(cabTOedit).COND
        manual entry of integer <1-99>
    Text4 = Cable(cabTOedit).OD

    Text5 = Cable(cabTOedit).WIDTH

    Text7 = Cable(cabTOedit).WGT
    **************
        Text7 = Format(Text7, "##0.000")

    *****************************
    Text6 = Cable(cabTOedit).BEND
    **************
    unitsKNOWN = "Millimeters"
    msg = "inches: <0.001-20>"

    Text8 = Cable(cabTOedit).PRICE

    cabINSTLpriceFIXED = Cable(cabTOedit).INSTALLfixed

    cabINSTLpriceFOOT = Cable(cabTOedit).INSTALLfoot

    Text11 = Cable(cabTOedit).PN



    Case RoundCable, AnyCable:
      Label1(3).Caption = "Outside Diameter:"
    Case FlatCable:
      Label1(3).Caption = "Thickness:"

    -->
	<a href="{{ url('/parts/add') }}"><button type="button" class="btn btn-xs btn-success">Add Part</button></a>
	<div class="table-responsive">
		<table class="table table-striped">
		  <thead>
    		<tr>
    		  <th>Part Number</th>
    		  <th>Style</th>
    		  <th>Type</th>
    		  <th>AWG</th>
          <th>Conductors</th>
    		  <th>Volts</th>
          <th>Outer Diameter</th>
          <th>Width</th>
          <th>Inner Diameter</th>
          <th>PSI</th>
          <th>Weight</th>
          <th>Reel Price</th>
          <th>Fest Price</th>
          <th>instl_fix</th>
          <th>instl_ft</th>
    		</tr>
      </thead>
		<tbody>


  	@foreach ($cables as $price)
  	<?php $arr = $price->toArray();
      ?>
  	<tr>

      <td>{{ $arr['PN'] }}</td>
      <td>{{ $arr['STYLE'] }}</td>
      <td>{{ $arr['TYPE'] }}</td>
      <td>{{ $arr['AWG'] }}</td>
      <td>{{ $arr['COND'] }}</td>
      <td>{{ $arr['VOLTS'] }}</td>
      <td>{{ $arr['OD'] }}</td>
      <td>{{ $arr['WIDTH'] }}</td>
      <td>{{ $arr['ID'] }}</td>
      <td>{{ $arr['PSI'] }}</td>
      <td>{{ $arr['WGT'] }}</td>
      <td>{{ $arr['REEL_PRICE'] }}</td>
      <td>{{ $arr['FEST_PRICE'] }}</td>
      <td>{{ $arr['INSTL_FIX'] }}</td>
      <td>{{ $arr['INSTL_FT'] }}</td>

	  </tr>
    @endforeach

    	  </tbody>
    	</table>
	</div>

@stop

@section('scripts')

<script type="text/javascript">

</script>

@stop
