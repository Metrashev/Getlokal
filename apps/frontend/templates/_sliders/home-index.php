<div class="slider_wrapper home-slider">
	<div class="slider-separator"></div>
	<div class="container">
		<div class="form-login">
			<div class="container">
				<div class="row">
					<div class="col-sm-12">

						<?php include_partial('user/signin_form',array('form'=> new sfGuardFormSignin()));?>

<!-- 						<form action="#">
							<div class="form-head">
								<h3>Log In<i class="ico-form-close"></i></h3>
							</div>
								
							<div class="form-body">
								<div class="form-row">
									<div class="form-controls">
										<i class="fa fa-user"></i>
										<input type="text" class="field" id="account" placeholder="Your account" />
									</div>
								</div>
								
								<div class="form-row">
									<div class="form-controls">
										<i class="fa fa-lock"></i>
										<input type="password" class="field" id="password" placeholder="Your password" />
									</div>
								</div>
								
								<div class="form-group">
									<div class="checkbox">
										<input type="checkbox" class="field" id="checkbox"/>
										<label for="checkbox"><span></span>Remember me</label>
									</div>
									
									<div class="form-row">
										<label for="#"><a href="#">Forgot password?</a></label>
										<div class="form-controls">
										</div>
									</div>
								</div>
							</div>
								
							<div class="form-foot">
								<div class="form-actions">
									<input type="submit" class="form-btn" value="Sign in">
									<input type="submit" class="form-btn-facebook" value="Sign in via Facebook">
									<p>Don't have an account?<a href="#">Sign up</a></p>
								</div>
							</div>
						</form> -->
					</div>
				</div>
			</div>
		</div><!-- form-login -->
	
		<!-- <div class="bs">
			    <div id="myCarousel" class="carousel slide" data-interval="10000" data-ride="carousel">
			    	Carousel indicators
			        <ol class="carousel-indicators">
			            <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
			            <li data-target="#myCarousel" data-slide-to="1"></li>
			            <li data-target="#myCarousel" data-slide-to="2"></li>
			        </ol>   
			        Carousel items
	        		<div class="carousel-inner">
			            <div class="active item">
			                <div class="col-sm-6">
			                	<h2>Places</h2>
			                	<div class="caption">
			                	  <h3>A great night out, recommended beauty salon, or trendy bar - Getlokal has all of these and 
			                	  	<span>
			                	  		much more
			                	  	</span>
			                  	  </h3>
			                	</div>
			                </div>
					
			                <div class="col-sm-6">
			                	<div class="prifile-review">
			                		<div class="profile-image alignleft">
			                			<a href="#"><img src="http://lorempixel.com/85/85/" class="" alt=""></a>
			                		</div>
			                		<span class="title"><a href="#">Andrea Florova</a></span>
			                		<p><em>Went again to Spaghetti Kitchen, and again had a really good time-our food was freshly prepared in front of our eyes everything</em></p>
									<div class="review-information">
										<span>Spagetty Kitchen</span>
										<ul>
											<li class="red-star"><i class="fa fa-star"></i></li>
											<li class="red-star"><i class="fa fa-star"></i></li>
											<li class="red-star"><i class="fa fa-star"></i></li>
											<li class="red-star"><i class="fa fa-star"></i></li>
											<li class="gray-star"><i class="fa fa-star"></i></li>
										</ul>
										
										<small><span>1340</span>reviews</small>
									</div>
					
									<ul class="review-places">
										<li><a href="#"><i class="fa fa-tags"></i>Restourants in Sofia</a></li>
										<li><a href="#"><i class="fa fa-tags"></i>Bar &amp; Dinner</a></li>
									</ul>
			                	</div>
			                </div>
			            </div>
					
			            <div class="item">
			                <div class="col-sm-6">
			                	<h2>Places</h2>
			                	<div class="caption">
			                	  <h3>A great night out, recommended beauty salon, or trendy bar - Getlokal has all of these and 
			                	  	<span>
			                	  		much more
			                	  	</span>
							                	  	  </h3>
			                	</div>
			                </div>
					
			                <div class="col-sm-6">
			                	<div class="prifile-review">
			                		<div class="profile-image alignleft">
			                			<a href="#"><img src="http://lorempixel.com/85/85/" class="" alt=""></a>
			                		</div>
			                		<span class="title">Andrea Florova</span>
			                		<p><em>Went again to Spaghetti Kitchen, and again had a really good time-our food was freshly prepared in front of our eyes everything</em></p>
									<div class="review-information">
										<span>Spagetty Kitchen</span>
										<ul>
											<li class="red-star"><i class="fa fa-star"></i></li>
											<li class="red-star"><i class="fa fa-star"></i></li>
											<li class="red-star"><i class="fa fa-star"></i></li>
											<li class="red-star"><i class="fa fa-star"></i></li>
											<li class="gray-star"><i class="fa fa-star"></i></li>
										</ul>
										
										<small><span>1340</span>reviews</small>
									</div>
					
									<ul class="review-places">
										<li><a href="#"><i class="fa fa-tags"></i>Restourants in Sofia</a></li>
										<li><a href="#"><i class="fa fa-tags"></i>Bar &amp; Dinner</a></li>
									</ul>
			                	</div>
			                </div>
			            </div>
					
			            <div class="item">
			                <div class="col-sm-6">
			                	<h2>Places</h2>
			                	<div class="caption">
			                	  <h3>A great night out, recommended beauty salon, or trendy bar - Getlokal has all of these and 
			                	  	<span>
			                	  		much more
			                	  	</span>
			                  	  </h3>
			                	</div>
			                </div>
			                
			                <div class="col-sm-6">
			                	<div class="prifile-review">
			                		<div class="profile-image alignleft">
			                			<a href="#"><img src="http://lorempixel.com/85/85/" class="" alt=""></a>
			                		</div>
			                		<span class="title">Andrea Florova</span>
			                		<p>
			                			<em>
			                				Went again to Spaghetti Kitchen, and again had a really good time-our food was freshly prepared in front of our eyes everything
			                			</em>
			                		</p>
									<div class="review-information">
										<span>Spagetty Kitchen</span>
										<ul>
											<li class="red-star"><i class="fa fa-star"></i></li>
											<li class="red-star"><i class="fa fa-star"></i></li>
											<li class="red-star"><i class="fa fa-star"></i></li>
											<li class="red-star"><i class="fa fa-star"></i></li>
											<li class="gray-star"><i class="fa fa-star"></i></li>
										</ul>
										
										<small><span>1340</span>reviews</small>
									</div>
					
									<ul class="review-places">
										<li><a href="#"><i class="fa fa-tags"></i>Restourants in Sofia</a></li>
										<li><a href="#"><i class="fa fa-tags"></i>Bar &amp; Dinner</a></li>
									</ul>
			                	</div>
			                </div>
			            </div>
		            </div>
		        </div>
		    </div>bs -->
					
		<div class="boxedcontainer">
			<div class="tp-banner-container">
				<div class="tp-banner" >
					<ul><!-- SLIDE  -->
						<li data-transition="fade" data-slotamount="7" data-masterspeed="1500" >
							<!-- MAIN IMAGE -->
							<img src="/../css/images/slider-bg-01.jpg"  alt="slidebg1"  data-bgfit="cover" data-bgposition="left top" data-bgrepeat="no-repeat">
							
		
							<!-- LAYER NR. 3 -->
							<div class="large_bold_grey skewfromrightshort customout"
								data-x="80"
								data-y="96"
								data-customout="x:0;y:0;z:0;rotationX:0;rotationY:0;rotationZ:0;scaleX:0.75;scaleY:0.75;skewX:0;skewY:0;opacity:0;transformPerspective:600;transformOrigin:50% 50%;"
								data-speed="500"
								data-start="800"
								data-easing="Back.easeOut"
								data-endspeed="500"
								data-endeasing="Power4.easeIn"
								data-captionhidden="on"
								style="z-index: 4; margin: -70px 0 0 0 65px;"><h2><?php echo __('Places'); ?></h2>
							</div>
		
							<!-- LAYER NR. 7 -->
							<div class="tp-caption small_thin_grey customin customout"
								data-x="80"
								data-y="240"
								data-customin="x:0;y:100;z:0;rotationX:0;rotationY:0;rotationZ:0;scaleX:1;scaleY:3;skewX:0;skewY:0;opacity:0;transformPerspective:600;transformOrigin:0% 0%;"
								data-customout="x:0;y:0;z:0;rotationX:0;rotationY:0;rotationZ:0;scaleX:0.75;scaleY:0.75;skewX:0;skewY:0;opacity:0;transformPerspective:600;transformOrigin:50% 50%;"
								data-speed="500"
								data-start="1300"
								data-easing="Power4.easeOut"
								data-endspeed="500"
								data-endeasing="Power4.easeIn"
								data-captionhidden="on"
								style="z-index: 8"><div class="caption">
			                	  <h3><?php echo __('Planning a great night out<br>looking for a recommended beauty salon, <br>or a trendy bar - you will find everything you search in Getlokal'); ?><br> 	  	<span class="int-back">
			                	  		
			                	  	</span>
			                  	  </h3>
			                	</div>
							</div>
		
							<!-- LAYER NR. 8 -->
							<div class="tp-caption skewfromrightshort customout"
								data-x="816"
								data-y="207"
								data-customout="x:0;y:0;z:0;rotationX:0;rotationY:0;rotationZ:0;scaleX:0.75;scaleY:0.75;skewX:0;skewY:0;opacity:0;transformPerspective:600;transformOrigin:50% 50%;"
								data-speed="500"
								data-start="1750"
								data-easing="Back.easeOut"
								data-endspeed="500"
								data-endeasing="Power4.easeIn"
								data-captionhidden="on"
								style="z-index: 9">
							</div>
		
							<!-- LAYER NR. 11 -->
							<div class="medium_bold_red skewfromrightshort customout"
								data-x="right" data-hoffset="-90"
								data-y="200"
								data-customout="x:0;y:0;z:0;rotationX:0;rotationY:0;rotationZ:0;scaleX:0.75;scaleY:0.75;skewX:0;skewY:0;opacity:0;transformPerspective:600;transformOrigin:50% 50%;"
								data-speed="500"
								data-start="1800"
								data-easing="Back.easeOut"
								data-endspeed="500"
								data-endeasing="Power4.easeIn"
								data-captionhidden="on"
								style="z-index: 12;">
			                		<div class="profile-review">
			                			<div class="profile-image alignleft">
				                			<a href="#"><img src="http://lorempixel.com/85/85/" class="" alt=""></a>
				                		</div>
			                			<span class="title">Andrea D'ge</span>
			                			<p>
				                			<span class="comment-txt">
				                				Went again to Spaghetti Kitchen, and again had a really good <br> time-our food was freshly prepared in front of our eyes everything
				                			</span>
				                		</p>
										<div class="review-information">
											<span>Spagetty Kitchen</span>
											<ul>
												<li class="red-star"><i class="fa fa-star"></i></li>
												<li class="red-star"><i class="fa fa-star"></i></li>
												<li class="red-star"><i class="fa fa-star"></i></li>
												<li class="red-star"><i class="fa fa-star"></i></li>
												<li class="gray-star"><i class="fa fa-star"></i></li>
											</ul>
											
											<small><span>1340</span>reviews</small>
										</div>
						
										<ul class="review-places">
											<li><a href="#"><i class="fa fa-tags"></i>Restourants in Sofia</a></li>
											<li><a href="#"><i class="fa fa-tags"></i>Bar &amp; Dinner</a></li>
										</ul>
			                		</div>
							</div>
						</li>
	
						<li data-transition="fade" data-slotamount="7" data-masterspeed="1500" >
							<!-- MAIN IMAGE -->
							<img src="/../css/images/images.jpg"  alt="slidebg1"  data-bgfit="cover" data-bgposition="left top" data-bgrepeat="no-repeat">
							
		
							<!-- LAYER NR. 3 -->
							<div class="large_bold_grey skewfromrightshort customout"
								data-x="80"
								data-y="96"
								data-customout="x:0;y:0;z:0;rotationX:0;rotationY:0;rotationZ:0;scaleX:0.75;scaleY:0.75;skewX:0;skewY:0;opacity:0;transformPerspective:600;transformOrigin:50% 50%;"
								data-speed="500"
								data-start="800"
								data-easing="Back.easeOut"
								data-endspeed="500"
								data-endeasing="Power4.easeIn"
								data-captionhidden="on"
								style="z-index: 4; margin: -70px 0 0 0 65px;"><h2><?php echo __('Events'); ?></h2>
								
							</div>
		
							<!-- LAYER NR. 7 -->
							<div class="small_thin_grey customin customout"
								data-x="80"
								data-y="240"
								data-customin="x:0;y:100;z:0;rotationX:0;rotationY:0;rotationZ:0;scaleX:1;scaleY:3;skewX:0;skewY:0;opacity:0;transformPerspective:600;transformOrigin:0% 0%;"
								data-customout="x:0;y:0;z:0;rotationX:0;rotationY:0;rotationZ:0;scaleX:0.75;scaleY:0.75;skewX:0;skewY:0;opacity:0;transformPerspective:600;transformOrigin:50% 50%;"
								data-speed="500"
								data-start="1300"
								data-easing="Power4.easeOut"
								data-endspeed="500"
								data-endeasing="Power4.easeIn"
								data-captionhidden="on"
								style="z-index: 8"><div class="caption">
			                	  <h3><br> <?php echo __('Concerts, exhibitions,<br>parties – Getlokal will show you when and where<br>local events are happening'); ?><br>              	  	<span class="int-back">
			                	  		
			                	  	</span>
			                  	  </h3>
			                	</div>
							</div>
		
							<!-- LAYER NR. 8 -->
							<div class="tp-caption skewfromrightshort customout"
								data-x="816"
								data-y="207"
								data-customout="x:0;y:0;z:0;rotationX:0;rotationY:0;rotationZ:0;scaleX:0.75;scaleY:0.75;skewX:0;skewY:0;opacity:0;transformPerspective:600;transformOrigin:50% 50%;"
								data-speed="500"
								data-start="1750"
								data-easing="Back.easeOut"
								data-endspeed="500"
								data-endeasing="Power4.easeIn"
								data-captionhidden="on"
								style="z-index: 9">
							</div>
		
							<!-- LAYER NR. 11 -->
							<div class="tp-caption medium_bold_red skewfromrightshort customout"
								data-x="right" data-hoffset="-90"
								data-y="200"
								data-customout="x:0;y:0;z:0;rotationX:0;rotationY:0;rotationZ:0;scaleX:0.75;scaleY:0.75;skewX:0;skewY:0;opacity:0;transformPerspective:600;transformOrigin:50% 50%;"
								data-speed="500"
								data-start="1800"
								data-easing="Back.easeOut"
								data-endspeed="500"
								data-endeasing="Power4.easeIn"
								data-captionhidden="on"
								style="z-index: 12;">
		                		<div class="profile-review">
		                			<div class="profile-image alignleft">
			                			<a href="#"><img src="http://lorempixel.com/85/85/" class="" alt=""></a>
			                		</div>
		                			<span class="title">Andrea D'ge</span>
		                			<p>
			                			<span class="comment-txt">
			                				Went again to Spaghetti Kitchen, and again had a really good <br> time-our food was freshly prepared in front of our eyes everything
			                			</span>
			                		</p>
									<div class="review-information">
										<span>Spagetty Kitchen</span>
										<ul>
											<li class="red-star"><i class="fa fa-star"></i></li>
											<li class="red-star"><i class="fa fa-star"></i></li>
											<li class="red-star"><i class="fa fa-star"></i></li>
											<li class="red-star"><i class="fa fa-star"></i></li>
											<li class="gray-star"><i class="fa fa-star"></i></li>
										</ul>
										
										<small><span>1340</span>reviews</small>
									</div>
					
									<ul class="review-places">
										<li><a href="#"><i class="fa fa-tags"></i>Restourants in Sofia</a></li>
										<li><a href="#"><i class="fa fa-tags"></i>Bar &amp; Dinner</a></li>
									</ul>
		                		</div>
							</div>
						</li>
						<!-- SLIDE  -->
					</ul>
					<div class="tp-bannertimer"></div>
				</div>
			</div>
		</div>
	</div><!-- slider_wrapper -->
</div>