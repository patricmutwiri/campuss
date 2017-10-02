<?php

/**
 * @Copyright Copyright (C) 2009-2010 Ahmad Bilal
 * @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
 * Company:     Buruj Solutions
 + Contact:     http://www.burujsolutions.com , info@burujsolutions.com
 * Created on:  Nov 22, 2010
 ^
 + Project:     JS Jobs
 ^ 
 */
 
defined('_JEXEC') or die('Restricted access');
$link = 'index.php?option=com_jsjobs&c=jobseekerpackages&view=jobseekerpackages&layout=packages&Itemid=' . $this->Itemid;
?>
<script type="text/javascript" languge="javascript">
jQuery( document ).ready(function() {
   jQuery("span.jsjobs-package-values").last().css("border-bottom","none");
});
</script>
<div id="js_jobs_main_wrapper">
    <div id="js_menu_wrapper">
        <?php
        if (sizeof($this->jobseekerlinks) != 0) {
            foreach ($this->jobseekerlinks as $lnk) {
                ?>                     
                <a class="js_menu_link <?php if ($lnk[2] == 'coverletter') echo 'selected'; ?>" href="<?php echo $lnk[0]; ?>"><?php echo $lnk[1]; ?></a>
                <?php
            }
        }
        if (sizeof($this->employerlinks) != 0) {
            foreach ($this->employerlinks as $lnk) {
                ?>
                <a class="js_menu_link <?php if ($lnk[2] == 'coverletter') echo 'selected'; ?>" href="<?php echo $lnk[0]; ?>"><?php echo $lnk[1]; ?></a>
                <?php
            }
        }
        ?>
    </div>
