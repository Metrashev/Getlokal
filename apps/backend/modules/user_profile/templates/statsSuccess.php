<div class="wrap">
  <h2>User stats for: <?php echo $user ?> (<?php echo link_to('back', 'user_profile/index') ?>)</h2>
  
  <table class="widefat">
    <thead>
      <tr>
        <th scope="col" width="100">key name</th>
        <th scope="col">value</th>
      </tr>
    </thead>

    <?php foreach($stats as $i => $stat): ?>
      <tr class="<?php $i%2==0 and print 'alternate' ?>">
        <td><?php echo $stat->getKey() ?></td>
        <td>
          <?php echo $stat->getValue() ?>
        </td>
      </tr>
    <?php endforeach ?>
    </table>
  <br class="clear" />
</div>
