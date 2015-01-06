<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>404 Page</title>
  <meta name="description" content="">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="/css/normalize.css" />
  <link rel="stylesheet" href="/css/404.css" />
</head>

<body>

  <!-- Video Markup -->
  <section class="masthead">
    <video class="masthead-video" autoplay loop muted poster="//images/gui/video-fallback.jpg">
      <source src="/videos/404.mp4" type="video/mp4">
      <!-- <source src="/videos/404.webm" type="video/webm"> -->
    </video>
    <div class="masthead-overlay"></div>
    <h1>404<span>It seems you are lost</span>
      <a href="<?php echo url_for('@home3') ?>" class="home-btn">Go back home</a>
    </h1>

    <p class="description">
      <?php echo __('Here are some of the possible reasons', null, 'error404') ?></br>
      <?php echo __('Did you type a URL i.e. website address?', null, 'error404') ?>
      <?php echo __('You may have typed the website address (URL) incorrectly. Please, check the spelling, capitalization, punctuation, etc.', null, 'error404') ?>
      <?php if ($sf_user->getCountry()->getSlug() == 'bg'):?>
      <?php echo __('Did you follow a link to this page from another page in this site?', null, 'error404') ?><br/>
      <?php echo str_replace('info@getlokal.com', '<a href="mailto:info@getlokal.com">info@getlokal.com</a>', __('If you reached this page from another page in this site, please email us at info@getlokal.com so we can fix the problem.', null, 'error404')) ?></br>
      <?php echo __('Did you follow a link from another site?', null, 'error404') ?>
      <?php echo str_replace('info@getlokal.com', '<a href="mailto:info@getlokal.com">info@getlokal.com</a>', __('Links from other sites can sometimes be out-of-date or misspelled. Please email us at info@getlokal.com with information about the site from which you followed the link so we can try and contact the other site in order to fix the problem.', null, 'error404')) ?>
      <?php elseif ($sf_user->getCountry()->getSlug() == 'ro'):?>
      <?php echo __('Did you follow a link to this page from another page in this site?', null, 'error404') ?>
      <?php echo str_replace('romania@getlokal.com', '<a href="mailto:romania@getlokal.com">romania@getlokal.com</a>', __('If you reached this page from another page in this site, please email us at romania@getlokal.com so we can fix the problem.', null, 'error404')) ?>
      <?php echo __('Did you follow a link from another site?', null, 'error404') ?>
      <?php echo str_replace('romania@getlokal.com', '<a href="mailto:romania@getlokal.com">romania@getlokal.com</a>', __('Links from other sites can sometimes be out-of-date or misspelled. Please email us at romania@getlokal.com with information about the site from which you followed the link so we can try and contact the other site in order to fix the problem.', null, 'error404')) ?>
      <?php endif;?>
    </p>

  </section>

  <!-- Load Scripts -->
  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
  <script src="/js/covervid/covervid.js"></script>
  <script src="/js/covervid/scripts.js"></script>

  <!-- Call CoverVid -->
  <script type="text/javascript">
    // If using jQuery
      // $('.masthead-video').coverVid(1920, 1080);
    // If not using jQuery (Native Javascript)
      coverVid(document.querySelector('.masthead-video'), 1920, 1080);
  </script>

</body>

</html>




<!-- <div class="content">
	<div class="left">
<div class="left_dynamic">
<h2><?php echo __('404 ERROR - The page can\'t be found',null,'error404')?></h2>
<p>
    <?php echo __('The server returned a 404 response!', null, 'error404') ?>
    <br/><br/>
    <?php echo __('Here are some of the possible reasons', null, 'error404') ?> :<br/>
  </p>

  <ul>
    <li>
      <em><?php echo __('Did you type a URL i.e. website address?', null, 'error404') ?></em>
      <br/>
      <?php echo __('You may have typed the website address (URL) incorrectly. Please, check the spelling, capitalization, punctuation, etc.', null, 'error404') ?>
      <br/>&nbsp;
    </li>
    <?php if ($sf_user->getCountry()->getSlug() == 'bg'):?>
    <li>
      <em><?php echo __('Did you follow a link to this page from another page in this site?', null, 'error404') ?></em>
      <br/>
      <?php echo str_replace('info@getlokal.com', '<a href="mailto:info@getlokal.com">info@getlokal.com</a>', __('If you reached this page from another page in this site, please email us at info@getlokal.com so we can fix the problem.', null, 'error404')) ?>
      <br/>&nbsp;
    </li>
    <li>
      <em><?php echo __('Did you follow a link from another site?', null, 'error404') ?></em>
      <br/>
      <?php echo str_replace('info@getlokal.com', '<a href="mailto:info@getlokal.com">info@getlokal.com</a>', __('Links from other sites can sometimes be out-of-date or misspelled. Please email us at info@getlokal.com with information about the site from which you followed the link so we can try and contact the other site in order to fix the problem.', null, 'error404')) ?>

    </li>
    <?php elseif ($sf_user->getCountry()->getSlug() == 'ro'):?>
     <li>
      <em><?php echo __('Did you follow a link to this page from another page in this site?', null, 'error404') ?></em>
      <br/>
      <?php echo str_replace('romania@getlokal.com', '<a href="mailto:romania@getlokal.com">romania@getlokal.com</a>', __('If you reached this page from another page in this site, please email us at romania@getlokal.com so we can fix the problem.', null, 'error404')) ?>
      <br/>&nbsp;
    </li>
    <li>
      <em><?php echo __('Did you follow a link from another site?', null, 'error404') ?></em>
      <br/>
      <?php echo str_replace('romania@getlokal.com', '<a href="mailto:romania@getlokal.com">romania@getlokal.com</a>', __('Links from other sites can sometimes be out-of-date or misspelled. Please email us at romania@getlokal.com with information about the site from which you followed the link so we can try and contact the other site in order to fix the problem.', null, 'error404')) ?>

    </li>
    <?php endif;?>
  </ul>
</div>




</div>
	
	</div> -->