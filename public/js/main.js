function chart1(){
  //WidgetChart 1
  var ctx = document.getElementById("widgetChart1");
  var all_month_data = document.getElementById("all_month_data").value;
  var decode= JSON.parse(all_month_data);
  var month = Object.keys(decode);
  var value = Object.values(decode);
  if (ctx) {
  ctx.height = 130;
  var myChart = new Chart(ctx, {
      type: 'line',
      data: {
      labels: month,
      type: 'line',
      datasets: [{
          data: value,
          label: 'Order',
          backgroundColor: 'transparent',
          borderColor: 'rgba(255,255,255,.55)',
      },]
      },
      options: {

      maintainAspectRatio: false,
      legend: {
          display: false
      },
      responsive: true,
      tooltips: {
          mode: 'index',
          titleFontSize: 12,
          titleFontColor: '#000',
          bodyFontColor: '#000',
          backgroundColor: '#fff',
          titleFontFamily: 'Montserrat',
          bodyFontFamily: 'Montserrat',
          cornerRadius: 3,
          intersect: false,
      },
      scales: {
          xAxes: [{
          gridLines: {
              color: 'transparent',
              zeroLineColor: 'transparent'
          },
          ticks: {
              fontSize: 2,
              fontColor: 'transparent'
          }
          }],
          yAxes: [{
          display: false,
          ticks: {
              display: false,
          }
          }]
      },
      title: {
          display: false,
      },
      elements: {
          line: {
          tension: 0.00001,
          borderWidth: 1
          },
          point: {
          radius: 4,
          hitRadius: 10,
          hoverRadius: 4
          }
      }
      }
  });
  }
}

function chart2(){
  //WidgetChart 2
  var ctx = document.getElementById("widgetChart2");
  var placed = document.getElementById("placed").value;
  var decode= JSON.parse(placed);
  var month = Object.keys(decode);
  var value = Object.values(decode);
  if (ctx) {
  ctx.height = 130;
  var myChart = new Chart(ctx, {
      type: 'line',
      data: {
      labels: month,
      type: 'line',
      datasets: [{
          data: value,
          label: 'Placed order',
          backgroundColor: 'transparent',
          borderColor: 'rgba(255,255,255,.55)',
      },]
      },
      options: {

      maintainAspectRatio: false,
      legend: {
          display: false
      },
      responsive: true,
      tooltips: {
          mode: 'index',
          titleFontSize: 12,
          titleFontColor: '#000',
          bodyFontColor: '#000',
          backgroundColor: '#fff',
          titleFontFamily: 'Montserrat',
          bodyFontFamily: 'Montserrat',
          cornerRadius: 3,
          intersect: false,
      },
      scales: {
          xAxes: [{
          gridLines: {
              color: 'transparent',
              zeroLineColor: 'transparent'
          },
          ticks: {
              fontSize: 2,
              fontColor: 'transparent'
          }
          }],
          yAxes: [{
          display: false,
          ticks: {
              display: false,
          }
          }]
      },
      title: {
          display: false,
      },
      elements: {
          line: {
          tension: 0.00001,
          borderWidth: 1
          },
          point: {
          radius: 4,
          hitRadius: 10,
          hoverRadius: 4
          }
      }
      }
  });
  }
}

function chart3(){
  //WidgetChart 3
  var ctx = document.getElementById("widgetChart3");
  var accepted = document.getElementById("accepted").value;
  var decode= JSON.parse(accepted);
  var month = Object.keys(decode);
  var value = Object.values(decode);
  if (ctx) {
  ctx.height = 130;
  var myChart = new Chart(ctx, {
      type: 'line',
      data: {
      labels: month,
      type: 'line',
      datasets: [{
          data: value,
          label: 'Accepted orders',
          backgroundColor: 'transparent',
          borderColor: 'rgba(255,255,255,.55)',
      },]
      },
      options: {

      maintainAspectRatio: false,
      legend: {
          display: false
      },
      responsive: true,
      tooltips: {
          mode: 'index',
          titleFontSize: 12,
          titleFontColor: '#000',
          bodyFontColor: '#000',
          backgroundColor: '#fff',
          titleFontFamily: 'Montserrat',
          bodyFontFamily: 'Montserrat',
          cornerRadius: 3,
          intersect: false,
      },
      scales: {
          xAxes: [{
          gridLines: {
              color: 'transparent',
              zeroLineColor: 'transparent'
          },
          ticks: {
              fontSize: 2,
              fontColor: 'transparent'
          }
          }],
          yAxes: [{
          display: false,
          ticks: {
              display: false,
          }
          }]
      },
      title: {
          display: false,
      },
      elements: {
          line: {
          tension: 0.00001,
          borderWidth: 1
          },
          point: {
          radius: 4,
          hitRadius: 10,
          hoverRadius: 4
          }
      }
      }
  });
  }
}

