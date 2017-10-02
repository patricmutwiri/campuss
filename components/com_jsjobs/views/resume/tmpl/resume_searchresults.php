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
$link = 'index.php?option=com_jsjobs&c=resume&view=resume&layout=resume_searchresults&Itemid=' . $this->Itemid;
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
    ?>
    <div id="jsjobs-main-wrapper">
        <span class="jsjobs-main-page-title"><?php echo JText::_('Resume Search Result'); ?></span>
<?php
    if ($this->result != false) {
        if ($this->resumes) {
            if ($this->userrole->rolefor == 1) { // employer
                if ($this->sortlinks['sortorder'] == 'ASC')
                    $img = JURI::root()."components/com_jsjobs/images/sort0.png";
                else
                    $img = JURI::root()."components/com_jsjobs/images/sort1.png";
                    if ($this->result != false)
                        if (isset($this->searchresumeconfig['search_resume_showsave']) AND ( $this->searchresumeconfig['search_resume_showsave'] == 1)) {
                            if(isset($this->issearchform) && $this->issearchform == 1){ ?>
                            <div id="savesearch-form">
                                <form action="index.php" method="post" name="adminForm" id="adminForm" >
                                    <div class="jsjobs-label">
                                        <?php echo JText::_('Search Name'); ?>
                                    </div>
                                    <div class="jsjobs-input-field">
                                        <input class="inputbox required" type="text" name="searchname" size="20" maxlength="30"  />
                                    </div>
                                    <div class="jsjobs-button-field">
                                        <input type="submit" id="button" class="button validate" value="<?php echo JText::_('Save'); ?>">
                                    </div>
                                    <input type="hidden" name="option" value="<?php echo $this->option; ?>" />
                                    <input type="hidden" name="searchcriteria" value="<?php echo $this->getJSModel('common')->b64ForEncode(json_encode($this->forsavesearch)); ?>" />
                                    <input type="hidden" name="task" value="saveresumesearch" />
                                    <input type="hidden" name="c" value="resumesearch" />
                                </form>	
                            </div>
                        <?php } 
                        }
                    $fieldsordering = JSModel::getJSModel('fieldsordering')->getFieldsOrderingByFieldFor(3);
                    $_field = array();
                    foreach($fieldsordering AS $field){
                        if($field->showonlisting == 1){
                            $_field[$field->field] = $field->fieldtitle;
                        }
                    }
                    ?>
                    <div id="sortbylinks">
                        <?php if (isset($_field['application_title'])) { ?>
                            <span class="my_resume_sbl_links"><a class="<?php if ($this->sortlinks['sorton'] == 'application_title') echo 'selected'; ?>" href="<?php echo $link ?>&sortby=<?php echo $this->sortlinks['application_title']; ?>"><?php echo JText::_('Title'); ?><?php if ($this->sortlinks['sorton'] == 'application_title') { ?> <img src="<?php echo $img ?>"> <?php } ?></a></span>
                        <?php } ?>
                        <?php if (isset($_field['jobtype'])) { ?>      
                            <span class="my_resume_sbl_links"><a class="<?php if ($this->sortlinks['sorton'] == 'jobtype') echo 'selected'; ?>" href="<?php echo $link ?>&sortby=<?php echo $this->sortlinks['jobtype']; ?>"><?php echo JText::_('Job Type'); ?><?php if ($this->sortlinks['sorton'] == 'jobtype') { ?> <img src="<?php echo $img ?>"> <?php } ?></a></span>
                        <?php } ?>
                        <?php if (isset($_field['salary'])) { ?>
                            <span class="my_resume_sbl_links"><a class="<?php if ($this->sortlinks['sorton'] == 'salaryrange') echo 'selected'; ?>" href="<?php echo $link ?>&sortby=<?php echo $this->sortlinks['salaryrange']; ?>"><?php echo JText::_('Salary Range'); ?><?php if ($this->sortlinks['sorton'] == 'salaryrange') { ?> <img src="<?php echo $img ?>"> <?php } ?></a></span>
                        <?php } ?>
                        <span class="my_resume_sbl_links"><a class="<?php if ($this->sortlinks['sorton'] == 'created') echo 'selected'; ?>" href="<?php echo $link ?>&sortby=<?php echo $this->sortlinks['created']; ?>"><?php echo JText::_('Posted'); ?><?php if ($this->sortlinks['sorton'] == 'created') { ?> <img src="<?php echo $img ?>"> <?php } ?></a></span>
                    </div>

                    <?php
                    foreach ($this->resumes as $resume) {
                        $comma = "";
                        ?>
                        <div class="jsjobs-main-wrapper-resume-searchresults">
                          <div class="jsjobs-resume-searchresults">
                          <div class="jsjobs-resume-search">
                            <?php if (isset($_field['photo'])) { ?>
                                <div class="jsjobs-image-area">
                                  <div class="jsjobs-img-border">
                                    <div class="jsjobs-image-wrapper">
                                        <?php
                                        if ($resume->photo != '') {
                                            $imgsrc = JURI::root().$this->config['data_directory'] . "/data/jobseeker/resume_" . $resume->id . "/photo/" . $resume->photo;
                                        } else {
                                            $imgsrc = JURI::root()."components/com_jsjobs/images/jobseeker.png";
                                        }
                                        ?>
                                        <img class="js_job_image" src="<?php echo $imgsrc; ?>" />
                                    </div>
                                  </div>
                                </div>
                            <?php } ?>
                            <div class="jsjobs-data-area">
                                    <div class='jsjobs-data-2-wrapper-title'>
                                        <span class="jsjobs-name-title">
                                        <?php if (isset($_field['first_name'])) { ?>
                                            <?php echo $resume->first_name; ?>
                                        <?php } ?>
                                        <?php if (isset($_field['last_name'])) { ?>
                                            <?php echo ' ' . $resume->last_name; ?>
                                        <?php } ?>
                                        </span>
                                        <span class="jsjobs-posted">
                                          <?php
                                           echo "<span class='js_job_data_2_created_myresume'>" . JText::_('Created').": ";
                                           echo JHtml::_('date', $resume->created, $this->config['date_format']) . "</span>";
                                         ?>
                                        </span>
                                        <span class="jsjobs-jobs-types">
                                          <?php if (isset($_field['jobtype'])) { ?>
                                            <span class="js_job_data_2_value"><?php echo JText::_($resume->jobtypetitle); ?></span>
                                          <?php } ?>
                                        </span>
                                    </div>
                                    <div class='jsjobs-data-2-wrapper font'>
                                        <?php if (isset($_field['application_title'])) { ?>
                                            <?php echo $resume->application_title; ?>
                                        <?php } ?>
                                    </div>
                                    <div class='jsjobs-data-2-wrapper cat'>
                                        <?php if (isset($_field['job_category'])) { ?>
                                            <span class="jsjobs-main-wrap">
                                                <span class="js_job_data_2_title"><?php echo JText::_($_field['job_category']); ?>: </span>
                                                <span class="js_job_data_2_value"><?php echo JText::_($resume->cat_title); ?></span>
                                            </span>
                                        <?php } ?>
                                        <?php if (isset($_field['salary'])) { ?>
                                            <span class="jsjobs-main-wrap">
                                                <span class="js_job_data_2_title"><?php echo JText::_($_field['salary']); ?> : </span>
                                                <span class="js_job_data_2_value">
                                                    <?php
                                                        $salary = $this->getJSModel('common')->getSalaryRangeView($resume->symbol,$resume->rangestart,$resume->rangeend,JText::_($resume->salarytype),$this->config['currency_align']);
                                                        echo $salary;
                                                    ?>
                                                </span>
                                            </span>
                                        <?php } ?>
                                    </div>
                                    <div class="jsjobs-data-2-wrapper cat">
                                        <?php if (isset($_field['heighestfinisheducation'])) { ?>
                                            <span class="jsjobs-main-wrap">
                                                <span class="js_job_data_2_title"><?php echo JText::_($_field['heighestfinisheducation']); ?> : </span>
                                                <span class="js_job_data_2_value">
                                                    <?php echo $resume->educationtitle; ?>
                                                </span>
                                            </span>
                                        <?php } ?>
                                        <?php if (isset($_field['total_experience'])) { ?>
                                            <span class="jsjobs-main-wrap">
                                                <span class="js_job_data_2_title"><?php echo JText::_($_field['total_experience']); ?>: </span>
                                                <span class="js_job_data_2_value">
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
                                                echo  $customfieldobj->showCustomFields($field, 10 ,$resume);
                                            }

                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                            <div class="jsjobs-data-3-myresume">
                                    <?php
                                    $address = '';
                                    $comma = '';
                                    if ($resume->cityname != '') {
                                        $address = $comma . $resume->cityname;
                                        $comma = " ,";
                                    }
                                    switch ($this->config['defaultaddressdisplaytype']){
                                        case 'csc':
                                            if ($resume->statename != '') {
                                                $address .= $comma . $resume->statename;
                                                $comma = " ,";
                                            }
                                            if ($resume->countryname != '')
                                                $address .= $comma . $resume->countryname;
                                        break;
                                        case 'cs':
                                            if ($resume->statename != '') {
                                                $address .= $comma . $resume->statename;
                                                $comma = " ,";
                                            }
                                        break;
                                        case 'cc':
                                            if ($resume->countryname != '')
                                                $address .= $comma . $resume->countryname;
                                        break;
                                    }
                                    ?> 
                                    <span class="jsjobs-location">
                                        <span><img src="<?php echo JURI::root();?>components/com_jsjobs/images/location.png"></span>
                                        <span class="js_job_data_2_value"><?php echo $address; ?></span>
                                    </span>
                                    <span class="jsjobs-view-resume">
                                        <?php 
                                        $resumealiasid = $this->getJSModel('common')->removeSpecialCharacter($resume->resumealiasid);
                                        $link = 'index.php?option=com_jsjobs&c=resume&view=resume&layout=view_resume&nav=3&rd=' . $resumealiasid . '&Itemid=' . $this->Itemid; 
                                        ?>
                                        <a class="js_job_data_area_button" href="<?php echo $link ?>"><?php echo JText::_('View Resume'); ?></a>
                                    </span>
                                </div>
                        </div> 
                        <?php
                    }
                    ?>
                <form action="<?php echo JRoute::_('index.php?option=com_jsjobs&c=resume&view=resume&layout=resume_searchresults&Itemid=' . $this->Itemid ,false); ?>" method="post">
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
                    <?php /* if ($this->config['resume_rss'] == 1) { ?>
                        <div id="rss">
                            <a href="index.php?option=com_jsjobs&c=rss&view=rss&layout=rssresumes&format=rss" target="_blank"><img width="24" height="24" src="<?php echo JURI::root();?>components/com_jsjobs/images/rss.png" text="Resume RSS" alt="Resume RSS" /></a>
                        </div>
                    <?php } */ ?>
                </form>	
                <?php
            } else { // not allowed job posting 
                $this->jsjobsmessages->getAccessDeniedMsg('You are not allowed', 'You are not allowed to view this page', 0);
            }
        } else { // no result found in this category 
            $this->jsjobsmessages->getAccessDeniedMsg('Could not find any matching results', 'Could not find any matching results', 0);
        }
    } else { // not result found in this category
        $this->jsjobsmessages->getAccessDeniedMsg('Could not find any matching results', 'Could not find any matching results', 0);
    }
    ?>

    </div>

    <script language="javascript">
    //showsavesearch(0); 
    </script>
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