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
$link = "index.php?option=com_jsjobs&c=resume&view=resume&layout=myresumes&Itemid=" . $this->Itemid;
$document = JFactory::getDocument();
$document->addScript('components/com_jsjobs/js/canvas_script.js');
?>
<script language=Javascript>
    function confirmdeleteresume() {
        return confirm("<?php echo JText::_('Are you sure to delete the resume').'!'; ?>");
    }
</script>
<div id="js_jobs_main_wrapper">
<div id="js_menu_wrapper">
    <?php
    if (sizeof($this->jobseekerlinks) != 0) {
        foreach ($this->jobseekerlinks as $lnk) {
            ?>                     
            <a class="js_menu_link <?php if ($lnk[2] == 'job') echo 'selected'; ?>" href="<?php echo $lnk[0]; ?>"><?php echo $lnk[1]; ?></a>
            <?php
        }
    }
    if (sizeof($this->employerlinks) != 0) {
        foreach ($this->employerlinks as $lnk) {
            ?>
            <a class="js_menu_link <?php if ($lnk[2] == 'job') echo 'selected'; ?>" href="<?php echo $lnk[0]; ?>"><?php echo $lnk[1]; ?></a>
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
    <?php
    if ($this->myresume_allowed == VALIDATE) { ?>
        <span class="jsjobs-main-page-title"><span class="jsjobs-title-componet"><?php echo JText::_('My Resume'); ?></span>
            <span class="jsjobs-add-resume-btn"><a class="jsjobs-resume-a" href="index.php?option=com_jsjobs&view=resume&layout=formresume&Itemid=<?php echo $this->Itemid; ?>"><img src="<?php echo JURI::root();?>components/com_jsjobs/images/add-icon.png"><span class="jsjobs-add-resume-btn"><?php echo JText::_('Add Resume'); ?></span></a></span>
        </span>
        <?php 

        $fieldsordering = JSModel::getJSModel('fieldsordering')->getFieldsOrderingByFieldFor(3);
        $_field = array();
        foreach($fieldsordering AS $field){
            if($field->showonlisting == 1){
                $_field[$field->field] = $field->fieldtitle;
            }
        }
        if ($this->resumes) {
            if ($this->sortlinks['sortorder'] == 'ASC')
                $img = JURI::root()."components/com_jsjobs/images/sort0.png";
            else
                $img = JURI::root()."components/com_jsjobs/images/sort1.png";
            ?>
                <form action="index.php" method="post" name="adminForm">
                    <div id="sortbylinks">
                      <ul>
                        <?php if (isset($_field['application_title'])) { ?>
                            <li><a class="<?php if ($this->sortlinks['sorton'] == 'application_title') echo 'selected' ?>" href="<?php echo $link; ?>&sortby=<?php echo $this->sortlinks['application_title']; ?>"><?php if ($this->sortlinks['sorton'] == 'application_title') { ?> <img src="<?php echo $img ?>"> <?php } ?><?php echo JText::_('Title'); ?></a></li>
                        <?php } ?>
                        <?php if (isset($_field['jobtype'])) { ?>
                           <li><a class="<?php if ($this->sortlinks['sorton'] == 'jobtype') echo 'selected' ?>" href="<?php echo $link; ?>&sortby=<?php echo $this->sortlinks['jobtype']; ?>"><?php if ($this->sortlinks['sorton'] == 'jobtype') { ?> <img src="<?php echo $img ?>"> <?php } ?><?php echo JText::_('Job Type'); ?></a></li>
                        <?php } ?>
                        <?php if (isset($_field['salary'])) { ?>
                            <li><a class="<?php if ($this->sortlinks['sorton'] == 'salaryrange') echo 'selected' ?>" href="<?php echo $link; ?>&sortby=<?php echo $this->sortlinks['salaryrange']; ?>"><?php if ($this->sortlinks['sorton'] == 'salaryrange') { ?> <img src="<?php echo $img ?>"> <?php } ?><?php echo JText::_('Salary Range'); ?></a></li>
                        <?php } ?>
                        <li><a  class="<?php if ($this->sortlinks['sorton'] == 'created') echo 'selected' ?>" href="<?php echo $link; ?>&sortby=<?php echo $this->sortlinks['created']; ?>"><?php if ($this->sortlinks['sorton'] == 'created') { ?> <img src="<?php echo $img ?>"> <?php } ?><?php echo JText::_('Posted'); ?></a></li>
                        </ul>
                    </div>
                    <?php
                    $isnew = date("Y-m-d H:i:s", strtotime("-" . $this->config['newdays'] . " days"));

                    foreach ($this->resumes as $resume) {
                        $resumealiasid = $this->getJSModel('common')->removeSpecialCharacter($resume->resumealiasid);
                        $link_viewresume = 'index.php?option=com_jsjobs&c=resume&view=resume&layout=view_resume&nav=1&rd=' . $resumealiasid . '&Itemid=' . $this->Itemid; ?>
                        <div class="jsjobs-main-wrapper-listresume">
                            <div class="jsjobs-main-wrapper-resumeslist"> 
                                <div class="jsjobs-main-resumeslist">       
                                    <?php if (isset($_field['photo'])) { ?>
                                        <div class="jsjobs-image-area">
                                            <a  class="logo_a" href="<?php echo $link_viewresume;?>">
                                                <?php
                                                if ($resume->photo != '') {
                                                        $imgsrc = JURI::root().$this->config['data_directory'] . "/data/jobseeker/resume_" . $resume->id . "/photo/" . $resume->photo;
                                                    } else {
                                                        $imgsrc = JURI::root()."components/com_jsjobs/images/Users.png";
                                                    }
                                                ?>
                                                <img class="logo_img" src="<?php echo $imgsrc; ?>" />
                                            </a>
                                        </div>
                                    <?php } ?>
                                    <div class="jsjobs-data-area">
                                        <div class="jsjobs-data-titlename">
                                            <div class="jsjobs-applyname">
                                               <span class="jsjobs-titleresume">
                                                <a  class="jsjobs-anchor_resume" href="<?php echo $link_viewresume;?>">
                                                <?php if (isset($_field['first_name'])) { ?>
                                                    <?php echo htmlspecialchars($resume->first_name); ?>
                                                <?php } ?>
                                                <?php if (isset($_field['last_name'])) { ?>
                                                    <?php echo ' ' . htmlspecialchars($resume->last_name); ?>
                                                <?php } ?>
                                                </a>
                                                </span>
                                                <span class="jsjobs-date-created">
                                                    <?php
                                                    echo  JText::_('Created');?>: 
                                                    <?php echo JHtml::_('date', $resume->created, $this->config['date_format']) ;
                                                    ?>
                                                </span>
                                                <span class="jsjobs-fulltime-btn">
                                                    <?php echo htmlspecialchars(JText::_($resume->jobtypetitle)); ?>
                                                </span>
                                            </div>
                                            <div class="jsjobs-application-title">
                                                <?php if (isset($_field['application_title'])) { ?>
                                                   (<?php echo $resume->application_title; ?>)
                                                <?php } ?>
                                            </div>
                                            <?php if (isset($_field['job_category'])) { ?>
                                                    <span class="jsjobs-categoryjob">
                                                        <span class="jsjobs-titlecategory"><?php echo JText::_($_field['job_category']) . ": "; ?></span>
                                                        <span class="jsjobs-valuecategory"><?php echo JText::_($resume->cat_title); ?></span>
                                                    </span>
                                                <?php } ?>
                                        <?php if (isset($_field['salary'])) { ?>
                                                <span class="jsjobs-salary-range">
                                                 <span class="jsjobs-salary-title"><?php echo JText::_($_field['salary']) . ": "; ?></span>
                                                 <span class="jsjobs-salary-value">
                                                    <?php
                                                        $salary = $this->getJSModel('common')->getSalaryRangeView($resume->symbol,$resume->rangestart,$resume->rangeend,JText::_($resume->salarytype),$this->config['currency_align']);
                                                        echo htmlspecialchars($salary);
                                                        ?>
                                                    </span>
                                                  </span>
                                            <?php } ?>
                                            <?php if (isset($_field['heighestfinisheducation'])) { ?>
                                                <span class="jsjobs-emailaddress">
                                                <span class="jsjobs-emailaddress-color"><?php echo JText::_($_field['heighestfinisheducation']) ?>: </span>
                                                <span class="jsjobs-address">
                                                    <?php echo htmlspecialchars($resume->educationtitle); ?>
                                                </span>
                                                </span>
                                            <?php } ?>
                                             <?php if (isset($_field['total_experience'])) { ?>
                                                    <span class="jsjobs-totexprience">
                                                    <span class="jsjobs-totalexpreience-title"><?php echo JText::_($_field['total_experience']) . ": "; ?></span>
                                                    <span class="jsjobs-totalexpreience-value">
                                                        <?php
                                                        if (empty($resume->exptitle))
                                                            echo $resume->total_experience;
                                                        else
                                                            echo JText::_($resume->exptitle);
                                                        ?>
                                                    </span>
                                            </span>
                                        <?php }
                                            $customfieldobj = getCustomFieldClass();
                                            $customfields = $customfieldobj->userFieldsData( 3 , 1 , 1);
                                            foreach ($customfields as $field) {
                                                echo  $customfieldobj->showCustomFields($field, 9 ,$resume , 1);
                                            }
                                         ?>

                                    </div>
                                </div>
                                <div class="jsjobs-myresume-btn">
                                    <span class="jsjobs-resume-loction">
                                    <span><img src="<?php echo JURI::root();?>components/com_jsjobs/images/location.png"></span>
                                        <?php echo $resume->location; ?>
                                    </span>
                                    <span class="jsjobs-myresumebtn">
                                        <?php
                                        if ($resume->status == 0) { ?>
                                            <font id="jsjobs-status-btn"><canvas class="canvas_color_bg" width="20" height="20"></canvas><?php echo JText::_('Waiting for approval');?></font>
                                        <?php
                                        } elseif ($resume->status == -1) { ?>
                                            <font id="jsjobs-status-btn-rejected"><canvas class="canvas_color_bg" width="20" height="20"></canvas><?php echo JText::_('Rejected');?></font>
                                        <?php
                                        } elseif ($resume->status == 1) {
                                            $link_edit = 'index.php?option=com_jsjobs&c=resume&view=resume&layout=formresume&nav=29&rd=' . $resume->resumealiasid . '&Itemid=' . $this->Itemid;
                                            ?>
                                            <a class="jsjobs-resumes-edit-btn" href="<?php echo $link_edit; ?>" title="<?php echo JText::_('Edit'); ?>"><img  src="<?php echo JURI::root();?>components/com_jsjobs/images/edit.png" /></a>
                                            <a class="jsjobs-resumes-view-btn" href="<?php echo $link_viewresume; ?>" title="<?php echo JText::_('View'); ?>"><img  src="<?php echo JURI::root();?>components/com_jsjobs/images/view.png" /></a>
                                            <?php $link_delete = 'index.php?option=com_jsjobs&task=resume.deleteresume&rd=' . $resume->resumealiasid . '&Itemid=' . $this->Itemid; ?>
                                                <a class="jsjobs-resumes-delete-btn" href="<?php echo $link_delete; ?>" onclick=" return confirmdeleteresume();" class="icon" title="<?php echo JText::_('Delete'); ?>"><img src="<?php echo JURI::root();?>components/com_jsjobs/images/force-delete.png" /></a>
                                        <?php } ?>
                                    </span>
                                </div>
                            </div>
                        </div>
                        </div>
                <?php } ?>
                <input type="hidden" name="option" value="<?php echo $this->option; ?>" />
                <input type="hidden" name="task" value="deleteresume" />
                <input type="hidden" name="c" value="resume" />
                <input type="hidden" id="id" name="id" value="" />
                <input type="hidden" name="boxchecked" value="0" />
            </form>
            <form action="<?php echo JRoute::_('index.php?option=com_jsjobs&c=resume&view=resume&layout=myresumes&Itemid=' . $this->Itemid ,false); ?>" method="post">
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
    } else {
        switch ($this->myresume_allowed) {
            case EMPLOYER_NOT_ALLOWED_JOBSEEKER_PRIVATE_AREA:
                $this->jsjobsmessages->getAccessDeniedMsg('Employer not allowed', 'Employer is not allowed in job seeker private area', 0);
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
 

