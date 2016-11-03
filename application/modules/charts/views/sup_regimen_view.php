<div class="col-md-12">
	<div class="panel panel-primary">
		<div class="panel-body">
			<div id="regimen_pie"></div>
		</div>
	</div>
</div>

<script type="text/javascript">
	$(function(){
				$('#regimen_pie').highcharts({
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
			            series: [<?php echo json_encode($suppressions['regimen']); ?>]
			        });
		    });
</script>