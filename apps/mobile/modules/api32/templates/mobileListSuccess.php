<div id="content">
  <?php foreach ($companies as $company): ?>
    <a href="getlokal://location?<?php echo $company->getId() ?>">
          <div class="company">
            <a href="getlokal://location?<?php echo $company->getId() ?>" style="text-decoration:none;">
              <h1 class="title"><?php echo $company?></h1>
            </a>
            <div class="classification"><?php echo $company->getClassification() ?></div>
            <div class="about">  
              <div class="text"><?php echo __('Address') ?> <span><?php echo $company->getDisplayAddress(); ?></span></div>
              <div class="clear"></div>
            </div>
              
            <div style="float:right;">
              <img src="<?php echo image_path($company->getThumb(1, 0)) ?>" />
            </div>
            <div class="clear"></div>      
            <div class="col">

            </div>
            
            <div class="clear"></div>
            

          </div>
      <?php endforeach ?> 
    </a>
</div>

 
<script type="text/javascript">
var toggleFavorite = function() {
  var element = document.getElementById('addFavorite');
  
  if(element.getAttribute("src").indexOf('ON') != -1)
  {
    element.src = element.src.replace('ON', '');
    return;
  }
  
  element.src = element.src.replace('.png', 'ON.png');
}
</script>
