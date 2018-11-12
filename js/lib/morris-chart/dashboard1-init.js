// Dashboard 1 Morris-chart
$( function () {
	"use strict";


	// Extra chart
	Morris.Area( {
		element: 'extra-area-chart',
		data: [ {
				period: '2004',
				Bitcoin: 0,
				Etheruem: 0,
				Yuan: 90,
				Zin: 0,
				Plin: 0
        }, {
				period: '2007',
				Bitcoin: 10,
				Etheruem: 60,
				Yuan: 40,
				Zin: 80,
				Plin: 120
        }, {
				period: '2008',
				Bitcoin: 120,
				Etheruem: 10,
				Yuan: 90,
				Zin: 30,
				Plin: 50
        }, {
				period: '2012',
				Bitcoin: 0,
				Etheruem: 0,
				Yuan: 120,
				Zin: 0,
				Plin: 0
        }, {
				period: '2014',
				Bitcoin: 0,
				Etheruem: 0,
				Yuan: 0,
				Zin: 150,
				Plin: 0
        }, {
				period: '2016',
				Bitcoin: 160,
				Etheruem: 75,
				Yuan: 30,
				Zin: 60,
				Plin: 90
        }, {
				period: '2018',
				Bitcoin: 150,
				Etheruem: 120,
				Yuan: 40,
				Zin: 60,
				Plin: 30
        }


        ],
		lineColors: [ '#26DAD2', '#fc6180', '#62d1f3', '#ffb64d', '#4680ff' ],
		xkey: 'period',
		ykeys: [ 'Bitcoin', 'Etheruem', 'Yuan', 'Zin', 'Plin' ],
		labels: [ 'Bitcoin', 'Etheruem', 'Yuan', 'Zin', 'Plin' ],
		pointSize: 0,
		lineWidth: 0,
		resize: true,
		fillOpacity: 0.8,
		behaveLikeLine: true,
		gridLineColor: '#e0e0e0',
		hideHover: 'auto'

	} );



} );
