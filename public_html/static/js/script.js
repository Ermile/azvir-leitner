$(document).ready(function() {
	$(".button-collapse").sideNav();

	$('#container').highcharts({
        chart: {
            type: 'column'
        },
        title: {
            text: 'Azvir Test'
        },
        xAxis: {
            categories: ['Apples', 'Oranges', 'Pears', 'Grapes', 'Bananas']
        },
        yAxis: {
            min: 0,
            title: {
                text: 'Cards'
            }
        },
        tooltip: {
            pointFormat: '<span style="color:{series.color}">{series.name}</span>: <b>{point.y}</b> ({point.percentage:.0f}%)<br/>',
            shared: true
        },
        series: [{
            name: 'John',
            data: [5, 3, 4, 7, 2]
        }]
    });
})