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
$link = 'index.php?option=com_jsjobs&c=job&view=job&layout=myjobs&Itemid=' . $this->Itemid;
?>
<script language="Javascript">
    function confirmdeletejob() {
        return confirm("<?php echo JText::_('Are you sure to delete the job'); ?>");
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
} else { ?>
    <div id="jsjobs-main-wrapper">
        <span class="jsjobs-main-page-title"><span class="jsjobs-title-componet"><?php echo JText::_('My Jobs'); ?></span>
        <span class="jsjobs-add-resume-btn"><a class="jsjobs-resume-a" href="index.php?option=com_jsjobs&c=job&view=job&layout=formjob&Itemid=<?php echo $this->Itemid; ?>"><img  src="<?php echo JURI::root();?>components/com_jsjobs/images/add-icon.png"><span class="jsjobs-add-resume-btn"><?php echo JText::_('Add New Job');?></span></a></span>
        </span> 
<?php

    $fieldsordering = JSModel::getJSModel('fieldsordering')->getFieldsOrderingByFieldFor(2);
    $_field = array();
    foreach($fieldsordering AS $field){
        if($field->showonlisting == 1){
            $_field[$field->field] = $field->fieldtitle;
        }

    }

    if ($this->myjobs_allowed == VALIDATE) {
        if ($this->jobs) {
            if ($this->sortlinks['sortorder'] == 'ASC')
                $img = JURI::root()."components/com_jsjobs/images/sort0.png";
            else
                $img = JURI::root()."components/com_jsjobs/images/sort1.png";            
            ?>
                <form action="index.php" method="post" name="adminForm">
                    <div id="sortbylinks">
                        <ul>
                            <?php if (isset($_field['jobtitle'])) { ?>
                            <li class="jsjobs-sorting-bar-myjob"><a href="<?php echo $link ?>&sortby=<?php echo $this->sortlinks['title']; ?>" class="<?php if ($this->sortlinks['sorton'] == 'title') echo 'selected' ?>"><?php if ($this->sortlinks['sorton'] == 'title') { ?> <img src="<?php echo $img ?>"> <?php } ?><?php echo JText::_('Title'); ?></a></li>
                            <?php } ?>
                            <?php if (isset($_field['jobcategory'])) { ?>
                            <li class="jsjobs-sorting-bar-myjob"><a href="<?php echo $link ?>&sortby=<?php echo $this->sortlinks['category']; ?>" class="<?php if ($this->sortlinks['sorton'] == 'category') echo 'selected' ?>"><?php if ($this->sortlinks['sorton'] == 'category') { ?> <img src="<?php echo $img ?>"> <?php } ?><?php echo JText::_('Category'); ?></a></li>
                            <?php } ?>
                            <?php if (isset($_field['jobtype'])) { ?>
                            <li class="jsjobs-sorting-bar-myjob"><a href="<?php echo $link ?>&sortby=<?php echo $this->sortlinks['jobtype']; ?>" class="<?php if ($this->sortlinks['sorton'] == 'jobtype') echo 'selected' ?>"><?php if ($this->sortlinks['sorton'] == 'jobtype') { ?> <img src="<?php echo $img ?>"> <?php } ?><?php echo JText::_('Job Type'); ?></a></li>
                            <?php } ?>
                            <?php //if (isset($_field['jobstatus'])) { ?>
                            <li class="jsjobs-sorting-bar-myjob"><a href="<?php echo $link ?>&sortby=<?php echo $this->sortlinks['jobstatus']; ?>" class="<?php if ($this->sortlinks['sorton'] == 'jobstatus') echo 'selected' ?>"><?php if ($this->sortlinks['sorton'] == 'jobstatus') { ?> <img src="<?php echo $img ?>"> <?php } ?><?php echo JText::_('Job Status'); ?></a></li>
                            <?php //}  ?>
                            <?php if (isset($_field['company'])) { ?>
                            <li class="jsjobs-sorting-bar-myjob"><a href="<?php echo $link ?>&sortby=<?php echo $this->sortlinks['company']; ?>" class="<?php if ($this->sortlinks['sorton'] == 'company') echo 'selected' ?>"><?php if ($this->sortlinks['sorton'] == 'company') { ?> <img src="<?php echo $img ?>"> <?php } ?><?php echo JText::_('Company'); ?></a></li>
                            <?php } ?>
                            <?php if (isset($_field['jobsalaryrange'])) { ?>
                            <li class="jsjobs-sorting-bar-myjob"><a href="<?php echo $link ?>&sortby=<?php echo $this->sortlinks['salaryrange']; ?>" class="<?php if ($this->sortlinks['sorton'] == 'salaryrange') echo 'selected' ?>"><?php if ($this->sortlinks['sorton'] == 'salaryrange') { ?> <img src="<?php echo $img ?>"> <?php } ?><?php echo JText::_('Salary Range'); ?></a></li>
                            <?php } ?>
                            <li class="jsjobs-sorting-bar-myjob"><a href="<?php echo $link ?>&sortby=<?php echo $this->sortlinks['created']; ?>" class="<?php if ($this->sortlinks['sorton'] == 'created') echo 'selected' ?>"><?php if ($this->sortlinks['sorton'] == 'created') { ?> <img src="<?php echo $img ?>"> <?php } ?><?php echo JText::_('Created'); ?></a></li>
                        </ul>
                    </div>
                        <?php
                            $days = $this->config['newdays'];
                            $isnew = date("Y-m-d H:i:s", strtotime("-$days days"));
                            if (isset($this->jobs)) {
                                foreach ($this->jobs as $job) {
                            ?>
                            <div class="jsjobs-folderinfo">
                                <div class="jsjobs-main-myjobslist">
                                    <span class="jsjobs-image-area"> 
                                        <?php
                                            $companyaliasid = ($this->isjobsharing != "") ? $job->scompanyaliasid : $job->companyaliasid;
                                            $jobcategory = ($this->isjobsharing != "") ? $job->sjobcategory : $job->jobcategory;
                                            $companyaliasid = JSModel::getJSModel('common')->removeSpecialCharacter($companyaliasid);
                                            $link = 'index.php?option=com_jsjobs&c=company&view=company&layout=view_company&nav=41&cd=' . $companyaliasid . '&cat=' . $jobcategory . '&Itemid=' . $this->Itemid;
                                        ?>                                    
                                        <?php if(isset($_field['company'])){ ?>
                                        <a class="jsjobs-image-area-achor" href="<?php echo $link; ?>">
                                            <?php
                                            if (!empty($job->companylogo)) {
                                                if ($this->isjobsharing) {
                                                    $imgsrc = $job->companylogo;
                                                } else {
                                                    $imgsrc = JURI::root().$this->config['data_directory'] . '/data/employer/comp_' . $job->companyid . '/logo/' . $job->companylogo;
                                                }
                                            } else {
                                                    $imgsrc = JURI::root().'components/com_jsjobs/images/blank_logo.png';
                                                }
                                            ?>
                                            <img class="jsjobs-img-company" src="<?php echo $imgsrc; ?>" />  
                                        </a>
                                        <?php } ?>
                                    </span>
                                    <div class="jsjobs-content-wrap">
                                        <div class="jsjobs-data-1">
                                            <div class="jsjobs-data-1-title">
                                                <?php 
                                                    if (isset($_field['jobtitle'])) { 
                                                            $jobaliasid = ($this->isjobsharing != "") ? $job->sjobaliasid : $job->jobaliasid;
                                                            $jobaliasid = $this->getJSModel('common')->removeSpecialCharacter($jobaliasid);                                                                                                                        
                                                            $link = 'index.php?option=com_jsjobs&c=job&view=job&layout=view_job&nav=19&bd=' . $jobaliasid . '&Itemid=' . $this->Itemid;
                                                        ?>
                                                        <a id="jsjobs-a-job-tile" href="<?php echo $link; ?>">
                                                        <span class='job-title'><?php echo $job->title; ?></span>
                                                        </a>
                                                        <?php
                                                        if ($job->created > $isnew) {
                                                            echo '<span class=" new jsjobs_new_tag">'.JText::_('New').'</span>';
                                                        }
                                                    } 
                                                ?>
                                            </div>
                                            <div class="jsjobs-data-1-right">
                                                <span class="jsjobs-posted">
                                                    <?php echo  JHtml::_('date', $job->created, $this->config['date_format']); ?>
                                                </span>
                                                <?php if(isset($_field['jobtype'])){ ?>
                                                    <span class="jsjobs-jobs-types">
                                                        <?php echo JText::_($job->jobtypetitle); ?>
                                                    </span>
                                                <?php } ?>
                                            </div>
                                        </div>
                                        <div class="jsjobs-data-area">
                                            <div class="jsjobs-data-2">
                                                <?php if(isset($_field['company'])){
                                                        echo "<div class='jsjobs-data-2-wrapper  col-sm-6 col-md-6'>";
                                                        if ($this->config['labelinlisting'] == '1') {
                                                            echo "<span class=\"js_job_data_2_title\">" . JText::_($_field['company']) . ": </span>";
                                                        }
                                                        $companyaliasid = ($this->isjobsharing != "") ? $job->scompanyaliasid : $job->companyaliasid;
                                                        $jobcategory = ($this->isjobsharing != "") ? $job->sjobcategory : $job->jobcategory;
                                                        $companyaliasid = JSModel::getJSModel('common')->removeSpecialCharacter($companyaliasid);
                                                        $link = 'index.php?option=com_jsjobs&c=company&view=company&layout=view_company&nav=41&cd=' . $companyaliasid . '&cat=' . $jobcategory . '&Itemid=' . $this->Itemid;
                                                       
                                                    ?>
                                                     <span class="js_job_data_2_value"><a href="<?php echo $link ?>"><?php echo $job->companyname; ?></a></span>
                                                        <?php
                                                    echo '</div>';
                                                }

                                                if(isset($_field['jobsalaryrange'])){
                                                    if ($job->rangestart) {
                                                        $salary = $this->getJSModel('common')->getSalaryRangeView($job->symbol,$job->rangestart,$job->rangeend,JText::_($job->salarytypetitle),$this->config['currency_align']);
                                                        echo "<div class='jsjobs-data-3-wrapper col-sm-6 col-md-6'>";
                                                        if ($this->config['labelinlisting'] == '1') {
                                                            echo "<span class=\"js_job_data_2_title\">" . JText::_($_field['jobsalaryrange']) . ": </span>";
                                                        }
                                                        echo '<span class="js_job_data_2_value">' . $salary . "</span>";
                                                        echo '</div>';
                                                    } 
                                                }
                                                ?>                                                
                                            </div>
                                            <div class="jsjobs-data-2">
                                                <?php
                                                if(isset($_field['jobcategory'])){
                                                    echo "<div class='jsjobs-data-2-wrapper js_forcat col-sm-4 col-md-4'>";
                                                    if ($this->config['labelinlisting'] == '1') {
                                                        echo "<span class=\"js_job_data_2_title\">" . JText::_($_field['jobcategory']) . " : </span>";
                                                    }
                                                    echo '<span class="js_job_data_2_value">' . JText::_($job->cat_title) . "</span>";
                                                    echo '</div>';
                                                }

                                                $curdate = date('Y-m-d');
                                                $startpublishing = date('Y-m-d', strtotime($job->startpublishing));
                                                $stoppublishing = date('Y-m-d', strtotime($job->stoppublishing));
                                                ?>
                                                <div class="jsjobs-data-3-myjob-no js_noof_jobs col-sm-4 col-md-4">
                                                   <?php  if(isset($_field['noofjobs'])){ ?> 
                                                    <span class="jsjobs-noof-jobs">
                                                    <?php
                                                        echo "<span class='js_job_myjob_numbers'>";
                                                        if ($job->noofjobs != 0) {
                                                            echo $job->noofjobs . " " . JText::_('Jobs');
                                                        } else {
                                                            echo '1' . " " . JText::_('Jobs');
                                                        }
                                                        echo "</span>";
                                                    ?>
                                                    </span>
                                                    <?php } ?>
                                               </div> 
                                               <?php 
                                                    $customfields = getCustomFieldClass()->userFieldsData( 2 , 1);
                                                    foreach ($customfields as $field) {
                                                        echo  getCustomFieldClass()->showCustomFields($field, 12 ,$job , $this->config['labelinlisting']);
                                                    }
                                                ?>

                                            </div>
                                        </div>   
                                    </div>  
                                                      
                                </div>
                                <div class="jsjobs-main-myjobslist-btn">
                                        <div class="jsjobs-data-myjob-left-area"> 
                                            <?php if(isset($_field['city'])){ ?>
                                                <span><img src="<?php echo JURI::root();?>components/com_jsjobs/images/location.png" /></span>
                                                <?php
                                                    if (isset($job->city) AND ! empty($job->city)) {
                                                        echo "<span class=\"js_job_data_location_value\">" . $job->city . "</span>";
                                                    }
                                                }
                                            ?>
                                        </div>
                                        <div class="jsjobs-data-myjob-right-area">
                                            <?php
                                        if ($job->status == 0) { ?>
                                            <font id="jsjobs-status-btn"><canvas class="canvas_color_bg" width="20" height="20"></canvas><?php echo JText::_('Waiting for approval');?></font>
                                        <?php
                                        } elseif ($job->status == -1) { ?>
                                            <font id="jsjobs-status-btn-rejected"><canvas class="canvas_color_bg" width="20" height="20"></canvas><?php echo JText::_('Rejected');?></font>
                                        <?php
                                        } elseif ($job->status == 1) {
                                                $show_links = false;
                                                if ($this->isjobsharing){
                                                    if ($job->serverstatus == "ok"){
                                                        $show_links = true;
                                                    }else{
                                                        $show_links = false;
                                                    }
                                                }else{
                                                    $show_links = true;
                                                }
                                                if ($show_links) {
                                                   
                                                    $link = 'index.php?option=com_jsjobs&c=job&view=job&layout=formjob&bd=' . $job->jobaliasid . '&Itemid=' . $this->Itemid;
                                                        ?>
                                                        <a href="<?php echo $link ?>" class="company_icon" title="<?php echo JText::_('Edit'); ?>"><img src="<?php echo JURI::root();?>components/com_jsjobs/images/edit.png" /></a>
                                                        <?php
                                                    }
                                                    $jobaliasid = ($this->isjobsharing != "") ? $job->sjobaliasid : $job->jobaliasid;
                                                    $jobaliasid = $this->getJSModel('common')->removeSpecialCharacter($jobaliasid);
                                                    $link = 'index.php?option=com_jsjobs&c=job&view=job&layout=view_job&nav=19&bd=' . $jobaliasid . '&Itemid=' . $this->Itemid;
                                                    ?>
                                                    <a href="<?php echo $link ?>" class="company_icon" title="<?php echo JText::_('View'); ?>"><img src="<?php echo JURI::root();?>components/com_jsjobs/images/view.png" /></a>
                                                    <?php
                                                        if (isset($job->visitor) && $job->visitor == 'visitor')
                                                            $link_delete = 'index.php?option=com_jsjobs&task=job.deletejob&email=' . $job->contactemail . '&bd=' . $job->jobaliasid . '&Itemid=' . $this->Itemid;
                                                        else
                                                            $link_delete = 'index.php?option=com_jsjobs&task=job.deletejob&bd=' . $job->jobaliasid . '&Itemid=' . $this->Itemid;
                                                        if (isset($this->uid) && $this->uid != 0) { ?>
                                                            <a href="<?php echo $link_delete ?>" class="company_icon" onclick="return confirmdeletejob();"  title="<?php echo JText::_('Delete'); ?>"><img src="<?php echo JURI::root();?>components/com_jsjobs/images/force-delete.png" /></a>
                                                            <?php $jobid = ($this->isjobsharing != "") ? $job->locajobid : $job->id; ?>
                                                            <?php $jobaliasid = ($this->isjobsharing != "") ? $job->sjobaliasid : $job->jobaliasid; ?>      
                                                        <?php } ?>
                                                        <?php $jobaliasid = ($this->isjobsharing != "") ? $job->sjobaliasid : $job->jobaliasid; ?>      
                                                        <?php $link = 'index.php?option=com_jsjobs&c=jobapply&view=jobapply&layout=job_appliedapplications&bd=' . $jobaliasid . '&Itemid=' . $this->Itemid; ?>
                                                            <a class="applied-resume-button-no" href="<?php echo $link ?>"><?php echo JText::_('Resume');
                                                                echo ' (' . $job->totalapply . ')';
                                                        ?></a>
                                            <?php 
                                            } ?>
                                        </div>
                                    </div>  
                    </div> 
                        <?php
                                }
                            }
                        ?>
                    <input type="hidden" name="option" value="<?php echo $this->option; ?>" />
                    <input type="hidden" name="task" value="deletejob" />
                    <input type="hidden" name="c" value="job" />
                    <input type="hidden" id="id" name="id" value="" />
                    <input type="hidden" name="boxchecked" value="0" />
                </form>
            <form action="<?php echo JRoute::_('index.php?option=com_jsjobs&c=job&view=job&layout=myjobs&Itemid=' . $this->Itemid ,false); ?>" method="post">
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
        } else { // no result found in this category 
            $this->jsjobsmessages->getAccessDeniedMsg('Could not find any matching results', 'Could not find any matching results', 0);
        }
    } else {
        switch ($this->myjobs_allowed) {
            case JOBSEEKER_NOT_ALLOWED_EMPLOYER_PRIVATE_AREA:
                $this->jsjobsmessages->getAccessDeniedMsg('Job seeker not allowed', 'Job seeker is not allowed in employer private area', 0);
            break;
            case USER_ROLE_NOT_SELECTED:
                $link = "index.php?option=com_jsjobs&c=common&view=common&layout=new_injsjobs&Itemid=".$this->Itemid;
                $vartext = JText::_('You do not select your role').','.JText::_('Please select your role');
                $this->jsjobsmessages->getUserNotSelectedMsg('You do not select your role',$vartext, $link);
                break;
            case VISITOR_NOT_ALLOWED_TO_EDIT_THEIR_JOBS:
                $this->jsjobsmessages->getAccessDeniedMsg('You are not logged in', 'Visitor is not allowed in employer private area', 1);
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
<script type="text/javascript" src="<?php echo JURI::root(); ?>components/com_jsjobs/js/tinybox.js"></script>
<link media="screen" rel="stylesheet" href="<?php echo JURI::root(); ?>components/com_jsjobs/js/style.css" />
<script type="text/javascript" language="Javascript">
    function copyjob(val) {
        jQuery.post("<?php echo JURI::root(); ?>index.php?option=com_jsjobs&task=job.getcopyjob", {val: val}, function (data) {
            if (data == true) {
                TINY.box.show({html: "<?php echo JText::_('Job has been copied'); ?>", animate: true, boxid: 'frameless', close: true});
            } else {
                TINY.box.show({html: "<?php echo JText::_('Cannot add new job'); ?>", animate: true, boxid: 'frameless', close: true});
            }
            setTimeout(function () {
                window.location.reload();
            }, 3000);
        });
    }
</script>
<?php
$document = JFactory::getDocument();
$document->addScript('components/com_jsjobs/js/canvas_script.js');
?>