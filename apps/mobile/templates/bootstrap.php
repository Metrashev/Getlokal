<!DOCTYPE html>
<html>
<head>
    <?php include_http_metas(); ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

    <?php include_metas(); ?>
    <?php include_title() ?>

    <link rel="shortcut icon" href="/favicon.ico" />

    <?php include_stylesheets() ?>
    <?php include_javascripts() ?>

</head>
<body>
    <div class="container <?php include_slot('container-class'); ?>">
        <?php echo $sf_content; ?>
    </div>
</body>
</html>
