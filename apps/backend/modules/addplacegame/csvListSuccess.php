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
  <?php echo __('Vocuhers', array(), 'messages') ?>
</th>
      </tr>
    </thead>
  <tbody>
   <?php $from = null; $to =null;?>
  <?php $date_val= $filters['company_created_at']->getValue();?>
  <?php if (!empty($date_val)):
   $date_val = $filters['company_created_at']->getValue();
   if ($date_val['from']):
     $from =$date_val['from'];
   endif;
   if ($date_val['to']):
     $to =$date_val['to'];
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

