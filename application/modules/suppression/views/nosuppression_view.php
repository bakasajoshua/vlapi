<?php?>
<style type="text/css">
	.navbar-inverse {
		border-radius: 0px;
	}
	.navbar .container-fluid .navbar-header .navbar-collapse .collapse .navbar-responsive-collapse .nav .navbar-nav {
		border-radius: 0px;
	}
	.panel {
		border-radius: 0px;
	}
	.panel-primary {
		border-radius: 0px;
	}
	.panel-heading {
		border-radius: 0px;
	}
	.list-group-item{
		margin-bottom: 0.1em;
	}
	.btn {
		margin: 0px;
	}
	.alert {
		margin-bottom: 0px;
		padding: 8px;
	}
	.filter {
		margin: 2px 20px;
	}
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
<div id="notification" style="margin-bottom: 1em;background-color:#E4F1FE;">
  	Not Suppressed: XXXX
</div>
<div class="row">
	<div class="col-md-7">
		<!-- Begining of the age gender suppresion failures -->
		<div class="row">
			<div class="col-md-7">
				<div class="panel panel-default">
					<div class="panel-heading">
					  By Gender <div class="display_date"></div>
					</div>
				  	<div class="panel-body">
				  	<div class="row" id="genderGrp">
				  		<div>Loading...</div>
				  	</div>
				  	<!-- -->
				  </div>
				</div>
			</div>
			<div class="col-md-5">
				<div class="panel panel-default">
					<div class="panel-heading">
					  By Age <div class="display_date"></div>
					</div>
				  	<div class="panel-body">
				  	<div class="row" id="ageGrp">
				  		<div>Loading...</div>
				  	</div>
				  	<!-- -->
				  </div>
				</div>
			</div>
		</div>
		<!-- End of the age gender suppresion failures -->
		
		<div class="row">
			<div class="col-md-7">
				<!-- Begining of Justification -->
				<div class="panel panel-default">
					<div class="panel-heading">
						By Justification <div class="display_date"></div>
					</div>
					  <div class="panel-body">
					  	<div class="row" id="justification">
					  		<div>Loading...</div>
					  		
					  	</div>
					 </div>
				</div>
				<!-- End of Justification -->
			</div>
			<div class="col-md-5">
				<!-- Begining of Sample Types -->
				<div class="panel panel-default">
						<div class="panel-heading">
							By Sample Types <div class="display_date"></div>
						</div>
					  <div class="panel-body">
					  	<div class="row" id="sampleType">
					  		<div>Loading...</div>
					  	</div>
					 </div>
				</div>
				<!-- End of Sample Types -->
			</div>
		</div>
		
		
		
	</div>
	<div class="col-md-5">
		<div class="row">
			<div class="col-md-6">
				<div class="panel panel-default">
				  <div class="panel-heading">
				  	Counties <div class="display_date"></div>
				  </div>
				  <div class="panel-body" id="countys">
				    Loading...
				  </div>
				</div>
				
			</div>

			<div class="col-md-6">
				<div class="panel panel-default">
				  <div class="panel-heading">
				  	Patners <div class="display_date"></div>
				  </div>
				  <div class="panel-body" id="partners">
				    <div>Loading...</div>
				  </div>
				</div>
		
			</div>
		</div>
		<!-- Begining of Regimen -->
		<div class="panel panel-default">
				<div class="panel-heading">
					By Regimen <div class="display_date"></div>
				</div>
			  <div class="panel-body">
			  	<div class="row" id="regimen">
			  		<div>Loading...</div>
			  	</div>
			 </div>
		</div>
		<!-- End of Regimen -->
		
	</div>
</div>
<?php $this->load->view('nosuppression_view_footer')?>