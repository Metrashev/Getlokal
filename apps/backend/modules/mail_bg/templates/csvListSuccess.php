<?php use_helper('Date')?>
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8">
</head>

<table cellspacing="0">
    <thead>
      <tr>
<th class="sf_admin_text sf_admin_list_th_company">
  <?php echo __('Company', array(), 'messages') ?>
</th>
<th class="sf_admin_text sf_admin_list_th_city">
  <?php echo __('City', array(), 'messages') ?>
</th>
<th class="sf_admin_text sf_admin_list_th_created_at">
  <?php echo __('Added on', array(), 'messages') ?>
</th>

<th class="sf_admin_text sf_admin_list_th_updated_at">
  <?php echo __('Last Updated on', array(), 'messages') ?>
</th>
<th class="sf_admin_text sf_admin_list_th_status">
  <?php echo __('Status', array(), 'messages') ?>
</th>
      </tr>
    </thead>
  <tbody><?php foreach ($pager->getResults() as $i => $mail_bg_campaign): $odd = fmod(++$i, 2) ? 'odd' : 'even' ?>
     <tr class="sf_admin_row <?php echo $odd ?>">
    

<td class="sf_admin_text sf_admin_list_td_company">
  <?php echo $mail_bg_campaign->getCompany()->getTitle() ?>
</td>
<td class="sf_admin_text sf_admin_list_td_city">
  <?php echo $mail_bg_campaign->getCompany()->getCity()->getName();?>
</td>
<td class="sf_admin_text sf_admin_list_td_created_at">
  <?php echo $mail_bg_campaign->getCreatedAt('d-m-Y') ?>
</td>
<td class="sf_admin_foreignkey sf_admin_list_td_updated_at">
  <?php echo $mail_bg_campaign->getUpdatedAt('d-m-Y') ?>
</td>
<td class="sf_admin_foreignkey sf_admin_list_td_status">
  <?php echo ( $mail_bg_campaign->getIsActive()? 'Active' :'Inactive' );?>
</td>
<?php $mail_bg_campaign->free();?>
     </tr>
  <?php endforeach; ?>
  </tbody>
  </table>
