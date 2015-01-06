//Global variables
var scrolledTop; // Global body scrolled from top
var signInClickFlag = 0; // Will tell if Sign in button is clicked or not
var staticSelectorTopPosition; // Not to change when the function below is called
var flagForSettingStaticTopPosOnce = 0; // Flag used for setting staticSelectorTopPosition only with the first call of below function

// Scroll container
$(window).scroll(function() {
    scrolledTop = $(this).scrollTop();
    var GoogleMapSelector = $('.moving-map-container'); // Selects Google Map
    if (GoogleMapSelector.length) {
        movingGoogleMap(GoogleMapSelector); // On search results page
    }
});

function movingGoogleMap(selector) {
    var containerParentOfSelector = $('.top-places'); // Selector's parent, used to set the position where selector should stop moving at bottom part of the page
    var selectorOffset = selector.offset(); // Offset position of selector
    var selectorTopPosition = selectorOffset.top;
    var selectorHeight = parseInt(selector.height()); // Selector height
    var header = $('.header_wrapper'); // Header selector
    var headerHeight = parseInt(header.height()); // Header height
    var offsetFromHeader = 20; // Distance from bottom end of header and the position of map, in fixed mode. Set it to some integer.
    var containerOffset = containerParentOfSelector.offset();
    var containerBottom = parseInt(containerOffset.top + parseInt(containerParentOfSelector.height())); // Container parent of selector bottom place on page in pixels
    var bottomBreakPointForSelector = containerBottom - selectorHeight; // Container bottom position minus the height of selector equals the breakpoint of where the selector should stop moving
    if (!flagForSettingStaticTopPosOnce) {
        staticSelectorTopPosition = selectorTopPosition;
        flagForSettingStaticTopPosOnce = 1;
    }
    if(parseInt(containerParentOfSelector.height()) > selectorHeight + 200) {

        if (((scrolledTop + headerHeight) >= (staticSelectorTopPosition - offsetFromHeader)) && ((scrolledTop + headerHeight) < bottomBreakPointForSelector)) { // If site scroll plus whole header are bigger than the selector and it's top offset
            selector.addClass('moving');
            selector.css({
                'top': (headerHeight + offsetFromHeader)
            });
            selector.removeClass('pos-bottom');
        } else if ((scrolledTop + headerHeight) < (staticSelectorTopPosition + offsetFromHeader)) { // If site scroll and the whole header are smaller that the selector and it's top offset
            selector.removeClass('moving');
            selector.css({
                'top': 'auto'
            });
            selector.removeClass('pos-bottom');
        } else if ((scrolledTop + headerHeight) >= bottomBreakPointForSelector) { // If scroll reaches bottom breakpoint
            selector.removeClass('moving');
            selector.css({
                'top': 'auto'
            });
            selector.addClass('pos-bottom');
        }
    }
} // Setting fixed position on Google Maps when scrolled to defined position, and setting position absolute on reaching bottom of page

function fixSignInButtonFunctionalityAppearanceOnPage(signInButtonSelector, boxesToBePulledDown, pixels) {
    boxesToBePulledDown.stop(true, true).animate({
        marginTop: pixels
    });
    flagForSettingStaticTopPosOnce = 0;
} // Creates bigger space for the sign in form to take

function getTypeOfData(type) { // Gets type of Objects data which are listed in what autocomplete - example: 'place', 'event' etc.
    var types = [];
    var i = 0;
    type.forEach(function(entry) {
        types[i] = entry.type;
        i++;
    });
    setTypeOfDataToHtmlItems(types);
}

