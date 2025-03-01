//[Dashboard Javascript]

//Project:	Rhythm Admin - Responsive Admin Template
//Primary use:   Used only for the main dashboard (index.html)


$(function () {

  'use strict';
	
	var options = {
          series: [64, 73, 48],
          chart: {
          height: 250,
          type: 'radialBar',
        },
		stroke: {
			lineCap: "round",
		  },
        plotOptions: {
          radialBar: {
            dataLabels: {
              name: {
                fontSize: '22px',
              },
              value: {
                fontSize: '16px',
              },
              total: {
                show: true,
                label: 'Total',
                formatter: function (w) {
                  // By default this function returns the average of all series. The below is just an example to show the use of custom formatter function
                  return 145212
                }
              }
            }
          }
        },
		colors: ['#3246D3', '#ffa800', '#ee3158'],
        labels: ['New', 'Recovered', 'In Treatment'],
        };
	
        var chart = new ApexCharts(document.querySelector("#patient_overview"), options);
        chart.render();
	

	
		
	// Slim scrolling
  
  
	  $('.inner-user-div3').slimScroll({
		height: '200px'
	  });
  
	
	$('.owl-carousel').owlCarousel({
		loop: true,
		margin: 0,
		responsiveClass: true,
		autoplay: true,
		dots: false,
		nav: true,
		responsive: {
		  0: {
			items: 1,
		  },
		  600: {
			items: 1,
		  },
		  1000: {
			items: 1,
		  }
		}
	  });
	
}); // End of use strict
