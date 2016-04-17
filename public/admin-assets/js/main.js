$(function() {
    $('#accept-form').each(function() {
        var me = $(this)

        var accept = me.find('[name=accept]')
        var reject = me.find('[name=reject]')
        var processing = me.find('[name=processing]')

        me.find('[data-accept]').click(function() {
            accept.val('yes')
            reject.val('')
            processing.val('')

            me.submit()
        })

        me.find('[data-reject]').click(function() {
            accept.val('')
            processing.val('')
            reject.val('yes')

            me.submit()
        })
        
        me.find('[data-processing]').click(function() {
            accept.val('')
            processing.val('yes')
            reject.val('')

            me.submit()
        })

        me.find('[data-new]').click(function() {
            accept.val('')
            reject.val('')
            processing.val('')

            me.submit()
        })
    })
  $('#confirmAction').on('show.bs.modal', function (e) {
      $message = $(e.relatedTarget).attr('data-message');
      $(this).find('.modal-body p').text($message);
      $title = $(e.relatedTarget).attr('data-title');
      $(this).find('.modal-title').text($title);

      // Pass form reference to modal for submission on yes/ok
      var form = $(e.relatedTarget).closest('form');
      $(this).find('.modal-footer #confirm').data('form', form).data('loading-text', $(e.relatedTarget).data('loading-text'));
  });

  // Form confirm (yes/ok) handler, submits form
  $('#confirmAction').find('.modal-footer #confirm').on('click', function(){
      $(this).data('form').submit();
      $(this).button('loading')
  });

    $('[data-calculate=overall]').each(function() {
        var target = $(this)
        var sources = $('[data-calculate=source]')

        sources.change(function() {
            sum = 0

            sources.each(function() {
                var val = parseInt($(this).val())

                if(isNaN(val)) {
                    val = 0
                }
                
                sum += val
            })

            target.val(sum)
        })
    })
})
