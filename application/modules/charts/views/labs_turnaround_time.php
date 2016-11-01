<style type="text/css">
    .title-name {
        color: blue;
    }
    .key {
        font-size: 11px;
        margin-top: 0.5em;
    }
    .cr {
        background-color: rgba(255,0,0,0.5);
    }
    .rp {
        background-color: rgba(255,255,0,0.5);
    }
    .pd {
        background-color: rgba(0,255,0,0.5);
    }
    .cd {
        width: 0px;
        height: 0px;
        border-left: 8px solid transparent;
        border-right: 8px solid transparent;
        border-top: 8px solid black;
    }
</style>
<div class="row">
	<div class="col-md-6" id="container1" style="height:100px;"></div>
	<div class="col-md-6" id="container2" style="height:100px;"></div>
	<div class="col-md-6" id="container3" style="height:100px;"></div>
	<div class="col-md-6" id="container4" style="height:100px;"></div>
	<div class="col-md-6" id="container5" style="height:100px;"></div>
	<div class="col-md-6" id="container6" style="height:100px;"></div>
	<div class="col-md-6" id="container7" style="height:100px;"></div>
	<div class="col-md-6" id="container8" style="height:100px;"></div>
	<div class="col-md-6" id="container9" style="height:100px;"></div>
    <div class="col-md-6" style="border: 1px solid black">
        <div class="title-name">Key</div>
            <div class="row">
                <div class="col-md-6">
                    <div class="key cr"><center>Collection Receipt (C-R)</center></div>
                    <div class="key rp"><center>Receipt to Processing (R-P)</center></div>
                </div>
                <div class="col-md-6">
                    <div class="key pd"><center>Processing Dispatch (P-D)</center></div>
                    <div class="key"><center><div class="cd"></div>Collection Dispatch (C-D)</center></div>
                </div>
            </div>
    </div>
</div>


<script type="text/javascript">
	$(function () {

    /**
     * Highcharts Linear-Gauge series plugin
     */
    (function (H) {
        var defaultPlotOptions = H.getOptions().plotOptions,
            columnType = H.seriesTypes.column,
            wrap = H.wrap,
            each = H.each;

        defaultPlotOptions.lineargauge = H.merge(defaultPlotOptions.column, {});
        H.seriesTypes.lineargauge = H.extendClass(columnType, {
            type: 'lineargauge',
            //inverted: true,
            setVisible: function () {
                columnType.prototype.setVisible.apply(this, arguments);
                if (this.markLine) {
                    this.markLine[this.visible ? 'show' : 'hide']();
                }
            },
            drawPoints: function () {
                // Draw the Column like always
                columnType.prototype.drawPoints.apply(this, arguments);

                // Add a Marker
                var series = this,
                    chart = this.chart,
                    inverted = chart.inverted,
                    xAxis = this.xAxis,
                    yAxis = this.yAxis,
                    point = this.points[0], // we know there is only 1 point
                    markLine = this.markLine,
                    ani = markLine ? 'animate' : 'attr';

                // Hide column
                point.graphic.hide();

                if (!markLine) {
                    var path = inverted ? ['M', 0, 0, 'L', -5, -5, 'L', 5, -5, 'L', 0, 0, 'L', 0, 0 + xAxis.len] : ['M', 0, 0, 'L', -5, -5, 'L', -5, 5,'L', 0, 0, 'L', xAxis.len, 0];
                    markLine = this.markLine = chart.renderer.path(path)
                        .attr({
                            'fill': series.color,
                            'stroke': series.color,
                            'stroke-width': 1
                        }).add();
                }
                markLine[ani]({
                    translateX: inverted ? xAxis.left + yAxis.translate(point.y) : xAxis.left,
                    translateY: inverted ? xAxis.top : yAxis.top + yAxis.len -  yAxis.translate(point.y)
                });
            }
        });
    }(Highcharts));

    $('#container1').highcharts({
        chart: {
            type: 'lineargauge',
            inverted: true
        },
        title: {
            text: 'KEMRI Nairobi Lab'
        },
        xAxis: {
            lineColor: '#C0C0C0',
            labels: {
                enabled: false
            },
            tickLength: 0
        },
        yAxis: {
            min: 0,
            max: <?php echo json_encode($trends['kemri_nairobi_lab']['tat3']);?>,
            tickLength: 5,
            tickWidth: 1,
            tickColor: '#C0C0C0',
            gridLineColor: '#C0C0C0',
            gridLineWidth: 1,
            minorTickInterval: 5,
            minorTickWidth: 1,
            minorTickLength: 5,
            minorGridLineWidth: 0,

            title: null,
            labels: {
                format: '{value}'
            },
            plotBands: [{
                from: 0,
                to: <?php echo json_encode($trends['kemri_nairobi_lab']['tat1']);?>,
                color: 'rgba(255,0,0,0.5)'
            }, {
                from: <?php echo json_encode($trends['kemri_nairobi_lab']['tat1']);?>,
                to: <?php echo json_encode($trends['kemri_nairobi_lab']['tat2']);?>,
                color: 'rgba(255,255,0,0.5)'
            }, {
                from: <?php echo json_encode($trends['kemri_nairobi_lab']['tat2']);?>,
                to: <?php echo json_encode($trends['kemri_nairobi_lab']['tat3']);?>,
                color: 'rgba(0,255,0,0.5)'
            }]
        },
        legend: {
            enabled: false
        },

        series: [{
            data: [92],
            color: '#000000',
            dataLabels: {
                enabled: true,
                align: 'center',
                format: '{point.y}',
                y: 10
            }
        }]

    },
     // Add some life
    function (chart) {
        Highcharts.each(chart.series, function (serie) {
            var point = serie.points[0];
            point.update(<?php echo json_encode($trends['kemri_nairobi_lab']['tat4']);?>);
        });

    });
});

