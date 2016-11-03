<div class="panel-body">
	<div id="vlOutcomes_pie" style="height: 350px;"></div>
</div>
<div>
	<ul>
		<?php echo $outcomes['ul'];?>
	</ul>
</div>

<script type="text/javascript">
	// $().ready(function() {
	// 	$.get("<?php //echo base_url('charts/summaries/suppressiondata');?>", function(data) {

	// 	});
	// 	$("#samples").load("<?php //echo base_url('charts/summaries/sample_types'); ?>");
	// });

	$(function () {
				$('#vlOutcomes_pie').highcharts({
			        chart: {
                plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: false,
                type: 'pie'
		            },
		            title: {
		                text: ''
		            },
		            tooltip: {
		                pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
		            },
		            plotOptions: {
		                pie: {
		                    allowPointSelect: true,
		                    cursor: 'pointer',
		                    dataLabels: {
		                        enabled: false
		                    },
		                    showInLegend: true
		                }
		            },
		            series: [<?php echo json_encode($outcomes['vl_outcomes']); ?>]

		        });
		    });
</script>



