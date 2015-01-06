<?php 

use_helper('TimeStamps');

$module = $sf_request->getParameter('module');
$action = $sf_request->getParameter('action');

$username = $comment->getUserProfile()->getSfGuardUser()->getUsername();
if ($module=='list' && $action=='show' && count($comment->getUserProfile()->getListPage())>0 ):
$user_tab= url_for('@user_page?username='.$username.'&listTab=true#lists_tab');
endif;
if ($module=='event' && $action=='show' && count($comment->getUserProfile()->getEvent())>0 ):
$user_tab= url_for('@user_page?username='. $username.'&eventTab=true#events_tab');
endif;?>
<li>
	<div class="comments" id="comment-<?php echo $comment->getId() ?>">
		<div
			class="comment-image">
			<?php echo $comment->getUserProfile()->getLink(0, 'size=80x80', ESC_RAW) ?>
			<!-- 			<img src="http://lorempixel.com/80/80/" alt=""> -->
		</div>
		<!-- comment-image -->

		<div class="comment-content">
			<div class="comment-content-head">
				<div class="name-rating">
					<h3>
						<?php if (isset($user_tab)):?>
						<a class="user" title="<?php echo $comment->getUserProfile()?>"
							href="<?php echo  $user_tab ?> "><b><?php echo $comment->getUserProfile()?>
						</b> </a>
						<?php else:?>
						<a class="user" title="<?php echo $comment->getUserProfile()?>"
							href="<?php echo  url_for('@user_page?username='. $comment->getUserProfile()->getSfGuardUser()->getUsername()) ?>"><b><?php echo $comment->getUserProfile()?>
						</b> </a>
						<?php endif;?>
					</h3>
				</div>
				<p>
					<?php echo ezDate(date('d.m.Y H:i', strtotime($comment->getCreatedAt()))); ?>
				</p>
				<!-- comment-content-head -->
				<div class="clearfix"></div>

				<div class="ajax"></div>
			</div>

			<div class="comment-content-body">
				<p class="comment lists-comment">
					<?php
					$parent = $comment->getParent();
					if($parent != null && $parent->getRank()){
				      	echo __('Reply to Comment')."#".$parent->getRank(); 
				    }
					?>
					<span class="comment-txt"> <?= $comment->getBody() ?>
					</span>
				</p>
				<!-- comment -->
				<div class="clearfix"></div>
				<div class="vote-report">				
				<?php include_partial('like/like', array('object' => $comment->getActivityComment()));?>
				
				<?php if($user && $comment->getUserId() != $user->getId()): ?>
				<a href="javascript:void(0);" data="<?php echo url_for('report/comment?id='.$comment->getId()) ?>"
					class="report"><?php echo __('report')?> </a>
				<?php endif ?>
				</div><!-- vote-report -->

				<!-- vote-report -->

				<?php if($user && $user->getId() != $comment->getUserId()):?>
				<a href="javascript:void(0);" data="<?php echo url_for('comment/reply?id='.$comment->getId())?>"
					class="reply"><?php echo __('reply')?> </a>
				<?php endif;?>

			</div>
			<!-- comment-content-body -->
		</div>
		<!-- comment-content -->
		</div>
		<!-- comments -->
</li>
