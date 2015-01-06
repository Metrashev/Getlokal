<!DOCTYPE html>
<html>
<head>
  <title>Widget</title>
  <?php
    include_stylesheets();
    include_javascripts();
  ?>
  <link href='http://fonts.googleapis.com/css?family=Open+Sans&subset=latin,cyrillic-ext' rel='stylesheet' type='text/css'>
</head>
<?php
  $body_class = get_slot('body_class', 'place');
  $body_class .= ' ' . $sf_request->getParameter('color', 'white');
  $width = $sf_request->getParameter('width');
  $height = $sf_request->getParameter('height');
  if (!empty($height) && ($width / $height) < 1) {
    $body_class .= ' s'; // streched version
  } else {
    $body_class .= ' w';
  }
?>
<body class="<?php echo $body_class ?>">
  <?php echo $sf_content ?>
</body>
</html>
