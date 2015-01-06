$(document).ready(function() {
    var $grid = $('#grid');   
    $grid.shuffle({
        itemSelector: '.element-item', // the selector for the items in the grid,
        gutterWidth: 20
    });

    if(document.getElementById('sector_id') != null && document.getElementById('city_id') != null){
        initialSort();
    }

  initMarkers();
  
 
// Initialize shuffle
$grid.shuffle();   
    $('#sector_id').on('change', function() {
        var sort = $(this).find("option:selected").attr('data-sectorId');
        var sectorUrl = $(this).find("option:selected").val();

        stateObject = {};
        var title = "city-sector";
        history.pushState(stateObject,title,sectorUrl);    
        // Filter elements
        if(sort==='all-sectors')
            {
              $grid.shuffle('shuffle', 00);
            }
        else{
            $grid.shuffle('shuffle', sort);
        }
    });

    $('#city_id').on('change', function() {
        var groupName = $(this).find("option:selected").attr('data-group');
        $.ajax({
            url: $(this).find("option:selected").attr('value'),
            //   data: ,
            beforeSend: function(jqXHR, request) {
                stateObject = {};
                var title = "city";
                url = request.url;
                history.pushState(stateObject,title,url);
                $('.sector_selection').html('<img src="/images/gui/blue_loader.gif"/>');
            },      
            success: function(data) {
                var myFilter = $(data).find("#sector_id");
                $('.sector_selection').html(myFilter);      
                $('#sector_id').first().select2();
                $grid.shuffle('shuffle', groupName );
                      
                $('#sector_id').on('change', function() {
                    var sectorUrl = $(this).find("option:selected").val();
                    stateObject = {};
                    var title = "city-sector";
                    history.pushState(stateObject,title,sectorUrl);
                    var showAll = document.getElementById('sector_id').selectedIndex;
                    //     var showAll = ddl.options[ddl.selectedIndex].getAttribute("data-title").toLowerCase();
                    var val = $(this).find("option:selected").attr('data-sectorId').toLowerCase();

                    if(showAll === 0){
                        $grid.shuffle('shuffle', function($el, shuffle) {

                            // Only search elements in the current group
                            if (shuffle.group !== 'all' && $.inArray(shuffle.group, $el.data('groups')) === -1) {
                                return false;
                            }
                            var text = $.trim( $el.find('.sectors-all').val()).toLowerCase();
                            return text.indexOf(showAll) !== -1;

                        });
                    }
                    else{
                     
                        $grid.shuffle('shuffle', function($el, shuffle) {

                            // Only search elements in the current group
                            if (shuffle.group !== 'all' && $.inArray(shuffle.group, $el.data('groups')) === -1) {
                                return false;
                            }

                            var text = $.trim( $el.find('.sector-id').val()).toLowerCase();
                            if(text === val)
                                return text.indexOf(val) !== -1;  
                        });
                    }    
              
                });    
            initMarkers();
            }
        })
        return false;
    });

    $('ul.sorting_wrap li input').on('click', function() {
        var stateObject = {};
        var sort = this.value,
        opts = {};
        switch(sort)
        {
            case '1':
                opts = {
                    reverse: false,
                    by: function($el) {
                        return parseInt($el.attr('data-low-high'), 10);
                    }
                };
                var title = "?order=1";
                var newUrl = "?order=1";
                history.pushState(stateObject,title,newUrl);
                break;
            case '2':
                opts = {
                    reverse: true,
                    by: function($el) {
                        return parseInt($el.attr('data-low-high'), 10);
                    }
                };
                var title = "?order=2";
                var newUrl = "?order=2";
                history.pushState(stateObject,title,newUrl);
                break;
            case '3':
                opts = {
                    reverse: true,
                    by: function($el) {
                        return $el.data('date-created');
                    }
                };
                var title = "?order=3";
                var newUrl = "?order=3";
                history.pushState(stateObject,title,newUrl);
                break;
            case '4':
                opts = {
                    reverse: false,
                    by: function($el) {
                        return $el.data('date-expires');
                    }
                };
                var title = "?order=4";
                var newUrl = "?order=4";
                history.pushState(stateObject,title,newUrl);
                break;  
            default:
                opts = {
                    reverse: true,
                    by: function($el) {
                        return $el.data('date-created');
                    }
                };
        }
        // Filter elements
        $grid.shuffle('sort', opts);
    });  
    
 $('.link_to_offer').hover( 
    function () {
       $(this).next().find('.offer_benefits').animate({ "height": "205px" }, "fast" );
       $(this).next().find('.offer_benefits ul').addClass('tags');
       $(this).next().find('.expiration_strip').addClass('hidden');
    },
    function () {
       $(this).next().find('.offer_benefits ul').removeClass('tags');
       $(this).next().find('.offer_benefits').animate({ "height": "24px" }, "fast" );
       $(this).next().find('.expiration_strip').removeClass('hidden');
       
    });
}); 

