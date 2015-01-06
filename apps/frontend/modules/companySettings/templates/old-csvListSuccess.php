<?php slot('no_ads', true) ?>
<?php use_helper('I18N', 'Date') ?>
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8">
</head>
<table>
<tr>
<td>Voucher Code</td>
<td>First Name</td> 
<td>Last Name</td>
<td>Order Date</td>
</tr>

<?php foreach($ordered_vouchers as $r): ?>
  <tr>
  <td><?php echo $r->getCode();?></td>
  <td><?php echo $r->getUserProfile()->getsfGuardUser()->getFirstName();?></td>
  <td><?php echo $r->getUserProfile()->getsfGuardUser()->getLastName(); ?></td>
  <td><?php echo $r->getUserProfile()->getsfGuardUser()->getCreatedAt(); ?></td>
  </tr>
 <?php endforeach ?>

 </table>
