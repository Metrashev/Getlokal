var LoaderHTML = '<div class="loading-data"><div class="spinner"><div class="rect1"></div><div class="rect2"></div><div class="rect3"></div><div class="rect4"></div><div class="rect5"></div></div></div>';
var selected_id = null;
var isLastButtonEnter = false;
var firstTimeLoad = true;
var map = {
  lat       : 0,
  lng       : 0,
  autocompleteUrl   : '',
  classification_id : 0,
  sector_id : 0,
  loadUrl   : '',
  markers   : {},
  zoom      : 4,
  geocoder  : null,
  center    : null,
  newCenter : null,
  map       : null,
  mgr       : null,
  window    : null,
  keywords  : '',
  address   : '',
  acWhere   : '',
  acWhereIDs: '',
  page      : 1,
  pages     : 1,
  perPage   : 20,
  updating  : false,
  useAjaxPagination: false,
  totalObjects: 0,
  itemsPerPage: 20,
  totalPages:   0,
  currentPage:  1,
  offset    :   0,
  blankMap  : false,
  autoTrigger : false,
  
  loadMarkers: function(jsonString){
	  objects = JSON.parse(jsonString);

	  companyCount = objects.length;
	  for (i = 0; i < companyCount; i++) {
		 s = objects[i];
		 if(s.lat != 0 && s.lng != 0){
			 var icon = new google.maps.MarkerImage('/images/gui/icons/'+s.icon+'.png', null, null, null, new google.maps.Size(40,40));
			 marker = new google.maps.Marker({
	            title: s.title,
	            position: new google.maps.LatLng(s.lat, s.lng),
	            map: map.map,
	            icon: icon,
	            zIndex:100
	          });
			  marker.data = s;
			  
			  //bounds.extend(new google.maps.LatLng(s.lat, s.lng));
			  google.maps.event.addListener(marker, 'click', function(a) {
//		    	selected_id = s.id;
		        map.overlay.load($("#overlay_"+this.data.id).html());
		        //map.overlay.setCenter(new google.maps.LatLng(s.lat, s.lng));
		        map.overlay.setCenter(this.position);
		        map.overlay.show();
		        $('.nav_arrow2').hide();
		        $('#hide_sim_places').show();
		      });
			  map.markers[s.id] = marker;
		 }		 
	  }
	  this.map.setZoom(15);
	  
	  if(!$.isEmptyObject(this.markers)){
		  this.fitToMarkers();
	  }
  },
  
  fitToMarkers: function(){
	  bounds = new google.maps.LatLngBounds();
	  for(key in map.markers){
		  var marker = map.markers[key];
		  var myLatLng = new google.maps.LatLng(marker.position.lat(), marker.position.lng());
		  bounds.extend(myLatLng);
	  }
	  map.map.fitBounds(bounds);
	  //map.map.setCenter(bounds.getCenter())
  },
  
  initAutocomplete: function() {
    $.widget( "custom.locationComplete", $.ui.autocomplete, {
        _renderMenu: function( ul, items ) {
            var that = this,
                currentCategory = "";

            $.each( items, function( index, item ) {
                if ( item.category != currentCategory ) {
                    if(index != 0)
                    {
                      ul.append( "<li class='break'></li>" );
                    }

                    ul.append( "<li class='ui-autocomplete-category'>" + item.category + "</li>" );
                    currentCategory = item.category;
                }
                that._renderItemData( ul, item );
            });
            ul.append( "<li class='break'></li>" );
        },
        _renderItemData: function (ul, item) {     
            var location = item.title.split(',');
            html = "";
            for(i=location.length-1;i>=0;i--){
                element = location[i];
                if(i == location.length-1){
                     var html =" <span class='country'>"+element+"</span>"+html;
                }
                if(i == location.length-2){
                   var html = " <span class='region'>"+element+','+"</span>"+html;
                }
                if(i == location.length-3){
                 var html = " <span class='city'>"+ element+',' +"</span>" +html;
                }
            }
          return $('<li class="locations"></li>')
            .data("item.autocomplete", item)
            .append("<a>" + html + "<span class='clear'></span></a>")
            .appendTo(ul);
            
        }
    });
    $.widget( "custom.termComplete", $.ui.autocomplete, {
        _renderMenu: function( ul, items ) {
            var that = this,
                currentCategory = "";

            $.each( items, function( index, item ) {
                if ( item.category != currentCategory ) {
                    if(index != 0)
                    {
                      ul.append( "<li class='break'></li>" );
                    }

                    ul.append( "<li class='ui-autocomplete-category'>" + item.category + "</li>" );
                    currentCategory = item.category;
                }
                that._renderItemData( ul, item );
            });
            ul.append( "<li class='break'></li>" );
        },
        _renderItemData: function (ul, item) {
          var img = '',
              href = '',
              details = '';

          if(item.address !== undefined)
            details = "<span class='address'>" + item.address + "</span>";

          if(item.link !== undefined)
            href = " href='" + item.link + "'";
          else href = " href='javascript:void(0)'";

          return $("<li></li>")
            .data("item.autocomplete", item)
            .append("<a" + href +">" +" <span class='title'>" + item.title + "</span>" + details + "<span class='clear'></span></a>")
            .appendTo(ul);
        }
    });
    
    $([{
      el: $( "#search_what" ),
      of: $( "#search_what" ).parent().parent(),
      to: $('#search_what').parent().parent().parent(),
      w: $('#search_where')
    }, {
      el: $( "#search_header_what" ),
      of: $( "#search_header_what" ).parent().parent(),
      to: $('#search_header_what').parent(),
      w: $('#search_header_where')
    }]).each(function (i, s) {
      var cache = {},
          lastXhr;

      s.el.termComplete({
        minLength: 2,
        appendTo: s.to,
        position: { my: "left top", at: "left bottom", of: s.of },
        search: function(){
        $('.search-what-controll .ui-autocomplete').html('');
        $('.search-what-controll .ui-autocomplete').css('width',$(window).width()-608)
                      .append(LoaderHTML)
                     .show();
                     $('.search-what-controll .ui-autocomplete').addClass('show-autocomplete');
        },
        response: function() {$('.loading-data').remove();},
        select: function (event, ui) {
          if (ui.item.link !== undefined) {
            window.location.href = ui.item.link;
          }
        },
        source: function (request, response) {
          // cache key must be term + city search
          var key = request.term + '_' + s.w.val();
          if (key in cache) {
            response(cache[key]);
            return;
          }
          // add where to the data
          request.w = s.w.val();

          lastXhr = $.getJSON(map.autocompleteUrl, request, function (data, status, xhr) {
            cache[key] = data;
            if (xhr === lastXhr) {
              response(data);
              $('.search-what-controll .ui-autocomplete').css('width',$(window).width()-608);
            }
            if(!data.length) {$('.search-what-controll .ui-autocomplete').removeClass('show-autocomplete');} else {getTypeOfData(data);}
          });
        }
      });
    });

    $([{
      el: $( "#search_where" ),
      of: $( "#search_what" ).parent().parent(),
      to: $('#search_where').parent().parent().parent()
    }, {
      el: $( "#search_header_where" ),
      of: $( "#search_header_where" ).parent().parent(),
      to: $('#search_header_where').parent()
    }]).each(function (i, s) {
      var cache = {};

      s.el.locationComplete({
        minLength: 2,
        appendTo: s.to,
        position: { my: "left top", at: "left bottom", of: s.of },
        search: function(){
        $('.search-where-controll .ui-autocomplete').html('');
        $('.search-where-controll .ui-autocomplete').css('width',$(window).width()-608)
                     .append(LoaderHTML)
                     .show();
                     $('.search-where-controll .ui-autocomplete').addClass('show-autocomplete');
        },
        response: function() {
          $('.loading-data').remove();
        },
        select: function (event, ui) {
          $("#ac_where").val(ui.item.title);
          $("#ac_where_ids").val(ui.item.ids);
          $('.header_box').css('width','40%');
          $('#search_header_where').css('width','100%');
          if(event.keyCode == 13) { 
            $('.search-where-controll .ui-autocomplete').removeClass('show-autocomplete');
            $("#search-form .btn-search").trigger('click');
          }
          if(ui.item.link !== undefined) {
            window.location.href = ui.item.link;
          }
          if (ui.item.reference) {
            $('#search_header_where_reference').val(ui.item.reference);
          }
        },
        
        source: function (request, response) {
        	var term = request.term;
        	var key = term;
            request.w = term;
            lastXhr = $.getJSON(map.autocompleteUrl+"Location", request, function (data, status, xhr) {
              cache[key] = data;
              var returnData = [];
              for (i = 0; i< data.length; i++) {
            	  returnData.push({
                  label: data[i].description,
                  title: data[i].description,
                  ids: data[i].ids,
                  category: '',
                  reference: data[i].reference,
                });
              }
              cache[term] = returnData;
              response(returnData);
              if(!data.length) {$('.search-where-controll .ui-autocomplete').removeClass('show-autocomplete');}    
              //$('#ui-id-2').css('width',$(window).width()-608);            
            }); 

        }
      });
    });
  },
  Overlay: function(center, map) {
    this.center = center;
    this.map_ = map;

    this.div_ = null;

    this.setMap(map);
  },
  initOverlay: function() {
    map.Overlay.prototype = new google.maps.OverlayView();

    map.Overlay.prototype.onAdd = function() {
      var div = $('<div><div class="down"></div></div>').addClass('map_overlay');
      var close = $('<a></a>').addClass('close').click(function() {
        map.overlay.hide();
        $('.nav_arrow2').hide();
        for (i in map.markers) {
	    	map.markers[i].setVisible(true);
	    }
        return false;
      });
      var content = $('<div></div>').addClass('content');

      div.append(content).append(close).hide();

      // Set the overlay's div_ property to this DIV
      this.div_ = div;
      this.content_ = content;

      var panes = this.getPanes();
      panes.overlayImage.appendChild(this.div_[0]);
    };

    map.Overlay.prototype.draw = function() {
      var overlayProjection = this.getProjection();

      // Resize the image's DIV to fit the indicated dimensions.
      var div = this.div_;

      var xy = overlayProjection.fromLatLngToDivPixel(this.center);

      div.css({
        left: (xy.x - 115) + 'px',//old value - 124
        top: (xy.y - div.outerHeight() - 40) + 'px'
      });
    };

    map.Overlay.prototype.setCenter = function(center) {
      this.center = center;
      this.draw();
    };
    map.Overlay.prototype.onRemove = function() {
      this.div_.parentNode.removeChild(this.div_);
    };

    // Note that the visibility property must be a string enclosed in quotes
    map.Overlay.prototype.hide = function() {
      this.div_.hide();
    };

    map.Overlay.prototype.show = function() {
      this.div_.show();

      this.panMap();
    };

    map.Overlay.prototype.load = function(data) {
      this.div_.find('.content').html(data);
    };

    map.Overlay.prototype.toggle = function() {
      this.div_.toggle();
    };

    map.Overlay.prototype.toggleDOM = function() {
      if (this.getMap()) {
        this.setMap(null);
      } else {
        this.setMap(this.map_);
      }
    };

    map.Overlay.prototype.panMap = function() {
      // if we go beyond map, pan map
      var map = this.map_;
      var bounds = map.getBounds();
      if (!bounds) return;

      // The position of the infowindow
      var position = this.center;

      // The dimension of the infowindow
      var iwWidth = this.div_.outerWidth();
      var iwHeight = this.div_.outerHeight();

      // The offset position of the infowindow
      var iwOffsetX = -120;
      var iwOffsetY = -180;

      // Padding on the infowindow
      var padX = 10;
      var padY = 10;

      // The degrees per pixel
      var mapDiv = map.getDiv();
      var mapWidth = mapDiv.offsetWidth;
      var mapHeight = mapDiv.offsetHeight;
      var boundsSpan = bounds.toSpan();
      var longSpan = boundsSpan.lng();
      var latSpan = boundsSpan.lat();
      var degPixelX = longSpan / mapWidth;
      var degPixelY = latSpan / mapHeight;

      // The bounds of the map
      var mapWestLng = bounds.getSouthWest().lng();
      var mapEastLng = bounds.getNorthEast().lng();
      var mapNorthLat = bounds.getNorthEast().lat();
      var mapSouthLat = bounds.getSouthWest().lat();

      // The bounds of the infowindow
      var iwWestLng = position.lng() + (iwOffsetX - padX) * degPixelX;
      var iwEastLng = position.lng() + (iwOffsetX + iwWidth + padX) * degPixelX;
      var iwNorthLat = position.lat() - (iwOffsetY - padY) * degPixelY;
      var iwSouthLat = position.lat() - (iwOffsetY + iwHeight + padY) * degPixelY;

      // calculate center shift
      var shiftLng =
          (iwWestLng < mapWestLng ? mapWestLng - iwWestLng : 0) +
          (iwEastLng > mapEastLng ? mapEastLng - iwEastLng : 0);
      var shiftLat =
          (iwNorthLat > mapNorthLat ? mapNorthLat - iwNorthLat : 0) +
          (iwSouthLat < mapSouthLat ? mapSouthLat - iwSouthLat : 0);

      // The center of the map
      var center = map.getCenter();

      // The new map center
      var centerX = center.lng() - shiftLng;
      var centerY = center.lat() - shiftLat;

      // center the map to the new shifted center
      map.panTo(new google.maps.LatLng(centerY, centerX));
    };

  },
  init: function(load) {
    map.initOverlay();
    map.initAutocomplete();
    map.center = new google.maps.LatLng(map.lat, map.lng);

    map.geocoder = new google.maps.Geocoder();

    var myOptions = {
      center: map.center,
      zoom: 13,
      mapTypeId: google.maps.MapTypeId.ROADMAP,
      streetViewControl: true
    };
    var map_step = 100;
    var overlayDesabler = $('.map_activator');
    $(".nav_arrow").click(function() {
    	var height = $("#google_map").height() < 390? 400: 185;
       
    	$("#google_map").animate({ height: height },100, function() { 
    		google.maps.event.trigger(map.map, 'resize');
                overlayDesabler.hide();
    	});
    	
    	$(".nav_arrow").toggle();

		  return false;
    });

    $(".nav_arrow2").click(function() {
    	$(".nav_arrow2").toggle();
    	if ($(this).attr('id') == 'hide_sim_places')
    	{
			for (i in map.markers) {
		    	map.markers[i].setVisible(false);
		    }
    		map.markers[selected_id].setVisible(true);
    	}
    	else {
    		for (i in map.markers) {
    	    	map.markers[i].setVisible(true);
    	    }
    	}
		return false;
    });

    $('#map_reload').click(function() {
      // show loading
      $('.map').addClass('loading');
      if(firstTimeLoad) {
        $('.map_loader').append(LoaderHTML);
        firstTimeLoad = false;
      }

      // map.address = 'true';
    	map.blankMap = true;
    	map.offset = 0;
    	map.currentPage = 1;
    	map.mapClick = 1;
    	map.zoom = map.map.zoom;
    	var cenX = map.map.getCenter();
        var height = $("#google_map").height();        

        if(height < 390 && !map.autoTrigger) {
            $("#google_map").css('height', '400px');
            $(".nav_arrow").toggle('fast');

            google.maps.event.trigger(map.map, 'resize');
            map.map.setCenter(cenX);
        }
        
        map.load({
        	geometry: {
        		bounds: map.map.getBounds()
        	}
        }, true, map.blankMap, map.autoTrigger);
        
        map.autoTrigger = '';
    });

    if($("#google_map").length) {
      map.map = new google.maps.Map(document.getElementById("google_map"), myOptions);

      google.maps.event.addListener(map.map, 'dragend', function() { addHoverToGmapButton() } );

    /*var input = document.getElementById('search_where');
    var autocomplete = new google.maps.places.Autocomplete(input, {types: ['geocode']});
    autocomplete.bindTo('bounds', map.map);

    var input = document.getElementById('search_header_where');
    var autocomplete = new google.maps.places.Autocomplete(input, {types: ['geocode']});

    autocomplete.bindTo('bounds', map.map); */

      map.overlay = new map.Overlay(map.map.getCenter(), map.map);
    }
  },

  geocodeAndLoad: function(address) {
    map.address = address;
    map.geocoder.geocode( { 'address': address}, function(results, status) {
      if (status == google.maps.GeocoderStatus.OK) {

        if(results[0].geometry.bounds)
        {
          bounds = new google.maps.LatLngBounds();
          bounds.extend(results[0].geometry.bounds.getNorthEast());
          bounds.extend(results[0].geometry.bounds.getSouthWest());

          map.map.fitBounds(bounds);
        }

        map.center = results[0].geometry.location;
        map.map.setCenter(map.center);
      }

      map.load(results[0], true);
    });
  },
  
  geocodeAndPositionMap: function(address) {   
	    map.address = address;
	    map.geocoder.geocode( { 'address': address}, function(results, status) {
	      if (status == google.maps.GeocoderStatus.OK) {

	        if(results[0].geometry.bounds)
	        {
	          bounds = new google.maps.LatLngBounds();
	          bounds.extend(results[0].geometry.bounds.getNorthEast());
	          bounds.extend(results[0].geometry.bounds.getSouthWest());

	          map.map.fitBounds(bounds);
	        }

	        map.center = results[0].geometry.location;
	        map.map.setCenter(map.center);
	      }
	    });
	  },

  initAjaxPager: function() {
    var container = $('.ajaxPager');
    var startPagesListFrom = 0;
    var endPagesListTo = 0;
    var startPagesListHTML = '';
    var endPagesListHTML = '';
    var paginationHTML = '';
    var paginationRightHTML = '';
    var paginationLeftHTML = '';

//    map.currentPage = container.find('.pagerCenter a.current').attr('id');

    // $('#places_count').html(map.totalObjects);

/*
    if (!isNaN(map.currentPage)) {
      map.currentPage = parseInt(map.currentPage.replace('page-', ''));
    }
    else {
      map.currentPage = 1;
    }
*/

    if (map.totalObjects > map.itemsPerPage) {
      container.css('display', 'block');
      map.totalPages = Math.ceil(map.totalObjects / map.itemsPerPage);
      var pageClass = '';
      
      //$('.pager').remove();
      map.setPagerCenterHTML(pageClass);
      // container.find('.pagerLeft').html(paginationLeftHTML);
      // container.find('.pagerRight').html(paginationRightHTML);

// 
      container.find('.pagerLeft').click(function(){
    	  map.currentPage = map.currentPage - 1;
    	  container.find('.pagerCenter a').removeClass('current');
          $('#page-' + map.currentPage).addClass('current');
          
          map.offset = (map.currentPage - 1) * map.itemsPerPage;

          $('.places-list').html(LoaderHTML);
          //$('html,body').scrollTop($('.listing_tabs_wrap').offset().top - 60);
          $('html,body').scrollTop($('.places-list').offset().top - 184);

          map.geocodeAndLoad(map.address);
          map.setPagerCenterHTML(pageClass);
          return;
      });
      
      container.find('.pagerRight').click(function(){
    	  map.currentPage = parseInt(map.currentPage) - -1;
    	  container.find('.pagerCenter a').removeClass('current');
          $('#page-' + map.currentPage).addClass('current');
          
          map.offset = (map.currentPage - 1) * map.itemsPerPage;

          $('.places-list').html(LoaderHTML);
          //$('html,body').scrollTop($('.listing_tabs_wrap').offset().top - 60);
          $('html,body').scrollTop($('.places-list').offset().top - 184);

          map.geocodeAndLoad(map.address);
          map.setPagerCenterHTML(pageClass);
          return;
      });

      container.find('.pagerCenter a').click('live', function(){
          container.find('.pagerCenter a').removeClass('current');

          $(this).addClass('current');
          map.currentPage = parseInt($(this).attr('id').replace('page-', ''));
          map.offset = (map.currentPage - 1) * map.itemsPerPage;

          $('.places-list').html(LoaderHTML);
          //$('html,body').scrollTop($('.listing_tabs_wrap').offset().top - 60);
          $('html,body').scrollTop($('.places-list').offset().top - 184);

          map.geocodeAndLoad(map.address);
          map.setPagerCenterHTML(pageClass);
          return;
      });
      $("#page-"+map.currentPage).addClass('current');
    }
    else {
      container.css('display', 'none');
    }
  },

  setPagerCenterHTML: function(pageClass) {
	  var container = $('.ajaxPager');
	  var paginationHTML = '';
	  var startPagesListHTML = '';
	  var endPagesListHTML = '';
	  var paginationLeftHTML = '';
	  var paginationRightHTML = '';
	  if(map.totalPages > 4) {
		  if ((map.currentPage - 2) <= 1) {
			  startPagesListFrom = 1;
			  
			  if ((map.currentPage + 2) >= map.totalPages) {    			  
    			  endPagesListTo = map.totalPages;
    		  }
    		  else {
    			  endPagesListHTML = '...' + '<a href="javascript:;" id="page-' + map.totalPages + '" ' + pageClass + '>' + map.totalPages + '</a>';
    			  if (map.currentPage != 3) {
    				  endPagesListTo = 3;
    			  }
    			  else {
    				  endPagesListTo = map.currentPage + 1;
    			  }
    		  }
	      }
		  else {    	          
	          startPagesListHTML = '<a href="javascript:;" id="page-' + 1 + '" ' + pageClass + '>' + 1 + '</a>' + '...';
	          startPagesListFrom = map.currentPage - 1;
	          
	          if ((map.currentPage + 2) >= map.totalPages) {    			  
    			  endPagesListTo = map.totalPages;
    			  if (map.currentPage > map.totalPages - 2) {
    				  startPagesListFrom = map.totalPages - 2;
    			  }
    		  }
    		  else {
    			  endPagesListHTML = '...' + '<a href="javascript:;" id="page-' + map.totalPages + '" ' + pageClass + '>' + map.totalPages + '</a>';
    			  endPagesListTo = map.currentPage + 1;
    		  }
	      }
		  
	  }
	  else {
		  startPagesListFrom = 1;
		  endPagesListTo = map.totalPages;
	  }
	  
	  if (map.currentPage < map.totalPages) {
	      paginationRightHTML = '<a href="javascript:;" id="next"><span><i class="fa fa-angle-double-right"></i></span></a>';
	  }

	  if (map.currentPage > 1) {
	      paginationLeftHTML = '<a href="javascript:;" id="prev"><span><i class="fa fa-angle-double-left"></i></span></a>';
	  }
	  if (map.totalPages != 1) {
	      for (var page = startPagesListFrom; page <= endPagesListTo; page++) {
		      if (map.currentPage == page) {
			      pageClass = 'class="current"';
		      } else {
			      pageClass = '';
		      }

		      paginationHTML += '<a href="javascript:;" id="page-' + page + '" ' + pageClass + '>' + page + '</a>';
	      }
	  }
      
      paginationHTML = startPagesListHTML + paginationHTML + endPagesListHTML;
      
      $('.pagerCenter').html(paginationHTML);
      $('.pagerLeft').html(paginationLeftHTML);
      $('.pagerRight').html(paginationRightHTML);
      
      container.find('.pagerCenter a').click('live', function(){
          container.find('.pagerCenter a').removeClass('current');

          $(this).addClass('current');
          map.currentPage = parseInt($(this).attr('id').replace('page-', ''));
          map.offset = (map.currentPage - 1) * map.itemsPerPage;

          $('.places-list').html(LoaderHTML);
          //$('html,body').scrollTop($('.listing_tabs_wrap').offset().top - 60);
          $('html,body').scrollTop($('.places-list').offset().top - 184);

          map.geocodeAndLoad(map.address);
          map.setPagerCenterHTML(pageClass);
          return;
      });
      
      $("#page-"+map.currentPage).addClass('current');
  },

  initPages: function() {
    $('.pager_center').html('');
    map.page  = 1;

    for(i=1; i<=map.pages; i++)
    {
      $('.pager_center').append('<a href="#" rel="'+i+'">'+i+'</a>');
    }

    $('.pager_center a').click(function() {
      map.showPage(this.rel * 1);
	  var top = $('.listing_tabs_wrap').offset().top - 60;
      $('html,body').scrollTop(top);
      return false;
    });

    $('.pager_left a').click(function() {
      if(map.page == 1) return false;

      map.showPage(map.page - 1);
	  var top = $('.listing_tabs_wrap').offset().top - 60;
      $('html,body').scrollTop(top);
      return false;
    });

    $('.pager_right a').click(function() {
      if(map.page == map.pages) return false;

      map.showPage(map.page + 1);
	  var top = $('.listing_tabs_wrap').offset().top - 60;
      $('html,body').scrollTop(top);
      return false;
    });

    map.showPage(1);
  },

  showPage: function(page) {
    map.page = page;

    $('.pager_left a').show();
    $('.pager_right a').show();
    $('.pager_center a').removeClass('active');

    if(map.page == 1) {
      $('.pager_left a').hide();
    }
    if(map.page == map.pages) {
      $('.pager_right a').hide();
    }

    $('.pager_center a[rel='+page+']').addClass('active');

    $('.listing_place_wrap .page').hide();
    $('.listing_place_wrap .page.'+map.page).show();
  },

  load: function(result, fit_map, blank, autoT) {
    if (map.blankMap) {
      blank = 'true';
    }
    if(result && !result.geometry.bounds) result = undefined;

    if(map.updateing) return;

    map.updateing = true;

    for (var i in map.markers)
    {
      map.markers[i].setMap(null);
    }
    map.markers = {};

    var $icon = $('a#map_reload');

    // remove loadin icon
    function end(jqXHR, settings) {
      $icon.removeClass('reloading');
      map.updateing = false;
    }

    var postData = {
        lat:  map.map.getCenter().lat(),
        lng:  map.map.getCenter().lng(),
        Nlat: result? result.geometry.bounds.getNorthEast().lat(): map.map.getBounds().getNorthEast().lat(),
        Elng: result? result.geometry.bounds.getNorthEast().lng(): map.map.getBounds().getNorthEast().lng(),
        Slat: result? result.geometry.bounds.getSouthWest().lat(): map.map.getBounds().getSouthWest().lat(),
        Wlng: result? result.geometry.bounds.getSouthWest().lng(): map.map.getBounds().getSouthWest().lng(),
        s:    map.keywords,
        w:    map.address,
        mapClick:	this.mapClick || 0,
        ac_where:    map.acWhere,
        ac_where_ids:    map.acWhereIDs,
        // reference: map.reference,
        offset: map.offset,
        sector_id:         map.sector_id,
        classification_id: map.classification_id,
        blank: blank,
        auto: autoT
    };
    
  //reset to mapClick = 0 for the next click
    this.mapClick = 0;

    // Add limit and offset to assiotive array
    if (map.useAjaxPagination) {
      postData.offset = map.offset;
    }

    $.ajax({
      url: map.loadUrl,
      dataType: 'json',
      data: postData,

      // show loading icon
      beforeSend: function (jqXHR, settings) {
        $icon.addClass('reloading');
      },
      complete: end,
      error: end,
      success: function(data) {
        var divs = [];
        $('.listing_place_wrap').html('').hide();

        // Hide loader
        $('.map').removeClass('loading');

        map.pages = 0;
        // $('#places_count').html(data.length);

        if(!data.length) {
          $('#results').hide();
          $('#no_results').show();
        }

        bounds = new google.maps.LatLngBounds();
        bounds.extend(map.map.getCenter());

        map.totalObjects = data[0].totalObjects;

        $(data).each(function(i,s) {
			if(s.latitude > 0 && s.longitude > 0){
					var zIndex = (s.is_ppp) ? 100 : 1;
					var icon = new google.maps.MarkerImage('/images/gui/icons/'+s.icon+'.png', null, null, null, new google.maps.Size(40,40));
					
				  map.markers[s.id] = new google.maps.Marker({
				    title: s.title,
				    position: new google.maps.LatLng(s.latitude, s.longitude),
				    map: map.map,
				    icon: icon,
				    zIndex: zIndex
				  });
		          
		
		          bounds.extend(new google.maps.LatLng(s.latitude, s.longitude));
		
		          google.maps.event.addListener(map.markers[s.id], 'click', function() {
		        	  selected_id = s.id;
		            map.overlay.load(s.overlay);
		            map.overlay.setCenter(new google.maps.LatLng(s.latitude, s.longitude));
		            map.overlay.show();
		            $('.nav_arrow2').hide();
		            $('#hide_sim_places').show();
		            //map.showPage(parseInt($('#company-'+ s.id).parent().attr("class").replace('page ', '')));
		
		            //$(document).scrollTop($('#company-'+ s.id).offset().top);
		
		            //$('#company-'+ s.id).animate({backgroundColor: '#ffff99'}, 300, function() {
		            //  $(this).animate({backgroundColor: '#ffffff'});
		            //});
		          });
		
		          if (i % map.perPage == 0 && i>0) {
		            map.pages++;
		            $('.listing_place_wrap').append('<div class="page '+ map.pages+ '">'+ divs.join(' ') +'</div>');
		            divs = [];
		          }
		
		          divs[i] = s.html;
			}
        });

        if(divs.length)
        {
          map.pages++;

          if(fit_map)
          {
            map.map.fitBounds(bounds);

            if (map.map.getZoom() > 16) map.map.setZoom(16);
          }

          $('.places-list').html(divs.join(' '))
//          $('.listing_place_wrap').append('<div class="page '+ map.pages+ '">'+ divs.join(' ') +'</div>');
        }
  
        $('#places_count').html(map.totalObjects);
        if (!map.useAjaxPagination) {
          map.initPages();
        } else {
          map.initAjaxPager();
        }
        
        $('.listing_place_wrap').show();
         if($( ".pagerCenter" ).children().first().hasClass('current')){
            $('.pagerLeft').css('visibility', 'hidden');
        }else{
            $('.pagerLeft').css('visibility', 'visible');
        }
         if($( ".pagerCenter" ).children().last().hasClass('current')){
            $('.pagerRight').css('visibility', 'hidden');
        }else{
            $('.pagerRight').css('visibility', 'visible');
        }
        map.updateing = false;
      }
      
    });
  }
};
$('.header_box input').focus(function(){ 
     $('.header_box').addClass('extented');
     $('#search_header_where').addClass('extented');
     $('#search_header_what').addClass('shorten');
}); 

$('.header_box input').blur(function(){
    $('.header_box').removeClass('extented');
    $('#search_header_where').removeClass('extented');
    $('#search_header_what').removeClass('shorten'); 
});

$(document).ready(function () {
    $('.content_in.index').on("click",".pager_center a",function () {
        $("html, body").animate({
            scrollTop: 500
        }, 2000);
    });

});