function initMarkers(){
     $('#grid').on('filtered.shuffle', function() {
        map.init();
        var bounds = new google.maps.LatLngBounds( );
        var shownOffer = $('.filtered');
        $(shownOffer).each(function(index, value) { 
            var point = new google.maps.LatLng($(this).attr('c-lat'),$(this).attr('c-long'));
            if($(this).attr('premuim')==1)   {
                map.markers[$(this).attr('c-id')] = new google.maps.Marker({
                    title: $(this).attr('c-title'),
                    position: point,
                    map: map.map,
                    draggable: false,
                    icon: new google.maps.MarkerImage('/images/gui/icons/small_marker_'+$(this).attr('sector-id')+'.png', null, null, null, new google.maps.Size(40,40)),
                    zIndex: google.maps.Marker.MAX_ZINDEX + 1   
                });
            }
            else if($(this).attr('premuim')==0){
                map.markers[$(this).attr('c-id')] = new google.maps.Marker({
                    title: $(this).attr('c-title'),
                    position: point,
                    map: map.map,
                    draggable: false,
                    icon: new google.maps.MarkerImage('/images/gui/icons/gray_small_marker_'+$(this).attr('sector-id')+'.png', null, null, null, new google.maps.Size(40,40)),
                    zIndex: google.maps.Marker.MAX_ZINDEX + 1         
                });
            }
            bounds.extend(point);     
        });       
        map.map.fitBounds(bounds);
    });
}

function initialSort(){
    var $grid = $('#grid');   
    var sectorAll = document.getElementById('sector_id').selectedIndex;
    var cityOnly = document.getElementById('city_id').selectedIndex;
    var valSector = $('#sector_id').find("option:selected").attr('data-sectorId').toLowerCase();
    var valCity = $('#city_id').find("option:selected").data('group');
    if(sectorAll === 0 && cityOnly !== 0){
        $grid.shuffle('shuffle', function($el, shuffle) {
            // Only search elements in the current group
            if (shuffle.group !== 'all' && $.inArray(shuffle.group, $el.data('groups')) === -1) {
                return false;
            }
            var text = $.trim( $el.find('.city-id').val());
            return text.indexOf(valCity) !== -1;
                    
                    
        });
    }
    else if(sectorAll !== 0 && cityOnly === 0){
        $grid.shuffle('shuffle', function($el, shuffle) {
            // Only search elements in the current group
            if (shuffle.group !== 'all' && $.inArray(shuffle.group, $el.data('groups')) === -1) {
                return false;
            }
            var text = $.trim( $el.find('.sector-id').val()).toLowerCase();
            if(text === valSector)
                return text.indexOf(valSector) !== -1;  
        });
    }  
    else if(cityOnly === 0 && sectorAll === 0){
       return true;
    }
    else{
         $grid.shuffle('shuffle', function($el, shuffle) {
            // Only search elements in the current group
            if (shuffle.group !== 'all' && $.inArray(shuffle.group, $el.data('groups')) === -1) {
                return false;
            }
            var text = $.trim( $el.find('.sector-id').val()).toLowerCase();
            if(text === valSector)
                return text.indexOf(valSector) !== -1;  
        });
     }    
    
}