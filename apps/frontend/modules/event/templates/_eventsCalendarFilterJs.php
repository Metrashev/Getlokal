<?php // use_stylesheet('jquery-ui/jquery-ui-1.8.6.custom.css'); ?>
<?php use_stylesheet('ui-lightness/jquery-ui-1.8.16.custom.css'); ?>
<?php use_javascript('init_date_picker.js'); ?>
<?php use_javascript('jquery-ui-i18n-'.mb_convert_case(getlokalPartner::getLanguageClass(), MB_CASE_LOWER,'UTF-8').'.js'); ?>
<?php
$sCulture = $sf_user->getCulture();
?>

<script type="text/javascript">
	function isEmpty(obj) {
        if (typeof obj == 'undefined' || obj === null || obj === '')
            return true;
        if (typeof obj == 'number' && isNaN(obj))
            return true;
        if (obj instanceof Date && isNaN(Number(obj)))
            return true;
        return false;
    }
	jQuery(document).ready(function (){
		var sCulture = '<?php echo $sCulture; ?>';
		if('en' == sCulture){
			$.datepicker.setDefaults($.datepicker.regional['']);
		}else
			$.datepicker.setDefaults($.datepicker.regional[sCulture]);

		$('#datepicker').datepicker({
			<?php echo (isset($sFilterDate) && !empty($sFilterDate)) ? "defaultDate: new Date('". $sFilterDate ."')," : ""; ?>
			<?php /* ?> beforeShowDay: highlightDays <?php */ ?>
		});
<?php /*
		function highlightDays(date) {
			var arEventDates = <?php echo $sDatesWithEventsJSArray; ?>
			if($.inArray(date.toString(), arEventDates) != -1){
				return [true, 'highlight'];
			}

            return [false, ''];
		}
*/ ?>
		$("#datepicker").datepicker().change(function(){

			var category_id = '<?php echo (isset($category_id) && !empty($category_id)) ? $category_id : ''; ?>';
			var sDate = $("#datepicker").datepicker().val();
			var oDate = new Date(sDate);
			var nDay = oDate.getDate();
			var nMonth = oDate.getMonth() + 1;
			var nYear = oDate.getFullYear();

			var sEndOfSocialEventListLink;
			var sCalendarPropertyURL = 'nDay=' + nDay + '&nMonth=' + nMonth + '&nYear=' + nYear;
			//
			if(isEmpty(category_id)){
				sEndOfSocialEventListLink = sCalendarPropertyURL;
			}else{
				sEndOfSocialEventListLink = 'category_id=' + category_id + '&' + sCalendarPropertyURL;
			}

			var sURL = '<?php echo url_for($sEventListURL); ?>?' + sEndOfSocialEventListLink;
			window.open(sURL, '_self', '<attributes>');
		});
	});
</script>
