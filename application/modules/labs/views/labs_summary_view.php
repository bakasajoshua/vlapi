<style type="text/css">
	.display_date {
		width: 130px;
		display: inline;
	}
	.display_range {
		width: 130px;
		display: inline;
	}
	
</style>
<div class="row">
	<!-- Map of the country -->
	<div style="color:red;"><center>Click on Lab(s) on legend to view only for the lab(s) selected</center></div>
	<div class="col-md-6 col-sm-12 col-xs-12">
		<div class="panel panel-default">
		  <div class="panel-heading">
		  	Labs Testing Trends <div class="display_date" ></div>
		  </div>
		  <div class="panel-body" id="test_trends">
		  	<center><div class="loader"></div></center>
		  </div>
		  
		</div>
	</div>
	<!-- Map of the country -->
	<!-- Map of the country -->
	<div class="col-md-6 col-sm-12 col-xs-12">
		<div class="panel panel-default">
		  <div class="panel-heading">
		  	Labs Rejection Trends <div class="display_date" ></div>
		  </div>
		  <div class="panel-body" id="rejected">
		  	<center><div class="loader"></div></center>
		  </div>
		  
		</div>
	</div>
	<!-- Map of the country -->
	
</div>
<div class="row">
	<div class="col-md-5 col-sm-12 col-xs-12">
		<div class="panel panel-default">
		  <div class="panel-heading">
		    Sample Types Sent to Labs <div class="display_date" ></div>
		  </div>
		  <div class="panel-body" id="samples">
		    <div>Loading...</div>
		  </div>
		</div>
	</div>
	<div class="col-md-7 col-sm-12 col-xs-12">
		<div class="panel panel-default">
		  <div class="panel-heading">
		    Turn around Time <div class="display_date" ></div>
		  </div>
		  <div class="panel-body" id="ttime">
		    <div>Loading...</div>
		  </div>
		  
		</div>
	</div>
</div>
<div class="row">
	<!-- Map of the country -->
	<div class="col-md-12 col-sm-12 col-xs-12">
		<div class="panel panel-default">
		  <div class="panel-heading">
		  	Results Outcomes <div class="display_date"></div>
		  </div>
		  <div class="panel-body" id="results">
		    <div>Loading...</div>
		  </div>
		</div>
	</div>
</div>
		
<?php $this->load->view('labs_summary_view_footer'); ?>