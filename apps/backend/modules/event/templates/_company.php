<?php //$pages= $event->getAllEventPage();
     if (count($pages= $event->getEventPage())): ?>
    <?php $last=count($pages)-1; foreach ($pages as $kay=>$page):?>
    <?php echo link_to($page->getCompanyPage()->getCompany(),'/'.$page->getCompanyPage()->getCompany()->getCountry()->getSlug().'/'. $page->getCompanyPage()->getCompany()->getCity()->getSlug(). '/'. $page->getCompanyPage()->getCompany()->getSlug(), 'target=_blank') ?>
      <?php if ($kay!=$last):?>,<?php endif;?> 
     <?php endforeach;?>
    <?php endif;?> 