function setTypeOfDataToHtmlItems(types) { // Sets data types in what autocomplete to it's spans to see an icon for every type 
    var autocomplete = $('.search-what-controll .ui-autocomplete');
    var i = 0;
    if (autocomplete.length) {
        autocomplete.children().each(function() {
            if ($(this).hasClass('ui-menu-item')) {
                $(this).attr('lang', types[i]);
                i++;
            }
        });
        autocomplete.children().each(function() {
            if ($(this).hasClass('ui-autocomplete-category')) {
                if ($(this).attr('lang') != '') {
                    $(this).attr('lang', $(this).next().attr('lang'));
                    $(this).html($(this).html() + "<span class='fa'></span>");
                    switch ($(this).attr('lang')) {
                        case 'article':
                            $(this).children('.fa').addClass('fa-edit');
                            break;
                        case 'place':
                            $(this).children('.fa').addClass('fa-map-marker');
                            break;
                        case 'event':
                            $(this).children('.fa').addClass('fa-ticket');
                            break;
                        case 'list':
                            $(this).children('.fa').addClass('fa-list-ul');
                            break;
                    }
                }
            }
        });
    }
}

function addHoverToGmapButton() {
    $('.search-in-area').addClass('hovered');
} // Add hover to search button in Google Maps

function controlJsValidationMessages(currentObject) {
    //Selectors
    var ulErrorList = currentObject.parent().children('label').children('ul');
    var placeholderOfOriginalValue = currentObject.prev('label').children('.original-value'); // Original placeholder value set to span 
    var holderOfWholeInput = currentObject.parent().parent();
    
    var defaultMargin = currentObject.parent().children('label').children('.original-value').css('marginTop'); // Takes label's default margin so when it's animated it could go to default position
    var placeHolderValue = currentObject.attr('placeholder');
    
    if (ulErrorList.is(':empty')) {
        placeholderOfOriginalValue.addClass('d-none-important');
        holderOfWholeInput.addClass('input-error-border');
        currentObject.focus(function() {
        	holderOfWholeInput.removeClass('input-error-border'); // Commented in css
        });
        currentObject.blur(function() {
        	if(!$(this).val()) {
        		holderOfWholeInput.addClass('input-error-border');
        	}
        });
    } else {
        holderOfWholeInput.removeClass('input-error-border');
        placeholderOfOriginalValue.removeClass('d-none-important');
        currentObject.focus(function() {
            $(this).prev('label').children('span').stop(true, true).animate({
                opacity: 1,
                marginTop: '0px'
            }, 500);
            $(this).attr('placeholder', '');
            $(this).addClass('focused');
        });
        currentObject.blur(function() {
            if( !$(this).val() ) {
                $(this).prev('label').children('span').animate({
                    opacity: 0,
                    marginTop: defaultMargin
                }, 300);
                $(this).attr('placeholder', placeHolderValue);
                $(this).removeClass('focused');
            }
        });
    }
} // Actual rendering of placeholder/label and error msg

function setFileUplRules() {
    // Get filename when selected file in file button
    $('.file-input').change(function () {
        var fullPath = this.value;
        if (fullPath) {
            var startIndex = (fullPath.indexOf('\\') >= 0 ? fullPath.lastIndexOf('\\') : fullPath.lastIndexOf('/'));
            var filename = fullPath.substring(startIndex);
            if (filename.indexOf('\\') === 0 || filename.indexOf('/') === 0) {
                filename = filename.substring(1);
            }
            setFilenameToInputLabel($(this), filename);
        }
    });
}

$(window).load( function() {
    // Hide autocomplete 
    $('.search-where-controll .ui-corner-all').click( function() {
        $('.search-where-controll .ui-autocomplete').removeClass('show-autocomplete');
        $( ".search-where-controll .ui-autocomplete-input" ).focus();
    });

    $(".search-where-controll .ui-autocomplete-input").keypress(function(event) {
        if (event.which == 13) {
            event.preventDefault();
            $("#search-form").submit();
        }
    });

    // Scroll to top if there is Google Map in page
    var GoogleMapSelector = $('.moving-map-container'); // Selects Google Map
    if (GoogleMapSelector.length) {
        $('html, body').animate({
            scrollTop: 0
        }, 100);   
        GoogleMapSelector.removeClass('moving');
        GoogleMapSelector.css({
            'top': 'auto'
        });
        GoogleMapSelector.removeClass('pos-bottom');
    }
});

