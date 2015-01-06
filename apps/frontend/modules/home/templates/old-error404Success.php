<div class="content">
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
	
	</div>