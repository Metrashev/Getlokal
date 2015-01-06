<li>
    <?php if (!$page->getNode()->isRoot()): ?>
        <?php echo link_to($page->getTitle(), '@static_page?slug=' . $page->getSlug()) ?>
    <?php endif; ?>
    <?php if ($page->getNode()->hasChildren()) : ?>
        <ul class="sub_page_wrapper">
            <?php foreach ($page->getNode()->getChildren() as $subpage): ?>
                <?php include_partial('page', array('page' => $subpage)); ?>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
</li>
