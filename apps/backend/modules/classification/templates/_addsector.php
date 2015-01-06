<?php use_helper('jQuery'); ?>
<?php echo $form['sectors'][$num]['sector_id']->render()?>
<?php $next =$num+1;?>
<?php if ($next < 5 ):?>
<div class="classifierButtons" id="classifierButtons<?php echo  $next;?>">
				          	 <?php  echo  jq_link_to_remote('<span>Add</span>', array(
                                  'update' => 'classifierButtons'.$next,
                                  'url'    => 'classification/addSector?id='.$form->getObject()->getId().'&num='.($next),
                                        'onclick'=>'return true'
                                        ));?>  
                      
                    </div> 
                    <?php endif;?>