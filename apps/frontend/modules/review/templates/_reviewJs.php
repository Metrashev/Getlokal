<?php ?>
<script type="text/javascript">
$(document).ready(function() {
  var loading= false;

    $('.like').on("click", function(){
   	 var element = this;
      if(loading) return false;
      
      loading = true;
      
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
    });
    
$('.review-content-body').on('click', '.edit', function(){
    var element = $(this);
    var container = element.parent().parent().parent().find('div.review-content-body');
    var href = $(this).attr('data');
    if(loading) return false;
    
    loading = true;

    $.ajax({
        url: href,
        beforeSend: function() {
          container.html(LoaderHTML);
        },
        success: function(data, url) {
          container.html(data);
          loading = false;
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
  });

  $('.reply, .report').on("click", function(){
      var href = $(this).attr('data');
      if(loading) return false;

      var element = $(this).parent().parent().children('.ajax');
      element.css('display', 'block');
      loading = true;

      $.ajax({
          url: href,
          beforeSend: function() {
        	 $(element).html(LoaderHTML);
          },
          success: function(data, url) {
        	 element.html(data);
            loading = false;
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
    });
}) 
</script>