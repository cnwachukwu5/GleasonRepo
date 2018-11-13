

function appendGR(pn)
{
  if(pn.indexOf("GR") == -1 && pn != "Special Part") return "GR"+pn;
  return pn;
  //return "GR"+pn;
}

//Still to be tested
function removeGR(pn)
{
  if(pn.indexOf("GR") == 0) return pn.slice(2);
  return pn;
}


function selectedHV(data) {
  if(data.value == "hv") {
     document.getElementById("conductors").value = 3;
     $("#removeHV").prop("disabled", true);
     $("#removeHV").hide();
  }
  else
  {
    $("#removeHV").prop("disabled", false);
    $("#removeHV").show();
  }

}

function fluidWGTft(type, diam)
{
  var type = $('#type').val();

  if(type == "Air") type = 0.08;
  else if(type== "Water") type = 62.36;
  else if(type == "Hydraulic") type = 54.81;
  else if(type == "Other") return null;

  return type * (3.14159 * ((parseFloat(diam) / 12) ^ 2) / 4)
}

function checkCond(input){
  if (input.value < 0) input.value = 0;
    if (input.value > 99) input.value = 99;
}

function isNumberKey(evt)
{
   var charCode = (evt.which) ? evt.which : event.keyCode
   if (charCode > 31 && (charCode < 48 || charCode > 57))
    return false;
   return true;
}

function calcBend(itemDiam)
{
  var tempBend;

  tempBend = 4 * parseFloat(itemDiam);
  return tempBend;
}

