
<div class="col-md-12">
	<div class="panel panel-primary">
		<div class="panel-body">
			<div id="agr_group_chart"></div>
		</div>
	</div>
</div>

<script type="text/javascript">
	$(function(){
				$('#agr_group_chart').highcharts({
				    	chart: {
			            type: 'column'
			        },
			        title: {
			            text: ''
			        },
			       xAxis: {
			            categories: <?php echo json_encode($suppressions['categories']); ?>,
			            crosshair: true
			        },
			        yAxis: {
			            min: 0,
			            title: {
			                text: 'Number'
			            }
			        },
			        tooltip: {
			            headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
			            pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
			                '<td style="padding:0"><b>{point.y:.1f}</b></td></tr>',
			            footerFormat: '</table>',
			            shared: true,
			            useHTML: true
			        },
			        plotOptions: {
			            column: {
			                pointPadding: 0.2,
			                borderWidth: 0
			            }
			        },
			        series: [<?php echo json_encode($suppressions['age_gr']); ?>]
			    });
			});
</script>