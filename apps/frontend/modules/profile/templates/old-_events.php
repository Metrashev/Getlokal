<?php use_stylesheet('ui-lightness/jquery-ui-1.8.16.custom.css'); ?>
<?php foreach ($pager->getResults() as $event):?>
      <?php  $attending = ($event->getIsAttendedByUser($pageuser)) ? true : false;?>
        <?php /*
            <li class="user_event <?php echo ($attending ? 'attend' : 'my_event') ?>">
              <?php include_partial('event/event', array('event' => $event)) ?>
              
              <div class="review_interaction">
                <?php if($is_current_user): ?>
                  <?php if ($event->getUserProfile()->getId() == $user->getId()):?>
                      <a class="list_delete" href="<?php echo url_for('profile/deleteEvent?event_id='.$event->getId() )?>"><?php echo __('delete')?></a>
                      <a class="list_edit" href="<?php echo url_for('event/edit?id='.$event->getId() )?>" ><?php echo __('edit')?></a>
                        <?php else: ?>
                            <a id="<?php echo $event->getId()?>" href="javascript:void(0);" data="<?php echo url_for('report/event?id='.$event->getId()) ?>" class="report"><?php echo __('report')?></a>
                        <?php endif ?>
                      <?php else: ?>
                          <a id="<?php echo $event->getId()?>" href="javascript:void(0);" data="<?php echo url_for('report/event?id='.$event->getId()) ?>" class="report"><?php echo __('report')?></a>
                      <?php endif ?>
                    </div>
                    <div class="ajax"></div>
                    <div class="clear"></div>
            </li>
           */ ?>
      
      <li class="events-redesign">
        <div class="list-event-redesign">
            <h3><a href="<?php echo url_for('event/show?id='.$event->getId());?>" title="<?php echo ($event->getDisplayTitle() ? $event->getDisplayTitle() : $event->getImage()->getCaption());?>"><?php echo ($event->getDisplayTitle() ? $event->getDisplayTitle() : $event->getImage()->getCaption());?></a></h3>
            <div class="event-town">
              Sofia
            </div><!-- event-town -->
            <div class="picture-container">
              <div class="event-redesign-picture">
                  <div class="show-on-hover">
                    <?php if($is_current_user): ?>
                      <?php if ($event->getUserProfile()->getId() == $user->getId()):?>
                        <a class="list_delete" href="<?php echo url_for('profile/deleteEvent?event_id='.$event->getId() )?>"><?php echo __('delete')?></a><br>
                        <a class="list_edit" href="<?php echo url_for('event/edit?id='.$event->getId() )?>" onclick='setEditAttribute()'><?php echo __('edit')?></a><br>
                      <?php else: ?>
                        <a  class="report" id="<?php echo $event->getId()?>" href="javascript:void(0);" data="<?php echo url_for('report/event?id='.$event->getId()) ?>"><?php echo __('report')?></a>
                      <?php endif ?>
                    <?php else: ?>
                      <a  class="report" id="<?php echo $event->getId()?>" href="javascript:void(0);" data="<?php echo url_for('report/event?id='.$event->getId()) ?>"><?php echo __('report')?></a>
                    <?php endif ?>
                  </div><!-- show-on-hover -->
                  <a href="#">
                    <?php 
                      if ($event->getImage()->getType()=='poster' ):
                        echo image_tag($event->getThumb('preview'),array('size'=>'101x135', 'alt'=>($event->getDisplayTitle() ? $event->getDisplayTitle() : $event->getImage()->getCaption())));
                      else:
                        echo image_tag($event->getThumb(2), array( 'size'=>'178x135', 'alt'=>($event->getDisplayTitle() ? $event->getDisplayTitle() : $event->getImage()->getCaption()) ) );
                      endif;
                    ?>
                    <?php if($event->hasTickets()):?>
                      <div class="has-ticket"><i class="fa fa-ticket"></i><?php echo __('Tickets Available', null, 'events');?></div>
                    <?php endif;?>
                  </a>
              </div><!-- event-redesign-picture -->
            </div><!-- picture-container -->
            <div class="event-redesign-date">
              <?php
                $start_at = $event->getDateTimeObject('start_at');
                $end_at = $event->getDateTimeObject('end_at');
                
                  if ($start_at->format('H:i:s') == '00:00:00') :
                  $from = $start_at->format('d.m.Y');
                else:
                  $from = $start_at->format('d.m.Y H:i')."h";
                endif;
                
                $to = false;
                
                if($end_at->format("dmYHis") != $start_at->format("dmYHis")){
                  if ($end_at->format('H:i:s') == '00:00:00') :
                    $to = $end_at->format('d.m.Y');
                  else:
                    $to = $end_at->format('d.m.Y H:i')."h";
                  endif;
                } 
              ?>
                <?php echo __("From",null,"events")?> : <span class="black"> <?php echo $from ?></span>
                <br>
                <?php echo __("To",null,"events")?> : <span class="black"> <?php echo $to?></span>
            </div><!-- event-redesign-date -->
            <div class="event-redesign-location">
              <span>
              <?php if ($page= $event->getFirstEventPage()): ?>
                    <?php echo link_to_company($page->getCompanyPage()->getCompany()) ?> 
              <?php endif;?>
            </span>
            <br>
             <?php $city_id = !empty($city) ? $city->getId() : "current" ?>
             <a href="<?php echo "/{$sf_user->getCulture()}/events/current/".$event->getCategoryId(); ?>" class="redesign-category" title="<?php echo $event->getCategory() ?>" ><?php echo $event->getCategory();?></a></p>
            </div><!-- event-redesign-location -->
        </div><!-- list-event-redesign --> 
        <div class="ajax"></div>
        <div class="clear"></div>
      </li>
          <?php endforeach;?>
