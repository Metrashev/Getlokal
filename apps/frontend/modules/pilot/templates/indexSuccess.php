<div class="getpilot" id="getpilot">
  
  <div id="header">
    <div class="container">
      <div><?php echo link_to(image_tag('pilot/logo.png'), 'homepage'); ?></div>
      <div class="title">
        <div class="fblike">
          <div class="fb-like" data-href="https://www.facebook.com/getlokal.ro" data-layout="box_count" data-action="like" data-show-faces="true" data-share="false"></div>
        </div>
      </div>
      <div class="button">
        <div class="scroll-down">AM FACUT PENTRU TINE <span>3 EPISOADE</span></div>
      </div>
      <div class="desc">
        Votează-l pe cel care îți place cel mai mult și astfel vei alege <br/>
        persoana care va realiza getweekend în anul 2014.
      </div>
      <div class="bubble"></div>
      <div class="bottom-desc">Apreciem în plus și parerea ta sinceră în caseta de comentarii de sub fiecare videoclip.</div>
    </div>
  </div>

  <!-- top part -->
  <div class="top">
    <div class="container">
      <?php foreach ($videos as $k => $video): ?>
        <div class="element<?php if (($k+1) % 3 == 0): ?> last <?php endif ?>">
          <iframe width="306" height="186" src="//www.youtube.com/embed/<?php echo $video->getYoutubeKey(); ?>?wmode=opaque" frameborder="0" allowfullscreen></iframe>
        </div>
      <?php endforeach ?>  
      <div class="clr"></div>
    </div>
  </div>

  <div class="bottom">
    <div class="container">
      <?php foreach ($videos as $k => $video): 
        $fburl = url_for('@getpilot', true) . "?video=" . $video->getId(); 
        $eclass = 'can_vote';
        if (!$canVote) {
          $eclass = 'disabled';
        }
        $voted = '';
        $is_voted = false;
        if ($todayVoteId == $video->getId()) {
          $eclass = 'is_voted';
          $is_voted = true;
        } 
        if (isset($vote_disabled) && $vote_disabled) {
            $eclass = 'disabled';
        }
      ?>
        <div id="element-video-<?php  echo $video->getId(); ?>" class="element <?php if (($k+1) % 3 == 0): ?> last <?php endif; echo $eclass;  ?>">
          <div class="avatar"><?php echo image_tag("pilot/avatar-" . ($k+1) . ".png"); ?></div>
          <div class="info">
            <div class="vote-status">
              <div class="status-text"><?php if ($eclass == 'is_voted'): ?>Ai votat<?php else: ?>Votează<?php endif ?></div>
              <div class="n"><?php echo $video->getName(); ?></div>
            </div>
            <div class="vote-action">
              <div class="count">
                <b><?php echo $video->getPilotVote()->count(); ?></b>
                voturi
              </div>
              <a href="<?php echo url_for('getpilot_vote', array('id' => $video->getId())) ?>" class="vote"></a>
            </div>
            <div class="clr"></div>
          </div>
          <div class="clr"></div>
          <div class="thanks <?php if ($is_voted) {echo 'active';} ?>">
            <?php echo $video->getName(); ?> îți mulțumește pentru vot. <br/>
            Poți vota și mâine încă o dată! 
          </div>
          <div class="comments">
            <div class="q">Ți-a placut?</div>
            <div class="fb-comments" data-href="<?php echo $fburl; ?>" data-numposts="5" data-width="306" data-colorscheme="light"></div>
          </div>
        </div>
      <?php endforeach ?>
    </div>
  </div>
  <div class="clr"></div>
</div>

<input type="hidden" id="auth-url" value="<?php echo url_for('sf_guard_signin'); ?>">

<?php if (isset($vote_disabled) && $vote_disabled): ?>
    <div class="share-overlay">
        <div class="buttons">
            <div class="text">
                <?php echo $winner_message->getVal(ESC_RAW); ?>
                <span class="close no-animate"></span>
            </div>
        </div>    
    </div>
    <script>
        jQuery(function () {
            setTimeout(function () {
                window.openOverlay();
            }, 1000);
        });
    </script>
<?php else: ?>
    <div class="share-overlay">
      <div class="buttons">
        <a href="https://www.facebook.com/sharer.php?u=<?php echo urlencode(url_for('@getpilot', true)); ?>">
          <?php echo image_tag('pilot/share-fb.png'); ?>
        </a>
        <a href="https://twitter.com/share?url=<?php echo urlencode(url_for('@getpilot', true)); ?>&text=Tocmai ce am votat un videoclip pe Getpilot! Votează și tu!">
          <?php echo image_tag('pilot/share-tw.png'); ?>
        </a>
        <br/>
        <span class="close">Închide</span>
      </div>
    </div>
<?php endif ?>


<?php if (isset($forceVote)): ?>
  <script>
    jQuery(function () {
      setTimeout(function () {
        var $el= $("#element-video-<?php echo $forceVote; ?> a.vote");
        $('html, body').animate({
          scrollTop: $el.position().top
        }, 500, function () {
            $el.filter("a.vote").click();    
        });

      }, 1500);

    });
  </script>
<?php endif ?>