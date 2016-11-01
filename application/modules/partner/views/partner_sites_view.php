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

<div class="row" id="sites_all">
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

<div class="row" id="partner_sites">
	<div class="col-md-12">
		<div class="panel panel-default">
			<div class="panel-heading">
			  Partner Sites <div class="display_date"></div>
			</div>
		  	<div class="panel-body" id="partnerSites">
		  		<center><div class="loader"></div></center>
		  	</div>
		</div>
	</div>
</div>
<?php $this->load->view('partner_sites_view_footer')?>