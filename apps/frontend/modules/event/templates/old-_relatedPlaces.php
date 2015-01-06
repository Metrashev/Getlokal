<?php if (count($eventPages) > 0): ?>
    <div class="related_places_wrap">
        <h2><?php echo __('Related Places', null, 'article') ?></h2>

        <ul>
            <?php foreach ($eventPages as $event_page): ?>
                <li>
                    <?php echo link_to(image_tag($event_page->getCompanyPage()->getCompany()->getThumb(0), 'size=52x52 alt=' . $event_page->getCompanyPage()->getCompany()->getCompanyTitle()), $event_page->getCompanyPage()->getCompany()->getUri(ESC_RAW), array('title' => $event_page->getCompanyPage()->getCompany()->getCompanyTitle())) ?>
                    <?php echo link_to(truncate_text($event_page->getCompanyPage()->getCompany()->getCompanyTitle(), 40, '...', true), $event_page->getCompanyPage()->getCompany()->getUri(ESC_RAW), array('title' => $event_page->getCompanyPage()->getCompany()->getCompanyTitle())) ?>
                    <div class="place_rateing">
                        <div class="rateing_stars">
                            <div class="rateing_stars_orange" style="width: <?php echo $event_page->getCompanyPage()->getCompany()->getRating() ?>%;"></div>
                        </div>
                        <p><?php echo format_number_choice('[0]0 reviews|[1]1 review|(1,+Inf]%count% reviews', array('%count%' => $event_page->getCompanyPage()->getCompany()->getNumberOfReviews()), $event_page->getCompanyPage()->getCompany()->getNumberOfReviews()); ?></p>
                        <p class="place_classification"><?php echo $event_page->getCompanyPage()->getCompany()->getClassification(); ?></p>
                    </div>
                </li>
            <?php endforeach; ?>
        </ul>

    </div>
<?php endif; ?>