//Global variables
var scrolledTop; // Global body scrolled from top
var signInClickFlag = 0; // Will tell if Sign in button is clicked or not
var staticSelectorTopPosition; // Not to change when the function below is called
var flagForSettingStaticTopPosOnce = 0; // Flag used for setting staticSelectorTopPosition only with the first call of below function

// Scroll container
$(window).scroll( function() {

	scrolledTop = $(this).scrollTop();

	var GoogleMapSelector = $('.top-places .search'); // Selects Google Map
	if(GoogleMapSelector.length) {
		movingGoogleMap(GoogleMapSelector); // On search results page
	}

});

function movingGoogleMap(selector) {
	var header = $('.header_wrapper'); // Header selector
	var containerParentOfSelector = $('.top-places'); // Selector's parent, used to set the position where selector should stop moving at bottom part of the page

	var selectorOffset = selector.offset(); // Offset position of selector
	var selectorTopPosition = selectorOffset.top;
	var selectorHeight = parseInt(selector.height()); // Selector height
	var headerHeight = parseInt(header.height()); // Header height
	var offsetFromHeader = 20; // Distance from bottom end of header and the position of map, in fixed mode. Set it to some integer.
	var containerOffset = containerParentOfSelector.offset();
	var containerBottom = parseInt(containerOffset.top + parseInt(containerParentOfSelector.height())); // Container parent of selector bottom place on page in pixels
	var bottomBreakPointForSelector = containerBottom - selectorHeight; // Container bottom position minus the height of selector equals the breakpoint of where the selector should stop moving

	if(!flagForSettingStaticTopPosOnce || scrolledTop == 0) {
		staticSelectorTopPosition = selectorTopPosition;
		flagForSettingStaticTopPosOnce = 1;
	}
	if(((scrolledTop + headerHeight) >= (staticSelectorTopPosition - offsetFromHeader)) && ((scrolledTop + headerHeight) < bottomBreakPointForSelector)) { // If site scroll plus whole header are bigger than the selector and it's top offset
		selector.addClass('moving');
		selector.css({'top' : (headerHeight + offsetFromHeader)});
		selector.removeClass('pos-bottom');
	} else if((scrolledTop + headerHeight) < (staticSelectorTopPosition + offsetFromHeader)) { // If site scroll and the whole header are smaller that the selector and it's top offset
		selector.removeClass('moving');
		selector.css({'top' : 'auto'});
	} else if((scrolledTop + headerHeight) >= bottomBreakPointForSelector) { // If scroll reaches bottom breakpoint
		selector.removeClass('moving');
		selector.css({'top' : 'auto'});
		selector.addClass('pos-bottom');
	}
} // Setting fixed position on Google Maps when scrolled to defined position, and setting position relative on reaching bottom of page

function fixSignInButtonFunctionalityAppearanceOnPage(signInButtonSelector, boxesToBePulledDown, pixels) {

	boxesToBePulledDown.stop(true, true).animate({ 
		marginTop: pixels
	});

	flagForSettingStaticTopPosOnce = 0;

} // Creates bigger space for the sign in form to take

$(function() {

	// Sign in button functionality
	var signInButtonSelector = $('.header-bottom .sign-in');
	if(signInButtonSelector.length) { // Check if it's necessary to call sign in form expand function
		
		var formSelector = $(".form-login");
		var boxesToBePulledDown = $('.search_wrapper .categories_wrapper'); // Which dom elements will move so the form could expand
		var selectorCssSetMarginTop = parseInt(boxesToBePulledDown.css('margin-top'));
		var minusMarginToSet = 38; // How much minus margin top to take the boxes which will be pulled down
		var hasClickedOnSignIn = 0;

		signInButtonSelector.click( function() {

			//Hides top header nav -- taken from functions.js
			$(".header-top").css('height' , '50px');    
	        $(".nav-tab").hide();  
	        $('.header-top .col-sm-7').css('border-bottom' , "0");
	        $('.nav-tabs-head ul li').removeClass('current , navigation-border');
	        //Hides top header nav -- taken from functions.js

			if(!signInClickFlag) { // Click state 0 or 1
				$("html, body").stop(true, true).animate({ 
					scrollTop: 0 
				});
				fixSignInButtonFunctionalityAppearanceOnPage(signInButtonSelector, boxesToBePulledDown, minusMarginToSet);
				formSelector.stop(true,true).fadeToggle(200);
				signInClickFlag = 1;
			} else if(signInClickFlag) {
				$("html, body").stop(true, true).animate({ 
					scrollTop: 0 
				});
				fixSignInButtonFunctionalityAppearanceOnPage(signInButtonSelector, boxesToBePulledDown, selectorCssSetMarginTop);
				formSelector.fadeOut(200);
				signInClickFlag = 0;
			}
			var hasClickedOnSignIn = 1;
		});

		if(!hasClickedOnSignIn) {

			$('.ico-form-close, .nav-tabs-head ul li').click(function() {
			    fixSignInButtonFunctionalityAppearanceOnPage(signInButtonSelector, boxesToBePulledDown, selectorCssSetMarginTop);
				formSelector.fadeOut(200);
				signInClickFlag = 0;
			}); // Closes sign in form when clicked on listed selectors

		}

	} 

});