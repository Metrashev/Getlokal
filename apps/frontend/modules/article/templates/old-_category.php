<?php use_stylesheet('select-menu/select2-pink'); ?>
<?php if (isset($categories) && count($categories)>0):?>
<?php $currentUrl = sfContext::getInstance()->getRequest()->getParameter( 'slug' )?>
    <div id="article-categories">
        <div class="categories-dropdown">
            <div class="select">
                <?php echo __('Select Category', null, 'article')?> 
                <div class="menu_vertical_separator"></div>   
            </div>
            <div class="list">
                <div class="dropdown-content">
                  <select id="category-menu">
                         <option value="<?php echo url_for('@article_index') ?>" <?php echo ($currentUrl == '' ) ? ' selected="selected" ' : ''; ?>>
                            <?php echo __("All categories", null, 'messages'); ?>
                        </option>
                    <?php foreach ($categories as $category):?>
                        <option value="<?php echo url_for( '@article_category?slug='.$category->getSlug() ); ?>" <?php echo ($currentUrl == $category->getSlug() ) ? ' selected="selected" ' : ''; ?>>
                          <?php echo $category->getTitle()?>
                        </option>   
                    <?php endforeach;?>
                  </select>
                </div>
            </div>
            <div class="clear"></div>
    	</div>
    </div>
<?php endif;?>

