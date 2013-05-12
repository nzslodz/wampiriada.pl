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
})
