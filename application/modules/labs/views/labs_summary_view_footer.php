<script type="text/javascript">
	$().ready(function() {
		$("#rejected").load("<?php echo base_url();?>charts/labs/rejection_trends");
		$("#test_trends").load("<?php echo base_url('charts/labs/testing_trends');?>");
		$("#samples").load("<?php echo base_url();?>charts/labs/sample_types");
		$("#ttime").load("<?php echo base_url();?>charts/labs/turn_around_time");
		$("#results").load("<?php echo base_url();?>charts/labs/results_outcome");

		$(".display_date").load("<?php echo base_url('charts/labs/display_date'); ?>");
	});

	function date_filter(criteria, id)
 	{
 		if (criteria === "monthly") {
 			year = null;
 			month = id;
 		}else {
 			year = id;
 			month = null;
 		}

 		var posting = $.post( '<?php echo base_url();?>summary/set_filter_date', { 'year': year, 'month': month } );

 		// Put the results in a div
		posting.done(function( data ) {
			obj = $.parseJSON(data);
			
			if(obj['month'] == "null" || obj['month'] == null){
				obj['month'] = "";
			}
			$(".display_date").html("( "+obj['year']+" "+obj['month']+" )");
			$(".display_range").html("( "+obj['prev_year']+" - "+obj['year']+" )");
			
		});
 		
 		
 		$("#rejected").html("<div>Loading...</div>"); 
		$("#test_trends").html("<div>Loading...</div>");
		$("#samples").html("<div>Loading...</div>");
		$("#ttime").html("<div>Loading...</div>");
		$("#results").html("<div>Loading...</div>");

		$("#rejected").load("<?php echo base_url();?>charts/labs/rejection_trends/"+year);
		$("#test_trends").load("<?php echo base_url('charts/labs/testing_trends');?>/"+year);
		$("#ttime").load("<?php echo base_url();?>charts/labs/turn_around_time/"+year+"/"+month);
		$("#samples").load("<?php echo base_url();?>charts/labs/sample_types/"+year+"/"+month);
		$("#results").load("<?php echo base_url();?>charts/labs/results_outcome/"+year+"/"+month);
	}
</script>