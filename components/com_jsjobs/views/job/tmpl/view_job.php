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
global $mainframe;
$document = JFactory::getDocument();
if (JVERSION < 3) {
    JHtml::_('behavior.mootools');
    $document->addScript('components/com_jsjobs/js/jquery.js');
} else {
    JHtml::_('behavior.framework');
    JHtml::_('jquery.framework');

}
$document->addScript('components/com_jsjobs/js/jquery_idTabs.js');
JHTML::_('behavior.modal');
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
    if (isset($this->job)) {
        require_once 'jobapply.php';
        $section_array = array();

        if (
            (isset($this->fieldsordering['heighesteducation']) && $this->fieldsordering['heighesteducation'] == 1) ||
            (isset($this->fieldsordering['experience']) && $this->fieldsordering['experience'] == 1) ||
            (isset($this->fieldsordering['workpermit']) && $this->fieldsordering['workpermit'] == 1) ||
            (isset($this->fieldsordering['requiredtravel']) && $this->fieldsordering['requiredtravel'] == 1)
        )
            $section_array['requirement'] = 1;
        else
            $section_array['requirement'] = 0;

        ?>

    <?php
        $listjobconfig = JSModel::getJSModel('configurations')->getConfigByFor('listjob');
        $islistjobforvisitor = JSModel::getJSModel('common')->islistjobforvisitor();
        if ($islistjobforvisitor == 1) { 
            $listjobconfig['lj_category'] = $listjobconfig['visitor_lj_category'];
            $listjobconfig['lj_jobtype'] = $listjobconfig['visitor_lj_jobtype'];
            $listjobconfig['lj_jobstatus'] = $listjobconfig['visitor_lj_jobstatus'];
            $listjobconfig['lj_company'] = $listjobconfig['visitor_lj_company'];
            $listjobconfig['lj_companysite'] = $listjobconfig['visitor_lj_companysite'];
            $listjobconfig['lj_country'] = $listjobconfig['visitor_lj_country'];
            $listjobconfig['lj_city'] = $listjobconfig['visitor_lj_city'];
            $listjobconfig['lj_salary'] = $listjobconfig['visitor_lj_salary'];
            $listjobconfig['lj_created'] = $listjobconfig['visitor_lj_created'];
            $listjobconfig['lj_noofjobs'] = $listjobconfig['visitor_lj_noofjobs'];
            $listjobconfig['lj_description'] = $listjobconfig['visitor_lj_description'];
        }

        $cf_model = $this->getJSModel('customfields');
        function getjobfieldtitle($field  , $cf_model ){
            return JText::_($cf_model->getFieldTitleByFieldAndFieldfor($field , 2));
        }

    ?>


        <div id="jsjobs-main-wrapper">
            <span class="jsjobs-main-page-title">
                <?php echo JText::_('Job Information'); ?>
            </span>
            <div class="jsjobs-job-info">
                    <span class="jsjobs-title">
                        <?php
                        if (isset($this->job)){
                            echo $this->job->title;
                        }
                        $days = $this->config['newdays'];
                        $isnew = date("Y-m-d H:i:s", strtotime("-$days days"));
                        if (isset($this->job)) {
                            if ($this->job->created > $isnew){?>
                                <span class="jsjobs-new-tag"><?php echo JText::_('New');?></span>
                            <?php
                            }
                        } ?>
                    </span> 
                <div class="jsjobs-data-jobs-wrapper">
                    <?php if($listjobconfig['lj_company'] == 1){ ?>
                        <?php if (isset($this->fieldsorderingcompany['name']) && $this->fieldsorderingcompany['name'] == 1 && $this->config['comp_name'] == 1) { ?>
                            <span class="js_job_data_value">
                                <span class="jsjobs-company-name">
                                    <?php
                                    if (isset($_GET['cat']))
                                        $jobcat = $_GET['cat'];
                                    else
                                        $jobcat = null;
                                    (isset($navcompany) && $navcompany == 41) ? $navlink = "&nav=41" : $navlink = "";
                                    $companyaliasid = JSModel::getJSModel('common')->removeSpecialCharacter($this->job->companyaliasid);
                                    $link = 'index.php?option=com_jsjobs&c=company&view=company&layout=view_company' . $navlink . '&cd=' . $companyaliasid . '&cat=' . $this->job->jobcategory . '&Itemid=' . $this->Itemid;
                                    ?>
                                    <a class="js_job_company_anchor" href="<?php echo $link; ?>">
                                        <?php echo $this->job->companyname; ?>
                                    </a>
                                </span>
                            </span>
                        <?php } ?>
                    <?php } ?>


                    
                    <?php if (isset($this->fieldsordering['city']) && $this->fieldsordering['city'] == '1' && $this->listjobconfig['lj_city'] == 1) { ?>
                        <span class="jsjobs-location-wrap">
                            <span class="js_controlpanel_section_title">
                                <img src="<?php echo JURI::root();?>components/com_jsjobs/images/location.png">
                            </span>
                            <?php if ($this->job->multicity != ''){
                                echo $this->job->multicity;
                            }  ?>
                        </span>
                    <?php } ?>

                    <?php if($this->listjobconfig['lj_created'] == 1){ ?>
                        <span class="jsjobs_daysago"> <?php
                            $startTimeStamp = strtotime($this->job->created);
                            $endTimeStamp = strtotime("now");
                            $timeDiff = abs($endTimeStamp - $startTimeStamp);
                            $numberDays = $timeDiff / 86400;  // 86400 seconds in one day
                            // and you might want to convert to integer
                            $numberDays = intval($numberDays);
                            if ($numberDays != 0 && $numberDays == 1) {
                               $day_text = JText::_('Day');
                            } elseif ($numberDays > 1) {
                               $day_text = JText::_('Days');
                            } elseif ($numberDays == 0) {
                               $day_text = JText::_('Today');
                            }
                            if ($numberDays == 0) {
                               $hourago = $day_text;
                            } else {
                              $hourago = $numberDays.' '.$day_text.' '.JText::_('Ago');
                            } 
                            echo $hourago;
                            ?>
                        </span> <?php
                    } ?>
                </div>
            </div>
            <div class="jsjobs-job-data">
                <div class="jsjobs-menubar-wrap">
                    <ul>
                        <li><a href="#jsjobs-overview"><?php echo JText::_("Overview"); ?></a></li>
                        <li><a href="#jsjobs-requirements"><?php echo JText::_("Requirements"); ?></a></li>
                        <li><a href="#jsjobs-jobsstatus"><?php echo JText::_("Job Status"); ?></a></li>
                        <li><a href="#jsjobs-location"><?php echo JText::_("Location");?></a></li>
                    </ul> 
                </div>
                <div class="jsjobs-job-information-data">
                    <div class="jsjobs-left-area">
                        <div id="jsjobs-overview">
                        <span class="js_controlpanel_section_title"><?php echo JText::_('Overview'); ?></span>
                        <div class="jsjobs-jobs-overview-area">
                            <?php if (isset($this->fieldsordering['jobtype']) && $this->fieldsordering['jobtype'] == 1 && $this->listjobconfig['lj_jobtype'] == 1) { ?>
                                <div class="js_job_data_wrapper">
                                <span class="js_job_data_title"><?php echo getjobfieldtitle('jobtype' , $cf_model); ?>:</span>
                                <span class="js_job_data_value"><?php echo JText::_($this->job->jobtypetitle); ?></span>
                                </div>
                            <?php } ?>
                        <?php if (isset($this->fieldsordering['duration']) && $this->fieldsordering['duration'] == 1) { ?>
                        <div class="js_job_data_wrapper">
                            <span class="js_job_data_title"><?php echo getjobfieldtitle('duration' , $cf_model); ?>:</span>
                            <span class="js_job_data_value"><?php echo JText::_($this->job->duration); ?></span>
                        </div>
                    <?php } ?>
                    <?php if (isset($this->fieldsordering['jobsalaryrange']) && $this->fieldsordering['jobsalaryrange'] == 1 && $this->listjobconfig['lj_salary'] == 1) { ?>
                        <?php if ($this->job->hidesalaryrange != 1) { // show salary ?>
                            <div class="js_job_data_wrapper">
                                <span class="js_job_data_title"><?php echo getjobfieldtitle('jobsalaryrange' , $cf_model); ?>:</span>
                                <span class="js_job_data_value">
                                    <?php
                                    $salary = $this->getJSModel('common')->getSalaryRangeView($this->job->symbol,$this->job->salaryfrom,$this->job->salaryto,$this->job->salarytype,$this->config['currency_align']);
                                    echo $salary;
                                    ?>
                                </span>
                            </div>
                        <?php } ?>
                    <?php } ?>
                    <?php if (isset($this->fieldsordering['department']) && $this->fieldsordering['department'] == 1) { ?>
                    <div class="js_job_data_wrapper">
                        <span class="js_job_data_title"><?php echo getjobfieldtitle('department' , $cf_model); ?>:</span>
                        <span class="js_job_data_value"><?php echo $this->job->departmentname; ?></span>
                    </div>
                <?php } ?>
                <?php if (isset($this->fieldsordering['jobcategory']) && $this->fieldsordering['jobcategory'] == 1 && $this->listjobconfig['lj_category'] == 1) { ?>
                <div class="js_job_data_wrapper">
                    <span class="js_job_data_title"><?php echo getjobfieldtitle('jobcategory' , $cf_model); ?>:</span>
                    <span class="js_job_data_value"><?php echo JText::_($this->job->cat_title); ?></span>
                </div>
                <?php } ?>
                <?php if (isset($this->fieldsordering['jobshift']) && $this->fieldsordering['jobshift'] == 1) { ?>
                <div class="js_job_data_wrapper">
                    <span class="js_job_data_title"><?php echo getjobfieldtitle('jobshift' , $cf_model); ?>:</span>
                    <span class="js_job_data_value"><?php echo JText::_($this->job->shifttitle); ?></span>
                </div>
                <?php } ?>
                <?php if($this->listjobconfig['lj_created'] == 1){ ?>
                    <div class="js_job_data_wrapper">
                        <span class="js_job_data_title"><?php echo JText::_('Posted'); ?>:</span>
                        <span class="js_job_data_value"><?php echo JHtml::_('date', $this->job->created, $this->config['date_format']); ?></span>
                    </div>
                <?php } ?>
                <?php if (isset($this->fieldsordering['zipcode']) && $this->fieldsordering['zipcode'] == 1) { ?>
                <div class="js_job_data_wrapper">
                    <span class="js_job_data_title"><?php echo getjobfieldtitle('zipcode' , $cf_model); ?>:</span>
                    <span class="js_job_data_value"><?php echo $this->job->zipcode; ?></span>
                </div>
                <?php } ?>
            <?php
            if ($this->isjobsharing != "") {
                if (is_array($this->userfields)) {
                    for ($k = 0; $k < 15; $k++) {
                        $field_title = 'fieldtitle_' . $k;
                        $field_value = 'fieldvalue_' . $k;
                        if(!empty($this->userfields[$field_title]) && !empty($this->userfields[$field_value])){
                            echo '<div class="js_job_data_wrapper">
                                    <span class="js_job_data_title">' . $this->userfields[$field_title] . '</span>
                                    <span class="js_job_data_value">' . $this->userfields[$field_value] . '</span>
                                </div>';
                        }
                    }
                }
            } else {                                               
                $customfields = getCustomFieldClass()->userFieldsData( 2 );
                foreach ($customfields as $field) {
                    echo  getCustomFieldClass()->showCustomFields($field, 2 ,$this->job , 1);
                }
            }
            ?>                  
                 </div>
                 </div>

                 <div id="jsjobs-requirements">
                    <span class="jsjobs-controlpanel-section-title"><?php echo JText::_("Requirements"); ?></span>
                <div class="jsjobs-jobs-overview-area">
                        <?php if ($section_array['requirement'] == 1) { ?>
                
                <?php
                if ($this->job->iseducationminimax == 1) {
                    if ($this->job->educationminimax == 1)
                        $title = JText::_('Minimum Education');
                    else
                        $title = JText::_('Maximum Education');
                    $educationtitle = JText::_($this->job->educationtitle);
                }else {
                    $title = getjobfieldtitle('heighesteducation' , $cf_model);
                    $educationtitle = JText::_($this->job->mineducationtitle) . ' - ' . JText::_($this->job->maxeducationtitle);
                }
                ?>
                <?php if (isset($this->fieldsordering['heighesteducation']) && $this->fieldsordering['heighesteducation'] == 1) { ?>
                    <div class="js_job_data_wrapper">
                        <span class="js_job_data_title"><?php echo JText::_($title);?>:</span>
                        <span class="js_job_data_value"><?php echo JText::_($educationtitle); ?></span>
                    </div>
                     <div class="js_job_data_wrapper">
                        <span class="js_job_data_title"><?php echo JText::_('Degree Title'); ?>:</span>
                        <span class="js_job_data_value"><?php echo JText::_($this->job->degreetitle); ?></span>
                    </div>
                     <?php } ?>
                <?php
                if ($this->job->isexperienceminimax == 1) {
                    if ($this->job->experienceminimax == 1)
                        $title = JText::_('Minimum Experience');
                    else
                        $title = JText::_('Maximum Experience');
                    $experiencetitle = $this->job->experiencetitle;
                }else {
                    $title = getjobfieldtitle('experience' , $cf_model);
                    $experiencetitle = $this->job->minexperiencetitle . ' - ' . $this->job->maxexperiencetitle;
                }
                if ($this->job->experiencetext)
                    $experiencetitle .= ' (' . $this->job->experiencetext . ')';
                ?>
                <?php if (isset($this->fieldsordering['experience']) && $this->fieldsordering['experience'] == 1) { ?>
                    <div class="js_job_data_wrapper">
                        <span class="js_job_data_title"><?php echo $title; ?>:</span>
                        <span class="js_job_data_value"><?php echo JText::_($experiencetitle); ?></span>
                    </div>
                <?php } ?>
                <?php if(isset($this->fieldsordering['age']) && $this->fieldsordering['age'] == 1){ ?>
                    <div class="js_job_data_wrapper">
                        <span class="js_job_data_title"><?php echo getjobfieldtitle('age' , $cf_model); ?>:</span>
                        <span class="js_job_data_value"><?php echo JText::_($this->job->agefromtitle). ' - '.JText::_($this->job->agetotitle); ?></span>
                    </div>
                <?php } ?>
                <?php if (isset($this->fieldsordering['workpermit']) && $this->fieldsordering['workpermit'] == 1) { ?>
                    <div class="js_job_data_wrapper">
                        <span class="js_job_data_title"><?php echo getjobfieldtitle('workpermit' , $cf_model); ?>:</span>
                        <span class="js_job_data_value"><?php echo $this->job->workpermitcountry; ?></span>
                    </div>
                <?php } ?>
                <?php
                if (isset($this->fieldsordering['requiredtravel']) && $this->fieldsordering['requiredtravel'] == 1) {
                    switch ($this->job->requiredtravel) {
                        case 1: $requiredtraveltitle = JText::_('Not Required');
                            break;
                        case 2: $requiredtraveltitle = "25%";
                            break;
                        case 3: $requiredtraveltitle = "50%";
                            break;
                        case 4: $requiredtraveltitle = "75%";
                            break;
                        case 5: $requiredtraveltitle = "100%";
                            break;
                        default: $requiredtraveltitle = '';
                            break;
                    }
                    ?>
                    <div class="js_job_data_wrapper">
                        <span class="js_job_data_title"><?php echo getjobfieldtitle('requiredtravel' , $cf_model); ?>:</span>
                        <span class="js_job_data_value"><?php echo JText::_($requiredtraveltitle); ?></span>
                    </div>
                <?php } ?>
            <?php } ?>
                </div>
                </div>

                <div id="jsjobs-jobsstatus">
                    <span class="jsjobs-controlpanel-section-title"><?php echo JText::_("Job Status");?></span>
                <div class="jsjobs-jobs-overview-area">
                     <?php if (isset($this->fieldsordering['jobstatus']) && $this->fieldsordering['jobstatus'] == 1 && $this->listjobconfig['lj_jobstatus'] == 1) { ?>
                     <div class="js_job_data_wrapper">
                     <span class="js_job_data_title"><?php echo getjobfieldtitle('jobstatus' , $cf_model); ?>:</span>
                     <span class="js_job_data_value"><?php echo JText::_($this->job->jobstatustitle); ?></span>
                     </div>
                     <?php } ?>
                     <div class="js_job_data_wrapper">
                     <span class="js_job_data_title"><?php echo getjobfieldtitle('startpublishing' , $cf_model); ?>:</span>
                     <span class="js_job_data_value"><?php echo JHtml::_('date', $this->job->startpublishing, $this->config['date_format']); ?></span>
                     </div>
                     <?php if (isset($this->fieldsordering['noofjobs']) && $this->fieldsordering['noofjobs'] == 1 && $this->listjobconfig['lj_noofjobs'] == 1) { ?>
                         <div class="js_job_data_wrapper">
                             <span class="js_job_data_title"><?php echo getjobfieldtitle('noofjobs' , $cf_model); ?>:</span>
                             <span class="js_job_data_value"><?php echo JText::_($this->job->noofjobs); ?></span>
                         </div>
                    <?php } ?>
                    <div class="js_job_data_wrapper">
                        <span class="js_job_data_title"><?php echo getjobfieldtitle('stoppublishing' , $cf_model); ?>:</span>
                        <span class="js_job_data_value"><?php echo JHtml::_('date', $this->job->stoppublishing, $this->config['date_format']); ?></span>
                    </div>
                 </div>
                 </div>
            </div>


            <div class="jsjobs-right-raea">
                <div class="js_job_company_data">
                   <?php if($this->fieldsordering['company'] == 1 && $this->listjobconfig['lj_company'] == 1){ ?>
                        <?php if (isset($this->fieldsorderingcompany['logo']) && $this->fieldsorderingcompany['logo'] == 1) { 
                            
                            (isset($navcompany) && $navcompany == 41) ? $navlink = "&nav=41" : $navlink = "";
                            $companyaliasid = JSModel::getJSModel('common')->removeSpecialCharacter($this->job->companyaliasid);
                            $link = 'index.php?option=com_jsjobs&c=company&view=company&layout=view_company' . $navlink . '&cd=' . $companyaliasid . '&cat=' . $this->job->jobcategory . '&Itemid=' . $this->Itemid;
                            ?>
                            <div class="js_job_company_logo">
                                <div class="jsjobs-company-logo-wrap">
                                <?php
                                if (!empty($this->job->companylogo)) {
                                    if ($this->isjobsharing) {
                                        $logourl = $this->job->companylogo;
                                    } else {
                                        $logourl = JURI::root().$this->config['data_directory'] . '/data/employer/comp_' . $this->job->companyid . '/logo/' . $this->job->companylogo;
                                    }
                                } else {
                                    $logourl = JURI::root().'components/com_jsjobs/images/blank_logo.png';
                                }
                                ?>
                                <a href="<?php echo $link;?>"> <img class="js_jobs_company_logo" src="<?php echo $logourl; ?>" /></a>
                                </div>
                            </div>
                        <?php } ?>
                    <?php if (isset($this->fieldsorderingcompany['name']) && $this->fieldsorderingcompany['name'] == 1 && $this->config['comp_name'] == 1) { ?>
                            <span class="js_job_data_value">
                                <?php
                                if (isset($_GET['cat']))
                                    $jobcat = $_GET['cat'];
                                else
                                    $jobcat = null;
                                (isset($navcompany) && $navcompany == 41) ? $navlink = "&nav=41" : $navlink = "";
                                $companyaliasid = JSModel::getJSModel('common')->removeSpecialCharacter($this->job->companyaliasid);
                                $link = 'index.php?option=com_jsjobs&c=company&view=company&layout=view_company' . $navlink . '&cd=' . $companyaliasid . '&cat=' . $this->job->jobcategory . '&Itemid=' . $this->Itemid;
                                ?>
                                <a class="js_jobs_company_anchor" href="<?php echo $link; ?>">
                                    <?php echo $this->job->companyname; ?>
                                </a>
                            </span>
                    <?php } ?>
                    <?php if (isset($this->fieldsorderingcompany['url']) && $this->fieldsorderingcompany['url'] == 1 && $this->config['comp_show_url'] == 1) { ?>
                        
                            <span class="js_jobs_data_value">
                                <a class="js_job_company_anchor" href="<?php echo $this->job->companywebsite; ?>">
                                    <?php echo $this->job->companywebsite; ?>
                                </a>
                            </span>
                        
                    <?php } ?>
                     <span class="jsjobs-location">
                       <?php if (isset($this->fieldsordering['city']) && $this->fieldsordering['city'] == '1' && $this->listjobconfig['lj_city'] == 1) { ?>
                           <img src="<?php echo JURI::root() . "components/com_jsjobs/images/location.png"; ?>"  />           
                           <?php if ($this->job->multicity != '') echo $this->job->multicity; ?>
                       <?php } ?>
                     </span> 
                    <?php if (isset($this->fieldsorderingcompany['contactname']) && $this->fieldsorderingcompany['contactname'] == 1) { ?>
                        <div class="js_job_data_wrapper">
                            <span class="js_job_data_title"><?php //echo JText::_('Contact Name'); ?></span>
                            <span class="js_job_data_value"><?php //echo $this->job->companycontactname; ?></span>
                        </div>
                    <?php } ?>
                    <?php if (isset($this->fieldsorderingcompany['contactemail']) && $this->fieldsorderingcompany['contactemail'] == 1 && $this->config['comp_email_address'] == 1) { ?>
                        <div class="js_job_data_wrapper">
                            <span class="js_job_data_title"><?php //echo JText::_('Contact Email'); ?></span>
                            <span class="js_job_data_value"><?php //echo $this->job->companycontactemail; ?></span>
                        </div>
                    <?php } ?>
                    <?php if (isset($this->fieldsorderingcompany['since']) && $this->fieldsorderingcompany['since'] == 1) { ?>
                        <div class="js_job_data_wrapper">
                            <span class="js_job_data_title"><?php //echo JText::_('Since'); ?></span>
                            <span class="js_job_data_value"><?php //echo JHtml::_('date', $this->job->companysince, $this->config['date_format']); ?></span>
                        </div>
                    <?php  } ?>
                    <?php  if (isset($this->fieldsordering['subcategory']) && $this->fieldsordering['subcategory'] == 1) { ?>
                <div class="js_job_data_wrapper">
                    <span class="js_job_data_title"><?php // echo JText::_('Sub Category'); ?></span>
                    <span class="js_job_data_value"><?php // echo JText::_($this->job->subcategory); ?></span>
                </div>
            <?php   } ?>
            <?php  } ?>
           
                </div>
               </div>
            <div id="jsjobs-location" class="jsjobs-map-wrap">
                <?php if (isset($this->fieldsordering['map']) && $this->fieldsordering['map'] == 1) { ?>
                    <span class="jsjobs_controlpanel_section_title"><?php echo JText::_('Location'); ?></span>
                        <span class="jsjobs-loction-wrap">      
                            <?php if ($this->fieldsordering['city'] == '1' && $this->listjobconfig['lj_city'] == 1) { ?>
                                <div class="">
                                    <?php if ($this->job->multicity != '') echo $this->job->multicity; ?>
                                </div>
                            <?php } ?>
                        </span>
                        <div class="js_job_full_width_data">
                            <div id="map"><div id="map_container"></div></div>
                            <input type="hidden" id="longitude" name="longitude" value="<?php if (isset($this->job)) echo $this->job->longitude; ?>"/>
                            <input type="hidden" id="latitude" name="latitude" value="<?php if (isset($this->job)) echo $this->job->latitude; ?>"/>
                        </div>
                <?php } ?>
            </div>

            <div class="jsjobs-jobmore-info">
                <?php if($this->listjobconfig['lj_description'] == 1){ ?>
                    <span class="js_controlpanel_title"><?php echo getjobfieldtitle('description' , $cf_model); ?></span>
                    <div class="jsjobs_full_width_data"><?php echo $this->job->description; ?></div>
                <?php } ?>
                <?php if (isset($this->fieldsordering['agreement']) && $this->fieldsordering['agreement'] == 1) { ?>
                    <span class="js_controlpanel_title"><?php echo getjobfieldtitle('agreement' , $cf_model); ?></span>
                    <div class="jsjobs_full_width_data"><?php echo $this->job->agreement; ?></div>
                <?php } ?>
                <?php if (isset($this->fieldsordering['qualifications']) && $this->fieldsordering['qualifications'] == 1) { ?>
                    <span class="js_controlpanel_title"><?php echo getjobfieldtitle('qualifications' , $cf_model); ?></span>
                    <div class="jsjobs_full_width_data"><?php echo $this->job->qualifications; ?></div>
                <?php } ?>
                 <?php if (isset($this->fieldsordering['prefferdskills']) && $this->fieldsordering['prefferdskills'] == 1) { ?>
                    <span class="js_controlpanel_title"><?php echo getjobfieldtitle('prefferdskills' , $cf_model); ?></span>
                    <div class="jsjobs_full_width_data"><?php echo $this->job->prefferdskills; ?></div>
                <?php } ?>
                <div class="js_job_apply_button">
                    <?php
                    if($this->config['showapplybutton'] == 1){
                        if($this->job->jobapplylink == 1 && !empty($this->job->joblink)){
                            if(!strstr('http',$this->job->joblink)){
                                $this->job->joblink = 'http://'.$this->job->joblink;
                            } ?>
                        <a class="js_job_button" href= "<?php echo $this->job->joblink ;?>" target="_blank" ><?php echo JText::_('Apply Now'); ?></a>
                        <?php }elseif(!empty($this->config['applybuttonredirecturl'])){ ?>
                              <a class="js_job_button" href= "<?php echo $this->config['applybuttonredirecturl']; ?>" target="_blank" ><?php echo JText::_('Apply Now'); ?></a>
                        <?php }else{ ?>
                        <a class="js_job_button" onclick="getApplyNowByJobid('<?php echo $this->job->id;?>');" href="#"><?php echo JText::_('Apply Now'); ?></a>
                        <?php }
                    }
  
          ?>

                </div>
            </div>
               </div>

            <?php if (isset($this->fieldsordering['video']) && $this->fieldsordering['video'] == 1) { ?>
                <?php if ($this->job->video) { ?>
                    <span class="js_controlpanel_section_title"><?php echo JText::_('Video'); ?></span>
                    <div class="js_job_full_width_data">
                        <iframe title="YouTube video player" width="480" height="390" 
                                src="http://www.youtube.com/embed/<?php echo $this->job->video; ?>" frameborder="0" allowfullscreen>
                        </iframe>
                    </div>
                <?php } ?>
            <?php } ?> 	
            </div>
        </div>
        <?php } else {
                $this->jsjobsmessages->getAccessDeniedMsg('Could not find any matching results', 'Could not find any matching results', 0);
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

<style type="text/css">
    div#map_container{ width:100%; height:350px; }
</style>
<?php $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://"; ?>
<script type="text/javascript" src="<?php echo $protocol; ?>maps.googleapis.com/maps/api/js?key=<?php echo $this->config['google_map_api_key']; ?>"></script>
<script type="text/javascript">
                var bounds = new google.maps.LatLngBounds();
                window.onload = loadMap();
                function loadMap() {
                    var latedit = [];
                    var longedit = [];

                    var longitude = jQuery('#longitude').val();
                    var latitude = jQuery('#latitude').val();
                    if (typeof (longitude) != "undefined" && typeof (latitude) != "undefined") {
                        latedit = latitude.split(",");
                        longedit = longitude.split(",");
                        if (latedit != '' && longedit != '') {
                            for (var i = 0; i < latedit.length; i++) {
                                var latlng = new google.maps.LatLng(latedit[i], longedit[i]);
                                var myOptions = {
                                    center: latlng,
                                    mapTypeId: google.maps.MapTypeId.ROADMAP
                                };
                                if (i == 0)
                                    var map = new google.maps.Map(document.getElementById("map_container"), myOptions);
                                var marker = new google.maps.Marker({
                                    position: latlng,
                                    map : map,
                                    visible: true,
                                });
                                
                                marker.setMap(map);
                                
                                bounds.extend(latlng);
                            }
                            map.fitBounds(bounds);
                            map.panToBounds(bounds);
                        }
                    }
                }
                window.onload = function () {

                    if (document.getElementById('jobseeker_fb_comments') != null) {
                        var myFrame = document.getElementById('jobseeker_fb_comments');
                        if (myFrame != null)
                            myFrame.src = 'http://www.facebook.com/plugins/comments.php?href=' + location.href;
                    }
                    if (document.getElementById('employer_fb_comments') != null) {
                        var myFrame = document.getElementById('employer_fb_comments');
                        if (myFrame != null)
                            myFrame.src = 'http://www.facebook.com/plugins/comments.php?href=' + location.href;
                    }
                }
</script>
<?php
$document = JFactory::getDocument();
$document->addScript('components/com_jsjobs/js/canvas_script.js');
?>

<div id="js_jobs_main_popup_back"></div>
<div id="js_jobs_main_popup_area">
    <div id="js_jobs_main_popup_head">
        <div id="jspopup_title"><?php echo JText::_('Apply Now');?></div>
        <img id="jspopup_image_close" src="<?php echo JURI::root();?>components/com_jsjobs/images/popup-close.png" />
    </div>
    <div id="jspopup_work_area"></div>
</div>
<script type="text/javascript">
    jQuery(document).ready(function(){
        jQuery("img#jspopup_image_close,div#js_jobs_main_popup_back").click(function(){
            jQuery("div#js_jobs_main_popup_area").slideUp('slow');
            setTimeout(function () {
                jQuery("div#js_jobs_main_popup_back").hide();
                jQuery("div#jspopup_work_area").html('');
            }, 700);
        });
    });
</script>