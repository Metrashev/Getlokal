$(document).ready(function() {
   if($('.list-place-item').length > 5){
       $('#list_of_places').pajinate({
        nav_label_prev : '',
        nav_label_next : '',
        show_first_last: false,
        items_per_page : 5 ,
        item_container_id : '.alt-content',
        nav_panel_id : '.pager-center'			
    }); 
   }
    var hash = window.location.hash;
    hash = hash.substring(1);
    if(!isNaN(hash)){                  
        $('.page_link').eq(hash).trigger('click');
    }
    
    var loading= false;
    $('.tipec').live('click', function() {
        var element = this;
        var href = $(this).attr('data');
        if(loading) return false;
        loading = true;
        $(this).parent().find('.desc_full').css('display', 'none');
        $('.listing_place_in .list_review_box').html('').css('display', 'none');
        $(this).parent().children('.list_review_box').css('display', 'block');
        $.ajax({
            url: href,
            beforeSend: function() {
                $(element).parent().find('.list_review_box').html('loading...');
            },
            success: function(data, url) {
                $(element).parent().find('.list_review_box').html(data);
                $(element).parent().find('.list_review_box').children('.add_review').append('<a id="special_close" href="javascript:void(0);"></a>');
                loading = false;
            //console.log(id);
            },
            error: function(e, xhr)
            {
                console.log(e);
            }
        });
        return false;
    });

    $('#places_pager a').click(function() {
        $.ajax({
            url: this.href,
            beforeSend: function( ) {
                $('#list_of_places').html('<div class="review_list_wrap">loading...</div>');
            },
            success: function( data ) {
                $('#list_of_places').html(data);
            }
        });
        var top = $('#list_of_places').offset().top - 60;
        $('html,body').scrollTop(top);
        return false;
    });
    
    $('#special_close').live('click', function() {
        $(this).parent().parent().parent().children('.desc_full').css('display', 'block');
        $(this).parent().parent().html('').css('display', 'none');
    });
    
    $('.page_link, .next_link, .previous_link').click(function() {
        $("html,body").animate({scrollTop: $('#map_canvas_list').offset().top}, 300);
    });
});