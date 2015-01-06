<?php use_stylesheet('facebook/gameGetLove.css') ?>

<form action="<?php echo url_for('facebook/getLove') ?>" method="post">
  <input type="hidden" name="step" value="3" />
  <div id="wrapper">
    <div id="header"></div>
    
    <div class="step1">
      <div class="heading">
        <h2>- PASUL 1 -</h2>
        Alege din lista de prieteni o persoană - iubita, iubit sau un amic
      </div>
      <?php if($relationship): ?>
        <div class="box relationship">
          <div class="left">
            Facebook ne-a șoptit că ești într-o relație cu:
          </div>
          <div class="right">
            <img src="<?php echo $relationship['pic_square'] ?>" width="50" /><br />
            <?php echo $relationship['name'] ?>
          </div>
        </div>

        <input class="relationshipNext" type="button" value="Mergi mai departe cu aceasta alegere" />
      
        <div class="heading">Vreau sa aleg pe altcineva:</div>
      <?php endif ?>

      <div class="input">
        <input type="text" id="friend" placeholder="scrie aici numele unui prieten" />
        <input type="hidden" id="friend-id" name="friend_id" value="<?php echo $relationship['uid'] ?>" />
        <input type="button" id="chose" value="Alege" />
        <div class="clear"></div>
      </div>
    </div>
    
    <div class="step2 box" style="display: none;">
      <div class="heading">
        <h2>- PASUL 2 -</h2>
        Tipul relatiei
      </div>
      <ul class="radio_list">
        <li>
          <label>
            <input type="radio" name="rel" checked="checked" />
            Amoroasa
          </label>
        </li> 
        <li>
          <label>
            <input type="radio" name="rel" />
            Amicitie
          </label>
        </li>
      </ul>
      <div class="clear"></div>
    </div>
    
    <div class="heading step3" style="display: none;">
      <h2>- PASUL 2 -</h2>
      Spune-ne un motiv pentru care relația voastră este specială
      
      <textarea name="caption" id="caption" cols="" rows="" placeholder="Ex.: gateste bine si imi aduce mic dejunul la pat"></textarea>
    </div>
    
    <div class="heading step4" style="display: none;">
      <h2>- PASUL 2 -</h2>
      Locul vostru
      
      <span>
        Scrie numele locului în care ieşiţi împreună cel mai des
      </span>
      
      <span class="error"></span>
      <input type="text" id="place" name="place" placeholder="scrie aici numele unui bar/cinematograf/etc" />
      <input type="hidden" id="place-id" name="place_id" value="" />
    </div>
    
    <div class="step5 box" style="display: none;">
      <div class="heading">
        <h2>- PASUL 3 -</h2>
        Vrei sa iti publicam poza pe facebook ?
      </div>
      <ul class="radio_list">
        <li>
          <label>
            <input type="radio" name="save_photo" value="1" checked="checked" />
            Da
          </label>
        </li> 
        <li>
          <label>
            <input type="radio" name="save_photo" value="0" />
            Nu
          </label>
        </li>
      </ul>
      <div class="clear"></div>
    </div>
    
    
    
    <input type="submit" class="submit" id="submit" value="Mergi mai departe" style="display: none;" />
  </div>
</form>

<div class="loading" style="text-align: center; display: none;">
      <a href="http://www.getlokal.ro/ro/article/am-lansat-aplicatia-getlove" target="_blank"><?php  echo image_tag('facebook/v4/loading.jpg') ?></a>
    </div>

<script type="text/javascript">
$(function() {
  var step = 1;
  
 
  
  $('.relationshipNext').click(function() {
    $('.step1').hide();
    $('.step4').show();
    step = 4;
    
    $('#submit').show();
  })
  
  $('#chose').click(function() {
    $('.step1').hide();
    $('.step4').show();
    step=4;
    $('#submit').show();
  })
  
  $('form').submit(function() {
    if(step < 5)
    {
      step++;
      $('.step1, .step2, .step3, .step4, .step5').hide();
      $('.step'+step).show();
      
      return false;
    }
    
    $('form').hide();
    $('.loading').show();
  })
$( "#friend" ).autocomplete({
	   
        source: function( request, response ) {
        $.ajax({
          url: "https://graph.facebook.com/me/friends?access_token=<?php echo $access_token?>&callback=?",
          dataType: "jsonp",
          data: {
            featureClass: "P",
            style: "full",
            maxRows: 12,
            name_startsWith: request.term
          },
          success: function( data ) {
            res = $.map( data.data, function( item ) {
              if (item.name.toLowerCase().indexOf(request.term.toLowerCase()) >= 0){
                return {
                  label: item.name,
                  value: item.id
                }
              }
            });
            response(res);
          }
        });
      },
      minLength: 2,
      focus: function( event, ui ) {
          $( "#friend" ).val( ui.item.label );
        },
      select: function( event, ui ) {
    	  $( "#friend" ).val( ui.item.label );
          $( "#friend-id" ).val( ui.item.value );
          return false;
      }
      });
    $("#friend").data("uiAutocomplete")._renderItem =  function( ul, item ) {
        console.log(item);
        var image_url = "http://graph.facebook.com/" + item.value +"/picture";
        return $( "<li>" )
          .append($("<img width='25' style='padding: 1px 5px 0 0' align='left'>").attr('src',image_url))
          .append( $( "<a>" ).text( item.label ) )
          .appendTo( ul );
    }
  $( "#place" ).autocomplete({
      source: "<?php echo url_for('facebook/autocomplete') ?>",
      minLength: 2,
      select: function( event, ui ) {
        $('#place-id').val(ui.item.id)
      }
  });
  
});
</script>


