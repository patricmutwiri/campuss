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
} else {
    ?>
    <?php
    $printform = 1;
    if (isset($this->userrole))
        if (isset($this->userrole->rolefor) && $this->userrole->rolefor == 1) { // employer
            if ($this->config['employerview_js_controlpanel'] == 1)
                $printform = true;
            else {
                echo JText::_('You are not allowed to view this page');
                $printform = 0;
            }
        }
    if ($printform == 1) {
        if (isset($this->package)) {
            ?>
            <div id="jsjobs-main-wrapper">
                <span class="jsjobs-main-page-title"><?php echo JText::_('Package Details'); ?></span>
                <div class="jsjobs-package-data">
                <span class="js-job-title">
                  <span class="js-job-package-title">
                    <?php
                    echo $this->package->title;
                    $curdate = date('Y-m-d H:i:s');
                    if (($this->package->discountstartdate <= $curdate) && ($this->package->discountenddate >= $curdate)) {
                        if ($this->package->discountmessage)
                            echo $this->package->discountmessage;
                    }
                    ?>
                    </span>
                    <span class="js-job-package-price">
                    <span class="stats_data_value">
                        <?php
                        if ($this->package->price != 0) {
                            $curdate = date('Y-m-d H:i:s');
                            if (($this->package->discountstartdate <= $curdate) && ($this->package->discountenddate >= $curdate)) {
                                if ($this->package->discounttype == 2) {
                                    $discountamount = ($this->package->price * $this->package->discount) / 100;
                                    $discountamount = $this->package->price - $discountamount;
                                    echo $this->package->symbol . $discountamount . ' [ ' . $this->package->discount . '% ' . JText::_('Discount') . ' ]';
                                } else {
                                    $discountamount = $this->package->price - $this->package->discount;
                                    echo $this->package->symbol . $discountamount . ' [ ' . JText::_('Discount') . ' : ' . $this->package->symbol . $this->package->discount . ' ]';
                                }
                            } else
                                echo $this->package->symbol . $this->package->price;
                        }else {
                            echo JText::_('Free');
                        }
                        ?>
                    </span> 
                    </span>
                </span>
                <div class="js_listing_wrapper">
                    <span class="stats_data_title"><?php echo JText::_('Resume Allowed'); ?></span>
                    <span class="stats_data_value"><?php if ($this->package->resumeallow == -1)
                echo JText::_('Unlimited');
            else
                echo $this->package->resumeallow;
            ?></span>
                    <span class="stats_data_title"><?php echo JText::_('Cover Letters Allowed'); ?></span>
                    <span class="stats_data_value"><?php if ($this->package->coverlettersallow == -1)
                echo JText::_('Unlimited');
            else
                echo $this->package->coverlettersallow;
            ?></span>
                    <span class="stats_data_title"><?php echo JText::_('Job Search'); ?></span>
                    <span class="stats_data_value"><?php if ($this->package->jobsearch == 1)
                echo JText::_('Yes');
            else
                echo JText::_('No');
            ?></span>
                    <span class="stats_data_title"><?php echo JText::_('Save Job Search'); ?></span>
                    <span class="stats_data_value"><?php if ($this->package->savejobsearch == 1)
                echo JText::_('Yes');
            else
                echo JText::_('No');
            ?></span>
                    <span class="stats_data_title"><?php echo JText::_('Apply Jobs'); ?></span>
                    <span class="stats_data_value"><?php if ($this->package->applyjobs == -1)
                echo JText::_('Unlimited');
            else
                echo $this->package->applyjobs;
                    ?></span>
                    <span class="stats_data_title"><?php echo JText::_('Expire In Days'); ?></span>
                    <span class="stats_data_value"><?php echo $this->package->packageexpireindays; ?></span>
                    <span class="jsjobs-description">       
                    <span class="stats_data_descrptn-title"><?php echo JText::_('Description'); ?></span>
                    <span class="stats_data_descrptn-value"><?php echo $this->package->description; ?></span>
                    </span> 
                    <div class="js_job_apply_button">
                     <?php $link = 'index.php?option=com_jsjobs&c=jobseekerpackages&view=jobseekerpackages&layout=package_buynow&nav=22&gd=' . $this->package->id . '&Itemid=' . $this->Itemid; ?>
                     <a class="js_job_button" href="<?php echo $link ?>" class="pkgLink"><?php echo JText::_('Buy Now'); ?></a>
                    </div>
                </div>
                </div>
            </div>
            <?php
        }
        ?>	
        <?php
    }
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
