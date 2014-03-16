<script type="application/javascript">
$.ajax({
    type: "POST",
    url: "http://grandmasterx.com/trading/getData/",
    dataType: 'json',
    success: function(graphData){
        var data = graphData
        var masterChart,
            detailChart,
            dataLength = graphData.length;

        function createMaster() {
            masterChart = $('#master-container').highcharts({
                chart: {
                    reflow: false,
                    borderWidth: 0,
                    backgroundColor: null,
                    marginLeft: 50,
                    marginRight: 20,
                    zoomType: 'x',
                    events: {

                        // listen to the selection event on the master chart to update the
                        // extremes of the detail chart
                        selection: function(event) {
                            var extremesObject = event.xAxis[0],
                                min = extremesObject.min,
                                max = extremesObject.max,
                                detailData = [],
                                xAxis = this.xAxis[0];

                            // reverse engineer the last part of the data
                            jQuery.each(this.series[0].data, function(i, point) {
                                if (point.x > min && point.x < max) {
                                    detailData.push({
                                        x: point.x,
                                        y: point.y
                                    });
                                }
                            });

                            // move the plot bands to reflect the new detail span
                            xAxis.removePlotBand('mask-before');
                            xAxis.addPlotBand({
                                id: 'mask-before',
                                from: Date.UTC(2012, 1, 1),
                                to: min,
                                color: 'rgba(0, 0, 0, 0.2)'
                            });

                            xAxis.removePlotBand('mask-after');
                            xAxis.addPlotBand({
                                id: 'mask-after',
                                from: max,
                                to: Date.UTC(2013, 12, 31),
                                color: 'rgba(0, 0, 0, 0.2)'
                            });


                            detailChart.series[0].setData(detailData);

                            return false;
                        }
                    }
                },
                title: {
                    text: null
                },
                xAxis: {
                    type: 'datetime',
                    showLastTickLabel: true,
                    maxZoom: 365, // fourteen days 14* 24 * 3600000
                    plotBands: [{
                        id: 'mask-before',
                        from: Date.UTC(2012, 1, 1),
                        to: Date.UTC(2013, 12, 31),
                        color: 'rgba(0, 0, 0, 0.2)'
                    }],
                    title: {
                        text: null
                    }
                },
                yAxis: {
                    gridLineWidth: 0,
                    labels: {
                        enabled: false
                    },
                    title: {
                        text: null
                    },
                    min: 0.6,
                    showFirstLabel: false
                },
                tooltip: {
                    formatter: function() {
                        return false;
                    }
                },
                legend: {
                    enabled: false
                },
                credits: {
                    enabled: false
                },
                plotOptions: {
                    series: {
                        fillColor: {
                            linearGradient: [0, 0, 0, 70],
                            stops: [
                                [0, '#4572A7'],
                                [1, 'rgba(0,0,0,0)']
                            ]
                        },
                        lineWidth: 1,
                        marker: {
                            enabled: true
                        },
                        shadow: false,
                        states: {
                            hover: {
                                lineWidth: 1
                            }
                        },
                        turboThreshold: dataLength,
                        enableMouseTracking: false
                    }
                },

                series: [{
                    type: 'area',
                    name: 'USD to EUR',
                    pointInterval: 24,
                    pointStart: Date.UTC(2012, 1, 1),
                    data: data
                }],

                exporting: {
                    enabled: false
                }

            }, function(masterChart) {
                createDetail(masterChart)
            })
                .highcharts(); // return chart instance
        }


        // create the detail chart
        function createDetail(masterChart) {

            // prepare the detail chart
            var detailData = [],
                detailStart = Date.UTC(2012, 1, 1);

            jQuery.each(masterChart.series[0].data, function(i, point) {
                if (point.x >= detailStart) {
                    detailData.push(point.y);
                }
            });

            // create a detail chart referenced by a global variable
            detailChart = $('#detail-container').highcharts({
                chart: {
                    marginBottom: 120,
                    reflow: false,
                    marginLeft: 50,
                    marginRight: 20,
                    style: {
                        position: 'absolute'
                    }
                },
                credits: {
                    enabled: false
                },
                title: {
                    text: 'Historical USD to EUR Exchange Rate'
                },
                subtitle: {
                    text: 'Select an area by dragging across the lower chart'
                },
                xAxis: {
                    type: 'datetime'
                },
                yAxis: {
                    title: {
                        text: null
                    },
                    maxZoom: 0.1
                },
                tooltip: {
                    formatter: function() {
                        var point = this.points[0];
                        return '<b>'+ point.series.name +'</b><br/>'+
                            Highcharts.dateFormat('%Y-%m-%d %H:%M:%S ', this.x) + '<br/>'+
                            '1 EUR = '+ Highcharts.numberFormat(point.y, 4) +' USD';
                    },
                    shared: true
                },
                legend: {
                    enabled: false
                },
                plotOptions: {
                    series: {
                        marker: {
                            enabled: false,
                            states: {
                                hover: {
                                    enabled: true,
                                    radius: 3
                                }
                            }
                        },
                        turboThreshold: dataLength
                    }
                },
                series: [{
                    name: 'USD to EUR',
                    pointStart: detailStart,
                    pointInterval: 365*8*36000,
                    data: detailData
                }],

                exporting: {
                    enabled: false
                }

            }).highcharts(); // return chart
        }


        // make the container smaller and add a second container for the master chart
        var $container = $('#container')
            .css('position', 'relative');

        var $detailContainer = $('<div id="detail-container">')
            .appendTo($container);

        var $masterContainer = $('<div id="master-container">')
            .css({ position: 'absolute', top: 300, height: 80, width: '100%' })
            .appendTo($container);

        // create master and in its callback, create the detail chart
        createMaster();

        $('.tradersStnt').click(function() {
            $.ajax({
                type: "POST",
                url: "http://grandmasterx.com/trading/drawTicket/",
                dataType: 'json',
                data: {id:$(this).attr('id')},
                success: function(graphData){
                    console.log(graphData.open,graphData.oy, graphData.om, graphData.od);

                    detailChart.addAxis({ // Secondary yAxis
                        id: 'rainfall-axis',
                        title: {
                            text: 'Rainfall'
                        },
                        lineWidth: 2,
                        lineColor: '#222',
                        opposite: true,
                        xAxis: {
                            type: 'datetime'
                        }
                        //pointInterval: 24
                    });
                    detailChart.addSeries({
                        name: graphData.trader_name,
                        color: '#222',
                        data: [[Date.UTC(graphData.oy, graphData.om, graphData.od, graphData.oh, graphData.om,00),graphData.open],[Date.UTC(graphData.cy, graphData.cm, graphData.cd, graphData.ch, graphData.cm,00),graphData.close]]

                    });
                }
            });
        });

    }
});


</script>