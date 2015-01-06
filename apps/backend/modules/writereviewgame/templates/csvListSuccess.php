<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8">
</head>

<table cellspacing="0">
    <thead>
      <tr>
<th class="sf_admin_text sf_admin_list_th_first_name">
  <?php echo __('Name', array(), 'messages') ?>
</th>
<th class="sf_admin_text sf_admin_list_th_email_address">
  <?php echo __('Email address', array(), 'messages') ?>
</th>
<th class="sf_admin_text sf_admin_list_th_vouchers">
  <?php echo __('Vocuhers', array(), 'messages') ?>
</th>
<th class="sf_admin_text sf_admin_list_th_date_issued">
  <?php echo __('Date  Issued', array(), 'messages') ?>
</th>
      </tr>
    </thead>
  <tbody>
  <?php $from = null; $to =null;?>
  <?php $date_val= $filters['review_created_at']->getValue();?> 
  <?php if (empty($date_val['from']['month']) or empty($date_val['from']['day'])):
  $week = $filters['week_id']->getValue();   
  if ($week['text']):  
  $year = date('Y');
  $next_week = $week['text']+1;
  $from = date('Y-m-d', strtotime($year."W".$week['text'].'1'));
  $to = date('Y-m-d', strtotime($year."W".$next_week.'1'));
  $from = $from .' 00:00:00';
  $to = $to.' 00:00:00';
  endif;
  else: 

   $date_val = $filters['review_created_at']->getValue();
    if ($date_val['from']['month'] && $date_val['from']['day']):
     $from =$date_val['from']['year'] .'-'.$date_val['from']['month'].'-'.$date_val['from']['day'].' '.$date_val['from']['hour'].':'.$date_val['from']['minute'].':00';
   endif;
    if ($date_val['to']['month'] && $date_val['to']['day']):
     $to = $date_val['to']['year'] .'-'.$date_val['to']['month'].'-'.$date_val['to']['day'].' '.$date_val['to']['hour'].':'.$date_val['to']['minute'].':00';
   endif;
  endif;
  ?>

  <?php foreach ($pager->getResults() as $i => $user_profile): 
  $odd = fmod(++$i, 2) ? 'odd' : 'even' ?>
     <tr class="sf_admin_row <?php echo $odd ?>">
   <td class="sf_admin_text sf_admin_list_td_first_name">
  <?php echo $user_profile; ?>
</td>
<td class="sf_admin_text sf_admin_list_td_email_address">
  <?php echo $user_profile->getEmailAddress() ?>
</td>
<?php
  $user_review_vouchers = $user_profile->getVouchersReviews($from, $to);
  $count = count($user_review_vouchers);?>


  <?php 
if ($count == 1 ): ?>
<td class="sf_admin_text sf_admin_list_td_vouchers">
<?php echo $user_review_vouchers[0]->getVoucher(); ?>
</td>
<td class="sf_admin_text sf_admin_list_td_vouchers">
<?php echo $user_review_vouchers[0]->getDateIssued();?>
</td>
<?php else:?>
<td class="sf_admin_text sf_admin_list_td_vouchers">
<?php echo $count; ?>
</td>
<td class="sf_admin_text sf_admin_list_td_vouchers">
<?php foreach ($user_review_vouchers as $voucher): ?>

<?php echo $voucher->getVoucher() .' - '. $voucher->getDateIssued().'</br>';?>

<?php 
$voucher->free();
endforeach; ?>
</td>
<?php endif;
?>

 

<?php  $user_review_vouchers->free();
$user_profile->free();?>
     </tr>
  <?php endforeach; ?>
  </tbody>
  </table>

