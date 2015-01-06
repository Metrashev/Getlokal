<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8">
</head>

<table cellspacing="0">
  <thead>
    <tr> 
      <?php include_partial('company_offer/list_th_export_tabular', array('sort' => $sort)) ?>
      
    </tr>
  </thead>
<tbody>
<?php foreach ($pager->getResults() as $i => $company_offer): $odd = fmod(++$i, 2) ? 'odd' : 'even' ?>
   <tr class="sf_admin_row <?php echo $odd ?>">
    <?php include_partial('company_offer/list_td_export_tabular', array('company_offer' => $company_offer)) ?>
   </tr>
<?php endforeach; ?>
</tbody>
</table>