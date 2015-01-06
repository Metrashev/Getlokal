<div class="review_edit_success form-message success" ></div>
<div class="stars-holder small">                    
	<ul>
		<li class="gray-star"><i class="fa fa-star"></i></li>
        <li class="gray-star"><i class="fa fa-star"></i></li>
        <li class="gray-star"><i class="fa fa-star"></i></li>
        <li class="gray-star"><i class="fa fa-star"></i></li>
        <li class="gray-star"><i class="fa fa-star"></i></li>
	</ul>
    <div class="top-list">
        <div class="hiding-holder" style="width: <?php echo round($review->getRating() * 20) ?>%;">
            <ul class="spans-holder small">
                <li class="red-star"><i class="fa fa-star"></i></li>
                <li class="red-star"><i class="fa fa-star"></i></li>
                <li class="red-star"><i class="fa fa-star"></i></li>
                <li class="red-star"><i class="fa fa-star"></i></li>
                <li class="red-star"><i class="fa fa-star"></i></li>
            </ul>
        </div>
    </div>
</div>

<p class="comment">	        	
 	<?php echo ($review->getUserId() == 5712) ? simple_format_text_review(htmlspecialchars_decode($review->getText(ESC_RAW))) : simple_format_text_review(htmlspecialchars($review->getText(ESC_RAW))) ?>	            
</p><!-- comment -->