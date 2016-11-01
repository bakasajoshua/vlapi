<script type="text/javascript">
	$().ready(function() {
		var partner = <?php echo json_encode($partner_select);?>;
		
		if (partner) {
			part = partner;
		} else {
			part = 1;
		}
		// console.log(part);
		//Selecting the appropriate partner and filling the breadcrum with their data
		// $.get("<?php echo base_url();?>template/breadcrum/"+part+"/"+1, function(data){
	 	//    	$("#breadcrum").html(data);
	 //    });
	    //Fetching data for the above selected partner
		$("#genderGrp").load("<?php echo base_url('charts/nonsuppression/gender_group');?>/"+null+"/"+null+"/"+null+"/"+part);
 		$("#ageGrp").load("<?php echo base_url('charts/nonsuppression/age_group');?>/"+null+"/"+null+"/"+null+"/"+part);
		$("#justification").load("<?php echo base_url('charts/nonsuppression/justification');?>/"+null+"/"+null+"/"+null+"/"+part);
		$("#regimen").load("<?php echo base_url('charts/nonsuppression/regimen');?>/"+null+"/"+null+"/"+null+"/"+part);
		$("#sampleType").load("<?php echo base_url('charts/nonsuppression/sample_type');?>/"+null+"/"+null+"/"+null+"/"+part);
		$("#sites_listing").load("<?php echo base_url('charts/nonsuppression/site_listings');?>/"+null+"/"+null+"/"+part);

		// $(".display_date").load("<?php echo base_url('charts/nonsuppression/display_date'); ?>");

		// fetching the data for a specific partner
		$("select").change(function(){
			part = $(this).val();
			console.log(part);
			// Send the data using post
	        var posting = $.post( "<?php echo base_url();?>template/filter_partner_data", { partner: part } );
	        
	        // Put the results in a div
	        posting.done(function( data ) {
	        	$.get("<?php echo base_url();?>template/breadcrum/"+data+"/"+1, function(data){
	        		$("#breadcrum").html(data);
	        	});
	    //     	$.get("<?php echo base_url();?>template/dates", function(data){
	    //     		obj = $.parseJSON(data);
			
					// if(obj['month'] == "null" || obj['month'] == null){
					// 	obj['month'] = "";
					// }
					// $(".display_date").html("( "+obj['year']+" "+obj['month']+" )");
					
	    //     	});

	        	$("#genderGrp").html("<center><div class='loader'></div></center>"); 
	        	$("#ageGrp").html("<center><div class='loader'></div></center>"); 
				$("#justification").html("<center><div class='loader'></div></center>");
				$("#regimen").html("<center><div class='loader'></div></center>");
				$("#sampleType").html("<center><div class='loader'></div></center>");
				$("#sites_listing").html("<center><div class='loader'></div></center>");
				
				data = "<?php echo json_decode("+data+")?>";

				$("#genderGrp").load("<?php echo base_url('charts/nonsuppression/gender_group');?>/"+null+"/"+null+"/"+null+"/"+data);
		 		$("#ageGrp").load("<?php echo base_url('charts/nonsuppression/age_group');?>/"+null+"/"+null+"/"+null+"/"+data);
				$("#justification").load("<?php echo base_url('charts/nonsuppression/justification');?>/"+null+"/"+null+"/"+null+"/"+data);
				$("#regimen").load("<?php echo base_url('charts/nonsuppression/regimen');?>/"+null+"/"+null+"/"+null+"/"+data);
				$("#sampleType").load("<?php echo base_url('charts/nonsuppression/sample_type');?>/"+null+"/"+null+"/"+null+"/"+data);
				$("#sites_listing").load("<?php echo base_url('charts/nonsuppression/site_listings');?>/"+null+"/"+null+"/"+data);
	        	});
	        });
		});
	
	function date_filter(criteria, id)
 	{
 		$("#genderGrp").html("<div>Loading...</div>"); 
        $("#ageGrp").html("<div>Loading...</div>"); 
		$("#justification").html("<div>Loading...</div>");
		$("#regimen").html("<div>Loading...</div>");
		$("#sampleType").html("<div>Loading...</div>");
		$("#sites_listing").html("<center><div class='loader'>Loading...</div></center>");

 		if (criteria === "monthly") {
 			year = null;
 			month = id;
 		}else {
 			year = id;
 			month = null;
 		}

 		var posting = $.post( '<?php echo base_url();?>template/filter_date_data', { 'year': year, 'month': month } );

 		// Put the results in a div
		posting.done(function( data ) {
			obj = $.parseJSON(data);
			
			if(obj['month'] == "null" || obj['month'] == null){
				obj['month'] = "";
			}
			$(".display_date").html("( "+obj['year']+" "+obj['month']+" )");
			$(".display_range").html("( "+obj['prev_year']+" - "+obj['year']+" )");
			
		});
 		$.get("<?php echo base_url('partner/check_partner_select')?>", function(data) {
 			data = "<?php echo json_decode("+data+")?>";
 			partner = data;
 			// console.log(partner);
	 		$("#genderGrp").load("<?php echo base_url('charts/nonsuppression/gender_group');?>/"+year+"/"+month+"/"+null+"/"+partner);
	 		$("#ageGrp").load("<?php echo base_url('charts/nonsuppression/age_group');?>/"+year+"/"+month+"/"+null+"/"+partner);
			$("#justification").load("<?php echo base_url('charts/nonsuppression/justification');?>/"+year+"/"+month+"/"+null+"/"+partner);
			$("#regimen").load("<?php echo base_url('charts/nonsuppression/regimen');?>/"+year+"/"+month+"/"+null+"/"+partner);
			$("#sampleType").load("<?php echo base_url('charts/nonsuppression/sample_type');?>/"+year+"/"+month+"/"+null+"/"+partner);
			$("#sites_listing").load("<?php echo base_url('charts/nonsuppression/site_listings');?>/"+year+"/"+month+"/"+null);
		});
	}
</script>