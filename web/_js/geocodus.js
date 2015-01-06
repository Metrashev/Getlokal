jQuery(function ($) {
  var $logging = $('#logging'),
      map = $('#map')[0],
      started = false,
      url = window.geo.get,
      data = null,
      counter = parseInt(window.geo.count),
      timing = 1000;

  function log(message) {
    $logging.append($('<div>').html(message));
    $logging.scrollTop($logging[0].scrollHeight);
  }

  // init map
  log('Init map!');
  var gmap = new google.maps.Map(map, {
        center: new google.maps.LatLng(45, 26),
        zoom: 15
      }),
      geocoder = new google.maps.Geocoder();


  function start() {
    started = true;
    log('Process started!');
    $('#start').attr('disabled', true);
    proceed();
  }

  var errorCount = 0;

  function geocode(address, cb) {
    geocoder.geocode({address: address}, function (response, status) {
      if (status == google.maps.GeocoderStatus.OK) {
        var location = response[0].geometry.location;
        cb(location.lat(), location.lng());
        errorCount = 0; // reset error count
        if (counter % 20 == 0) {
          timing = 5000; // wait 10 seconds every 20 requests
        }
        return;
      }
      if (status == google.maps.GeocoderStatus.OVER_QUERY_LIMIT) {
        // refresh the page when limit is reached
        window.location.href = url + '?count=' + counter;
        // timing = 30000; // wait 30 seconds before next request
        // errorCount++;
      }
      if (errorCount == 10) {
        log('Too many consecutive errors.');
        stop();
      }
      // stop the process
      log('Geocoder returned: ' + status);
      cb(false, false);
    });
  }

  function getLocation(cb) {
    $.get(url, function (result) {
      cb(result);
    });
  }

  function proceed() {
    if (started) {
      setTimeout(process, timing);
      timing = 1000;
    }
  }

  function saveLocation(location) {
    log('Saving location ' + location.id + ' with data ' + location.lat +
        ', ' + location.lng + '. Count: ' + (counter + 1));
    $.post(url, {data: location}, function (response) {
      if (!response) {
        log("Company not saved. Server returned false!");
      } else {
        counter++;
      }
      proceed();
    });
  }

  function process() {
    getLocation(function (location) {
      if (!location) {
        // no locations, stop the processing
        log('No location returned!');
        stop();
        return;
      }

      log("Geocoding location id: " + location.id);
      var address = location.address + " " + location.city + " " + location.country;
      geocode(address, function (lat, lng) {
        if (!lat || !lng) {
          log('No results found for ' + location.id);
          return proceed();
        }
        location.lat = lat;
        location.lng = lng;
        saveLocation(location);
      });
    });
  }

  function stop() {
    started = false;
    log('Process stopped! Geocoded:' + counter + ' location.');
    $('#start').attr('disabled', false);
  }

  $('#start').click(start);
  $('#stop').click(stop);

  if (counter > 0) {
    start();
  }

});
