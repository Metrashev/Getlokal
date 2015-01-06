<li class="premium-places-event-details">
						<?php echo link_to(image_tag($company->getThumb(2), 'alt=' . $company->getCompanyTitle()), $company->getUri(ESC_RAW) );?>
						<a href="#"><h5><?=$company->getCompanyTitle()?></h5></a>
						<div class="stars-holder big">                  
                            <ul>
                                <li class="gray-star"><i class="fa fa-star"></i></li>
                                <li class="gray-star"><i class="fa fa-star"></i></li>
                                <li class="gray-star"><i class="fa fa-star"></i></li>
                                <li class="gray-star"><i class="fa fa-star"></i></li>
                                <li class="gray-star"><i class="fa fa-star"></i></li>
                                
                            </ul>
                            <div class="top-list">
                                <div class="hiding-holder" style="width: <?=$company->getRating()?>%;">
                                    <ul class="spans-holder">
                                        <li class="red-star"><i class="fa fa-star"></i></li>
                                        <li class="red-star"><i class="fa fa-star"></i></li>
                                        <li class="red-star"><i class="fa fa-star"></i></li>
                                        <li class="red-star"><i class="fa fa-star"></i></li>
                                        <li class="red-star"><i class="fa fa-star"></i></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <p class="events-details-review-number"><?php echo format_number_choice('[0]<span>0</span> reviews|[1]<span>1</span> review|(1,+Inf]<span>%count%</span> reviews', array('%count%' => $company->getNumberOfReviews()), $company->getNumberOfReviews(), 'company'); ?></p>
					</li>