function chart4(){
  var ctx = document.getElementById("widgetChart4");
  var rejected = document.getElementById("rejected").value;
  var decode= JSON.parse(rejected);
  var month = Object.keys(decode);
  var value = Object.values(decode);
  if (ctx) {
  ctx.height = 130;
  var myChart = new Chart(ctx, {
      type: 'line',
      data: {
      labels: month,
      type: 'line',
      datasets: [{
          data: value,
          label: 'Rejected orders',
          backgroundColor: 'transparent',
          borderColor: 'rgba(255,255,255,.55)',
      },]
      },
      options: {

      maintainAspectRatio: false,
      legend: {
          display: false
      },
      responsive: true,
      tooltips: {
          mode: 'index',
          titleFontSize: 12,
          titleFontColor: '#000',
          bodyFontColor: '#000',
          backgroundColor: '#fff',
          titleFontFamily: 'Montserrat',
          bodyFontFamily: 'Montserrat',
          cornerRadius: 3,
          intersect: false,
      },
      scales: {
          xAxes: [{
          gridLines: {
              color: 'transparent',
              zeroLineColor: 'transparent'
          },
          ticks: {
              fontSize: 2,
              fontColor: 'transparent'
          }
          }],
          yAxes: [{
          display: false,
          ticks: {
              display: false,
          }
          }]
      },
      title: {
          display: false,
      },
      elements: {
          line: {
          borderWidth: 1
          },
          point: {
          radius: 4,
          hitRadius: 10,
          hoverRadius: 4
          }
      }
      }
  });
  }
}

function chart6(){
 // WidgetChart 6
  var ctx = document.getElementById("widgetChart6");
  var delivered = document.getElementById("delivered").value;
  var decode= JSON.parse(delivered);
  var month = Object.keys(decode);
  var value = Object.values(decode);
  if (ctx) {
  ctx.height = 130;
  var myChart = new Chart(ctx, {
      type: 'line',
      data: {
      labels: month,
      type: 'line',
      datasets: [{
          data: value,
          label: 'Delivered orders',
          backgroundColor: 'transparent',
          borderColor: 'rgba(255,255,255,.55)',
      },]
      },
      options: {

      maintainAspectRatio: false,
      legend: {
          display: false
      },
      responsive: true,
      tooltips: {
          mode: 'index',
          titleFontSize: 12,
          titleFontColor: '#000',
          bodyFontColor: '#000',
          backgroundColor: '#fff',
          titleFontFamily: 'Montserrat',
          bodyFontFamily: 'Montserrat',
          cornerRadius: 3,
          intersect: false,
      },
      scales: {
          xAxes: [{
          gridLines: {
              color: 'transparent',
              zeroLineColor: 'transparent'
          },
          ticks: {
              fontSize: 2,
              fontColor: 'transparent'
          }
          }],
          yAxes: [{
          display: false,
          ticks: {
              display: false,
          }
          }]
      },
      title: {
          display: false,
      },
      elements: {
          line: {
          borderWidth: 1
          },
          point: {
          radius: 4,
          hitRadius: 10,
          hoverRadius: 4
          }
      }
      }
  });
  }
}

