<?php use_javascript('jquery.js') ?>

<div class="wrap" style="width: 900px; margin: 0 auto;">
<div style="float: left; width: 600px;">
<h2>where list</h2>
  <form action="<?php echo url_for('api2/wherelist') ?>" method="post">
    <input type="text" name="token" value="5cde456e76691a8c9172f91a938609c1" />    
    <input type="text" name="lat" value="42.703632" />
    <input type="text" name="long" value="23.32798" />    
    <input type="text" name="term" value="" /> 
    <input type="text" name="locale" value="bg" />
    <input type="text" name="country" value="bg" /> 
    <input type="submit" value="where list" />
  </form>

<h2>SearchNear</h2>
  <form action="<?php echo url_for('api2/searchNear') ?>" method="post">
    <input type="text" name="token" value="5cde456e76691a8c9172f91a938609c1" />    
    <input type="text" name="lat" value="42.681173" />
    <input type="text" name="long" value="23.310819" />
    <input type="text" name=keyword value="" />
    <input type="text" name="where" value="" />
    <input type="text" name=classification value="" />    
    <input type="text" name="locale" value="bg" />
    <input type="text" name="country" value="bg" /> 
    <input type="text" name="start_index" value="0" />
    <input type="text" name="end_index" value="2" />    
    <input type="submit" value="Search Near" />
  </form>
 <h2> Add place</h2>
  <form action="<?php echo url_for('api2/addnewplace') ?>" method="post">
    <input type="text" name="token" value="5cde456e76691a8c9172f91a938609c1" />    
    <input type="text" name="lat" value="42.681173" />
    <input type="text" name="long" value="23.310819" />
    <input type="text" name="phone" value="+393585555555" />
    <input type="text" name="title" value="NQkakva firma" />
    <input type="text" name=address value="Balsha 1" />
    <input type="text" name=location value="Sofia" />
    <input type="text" name="locale" value="bg" />
    <input type="text" name="country" value="bg" />
    <input type="text" name="classification_id" value="12" />
    <input type="submit" value="Add place" />
  </form>

  <h2>Test Login</h2>
  <form action="<?php echo url_for('api2/login') ?>" method="post">
    <input type="test" name="username" value="iva@getlokal.com" />
    <input type="password" name="password" value="lostsoul" />
    
    <input type="submit" value="Test login" />
  </form>
  
  <h2>Test recover</h2>
  <form action="<?php echo url_for('api2/recover') ?>" method="post">
    <input type="test" name="username" value="iva@getlokal.com" />
    
    <input type="submit" value="Test" />
  </form>

  <h2>Test Register</h2>
  <form action="<?php echo url_for('api2/register') ?>" method="post">
    <input type="text" name="username" value="dasdas@asdfsdf.com" />
   <input type="text" name="password" value="111111" />
    <input type="text" name="firstname" value="Iva" />
    <input type="text" name="lastname" value="Tri" />
    <input type="text" name="locale" value="bg" />
    <input type="text" name="country" value="bg" />
    <input type="text" name="allow_contact" value="0" />
    <input type="text" name="accept" value="0" />
    <input type="text" name="location" />    
    <input type="text" name="lat" value="42.681173" />
    <input type="text" name="long" value="23.310819" />
    <input type="submit" value="Test register" />
   
  </form>
  
  
  <h2>FB Register</h2>
  <form action="<?php echo url_for('api2/register') ?>" method="post">
    <input type="text" name="username" value="dasdas@asdfsdf.com" />   
    <input type="text" name="firstname" value="Iva" />
    <input type="text" name="lastname" value="Tri" />
    <input type="text" name="locale" value="bg" />
    <input type="text" name="country" value="bg" />
    <input type="text" name="allow_contact" value="0" />
    <input type="text" name="accept" value="0" />
    <input type="text" name="location" />
    <input type="text" name="access_token" value="AAAEHhjdGjB4BAIx2IFbPZBaACJrjUZAsJrMgbyhDwGFZAkpQetvwnhmBNVxtVeOqSjxm4ShTEXhpK7oEpzjzEd4cGO3k1cHQvEyw7pkXQZDZD" />
    <input type="text" name="lat" value="42.681173" />
    <input type="text" name="long" value="23.310819" />
    <input type="submit" value="Test register" />
   
  </form>

  <h2>Test FB login</h2>
  <form action="<?php echo url_for('api2/LoginFb') ?>" method="post">
    <input type="text" name="access_token" value="AAAEHhjdGjB4BAIx2IFbPZBaACJrjUZAsJrMgbyhDwGFZAkpQetvwnhmBNVxtVeOqSjxm4ShTEXhpK7oEpzjzEd4cGO3k1cHQvEyw7pkXQZDZD" />
     <input type="text" name="locale" value="bg" />
    <input type="text" name="country" value="bg" />
    <input type="text" name="lat" value="44.44004" />
    <input type="text" name="long" value="26.097539" />
    <input type="submit" value="Test FB" />
  </form>
  
  <h2>Test profile</h2>
  <form action="<?php echo url_for('api2/profile') ?>" method="post">
    <input type="text" name="token" value="5cde456e76691a8c9172f91a938609c1" />
    
    <input type="submit" value="Test FB" />
  </form>
  
  <h2>Test Locations</h2>
  <form action="<?php echo url_for('api2/search') ?>" method="post">
    <input type="text" name="lat" value="44.44004" />
    <input type="text" name="long" value="26.097539" />
    <input type="text" name="text" value="Restaurant" />
    <input type="text" name="token" value="5cde456e76691a8c9172f91a938609c1" />
    
    <input type="submit" value="Test FB" />
  </form>
  
  <h2>Test news</h2>
  <form action="<?php echo url_for('api2/news') ?>" method="post">
    <input type="text" name="lat" value="44.44004" />
    <input type="text" name="long" value="26.097539" />
    <input type="text" name="text" value="Restaurant" />
    <input type="text" name="token" value="5cde456e76691a8c9172f91a938609c1" />
    
    <input type="submit" value="Test FB" />
  </form>
  
  <h2>Test Images</h2>
  <form action="<?php echo url_for('api2/photos') ?>" method="post">
    <input type="text" name="identifier" value="id" />
    <input type="text" name="token" value="5cde456e76691a8c9172f91a938609c1" />
    <select name="type">
      <option value="0">Company</option>
      <option value="1">Event</option>
    </select>
    
    <input type="submit" value="Test" />
  </form>
  
  <h2>Test review</h2>
  <form action="<?php echo url_for('api2/review') ?>" method="post" rel="noajax" enctype="multipart/form-data">
    <input type="text" name="identifier" value="14360" />
    <input type="text" name="token" value="5cde456e76691a8c9172f91a938609c1" />
    <input type="text" name="rating" value="5" />
    <input type="text" name="review" value="test2" />
    <input type="file" name="file" />
    <input type="submit" value="Test" />
  </form>
  
  <h2>Test favorite</h2>
  <form action="<?php echo url_for('api2/favorite') ?>" method="post">
    <input type="text" name="id" value="id" />
    <input type="text" name="token" value="5cde456e76691a8c9172f91a938609c1" />
    
    <input type="submit" value="Test" />
  </form>
  
  <h2>Test STATUS</h2>
  <form action="<?php echo url_for('api2/status') ?>" method="post">
    <input type="text" name="identifier" value="id" />
    <input type="text" name="token" value="5cde456e76691a8c9172f91a938609c1" />
    
    <input type="submit" value="Test" />
  </form>
  
  <h2>Favorite List</h2>
  <form action="<?php echo url_for('api2/favoriteList') ?>" method="post">
    <input type="text" name="token" value="5cde456e76691a8c9172f91a938609c1" />
    <input type="text" name="lat" value="44.44004" />
    <input type="text" name="long" value="26.097539" />
    <input type="submit" value="Test" />
  </form>
  
  <h2>Test news</h2>
  <form action="<?php echo url_for('api2/news') ?>" method="post">
    <input type="text" name="token" value="5cde456e76691a8c9172f91a938609c1" />
    <input type="text" name="lat" value="44.44004" />
    <input type="text" name="long" value="26.097539" />
    <input type="submit" value="Test" />
  </form>
  
  <h2>Test checkin</h2>
  <form action="<?php echo url_for('api2/checkin') ?>" method="post">
    <input type="text" name="token" value="5cde456e76691a8c9172f91a938609c1" />
    <input type="text" name="identifier" value="121" />
    <input type="submit" value="Test" />
  </form>
  
  <h2>Test checkins</h2>
  <form action="<?php echo url_for('api2/checkinList') ?>" method="post">
    <input type="text" name="token" value="5cde456e76691a8c9172f91a938609c1" />
    <input type="text" name="lat" value="42.681173" />
    <input type="text" name="long" value="23.310819" />
    <input type="text" name="locale" value="bg" />
    <input type="text" name="country" value="bg" />
    <input type="submit" value="Test" />
  </form>
  
  <h2>Test upload</h2>
  <form action="<?php echo url_for('api2/upload') ?>" method="post" rel="noajax" target="_blank" enctype="multipart/form-data">
    <input type="text" name="token" value="5cde456e76691a8c9172f91a938609c1" />
    <input type="text" name="identifier" value="121" />
    <input type="file" name="file" />
    
    <input type="submit" value="Test" />
  </form>
  
  <h2>Company upload validate</h2>
  <form action="<?php echo url_for('api2/validatephoto') ?>" method="post">
    <input type="text" name="token" value="5cde456e76691a8c9172f91a938609c1" />
    <input type="text" name="text" value="dsasda" />
    <input type="text" name="photoid" value="113727" />
    <input type="submit" value="Company Report" />
  </form>
  
   <h2>Company Offers</h2>
  <form action="<?php echo url_for('api2/companyoffers') ?>" method="post">
    <input type="text" name="token" value="5cde456e76691a8c9172f91a938609c1" />
    <input type="text" name="identifier" value="121009" />
    <input type="submit" value="Company Offers" />
  </form>
  
   <h2>Company Report</h2>
  <form action="<?php echo url_for('api2/report') ?>" method="post">
    <input type="text" name="token" value="5cde456e76691a8c9172f91a938609c1" />
    <input type="text" name="identifier" value="14360" />
    <input type="text" name="offence" value="8" />
    <input type="submit" value="Company Report" />
  </form>
  
   <h2> Classifications list</h2>
  <form action="<?php echo url_for('api2/classificationslist') ?>" method="post">
    <input type="text" name="token" value="5cde456e76691a8c9172f91a938609c1" />
     <input type="text" name="locale" value="bg" />
    <input type="text" name="country" value="bg" />
    <input type="submit" value="Classifications list" />
  </form>
  
  
 
  
</div>
<div id="response" style="float: right; width: 300px;">
</div>
</div>

<script type="text/javascript">
$(document).ready(function() {
  $('form').submit(function() {
    if($(this).attr('rel') == 'noajax') return true;
    
    $.ajax({
      url:  this.action,
      data: $(this).serialize(),
      type: 'post',
      success: function(data) {
        $('#response').html(data);
      }
    })
    
    return false;
  });
})
</script>