<?php
function makesymbolalign($price, $symbol, $align){ if($align == 1) $p = $symbol.$price; elseif($align == 2) $p = $price.$symbol; return $p; }
if ($this->config['offline'] == '1') {
    $this->jsjobsmessages->getSystemOfflineMsg($this->config);
} else {
    $printform = 1;
    $currency_align = $this->config['currency_align'];
    if (isset($this->userrole->rolefor) && $this->userrole->rolefor == 1) { // employer
        if ($this->config['employerview_js_controlpanel'] == 1){
          $printform = 1;
        }else {
            $this->jsjobsmessages->getAccessDeniedMsg('You are not allowed', 'You are not allowed to view this page');
            $printform = 0;
        }
    }
    ?>
    <div id="jsjobs-main-wrapper">
        <span class="jsjobs-main-page-title"><?php echo JText::_('Packages'); ?></span>
    <?php
    if ($printform == 1) {
            if (isset($this->packages) AND (!empty($this->packages))) {
                foreach ($this->packages as $package) {
                  //price and disscount related code
                    $discflag = 0;
                     if ($package->price != 0) {
                        $curdate = date('Y-m-d H:i:s');
                            if (($package->discountstartdate <= $curdate) && ($package->discountenddate >= $curdate)) {
                              if ($package->discounttype == 2) {
                                $discflag = 1;
                                $discountamount = ($package->price * $package->discount) / 100;
                                $price = ($package->price - $discountamount);
                                $price = makesymbolalign($price, $package->symbol, $currency_align);
                              } elseif ($package->discounttype == 1) {
                                $discflag = 1;
                                $discountamount = $package->discount;
                                $price = ($package->price - $discountamount);
                                $price = makesymbolalign($price, $package->symbol, $currency_align);
                              }
                            }else
                              $price = makesymbolalign($package->price, $package->symbol, $currency_align);
                      }else {
                          $price =  JText::_('Free');
                      }
                    ?>
             <div class="jsjobs-package-data">
                    <span class="jsjobs-package-title">
                       <span class="jsjobs-package-name">
                        <?php
                        echo $package->title;
                        if($discflag == 1){?>
                            <strike>
                                <span class="total-amount"><?php echo makesymbolalign($package->price, $package->symbol, $currency_align); ?></span>
                            </strike>
                          <?php } ?>
                        </span>
                        <span class="jsjobs-package-price-forjobseeker">
                          <span class="stats_data_value ">
                              <?php
                                  echo $price;
                              ?>
                          </span>
                        </span>
                    </span>
                    <div class="jsjobs-package-listing-wrapper">
                        <div class="jsjobs-listing-datawrap">
                            <div class="jsjobs-package-data-detail">
                                <span class="jsjobs-package-values">
                                    <span class="stats_data_title"><?php echo JText::_('Resume Allowed'); ?>:</span>
                                    <span class="stats_data_value">
                                        <?php 
                                            if ($package->resumeallow == -1) echo JText::_('Unlimited');
                                            else echo $package->resumeallow;
                                        ?>
                                    </span>
                                </span>
                            </div>
                            <div class="jsjobs-package-data-detail">
                                <span class="jsjobs-package-values">
                                    <span class="stats_data_title"><?php echo JText::_('Job Search'); ?>:</span>
                                    <span class="stats_data_value">
                                        <?php 
                                            if ($package->jobsearch == 1) $imgscr  = JURI::root().'components/com_jsjobs/images/publish-icon.png' ;
                                            else $imgscr  = JURI::root().'components/com_jsjobs/images/reject-s.png' ;
                                        ?> 
                                        <img src="<?php echo $imgscr ;?>">
                                    </span>
                                </span>
                            </div>
                            <div class="jsjobs-package-data-detail">
                                <span class="jsjobs-package-values">
                                    <span class="stats_data_title"><?php echo JText::_('Cover Letters Allowed'); ?>:</span>
                                    <span class="stats_data_value">
                                        <?php 
                                            if ($package->coverlettersallow == -1) echo JText::_('Unlimited');
                                            else echo $package->coverlettersallow;
                                        ?>
                                    </span>
                                </span>
                            </div>
                            <div class="jsjobs-package-data-detail">
                                <span class="jsjobs-package-values">
                                    <span class="stats_data_title"><?php echo JText::_('Save Job Search'); ?>:</span>
                                    <span class="stats_data_value">
                                        <?php 
                                            if ($package->savejobsearch == 1) $imgscr  = JURI::root().'components/com_jsjobs/images/publish-icon.png' ;
                                            else $imgscr  = JURI::root().'components/com_jsjobs/images/reject-s.png' ;
                                        ?> 
                                        <img src="<?php echo $imgscr ;?>">
                                    </span>
                                </span>
                            </div>
                            <div class="jsjobs-package-data-detail">
                                <span class="jsjobs-package-values">
                                    <span class="stats_data_title"><?php echo JText::_('Apply Jobs'); ?>:</span>
                                    <span class="stats_data_value">
                                        <?php 
                                            if ($package->applyjobs == -1) echo JText::_('Unlimited');
                                            else echo $package->applyjobs;
                                        ?>
                                    </span>
                                </span>
                            </div>
                        </div>
                        <div class="jsjobs-apply-button">
                            <div class="jsjobs-package-detail">
                                <span class="jsjobs-buy-btn">
                                    <?php $link = 'index.php?option=com_jsjobs&c=jobseekerpackages&view=jobseekerpackages&layout=package_buynow&nav=21&gd=' . $package->id . '&Itemid=' . $this->Itemid; ?>
                                    <a class="js_job_button" href="<?php echo $link ?>" class="pageLink"><img src="<?php echo JURI::root();?>components/com_jsjobs/images/buy-now.png"> <?php echo JText::_('Buy Now'); ?></a>
                                </span>
                                <span class="jsjobs-view-btn">
                                    <?php $link2 = 'index.php?option=com_jsjobs&c=jobseekerpackages&view=jobseekerpackages&layout=package_buynow&jslayfor=detail&nav=21&gd=' . $package->id . '&Itemid=' . $this->Itemid; ?>
                                    <a class="js_job_button" href="<?php echo $link2;?>" ><?php echo JText::_('Details View'); ?></a>
                                </span>
                                <span class="jsjobs-expiredays">
                                    <span class="stats_data_title"><?php echo JText::_('Expire In Days'); ?>:</span>
                                    <span class="stats_data_value"><?php echo $package->packageexpireindays; ?></span>
                                </span>
                            </div>
                        </div>
                    </div>
                    <?php
                        $curdate = date('Y-m-d H:i:s');
                        if (($package->discountstartdate <= $curdate) && ($package->discountenddate >= $curdate)) {
                            if ($package->discountmessage != '') { ?>
                                <div class="disc-message">
                                    <?php echo $package->discountmessage; ?>
                                </div>
                    <?php 
                            }
                        }
                    ?>
                </div>    
                <?php 
            }
        }else{
          $this->jsjobsmessages->getAccessDeniedMsg('Could not find any matching results.','Could not find any matching results.');
        }
        ?>
        <form action="<?php echo JRoute::_('index.php?option=com_jsjobs&c=jobseekerpackages&view=jobseekerpackages&layout=packages&Itemid=' . $this->Itemid ,false); ?>" method="post">
            <div id="jsjobs_jobs_pagination_wrapper">
                <div class="jsjobs-resultscounter">
                    <?php echo $this->pagination->getResultsCounter(); ?>
                </div>
                <div class="jsjobs-plinks">
                    <?php echo $this->pagination->getPagesLinks(); ?>
                </div>
                <div class="jsjobs-lbox">
                    <?php echo $this->pagination->getLimitBox(); ?>
                </div>
            </div>
        </form> 
    <?php
    } ?>
    </div>
    <?php
}//ol
?>  
<div id="jsjobsfooter">
    <table width="100%" style="table-layout:fixed;">
        <tr><td height="15"></td></tr>
        <tr>
            <td style="vertical-align:top;" align="center">
                <a class="img" target="_blank" href="http://www.joomsky.com"><img src="http://www.joomsky.com/logo/jsjobscrlogo.png"></a>
                <br>
                Copyright &copy; 2008 - <?php echo  date('Y') ?> ,
                <span id="themeanchor"> <a class="anchor"target="_blank" href="http://www.burujsolutions.com">Buruj Solutions </a></span>
            </td>
        </tr>
    </table>
</div>
</div>