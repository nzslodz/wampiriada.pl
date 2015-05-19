$(function() {
    $('a.button').click(function() {
        $.scrollTo($($(this).attr('href')), 500);//przewijanie do nastepnej sekcji
        
        return false;
    })

    var source = $('#map-item-template').html()
    var template = Handlebars.compile(source)
	
	//sortowanie tabelki
    $('.isotope').isotope({
        getSortData: {
            name: function(elem) {
                return $(elem).find('p.place').data('sort')
            }
        }
    })

    $(window).resize(function() {
        $('.isotope').isotope('reloadItems').isotope()
    })

    $('.sorting a').click(function() {
        var me = $(this)
        var option = me.data('option-value')
        
        if(me.hasClass('active')) {
            return false;
        }

        $('.sorting a').toggleClass('active')
        $('.isotope').isotope({sortBy: option})

        return false;
    })

	
	//wykres na stronie
var chart = new CanvasJS.Chart("magicalchart", {
    backgroundColor: 'rgb(75, 0, 0)',
    axisX: {
        gridThickness: 0,
        tickThickness: 0,
        labelFontColor: "rgba(0,0,0,0)"
    },
    axisY: {
        gridThickness: 0,
        maximum: 1000,
        labelFontColor: "#fff"
    },
    
    data: [
      {
        indexLabelFontColor: "#fff",
        indexLabelLineColor: "rgba(255,255,255,0.6)",
        type: "pie",
        dataPoints: [
        { y: $('#magicalchart').data('a-plus'), label: "A+" },
        { y: $('#magicalchart').data('a-minus'), label: "A-" },
        { y: $('#magicalchart').data('b-plus'), label: "B+" },
        { y: $('#magicalchart').data('b-minus'), label: "B-" },
        { y: $('#magicalchart').data('zero-plus'), label: "0+" },
        { y: $('#magicalchart').data('zero-minus'), label: "0-" },
        { y: $('#magicalchart').data('ab-plus'), label: "AB+" },
        { y: $('#magicalchart').data('ab-minus'), label: "AB-" },
        { y: $('#magicalchart').data('unknown'), label: "Nieznana" }
        ]
      }
      ]
    });
    chart.render();//renderuje wykres


    //script z map google (example: markers)
    var map;
    $(document).ready(function(){
      map = new GMaps({
        el: '#map',
        lat: 51.770,
        lng: 19.459,
		zoom: 13,
        disableDefaultUI: true,
        scrollwheel: false,
        navigationControl: false,
        mapTypeControl: false,
        scaleControl: false,
        draggable: false,
      });
	  
      var items = $('.isotope li')

	  items.each(function() {
		var me = $(this)

		me.click(function() {
            items.removeClass('active')
			map.removeMarkers()
            
            me.addClass('active')
            
            var title = me.find('.place').text()
            var address = me.find('.place').data('address')

			map.addMarker ({
				lat: me.data('lat'),
				lng: me.data('lng'),
				title: me.find('.place').text(),
                infoWindow: {
                    content: template({
                        title: title,
                        address: address,
                        day: me.find('.date').text(),
                        time: me.find('.time').text(),
                    }),
                },
			});
            
            if(ResponsiveBootstrapToolkit.is('<md')) {
                $.scrollTo($('#map'), 500)
            }

            map.markers[0].infoWindow.open(map.map,map.markers[0]);
		})
	  })
    });
})