function chart7(){
  //WidgetChart 7
  var ctx = document.getElementById("widgetChart7");
  var ready = document.getElementById("ready").value;
  var decode= JSON.parse(ready);
  var month = Object.keys(decode);
  var value = Object.values(decode);
  if (ctx) {
  ctx.height = 130;
  var myChart = new Chart(ctx, {
      type: 'line',
      data: {
      labels: month,
      type: 'line',
      datasets: [{
          data: value,
          label: 'Ready orders',
          backgroundColor: 'transparent',
          borderColor: 'rgba(255,255,255,.55)',
      },]
      },
      options: {

      maintainAspectRatio: false,
      legend: {
          display: false
      },
      responsive: true,
      tooltips: {
          mode: 'index',
          titleFontSize: 12,
          titleFontColor: '#000',
          bodyFontColor: '#000',
          backgroundColor: '#fff',
          titleFontFamily: 'Montserrat',
          bodyFontFamily: 'Montserrat',
          cornerRadius: 3,
          intersect: false,
      },
      scales: {
          xAxes: [{
          gridLines: {
              color: 'transparent',
              zeroLineColor: 'transparent'
          },
          ticks: {
              fontSize: 2,
              fontColor: 'transparent'
          }
          }],
          yAxes: [{
          display: false,
          ticks: {
              display: false,
          }
          }]
      },
      title: {
          display: false,
      },
      elements: {
          line: {
          borderWidth: 1
          },
          point: {
          radius: 4,
          hitRadius: 10,
          hoverRadius: 4
          }
      }
      }
  });
  }
}

function chart8(){
  //WidgetChart 8
  var ctx = document.getElementById("widgetChart8");
  var cancel = document.getElementById("cancel").value;
  var decode= JSON.parse(cancel);
  var month = Object.keys(decode);
  var value = Object.values(decode);
  if (ctx) {
      ctx.height = 130;
      var myChart = new Chart(ctx, {
      type: 'line',
      data: {
          labels: month,
          type: 'line',
          datasets: [{
          data: value,
          label: 'Cancel orders',
          backgroundColor: 'transparent',
          borderColor: 'rgba(255,255,255,.55)',
          },]
      },
      options: {

          maintainAspectRatio: false,
          legend: {
          display: false
          },
          responsive: true,
          tooltips: {
          mode: 'index',
          titleFontSize: 12,
          titleFontColor: '#000',
          bodyFontColor: '#000',
          backgroundColor: '#fff',
          titleFontFamily: 'Montserrat',
          bodyFontFamily: 'Montserrat',
          cornerRadius: 3,
          intersect: false,
          },
          scales: {
          xAxes: [{
              gridLines: {
              color: 'transparent',
              zeroLineColor: 'transparent'
              },
              ticks: {
              fontSize: 2,
              fontColor: 'transparent'
              }
          }],
          yAxes: [{
              display: false,
              ticks: {
              display: false,
              }
          }]
          },
          title: {
          display: false,
          },
          elements: {
          line: {
              borderWidth: 1
          },
          point: {
              radius: 4,
              hitRadius: 10,
              hoverRadius: 4
          }
          }
      }
      });
  }
}

function chart9(){
  //WidgetChart 9
  var ctx = document.getElementById("widgetChart9");
  var month_wise_revenue = document.getElementById("month_wise_revenue").value;
  var decode= JSON.parse(month_wise_revenue);
  var month = Object.keys(decode);
  var value = Object.values(decode);
  if (ctx) {
      ctx.height = 130;
      var myChart = new Chart(ctx, {
      type: 'line',
      data: {
          labels: month,
          type: 'line',
          datasets: [{
          data: value,
          label: 'Truck revenue',
          backgroundColor: 'transparent',
          borderColor: 'rgba(255,255,255,.55)',
          },]
      },
      options: {

          maintainAspectRatio: false,
          legend: {
          display: false
          },
          responsive: true,
          tooltips: {
          mode: 'index',
          titleFontSize: 12,
          titleFontColor: '#000',
          bodyFontColor: '#000',
          backgroundColor: '#fff',
          titleFontFamily: 'Montserrat',
          bodyFontFamily: 'Montserrat',
          cornerRadius: 3,
          intersect: false,
          },
          scales: {
          xAxes: [{
              gridLines: {
              color: 'transparent',
              zeroLineColor: 'transparent'
              },
              ticks: {
              fontSize: 2,
              fontColor: 'transparent'
              }
          }],
          yAxes: [{
              display: false,
              ticks: {
              display: false,
              }
          }]
          },
          title: {
          display: false,
          },
          elements: {
          line: {
              borderWidth: 1
          },
          point: {
              radius: 4,
              hitRadius: 10,
              hoverRadius: 4
          }
          }
      }
      });
  }
}