function getValidSpringS(value) {
  var springSize = $("#s-inputs select[name='s-springsize']");
  var application = $('#applicationSelect').val();

  springSize.find('option').remove();

  springSize.append($('<option></option>').val('all').text('All'));
  springSize.append($('<option></option>').val('351').text('351'));
  springSize.append($('<option></option>').val('601').text('601'));
  springSize.append($('<option></option>').val('621').text('621'));
  springSize.append($('<option></option>').val('622').text('622'));
  springSize.append($('<option></option>').val('623').text('623'));
  springSize.append($('<option></option>').val('624').text('624'));
  springSize.append($('<option></option>').val('62X').text('62X'));
  springSize.append($('<option></option>').val('751').text('751'));
  springSize.append($('<option></option>').val('752').text('752'));
  springSize.append($('<option></option>').val('753').text('753'));
  springSize.append($('<option></option>').val('754').text('754'));
  springSize.append($('<option></option>').val('75X').text('75X'));
  springSize.append($('<option></option>').val('801').text('801'));
  springSize.append($('<option></option>').val('802').text('802'));
  springSize.append($('<option></option>').val('803').text('803'));
  springSize.append($('<option></option>').val('804').text('804'));
  springSize.append($('<option></option>').val('80X').text('80X'));
  if(application != 'hand') {
    springSize.append($('<option></option>').val('1001').text('1001'));
    springSize.append($('<option></option>').val('1002').text('1002'));
    springSize.append($('<option></option>').val('1003').text('1003'));
    springSize.append($('<option></option>').val('1004').text('1004'));
    springSize.append($('<option></option>').val('100X').text('100X'));
  }

  if(value != null) {
    switch(value) {
      case '32':
        limitChoice = true;
        $('#s-checkboxes :checkbox').each(function() {
          if(this.value != '14' && this.value != '32') {
            if(this.checked) {
              limitChoice = false;
            }
          }
        });
        //console.log('limitChoice: ' + limitChoice);
        //console.log('s14 checked: ' + $("#s-checkboxes :checkbox[value='s14']").is(':checked'));
        if(limitChoice == true && $("#s-checkboxes :checkbox[value='32']").is(':checked')) {
          springSize.find('option').remove();
          springSize.append($('<option></option>').val('all').text('All'));
          if($("#s-checkboxes :checkbox[value='14']").is(':checked')) {

            springSize.append($('<option></option>').val('351').text('351'));
            springSize.append($('<option></option>').val('601').text('601'));
            springSize.append($('<option></option>').val('751').text('751'));
          }

          springSize.append($('<option></option>').val('801').text('801'));
          springSize.append($('<option></option>').val('802').text('802'));
          springSize.append($('<option></option>').val('803').text('803'));
          springSize.append($('<option></option>').val('804').text('804'));
          springSize.append($('<option></option>').val('80X').text('80X'));
          if(application != 'hand') {
            springSize.append($('<option></option>').val('1001').text('1001'));
            springSize.append($('<option></option>').val('1002').text('1002'));
            springSize.append($('<option></option>').val('1003').text('1003'));
            springSize.append($('<option></option>').val('1004').text('1004'));
            springSize.append($('<option></option>').val('100X').text('100X'));
          }
        }

        if(limitChoice == true && !$("#s-checkboxes :checkbox[value='32']").is(':checked') && $("#s-checkboxes :checkbox[value='14']").is(':checked')) {
          springSize.find('option').remove();
          springSize.append($('<option></option>').val('all').text('All'));
          springSize.append($('<option></option>').val('351').text('351'));
          springSize.append($('<option></option>').val('601').text('601'));
          springSize.append($('<option></option>').val('751').text('751'));
        }
        break;
      case '14':
        limitChoice = true;
        $('#s-checkboxes :checkbox').each(function() {
          if(this.value != '14' && this.value != '32') {
            if(this.checked) {
              limitChoice = false;
            }
          }
        });

        if(limitChoice == true && $("#s-checkboxes :checkbox[value='14']").is(':checked')) {
          springSize.find('option').remove();
          springSize.append($('<option></option>').val('all').text('All'));
          springSize.append($('<option></option>').val('351').text('351'));
          springSize.append($('<option></option>').val('601').text('601'));
          springSize.append($('<option></option>').val('751').text('751'));
          if($("#s-checkboxes :checkbox[value='32']").is(':checked')) {
            springSize.append($('<option></option>').val('801').text('801'));
            springSize.append($('<option></option>').val('802').text('802'));
            springSize.append($('<option></option>').val('803').text('803'));
            springSize.append($('<option></option>').val('804').text('804'));
            springSize.append($('<option></option>').val('80X').text('80X'));
            if(application != 'hand') {
              springSize.append($('<option></option>').val('1001').text('1001'));
              springSize.append($('<option></option>').val('1002').text('1002'));
              springSize.append($('<option></option>').val('1003').text('1003'));
              springSize.append($('<option></option>').val('1004').text('1004'));
              springSize.append($('<option></option>').val('100X').text('100X'));
            }
          }
        }

        if(limitChoice == true && !$("#s-checkboxes :checkbox[value='14']").is(':checked') && $("#s-checkboxes :checkbox[value='32']").is(':checked')) {

          springSize.find('option').remove();
          springSize.append($('<option></option>').val('all').text('All'));
          springSize.append($('<option></option>').val('801').text('801'));
          springSize.append($('<option></option>').val('802').text('802'));
          springSize.append($('<option></option>').val('803').text('803'));
          springSize.append($('<option></option>').val('804').text('804'));
          springSize.append($('<option></option>').val('80X').text('80X'));
          if(application != 'hand') {
            springSize.append($('<option></option>').val('1001').text('1001'));
            springSize.append($('<option></option>').val('1002').text('1002'));
            springSize.append($('<option></option>').val('1003').text('1003'));
            springSize.append($('<option></option>').val('1004').text('1004'));
            springSize.append($('<option></option>').val('100X').text('100X'));
          }
        }
        break;
    }
  }
}

function getValidSpringMMD() {
  var springSize = $("#mmd-inputs select[name='mmd-springsize']");

  springSize.find('option').remove();

  springSize.append($('<option></option>').val('all').text('All'));
  springSize.append($('<option></option>').val('1001').text('1001'));
  springSize.append($('<option></option>').val('1002').text('1002'));
  springSize.append($('<option></option>').val('1003').text('1003'));
  springSize.append($('<option></option>').val('1004').text('1004'));
  springSize.append($('<option></option>').val('100X').text('100X'));
}

function getValidSpringSM() {
  var springSize = $("#sm-inputs select[name='sm-springsize']");
  var application = $('#applicationSelect').val();

  springSize.find('option').remove();
  springSize.append($('<option></option>').val('all').text('All'));
  springSize.append($('<option></option>').val('1001').text('1001'));
  springSize.append($('<option></option>').val('1002').text('1002'));
  springSize.append($('<option></option>').val('1003').text('1003'));
  springSize.append($('<option></option>').val('1004').text('1004'));
  springSize.append($('<option></option>').val('100X').text('100X'));

  if($("#sm-checkboxes :checkbox[value='any']").is(':checked')
    || $("#sm-checkboxes :checkbox[value='sm32']").is(':checked')) {
    springSize.find('option').remove();
    springSize.append($('<option></option>').val('all').text('All'));
    springSize.append($('<option></option>').val('1001').text('1001'));
    springSize.append($('<option></option>').val('1002').text('1002'));
    springSize.append($('<option></option>').val('1003').text('1003'));
    springSize.append($('<option></option>').val('1004').text('1004'));
    springSize.append($('<option></option>').val('1004').text('1005'));
    springSize.append($('<option></option>').val('1004').text('1006'));
    springSize.append($('<option></option>').val('1004').text('1007'));
    springSize.append($('<option></option>').val('1004').text('1008'));
    springSize.append($('<option></option>').val('100X').text('100X'));
  }
}

