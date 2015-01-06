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
  <?php foreach ($pager->getResults() as $i => $user_profile): $odd = fmod(++$i, 2) ? 'odd' : 'even' ?>
     <tr class="sf_admin_row <?php echo $odd ?>">
      <?php include_partial('addplacegame/list_td_export_tabular', array('user_profile' => $user_profile)) ?>
     </tr>
  <?php endforeach; ?>
  </tbody>
  </table>
