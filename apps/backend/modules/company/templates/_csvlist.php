<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8">
</head>

<table cellspacing="0">
    <thead>
      <tr>
        <?php include_partial('company/list_th_export_tabular', array('sort' => $sort)) ?>
      </tr>
    </thead>
  <tbody>
  <?php foreach ($pager->getResults() as $i => $company): $odd = fmod(++$i, 2) ? 'odd' : 'even' ?>
     <tr class="sf_admin_row <?php echo $odd ?>">
      <?php include_partial('company/list_td_export_tabular', array('company' => $company)) ?>
     </tr>
  <?php endforeach; ?>
  </tbody>
  </table>