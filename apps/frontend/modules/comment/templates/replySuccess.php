<div class="review-content">
<form action="<?php echo url_for( 'comment/reply?id='. $comment->getId() ) ?>" method="post" class="replyForm">
  <div class="form-review-content">
    <h3><?php echo __('Leave Comment', null, 'messages'); ?></h3>
    <?php echo $form['body'] ?>
  </div>
  <div class="form_box form-review-actions ">
    <input type="submit" class="default-btn success publish-btn" value="<?php echo __('Publish');?>" class="input_submit" />
    <a href="javascript: void(0)" class="close_form_report"><?php echo __('Close') ?></a>
  </div>
  <?php echo $form['_csrf_token'] ?>
</form>
</div>

<?php if($sf_request->isXmlHttpRequest()): ?>
<script type="text/javascript">
  // enclose in function to separate from global scope
  (function () {
    $(".close_form_report").click(function() {
      $(this).parent().parent().parent().html("").css('display', 'none');
    });

    var loading = false;

    $('#comment-<?php echo $comment->getId() ?> .replyForm').submit(function(e) {
      e.preventDefault();
      if (loading) {
        return false;
      }
	  $(".new_reply").removeClass("new_reply");
	  var element = $("<li class='new_reply'></li>");
      $("ul.user-comment").prepend(element);//$(this).parent().parent().parent();
      var comment_pager_url = '';
      if ($('#pager_url').length > 0) {
        comment_pager_url = $('#pager_url')[0].value;
      }

      loading = true;
       $.ajax({
          url: this.action,
          type: 'POST',
          data: $(this).serialize() + '&pager_url=' + comment_pager_url,
          beforeSend: function() {
            element.html(LoaderHTML);
            $('html, body').animate({
                scrollTop: element.offset().top + 'px'
            }, 'fast');
          },
          success: function(data, url) {
            loading = false;
            //$(element).html($(data).html());
            element.html($(data).html())
            $(".close_form_report").trigger("click");
          },
          error: function(e, xhr)
          {
            loading = false;
            console.log(e);
          }
      });

      return false;
    });
  })();

</script>
<?php endif ?>
