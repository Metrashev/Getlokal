<?php
use_helper('Date','Pagination');
include_partial('global/commonSlider');
$params = array('company' => $company, 'adminuser' => $adminuser, 'companies' => $companies, 'is_getlokal_admin' => $is_getlokal_admin);
$is_with_order = $company->getActivePPPService(true);
$culture = $sf_user->getCulture();
$today =  strtotime(date("m.d.y"));
?>

<div class="container set-over-slider">
    <div class="row"> 
        <div class="container">
            <div class="row">
                <?php include_partial('topMenu', $params); ?> 
            </div>
        </div>            
    </div>    

    <div class="col-sm-4">
        <div class="section-categories">
            <?php include_partial('rightMenu', $params); ?>             
        </div>
    </div>
    <div class="col-sm-8">
        <div class="content-default">
            <form action="<?php echo url_for('userSettings/communication') ?>" method="post" class="default-form clearfix">
                <div class="row">
                    <div class="default-container default-form-wrapper col-sm-12">

                        <div class="col-sm-12">
                            <?php include_partial('tabsMenu', $params); ?>     
                        </div>

                        <h2 class="form-title"><?php echo __('Offers', null, 'offer')?></h2>

                        <div id="pictures_container">
                            <?php $picture_count = $pager->getNbResults(); ?>
                            <?php if($pager->getNbResults() == 0): ?>
                              <?php if ($sf_request->getParameter('drafts')): ?>
                                <p><?php echo __('There are no offer drafts', null, 'offer')?></p>
                              <?php else: ?>
                                <p><?php echo __('There are no offers', null, 'offer')?></p>
                              <?php endif ?>
                            <?php endif;?>

                            <?php if ($pager->getNbResults() > 0) { ?>
                                <div class="wrapper-tabs-event-details">
                                    <div class="tab-photo-event-details">


										<div class="settings_content">
										
										  <?php if($pager->getNbResults() == 0): ?>
										    <?php if ($sf_request->getParameter('drafts')): ?>
										      <p><?php echo __('There are no offer drafts', null, 'offer')?></p>
										    <?php else: ?>
										      <p><?php echo __('There are no offers', null, 'offer')?></p>
										    <?php endif ?>
										  <?php endif;?>
										  <?php foreach($pager->getResults() as $company_offer): ?>
										    <div class="offer_set_listing">
										      <?php $ad_service=  $company_offer->getActiveAdService() ?>
										
										      <div class="offer_set_listing_buttons right">
										
										      <?php if($ad_service):?>
										        <?php if ($company_offer->getIsDraft()): ?>
										          <?php echo link_to(__('publish', null, 'offer'),
										            'companySettings/offerPublish?id=' . $company_offer->getId(),
										            array('class' => 'button_pink')); ?>
										        <?php endif ?>
										
										        <?php
										          echo link_to(
										            __('preview', null, 'offer'),
										            'offer/show?id=' . $company_offer->getId() . '&preview=1',
										            array(
										              'target' => '_blank',
										              'class' => 'button_pink',
										            )
										          );
										        ?>
										
										        <?php if ($company_offer->canActivate()):?>
										          <?php //Check if it's ok to edit
										          //$login->getDateTimeObject ( 'expires_at' )->format ( 'U' ) < time () ?>
										          <?php echo link_to(__('activate',null,'offer'), 'companySettings/activateOffer?slug='.$company_offer->getCompany()->getSlug().'&id='. $company_offer->getId(), array('class'=>'button_green')); ?>
										        <?php elseif ($ad_service->getStatus()=='paid' && (!$company_offer->getActiveFrom() or !$company_offer->getActiveTo()) ):?>
										          <?php //Check if it's ok to edit?>
										          <?php echo link_to( __('Select dates for your offer',null,'company'),'offer/edit?active=1&id='. $company_offer->getId(), array('class'=>'button_green'))?>
										        <?php endif;?>
										
										        <?php if ($company_offer->getIsActive() && !$company_offer->getIsDraft()):?>
										          <?php echo link_to( __('deactivate',null,'offer'),'offer/deactivate?id='. $company_offer->getId(), array('class'=>'button_pink'))?>
										        <?php endif;?>
										
										        <?php endif;?>
										         <?php $offerEndDate = strtotime('+29 days', strtotime($company_offer->getActiveFrom())); ?>
										          <?php if ($today < $offerEndDate || $company_offer->getAdServiceStatus() == 'registered'):?>
										            <?php echo link_to( __('edit',null,'company'),'offer/edit?id='. $company_offer->getId(), array('class'=>'button_green'))?>
										         <?php endif;?>
										        <?php if($company_offer->canDelete()):?>
										          <?php echo link_to( __('delete',null,'company'),'offer/delete?id='. $company_offer->getId(), array('class'=>'button_pink'))?>
										        <?php endif;?>
										      </div>
										
										      <h3><?php echo link_to($company_offer->getDisplayTitle(),'offer/show?id='.$company_offer->getId());?></h3>
										      <div class="offer_date_info">
										        <div class="left">
										          <p><?php echo __('Offer Active From', null, 'form')?></p>
										          <p>
										            <b><?php echo format_date($company_offer->getActiveFrom(), 'dd MMM yyyy',$culture);?></b>
										            <?php echo __("to",null,"offer"); ?>
										            <b><?php echo format_date($company_offer->getActiveTo(), 'dd MMM yyyy',$culture);?></b>
										          </p>
										        </div>
										        <div class="left">
										          <p><?php echo __('Voucher Valid From', null, 'form')?></p>
										          <p>
										            <b><?php echo format_date($company_offer->getValidFrom(), 'dd MMM yyyy',$culture);?></b>
										            <?php echo __("to", null, "offer") ?>
										            <b><?php echo format_date($company_offer->getValidTo(), 'dd MMM yyyy',$culture);?></b>
										          </p>
										        </div>
										        <div class="clear"></div>
										      </div>
										
										      <p><?php echo __('Maximum number of vouchers to be issued', null, 'form')?>: <b><?php echo $company_offer->getMaxVouchers() ?></b></p>
										      <p><?php echo __('Maximum number of vouchers to be issued per user', null, 'form')?>: <b><?php echo $company_offer->getMaxPerUser() ?></b></p>
										      <p><?php echo __('Offer Code', null, 'offer')?>: <b><?php echo $company_offer->getCode() ?></b></p>
										      <p class="bigger"><?php echo __('Vouchers issued', null, 'offer')?>: <b><?php echo format_number_choice('[0]No vouchers have been issued yet for this offer.|[1]1 voucher has been issued for this offer.|(1,+Inf]%count% vouchers have been issued for this offer.', array('%count%' => $company_offer->getCountVoucherCodes()),$company_offer->getCountVoucherCodes(),'form'); ?></b></p>
										
										      <?php $ordered_vouchers = $company_offer->getVouchersPerOffer(false,false,5);?>
										      <?php if (count($ordered_vouchers) > 0):?>
										        <ul>
										
										          <?php foreach ($ordered_vouchers as $ordered_voucher):?>
										            <li><?php echo __('Voucher Code', null, 'offer')?>: <b><?php echo $ordered_voucher->getCode();?></b> -
										            <?php echo __('Name', null, 'form')?>: <b><?php echo $ordered_voucher->getUserProfile();?></b>
										            <?php echo __('issued on', null, 'offer')?>: <?php echo format_date($ordered_voucher->getCreatedAt(), 'dd MMM yyyy',$culture);?>
										              </li>
										            <?php endforeach;?>
										        </ul>
										        <?php echo link_to(__('Export to Excel', null, 'offer'), 'companySettings/companyVouchers?slug='.$company->getSlug().'&id='.$company_offer->getId(), array('class'=>'button_green right'))?>
										        <div class="clear"></div>
										      <?php endif;?>
										    </div>
										  <?php endforeach; ?>
										  <?php echo pager_navigation($pager, $sf_request->getUri()); ?>
										  <div class="clear"></div>
										
										  <?php $product_available = ($company->getActiveDealServiceAvailable(true) or $company->getRegisteredDealService(true));?>
										  <?php if ($product_available):?>
										    <?php echo link_to( __('Create an Offer', null, 'offer'), 'offer/new?slug='.$company->getSlug(), array('class'=>'button_pink createDeal'));?>
										  <?php endif;?>
										</div>


                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                        <!-- Form End -->
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