function showSearchCriteria() {
  $('#cablenotselected').hide();
  $('#searchcriteria').show();
}

function hideSearchCriteria() {
  $('#cablenotselected').show();
  $('#searchcriteria').hide();
}

function showValidGearS() {
  var gearRatio = $("#s-inputs select[name='s-gearratio']");
  var checkboxes = $('#s-checkboxes :checkbox');
  var springSize = $("#s-inputs select[name='s-springsize']");

  var gearChoice = [];
  for(var i = 0; i < 21; i++) {
    gearChoice.push(false);
  }

  gearRatio.find('option').remove();
  gearChoice[0] = true;
  //gearRatio.append($('<option></option>').val('noneGear').text('None'));

  if($("#s-checkboxes :checkbox[value='any']").is(':checked')) {
    for(var i = 1; i < gearChoice.length; i++) {
      gearChoice[i] = true;
    }
  }

  if($("#s-checkboxes :checkbox[value='32']").is(':checked')) {
    gearChoice[0] = true;
    gearChoice[1] = true;
    switch(springSize.val()) {
      case 'all':
      case '100X':
        for(var i = 11; i < gearChoice.length; i++) {
          gearChoice[i] = true;
        }
        break;
      case '80X':
      case '801':
      case '802':
      case '803':
      case '804':
      case '1001':
      case '1002':
        for(var i = 11; i < 17; i++) {
          gearChoice[i] = true;
        }
        break;
      case '1003':
        for(var i = 17; i < gearChoice.length; i++) {
          gearChoice[i] = true
        }
        break;
      case '1004':
        for(var i = 18; i < gearChoice.length; i++) {
          gearChoice[i] = true;
        }
        break;
    }
  }

    if($("#s-checkboxes :checkbox[value='14']").is(':checked') || $("#s-checkboxes :checkbox[value='16']").is(':checked') || $("#s-checkboxes :checkbox[value='18']").is(':checked')) {
        gearChoice[0] = true;
        gearChoice[1] = true;
    }

  if($("#s-checkboxes :checkbox[value='21']").is(':checked') ||
    $("#s-checkboxes :checkbox[value='24']").is(':checked') ||
    $("#s-checkboxes :checkbox[value='28']").is(':checked')) {
    gearChoice[0] = true;
    gearChoice[1] = true;
    switch(springSize.val()) {
      case '80X':
      case '801':
      case '802':
      case '803':
      case '1001':
      case '1002':
        for(var i = 2; i < 9; i++) {
          gearChoice[i] = true;
        }
        break;
      case '804':
        for(var i = 2; i < 8; i++) {
          gearChoice[i] = true;
        }
        break;
      case '1003':
        for(var i = 2; i < 6; i++) {
          gearChoice[i] = true;
        }
        gearChoice[10] = true;
        break;
      case '1004':
        for(var i = 2; i < 5; i++) {
          gearChoice[i] = true;
        }
        gearChoice[9] = true;
        gearChoice[10] = true;
        break;
      case '100X':
      case 'all':
        for(var i = 2; i < 9; i++) {
          gearChoice[i] = true;
        }
        gearChoice[9] = true;
        gearChoice[10] = true;
        break;
    }
  }

  //console.log(gearChoice);
  if(gearChoice[0]) gearRatio.append($('<option></option>').val('none').text('None'));
  if(gearChoice[1]) gearRatio.append($('<option></option>').val('all').text('All').attr('selected', true));
  if(gearChoice[2]) gearRatio.append($('<option></option>').val('A').text('A (gr: 1.22)'));
  if(gearChoice[3]) gearRatio.append($('<option></option>').val('B').text('B (gr: 1.5)'));
  if(gearChoice[4]) gearRatio.append($('<option></option>').val('C').text('C (gr: 1.86)'));
  if(gearChoice[5]) gearRatio.append($('<option></option>').val('D').text('D (gr: 2.07)'));
  if(gearChoice[6]) gearRatio.append($('<option></option>').val('E').text('E (gr: 2.33)'));
  if(gearChoice[7]) gearRatio.append($('<option></option>').val('F').text('F (gr: 3.00)'));
  if(gearChoice[8]) gearRatio.append($('<option></option>').val('G').text('G (gr: 4.00)'));
  if(gearChoice[9]) gearRatio.append($('<option></option>').val('J').text('J (gr: 2.00)'));
  if(gearChoice[10]) gearRatio.append($('<option></option>').val('K').text('K (gr: 2.33)'));
  if(gearChoice[11]) gearRatio.append($('<option></option>').val('M').text('M (gr: 1.50)'));
  if(gearChoice[12]) gearRatio.append($('<option></option>').val('N').text('N (gr: 1.72)'));
  if(gearChoice[13]) gearRatio.append($('<option></option>').val('P').text('P (gr: 2.00)'));
  if(gearChoice[14]) gearRatio.append($('<option></option>').val('Q').text('Q (gr: 2.33)'));
  if(gearChoice[15]) gearRatio.append($('<option></option>').val('R').text('R (gr: 2.75)'));
  if(gearChoice[16]) gearRatio.append($('<option></option>').val('S').text('S (gr: 4.00)'));
  if(gearChoice[17]) gearRatio.append($('<option></option>').val('T').text('T (gr: 1.50)'));
  if(gearChoice[18]) gearRatio.append($('<option></option>').val('V').text('V (gr: 2.00)'));
  if(gearChoice[19]) gearRatio.append($('<option></option>').val('W').text('W (gr: 2.75)'));
  if(gearChoice[20]) gearRatio.append($('<option></option>').val('Y').text('Y (gr: 4.00)'));
}

