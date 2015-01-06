<div class="wrapInner">

<?php if ($facebookGame->getSlug() == 'big-race-ro') : ?>
	<div class="header">
            <img src="/images/facebook/prizes/ro/game_<?php echo $facebookGame->getId() ?>_header.png" />
	</div>
<?php elseif ($facebookGame->getSlug() == 'bere-vs-vin') : ?>

    <script type="text/javascript">
        $(document).ready(function() {
            $('.wrapInner').css('width', '990px');
            $('.wrapInner > div.content ').css('top', '220px');
            $('.wrapInner > div.content ').css('border-top', '10px solid #6ec0c1');
            $('.footer').css('top', '220px');
          });
     
    </script>
    <div class="big_bg_image">
        <img src="/images/facebook/prizes/ro/game_<?php echo $facebookGame->getId() ?>_header.png" />
    </div>
	
	<div class="game_title">
      <h1>Ce bei mai des?</h1>
	</div>
<?php endif; ?>
	
	<div class="content">
		<div class="content_in">
			<h1 class="pink">Rezultatele de pana acum:</h1>
			
			<?php if (isset($games) && count($games)) : ?>
				<ul class="vote_list">
				    <?php foreach ($games as $game) : ?>
				    	<li>
					    	<div class="left_wrap">
					        	<h2><?php echo $game->getName(); ?></h2>
								<div class="total_votes"><p>Voturi totale: <span class="blue"><?php echo $game->getCountUsers(); ?></span></p></div>
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
			    <div class="content_in">Nu exista inca rezultate</div>
			<?php endif; ?>
		</div>
	</div>
	
	<div class="footer">
        <a href="<?php echo url_for('@homepage', array(), true); ?>"><img src="<?php echo public_path('/images/facebook/v3/bg/icon_e.png', true) ?>" /></a>
        <a href="<?php echo url_for('facebook/game2ro', array(), true) ?>">Start</a>
	    <?php if ($facebookGame->getSlug() == 'big-race-ro') : ?>		
			<a href="<?php echo url_for('static_page', array('slug' => 'reguli-bucuresti-vs-provincia')) ?>" target="_blank">Reguli de joc</a>
		<?php elseif ($facebookGame->getSlug() == 'bere-vs-vin') : ?>
			<a href="<?php echo url_for('static_page', array('slug' => 'reguli-bere-vs-vin')) ?>" target="_blank">Reguli de joc</a>
		<?php endif; ?>
            <?php if (isset($games) && count($games)) : ?>
                <a href="<?php echo url_for('facebook/game2ro', array(), true) . '?type=winners' ?>">Câștigătorii</a>
                <a href="<?php echo url_for('facebook/game2ro', array(), true) . '?type=results' ?>">Rezultate</a>
                <?php /*<a href="<?php echo url_for('facebook/game2cbg', array(), true) . '?type=awards' ?>">Награди</a>*/ ?>
            <?php endif; ?>
	</div>
</div>
