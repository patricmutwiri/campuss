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
    <div id="js_main_wrapper">
        <span class="js_controlpanel_section_title"><?php echo JText::_('Resume By Categories') . ' ' . $this->categoryname; ?></span>
    <?php
    if ($this->resumes) {
        if ($this->userrole->rolefor == 1) { // employer
            $fieldsordering = JSModel::getJSModel('fieldsordering')->getFieldsOrderingByFieldFor(3);
            $_field = array();
            foreach($fieldsordering AS $field){
                if($field->showonlisting == 1){
                    $_field[$field->field] = $field->fieldtitle;
                }
            }
            $link = 'index.php?option=com_jsjobs&c=resume&view=resume&layout=resume_bycategory&'.$this->catorsubcat.'=' . $this->resumes[0]->aliasid . '&Itemid=' . $this->Itemid;
            if ($this->sortlinks['sortorder'] == 'ASC')
                $img = JURI::root()."components/com_jsjobs/images/sort0.png";
            else
                $img = JURI::root()."components/com_jsjobs/images/sort1.png";
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
                <div id="jsjobs-main-wrapper">
                <?php
                $isnew = date("Y-m-d H:i:s", strtotime("-" . $this->config['newdays'] . " days"));
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
                                          <?php if (isset($_field['jobtype'])) { ?>
                                            <span class="jsjobs-jobs-types">
                                              <span class="js_job_data_2_value"><?php echo JText::_($resume->jobtypetitle); ?></span>
                                            </span>
                                          <?php } ?>
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
                                                    <span class="js_job_data_2_value"><?php echo JText::_($resume->categorytitle); ?></span>
                                                </span>
                                            <?php } ?>
                                        <span class="jsjobs-main-wrap">
                                            <?php if (isset($_field['salary'])) { ?>
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
                                                 <span class="js_job_data_2_title"><?php echo JText::_($_field['heighestfinisheducation'])?> : </span>
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
                $querystring = '&'.$this->catorsubcat.'=' . $this->resumes[0]->aliasid . '&Itemid=' . $this->Itemid;
                ?>
                <form action="<?php echo JRoute::_('index.php?option=com_jsjobs&c=resume&view=resume&layout=resume_bycategory' . $querystring ,false); ?>" method="post">
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
                    <?php /*  if ($this->config['resume_rss'] == 1) { ?>
                        <div id="rss">
                            <a href="index.php?option=com_jsjobs&c=rss&view=rss&layout=rssresumes&format=rss" target="_blank"><img width="24" height="24" src="<?php echo JURI::root();?>components/com_jsjobs/images/rss.png" text="Resume RSS" alt="Resume RSS" /></a>
                        </div>
                    <?php }  */ ?>
                </form>	
                <?php
            } else { // not allowed job posting 
                $this->jsjobsmessages->getAccessDeniedMsg('You are not allowed', 'You are not allowed to view this page', 0);
            }
        } else { // no result found in this category 
            $this->jsjobsmessages->getAccessDeniedMsg('Could not find any matching results', 'Could not find any matching results', 0);
        }
        ?>	
        <script language="javascript">
            //showsavesearch(0); 
        </script>
                </div>
        <?php
    }//ol
    ?>
</div> 
    <script type="text/javascript" language="javascript">
        function setLayoutSize() {
            var totalwidth = document.getElementById("rl_maindiv").offsetWidth;
            var per_width = (totalwidth * 0.23) - 10;
            var totalimagesdiv = document.getElementsByName("rl_imagediv").length;
            for (var i = 0; i < totalimagesdiv; i++) {
                document.getElementsByName("rl_imagediv")[i].style.minWidth = per_width + "px";
                document.getElementsByName("rl_imagediv")[i].style.width = per_width + "px";
            }
            var totalimages = document.getElementsByName("rl_image").length;
            for (var i = 0; i < totalimages; i++) {
                //document.getElementsByName("rl_image")[i].style.minWidth = per_width+"px";
                document.getElementsByName("rl_image")[i].style.width = per_width + "px";
                document.getElementsByName("rl_image")[i].style.maxWidth = per_width + "px";
            }
        }
        setLayoutSize();
    </script>