$(function () {

    /**
     * Highcharts Linear-Gauge series plugin
     */
    (function (H) {
        var defaultPlotOptions = H.getOptions().plotOptions,
            columnType = H.seriesTypes.column,
            wrap = H.wrap,
            each = H.each;

        defaultPlotOptions.lineargauge = H.merge(defaultPlotOptions.column, {});
        H.seriesTypes.lineargauge = H.extendClass(columnType, {
            type: 'lineargauge',
            //inverted: true,
            setVisible: function () {
                columnType.prototype.setVisible.apply(this, arguments);
                if (this.markLine) {
                    this.markLine[this.visible ? 'show' : 'hide']();
                }
            },
            drawPoints: function () {
                // Draw the Column like always
                columnType.prototype.drawPoints.apply(this, arguments);

                // Add a Marker
                var series = this,
                    chart = this.chart,
                    inverted = chart.inverted,
                    xAxis = this.xAxis,
                    yAxis = this.yAxis,
                    point = this.points[0], // we know there is only 1 point
                    markLine = this.markLine,
                    ani = markLine ? 'animate' : 'attr';

                // Hide column
                point.graphic.hide();

                if (!markLine) {
                    var path = inverted ? ['M', 0, 0, 'L', -5, -5, 'L', 5, -5, 'L', 0, 0, 'L', 0, 0 + xAxis.len] : ['M', 0, 0, 'L', -5, -5, 'L', -5, 5,'L', 0, 0, 'L', xAxis.len, 0];
                    markLine = this.markLine = chart.renderer.path(path)
                        .attr({
                            'fill': series.color,
                            'stroke': series.color,
                            'stroke-width': 1
                        }).add();
                }
                markLine[ani]({
                    translateX: inverted ? xAxis.left + yAxis.translate(point.y) : xAxis.left,
                    translateY: inverted ? xAxis.top : yAxis.top + yAxis.len -  yAxis.translate(point.y)
                });
            }
        });
    }(Highcharts));
$('#container2').highcharts({
        chart: {
            type: 'lineargauge',
            inverted: true
        },
        title: {
            text: 'Kisumu Lab'
        },
        xAxis: {
            lineColor: '#C0C0C0',
            labels: {
                enabled: false
            },
            tickLength: 0
        },
        yAxis: {
            min: 0,
            max: <?php echo json_encode($trends['kisumu_lab']['tat3']);?>,
            tickLength: 5,
            tickWidth: 1,
            tickColor: '#C0C0C0',
            gridLineColor: '#C0C0C0',
            gridLineWidth: 1,
            minorTickInterval: 5,
            minorTickWidth: 1,
            minorTickLength: 5,
            minorGridLineWidth: 0,

            title: null,
            labels: {
                format: '{value}'
            },
            plotBands: [{
                from: 0,
                to: <?php echo json_encode($trends['kisumu_lab']['tat1']);?>,
                color: 'rgba(255,0,0,0.5)'
            }, {
                from: <?php echo json_encode($trends['kisumu_lab']['tat1']);?>,
                to: <?php echo json_encode($trends['kisumu_lab']['tat2']);?>,
                color: 'rgba(255,255,0,0.5)'
            }, {
                from: <?php echo json_encode($trends['kisumu_lab']['tat2']);?>,
                to: <?php echo json_encode($trends['kisumu_lab']['tat3']);?>,
                color: 'rgba(0,255,0,0.5)'
            }]
        },
        legend: {
            enabled: false
        },

        series: [{
            data: [92],
            color: '#000000',
            dataLabels: {
                enabled: true,
                align: 'center',
                format: '{point.y}',
                y: 10
            }
        }]

    }, // Add some life
    function (chart) {
        Highcharts.each(chart.series, function (serie) {
            var point = serie.points[0];
			point.update(<?php echo json_encode($trends['kisumu_lab']['tat4']);?>);
        });
    });
});
$(function () {

    /**
     * Highcharts Linear-Gauge series plugin
     */
    (function (H) {
        var defaultPlotOptions = H.getOptions().plotOptions,
            columnType = H.seriesTypes.column,
            wrap = H.wrap,
            each = H.each;

        defaultPlotOptions.lineargauge = H.merge(defaultPlotOptions.column, {});
        H.seriesTypes.lineargauge = H.extendClass(columnType, {
            type: 'lineargauge',
            //inverted: true,
            setVisible: function () {
                columnType.prototype.setVisible.apply(this, arguments);
                if (this.markLine) {
                    this.markLine[this.visible ? 'show' : 'hide']();
                }
            },
            drawPoints: function () {
                // Draw the Column like always
                columnType.prototype.drawPoints.apply(this, arguments);

                // Add a Marker
                var series = this,
                    chart = this.chart,
                    inverted = chart.inverted,
                    xAxis = this.xAxis,
                    yAxis = this.yAxis,
                    point = this.points[0], // we know there is only 1 point
                    markLine = this.markLine,
                    ani = markLine ? 'animate' : 'attr';

                // Hide column
                point.graphic.hide();

                if (!markLine) {
                    var path = inverted ? ['M', 0, 0, 'L', -5, -5, 'L', 5, -5, 'L', 0, 0, 'L', 0, 0 + xAxis.len] : ['M', 0, 0, 'L', -5, -5, 'L', -5, 5,'L', 0, 0, 'L', xAxis.len, 0];
                    markLine = this.markLine = chart.renderer.path(path)
                        .attr({
                            'fill': series.color,
                            'stroke': series.color,
                            'stroke-width': 1
                        }).add();
                }
                markLine[ani]({
                    translateX: inverted ? xAxis.left + yAxis.translate(point.y) : xAxis.left,
                    translateY: inverted ? xAxis.top : yAxis.top + yAxis.len -  yAxis.translate(point.y)
                });
            }
        });
    }(Highcharts));
$('#container3').highcharts({
        chart: {
            type: 'lineargauge',
            inverted: true
        },
        title: {
            text: 'Busia Lab'
        },
        xAxis: {
            lineColor: '#C0C0C0',
            labels: {
                enabled: false
            },
            tickLength: 0
        },
        yAxis: {
            min: 0,
            max: <?php echo json_encode($trends['busia_lab']['tat3']);?>,
            tickLength: 5,
            tickWidth: 1,
            tickColor: '#C0C0C0',
            gridLineColor: '#C0C0C0',
            gridLineWidth: 1,
            minorTickInterval: 5,
            minorTickWidth: 1,
            minorTickLength: 5,
            minorGridLineWidth: 0,

            title: null,
            labels: {
                format: '{value}'
            },
            plotBands: [{
                from: 0,
                to: <?php echo json_encode($trends['busia_lab']['tat1']);?>,
                color: 'rgba(255,0,0,0.5)'
            }, {
                from: <?php echo json_encode($trends['busia_lab']['tat1']);?>,
                to: <?php echo json_encode($trends['busia_lab']['tat2']);?>,
                color: 'rgba(255,255,0,0.5)'
            }, {
                from: <?php echo json_encode($trends['busia_lab']['tat2']);?>,
                to: <?php echo json_encode($trends['busia_lab']['tat3']);?>,
                color: 'rgba(0,255,0,0.5)'
            }]
        },
        legend: {
            enabled: false
        },

        series: [{
            data: [92],
            color: '#000000',
            dataLabels: {
                enabled: true,
                align: 'center',
                format: '{point.y}',
                y: 10
            }
        }]

    }, // Add some life
    function (chart) {
        Highcharts.each(chart.series, function (serie) {
            var point = serie.points[0];
            point.update(<?php echo json_encode($trends['busia_lab']['tat4']);?>);
        });
    });
});

