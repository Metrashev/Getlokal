(function ($) {
  jQuery(function () {

    $(document).on('click', "#getpilot .vote-action a.vote", function (e) {
      e.preventDefault();
      var $a = $(this);
      var $element = $a.parents('.element');
      if (!$element.hasClass('can_vote')) {
        return;
      }
      $.ajax({
        type: 'GET',
        url: $a.attr('href'),
        beforeSend: function () {
          $a.addClass('ld');
        },
        success: function (r) {
          $a.removeClass('ld');

          if (!r.status) {
            if (r.not_authenticated) {
              window.location = $("#auth-url").val();
            }
          } else {
            $element.removeClass('can_vote').addClass('is_voted');
            $element.find('.status-text').html('Ai votat');
            $element.find('.count b').html(r.count);
            $("#getpilot .bottom .element.can_vote").each(function () {
              $(this).removeClass('can_vote').addClass('disabled');
            });
            setTimeout(function () {
              $element.find('.thanks').slideDown(function () {
                openShareOverlay();
              });
            }, 200);
          }
        }
      })
    }); 

    $(document).on('click', '#getpilot .scroll-down', function () {
      $('html, body').animate({
        scrollTop: $("#getpilot .top").position().top - 10
      });
    });

    $(document).on('click', '.share-overlay a', function (e) {
      e.preventDefault();
      var href = $(this).attr('href');
      window.open(href, '', 'width=600. height=300');
    });

    $(document).on('click', '.share-overlay .close', closeShareOverlay);


    function openShareOverlay() {
      $('body').css('overflow', 'hidden') ;
      $('.share-overlay').fadeIn(100, function () {
        $('.share-overlay .buttons').animate({
          top: '40%',
          opacity: 1,
        }, 500);
        setTimeout(function () {
          $('.share-overlay .close:not(.no-animate)').css('left', '50%');
        }, 1500);
      });
    }


    function closeShareOverlay() {
      $('.share-overlay .buttons').animate({
        top: '-10%',
        opacity: 0
      }, function () {
        $('.share-overlay').fadeOut(function () {
          $('body').css('overflow', 'auto');
        });
      });
    }
    window.openOverlay = openShareOverlay;
    window.closeOverlay = closeShareOverlay;

  });
})(jQuery);