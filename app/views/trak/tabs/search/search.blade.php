<div id='searchcriteria'>
  <div>
    <h3>Search Criteria</h3>
    <div class="well">
      <div class="form-group radio-inline">
        Selecting "any" for models will return the <input type="number" maxlength="4" size="4" id="nummodels" name="nummodels" value="1" /> most cost effective festoon systems.
      </div>
    </div>
    <ul id="tabs-cable" class="nav nav-tabs" role="tablist">
      <li id="tab-e" class="active"><a href="#e" role="tab" data-toggle="tab">E-Trak</a></li>
      <li id="tab-g"><a href="#g" role="tab" data-toggle="tab">G-Trak</a></li>
      <li id="tab-grp"><a href="#grp" role="tab" data-toggle="tab">GRP-Trak</a></li>
      <li id="tab-pt"><a href="#pt" role="tab" data-toggle="tab">PowerTube</a></li>
    </ul>
  </div>

  <div class="tab-content">
    <div class="tab-pane active" id="e">
      @include('trak.tabs.search.tabs.e')
    </div>
    <div class="tab-pane" id="g">
      @include('trak.tabs.search.tabs.g')
    </div>
    <div class="tab-pane" id="grp">
      @include('trak.tabs.search.tabs.grp')
    </div>
    <div class="tab-pane" id="sho">
      @include('trak.tabs.search.tabs.pt')
    </div>

  </div>
</div>
<div id='cablenotselected'>
  <h3>No cable/hose was selected!</h3>
</div>

<script type="text/javascript">




</script>
