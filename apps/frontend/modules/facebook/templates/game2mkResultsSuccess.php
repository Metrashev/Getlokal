<?php include_javascripts() ?>
<?php include_stylesheets() ?>
<div class="wrapInner">
	<div class="header">
            <img src="/images/facebook/prizes/mk/game_<?php echo $facebookGame->getId() ?>_header.png" />
	</div>
	<div class="content">
            <div class="content_in">
                <div class="left_wrap">
                    <?php if ($facebookGame->getSlug() == 'momci-vs-devojki') : ?>
                        <h2>Кои подобро се забавуваат кога излегуваат сами?</h2>
                    <?php endif; ?>
		            
                    <div class="final_results"><img src="/images/gui/loading.gif" /></div>
                </div>
                <div class="clear"></div>
            </div>
        </div>

        <div class="footer">
            <a href="<?php echo url_for('@homepage', array(), true); ?>" target="_blank"><img src="<?php echo public_path('/images/facebook/v3/mk/icon_e.png', true) ?>" /></a>
            <a href="<?php echo url_for('facebook/game2mk', array(), true) ?>">Насловна</a>
	    <a href="<?php echo url_for('static_page', array('slug' => 'rules-bigrace-momcidevojki')) ?>" target="_blank">Правила на натпреварот</a>
            <a href="<?php echo url_for('facebook/game2mk', array(), true) . '?type=results' ?>">Резултати</a>

            <?php if (isset($games) && count($games)) : ?>
                <a href="<?php echo url_for('facebook/game2mk', array(), true) . '?type=winners' ?>">Победници</a>
                <?php /*<a href="<?php echo url_for('facebook/game2mk', array(), true) . '?type=awards' ?>">Награди</a>*/ ?>
            <?php endif; ?>
	</div>
</div>

<script type="text/javascript">
    $.post('<?php echo url_for('default', array('module' => 'facebook', 'action' => 'game2mk'), true) ?>', { statistic: true }, function(data) {
        if (data) {
            if (data.error != undefined && data.error == true) {
                location.href = '<?php echo url_for('facebook/game2mk'); ?>';
            }
            else if (data.error == false) {
                var iterations = 0;
                var results = '';

                $.each(data.result, function(param1, param2) {
                    iterations++;
                    var scnd="";
                    if ((iterations % 2) == 0)
                        scnd='second';
                    results = results + '<div class="result_wrap"><span>' + param1 + '</span><div class="result_bar"><div class="' + scnd + '" style="width:' + param2 + '%"></div></div><span class="blue"><img src="/images/gui/bg_vote.gif" />' + param2 + '%</span><div class="clear"></div></div>';
                });

                results = results + '<div class="total_votes"><p>Вкупно гласале: <span class="blue">' + data.total + '</span></p></div>';
                $(".final_results").html(results);
            }
        }
    }, 'json');
</script>

<?php
// OLD
/* DO NOT REMOVE :)
<div class="wrapInner">
	<div class="header">
            <img src="/images/facebook/prizes/mk/game_<?php echo $facebookGame->getId() ?>_header.png" />
	</div>

	<div class="content">
		<div class="content_in">
			<h1 class="pink">Резултати от проведените надпревари</h1>
			
			<?php if (isset($games) && count($games)) : ?>
				<ul class="vote_list">
				    <?php foreach ($games as $game) : ?>
				    	<li>
					    	<div class="left_wrap">
					        	<h2><?php echo $game->getName(); ?></h2>
								<div class="total_votes"><p>Вкупно гласале: <span class="blue"><?php echo $game->getCountUsers(); ?></span></p></div>
							</div>
							<div class="right_wrap">
						        <div class="result_wrap">
						            <?php $iterations = 0; ?>
						            <?php foreach($results = $game->getUserResults($game->getCountUsers()) as $param1 => $param2) : ?>
						                <?php $iterations++; ?>
						                <span><?php echo $param1 ?></span>
						                <div class="result_bar">
						                	<div <?php echo (($iterations%2) == 0) ? 'class="scnd"' : ''; ?> style="width:<?php echo $param2 ?>%"></div>
						                </div>
						                <span class="blue">
						                	<img src="/images/gui/bg_vote.gif" />
						                	<?php echo $param2.'%' ?>
						                </span>
						                <div class="clear"></div>
						            <?php endforeach; ?>
						        </div>
						    </div>
						    <div class="clear"></div>
						</li>
				    <?php endforeach; ?>
			    </ul> 
			<?php else : ?>
			    <div class="content_in">В момента все още няма приключени надпревари...</div>
			<?php endif; ?>
		</div>
	</div>
	
	<div class="footer">
        <a href="<?php echo url_for('@homepage', array(), true); ?>"><img src="<?php echo public_path('/images/facebook/v3/mk/icon_e.png', true) ?>" /></a>
        <a href="<?php echo url_for('facebook/game2mk', array(), true) ?>">Насловна</a>
	    <a href="<?php echo url_for('static_page', array('slug' => 'rules-bigrace-momcidevojki')) ?>" target="_blank">Правила на натпреварот</a>

            <?php if (isset($games) && count($games)) : ?>
                <a href="<?php echo url_for('facebook/game2mk', array(), true) . '?type=winners' ?>">Победници</a>
                <a href="<?php echo url_for('facebook/game2mk', array(), true) . '?type=results' ?>">Резултати</a>
                <?php //<a href="<?php echo url_for('facebook/game2mk', array(), true) . '?type=awards' ?>">Награди</a> ?>
            <?php endif; ?>
	</div>
</div>
 */
?>