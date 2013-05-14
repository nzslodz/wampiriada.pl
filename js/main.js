$(function() {
    $('a.button').click(function() {
        $.scrollTo($($(this).attr('href')), 500);
        
        return false;
    })

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

chart.render();

})
