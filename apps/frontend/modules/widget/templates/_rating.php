<?php foreach (range(1, 5) as $i): ?>
  <?php
    $class = '';
    if ($i < $rating && ($i + 1) > $rating) {
      $class = 'h';
    } elseif ($i <= $rating) {
      $class = 'f';
    }
  ?>
  <a href="#" class="star <?php echo $class ?>"></a>
<?php endforeach ?>
