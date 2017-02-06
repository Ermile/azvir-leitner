$(function () {

    $(document).ready(function () {

        // Build the chart
        $('#chart-total-category').highcharts({
            chart: {
                plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: false,
                type: 'pie'
            },
            title: {
                text: 'Total Category'
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
            series: [{
                name: 'Brands',
                colorByPoint: true,
                data: [{
                    name: '504',
                    y: 40.33
                }, {
                    name: '1100 Vocabulary',
                    y: 24.03,
                    sliced: true,
                    selected: true
                }, {
                    name: 'essential word',
                    y: 16.38
                }, {
                    name: 'Math',
                    y: 14.77
                }]
            }]
        });
    });




        $(document).ready(function () {

        // Build the chart
        $('#chart-total-cards').highcharts( {
            chart: {
                plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: false,
                type: 'pie'
            },
            title: {
                text: 'Total cards'
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
            series: [{
                name: 'Brands',
                colorByPoint: true,
                data: [{
                    name: 'Learned',
                    y: 40,
                }, {
                    name: 'unlearned',
                    y: 60,
                    sliced: true,
                    selected: true
                }]
            }]
        });
    });
});

$(function () {
    $('#chart-total-history').highcharts( {
        chart: {
            zoomType: 'xy'
        },
        title: {
            text: 'Total History learned(daily)'
        },
        subtitle: {
            text: ''
        },
        xAxis: [{
            categories: ['01', '02', '03', '04', '05', '06',
                '07', '10', '13', '14', '16', '20'],
            crosshair: true
        }],
        yAxis: [{ // Primary yAxis
            labels: {
                format: '{value}°C',
                style: {
                    color: Highcharts.getOptions().colors[1]
                }
            },
            title: {
                text: 'Temperature',
                style: {
                    color: Highcharts.getOptions().colors[1]
                }
            }
        }, { // Secondary yAxis
            title: {
                text: 'Rainfall',
                style: {
                    color: Highcharts.getOptions().colors[0]
                }
            },
            labels: {
                format: '{value} mm',
                style: {
                    color: Highcharts.getOptions().colors[0]
                }
            },
            opposite: true
        }],
        tooltip: {
            shared: true
        },
        legend: {
            layout: 'vertical',
            align: 'left',
            x: 120,
            verticalAlign: 'top',
            y: 100,
            floating: true,
            backgroundColor: (Highcharts.theme && Highcharts.theme.legendBackgroundColor) || '#FFFFFF'
        },
        series: [{
            name: 'Rainfall',
            type: 'column',
            yAxis: 1,
            data: [49.9, 71.5, 106.4, 129.2, 144.0, 176.0, 135.6, 148.5, 216.4, 194.1, 95.6, 54.4],
            tooltip: {
                valueSuffix: ' mm'
            }

        }, {
            name: 'Temperature',
            type: 'spline',
            data: [7.0, 6.9, 9.5, 14.5, 18.2, 21.5, 25.2, 26.5, 23.3, 18.3, 13.9, 9.6],
            tooltip: {
                valueSuffix: '°C'
            }
        }]
    });
});



//------------------------------------------- page categories //

$(function () {
        $(document).ready(function () {

        // Build the chart
        $('.card1').highcharts( {
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
            series: [{
                name: 'Brands',
                colorByPoint: true,
                data: [{
                    name: 'Learned',
                    y: 91,
                }, {
                    name: 'unlearned',
                    y: 9,
                    sliced: true,
                    selected: true
                }]
            }]
        });
    });


       $(document).ready(function () {

        // Build the chart
        $('.card2').highcharts( {
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
            series: [{
                name: 'Brands',
                colorByPoint: true,
                data: [{
                    name: 'Learned',
                    y: 10,
                }, {
                    name: 'unlearned',
                    y: 90,
                    sliced: true,
                    selected: true
                }]
            }]
        });
    });


       $(document).ready(function () {

        // Build the chart
        $('.card3').highcharts( {
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
            series: [{
                name: 'Brands',
                colorByPoint: true,
                data: [{
                    name: 'Learned',
                    y: 40,
                }, {
                    name: 'unlearned',
                    y: 60,
                    sliced: true,
                    selected: true
                }]
            }]
        });
    });


       $(document).ready(function () {

        // Build the chart
        $('.card4').highcharts( {
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
            series: [{
                name: 'Brands',
                colorByPoint: true,
                data: [{
                    name: 'Learned',
                    y: 5,
                }, {
                    name: 'unlearned',
                    y: 95,
                    sliced: true,
                    selected: true
                }]
            }]
        });
    });

       $(document).ready(function () {

        // Build the chart
        $('.card5').highcharts( {
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
            series: [{
                name: 'Brands',
                colorByPoint: true,
                data: [{
                    name: 'Learned',
                    y: 45,
                }, {
                    name: 'unlearned',
                    y: 55,
                    sliced: true,
                    selected: true
                }]
            }]
        });
    });


       $(document).ready(function () {

        $('.card6').highcharts( {
        chart: {
            plotBackgroundColor: null,
            plotBorderWidth: 0,
            plotShadow: false
        },
        title: {
            text: 'Browser<br>shares<br>2015',
            align: 'center',
            verticalAlign: 'middle',
            y: 40
        },
        tooltip: {
            pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
        },
        plotOptions: {
            pie: {
                dataLabels: {
                    enabled: true,
                    distance: -50,
                    style: {
                        fontWeight: 'bold',
                        color: 'white'
                    }
                },
                startAngle: -90,
                endAngle: 90,
                center: ['50%', '75%']
            }
        },
        series: [{
            type: 'pie',
            name: 'Browser share',
            innerSize: '50%',
            data: [
                ['Learned',   30],
                ['Unlearned',       70],
                {
                    name: 'Proprietary or Undetectable',
                    y: 0.2,
                    dataLabels: {
                        enabled: false
                    }
                }
            ]
        }]
    });

});
       });


// ----------------------------------->> flipcard >>


$('#open-modal').click(function(){
    $('#modal').fadeIn('slow');
});

var modal = $('#modal');
$(window).click(function(event){
    var target = event.target;
    if ( $(target).attr('id') == 'modal' )
    {
        modal.fadeOut('slow');
    }
});

// -----------------------------------> span X
$('span.close').click(function(){
    $('#modal').fadeOut('slow');
});

//------------------------------------> add class fo rotate


$("div.btn").click(function()
{
    var parent = $(this).parents('.info-card');

    if(parent.hasClass("info-card-front"))
    {
        parent.removeClass('info-card-front');

        $(".front").removeClass("front_rotate");
        $(".back").removeClass("back_rotate");
    }
    else
    {
        parent.addClass('info-card-front');

        $(".front").addClass("front_rotate");
        $(".back").addClass("back_rotate");
    }
});

// --------------------------------- setting page
// $("#general").click(function()
// {
//     $("#tab-general").show();
//     $("#tab-advansed").hide();
//     $("#tab-scheduling").hide();

// });

// $("#advansed").click(function()
// {
//     $("#tab-advansed").show();
//     $("#tab-general").hide();
//     $("#tab-scheduling").hide();

// });

// $("#scheduling").click(function()
// {
//     $("#tab-scheduling").show();
//     $("#tab-advansed").hide();
//     $("#tab-general").hide();

// });

$("#general").click(function()
{
    if ("#tab-general div".hasClass("hide_li"))
    {
        $("#tab-general div").removeClass ("hide_li")
        $("#tab-general div").addClass ("show_li")
    };
});



// ------------------------------------------------------>> page dashboards >>

Highcharts.chart('bar-stacked-chart', {
    chart: {
        type: 'bar'
    },
    title: {
        text: ''
    },
    xAxis: {
        categories: ['504', 'Vocabs', 'Ielts', 'Toefl', 'Words']
    },
    yAxis: {
        min: 0,
        title: {
            text: ''
        }
    },
    legend: {
        reversed: true
    },
    plotOptions: {
        series: {
            stacking: 'normal'
        }
    },
    series: [{
        name: 'Learned',
        data: [10, 80, 40, 70, 5]
    }, {
        name: 'Failed',
        data: [60, 10, 0, 20, 25]
    }, {
        name: 'Unlearned',
        data: [30, 10, 60, 10, 70]
    }]
});




$(document).ready(function () {

    // Build the chart
    $('#half-cake-chart11').highcharts({
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
        series: [{
            name: 'Brands',
            colorByPoint: true,
            data: [{
                name: 'Learned',
                y: 60
            }, {
                name: 'Failed',
                y: 25,
                sliced: true,
                selected: true
            }, {
                name: 'Unlearned',
                y: 15
            }]
        }]
    });
});


AmCharts.makeChart("half-cake-chart",
                {
                    "type": "pie",
                    "balloonText": "[[title]]<br><span style='font-size:14px'><b>[[value]]</b> ([[percents]]%)</span>",
                    "labelsEnabled": false,
                    "titleField": "category",
                    "valueField": "column-1",
                    "allLabels": [],
                    "balloon": {},
                    "legend": {
                        "enabled": true,
                        "align": "center",
                        "equalWidths": false,
                        "markerType": "circle"
                    },
                    "titles": [],
                    "dataProvider": [
                        {
                            "category": "Unlearned",
                            "column-1": 40
                        },
                        {
                            "category": "Failed",
                            "column-1": 25
                        },
                        {
                            "category": "learned",
                            "column-1": 35
                        }
                    ]
                }
            );


AmCharts.makeChart("total-chart-progress",
                {
                    "type": "serial",
                    "categoryField": "category",
                    "startDuration": 1,
                    "theme": "default",
                    "categoryAxis": {
                        "gridPosition": "start"
                    },
                    "trendLines": [],
                    "graphs": [
                        {
                            "balloonText": "[[title]] of [[category]]:[[value]]",
                            "fillAlphas": 0.7,
                            "id": "AmGraph-1",
                            "lineAlpha": 0,
                            "title": "Success",
                            "valueField": "column-1"
                        },
                        {
                            "balloonText": "[[title]] of [[category]]:[[value]]",
                            "fillAlphas": 0.7,
                            "id": "AmGraph-2",
                            "lineAlpha": 0,
                            "title": "Practice",
                            "valueField": "column-2"
                        }
                    ],
                    "guides": [],
                    "valueAxes": [
                        {
                            "id": "ValueAxis-1",
                            "title": ""
                        }
                    ],
                    "allLabels": [],
                    "balloon": {},
                    "legend": {
                        "enabled": true
                    },
                    "titles": [
                        {
                            "id": "Title-1",
                            "size": 15,
                            "text": ""
                        }
                    ],
                    "dataProvider": [
                        {
                            "category": "week 1",
                            "column-1": "1",
                            "column-2": "2"
                        },
                        {
                            "category": "week 2",
                            "column-1": "3",
                            "column-2": "4"
                        },
                        {
                            "category": "week 3",
                            "column-1": "4",
                            "column-2": "6"
                        },
                        {
                            "category": "week 4",
                            "column-1": "4",
                            "column-2": "5"
                        },
                        {
                            "category": "week 5",
                            "column-1": "8",
                            "column-2": "13"
                        },
                        {
                            "category": "week 6",
                            "column-1": "12",
                            "column-2": "13"
                        },
                        {
                            "category": "week 7",
                            "column-1": "9",
                            "column-2": "11"
                        }
                    ]
                }
            );

$(document).ready(function(){
    $("#profile").click(function(){
        $("#profile_nav").fadeToggle();
    });
});

$(window).click( function(event){
    var profile = $("#profile");
    console.log(event.target)
    console.log(profile)
    var click_target = event.target;
    var target = click_target.parents("profile");
    if (event.target == profile)
    {
        console.log(111)
        $("#profile_nav").fadeOut();
    }
});

