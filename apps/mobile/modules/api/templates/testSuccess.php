<?php use_javascript('jquery.js') ?>

<div class="wrap" style="width: 900px; margin: 0 auto;">
<div style="float: left; width: 600px;">

<h2>suspended coffee</h2>
  <form action="<?php echo url_for('api/suspendedCoffee') ?>" method="post">
   
    <input type="hidden" name="locale" value="ro" />
    <input type="hidden" name="country" value="ro" />
      <input type="text" name="lat" value="44.44004" />
    <input type="text" name="long" value="26.097539" />
    <input type="submit" value="Test suspended" />
  </form>

  <h2>Test Login</h2>
  <form action="<?php echo url_for('api/login') ?>" method="post">
    <input type="test" name="username" value="campan@gmail.com" />
    <input type="password" name="password" value="lostsoul" />
    
    <input type="submit" value="Test login" />
  </form>
  
  <h2>Test recover</h2>
  <form action="<?php echo url_for('api/recover') ?>" method="post">
    <input type="test" name="username" value="campan@gmail.com" />
    
    <input type="submit" value="Test" />
  </form>

  <h2>Test Register</h2>
  <form action="<?php echo url_for('api/register') ?>" method="post">
    <input type="hidden" name="username" value="test@test222.ro" />
    <input type="hidden" name="password" value="lostsoul" />
    <input type="hidden" name="firstname" value="Test" />
    <input type="hidden" name="lastname" value="Test" />
    <input type="hidden" name="locale" value="ro" />
    <input type="hidden" name="country" value="ro" />
    
    <input type="submit" value="Test register" />
  </form>

  <h2>Test FB login</h2>
  <form action="<?php echo url_for('api/loginFb') ?>" method="post">
    <input type="text" name="access_token" value="" />
    
    <input type="submit" value="Test FB" />
  </form>
  
  <h2>Test profile</h2>
  <form action="<?php echo url_for('api/profile') ?>" method="post">
    <input type="text" name="token" value="token" />
    
    <input type="submit" value="Test FB" />
  </form>
  
  <h2>Test Locations</h2>
  <form action="<?php echo url_for('api/search') ?>" method="post">
    <input type="text" name="lat" value="44.44004" />
    <input type="text" name="long" value="26.097539" />
    <input type="text" name="text" value="Restaurant" />
    <input type="text" name="token" value="token" />
    
    <input type="submit" value="Test FB" />
  </form>
  
  <h2>Test news</h2>
  <form action="<?php echo url_for('api/news') ?>" method="post">
    <input type="text" name="lat" value="44.44004" />
    <input type="text" name="long" value="26.097539" />
    <input type="text" name="text" value="Restaurant" />
    <input type="text" name="token" value="token" />
    
    <input type="submit" value="Test FB" />
  </form>
  
  <h2>Test Images</h2>
  <form action="<?php echo url_for('api/itemImages') ?>" method="post">
    <input type="text" name="id" value="id" />
    <input type="text" name="token" value="token" />
    <select name="type">
      <option value="0">Company</option>
      <option value="1">Event</option>
    </select>
    
    <input type="submit" value="Test" />
  </form>
  
  <h2>Test review</h2>
  <form action="<?php echo url_for('api/review') ?>" method="post">
    <input type="text" name="identifier" value="163643" />
    <input type="text" name="token" value="token" />
    <input type="text" name="rating" value="5" />
    <input type="text" name="review" value="test" />
    
    <input type="submit" value="Test" />
  </form>
  
  <h2>Test favorite</h2>
  <form action="<?php echo url_for('api/favorite') ?>" method="post">
    <input type="text" name="id" value="id" />
    <input type="text" name="token" value="token" />
    
    <input type="submit" value="Test" />
  </form>
  
  <h2>Test STATUS</h2>
  <form action="<?php echo url_for('api/status') ?>" method="post">
    <input type="text" name="identifier" value="id" />
    <input type="text" name="token" value="token" />
    
    <input type="submit" value="Test" />
  </form>
  
  <h2>Favorite List</h2>
  <form action="<?php echo url_for('api/favoriteList') ?>" method="post">
    <input type="text" name="token" value="token" />
    <input type="text" name="lat" value="44.44004" />
    <input type="text" name="long" value="26.097539" />
    <input type="submit" value="Test" />
  </form>
  
  <h2>Test news</h2>
  <form action="<?php echo url_for('api/news') ?>" method="post">
    <input type="text" name="token" value="token" />
    <input type="text" name="lat" value="44.44004" />
    <input type="text" name="long" value="26.097539" />
    <input type="submit" value="Test" />
  </form>
  
  <h2>Test checkin</h2>
  <form action="<?php echo url_for('api/checkin') ?>" method="post">
    <input type="text" name="token" value="token" />
    <input type="text" name="identifier" value="121" />
    <input type="submit" value="Test" />
  </form>
  
  <h2>Test checkins</h2>
  <form action="<?php echo url_for('api/checkinList') ?>" method="post">
    <input type="text" name="token" value="token" />
    <input type="submit" value="Test" />
  </form>
  
  
  
  <h2>Test upload</h2>
  <form action="<?php echo url_for('api/upload') ?>" method="post" rel="noajax" target="_blank" enctype="multipart/form-data">
    <input type="text" name="token" value="token" />
    <input type="text" name="identifier" value="121" />
    <input type="file" name="file" />
    
    <input type="submit" value="Test" />
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