function showValidGearMMD() {
  var gearRatio = $("#mmd-inputs select[name='mmd-gearratio']");
  var checkboxes = $('#mmd-checkboxes :checkbox');
  var springSize = $("#mmd-inputs select[name='mmd-springsize']");

  var gearChoice = [];
  for(var i = 0; i < 21; i++) {
    gearChoice.push(false);
  }

  gearRatio.find('option').remove();
  gearChoice[0] = true;
  //gearRatio.append($('<option></option>').val('noneGear').text('None'));

  if($("#mmd-checkboxes :checkbox[value='any']").is(':checked')) {
    for(var i = 1; i < gearChoice.length; i++) {
      gearChoice[i] = true;
    }
  }

  if($("#mmd-checkboxes :checkbox[value='32']").is(':checked')) {
    gearChoice[0] = true;
    gearChoice[1] = true;
    switch(springSize.val()) {
      case 'all':
      case '100X':
        for(var i = 11; i < gearChoice.length; i++) {
          gearChoice[i] = true;
        }
        break;
      case '80X':
      case '801':
      case '802':
      case '803':
      case '804':
      case '1001':
      case '1002':
        for(var i = 11; i < 17; i++) {
          gearChoice[i] = true;
        }
        break;
      case '1003':
        for(var i = 17; i < gearChoice.length; i++) {
          gearChoice[i] = true
        }
        break;
      case '1004':
        for(var i = 18; i < gearChoice.length; i++) {
          gearChoice[i] = true;
        }
        break;
    }
  }

  if($("#mmd-checkboxes :checkbox[value='21']").is(':checked') ||
    $("#mmd-checkboxes :checkbox[value='24']").is(':checked') ||
    $("#mmd-checkboxes :checkbox[value='28']").is(':checked')) {
    gearChoice[0] = true;
    gearChoice[1] = true;
    switch(springSize.val()) {
      case '80X':
      case '801':
      case '802':
      case '803':
      case '1001':
      case '1002':
        for(var i = 2; i < 9; i++) {
          gearChoice[i] = true;
        }
        break;
      case '804':
        for(var i = 2; i < 8; i++) {
          gearChoice[i] = true;
        }
        break;
      case '1003':
        for(var i = 2; i < 6; i++) {
          gearChoice[i] = true;
        }
        gearChoice[10] = true;
        break;
      case '1004':
        for(var i = 2; i < 5; i++) {
          gearChoice[i] = true;
        }
        gearChoice[9] = true;
        gearChoice[10] = true;
        break;
      case '100X':
      case 'all':
        for(var i = 2; i < 9; i++) {
          gearChoice[i] = true;
        }
        gearChoice[9] = true;
        gearChoice[10] = true;
        break;
    }
  }

  //console.log(gearChoice);
  if(gearChoice[0]) gearRatio.append($('<option></option>').val('none').text('None'));
  if(gearChoice[1]) gearRatio.append($('<option></option>').val('all').text('All').attr('selected', true));
  if(gearChoice[2]) gearRatio.append($('<option></option>').val('A').text('A (gr: 1.22)'));
  if(gearChoice[3]) gearRatio.append($('<option></option>').val('B').text('B (gr: 1.5)'));
  if(gearChoice[4]) gearRatio.append($('<option></option>').val('C').text('C (gr: 1.86)'));
  if(gearChoice[5]) gearRatio.append($('<option></option>').val('D').text('D (gr: 2.07)'));
  if(gearChoice[6]) gearRatio.append($('<option></option>').val('E').text('E (gr: 2.33)'));
  if(gearChoice[7]) gearRatio.append($('<option></option>').val('F').text('F (gr: 3.00)'));
  if(gearChoice[8]) gearRatio.append($('<option></option>').val('G').text('G (gr: 4.00)'));
  if(gearChoice[9]) gearRatio.append($('<option></option>').val('J').text('J (gr: 2.00)'));
  if(gearChoice[10]) gearRatio.append($('<option></option>').val('K').text('K (gr: 2.33)'));
  if(gearChoice[11]) gearRatio.append($('<option></option>').val('M').text('M (gr: 1.50)'));
  if(gearChoice[12]) gearRatio.append($('<option></option>').val('N').text('N (gr: 1.72)'));
  if(gearChoice[13]) gearRatio.append($('<option></option>').val('P').text('P (gr: 2.00)'));
  if(gearChoice[14]) gearRatio.append($('<option></option>').val('Q').text('Q (gr: 2.33)'));
  if(gearChoice[15]) gearRatio.append($('<option></option>').val('R').text('R (gr: 2.75)'));
  if(gearChoice[16]) gearRatio.append($('<option></option>').val('S').text('S (gr: 4.00)'));
  if(gearChoice[17]) gearRatio.append($('<option></option>').val('T').text('T (gr: 1.50)'));
  if(gearChoice[18]) gearRatio.append($('<option></option>').val('V').text('V (gr: 2.00)'));
  if(gearChoice[19]) gearRatio.append($('<option></option>').val('W').text('W (gr: 2.75)'));
  if(gearChoice[20]) gearRatio.append($('<option></option>').val('Y').text('Y (gr: 4.00)'));
}

