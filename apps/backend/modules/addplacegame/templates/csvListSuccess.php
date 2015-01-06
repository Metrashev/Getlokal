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
<th class="sf_admin_text sf_admin_list_th_approved_places">
  <?php echo __('Approved places', array(), 'messages') ?>
</th>
      </tr>
    </thead>
  <tbody>
   <?php $from = null; $to =null;?>
  <?php $date_val= $filters['company_created_at']->getValue();?>
  <?php if (!empty($date_val['month'])):
   $date_val = $filters['company_created_at']->getValue();
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
      <?php include_partial('addplacegame/list_td_export_tabular', array('user_profile' => $user_profile, 'from' => $from,  'to' => $to)) ?>
     </tr>
  <?php endforeach; ?>
  </tbody>
  </table>

