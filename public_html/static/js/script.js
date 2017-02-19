

//------------------------------------------- page categories //




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


$("#general").click(function()
{
	if ("#tab-general div".hasClass("hide_li"))
	{
		$("#tab-general div").removeClass ("hide_li")
		$("#tab-general div").addClass ("show_li")
	};
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
	"balloon":
	{
	"adjustBorderColor": false
	},
		"titles": [],
		"dataProvider":
	[{
		"category": "category 1",
		"column-1": 8
	},
	{
		"category": "category 2",
		"column-1": 5
	},
	{
		"category": "category 3",
		"column-1": 6
	}]
});


$(document).ready(function(){
	$("#profile").click(function(e){
		$("#profile_nav").stop().fadeToggle(function(){
			$(this).toggleClass('isOpen');
		});
		e.preventDefault();
		e.stopPropagation();
	});

	$('#profile_nav').click(function(e){
		e.preventDefault();
		e.stopPropagation();
	});

	$('body').click(function(e){
		if ( $("#profile_nav").hasClass('isOpen') )
		{
			$("#profile_nav").stop().fadeOut().removeClass('isOpen');
		}
	});
});



	AmCharts.makeChart("bar-stacked-chart",
				{
					"type": "serial",
					"categoryField": "category",
					"rotate": true,
					"categoryAxis": {
						"gridPosition": "start"
					},
					"trendLines": [],
					"graphs": [
						{
							"balloonText": "[[title]] of [[category]]:[[value]]",
							"fillAlphas": 1,
							"id": "AmGraph-1",
							"title": "graph 1",
							"type": "column",
							"valueField": "column-1"
						},
						{
							"balloonText": "[[title]] of [[category]]:[[value]]",
							"fillAlphas": 1,
							"id": "AmGraph-2",
							"title": "graph 2",
							"type": "column",
							"valueField": "column-2"
						},
						{
							"fillAlphas": 1,
							"id": "AmGraph-4",
							"title": "graph 4",
							"type": "column",
							"valueField": "column-3"
						}
					],
					"guides": [],
					"valueAxes": [
						{
							"id": "ValueAxis-1",
							"stackType": "100%",
							"title": ""
						}
					],
					"allLabels": [],
					"balloon": {},
					"titles": [
						{
							"id": "Title-1",
							"size": 15,
							"text": ""
						}
					],
					"dataProvider": [
						{
							"category": "405 Words",
							"column-1": 18,
							"column-2": 5,
							"column-3": 9
						},
						{
							"category": "Toefl",
							"column-1": 6,
							"column-2": 15,
							"column-3": 4
						},
						{
							"category": "Essentional",
							"column-1": 6,
							"column-2": 7,
							"column-3": 3
						},
						{
							"category": "Iltes",
							"column-1": 2,
							"column-2": 3,
							"column-3": 6
						}
					]
				}
			);


$('.tab-cake').each(function()
{
	var first_content = $('[data-tab-navigate]', this).eq(0).attr('data-tab-navigate');
	$('[data-tab-content=' + first_content + ']').addClass('active');

	$('[data-tab-navigate]', this).click(function(){
		var navigate = $(this).attr('data-tab-navigate');
		$('[data-tab-content]').removeClass('active');
		$('[data-tab-content=' + navigate + ']').addClass('active');
	});
});




AmCharts.makeChart("total-chart-progress-daily",
				{
					"type": "serial",
					"startDuration": "",
					"startEffect":"easeOutSine",
					"categoryField": "category",
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
							"category": "day 1",
							"column-1": "1",
							"column-2": "2"
						},
						{
							"category": "day 2",
							"column-1": "3",
							"column-2": "4"
						},
						{
							"category": "day 3",
							"column-1": "4",
							"column-2": "6"
						},
						{
							"category": "day 4",
							"column-1": "4",
							"column-2": "5"
						},
						{
							"category": "day 5",
							"column-1": "8",
							"column-2": "13"
						},
						{
							"category": "day 6",
							"column-1": "12",
							"column-2": "13"
						},
						{
							"category": "day 7",
							"column-1": "9",
							"column-2": "11"
						}
					]
				}
			);

AmCharts.makeChart("total-chart-progress-weekly",
				{
					"type": "serial",
					"startDuration": "",
					"startEffect":"easeOutSine",
					"categoryField": "category",
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
							"column-2": "3"
						},
						{
							"category": "week 2",
							"column-1": "8",
							"column-2": "10"
						},
						{
							"category": "week 3",
							"column-1": "3",
							"column-2": "7"
						},
						{
							"category": "week 4",
							"column-1": "9",
							"column-2": "15"
						},
						{
							"category": "week 5",
							"column-1": "19",
							"column-2": "25"
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

AmCharts.makeChart("total-chart-progress-monthly",
				{
					"type": "serial",
					"startDuration": "",
					"startEffect":"easeOutSine",
					"categoryField": "category",
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
					"titles":
					[
						{
							"id": "Title-1",
							"size": 15,
							"text": ""
						}
					],
					"dataProvider": [
						{
							"category": "month 1",
							"column-1": "10",
							"column-2": "20"
						},
						{
							"category": "month 2",
							"column-1": "30",
							"column-2": "40"
						},
						{
							"category": "month 3",
							"column-1": "25",
							"column-2": "30"
						},
						{
							"category": "month 4",
							"column-1": "40",
							"column-2": "50"
						},
						{
							"category": "month 5",
							"column-1": "18",
							"column-2": "19"
						},
						{
							"category": "month 6",
							"column-1": "12",
							"column-2": "13"
						},
						{
							"category": "month 7",
							"column-1": "80",
							"column-2": "110"
						}
					]
				}
			);



// $(".tab-cake>li").click(function () {
//     $(".tab-cake>li").removeClass("active");
//     $(this).addClass("active");
// });

$(".tab-cake>li").click(function () {
	$(".tab-cake>li").removeClass("active");
	$(this).addClass("active");
});