function showValidGearSM() {
  var gearRatio = $("#sm-inputs select[name='sm-gearratio']");
  var checkboxes = $('#sm-checkboxes :checkbox');
  var springSize = $("#sm-inputs select[name='sm-springsize']");

  var gearChoice = [];
  for(var i = 0; i < 12; i++) {
    gearChoice.push(false);
  }

  gearRatio.find('option').remove();
  gearChoice[0] = true;
  //gearRatio.append($('<option></option>').val('noneGear').text('None'));

  if($("#sm-checkboxes :checkbox[value='any']").is(':checked')) {
    for(var i = 1; i < gearChoice.length; i++) {
      gearChoice[i] = true;
    }
  }


  gearChoice[1] = true;
  switch(springSize.val()) {
    case 'all':
    case '100X':
      for(var i = 2; i < gearChoice.length; i++) {
        gearChoice[i] = true;
      }
      break;
    case '1001':
    case '1002':
      for(var i = 2; i < 8; i++) {
        gearChoice[i] = true;
      }
      break;
    case '1003':
      for(var i = 8; i < gearChoice.length; i++) {
        gearChoice[i] = true
      }
      break;
    case '1004':
    case '1007':
    case '1008':
      for(var i = 9; i < gearChoice.length; i++) {
        gearChoice[i] = true;
      }
      break;
    case '1005':
    case '1006':
      for(var i = 8; i < gearChoice.length; i++) {
        gearChoice[i] = true;
      }
      break;
  }

  //console.log(gearChoice);
  if(gearChoice[0]) gearRatio.append($('<option></option>').val('none').text('None'));
  if(gearChoice[1]) gearRatio.append($('<option></option>').val('all').text('All').attr('selected', true));
  if(gearChoice[2]) gearRatio.append($('<option></option>').val('M').text('M (gr: 1.50)'));
  if(gearChoice[3]) gearRatio.append($('<option></option>').val('N').text('N (gr: 1.72)'));
  if(gearChoice[4]) gearRatio.append($('<option></option>').val('P').text('P (gr: 2.00)'));
  if(gearChoice[5]) gearRatio.append($('<option></option>').val('Q').text('Q (gr: 2.33)'));
  if(gearChoice[6]) gearRatio.append($('<option></option>').val('R').text('R (gr: 2.75)'));
  if(gearChoice[7]) gearRatio.append($('<option></option>').val('S').text('S (gr: 4.00)'));
  if(gearChoice[8]) gearRatio.append($('<option></option>').val('T').text('T (gr: 1.50)'));
  if(gearChoice[9]) gearRatio.append($('<option></option>').val('V').text('V (gr: 2.00)'));
  if(gearChoice[10]) gearRatio.append($('<option></option>').val('W').text('W (gr: 2.75)'));
  if(gearChoice[11]) gearRatio.append($('<option></option>').val('Y').text('Y (gr: 4.00)'));
}