function chart10(){
   //WidgetChart 10

  var d = document.getElementById("report").value;
  var decode= JSON.parse(d);

  var data1 = decode.data.data1;
  var data2 = decode.data.data2;
  var labels = decode.labels;
  
  var total_amount = decode.total_amount;
  var ctx = document.getElementById("widgetChart10");
  if (ctx) {
  ctx.height = 220;
  var myChart = new Chart(ctx, {
      type: 'bar',
      data: {
      labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
      datasets: [
          {
          label: "My First dataset",
          data: [78, 81, 80, 64, 65, 80, 70, 75, 67, 85, 66, 68],
          borderColor: "transparent",
          borderWidth: "0",
          backgroundColor: "#ccc",
          }
      ]
      },
      options: {
      maintainAspectRatio: true,
      legend: {
          display: false
      },
      scales: {
          xAxes: [{
          display: false,
          categoryPercentage: 1,
          barPercentage: 0.65
          }],
          yAxes: [{
          display: false
          }]
      }
      }
  });
  }
}



(function ($) {
  // USE STRICT
  "use strict";

  try {
    
    // Recent Report
    const brandProduct = 'rgba(0,181,233,0.8)'
    const brandService = 'rgba(0,173,95,0.8)'

    var elements = 10
    var d = document.getElementById("report").value;
    var decode= JSON.parse(d);
  
    var data1 = decode.data.data1;
    var data2 = decode.data.data2;
    var labels = decode.labels;
    
    var total_amount = decode.total_amount;
    var ctx = document.getElementById("recent-rep-chart");
    if (total_amount > 5 ){
      var steps_size  = (total_amount / 4);
    }else{
      var steps_size  =  total_amount;
    }
    if (ctx) {
      ctx.height = 250;
      var myChart = new Chart(ctx, {
        type: 'bar',
        data: {
          labels: [],
          datasets: [
            {
              label: labels[0],
              backgroundColor: brandProduct,
              borderColor: 'transparent',
              pointHoverBackgroundColor: '#fff',
              borderWidth: 0,
              data: data2

            },
            {
              label: labels[1],
              
              backgroundColor: brandService,
              borderColor: 'transparent',
              pointHoverBackgroundColor: '#fff',
              borderWidth: 0,
              data: data1

            }
          ]
        },
        options: {
          maintainAspectRatio: true,
          legend: {
            display: false
          },
          responsive: true,
          scales: {
            xAxes: [{
              gridLines: {
                drawOnChartArea: true,
                color: '#f2f2f2'
              },
              ticks: {
                fontFamily: "Poppins",
                fontSize: 12
              }
            }],
            yAxes: [{
              ticks: {
                beginAtZero: true,
                maxTicksLimit: 5,
                stepSize: steps_size,
                max: total_amount,
                fontFamily: "Poppins",
                fontSize: 12
              },
              gridLines: {
                display: true,
                color: '#f2f2f2'

              }
            }]
          },
          elements: {
            point: {
              radius: 0,
              hitRadius: 10,
              hoverRadius: 4,
              hoverBorderWidth: 3
            }
          }


        }
      });
    }

    // Percent Chart
    var d = document.getElementById("sale_data_per").value;
    var decode= JSON.parse(d);
    var data= decode.data;
    var labels = decode.labels;
    var colors = decode.colors;


    var ctx = document.getElementById("percent-chart");
    if (ctx) {
      ctx.height = 280;
      var myChart = new Chart(ctx, {
        type: 'doughnut',
        data: {
          datasets: [
            {
              label: "My First dataset",
              data: data,
              backgroundColor: colors,
              hoverBackgroundColor: [
                '#00b5e9',
                '#fa4251'
              ],
              borderWidth: [
                0, 0
              ],
              hoverBorderColor: [
                'transparent',
                'transparent',
              ]
            }
          ],
          labels: labels
        },
        options: {
          maintainAspectRatio: false,
          responsive: true,
          cutoutPercentage: 55,
          animation: {
            animateScale: true,
            animateRotate: true,
            animateRotate: true
          },
          legend: {
            display: false
          },
          tooltips: {
            titleFontFamily: "Poppins",
            xPadding: 15,
            yPadding: 10,
            caretPadding: 0,
            bodyFontSize: 16
          }
        }
      });
    }

  } catch (error) {
    console.log(error);
  }


  try {
    //Sales chart
    var ctx = document.getElementById("sales-chart");
    if (ctx) {
      ctx.height = 150;
      var myChart = new Chart(ctx, {
        type: 'line',
        data: {
          labels: ["2010", "2011", "2012", "2013", "2014", "2015", "2016"],
          type: 'line',
          defaultFontFamily: 'Poppins',
          datasets: [{
            label: "Foods",
            data: [0, 30, 10, 120, 50, 63, 10],
            backgroundColor: 'transparent',
            borderColor: 'rgba(220,53,69,0.75)',
            borderWidth: 3,
            pointStyle: 'circle',
            pointRadius: 5,
            pointBorderColor: 'transparent',
            pointBackgroundColor: 'rgba(220,53,69,0.75)',
          }, {
            label: "Electronics",
            data: [0, 50, 40, 80, 40, 79, 120],
            backgroundColor: 'transparent',
            borderColor: 'rgba(40,167,69,0.75)',
            borderWidth: 3,
            pointStyle: 'circle',
            pointRadius: 5,
            pointBorderColor: 'transparent',
            pointBackgroundColor: 'rgba(40,167,69,0.75)',
          }]
        },
        options: {
          responsive: true,
          tooltips: {
            mode: 'index',
            titleFontSize: 12,
            titleFontColor: '#000',
            bodyFontColor: '#000',
            backgroundColor: '#fff',
            titleFontFamily: 'Poppins',
            bodyFontFamily: 'Poppins',
            cornerRadius: 3,
            intersect: false,
          },
          legend: {
            display: false,
            labels: {
              usePointStyle: true,
              fontFamily: 'Poppins',
            },
          },
          scales: {
            xAxes: [{
              display: true,
              gridLines: {
                display: false,
                drawBorder: false
              },
              scaleLabel: {
                display: false,
                labelString: 'Month'
              },
              ticks: {
                fontFamily: "Poppins"
              }
            }],
            yAxes: [{
              display: true,
              gridLines: {
                display: false,
                drawBorder: false
              },
              scaleLabel: {
                display: true,
                labelString: 'Value',
                fontFamily: "Poppins"

              },
              ticks: {
                fontFamily: "Poppins"
              }
            }]
          },
          title: {
            display: false,
            text: 'Normal Legend'
          }
        }
      });
    }


  } catch (error) {
    console.log(error);
  }

})(jQuery);



