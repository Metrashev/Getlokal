<?php use_helper('TimeStamps');?>
<?php if ($sf_request->getParameter('module')=='list' && $sf_request->getParameter('action')=='show' && count($comment->getUserProfile()->getListPage())>0 ):?>
	<?php $user_tab= url_for('@user_page?username='. $comment->getUserProfile()->getSfGuardUser()->getUsername().'&listTab=true#lists_tab');?>
<?php endif;?>
<?php if ($sf_request->getParameter('module')=='event' && $sf_request->getParameter('action')=='show' && count($comment->getUserProfile()->getEvent())>0 ):?>
	<?php $user_tab= url_for('@user_page?username='. $comment->getUserProfile()->getSfGuardUser()->getUsername().'&eventTab=true#events_tab');?>
<?php endif;?>
<div class="review review_list_company" id="comment-<?php echo $comment->getId() ?>">
  <span class="review_date"><?php echo ezDate(date('d.m.Y H:i', strtotime($comment->getCreatedAt()))); ?></span>
  <span class="review_comment_num"><?php echo __('Comment')?> #<?php echo $comment->getRank() ?> <?php echo __('from')?> </span>
  
  <?php if (isset($user_tab)):?>
  	<a class="user" title="<?php echo $comment->getUserProfile()?>" href="<?php echo  $user_tab ?> "><b><?php echo $comment->getUserProfile()?></b></a>
  <?php else:?>
  	<a class="user" title="<?php echo $comment->getUserProfile()?>" href="<?php echo  url_for('@user_page?username='. $comment->getUserProfile()->getSfGuardUser()->getUsername()) ?>"><b><?php echo $comment->getUserProfile()?></b></a>
  <?php endif;?>
  
  <?php if($parent = $comment->getParent()): ?>
    <?php echo __('Reply to Comment')?> #<?php echo $comment->getParent()->getRank() ?>
  <?php endif ?>
  <br />
   
  <?php //echo $comment->getDateTimeObject('created_at')->format('d / m / Y') ?>
 
  <?php echo $comment->getUserProfile()->getLink(0, 'size=100x100', 'class=review_list_img', ESC_RAW) ?>

  <div class="review_content">

    <p><?php echo simple_format_text($comment->getBody()) ?></p>

  </div>
  
  <div class="review_interaction">
  <?php include_partial('like/like', array('object' => $comment->getActivityComment())) ?>
  
	  <?php if($user && $comment->getUserId() != $user->getId()): ?>
	    <a href="javascript:void(0);" data="<?php echo url_for('report/comment?id='.$comment->getId()) ?>" class="report"><?php echo __('report')?></a>
	  <?php endif ?>
	  
	  <?php if($user && $user->getId() != $comment->getUserId()):?>
	    <a href="javascript:void(0);" data="<?php echo url_for('comment/reply?id='.$comment->getId())?>" class="reply"><?php echo __('reply')?></a>
	  <?php endif;?>
	 
  </div>
  
  <div class="ajax"></div>
</div>
