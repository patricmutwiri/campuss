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
?>

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
if ($this->config['offline'] == '1') {
    $this->jsjobsmessages->getSystemOfflineMsg($this->config);
} else { ?>
    <div id="jsjobs-main-wrapper">
        <span class="jsjobs-main-page-title"><?php echo JText::_('Purchase History'); ?></span>
    <?php
    if ($this->mypurchasehistory_allowed == VALIDATE) { // employer 
        if (!empty($this->packages)) {
            ?>
                <div class="jsjobs-purchasehistory-main">
                <?php
                if (isset($this->packages)) {
                    foreach ($this->packages as $package) {
                        ?>
                        <span class="jsjobs-title-wrap">
                          <span class="jsjobs-title-wrap-purchase">
                            <a class="anchor" href="index.php?option=com_jsjobs&c=jobseekerpackages&view=jobseekerpackages&layout=package_buynow&jslayfor=detail&gd=<?php echo $package->id; ?>&Itemid=<?php echo $this->Itemid; ?>"><?php echo JText::_($package->title); ?></a>
                            </span>
                            <span class="jsjobs-data-price-wrap">
                            <span class="jsjobs-date-wrap">
                            <span class="stats_data_title last-child"><?php echo JText::_('Buy Date'); ?>:</span>
                            <span class="stats_data_value last-child"><?php echo JHtml::_('date', $package->created, $this->config['date_format']); ?></span>
                            </span>
                            <span class="jsjobs-price-wrap">
                                <span class="stats_data_value">
                                    <?php if ($package->paidamount != 0)
                                        echo $package->symbol . $package->paidamount;
                                    else
                                        echo JText::_('Free');
                                    ?>
                                </span>
                            </span>
                            </span>
                        </span>
                        <div class="jsjobs-purchase-listing-wrapper">
                           <div class="jsjobs-listing-datawrap-details">
                                <div class="jsjobs-listing-wrap">
                                    <div class="jsjobs-values-wrap">
                                        <span class="stats_data_title"><?php echo JText::_('Resume Allowed'); ?>:</span>
                                        <span class="stats_data_value">
                                            <?php if ($package->resumeallow == -1)
                                                echo JText::_('Unlimited');
                                            else
                                                echo $package->resumeallow;
                                            ?>
                                        </span>
                                    </div>
                                </div>
                                <div class="jsjobs-listing-wrap">
                                    <div class="jsjobs-values-wrap">
                                        <span class="stats_data_title"><?php echo JText::_('cover letters Allowed'); ?>:</span>
                                        <span class="stats_data_value">
                                            <?php if ($package->coverlettersallow == -1)
                                                echo JText::_('Unlimited');
                                            else
                                                echo $package->coverlettersallow;
                                            ?>
                                        </span>
                                    </div>
                                </div>
                                <div class="jsjobs-listing-wrap">
                                    <div class="jsjobs-values-wrap bordernone">
                                        <span class="stats_data_title"><?php echo JText::_('Payment'); ?>:</span>
                                        <span class="stats_data_value">
                                            <?php if ($package->transactionverified == 1)
                                               $imgscr  = JURI::root().'components/com_jsjobs/images/publish-icon.png' ;
                                               else
                                            $imgscr  = JURI::root().'components/com_jsjobs/images/reject-s.png' ;
                                        ?> 
                                            <img src="<?php echo $imgscr ;?>">
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="jsjobs-expire-days">
                                <span class="stats_data_title"><?php echo JText::_('Expire In Days'); ?>:</span>
                                <span class="stats_data_value"><?php echo $package->packageexpireindays; ?></span>
                                    <?php 
                                    $date = strtotime("+".$package->packageexpireindays." days", strtotime($package->created));
                                    $packageexpiredate = date("Y-m-d", $date);
                                    if($packageexpiredate <= date('Y-m-d')){?>
                                        <span class="expired_package"><?php echo JText::_('Expired'); ?></span>
                                    <?php } ?>
                            </div>
                        </div>
                            <?php
                    }
                } ?>
            </div>

        <form action="<?php echo JRoute::_('index.php?option=com_jsjobs&c=purchasehistory&view=purchasehistory&layout=jobseekerpurchasehistory&Itemid=' . $this->Itemid ,false); ?>" method="post">
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
        }else { // no result found in this category 
            $this->jsjobsmessages->getAccessDeniedMsg('Could not find any matching results', 'Could not find any matching results', 0);
        }
    } else { // not allowed job posting
        switch ($this->mypurchasehistory_allowed) {
            case EMPLOYER_NOT_ALLOWED_JOBSEEKER_PRIVATE_AREA:
                $this->jsjobsmessages->getAccessDeniedMsg('Employer not allowed', 'Employer is not allowed in Job Seeker private area', 0);
            break;
            case USER_ROLE_NOT_SELECTED:
                $link = "index.php?option=com_jsjobs&c=common&view=common&layout=new_injsjobs&Itemid=".$this->Itemid;
                $vartext = JText::_('You do not select your role').','.JText::_('Please select your role');
                $this->jsjobsmessages->getUserNotSelectedMsg('You do not select your role',$vartext, $link);
            break;
            case VISITOR_NOT_ALLOWED_JOBSEEKER_PRIVATE_AREA:
                $this->jsjobsmessages->getAccessDeniedMsg('You are not logged in', 'Please login to access private area', 1);
            break;
        }
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
<script type="text/javascript">
    function draw() {  
        var objects = document.getElementsByClassName('expired_package');
        for (var i = 0; i < objects.length; i++){
            var canvas = objects[i];
            if (canvas.getContext){
              var ctx = canvas.getContext('2d');
              ctx.fillStyle = "#4f4f4f";
              ctx.beginPath();
              ctx.moveTo(0,0);
              ctx.lineTo(15,15);
              ctx.lineTo(0,30);
              ctx.fill();
            }
        }
    }
    window.onload = function(){
        draw();
    }    
</script>