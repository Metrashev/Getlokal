<?php use_helper('Date');?>
<?php use_helper('TimeStamps');?>
<p class="review_date"><?php echo ezDate(date('d.m.Y H:i', strtotime($review->getCreatedAt()))); ?></p>
<a href="javascript:void(0);" data="<?php echo url_for('review/edit?review_answer_id='. $review->getId())?>" class="edit"><?php echo __('edit')?></a>
<?php echo link_to(__('delete'), 'review/deleteReview?review_id='. $review->getId().'&company_id='.$review->getCompanyId(), array('class'=>'delete')); ?>
<?php echo simple_format_text($review->getText()) ?>