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
$link = 'index.php?option=com_jsjobs&c=jobapply&view=jobapply&layout=myappliedjobs&Itemid=' . $this->Itemid;
?>
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
    if ($this->myappliedjobs_allowed == VALIDATE) {
        if ($this->application) {
            if ($this->sortlinks['sortorder'] == 'ASC')
                $img = JURI::root()."components/com_jsjobs/images/sort0.png";
            else
                $img = JURI::root()."components/com_jsjobs/images/sort1.png";

    $fieldsordering = JSModel::getJSModel('fieldsordering')->getFieldsOrderingByFieldFor(2);
    $_field = array();
    foreach($fieldsordering AS $field){
        if($field->showonlisting == 1){
            $_field[$field->field] = $field->fieldtitle;
        }

    }
?>

            <div id="jsjobs-main-wrapper">
                <span class="jsjobs-main-page-title"><?php echo JText::_('My Applied Jobs'); ?></span>
                <div id="sortbylinks" class="w20">
                  <ul>
                    <?php if (isset($_field['jobtitle'])) { ?>
                        <li class="jsjobs-sorting-bar"><a class="<?php if ($this->sortlinks['sorton'] == 'title') echo 'selected' ?>" href="<?php echo $link ?>&sortby=<?php echo $this->sortlinks['title']; ?>"><?php if ($this->sortlinks['sorton'] == 'title') { ?> <img src="<?php echo $img ?>"> <?php } ?><?php echo JText::_('Title'); ?></a></li>
                    <?php
                    }
                    if (isset($_field['jobtype'])) {
                        ?>
                        <li class="jsjobs-sorting-bar"><a class="<?php if ($this->sortlinks['sorton'] == 'jobtype') echo 'selected' ?>" href="<?php echo $link ?>&sortby=<?php echo $this->sortlinks['jobtype']; ?>"><?php if ($this->sortlinks['sorton'] == 'jobtype') { ?> <img src="<?php echo $img ?>"> <?php } ?><?php echo JText::_('Job Type'); ?></a></li>
                    <?php
                    }
                    /*
                    if (isset($this->fieldsordering['jobstatus']) && $this->fieldsordering['jobstatus'] == 1) {
                        ?>
                        <li class="jsjobs-sorting-bar"><a class="<?php if ($this->sortlinks['sorton'] == 'jobstatus') echo 'selected' ?>" href="<?php echo $link ?>&sortby=<?php echo $this->sortlinks['jobstatus']; ?>"><?php if ($this->sortlinks['sorton'] == 'jobstatus') { ?> <img src="<?php echo $img ?>"> <?php } ?><?php echo JText::_('Job Status'); ?></a></li>
                    <?php
                    }
                    */
                    if (isset($_field['company'])) {
                        ?>
                        <li class="jsjobs-sorting-bar"><a class="<?php if ($this->sortlinks['sorton'] == 'company') echo 'selected' ?>" href="<?php echo $link ?>&sortby=<?php echo $this->sortlinks['company']; ?>"><?php if ($this->sortlinks['sorton'] == 'company') { ?> <img src="<?php echo $img ?>"> <?php } ?><?php echo JText::_('Company'); ?></a></li>
                    <?php
                    }
                    if (isset($_field['jobsalaryrange'])) {
                        ?>
                        <li class="jsjobs-sorting-bar"><a class="<?php if ($this->sortlinks['sorton'] == 'salaryrange') echo 'selected' ?>" href="<?php echo $link ?>&sortby=<?php echo $this->sortlinks['salaryrange']; ?>"><?php if ($this->sortlinks['sorton'] == 'salaryrange') { ?> <img src="<?php echo $img ?>"> <?php } ?><?php echo JText::_('Salary Range'); ?></a></li>
                    <?php } ?>
                    <li class="jsjobs-sorting-bar"><a class="<?php if ($this->sortlinks['sorton'] == 'created') echo 'selected' ?>" href="<?php echo $link ?>&sortby=<?php echo $this->sortlinks['created']; ?>"><?php if ($this->sortlinks['sorton'] == 'created') { ?> <img src="<?php echo $img ?>"> <?php } ?><?php echo JText::_('Posted'); ?></a></li>
                    </ul>
                </div>
                <?php
                $days = $this->config['newdays'];
                $isnew = date("Y-m-d H:i:s", strtotime("-$days days"));
                if (isset($this->application)) {
                    foreach ($this->application as $job) {
                        $companyaliasid = JSModel::getJSModel('common')->removeSpecialCharacter($job->companyaliasid);
                        $link_comp_information = 'index.php?option=com_jsjobs&c=company&view=company&layout=view_company&nav=34&cd=' . $companyaliasid  . '&cat=' . $job->jobcategory . '&Itemid=' . $this->Itemid;
                        $comma = "";
                        ?>
                        <div class="jsjobs-main-wrapper-listappliedjobs">
                            <div class="jsjobs-main-wrapper-appliedjobslist">
                                <div class="jsjobs-image-area">
                                    <?php if(isset($_field['company'])){ ?>
                                        <a href="<?php echo $link_comp_information;?>">
                                            <?php
                                            if (!empty($job->companylogo)) {
                                                if ($this->isjobsharing) {
                                                    $imgsrc = $job->companylogo;
                                                } else {
                                                    $imgsrc = JURI::root().$this->config['data_directory'] . '/data/employer/comp_' . $job->companyid . '/logo/' . $job->companylogo;
                                                }
                                            } else {
                                                $imgsrc = JURI::root().'components/com_jsjobs/images/Users.png';
                                            }
                                            ?>
                                            <img src="<?php echo $imgsrc; ?>" />
                                        </a>
                                    <?php } ?>
                                </div>
                                <div class="jsjobs-data-area">
                                    <div class="jsjobs-data-1">
                                        <?php if (isset($_field['jobtitle'])) { ?>
                                            <span class="jsjobs-title">
                                                <?php 
                                                $jobaliasid = $this->getJSModel('common')->removeSpecialCharacter($job->jobaliasid);
                                                $link = 'index.php?option=com_jsjobs&c=job&view=job&layout=view_job&nav=16&bd=' . $jobaliasid . '&Itemid=' . $this->Itemid; 
                                                ?>
                                                <a href="<?php echo $link; ?>" class=''><?php echo htmlspecialchars($job->title); ?></a>
                                            </span>

                                        <?php } ?>
                                        <span class="jsjobs-posted jsjobstooltip" title="<?php echo JText::_('Applied date'); ?>">
                                        <?php 
                                            echo JHtml::_('date', $job->apply_date, $this->config['date_format']); 
                                        ?>
                                        </span>
                                        <?php 
                                        if(isset($_field['jobtype'])){  ?>
                                                <span class="jsjobs-jobstypes">
                                                    <div class='js_job_data_2_wrapper'>
                                                        <span class="js_job_data_2_value"><?php echo JText::_($job->jobtypetitle); ?> </span>
                                                    </div>
                                                </span>
                                        <?php
                                        }
                                        ?>
                                    </div>

                                    <div class="jsjobs-data-2"> <?php
                                        if(isset($_field['company'])){
                                            echo "<div class='jsjobs-data-2-wrapper'>";
                                                if ($this->config['labelinlisting'] == '1') {
                                                    echo "<span class=\"jsjobs-data-2-title\">" . JText::_($_field['company']) .": ". "</span>";
                                                }
                                            ?>
                                                <span class="jsjobs-data-2-value">
                                                    <a class="jl_company_a" href="<?php echo $link_comp_information ?>"><?php echo htmlspecialchars($job->companyname); ?></a>
                                                </span>
                                            </div>
                                        <?php
                                        }
                                        if(isset($_field['jobsalaryrange'])){
                                            if ($job->rangestart) {
                                                $salary = $this->getJSModel('common')->getSalaryRangeView($job->symbol,$job->rangestart,$job->rangeend,$job->salaytype,$this->config['currency_align']);
                                                echo "<div class='jsjobs-data-2-wrapper'>";
                                                if ($this->config['labelinlisting'] == '1') {
                                                    echo "<span class=\"jsjobs-data-2-title\">" . JText::_($_field['jobsalaryrange']) .": ". " </span>";
                                                }
                                                echo "<span class=\"jsjobs-data-2-value\">" . $salary . "</span></div>";
                                            }
                                        }
                                        if(isset($_field['jobcategory'])){
                                            echo "<div class='jsjobs-data-2-wrapper'>";
                                            if ($this->config['labelinlisting'] == '1') {
                                                echo "<span class=\"jsjobs-data-2-title\">" . JText::_($_field['jobcategory']) .": ". " </span>";
                                            }
                                            echo "<span class=\"jsjobs-data-2-value\">" . htmlspecialchars($job->cat_title) . "</span></div>";
                                        }   
                                        $customfields = getCustomFieldClass()->userFieldsData( 2 , 1);
                                        foreach ($customfields as $field) {
                                            echo  getCustomFieldClass()->showCustomFields($field, 3 ,$job , $this->config['labelinlisting']);
                                        }

                                        ?>
                                    </div>
                                </div>
                            </div> 
                    <div class="jsjobs-main-wrapper-appliedjobslist-btn">
                        <span class="jsjobs-main-wrapper-btn">
                            <span class="jsjobs-location">
                            <span ><img src="<?php echo JURI::root();?>components/com_jsjobs/images/location.png"></span>
                                <?php
                                if(isset($_field['city'])){
                                    echo "<span class=\"js_job_data_location_title\">" . "&nbsp;</span>"; ?>
                                        <span class="js_job_data_location_value"><?php echo $job->location; ?></span>
                                    <?php
                                } ?>
                           </span>
                           <?php 
                           $resumealiasid = $this->getJSModel('common')->removeSpecialCharacter($job->resumealiasid);
                           $link_viewresume = 'index.php?option=com_jsjobs&c=resume&view=resume&layout=view_resume&nav=7&rd=' . $resumealiasid . '&Itemid=' . $this->Itemid; 
                           ?>
                           <span class="jsjobs-resume-btn"> <a href="javascript:void(0)" onclick="hideShowResumeInfo('<?php echo $job->id;?>');" ><img src="<?php echo JURI::root();?>components/com_jsjobs/images/resumeinfo.png"><?php echo JText::_('Applied Info');?></a></span>
                                <?php 
                                if(isset($_field['noofjobs'])){
                                    if (isset($this->fieldsordering['noofjobs']) && $this->fieldsordering['noofjobs'] == 1) {
                                    ?>
                                    <span class="jsjobs-noofjobs">
                                        <span class="jsjobs-noofjob-value">
                                            <canvas id="jsjobs-nofjobs-canvas" class="canvas_color_bg" width="20" height="20"></canvas>
                                            <span class="jsjsobs-jobsno">
                                        <?php
                                            if ($job->noofjobs != 0) {
                                                echo htmlspecialchars($job->noofjobs) . " " . JText::_('Jobs');
                                            }
                                        ?>
                                            </span>
                                        </span>
                                    </span>
                                    <?php
                                    }
                                }   ?>
                        </span>     
                    </div>
                    <div class="jsjobs-data-title-cover info_<?php echo $job->id;?>">
                        <span class="jsjobs-cover-letter-data">
                            <span class="jsjobs-cover-letter-title"><?php echo JText::_("Cover Letter");?>:&nbsp;</span>
                            <span class="jsjobs-cover-letter-value"><a href="index.php?option=com_jsjobs&c=coverletter&view=coverletter&layout=view_coverletter&cl=<?php echo $job->coverletterid; ?>&Itemid=<?php echo $this->Itemid; ?>"><?php echo $job->coverlettertitle;?></a></span>
                        </span>
                        <span class="jsjobs-resume-data">
                            <span class="jsjobs-resume-title"><?php echo JText::_("Resume Title");?>:&nbsp;</span>
                            <?php $resumealiasid = JSModel::getJSModel('common')->removeSpecialCharacter($job->resumealiasid); ?>
                            <span class="jsjobs-resume-value"><a href="index.php?option=com_jsjobs&c=resume&view=resume&layout=view_resume&rd=<?php echo $resumealiasid; ?>&nav=1&Itemid=<?php echo $this->Itemid; ?>"><?php echo $job->applicationtitle;?></a></span>
                        </span>
                    </div>
                    </div>
                <?php
                }
            }else { // no result found in this category 
                $this->jsjobsmessages->getAccessDeniedMsg('Could not find any matching results', 'Could not find any matching results', 0);
                }
            ?>
            </div>
            <form action="<?php echo JRoute::_('index.php?option=com_jsjobs&c=jobapply&view=jobapply&layout=myappliedjobs&Itemid=' . $this->Itemid ,false); ?>" method="post">
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
        switch ($this->myappliedjobs_allowed) {
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
<?php
$document = JFactory::getDocument();
$document->addScript('components/com_jsjobs/js/canvas_script.js');
?>

<script type="text/javascript">
    function hideShowResumeInfo (jobid) {
        jQuery('.info_'+jobid).toggle();
    }
</script>