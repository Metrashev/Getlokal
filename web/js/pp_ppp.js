
function getAddPhotoForm(el) {
	$('.reservation_content').html('');
	$('.add_photo_content').html('');
	$('#add_list_wrap').html('');
  $.ajax({
    type: "GET",
    url: el.href,
    beforeSend: function(data) { 
    	$('.add_photo_content').html(LoaderHTML);
    }, 
    success: function(data) {
        if ($.trim(data)) {
        	$('.add_photo_content').html(data);
        }
        setFileUplRules();
    }
  });
  return false;
  }

function getAddToListForm(el){
	$('.reservation_content').html('');
	$('.add_photo_content').html('');
	$('#add_list_wrap').html('');
	$.ajax({
		type: "GET",
		url: el.href,
		beforeSend: function() {
			$('#add_list_wrap').html(LoaderHTML);
		},
		success: function(data) {
			$('#add_list_wrap').html(data);
		}
	});
}