<style type="text/css">
	.display_date {
		width: 130px;
		display: inline;
	}
	#filter {
		background-color: white;
		margin-bottom: 1.2em;
		margin-right: 0.1em;
		margin-left: 0.1em;
		padding-top: 0.5em;
		padding-bottom: 0.5em;
	}
	#year-month-filter {
		font-size: 12px;
	}
</style>

<div id="first">
	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-heading">
				  Sites Outcomes <div class="display_date"></div>
				</div>
			  	<div class="panel-body" id="siteOutcomes">
			  		<center><div class="loader"></div></center>
			  	</div>
			</div>
		</div>
	</div>
</div>

<div id="second">
	<div class="row">
		<div class="col-md-6 col-sm-12 col-xs-12">
			<div class="panel panel-default">
			  <div class="panel-heading">
			    Trends <div class="display_range"></div>
			  </div>
			  <div class="panel-body" id="tsttrends">
			    <center><div class="loader"></div></center>
			  </div>
			</div>
		</div>
		<div class="col-md-6 col-sm-12 col-xs-12">
			<div class="panel panel-default">
			  <div class="panel-heading">
			    Outcomes <div class="display_range"></div>
			  </div>
			  <div class="panel-body" id="stoutcomes">
			    <center><div class="loader"></div></center>
			  </div>
			</div>
		</div>
	</div>
	<div class="row">
		<!-- Map of the country -->
		<div class="col-md-4 col-sm-12 col-xs-12">
			<div class="panel panel-default">
			  <div class="panel-heading">
			  	VL Outcomes <div class="display_date" ></div>
			  </div>
			  <div id="vlOutcomes">
			  	<center><div class="loader"></div></center>
			  </div>
			  
			</div>
		</div>
		
		<div class="col-md-4">
			<div class="panel panel-default">
			  <div class="panel-heading">
			    Age <div class="display_date"></div>
			  </div>
			  <div class="panel-body" id="ageGroups">
			    <center><div class="loader"></div></center>
			  </div>
			  <!-- <div>
			  	<button class="btn btn-default" onclick="ageModal();">Click here for breakdown</button>
			  </div> -->
			</div>
		</div>
		<div class="col-md-4">
			<div class="panel panel-default">
			  <div class="panel-heading">
			    Gender <div class="display_date"></div>
			  </div>
			  <div class="panel-body" id="gender" style="padding-bottom:0px;">
			    <center><div class="loader"></div></center>
			  </div>
			</div>
		</div>
		
		<!-- Map of the country -->
		<!-- <div class="col-md-3 col-sm-4 col-xs-12">
			<div class="row">
				<div class="panel panel-default">
				  <div class="panel-heading">
					  Justification for tests <div class="display_date"></div>
				  </div>
				  <div class="panel-body" id="justification" style="height:500px;">
				    <center><div class="loader"></div></center>
				  </div>
				</div>
			</div>
		</div> -->
	</div>
</div>

<div class="modal fade" tabindex="-1" role="dialog" id="agemodal">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Age Category Breakdown</h4>
      </div>
      <div class="modal-body" id="CatAge">
        <center><div class="loader"></div></center>
      </div>
    </div>
  </div>
</div>
<?php $this->load->view('sites_view_footer')?>