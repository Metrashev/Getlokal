$(document).ready(function() {
	var pause = false;
  var max = $('.carousel_content li').length -1;
  var _x = -1;
  var _f = 0;


  var change = function() {
    $('.carousel_dots .carousel_dot').removeClass('active');
    $('.carousel_dots .carousel_dot:nth-child('+ (_x + 1) +')').addClass('active');

    $('.carousel_content ul li').animate({opacity:0.3}, 200, function() {
    	$('.carousel_content ul').css({left: (_x * -600) + 'px'});
    	$('.carousel_content ul li:nth-child('+ (_x + 1) +')').animate({opacity:1}, 200);
    });

    _f = 0;
  };

  var next = function() {
    _x++;
    if(_x > max) _x = 0;
    change();
  };

  $('.carousel_dots .carousel_dot').click(function() {
    var index = $(this).parent().children().index(this);
    if(_x != index)
    {
      _x = index;
      change();
    }

    return false;
  });

  $('.carousel_wrapper').hover(function() {
	 	pause = true;
  }, function() {
    pause = false;
  });

  setInterval(function() {
    if(pause) return;
    _f++;
    if(_f>10) {
      next();
    }
  }, 1000);

  next();
});