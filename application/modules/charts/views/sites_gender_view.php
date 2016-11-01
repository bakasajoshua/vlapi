<div id="sitesgender_column" style="height:450px;">
    
</div>
<script type="text/javascript">
    $(function () {
        $('#sitesgender_column').highcharts({
            chart: {
                type: 'column'
            },
            title: {
                text: null
            },
            subtitle: {
                text: null
            },
            xAxis: {
                categories: <?php echo json_encode($outcomes['categories']);?>,
                crosshair: true
            },
            yAxis: {
                min: 0,
                title: {
                    text: 'Tests'
                }
            },
            tooltip: {
                headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
                pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                    '<td style="padding:0"><b>{point.y:.1f} </b></td></tr>',
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
            // color: ['#1BA39C'],
            series: [<?php echo json_encode($outcomes['Gnd']);?>]
        });
    });
</script>
