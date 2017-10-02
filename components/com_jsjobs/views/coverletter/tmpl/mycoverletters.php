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
<script language=Javascript>
    function confirmdeletecoverletter() {
        return confirm("<?php echo JText::_('Are you sure to delete the cover letter').'!'; ?>");
    }
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
if ($this->config['offline'] == '1') {
    $this->jsjobsmessages->getSystemOfflineMsg($this->config);
} else {
    if ($this->mycoverletter_allowed == VALIDATE) {
    ?>
        <div id="jsjobs-main-wrapper"> 
            <span class="jsjobs-main-page-title"><span class="jsjobs-title-coverletter"><?php echo JText::_('My Cover Letter');?></span><a class="jsjobs-add-cover-btn" href="index.php?option=com_jsjobs&c=coverletter&view=coverletter&layout=formcoverletter&Itemid=<?php echo $this->Itemid; ?>"><img  src="<?php echo JURI::root();?>components/com_jsjobs/images/add-icon.png"><?php echo JText::_('Add Cover Letter');?></a></span>
    <?php
        if ($this->coverletters) {
            ?>
                 <form action="index.php" method="post" name="adminForm">
                 <?php
                    jimport('joomla.filter.output');
                    foreach ($this->coverletters as $letter) {
                        $link = JFilterOutput::ampReplace('index.php?option=' . $this->option . '&task=edit&cid[]=' . $letter->id);
                        ?>
                        <div class="jsjobs-listing-main-wrapper">
                            <div class="jsjobs-listing-area">
                                <span class="jsjobs-coverletter-title"><?php echo htmlspecialchars($letter->title); ?></span>
                                <div class="jsjobs-coverletter-button-area" >
                                    <span class="jsjobs-coverletter-created"><span><?php echo JText::_('Created'); ?>&nbsp;:</span><?php echo JHtml::_('date', $letter->created, $this->config['date_format']); ?></span>
                                    <div class="jsjobs-icon">
                                        <div class="jsjobs-icon-btn">
                                            <a href="index.php?option=com_jsjobs&c=coverletter&view=coverletter&layout=formcoverletter&cl=<?php echo $letter->aliasid; ?>&Itemid=<?php echo $this->Itemid; ?>"  title="<?php echo JText::_('Edit'); ?>">
                                                <img src="<?php echo JURI::root();?>components/com_jsjobs/images/edit.png" />
                                            </a>
                                            <a href="index.php?option=com_jsjobs&c=coverletter&view=coverletter&layout=view_coverletter&nav=8&cl=<?php echo $letter->aliasid; ?>&Itemid=<?php echo $this->Itemid; ?>" title="<?php echo JText::_('View'); ?>">
                                                <img src="<?php echo JURI::root();?>components/com_jsjobs/images/view.png" />
                                            </a>
                                            <a href="index.php?option=com_jsjobs&task=coverletter.deletecoverletter&cl=<?php echo $letter->aliasid; ?>&Itemid=<?php echo $this->Itemid; ?>" onclick=" return confirmdeletecoverletter();" title="<?php echo JText::_('Delete'); ?>">
                                                <img src="<?php echo JURI::root();?>components/com_jsjobs/images/force-delete.png" />
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                 <?php
                    }
                    ?>      
                    <input type="hidden" name="option" value="<?php echo $this->option; ?>" />
                    <input type="hidden" name="task" value="deletecoverletter" />
                    <input type="hidden" name="coverletter" value="deletecoverletter" />
                    <input type="hidden" id="id" name="id" value="" />
                    <input type="hidden" name="boxchecked" value="0" />  
                    <?php echo JHTML::_( 'form.token' ); ?>       
                 </form>
            <form action="<?php echo JRoute::_('index.php?option=com_jsjobs&c=coverletter&view=coverletter&layout=mycoverletters&Itemid=' . $this->Itemid ,false); ?>" method="post">
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
        <?php } else { // no result found in this category
                $this->jsjobsmessages->getAccessDeniedMsg('Could not find any matching results', 'Could not find any matching results', 0);
            }
        ?>
        </div>
        <?php
    } else {
        switch ($this->mycoverletter_allowed) {
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
    }
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