function switchShoReel(){


    if($("#shoReelSpooling").val() == "random") {
      $("#sho-reels-min-range").val(14);
      $("#sho-reels-max-range").val(36);

      if (parseFloat($("#identifier8").text()) * 1.1 < 4) {
        $('#sho-reels-spool-width')
            .find('option')
            .remove()
            .end()
            .append('<option value="4">4</option>'

            )
            .val('all');
        if(parseFloat($("#identifier8").text()) * 1.1 < 7){
          $('#sho-reels-spool-width')
              .find('option')
              .end()
              .append('<option value="7">7</option>'
                  + '<option value="all" selected="selected">all</option>'
              )
              .val('all');

        }
      }


    }

  else{
      $('#sho-reels-spool-width')
          .find('option')
          .remove()
          .end();

      if(parseFloat($("#identifier8").text()) * 1.1 <= .75){
        $('#sho-reels-spool-width')
            .find('option')
            .end()
            .append('<option value="ma">MA</option>'
            )

      }
      if(parseFloat($("#identifier8").text()) * 1.1 <= 1){
        $('#sho-reels-spool-width')
            .find('option')
            .end()
            .append('<option value="mb">MB</option>'
            )

      }
      if(parseFloat($("#identifier8").text()) * 1.1 <= 1.25){
        $('#sho-reels-spool-width')
            .find('option')
            .end()
            .append('<option value="mc">MC</option>'
            )

      }
      if(parseFloat($("#identifier8").text()) * 1.1 <= 1.5){
        $('#sho-reels-spool-width')
            .find('option')
            .end()
            .append('<option value="md">MD</option>'
            )

      }
      if(parseFloat($("#identifier8").text()) * 1.1 <= 1.75){
        $('#sho-reels-spool-width')
            .find('option')
            .end()
            .append('<option value="me">ME</option>'
            )

      }
      if(parseFloat($("#identifier8").text()) * 1.1 <= 2){
        $('#sho-reels-spool-width')
            .find('option')
            .end()
            .append('<option value="mf">MF</option>'
            )

      }
      if(parseFloat($("#identifier8").text()) * 1.1 <= 2){
        $('#sho-reels-spool-width')
            .find('option')
            .end()
            .append('<option value="mx">MX</option>'
                + '<option value="default" selected="selected">default</option>'
            )

      }




    $("#sho-reels-min-range").val(18);
    $("#sho-reels-max-range").val(48);
    $('#sho-reels-spool-width')
        .find('option')
        .remove()
        .end()
        .append(
            '<option value="ma">MA</option>'
            +'<option value="mb">MB</option>'
            +'<option value="mc">MC</option>'
            +'<option value="md">MD</option>'
            +'<option value="me">ME</option>'
            +'<option value="mf">MF</option>'
            +'<option value="mx">MX</option>'
            +'<option value="default">Default</option>')
        .val('ma');
  }
}


