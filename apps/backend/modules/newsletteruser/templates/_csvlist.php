<?php
/*OLD
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8">
</head>

<table cellspacing="0">
    <thead>
      <tr>
        <?php include_partial('newsletteruser/list_th_export_tabular', array('sort' => $sort)) ?>
      </tr>
    </thead>
  <tbody>
  <?php foreach ($pager->getResults() as $i => $newsletter_user): $odd = fmod(++$i, 2) ? 'odd' : 'even' ?>
     <tr class="sf_admin_row <?php echo $odd ?>">
      <?php include_partial('newsletteruser/list_td_export_tabular', array('newsletter_user' => $newsletter_user)) ?>
     </tr>
  <?php endforeach; ?>
  </tbody>
  </table>
*/ ?>
<?php // NEW ?>
<?php foreach ($pager->getResults() as $i => $newsletter_user) : ?>
<?php if ($newsletter_user->getUserProfile()->getCity() && $city = $newsletter_user->getUserProfile()->getCity()) {$city = $city->getName(); } else { $city = 'unknown'; } ?>
<?php if ($newsletter_user->getUserProfile()->getCity() && $county = $newsletter_user->getUserProfile()->getCity()) {$county = $county->getCounty()->getName() . "\n\r"; } else { $county = 'unknown' . "\n\r"; } ?>
<?php $date = $newsletter_user->getUserProfile()->getBirthdate(); if ($date && $date != NULL) { $date = date('Y', strtotime($date)); } else { $date = 'unknown'; }  ?>
<?php echo $newsletter_user->getUserProfile()->getSfGuardUser()->getEmailAddress(), ",", $newsletter_user->getUserProfile()->getSfGuardUser()->getFirstName(), ",", $newsletter_user->getUserProfile()->getSfGuardUser()->getLastName(), ",", $date, ",", $city, ",", $county; ?>
<?php endforeach; ?>