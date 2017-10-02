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
    if ($this->mydepartment_allowed == VALIDATE) {
?>
        <div id="jsjobs-main-wrapper">
            <span class="jsjobs-main-page-title"><span class="jsjobs-title-componet"><?php echo JText::_('My Departments'); ?></span>
            <span class="jsjobs-add-resume-btn"><a class="jsjobs-resume-a" href="index.php?option=com_jsjobs&c=department&view=department&layout=formdepartment&Itemid=<?php echo $this->Itemid;?>"><img  src="<?php echo JURI::root();?>components/com_jsjobs/images/add-icon.png"><span class="jsjobs-add-resume-btn">Add New Department</span></a></span>
            </span>
        <?php        
        if ($this->departments) {
            ?>
            <!-- Your Area starts here -->
                <form action="index.php" method="post" name="adminForm">
                    <div class="jsjobs-folderinfo">
                    <?php foreach ($this->departments as $department) { ?>
                        <div class="jsjobs-main-mydepartmentlist">  
                            <div class="jsjob-main-department">
                                <div class="jsjobs-main-department-left">
                                    <span class="jsjobs-coverletter-title">
                                      <span class="jsjobs-title-name"><strong><?php echo $department->name; ?></strong></span>
                                      <span class="jsjobs-coverletter-created"><span class="js_coverletter_created_title"><?php echo JText::_('Created'); ?>:&nbsp;</span><?php echo JHtml::_('date', $department->created, $this->config['date_format']); ?></span>
                                    </span>
                                    <span class="jsjobs-category-status">
                                    <?php 
                                        $companyaliasid = JSModel::getJSModel('common')->removeSpecialCharacter($department->companyaliasid);
                                        $link_viewcomp = 'index.php?option=com_jsjobs&c=company&view=company&layout=view_company&nav=31&cd=' . $companyaliasid . '&Itemid=' . $this->Itemid;
                                    ?>
                                        <span class="jsjobs-listing-title-child"><span class="jsjobs-title-status"><?php echo JText::_('Company'); ?>:&nbsp;</span><span class="jsjobs-company"><a href="<?php echo $link_viewcomp;?>"> <?php echo $department->companyname; ?></a></span></span>
                                        <span class="jsjobs-listing-title-child">
                                            <span class="jsjobs-title-status"><?php echo JText::_('Status'); ?>:&nbsp;</span>
                                            <span class="dept-status">
                                                <strong>
                                                    <?php
                                                        if ($department->status == 1){
                                                            echo '<span class="approve">' . JText::_('Approved') . '</span>';
                                                        }elseif ($department->status == 0) {
                                                            echo '<span class="pending">' . JText::_('Pending') . '</span>';
                                                        } elseif ($department->status == -1){
                                                            echo '<span class="reject">' . JText::_('Rejected') . '</span>';
                                                        }
                                                    ?>
                                                </strong>
                                            </span>
                                       </span>
                                   </span>
                                </div>
                                <?php if ($department->status == 0) { ?>
                                            <font id="jsjobs-status-btn" class="margin-top"><canvas class="canvas_color_bg" width="20" height="20"></canvas><?php echo JText::_('Waiting for approval');?></font>
                                        <?php
                                        } elseif ($department->status == -1) { ?>
                                            <font id="jsjobs-status-btn-rejected" class="margin-top"><canvas class="canvas_color_bg" width="20" height="20"></canvas><?php echo JText::_('Rejected');?></font>
                                        <?php
                                        } elseif ($department->status == 1) { ?>
                                 <div class="jsjobs-main-department-right">
                                    <div class="jsjobs-coverletter-button-area" >
                                        <a class="js_listing_icon" href="index.php?option=com_jsjobs&c=department&view=department&layout=formdepartment&pd=<?php echo $department->aliasid; ?>&Itemid=<?php echo $this->Itemid; ?>" title="<?php echo JText::_('Edit'); ?>">
                                            <img src="<?php echo JURI::root();?>components/com_jsjobs/images/edit.png" />
                                        </a>
                                        <a class="js_listing_icon" href="index.php?option=com_jsjobs&c=department&view=department&layout=view_department&pd=<?php echo $department->aliasid; ?>&Itemid=<?php echo $this->Itemid; ?>" title="<?php echo JText::_('View'); ?>" >
                                            <img src="<?php echo JURI::root();?>components/com_jsjobs/images/view.png" />
                                        </a>
                                        <a class="js_listing_icon" href="index.php?option=com_jsjobs&task=department.deletedepartment&pd=<?php echo $department->aliasid; ?>&Itemid=<?php echo $this->Itemid; ?>" title="<?php echo JText::_('Delete'); ?>">
                                            <img src="<?php echo JURI::root();?>components/com_jsjobs/images/force-delete.png" />
                                        </a>
                                    </div> 
                                 </div>
                        <?php } ?>  
                            </div>
                        </div>
                <?php
            }
            ?>      
                    </div>            
                    <input type="hidden" name="option" value="<?php echo $this->option; ?>" />
                    <input type="hidden" name="task" value="deletedepartment" />
                    <input type="hidden" name="department" value="deletedepartment" />
                    <input type="hidden" id="id" name="id" value="" />
                     <?php echo JHTML::_( 'form.token' ); ?>    
                </form>
            <!-- End your area -->
            <form action="<?php echo JRoute::_('index.php?option=com_jsjobs&c=department&view=department&layout=mydepartments&Itemid=' . $this->Itemid ,false); ?>" method="post">
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
            } ?>
        </div>
    <?php
    } else { // not allowed 
        switch ($this->mydepartment_allowed) {
            case JOBSEEKER_NOT_ALLOWED_EMPLOYER_PRIVATE_AREA:
                $this->jsjobsmessages->getAccessDeniedMsg('Job seeker not allowed', 'Job seeker is not allowed in employer private area', 0);
            break;
            case USER_ROLE_NOT_SELECTED:
                $link = "index.php?option=com_jsjobs&c=common&view=common&layout=new_injsjobs&Itemid=".$this->Itemid;
                $vartext = JText::_('You do not select your role').','.JText::_('Please select your role');
                $this->jsjobsmessages->getUserNotSelectedMsg('You do not select your role',$vartext, $link);
            break;
            case VISITOR_NOT_ALLOWED_EMPLOYER_PRIVATE_AREA:
                $this->jsjobsmessages->getAccessDeniedMsg('You are not logged in', 'Please login to access private area', 1);
            break;
        }
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
<?php
$document = JFactory::getDocument();
$document->addScript('components/com_jsjobs/js/canvas_script.js');
?>