$(function () {

    /**
     * Highcharts Linear-Gauge series plugin
     */
    (function (H) {
        var defaultPlotOptions = H.getOptions().plotOptions,
            columnType = H.seriesTypes.column,
            wrap = H.wrap,
            each = H.each;

        defaultPlotOptions.lineargauge = H.merge(defaultPlotOptions.column, {});
        H.seriesTypes.lineargauge = H.extendClass(columnType, {
            type: 'lineargauge',
            //inverted: true,
            setVisible: function () {
                columnType.prototype.setVisible.apply(this, arguments);
                if (this.markLine) {
                    this.markLine[this.visible ? 'show' : 'hide']();
                }
            },
            drawPoints: function () {
                // Draw the Column like always
                columnType.prototype.drawPoints.apply(this, arguments);

                // Add a Marker
                var series = this,
                    chart = this.chart,
                    inverted = chart.inverted,
                    xAxis = this.xAxis,
                    yAxis = this.yAxis,
                    point = this.points[0], // we know there is only 1 point
                    markLine = this.markLine,
                    ani = markLine ? 'animate' : 'attr';

                // Hide column
                point.graphic.hide();

                if (!markLine) {
                    var path = inverted ? ['M', 0, 0, 'L', -5, -5, 'L', 5, -5, 'L', 0, 0, 'L', 0, 0 + xAxis.len] : ['M', 0, 0, 'L', -5, -5, 'L', -5, 5,'L', 0, 0, 'L', xAxis.len, 0];
                    markLine = this.markLine = chart.renderer.path(path)
                        .attr({
                            'fill': series.color,
                            'stroke': series.color,
                            'stroke-width': 1
                        }).add();
                }
                markLine[ani]({
                    translateX: inverted ? xAxis.left + yAxis.translate(point.y) : xAxis.left,
                    translateY: inverted ? xAxis.top : yAxis.top + yAxis.len -  yAxis.translate(point.y)
                });
            }
        });
    }(Highcharts));
$('#container4').highcharts({
        chart: {
            type: 'lineargauge',
            inverted: true
        },
        title: {
            text: 'Kericho Lab'
        },
        xAxis: {
            lineColor: '#C0C0C0',
            labels: {
                enabled: false
            },
            tickLength: 0
        },
        yAxis: {
            min: 0,
            max: <?php echo json_encode($trends['kericho_lab']['tat3']);?>,
            tickLength: 5,
            tickWidth: 1,
            tickColor: '#C0C0C0',
            gridLineColor: '#C0C0C0',
            gridLineWidth: 1,
            minorTickInterval: 5,
            minorTickWidth: 1,
            minorTickLength: 5,
            minorGridLineWidth: 0,

            title: null,
            labels: {
                format: '{value}'
            },
            plotBands: [{
                from: 0,
                to: <?php echo json_encode($trends['kericho_lab']['tat1']);?>,
                color: 'rgba(255,0,0,0.5)'
            }, {
                from: <?php echo json_encode($trends['kericho_lab']['tat1']);?>,
                to: <?php echo json_encode($trends['kericho_lab']['tat2']);?>,
                color: 'rgba(255,255,0,0.5)'
            }, {
                from: <?php echo json_encode($trends['kericho_lab']['tat2']);?>,
                to: <?php echo json_encode($trends['kericho_lab']['tat3']);?>,
                color: 'rgba(0,255,0,0.5)'
            }]
        },
        legend: {
            enabled: false
        },

        series: [{
            data: [92],
            color: '#000000',
            dataLabels: {
                enabled: true,
                align: 'center',
                format: '{point.y}',
                y: 10
            }
        }]

    }, // Add some life
    function (chart) {
        setInterval(function () {
            Highcharts.each(chart.series, function (serie) {
                var point = serie.points[0];
                point.update(<?php echo json_encode($trends['kericho_lab']['tat4']);?>);
            });
        }, 2000);

    });
});
$(function () {

    /**
     * Highcharts Linear-Gauge series plugin
     */
    (function (H) {
        var defaultPlotOptions = H.getOptions().plotOptions,
            columnType = H.seriesTypes.column,
            wrap = H.wrap,
            each = H.each;

        defaultPlotOptions.lineargauge = H.merge(defaultPlotOptions.column, {});
        H.seriesTypes.lineargauge = H.extendClass(columnType, {
            type: 'lineargauge',
            //inverted: true,
            setVisible: function () {
                columnType.prototype.setVisible.apply(this, arguments);
                if (this.markLine) {
                    this.markLine[this.visible ? 'show' : 'hide']();
                }
            },
            drawPoints: function () {
                // Draw the Column like always
                columnType.prototype.drawPoints.apply(this, arguments);

                // Add a Marker
                var series = this,
                    chart = this.chart,
                    inverted = chart.inverted,
                    xAxis = this.xAxis,
                    yAxis = this.yAxis,
                    point = this.points[0], // we know there is only 1 point
                    markLine = this.markLine,
                    ani = markLine ? 'animate' : 'attr';

                // Hide column
                point.graphic.hide();

                if (!markLine) {
                    var path = inverted ? ['M', 0, 0, 'L', -5, -5, 'L', 5, -5, 'L', 0, 0, 'L', 0, 0 + xAxis.len] : ['M', 0, 0, 'L', -5, -5, 'L', -5, 5,'L', 0, 0, 'L', xAxis.len, 0];
                    markLine = this.markLine = chart.renderer.path(path)
                        .attr({
                            'fill': series.color,
                            'stroke': series.color,
                            'stroke-width': 1
                        }).add();
                }
                markLine[ani]({
                    translateX: inverted ? xAxis.left + yAxis.translate(point.y) : xAxis.left,
                    translateY: inverted ? xAxis.top : yAxis.top + yAxis.len -  yAxis.translate(point.y)
                });
            }
        });
    }(Highcharts));
$('#container5').highcharts({
        chart: {
            type: 'lineargauge',
            inverted: true
        },
        title: {
            text: 'Eldoret Lab'
        },
        xAxis: {
            lineColor: '#C0C0C0',
            labels: {
                enabled: false
            },
            tickLength: 0
        },
        yAxis: {
            min: 0,
            max: <?php echo json_encode($trends['eldoret_lab']['tat3']);?>,
            tickLength: 5,
            tickWidth: 1,
            tickColor: '#C0C0C0',
            gridLineColor: '#C0C0C0',
            gridLineWidth: 1,
            minorTickInterval: 5,
            minorTickWidth: 1,
            minorTickLength: 5,
            minorGridLineWidth: 0,

            title: null,
            labels: {
                format: '{value}'
            },
            plotBands: [{
                from: 0,
                to: <?php echo json_encode($trends['eldoret_lab']['tat1']);?>,
                color: 'rgba(255,0,0,0.5)'
            }, {
                from: <?php echo json_encode($trends['eldoret_lab']['tat1']);?>,
                to: <?php echo json_encode($trends['eldoret_lab']['tat2']);?>,
                color: 'rgba(255,255,0,0.5)'
            }, {
                from: <?php echo json_encode($trends['eldoret_lab']['tat2']);?>,
                to: <?php echo json_encode($trends['eldoret_lab']['tat3']);?>,
                color: 'rgba(0,255,0,0.5)'
            }]
        },
        legend: {
            enabled: false
        },

        series: [{
            data: [92],
            color: '#000000',
            dataLabels: {
                enabled: true,
                align: 'center',
                format: '{point.y}',
                y: 10
            }
        }]

    }, // Add some life
    function (chart) {
        Highcharts.each(chart.series, function (serie) {
            var point = serie.points[0];
            point.update(<?php echo json_encode($trends['eldoret_lab']['tat4']);?>);
        });
    });
});
$(function () {

    /**
     * Highcharts Linear-Gauge series plugin
     */
    (function (H) {
        var defaultPlotOptions = H.getOptions().plotOptions,
            columnType = H.seriesTypes.column,
            wrap = H.wrap,
            each = H.each;

        defaultPlotOptions.lineargauge = H.merge(defaultPlotOptions.column, {});
        H.seriesTypes.lineargauge = H.extendClass(columnType, {
            type: 'lineargauge',
            //inverted: true,
            setVisible: function () {
                columnType.prototype.setVisible.apply(this, arguments);
                if (this.markLine) {
                    this.markLine[this.visible ? 'show' : 'hide']();
                }
            },
            drawPoints: function () {
                // Draw the Column like always
                columnType.prototype.drawPoints.apply(this, arguments);

                // Add a Marker
                var series = this,
                    chart = this.chart,
                    inverted = chart.inverted,
                    xAxis = this.xAxis,
                    yAxis = this.yAxis,
                    point = this.points[0], // we know there is only 1 point
                    markLine = this.markLine,
                    ani = markLine ? 'animate' : 'attr';

                // Hide column
                point.graphic.hide();

                if (!markLine) {
                    var path = inverted ? ['M', 0, 0, 'L', -5, -5, 'L', 5, -5, 'L', 0, 0, 'L', 0, 0 + xAxis.len] : ['M', 0, 0, 'L', -5, -5, 'L', -5, 5,'L', 0, 0, 'L', xAxis.len, 0];
                    markLine = this.markLine = chart.renderer.path(path)
                        .attr({
                            'fill': series.color,
                            'stroke': series.color,
                            'stroke-width': 1
                        }).add();
                }
                markLine[ani]({
                    translateX: inverted ? xAxis.left + yAxis.translate(point.y) : xAxis.left,
                    translateY: inverted ? xAxis.top : yAxis.top + yAxis.len -  yAxis.translate(point.y)
                });
            }
        });
    }(Highcharts));
$('#container6').highcharts({
        chart: {
            type: 'lineargauge',
            inverted: true
        },
        title: {
            text: 'Coast Lab'
        },
        xAxis: {
            lineColor: '#C0C0C0',
            labels: {
                enabled: false
            },
            tickLength: 0
        },
        yAxis: {
            min: 0,
            max: <?php echo json_encode($trends['coast_lab']['tat3']);?>,
            tickLength: 5,
            tickWidth: 1,
            tickColor: '#C0C0C0',
            gridLineColor: '#C0C0C0',
            gridLineWidth: 1,
            minorTickInterval: 5,
            minorTickWidth: 1,
            minorTickLength: 5,
            minorGridLineWidth: 0,

            title: null,
            labels: {
                format: '{value}'
            },
            plotBands: [{
                from: 0,
                to: <?php echo json_encode($trends['coast_lab']['tat1']);?>,
                color: 'rgba(255,0,0,0.5)'
            }, {
                from: <?php echo json_encode($trends['coast_lab']['tat1']);?>,
                to: <?php echo json_encode($trends['coast_lab']['tat2']);?>,
                color: 'rgba(255,255,0,0.5)'
            }, {
                from: <?php echo json_encode($trends['coast_lab']['tat2']);?>,
                to: <?php echo json_encode($trends['coast_lab']['tat3']);?>,
                color: 'rgba(0,255,0,0.5)'
            }]
        },
        legend: {
            enabled: false
        },

        series: [{
            data: [92],
            color: '#000000',
            dataLabels: {
                enabled: true,
                align: 'center',
                format: '{point.y}',
                y: 10
            }
        }]

    }, // Add some life
    function (chart) {
        Highcharts.each(chart.series, function (serie) {
            var point = serie.points[0];
            point.update(<?php echo json_encode($trends['coast_lab']['tat4']);?>);
        });

    });
});
$(function () {

    /**
     * Highcharts Linear-Gauge series plugin
     */
    (function (H) {
        var defaultPlotOptions = H.getOptions().plotOptions,
            columnType = H.seriesTypes.column,
            wrap = H.wrap,
            each = H.each;

        defaultPlotOptions.lineargauge = H.merge(defaultPlotOptions.column, {});
        H.seriesTypes.lineargauge = H.extendClass(columnType, {
            type: 'lineargauge',
            //inverted: true,
            setVisible: function () {
                columnType.prototype.setVisible.apply(this, arguments);
                if (this.markLine) {
                    this.markLine[this.visible ? 'show' : 'hide']();
                }
            },
            drawPoints: function () {
                // Draw the Column like always
                columnType.prototype.drawPoints.apply(this, arguments);

                // Add a Marker
                var series = this,
                    chart = this.chart,
                    inverted = chart.inverted,
                    xAxis = this.xAxis,
                    yAxis = this.yAxis,
                    point = this.points[0], // we know there is only 1 point
                    markLine = this.markLine,
                    ani = markLine ? 'animate' : 'attr';

                // Hide column
                point.graphic.hide();

                if (!markLine) {
                    var path = inverted ? ['M', 0, 0, 'L', -5, -5, 'L', 5, -5, 'L', 0, 0, 'L', 0, 0 + xAxis.len] : ['M', 0, 0, 'L', -5, -5, 'L', -5, 5,'L', 0, 0, 'L', xAxis.len, 0];
                    markLine = this.markLine = chart.renderer.path(path)
                        .attr({
                            'fill': series.color,
                            'stroke': series.color,
                            'stroke-width': 1
                        }).add();
                }
                markLine[ani]({
                    translateX: inverted ? xAxis.left + yAxis.translate(point.y) : xAxis.left,
                    translateY: inverted ? xAxis.top : yAxis.top + yAxis.len -  yAxis.translate(point.y)
                });
            }
        });
    }(Highcharts));
$('#container7').highcharts({
        chart: {
            type: 'lineargauge',
            inverted: true
        },
        title: {
            text: 'NHRL Nairobi'
        },
        xAxis: {
            lineColor: '#C0C0C0',
            labels: {
                enabled: false
            },
            tickLength: 0
        },
        yAxis: {
            min: 0,
            max: <?php echo json_encode($trends['nhrl_nairobi']['tat3']);?>,
            tickLength: 5,
            tickWidth: 1,
            tickColor: '#C0C0C0',
            gridLineColor: '#C0C0C0',
            gridLineWidth: 1,
            minorTickInterval: 5,
            minorTickWidth: 1,
            minorTickLength: 5,
            minorGridLineWidth: 0,

            title: null,
            labels: {
                format: '{value}'
            },
            plotBands: [{
                from: 0,
                to: <?php echo json_encode($trends['nhrl_nairobi']['tat1']);?>,
                color: 'rgba(255,0,0,0.5)'
            }, {
                from: <?php echo json_encode($trends['nhrl_nairobi']['tat1']);?>,
                to: <?php echo json_encode($trends['nhrl_nairobi']['tat2']);?>,
                color: 'rgba(255,255,0,0.5)'
            }, {
                from: <?php echo json_encode($trends['nhrl_nairobi']['tat2']);?>,
                to: <?php echo json_encode($trends['nhrl_nairobi']['tat3']);?>,
                color: 'rgba(0,255,0,0.5)'
            }]
        },
        legend: {
            enabled: false
        },

        series: [{
            data: [92],
            color: '#000000',
            dataLabels: {
                enabled: true,
                align: 'center',
                format: '{point.y}',
                y: 10
            }
        }]

    }, // Add some life
    function (chart) {
        Highcharts.each(chart.series, function (serie) {
            var point = serie.points[0];
			point.update(<?php echo json_encode($trends['nhrl_nairobi']['tat4']);?>);
        });

    });
});
$(function () {

    /**
     * Highcharts Linear-Gauge series plugin
     */
    (function (H) {
        var defaultPlotOptions = H.getOptions().plotOptions,
            columnType = H.seriesTypes.column,
            wrap = H.wrap,
            each = H.each;

        defaultPlotOptions.lineargauge = H.merge(defaultPlotOptions.column, {});
        H.seriesTypes.lineargauge = H.extendClass(columnType, {
            type: 'lineargauge',
            //inverted: true,
            setVisible: function () {
                columnType.prototype.setVisible.apply(this, arguments);
                if (this.markLine) {
                    this.markLine[this.visible ? 'show' : 'hide']();
                }
            },
            drawPoints: function () {
                // Draw the Column like always
                columnType.prototype.drawPoints.apply(this, arguments);

                // Add a Marker
                var series = this,
                    chart = this.chart,
                    inverted = chart.inverted,
                    xAxis = this.xAxis,
                    yAxis = this.yAxis,
                    point = this.points[0], // we know there is only 1 point
                    markLine = this.markLine,
                    ani = markLine ? 'animate' : 'attr';

                // Hide column
                point.graphic.hide();

                if (!markLine) {
                    var path = inverted ? ['M', 0, 0, 'L', -5, -5, 'L', 5, -5, 'L', 0, 0, 'L', 0, 0 + xAxis.len] : ['M', 0, 0, 'L', -5, -5, 'L', -5, 5,'L', 0, 0, 'L', xAxis.len, 0];
                    markLine = this.markLine = chart.renderer.path(path)
                        .attr({
                            'fill': series.color,
                            'stroke': series.color,
                            'stroke-width': 1
                        }).add();
                }
                markLine[ani]({
                    translateX: inverted ? xAxis.left + yAxis.translate(point.y) : xAxis.left,
                    translateY: inverted ? xAxis.top : yAxis.top + yAxis.len -  yAxis.translate(point.y)
                });
            }
        });
    }(Highcharts));
$('#container8').highcharts({
        chart: {
            type: 'lineargauge',
            inverted: true
        },
        title: {
            text: 'Nyumbani Lab'
        },
        xAxis: {
            lineColor: '#C0C0C0',
            labels: {
                enabled: false
            },
            tickLength: 0
        },
        yAxis: {
            min: 0,
            max: <?php echo json_encode($trends['nyumbani_lab']['tat3']);?>,
            tickLength: 5,
            tickWidth: 1,
            tickColor: '#C0C0C0',
            gridLineColor: '#C0C0C0',
            gridLineWidth: 1,
            minorTickInterval: 5,
            minorTickWidth: 1,
            minorTickLength: 5,
            minorGridLineWidth: 0,

            title: null,
            labels: {
                format: '{value}'
            },
            plotBands: [{
                from: 0,
                to: <?php echo json_encode($trends['nyumbani_lab']['tat1']);?>,
                color: 'rgba(255,0,0,0.5)'
            }, {
                from: <?php echo json_encode($trends['nyumbani_lab']['tat1']);?>,
                to: <?php echo json_encode($trends['nyumbani_lab']['tat2']);?>,
                color: 'rgba(255,255,0,0.5)'
            }, {
                from: <?php echo json_encode($trends['nyumbani_lab']['tat2']);?>,
                to: <?php echo json_encode($trends['nyumbani_lab']['tat3']);?>,
                color: 'rgba(0,255,0,0.5)'
            }]
        },
        legend: {
            enabled: false
        },

        series: [{
            data: [92],
            color: '#000000',
            dataLabels: {
                enabled: true,
                align: 'center',
                format: '{point.y}',
                y: 10
            }
        }]

    }, // Add some life
    function (chart) {
        Highcharts.each(chart.series, function (serie) {
            var point = serie.points[0];
            point.update(<?php echo json_encode($trends['nyumbani_lab']['tat4']);?>);
        });

    });
});
$(function () {

    /**
     * Highcharts Linear-Gauge series plugin
     */
    (function (H) {
        var defaultPlotOptions = H.getOptions().plotOptions,
            columnType = H.seriesTypes.column,
            wrap = H.wrap,
            each = H.each;

        defaultPlotOptions.lineargauge = H.merge(defaultPlotOptions.column, {});
        H.seriesTypes.lineargauge = H.extendClass(columnType, {
            type: 'lineargauge',
            //inverted: true,
            setVisible: function () {
                columnType.prototype.setVisible.apply(this, arguments);
                if (this.markLine) {
                    this.markLine[this.visible ? 'show' : 'hide']();
                }
            },
            drawPoints: function () {
                // Draw the Column like always
                columnType.prototype.drawPoints.apply(this, arguments);

                // Add a Marker
                var series = this,
                    chart = this.chart,
                    inverted = chart.inverted,
                    xAxis = this.xAxis,
                    yAxis = this.yAxis,
                    point = this.points[0], // we know there is only 1 point
                    markLine = this.markLine,
                    ani = markLine ? 'animate' : 'attr';

                // Hide column
                point.graphic.hide();

                if (!markLine) {
                    var path = inverted ? ['M', 0, 0, 'L', -5, -5, 'L', 5, -5, 'L', 0, 0, 'L', 0, 0 + xAxis.len] : ['M', 0, 0, 'L', -5, -5, 'L', -5, 5,'L', 0, 0, 'L', xAxis.len, 0];
                    markLine = this.markLine = chart.renderer.path(path)
                        .attr({
                            'fill': series.color,
                            'stroke': series.color,
                            'stroke-width': 1
                        }).add();
                }
                markLine[ani]({
                    translateX: inverted ? xAxis.left + yAxis.translate(point.y) : xAxis.left,
                    translateY: inverted ? xAxis.top : yAxis.top + yAxis.len -  yAxis.translate(point.y)
                });
            }
        });
    }(Highcharts));
$('#container9').highcharts({
        chart: {
            type: 'lineargauge',
            inverted: true
        },
        title: {
            text: 'KNH Lab'
        },
        xAxis: {
            lineColor: '#C0C0C0',
            labels: {
                enabled: false
            },
            tickLength: 0
        },
        yAxis: {
            min: 0,
            max: <?php echo json_encode($trends['knh_lab']['tat3']);?>,
            tickLength: 5,
            tickWidth: 1,
            tickColor: '#C0C0C0',
            gridLineColor: '#C0C0C0',
            gridLineWidth: 1,
            minorTickInterval: 5,
            minorTickWidth: 1,
            minorTickLength: 5,
            minorGridLineWidth: 0,

            title: null,
            labels: {
                format: '{value}'
            },
            plotBands: [{
                from: 0,
                to: <?php echo json_encode($trends['knh_lab']['tat1']);?>,
                color: 'rgba(255,0,0,0.5)'
            }, {
                from: <?php echo json_encode($trends['knh_lab']['tat1']);?>,
                to: <?php echo json_encode($trends['knh_lab']['tat2']);?>,
                color: 'rgba(255,255,0,0.5)'
            }, {
                from: <?php echo json_encode($trends['knh_lab']['tat2']);?>,
                to: <?php echo json_encode($trends['knh_lab']['tat3']);?>,
                color: 'rgba(0,255,0,0.5)'
            }]
        },
        legend: {
            enabled: false
        },

        series: [{
            data: [92],
            color: '#000000',
            dataLabels: {
                enabled: true,
                align: 'center',
                format: '{point.y}',
                y: 10
            }
        }]

    }, // Add some life
    function (chart) {
        Highcharts.each(chart.series, function (serie) {
            var point = serie.points[0];

            point.update(<?php echo json_encode($trends['knh_lab']['tat4']);?>);
        });

    });
});
</script>