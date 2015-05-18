$(function() {
    $('a.button').click(function() {
        $.scrollTo($($(this).attr('href')), 500);//przewijanie do nastepnej sekcji
        
        return false;
    })

	
	//sortowanie tabelki
    $('.isotope').isotope({
        getSortData: {
            name: function($elem) {
                return $elem.find('p.place').data('sort')
            }
        }
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
        lat: 51.7731179,
        lng: 19.4805926,
		zoom: 12,
      });
	  
	  $('.isotope li').each(function() {
		var me = $(this)
		
		me.click(function() {
			map.removeMarkers()
			map.addMarker ({
				lat: me.data('lat'),
				lng: me.data('lng'),
				title: me.find('.place').text(),
                infoWindow: {
                    content: me.find('.place').text(),
                },
			})
		})
	  })
    });
})