function changeTabs() {
  $('#tabs-cable').hide();
  $('#tabs-hose').hide();

  var style = $('#identifier1').text();
  //if the style of the selected item is "Cable"
  if(style === "Cable") {
    var type = $('#identifier2').text();
    var conductors = $('#identifier4').text();
    var awg = $('#identifier3').text();
    var bendRadius = $('#identifier9').text();
    var calcDrumMinR = (2*bendRadius) + 1;
    $('#tabs-cable').show();

    $('#tabs-cable li').removeClass('disabled'); //show all tabs

    if($("#applicationSelect").val() != "lift")
    {
      $("#tab-pendant").addClass('disabled');
    }

    if($("#applicationSelect").val() == "magnet")
    {
      $('#tabs-cable li').addClass('disabled');
      $('#tab-s').removeClass('disabled');
      $('#tab-sm').removeClass('disabled');
      $('#tab-mmd').removeClass('disabled');
    }

    if($("#applicationSelect").val() == "hand")
    {
      $('#tabs-cable li').addClass('disabled');
      $('#tab-s').removeClass('disabled');
      $('#tab-uc').removeClass('disabled');
      $('#tab-cm').removeClass('disabled');
    }

    if(calcDrumMinR > 28) {
      $('#tabs-cable li').addClass('disabled');
      $('#tab-sho').removeClass('disabled');
      $('#tab-tmr').removeClass('disabled');
    }

    else if(type == "GGC" || conductors > 12 || ( awg < 8 || awg > 18))
    {
      $('#tab-cm').addClass('disabled');
    }

    //In nearly every case in the old VB program, U and TMR is disabled. I can't find the condition for this, so for now they're just disabled.
    //$('#tab-uc').addClass('disabled');
    //$('#tab-tmr').addClass('disabled');

    //Ensure that the selected tab is the first enabled tab
    $('#tabs-cable li').removeClass('active');
    $('#tabs-cable li').not('.disabled').first().addClass('active');
    $('#k').removeClass('active');
    $('#s').addClass('active');

  }
  else {
    $('#tabs-hose').show();
    var innerdiameter = $('#identifier7').text();

    $('#tabs-hoses').show();
    $("tab-uh").show();
    $("tab-hm").show();
    $('#tabs-hose li').removeClass('disabled');
    //$('#tabs-cable').hide();

    $('#tabs-hose li').removeClass('disabled');

    //console.log(style);
    if(style.indexOf('Dual Hose') != -1)
    {
      // disableTab('#tab-uh');
      // disableTab('#tab-hm');
      $('#tab-uh').addClass('enabled');
      $('#tab-hm').addClass('enabled');
    }
    else
    {
      // disableTab('#tab-k');
    //  $('#tab-k').addClass('disabled');
    }

    //if the application option is set to hand pull,
    if($('#applicationSelect').val() == "hand")
    {
      // disableTab('#tab-k');
      $('#tab-k').addClass('disabled');
    }

    //if the ID of the selected hose is greater than 0.5 inches,
    if(innerdiameter > 0.5)
    {
      //then HM is not an applicable reel
      // disableTab('#tab-hm');
      $('#tab-hm').addClass('disabled');
    }

    //Ensure that the selected tab is the first enabled tab
    $('#tabs-hose li').removeClass('active');
    $('#tabs-hose li').not('.disabled').first().addClass('active');
    $('#s').removeClass('active');
    $('#k').addClass('active');
  }

  // getValidSpringS();
}
var grndQty, grndChkQty;
function changeApplication() {
  var style = $('#identifier1').text();
  var type = $('#identifier2').text();
  var cond = $('#identifier4').text();
  var applicObject = $('#applicationSelect');
  applicObject.find('option').remove();

  //This code was almost directly copied from the previous program

  switch(type) {
    case "G":
      grndQty = 1;
      grndChkQty = 0;
      break;
    case "HV":
    case "GGC":
      grndQty = 1;
      grndChkQty = 1;
      break;
    default:
      grndQty = 0;
      grndChkQty = 0;
      break;
  }

  var qtyConductorsLessGrndChk = parseInt(grndQty) + parseInt(cond);
  //console.log("qtyConductorsLessGrndChk: " + qtyConductorsLessGrndChk);
  applicObject.append($('<option></option>').val('lift').text('Lift'));
  applicObject.append($('<option></option>').val('stretch').text('Stretch'));

  if(style.indexOf('Dual Hose') == -1) {
    applicObject.append($('<option></option>').val('retrieve').text('Retrieve'));
    if(qtyConductorsLessGrndChk == 2) {
      applicObject.append($('<option></option>').val('magnet').text('Magnet'));
    }
    applicObject.append($('<option></option>').val('hand').text('Hand Pull'));
  }
}


function handleError(error) {
  responseText = JSON.parse(error.responseText).error;
  console.log(error);
  console.error(error.statusText + "\n" + responseText.message + "\n\ton line " + responseText.line + " in file " + responseText.file + "\n\ttype: " + responseText.type);
}

