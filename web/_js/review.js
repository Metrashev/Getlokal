var review = {
  loading: false,
  edit: function() {
    $('.review .edit').click(function() {
      var element = $(this).parent().find('.review_content');
      var href = $(this).attr('data');
      if(review.loading) return false;
      
      review.loading = true;

      $.ajax({
          url: href,
          beforeSend: function() {
            element.html('loading...');
          },
          success: function(data, url) {
            element.html(data);
            review.loading = false;
            if ($('.profile_review_scroll').length > 0) {
                if ($('.profile_review_scroll .scrollbar').length > 0) {
            		$('.profile_review_scroll').tinyscrollbar_update('relative');
                }
            }
            //console.log(id);
          },
          error: function(e, xhr)
          {
            console.log(e);
          }
      });
      return false;
    })
  },
  initLike: function() {
    $('a.like').click(function() {
       var element = $(this);
      
      if(review.loading) return false;
      
      review.loading = true;
      
      $.ajax({
          url: this.href,
          beforeSend: function() {
            element.html('loading...');
          },
          success: function(data, url) {
            element.html(data.html());
            review.loading = false;
          }
      });
      
      return false;
    })
  },
  reply: function() {
    
    $('.reply, .report').live('click',function() {
    	$('.sidebar').find('.ajax').css('display', 'none');
    	$('.sidebar').find('.add_review').css('display', 'none');
      var element = $(this).parent().parent().children('.ajax');
      element.css('display', 'block');
      var href = $(this).attr('data');
      if(review.loading) return false;
      
      review.loading = true;
      
      //console.log($(element));
      
      $.ajax({
          url: href,
          beforeSend: function() {
            $(element).html('<img src="/images/gui/blue_loader.gif"/>');
          },
          success: function(data, url) {
            element.html(data);
            review.loading = false;
            if ($('.profile_review_scroll').length > 0) {
                if ($('.profile_review_scroll .scrollbar').length > 0)
            		$('.profile_review_scroll').tinyscrollbar_update('relative');
            }
            //console.log(id);
          },
          error: function(e, xhr)
          {
            console.log(e);
          }
      });
      return false;
    })
  },
  init: function() {
    review.edit();
    review.reply();
  }
}