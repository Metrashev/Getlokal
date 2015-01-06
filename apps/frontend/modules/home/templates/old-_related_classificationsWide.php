<?php $currentUrl = sfContext::getInstance()->getRequest()->getParameter( 'slug' )?>
<div class="related_category wide">
    <ul>
        <?php foreach($classifications as $classification): ?>
          <?php if($classification->Translation[$sf_user->getCountry()->getSlug()]->number_of_places): ?>
          	<?php if ($county): ?>
          	  <li <?php echo ($currentUrl == $classification->getSlug() ) ? ' class="current" ' : ''; ?>><?php echo link_to($classification, '@classificationCounty?slug='. $classification->getSlug(). '&sector='. $sector->getSlug(). '&county='. $sf_user->getCounty()->getSlug(), array('title' => $classification)) ?></li>
          	<?php  else: ?>
              <li <?php echo ($currentUrl == $classification->getSlug() ) ? ' class="current" ' : ''; ?>><?php echo link_to($classification, '@classification?slug='. $classification->getSlug(). '&sector='. $sector->getSlug(). '&city='. $sf_user->getCity()->getSlug(), array('title' => $classification)) ?></li>
            <?php  endif; ?>
          <?php endif ?>
        <?php endforeach ?>
    </ul>
</div>