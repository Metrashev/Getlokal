<?php decorate_with('simple'); ?>
<div id="wrapper">
    <header>
        <h2 class="lpage_h2">Câștigă 2 x <span class="lpage_yellow">Samsung Galaxy Note II</span><br />
        și alte <span class="lpage_big">127</span> <span class="lpage_yel_small">premii instant!</span></h2>
    </header>

    <div class="lpage_panel_2">

        <p class="lpage_secondline">Scrie părerea ta sinceră<br />despre localurile în care te duci</p>
        <div class="clear"></div>
        <a href="http://app.getlokal.com/portfolio/big-prize-2-x-samsung-galaxy-note-n5110/">

        </a>
        <div class="lpage_phone">
            <a href="http://app.getlokal.com/portfolio/big-prize-2-x-samsung-galaxy-note-n5110/" target="_blank" class="lpage_bg_link" title="Samsung Galaxy Note N5110">Samsung Galaxy Note N5110</a>
            <p class="lpage_p1">Toate părerile trimise prin intermediul<br />aplicației getlokal intră în extragerea<br />pentru unul dintre cele două<br />
            <br /><span>SAMSUNG GALAXY NOTE N5110</span><br />
            <p class="lpage_difference"><a href="http://bit.ly/15IQ26U">Vezi câștigătorii.</a></p>
        </div> <!-- end lpage_phone -->

        <p class="lpage_thirdline">Cele mai bune păreri câștigă instant unul<br> dintre cele 127 premii:</p>
        <div class="clear"></div>
        <ul>
            <li><span>19 de pachete</span> a câte 4 ședințe Power Plate și diagonsticare corporală</li>
            <li><span>29 de vouchere</span> de câte 1 săptămână VIP la centrele World Class </li>
            <li><span>Un prânz sau cină</span>, în valoare de 500 de lei la Puzzle </li>
        </ul>
        <div class="clear"></div>
        <a href="http://app.getlokal.com/premii/" class="lpage_allprizes">vezi toate premiile instant</a>

    </div> <!-- end lpage_panel_2 -->

    <div class="lpage_footer">
        <p class="lpage_incepe">Începe acum, ești gata de premii în 5 minute.<br />Descarcă aplicația <span class="lpage_bold">getlokal</span>:</p>

         <div class="lpage_bigapps">
            <?php echo link_to(image_tag('staticpage/discovercity/big_app_store.png'), 'http://getlok.al/getlokalios') ?>
            <?php echo link_to(image_tag('staticpage/discovercity/big_google_store.png'), 'http://getlok.al/getlokaldroid') ?>
        </div> <!-- end smallapps -->

    </div> <!-- end lpage_footer -->

    <div class="lpage_panel_1">
        <p class="lpage_firstline">Descarcă aplicația gratuită <span class="lpage_bold">getlokal</span></p>
        <div class="clear"></div>
        <p class="lpage_centered">cel mai complet ghid cu locurile de ieșit din <span class="lpage_bold">toată țara</span><br />și evenimentele pe care nu trebuie să le ratezi!</p>

        <div class="lpage_app_sms">
            <div class="lpage_leftaligned">
                <p>
                    Accesează<br>
                    <span class="lpage_bold_big"><a href="http://getlok.al/applokal">http://getlok.al/applokal</a></span>
                    <br>de pe dispozitivul tău iOS sau Android
                </p>
            </div>

            <div class="lpage_separator"><p>ori</p></div>

            <div class="lpage_sms">
                  <p>Îți trimitem linkul către aplicație<br />prin email sau SMS:</p>
                      <form action="" method="post">
                          <?php echo $form['number']->render(); ?>
                          <input type="submit" value="trimite link" id="lpage_butt">
                      </form>
              </div> <!-- end lpage_sms -->

        </div> <!-- end lpage_app_sms -->
        <div class="clear"></div>
        <div class="lpage_qr">
            <?php echo image_tag('staticpage/discovercity/qr_discover.png'); ?>
        </div>
        <div class="lpage_separator sep2"><p>ori</p></div>
        <div class="lpage_app_direct">
            <p>sau accesează direct:</p>

            <div class="lpage_smallapps">
                <?php echo link_to(image_tag('staticpage/discovercity/app_store.png'), 'http://getlok.al/getlokalios') ?>
                <?php echo link_to(image_tag('staticpage/discovercity/google_store.png'), 'http://getlok.al/getlokaldroid'); ?>
            </div> <!-- end smallapps -->
        </div>
        <div class="clear"></div>

        <div class="lpage_smalllinks">
            <a href="http://app.getlokal.com/testimoniale/">Vezi cum arată aplicația</a>&nbsp;&nbsp;-&nbsp;&nbsp;<a href="http://app.getlokal.com/demo/">Ce zic utilizatorii getlokal?</a>
        </div> <!-- end smallapps -->

    </div> <!-- end lpage_panel_1 -->

    <div class="lpage_footer lpage_pad">
        <a href="http://app.getlokal.com/regulament/" class="lpage_reg">citește regulamentul oficial</a>
    </div>

    <div class="lpage_abs1"></div>
    <div class="lpage_abs2"></div>
    <div class="lpage_abs3"></div>

</div> <!-- end wrapper -->
