<?php // $userCountry = myTools::getUserCountry(); ?>

<div class = "wrapper-holder">
    <div class="container-holder">
        <div class = "shell">
            <div class = "welcome">
                <h1>Hello local, </h1>
                <p>Getlokal is not yet available in <span><?php echo $userCountry['name_en']; ?></span>, but you can make this happen!</p>
                <div class = "activate">
                    <small>
                        <span>Not in <?php echo $userCountry['name_en']; ?>?</span>
                        Oops! Our location detection has gone fishing.
                        <a href = "<?php echo url_for('company/addCompany'); ?>">
                            <span>But why not activate your city</span>
                        </a>
                        , whatever it may be. It’s realy cool!
                    </small>
                </div>
            </div><!--/.welcome -->

            <div class="socials">
                <a href="<?php echo url_for('company/addCompany'); ?>" class="link-getlokal">activate your city now!</a>
            </div><!-- /.socials -->
        </div><!-- /.shell -->

        <div class="close">
            <a href="#" class="close"><i class="ico-close"></i></a>
        </div><!-- /.close -->
    </div><!-- /.container -->

    <div class="closed">
        <a href="#"><i class="ico-arrow-down"></i></a>
        <p class="membership">Become an ambassador</p>
    </div><!-- /.closed -->
</div><!-- /.wrapper-holder -->

<?php // var_dump(var_dump($_COOKIE)); ?>

<script src="/js/jquery.cookie.js"></script>
<script>
//    $.cookie("viewState");
    $.cookie("viewState", {expires: 1, path: '/'});
    var theState = $.cookie("viewState");
    
    $(".ico-close").click(function() {
        $(".container-holder").slideToggle("fast");
        $(".closed").slideToggle("fast");
        $.cookie("viewState", "block");
        theState = "block"
    });

//    $(".ico-close").click(function() {
//        $(".closed").slideToggle("fast");
//    });

    $(".ico-arrow-down").click(function() {
        $(".closed").slideToggle("fast");
        $(".container-holder").slideToggle("fast");
        $.cookie("viewState", "none");
        theState = "none"
    });

//    $(".ico-arrow-down").click(function() {
//        $(".container-holder").slideToggle("fast");
//    });
    
    if($.cookie("viewState") == "block"){
        $(".closed").css('display', theState);
        $(".container-holder").css('display', 'none');
    }
    if($.cookie("viewState") == "none"){
        $(".closed").css('display', theState);
    }

</script>