function updatePackageSelect(url, customerid){
  $.getJSON(url + '/package/customer/get/' + customerid, function(data) {
    $('#packageSelect').find("option").remove();
    $('#packageSelect').append($("<option></option>").attr("value", -1).text("New"));
    data.forEach(function(row){
      $('#packageSelect').append($("<option></option>").attr("value", row.id).text(row.name));
    });
  });
}
function getCollectorAmp(awg){
    var collectorAmp;
  switch(false){
    case true:

          break;
    case false:
          switch(awg)
          {
            case "18":
            case "16":
            case "14":
            case "12":
            case "10":
              collectorAmp = 35;
              break;
            case "8":
            case "6":
              collectorAmp = 75;
              break;
            case "4":
            case "3":
            case "2":
              collectorAmp = 125;
              break;
            case "1":
            case "1/0":
              collectorAmp = 200;
              break;
            case "2/0":
              collectorAmp = 400;
              break;
            case "3/0":
            case "4/0":
            case "250":
            case "300":
            case "350":
            case "400":
            case "450":
            case "500":
              collectorAmp = -1;
              break;
          }
    break;

  }
  return collectorAmp;


}
function changeCollectorCode(cond, awg){
  var amp = getCollectorAmp(awg);
  //alert(amp);
  var c = parseInt(cond);
  var qtycondLess = c + grndChkQty;
  var numCollectorCond;
  var cc;
switch(amp){
  case 35:

    if(qtycondLess>38){
      cc = "bad";
    }else if(qtycondLess>30){
      cc = "363"
      numCollectorCond = 36;
    }
    else if(qtycondLess>24){
      cc = "303"
      numCollectorCond = 30;
    }
    else if(qtycondLess>20){
      cc = "243"
      numCollectorCond = 24;
    }
    else if(qtycondLess>16){
      cc = "203"
      numCollectorCond = 20;
    }
    else if(qtycondLess>14){
      cc = "163"
      numCollectorCond = 16;
    }
    else if(qtycondLess>12){
      cc = "143"
      numCollectorCond = 14;
    }
    else if(qtycondLess>10){
      cc = "123"
      numCollectorCond = 12;
    }
    else if(qtycondLess>8){
      cc = "103"
      numCollectorCond = 10;
    }
    else if(qtycondLess>6){
      cc = "83"
      numCollectorCond = 8;
    }
    else if(qtycondLess>4){
      cc = "63"
      numCollectorCond = 6;
    }else if(qtycondLess>3){
      cc = "43"
      numCollectorCond = 4;
    }else if(qtycondLess>2){
      cc = "33"
      numCollectorCond = 3;
    }else if(qtycondLess>0){
      cc = "23"
      numCollectorCond = 2;
    }else{}
        break;
  case 75:
        if(c>8){
          cc = "bad"
        }
        else if(c>6){
          cc = "87"
          numCollectorCond = 8;
        }
        else if(c>4){
          cc = "67"
          numCollectorCond = 6;
        }else if(c>3){
          cc = "47"
          numCollectorCond = 4;
        }else if(c>2){
          cc = "37"
          numCollectorCond = 3;
        }else if(c>0){
          cc = "27"
          numCollectorCond = 2;
        }
        break;
  case 125:
       if(c>4){
        cc = "bad"
      }else if(c>3){
        cc = "412"
        numCollectorCond = 4;
      }else if(c>2){
        cc = "312"
        numCollectorCond = 3;
      }else if(c>0){
        cc = "212"
        numCollectorCond = 2;
      }
        break;
  case 200:
    if(c>4){
      cc = "bad"
    }else if(c>3){
      cc = "420"
      numCollectorCond = 4;
    }else if(c>2){
      cc = "320"
      numCollectorCond = 3;
    }else if(c>0){
      cc = "220"
      numCollectorCond = 2;
    }
    break;
  case 400:
    if(c>2){
      cc = "bad"
    }else if(c>0){
      cc = "240"
      numCollectorCond = 2;
    }
    break;

  }
  $("#s-collectorcode").val(cc);
  $("#mmd-collectorcode").val(cc);
  $("#sm-collectorcode").val(cc);
  $("#sho-reels-code").val(cc);
  $("#tmr-reels-code").val(cc);
  $("#u-collectorcode").val(cc);



}
function addOptionToPackageSelect(pid, name) {
  $('#packageSelect').append($("<option></option>").attr("value", pid).attr('selected', 'selected').text(name));
}

function getMetricValue(metricType){
    if(metricType === "STD"){
        return false;
    }else{
        return true;
    }
}

/*
function removeOptionFromPackageSelect(pid) {
  $('#packageSelect')
}
*/

$(document).ready(function() {
 // switchShoReel();
$('#rowTab a:first').tab('show');
$('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
//show selected tab / active
 //console.log ( $(e.target).attr('id') );
 if($(e.target).attr('id') == "cableTab"){
   onCableTab = true;
 }
 else{
   onCableTab = false;
 }
});

});
