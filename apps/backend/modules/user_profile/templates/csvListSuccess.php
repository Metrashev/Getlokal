<?php use_helper('Date')?>
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8">
</head>

<table cellspacing="0">
    <thead>
      <tr>
<th class="sf_admin_text sf_admin_list_th_first_name">
  <?php echo __('First name', array(), 'messages') ?>
</th>
<th class="sf_admin_text sf_admin_list_th_last_name">
  <?php echo __('Last name', array(), 'messages') ?>
</th>
<th class="sf_admin_text sf_admin_list_th_email_address">
  <?php echo __('Email address', array(), 'messages') ?>
</th>

<th class="sf_admin_text sf_admin_list_th_city_id">
  <?php echo __('City', array(), 'messages') ?>
</th>

      </tr>
    </thead>
  <tbody>
  <?php foreach ($pager->getResults() as $i => $user_profile): $odd = fmod(++$i, 2) ? 'odd' : 'even' ?>
     <tr class="sf_admin_row <?php echo $odd ?>">
    

<td class="sf_admin_text sf_admin_list_td_first_name">
  <?php echo $user_profile->getFirstName() ?>
</td>
<td class="sf_admin_text sf_admin_list_td_last_name">
  <?php echo $user_profile->getLastName() ?>
</td>
<td class="sf_admin_text sf_admin_list_td_email_address">
  <?php echo $user_profile->getEmailAddress() ?>
</td>
<td class="sf_admin_foreignkey sf_admin_list_td_city_id">
  <?php echo $user_profile->getCity()->getLocation() ?>
</td>
<?php $user_profile->free();?>
     </tr>
  <?php endforeach; ?>
  </tbody>
  </table>
