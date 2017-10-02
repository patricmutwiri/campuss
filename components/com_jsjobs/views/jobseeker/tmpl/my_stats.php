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
$document = JFactory::getDocument();
if (JVERSION < 3) {
    JHtml::_('behavior.mootools');
    $document->addScript('components/com_jsjobs/js/jquery.js');
} else {
    JHtml::_('behavior.framework');
    JHtml::_('jquery.framework');
}


$document->addScript('components/com_jsjobs/js/responsivetable.js');

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
  <div id="jsjobs-main-wrapper">
      <span class="jsjobs-main-page-title"><?php echo JText::_('Stats'); ?></span>
  <?php
    if ($this->mystats_allowed == VALIDATE) {
        $isodd = 1;
        $print = 1;
        if (isset($this->package) && $this->package == false)
            $print = 0;
        ?>
            <?php
                if ($this->ispackagerequired != 1) {
                    $message = "<strong>" . JText::_('Package Not Required') . "</strong>";
                    ?>
                    <div id="stats-package-message">
                        <img class="package-massage-img" src="<?php echo JURI::root();?>components/com_jsjobs/images/icon-massage-stats.png">  <?php echo $message; ?>
                    </div>

                    <?php
                }
            ?>            
            <span class="jsjobs-stats-title"><?php echo JText::_('My Stats'); ?></span>
            <div class="jsjobs-listing-stats-wrapper">
                <div class="jsjobs-icon-wrap">
                    <img class="jsjobs-img" src="<?php echo JURI::root();?>components/com_jsjobs/images/statsicon/resume.png">
                    <span class="stats-data-value"><?php echo $this->totalresume; ?></span>
                    <span class="stats-data-title"><?php echo JText::_('Resumes'); ?></span>
                </div>
                <div class="jsjobs-icon-wrap">
                     <img class="jsjobs-img" src="<?php echo JURI::root();?>components/com_jsjobs/images/statsicon/cover-letter.png">
                     <span class="stats-coverletterdata-value"><?php echo $this->totalcoverletters; ?></span>
                     <span class="stats-data-title"><?php echo JText::_('Cover Letters'); ?></span>
                </div>
            </div>
            <div class="jsjobs-listing-stats-wrapper">
            <div class="jsjobs_rs_heading"><?php echo JText::_('Stats');?> </div>
                  <table id="js-table">
                     <thead>
                         <tr>
                             <th>
                                <?php echo JText::_('Title');?> 
                             </th>
                             <th class="center">
                                 <?php echo JText::_('Allow');?>
                             </th>
                             <th class="center">
                                 <?php echo JText::_('Available');?>
                             </th>
                         </tr>
                     </thead>
                     <tbody>
                          <tr class="bodercolor1_rs">
                              <td class="color3 bodercolor1"><?php echo JText::_('Resumes');?></td>
                              <td class="center color">
                                 <?php
                                  if ($this->ispackagerequired != 1) {
                                  echo JText::_('Unlimited');
                                  } elseif ($this->resumeallow == -1) {
                                  echo JText::_('Unlimited');
                                  } else
                                  echo $this->resumeallow;
                                 ?>
                              </td>
                              <td class="center color2 ">
                                  <?php
                                   if ($this->ispackagerequired != 1) {
                                     echo JText::_('Unlimited');
                                     } elseif ($this->resumeallow == -1) {
                                  echo JText::_('Unlimited');
                                     } else {
                                     $available_resume = $this->resumeallow - $this->totalresume;
                                  echo $available_resume;
                                   }
                                  ?>
                              </td>
                          </tr>
                          <tr class="bodercolor4_rs">
                              <td class="color3 bodercolor4">
                                  <?php echo JText::_('Cover Letters');?>
                              </td>
                              <td class="center color">
                                  <?php
                                  if ($this->ispackagerequired != 1) {
                                  echo JText::_('Unlimited');
                                  } elseif ($this->coverlettersallow == -1) {
                                  echo JText::_('Unlimited');
                                  } else
                                  echo $this->coverlettersallow;
                                  ?>
                              </td>
                              <td class="center color2">
                                  <?php
                                   if ($this->ispackagerequired != 1) {
                                   echo JText::_('Unlimited');
                                   } elseif ($this->coverlettersallow == -1) {
                                   echo JText::_('Unlimited');
                                   } else {
                                   $available_coverletters = $this->coverlettersallow - $this->totalcoverletters;
                                   echo $available_coverletters;
                                   }
                                  ?>
                              </td>
                          </tr>
                     </tbody>
                  </table>
            </div>        
        <?php
    } else {
        switch ($this->mystats_allowed) {
            case EMPLOYER_NOT_ALLOWED_JOBSEEKER_PRIVATE_AREA:
                $this->jsjobsmessages->getAccessDeniedMsg('Employer not allowed', 'Employer is not allowed in job seeker private area', 0);
                break;
            case USER_ROLE_NOT_SELECTED:
                    $link = "index.php?option=com_jsjobs&c=common&view=common&layout=new_injsjobs&Itemid=".$this->Itemid;
                    $vartext = JText::_('You do not select your role').','.JText::_('Please select your role');
                    $this->jsjobsmessages->getUserNotSelectedMsg('You do not select your role', $vartext, $link);
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
<!-- <div id="jsjobsfooter" class="hidden">
    <table width="100%" style="table-layout:fixed;">
        <tr><td height="15"></td></tr>
        <tr>
            <td style="vertical-align:top;" align="center">
                <a class="img" target="_blank" href="http://www.joomsky.com"><img src="http://www.joomsky.com/logo/jsjobscrlogo.png"></a>
                <br>
                Copyright &copy; 2008 - <?php echo  date('Y') ?> ,
                <span id="themeanchor"> <a class="anchor"target="_blank" href="http://www.burujsolutions.com">Buruj Solutions</a></span>
            </td>
        </tr>
    </table>
</div> -->
</div>