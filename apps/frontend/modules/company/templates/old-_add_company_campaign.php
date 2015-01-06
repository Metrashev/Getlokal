<div class="wrapper-container">
        <div class="shell-container">
                <div class="welcome">
                    <h2 class="header-border">Hello <?php echo $userCountry['name_en']; ?> !</h2>
                    <p><span class="getlokal">Getlokal</span> is a way to <span>view</span>, <span>use</span>, <span>generate</span> and <span>share</span> information among friends and similar-minded </p>
                    <p><span>people</span> about <span>places</span>, <span>events</span>, products and <span>services</span> in your city.</p>
                </div><!-- /.welcome -->
                
                <div class="community">
                    <h2>Getlokal community is currently working in:</h2>
                
                    <ul class="community-list">
                        <?php $countries = array('bg', 'ro', 'mk', 'rs', 'fi', 'hu'); ?>
                        <?php foreach ($countries as $c): ?>
                            <?php $country = getlokalPartner::getInstance(sfConfig::get('app_domain_to_culture_' . strtoupper($c))); ?> 
                            <li>
                                <a href="http://www.getlokal.<?php echo $c ?>/" target="_blank">
                                    <span class="hover">
                                        <span class="inside-elements">
                                            Go to <i class="ico-arrow"> </i>
                                        </span>
                                    </span>
                
                                    <div class="list-head">
                                        <h4><?php echo __(sfConfig::get('app_countries_' . $c)); ?></h4>    
                                    </div>
                
                                    <div class="list-body">
                                        <img src="/images/addPlaceCampaign/<?php echo $c; ?>-image.jpg" alt="">
                                    </div>
                                    <div class="list-foot">
                                        <ul class="statistic-list">
                                            <li>places <br> <span><?php echo $company->getCompaniesInfo($country); ?></span></li>
                                            <li>users <br> <span><?php echo $review->getReviewsByCountry($country); ?></span></li>
                                            <li>reviews <br> <span><?php echo $profile->getUsersCount($country); ?></span></li>
                                        </ul>
                                    </div>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div><!-- /.community -->
                
                <div class="membership">
                    <div class="align-left">
                        <h2> Become <span class="getlokal">Getlokal</span> Ambassador!</h2>
                        <p>Add 25 places and become a Getlokal ambassador of <?php echo $userCountry['name_en']; ?>! As an ambassador you will be featured on Getlokal and will receive a special gift</p>
                        <br>
                
                        <?php if ($sf_user->isAuthenticated()): ?>
                            <?php $becomeAmbassador = 25 - $company->getUserCompanies($sf_user->getId(), $userCountry['id']); ?>
                            <?php if ($becomeAmbassador > 0): ?>
                                <span class="ambassador">
                                    Add <span><?php echo $becomeAmbassador; ?> more</span> places to become <span>Ambassador level 1</span> and recieve your well deserved T-shirt!
                                </span><!-- /.ambassador -->
                            <?php else: ?>
                                <span class="ambassador">
                                    Congrats! You are now Getlokal Ambassador of <?php echo $userCountry['name_en']; ?>. Send your address on <span> info@getlokal.com</span>, so we can send over your well-deserved gift!
                                </span><!-- /.ambassador -->
                            <?php endif; ?>
                
                        <?php else: ?>
                            <div class="socials">
                                <a href="<?php echo url_for('user/FBLogin'); ?>" class="link-facebook"><i class="ico-fb"></i>Connect with facebook</a>
                            </div><!-- /.socials -->
                        <?php endif; ?>
                
                    </div>
                
                    <div class="align-right">
                        <img src="/images/addPlaceCampaign/getlokal-planet.png" alt="" class="getlokal-planet">
                    </div>
                </div><!-- /.membership -->
                
                <?php $leftCompanies = 250 - $company->getCompaniesInfo($userCountry['id']); ?>
                <div class="places">
                    <h2>
                        <?php if($leftCompanies > 0): ?>
                            <?php echo format_number_choice('[0]|[1]<span>1</span> place left to activate|(1,+Inf]<span>%count%</span> places left to activate', array('%count%' => $leftCompanies), $leftCompanies); ?>
                            <span><?php echo $userCountry['name_en']; ?></span>. Add them now:
                        <?php else: ?>
                            <span>
                                 Congratulations, there are <?php echo $company->getCompaniesInfo($userCountry['id']); ?> places added in <?php echo $userCountry['name_en']; ?> - the country will be activated soon! 
                            </span>
                        <?php endif; ?>
                    </h2>
                
                    <ul class="places-list">
                        <?php foreach ($city->getDefaultCities($userCountry['slug']) as $c): ?>
                            <li id="<?php echo $c->getId(); ?>" class="<?php echo $c->getCityNameByCulture($userCountry['slug']); ?>">
                                <div class="list-head">
                                    <h4><?php echo $c->getCityNameByCulture($userCountry['slug']); ?></h4>    
                                </div>
                
                                <div class="list-body">
                                    <span class="places-hover">                                  
                                        <?php if ($company->getCompaniesInfo(null, $c->getId()) > 25): ?>
                                            <span class="inside-elements">
                                                <?php echo $company->getCompaniesInfo(null, $c->getId()); ?> <br> added
                                            </span>
                                        <?php else: ?>
                
                                            <span class="inside-elements">
                                                <?php echo (25 - $company->getCompaniesInfo(null, $c->getId())); ?> left <br> to enable
                                            </span>
                                        <?php endif; ?>
                
                                    </span>
                                    <img src="/images/addPlaceCampaign/<?php echo myTools::replaceDiacritics($c->getCityNameByCulture($userCountry['slug'])); ?>-image.jpg" alt="">
                                </div>
                
                                <div class="list-foot">
                                    <a class="btn-pink">add place</a>
                                </div>
                            </li>
                        <?php endforeach; ?>
                
                        <li>
                            <div class="list-head">
                                <h4>Your city</h4>    
                            </div>
                
                            <div class="list-body">
                                <span class="places-hover">
                                    <span class="inside-elements">
                                        Can’t find <br> your city?
                                    </span>
                                </span>
                                <img src="/images/addPlaceCampaign/yourcity-image.jpg" alt="">
                            </div>
                
                            <div class="list-foot">
                                <a class="btn-pink">add place</a>
                            </div>
                        </li>
                    </ul>
                </div><!-- /.places -->
        </div><!-- /.shell -->
</div><!-- /.wrapper -->

<script>
    $(document).ready(function() {
        
        var country = '<?php echo $userCountry['name_en'] ?>';
        var country_id = '<?php echo $userCountry['id'] ?>';

        $("ul.places-list > li").click(function() {
            var city_name = $(this).attr("class");
            var city_id = $(this).attr("id");
            
            $("#company_city").focus();
            $('#company_country').val(country);
            $('#company_country_id').val(country_id);
            $("#company_city_id").val(city_id);
            $("#company_city").val(city_name);
            
            setCity(city_id, city_name);

        });
    });
</script>