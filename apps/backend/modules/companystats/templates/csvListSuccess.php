<?php use_helper('Date')?>
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8">
</head>

<table cellspacing="0">
    <thead>
      <tr>
<th class="sf_admin_text sf_admin_list_th_first_name">
  <?php echo __('Place', array(), 'messages') ?>
</th>
<th class="sf_admin_text sf_admin_list_th_last_name">
  <?php echo __('Action', array(), 'messages') ?>
</th>
<th class="sf_admin_text sf_admin_list_th_email_address">
  <?php echo __('Month', array(), 'messages') ?>
</th>


      </tr>
    </thead>
  <tbody>
  <?php foreach ($pager->getResults() as $i => $company_stats): $odd = fmod(++$i, 2) ? 'odd' : 'even' ?>
     <tr class="sf_admin_row <?php echo $odd ?>">
    

<td class="sf_admin_text sf_admin_list_td_first_name">
  <?php echo $company_stats->getCompany()->getCompanyTitle() ?>
</td>
<td class="sf_admin_text sf_admin_list_td_last_name">
   <?php echo $company_stats->getActionName(); ?>
</td>
<td class="sf_admin_text sf_admin_list_td_email_address">
   <?php echo false !== strtotime($company_stats->getMonth()) ? format_date($company_stats->getMonth(), "MM/yyyy",'bg') : '&nbsp;' ?>
</td>

<?php $company_stats->free();?>
     </tr>
  <?php endforeach; ?>
  </tbody>
  </table>