<div id="dialog-confirm" title="<?php echo __('Deleting Event', null, 'messages') ?>" style="display:none;">
        <p><?php echo __('Are you sure you want to delete your event?', null, 'messages') ?></p>
</div>
<div id="dialog-empty-popup" class="asdasd" title="<?php echo __('Deleting Event', null, 'messages') ?>" style="display:none;">
        
</div>
   
<script type="text/javascript">
    $(document).ready(function() {
        
      function setEditAttribute(){
        <?php $sf_user->setAttribute('profile.edit.event', 'event/edit'); ?>
      }

      var loading= false;

      $('.reply, .report').live("click", function(){
            var href = $(this).attr('data');
            
            if(loading) return false;

            var element = $(this).parent().parent().parent().parent().parent().children('.ajax');
      var element = $("#dialog-empty-popup");
      element.dialog('open');            
            $(".ui-dialog").css("z-index", "2");
            loading = true;
            $.ajax({
                url: href,
                beforeSend: function() {
                 $(element).html('<img src="/images/gui/blue_loader.gif"/>');
                },
                success: function(data, url) {
                  element.html(data);
                  loading = false;
                  if ($('.profile_event_scroll').length > 0) {
                      if ($('.profile_event_scroll .scrollbar').length > 0) {
                      $('.profile_event_scroll').tinyscrollbar_update('relative');
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

/*Delete review */
        $('a.list_delete').live('click',function(event) {
          var deleleReviewLink = $(this).attr('href');
            $("#dialog-confirm").data('id', deleleReviewLink).dialog('open');
            
            $(".ui-dialog").css("z-index", "2");
          
            return false;        
    
        });
/*END Delete review */  
    });

$("#dialog-confirm").dialog({
        
        resizable: false,
        autoOpen: false,
        height: 250,
        width:340,
        buttons: {
            "<?php echo __('delete', null) ?>": function() {
                 window.location.href =  $("#dialog-confirm").data('id');
            },
        <?php echo __('cancel', null) ?>: function() {
          $(this).dialog("close");
      }
    }
  });

$("#dialog-empty-popup").dialog({
    dialogClass: 'report-popup',
    resizable: false,
    autoOpen: false,
    height: 540,
    width:550    
});
  
    $(".user_event").live({
        mouseenter : function() {
            $(this).children('div.review_interaction').children("a.report,a.list_report,a.edit,a.list_edit,a.delete,a.list_delete").fadeIn("fast");
        },
        mouseleave : function() {
            $(this).children('div.review_interaction').children("a.report,a.list_report,a.edit,a.list_edit,a.delete,a.list_delete").fadeOut("fast");
        }    
});

    $(".report").click(function(){
    $("#dialog-empty-popup").dialog({
    dialogClass: 'report-popup',
    resizable: false,
    autoOpen: false,
    height: 540,
    width:550    
    }).show();
    });
</script>