(function ($) {
    // USE STRICT
    "use strict";
    var navbars = ['header', 'aside'];
    var hrefSelector = 'a:not([target="_blank"]):not([href^="#"]):not([class^="chosen-single"])';
    var linkElement = navbars.map(element => element + ' ' + hrefSelector).join(', ');
    $(".animsition").animsition({
      inClass: 'fade-in',
      outClass: 'fade-out',
      inDuration: 900,
      outDuration: 900,
      linkElement: linkElement,
      loading: true,
      loadingParentElement: 'html',
      loadingClass: 'page-loader',
      loadingInner: '<div class="page-loader__spin"></div>',
      timeout: false,
      timeoutCountdown: 5000,
      onLoadEvent: true,
      browser: ['animation-duration', '-webkit-animation-duration'],
      overlay: false,
      overlayClass: 'animsition-overlay-slide',
      overlayParentElement: 'html',
      transition: function (url) {
        window.location.href = url;
      }
    });
  
  
  })(jQuery);
(function ($) {
  // USE STRICT
  "use strict";

  // Map
  try {

    var vmap = $('#vmap');
    if(vmap[0]) {
      vmap.vectorMap( {
        map: 'world_en',
        backgroundColor: null,
        color: '#ffffff',
        hoverOpacity: 0.7,
        selectedColor: '#1de9b6',
        enableZoom: true,
        showTooltip: true,
        values: sample_data,
        scaleColors: [ '#1de9b6', '#03a9f5'],
        normalizeFunction: 'polynomial'
      });
    }

  } catch (error) {
    console.log(error);
  }

  // Europe Map
  try {
    
    var vmap1 = $('#vmap1');
    if(vmap1[0]) {
      vmap1.vectorMap( {
        map: 'europe_en',
        color: '#007BFF',
        borderColor: '#fff',
        backgroundColor: '#fff',
        enableZoom: true,
        showTooltip: true
      });
    }

  } catch (error) {
    console.log(error);
  }

  // USA Map
  try {
    
    var vmap2 = $('#vmap2');

    if(vmap2[0]) {
      vmap2.vectorMap( {
        map: 'usa_en',
        color: '#007BFF',
        borderColor: '#fff',
        backgroundColor: '#fff',
        enableZoom: true,
        showTooltip: true,
        selectedColor: null,
        hoverColor: null,
        colors: {
            mo: '#001BFF',
            fl: '#001BFF',
            or: '#001BFF'
        },
        onRegionClick: function ( event, code, region ) {
            event.preventDefault();
        }
      });
    }

  } catch (error) {
    console.log(error);
  }

  // Germany Map
  try {
    
    var vmap3 = $('#vmap3');
    if(vmap3[0]) {
      vmap3.vectorMap( {
        map: 'germany_en',
        color: '#007BFF',
        borderColor: '#fff',
        backgroundColor: '#fff',
        onRegionClick: function ( element, code, region ) {
            var message = 'You clicked "' + region + '" which has the code: ' + code.toUpperCase();

            alert( message );
        }
      });
    }
    
  } catch (error) {
    console.log(error);
  }
  
  // France Map
  try {
    
    var vmap4 = $('#vmap4');
    if(vmap4[0]) {
      vmap4.vectorMap( {
        map: 'france_fr',
        color: '#007BFF',
        borderColor: '#fff',
        backgroundColor: '#fff',
        enableZoom: true,
        showTooltip: true
      });
    }

  } catch (error) {
    console.log(error);
  }

  // Russia Map
  try {
    var vmap5 = $('#vmap5');
    if(vmap5[0]) {
      vmap5.vectorMap( {
        map: 'russia_en',
        color: '#007BFF',
        borderColor: '#fff',
        backgroundColor: '#fff',
        hoverOpacity: 0.7,
        selectedColor: '#999999',
        enableZoom: true,
        showTooltip: true,
        scaleColors: [ '#C8EEFF', '#006491' ],
        normalizeFunction: 'polynomial'
      });
    }


  } catch (error) {
    console.log(error);
  }
  
  // Brazil Map
  try {
    
    var vmap6 = $('#vmap6');
    if(vmap6[0]) {
      vmap6.vectorMap( {
        map: 'brazil_br',
        color: '#007BFF',
        borderColor: '#fff',
        backgroundColor: '#fff',
        onRegionClick: function ( element, code, region ) {
            var message = 'You clicked "' + region + '" which has the code: ' + code.toUpperCase();
            alert( message );
        }
      });
    }

  } catch (error) {
    console.log(error);
  }
})(jQuery);
(function ($) {
  // Use Strict
  "use strict";
  try {
    var progressbarSimple = $('.js-progressbar-simple');
    progressbarSimple.each(function () {
      var that = $(this);
      var executed = false;
      $(window).on('load', function () {

        that.waypoint(function () {
          if (!executed) {
            executed = true;
            /*progress bar*/
            that.progressbar({
              update: function (current_percentage, $this) {
                $this.find('.js-value').html(current_percentage + '%');
              }
            });
          }
        }, {
            offset: 'bottom-in-view'
          });

      });
    });
  } catch (err) {
    console.log(err);
  }
})(jQuery);
(function ($) {
  // USE STRICT
  "use strict";

  // Scroll Bar
  try {
    var jscr1 = $('.js-scrollbar1');
    if(jscr1[0]) {
      const ps1 = new PerfectScrollbar('.js-scrollbar1');      
    }

    var jscr2 = $('.js-scrollbar2');
    if (jscr2[0]) {
      const ps2 = new PerfectScrollbar('.js-scrollbar2');

    }

  } catch (error) {
    console.log(error);
  }

})(jQuery);
(function ($) {
  // USE STRICT
  "use strict";

  // Select 2
  try {

    $(".js-select2").each(function () {
      $(this).select2({
        minimumResultsForSearch: 20,
        dropdownParent: $(this).next('.dropDownSelect2')
      });
    });

  } catch (error) {
    console.log(error);
  }


})(jQuery);
(function ($) {
  // USE STRICT
  "use strict";

  // Dropdown 
  try {
    var menu = $('.js-item-menu');
    var sub_menu_is_showed = -1;

    for (var i = 0; i < menu.length; i++) {
      $(menu[i]).on('click', function (e) {
        e.preventDefault();
        $('.js-right-sidebar').removeClass("show-sidebar");        
        if (jQuery.inArray(this, menu) == sub_menu_is_showed) {
          $(this).toggleClass('show-dropdown');
          sub_menu_is_showed = -1;
        }
        else {
          for (var i = 0; i < menu.length; i++) {
            $(menu[i]).removeClass("show-dropdown");
          }
          $(this).toggleClass('show-dropdown');
          sub_menu_is_showed = jQuery.inArray(this, menu);
        }
      });
    }
    $(".js-item-menu, .js-dropdown").click(function (event) {
      event.stopPropagation();
    });

    $("body,html").on("click", function () {
      for (var i = 0; i < menu.length; i++) {
        menu[i].classList.remove("show-dropdown");
      }
      sub_menu_is_showed = -1;
    });

  } catch (error) {
    console.log(error);
  }

  var wW = $(window).width();
    // Right Sidebar
    var right_sidebar = $('.js-right-sidebar');
    var sidebar_btn = $('.js-sidebar-btn');

    sidebar_btn.on('click', function (e) {
      e.preventDefault();
      for (var i = 0; i < menu.length; i++) {
        menu[i].classList.remove("show-dropdown");
      }
      sub_menu_is_showed = -1;
      right_sidebar.toggleClass("show-sidebar");
    });

    $(".js-right-sidebar, .js-sidebar-btn").click(function (event) {
      event.stopPropagation();
    });

    $("body,html").on("click", function () {
      right_sidebar.removeClass("show-sidebar");

    });
 

  // Sublist Sidebar
  try {
    var arrow = $('.js-arrow');
    arrow.each(function () {
      var that = $(this);
      that.on('click', function (e) {
        e.preventDefault();
        that.find(".arrow").toggleClass("up");
        that.toggleClass("open");
        that.parent().find('.js-sub-list').slideToggle("250");
      });
    });

  } catch (error) {
    console.log(error);
  }


  try {
    // Hamburger Menu
    $('.hamburger').on('click', function () {
      $(this).toggleClass('is-active');
      $('.navbar-mobile').slideToggle('500');
    });
    $('.navbar-mobile__list li.has-dropdown > a').on('click', function () {
      var dropdown = $(this).siblings('ul.navbar-mobile__dropdown');
      $(this).toggleClass('active');
      $(dropdown).slideToggle('500');
      return false;
    });
  } catch (error) {
    console.log(error);
  }
})(jQuery);
(function ($) {
  // USE STRICT
  "use strict";

  // Load more
  try {
    var list_load = $('.js-list-load');
    if (list_load[0]) {
      list_load.each(function () {
        var that = $(this);
        that.find('.js-load-item').hide();
        var load_btn = that.find('.js-load-btn');
        load_btn.on('click', function (e) {
          $(this).text("Loading...").delay(1500).queue(function (next) {
            $(this).hide();
            that.find(".js-load-item").fadeToggle("slow", 'swing');
          });
          e.preventDefault();
        });
      })

    }
  } catch (error) {
    console.log(error);
  }

})(jQuery);
(function ($) {
  // USE STRICT
  "use strict";

  try {
    
    $('[data-toggle="tooltip"]').tooltip();

  } catch (error) {
    console.log(error);
  }

  // Chatbox
  try {
    var inbox_wrap = $('.js-inbox');
    var message = $('.au-message__item');
    message.each(function(){
      var that = $(this);

      that.on('click', function(){
        $(this).parent().parent().parent().toggleClass('show-chat-box');
      });
    });
    

  } catch (error) {
    console.log(error);
  }

})(jQuery);