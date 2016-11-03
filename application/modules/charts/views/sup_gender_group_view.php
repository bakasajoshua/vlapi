
<div class="col-md-12">
    <div class="panel panel-primary">
        <div class="panel-body">
            <div id="genderGroup_bar"></div>
        </div>
    </div>
</div>

<script type="text/javascript">
	$(function () {
    $('#genderGroup_bar').highcharts({
        chart: {
            type: 'bar'
        },
        title: {
            text: ''
        },
        xAxis: {
            categories: <?php echo json_encode($suppressions['categories']); ?>,
            title: {
                text: null
            }
        },
        yAxis: {
            min: 0,
            title: {
                text: '',
                align: 'high'
            },
            labels: {
                overflow: 'justify'
            }
        },
        tooltip: {
            valueSuffix: ''
        },
        plotOptions: {
            bar: {
                dataLabels: {
                    enabled: true
                }
            }
        },
        legend: {
            enabled: false
        },
        credits: {
            enabled: false
        },
        series: [<?php echo json_encode($suppressions['gnd_gr']); ?>]
    });
});
</script>