function setFilenameToInputLabel(me, filename) {
    me.parent().children('.filename').remove();
    me.parent().append( "<div class='filename'>" + filename + "</div>" );
    me.parent().parent().addClass('active');
}

$(function() {

    var header = $('.header_wrapper'); // Header selector

    // Set active class to inputs without value 
    // if(!($(".default-input").val())) {
    //     alert($(this).attr('class'));
    //     $(this).parent().addClass('active');
    // }
    
    /*$('.star-check').click( function() {
    	alert(1);
    	$('.star-check').attr('checked', 'unchecked');
    	$(this).attr('checked', 'checked');   	
    });*/

    //$('.st-menu').height($(window).height());

    // // Show/hide func on sidemenu
    // var sidemenuShowHideBtn = $('.js-sidemenu-profile .custom-row.toggle-row');
    // var contentToShow = $('.image-dropdowns');
    // var sidemenuClickFlag = false;

    // sidemenuShowHideBtn.click( function() {
    //     if(!sidemenuClickFlag) {
    //         contentToShow.slideDown(500);
    //         sidemenuClickFlag = true;
    //     } else {
    //         contentToShow.slideUp(500);
    //         sidemenuClickFlag = false;
    //     }
    // });

    // // Show/hide func on sidemenu notif
    // var notifShowHideBtn = $('.st-menu .notification-ico');
    // var notifContent = $('.st-menu .section-notifications');
    // var notifClickBtn = false;

    // notifShowHideBtn.click( function() {
    //     if(!notifClickBtn) {
    //         notifContent.slideDown(500);
    //         notifClickBtn = true;
    //     } else {
    //         notifContent.slideUp(500);
    //         notifClickBtn = false;
    //     }
    // });

    // // Show/hide func on sidemenu msg
    // var msgShowHideBtn = $('.st-menu .ico-messages');
    // var msgContent = $('.st-menu .section-messages');
    // var msgClickBtn = false;

    // msgShowHideBtn.click( function() {
    //     if(!msgClickBtn) {
    //         msgContent.slideDown(500);
    //         msgClickBtn = true;
    //     } else {
    //         msgContent.slideUp(500);
    //         msgClickBtn = false;
    //     }
    // });

    // Append modal to body
    var modal = $('.modal');
    if(modal.length) {
        $("body").append(modal);
    }

    // Show/hide login func on companySettings 
    var funcButton = $('.js-form-open');
    var closeButton = $('.styled-company .x-marks-the-spot');
    var showHideClose = $('.styled-company .show-less');
    var compSettClickFlag = false;

    funcButton.click( function() {
        if($(this).hasClass('js-form-open')) {
            if($(this).hasClass('toggle-row')) {
                $(this).removeClass('js-form-open');
            }
            $('.login-form-toggle').slideUp('fast');
            $('.js-form-open').show();
            $(this).parent().children('.login-form-toggle').stop(true, true).slideDown('fast');
            if(!$(this).hasClass('js-always-visible')) $(this).fadeOut(200);
            $(this).parent().children('.login-form-toggle').find('.login').removeClass('container').removeClass('login');
            $('.show-less').addClass('show-more').removeClass('show-less').addClass('js-form-open');
        } else if($(this).hasClass('show-less')) {
            $('.login-form-toggle').slideUp('fast');
            $(this).addClass('js-form-open');
        }
    });

    closeButton.click( function() {
        $('.login-form-toggle').slideUp('fast');
        $('.js-form-open').show();
        $('.show-less').addClass('show-more').removeClass('show-less');
        $('.styled-company .toggle-row').addClass('js-form-open');
    });

    if($(".welcome_message").length) {
        // Hide welcome msg after time
        setTimeout(function() {
            $(".welcome_message").hide();
        }, 10000);

        // Hide welcome msg from 'x marks the spot'
        $(".welcome_message .close").click( function() {
            $(".welcome_message").hide();
        });
    }

    // Modal close 
    var openedModal = $('#openModal');
    var xMarksTheSpot = $('#openModal .close');
    xMarksTheSpot.click( function() {
        openedModal.removeClass('active');
    });

    // Set rules for show/hide - open/close buttons
    var showHideDefButton = $('.custom-row.toggle-row');
    var domToOpen;
    var showHideDefClickFlag = false;

    showHideDefButton.click( function() {
        domToOpen = $(this).attr('lang');
        $('#' + domToOpen).stop(true, true).slideToggle();
    });
    
    // Set show/hide to revert states when clicked
    showHideDefButton.click( function() {
        if($(this).hasClass('show-more')) {
            $(this).removeClass('show-more');
            $(this).addClass('show-less');
        } else {
            $(this).removeClass('show-less');
            $(this).addClass('show-more');
        }
    });

    // Set active to inputs without any value 
    var defaultInput = $(".default-input");
    defaultInput.each( function () {
        if($(this).val() || !$(this).attr('placeholder')) {
            $(this).parent().addClass('active');
        }
    });
    
    // Get filename when selected file in file button
    setFileUplRules();


    // Slide to write review when clicked the button
    var writeReviewButton = $('.write-review-btn');
    var reviewScrollToDestination = $('.user-review');
    if(reviewScrollToDestination.length) {
        var scrollToDestination = reviewScrollToDestination.offset().top - header.height();
    }
    var scrollTimeToAnimate = 1000;

    writeReviewButton.click( function () {
        $('html, body').animate({
            scrollTop: scrollToDestination
        }, scrollTimeToAnimate);
    });

    // Add view more/less functionality on voting area pp/ppp
    var votingContainer = $('.voting-body');
    var leftTableHolder = votingContainer.children().children('.left-table');
    var rightTableHolder = votingContainer.children().children('.right-table');
    var leftTableHolderHeightSetByCSS = parseInt(leftTableHolder.css('height'));
    var rightTableHolderHeightSetByCSS = parseInt(rightTableHolder.css('height'));
    var leftTableHolderFullHeight = leftTableHolder.children('table').height();
    var rightTableHolderFullHeight = rightTableHolder.children('table').height();
    var showHideButton = $('.voting-section .toggle-row');
    var votingClickFlag = false;
    var animationSpeedVote = 500;

    if(votingContainer.length) {

        if(!(leftTableHolder.children('table').children('tbody').children().length < 3 && rightTableHolder.children('table').children('tbody').children().length < 3)) {

            showHideButton.click( function() {
                if(!votingClickFlag) {

                    leftTableHolder.animate({
                        height : leftTableHolderFullHeight
                    }, animationSpeedVote);
                    rightTableHolder.animate({
                        height : leftTableHolderFullHeight
                    }, animationSpeedVote);

                    $(this).removeClass('show-more').addClass('show-less');
                    votingClickFlag = true;
                } else {

                    leftTableHolder.animate({
                        height : leftTableHolderHeightSetByCSS
                    }, animationSpeedVote);
                    rightTableHolder.animate({
                        height : rightTableHolderHeightSetByCSS
                    }, animationSpeedVote);

                    $(this).removeClass('show-less').addClass('show-more');
                    votingClickFlag = false;
                }
            });

        } else {
            $('.voting-foot').children().hide();
        }

    } // check if votingContainer exist on current page


    // Add view more/less functionality on descriptive text on company page
    var textContainer = $('.s-h-functionality');
    var childTextContainer = textContainer.children('.child-text-container');
    var seeMoreLessButton = $('.abs-set');
    var moreLessClickedFlag = false;
    var maxHeightToSetWhenOpened = 999;
    var maxHeightToSetWhenOpenedChild = maxHeightToSetWhenOpened - 20;
    var paragraphsContainer = $('.child-text-container');
    var paragraphsHeight = 0;
    var currentMaxHeighSetByCss = parseInt(textContainer.css('max-height'));
    var currentMaxHeighSetByCssChild = currentMaxHeighSetByCss - 20;
    var animationSpeed = 500;
    var dontHaveAnyParagraphs = false;
    var brsCount = 0;

    if(textContainer.length) {

        paragraphsContainer.children().each( function() {
            if(!$(this).hasClass('show-more-less-container')) {
                if(!$(this).attr('href')) {
                    paragraphsHeight += $(this).outerHeight();
                }
                if(typeof $(this) !== 'BR') {
                    paragraphsHeight += 10;
                    brsCount++;
                }
            }
        });

        if((paragraphsHeight > currentMaxHeighSetByCssChild) || (brsCount > 4)) {
            seeMoreLessButton.click( function() {
                if(!moreLessClickedFlag) {
                    textContainer.animate({
                        'maxHeight' : maxHeightToSetWhenOpened
                    }, animationSpeed);
                    childTextContainer.animate({
                        'maxHeight' : maxHeightToSetWhenOpenedChild
                    }, animationSpeed);
                    seeMoreLessButton.find('.show-more').addClass('show-less').removeClass('show-more');
                    moreLessClickedFlag = true;
                } else {
                    textContainer.animate({
                        'maxHeight' : currentMaxHeighSetByCss
                    }, animationSpeed);
                    childTextContainer.animate({
                        'maxHeight' : currentMaxHeighSetByCssChild
                    }, animationSpeed);
                    seeMoreLessButton.find('.show-less').addClass('show-more').removeClass('show-less');
                    moreLessClickedFlag = false;
                }
            });

        } else {
            seeMoreLessButton.hide();
            textContainer.css('max-height', maxHeightToSetWhenOpened);
            childTextContainer.css('max-height', maxHeightToSetWhenOpenedChild);
        }

    }

    // Add show/hide functionality on Work time sheet - PP/PPP
    var actionButton = $('.work-time-btn');
    var workTimeSheet = $('.profile-content-foot');
    var arrow = actionButton.children('.fa-caret-up');
    var workTimeClickFlag = false;
    var clickedOnce = false;
    actionButton.click( function() {
        if(!workTimeClickFlag) {
            workTimeSheet.stop(true, true).slideUp();
            arrow.removeClass('fa-caret-up');
            arrow.addClass('fa-caret-down');
            workTimeClickFlag = true;
        } else {
            workTimeSheet.stop(true, true).slideDown();
            arrow.addClass('fa-caret-up');
            arrow.removeClass('fa-caret-down');
            workTimeClickFlag = false;
        }
    });

    var actionBtn = $('#work-time-link');
    var workTimeSht = $('#working-days-sidebar');
    var carret = actionBtn.children('.fa-caret-up');
    var workTimeClkFlag = false;
    var clickedOnce = false;
    actionBtn.click( function() {
        if(!workTimeClickFlag) {
            workTimeSht.stop(true, true).slideUp();
            carret.removeClass('fa-caret-up');
            carret.addClass('fa-caret-down');
            workTimeClkFlag = true;
        } else {
            workTimeSht.stop(true, true).slideDown();
            carret.addClass('fa-caret-up');
            carret.removeClass('fa-caret-down');
            workTimeClkFlag = false;
        }
    });

    // Remove hover from Google Maps search button
    $('.search-in-area').click( function() {
        if($(this).hasClass('hovered')) {
            $(this).removeClass('hovered');
        }
    });

    // Set grid classes to PPP slider-gallery
    var galleryItem = $('.ppp-slider-container .item');
    var liCounter = 0;
    var assoc = { 1 : 'cover', 2 : 'two', 3 : 'three', 4 : 'four', 5 : 'five', 6 : 'six'}
    // Remove slider arrow if only one item 
    var itemsParent = $('.ppp-slider-container .gallery .carousel-inner');
    var sliderContainer = $('.ppp-slider-container');
    var counter = 0;
    itemsParent.children().each( function() {
        counter++;
    });
    if(counter < 2) {
        sliderContainer.children('.carousel-control').hide();
    }


    galleryItem.each( function() {
        liCounter = $(this).children().children('li').length;
        $(this).children('.layout').addClass(assoc[liCounter]);
    });
    
    var header = $('.header_wrapper'); // Header selector
    // Sign in button functionality
    var signInButtonSelector = $('.sign-in.js-sign-in');
    if (signInButtonSelector.length) { // Check if it's necessary to call sign in form expand function
        var formSelector = $(".form-login");
        var boxesToBePulledDown = $('.boxesToBePulledDown'); // Which dom elements will move so the form could expand
        var selectorCssSetMarginTop = parseInt(boxesToBePulledDown.css('margin-top'));
        if (!boxesToBePulledDown.length) boxesToBePulledDown = $('.categories_wrapper');
        else {
            var minusMarginToSet = parseInt(( header.height() + formSelector.height()) - boxesToBePulledDown.offset().top); // How much minus margin top to take the boxes which will be pulled down
        }
        var hasClickedOnSignIn = 0;
        var searchContainer = $('.search-container');
        var searchContainerInner = $('.form-search');
        signInButtonSelector.click(function() {
            //Hides top header nav -- taken from functions.js
            closeHeaderTabs();
            //Hides top header nav -- taken from functions.js
            if (!signInClickFlag) { // Click state 0 or 1
                $("html, body").stop(true, true).animate({
                    scrollTop: 0
                });
                fixSignInButtonFunctionalityAppearanceOnPage(signInButtonSelector, boxesToBePulledDown, minusMarginToSet);
                formSelector.stop(true, true).fadeToggle(200);
                searchContainer.addClass('small-z-index');
                searchContainerInner.addClass('small-z-index');
                signInClickFlag = 1;
            } else if (signInClickFlag) {
                $("html, body").stop(true, true).animate({
                    scrollTop: 0
                });
                fixSignInButtonFunctionalityAppearanceOnPage(signInButtonSelector, boxesToBePulledDown, selectorCssSetMarginTop);
                formSelector.fadeOut(200);
                searchContainer.removeClass('small-z-index');
                searchContainerInner.removeClass('small-z-index');
                signInClickFlag = 0;
            }
            var hasClickedOnSignIn = 1;
        });
        if (!hasClickedOnSignIn) {
            $('.ico-form-close, .nav-tabs-head ul li').click(function() {
                fixSignInButtonFunctionalityAppearanceOnPage(signInButtonSelector, boxesToBePulledDown, selectorCssSetMarginTop);
                formSelector.fadeOut(200);
                searchContainer.removeClass('small-z-index');
                searchContainerInner.removeClass('small-z-index');
                signInClickFlag = 0;
            }); // Closes sign in form when clicked on listed selectors
        }
    }
    // Close autocomplete when clicked outside
    $('body').click(function() {
        $(".ui-autocomplete").removeClass('show-autocomplete');
    });
    $('.form-controls').click(function(e) {
        e.stopPropagation();
    });
    // Scroll to form-search when click on locations autocomplete button
    var formSearchSelectorOffset = $('.form-search').offset();
    $('.search-where-controll .ui-autocomplete').click(function() {
        $(window).scrollTo(formSearchSelectorOffset.top);
    });

    // Calling to check on forms validation if there are any errors listed if not get the input value
    var formInputsSelector = [$(".form-body input[type='text']"), $(".form-body input[type='password']")]; // Input selector
    var formBodySelector = $('.form-body'); // Form selector
    var submitButtonSelector = $('.form-login .form-foot .form-btn'); // Form submit button selector
    var currentObject; // Takes THIS - current input

    if (formBodySelector) {
        $.each(formInputsSelector, function(index, value) { // Each all Inputs to set control validation rules
            $(this).each(function() {
                if ($(this).length) {
                    currentObject = $(this);
                    controlJsValidationMessages(currentObject); // Actual rendering of placeholder/label and error msg
                }
            });
        });
        submitButtonSelector.click(function() {
            $.each(formInputsSelector, function(index, value) { // Each again on submit click event
	            $(this).each(function() {
	                if ($(this).length) {
	                    currentObject = $(this);
	                    controlJsValidationMessages(currentObject); // Actual rendering of placeholder/label and error msg
	                }
	            });
	        });
        });
    } else {
        console.log('There is no form selector in the DOM.');
    }

});

