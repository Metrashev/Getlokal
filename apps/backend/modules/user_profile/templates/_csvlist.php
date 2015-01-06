<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8">
</head>

<table cellspacing="0">
    <thead>
      <tr>
        <?php include_partial('user_profile/list_th_tabular', array('sort' => $sort)) ?>
      </tr>
    </thead>
  <tbody>
  <?php foreach ($pager->getResults() as $i => $user_profile): $odd = fmod(++$i, 2) ? 'odd' : 'even' ?>
     <tr class="sf_admin_row <?php echo $odd ?>">
      <?php include_partial('user_profile/list_td_export_tabular', array('user_profile' => $user_profile)) ?>
     </tr>
  <?php endforeach; ?>
  </tbody>
  </table>
