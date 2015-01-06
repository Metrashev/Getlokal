<form action="<?php echo url_for('facebook/game1') ?>" method="post">
  <div class="step1 slide">
    <a href="#" class="continue"></a>
  </div>
  <div class="step2 slide">
    <span class="drink p1"></span>
    <span class="drink p2"></span>
    <span class="drink p3"></span>
    <span class="drink p4"></span>
    <div class="content">
      <div class="error"></div>
      
      <h1>Care-i locul (club, pub, etc.) in care te simti cel mai bine la party-uri sau concerte?</h1>
      
      <input type="text" name="q1" />
      <input type="hidden" name="q1_id" id="q1" value="" />
      
      <a href="#" class="continue"></a>
    </div>
  </div>
  <div class="step3 slide">
    <span class="drink p1 full"></span>
    <span class="drink p2"></span>
    <span class="drink p3"></span>
    <span class="drink p4"></span>
    
    <div class="content">
      <div class="error"></div>
      
      <h1>Ce bei cel mai des, atunci când ieși în oraș?</h1>
      
      <div class="radio">
      <?php foreach(array('Bere', 'Vin', 'Cocktail-uri', 'Long drinks', 'Shot-uri', 'Nu beau alcool') as $i => $name): ?>
        <label>
          <span class="check"><input type="radio" name="q2" value="<?php echo $i ?>" /></span><?php echo $name ?>
        </label>
      <?php endforeach ?>
      </div>
      
      <a href="#" class="continue"></a>
    </div>
  </div>
  <div class="step4 slide">
    <span class="drink p1 full"></span>
    <span class="drink p2 full"></span>
    <span class="drink p3"></span>
    <span class="drink p4"></span>
    
    <div class="content">
      <div class="error"></div>
      
      <h1>Dansezi pe...</h1>
      <div class="radio">
      <?php foreach(array('Rock', 'Indie', '80\'s music', 'Dubstep', 'Punk', 'Nu prea dansez') as $i => $name): ?>
        <label>
          <span class="check"><input type="radio" name="q3" value="<?php echo $i ?>" /></span><?php echo $name ?>
        </label>
      <?php endforeach ?>
      </div>
      
      <a href="#" class="continue"></a>
    </div>
  </div>
  <div class="step5 slide">
    <span class="drink p1 full"></span>
    <span class="drink p2 full"></span>
    <span class="drink p3 full"></span>
    <span class="drink p4"></span>
    
    <div class="content">
      <div class="error"></div>
      <h1>Cu cine ieși în oraș cel mai des?</h1>
      
      <div class="radio">
      <?php foreach(array('Cu gașca de prieteni vechi', 'Cu iubitul/ iubita', 'Cu colegii de la munca/ scoala', 'Singur - îmi fac prieteni rapid', 'Cu cine se nimerește', 'Nu prea ies în oraș') as $i => $name): ?>
        <label>
          <span class="check"><input type="radio" name="q4" value="<?php echo $i ?>" /></span><?php echo $name ?>
        </label>
      <?php endforeach ?>
      </div>
      
      <a href="#" class="continue"></a>
    </div>
  </div>
  <div class="step6 slide">
    <span class="drink p1 full"></span>
    <span class="drink p2 full"></span>
    <span class="drink p3 full"></span>
    <span class="drink p4 full"></span>
    <div class="content">
      <div class="error"></div>
      <h1>Îți calculăm rezultatul cât ai zice "mahmureală"!</h1>
      
      <?php echo image_tag('facebook/v1/dots.png') ?>
    </div>
  </div>
</form>

<script type="text/javascript">
$(function() {
  _step = 1;
  
  $('form').submit(function() {
    if(_step != 6)
    {
      _step++;
      $('.slide').hide();
      $('.step'+ _step).show();
      return false;
    }
  })
  
  $( ".step2 input" ).autocomplete({
      source: "<?php echo url_for('facebook/autocomplete') ?>",
      minLength: 2,
      select: function( event, ui ) {
        $('#q1').val(ui.item.id)
      }
  });
        
  $('.slide').hide();
  $('.step'+ _step).show();
  
  $('.slide .check').click(function() {
    $(this).parent().parent().find('input').removeAttr('checked');
    $(this).parent().parent().find('.check').removeClass('active');
    $(this).addClass('active');
    $(this).find('input').attr('checked', 'checked');
  });
  
  $('.slide .continue').click(function () {
    if(!$('input[name=q'+ (_step-1)+ ']').val() && _step == 2) 
    {
      $(this).parent().find('.error').html('<span>Trebuie sa raspunzi la intrebare ca sa mergi mai departe</span>');
      
      return false;
    }
    if(_step>2 && !$('input[name=q'+ (_step-1)+ ']:checked').length)
    {
      $(this).parent().find('.error').html('<span>Trebuie sa raspunzi la intrebare ca sa mergi mai departe</span>');
      
      return false;
    }
    
    _step++;
    $('.slide').hide();
    $('.step'+ _step).show();
    
    if(_step == 6)
    {
      $('form').submit();
    }
    return false;
  });
});
</script>