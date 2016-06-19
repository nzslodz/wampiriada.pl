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

  var modal = $('#prizeModal').on('show.bs.modal', function(e) {
      var target = $(e.relatedTarget)
      var description = target.find('[data-description]').text()
      var claimed = !!target.data('claimed')

      var modal = $(this)

      modal.find('form').attr('action', path('admin/wampiriada/prize/' + target.data('id')))
      modal.find('[data-claimed], [data-not-claimed]').hide()
      modal.find('#message-description').val(description)
      modal.find('[data-claimed]').toggle(claimed)
      modal.find('[data-not-claimed]').toggle(!claimed)
  })


  $('[data-tooltip]').tooltip()

  $('[data-card]').each(function(){
      var me = $(this)
      timeoutfunc = function(me) {
          setTimeout(function () {
              if(!$(".popover:hover").length) {
                  me.popover("hide");
              }
          }, 400);
      }

      me.popover({
          trigger: 'manual',
          html: true,
          content: function(){
              if (me.data('content')) {
                  return me.data('content')
              }

              me.data('content', $.ajax({
                  url: path('admin/activity/card/' + me.data('card')),
                  dataType: 'html',
                  async: false
              }).responseText)

              return me.data('content')
          },
          title: me.text(),
      }).on("mouseenter", function () {
          me.popover("show");
          $(".popover").off('mouseleave').on("mouseleave", function () {
              timeoutfunc(me)
          });
      }).on("mouseleave", function () {
          timeoutfunc(me)
      });
  })

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
